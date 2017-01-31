<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
// error_reporting(E_ALL);
/**
 *@property magaModel $magaModel
 *@property AvisosNotaModel $AvisosNotaModel
 *@property UsuarioModel $UsuarioModel
 */
class Tasks extends MY_Controller {


	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
		   $this->load->model('AvisosNotaModel');
		   $this->load->model('UsuarioModel');
		   $this->layouts->add_includes('js', 'app/js/tasks/main.js');
       }
	public function index()
	{
//		$this->layouts->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js');
		//$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js');
//		$this->layouts->add_includes('js', 'assets/admin/layout/scripts/demo.js');
		//$this->layouts->add_includes('js', 'assets/admin/pages/scripts/ui-confirmations.js');
		$this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/tasks/index.js');
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$this->data['page']='Task Manager';
			$this->data['user_id'] = $this->session->userdata('userData')[0]->Id;
			$this->layouts->view('TasksView', $this->data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function tasks(){
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$tag_name = $this->input->get('tag_name', true);
		$details = $this->AvisosNotaModel->getAvisosNotas($usuario, $tag_name);
		//vardump($details);exit;
			/*$tasks=array();
			foreach ($details as $detail) {
				$newTasks=$detail;
				$details = $this->UsuarioModel->getProfileFoto($newTasks->USUARIO);
				$newTasks->foto = base64_encode($details[0]->foto);
				$comments=$this->magaModel->selectComments('comentarios_de_tareas',array('tareasId'=>$detail->id));
				foreach ($comments as $comment) {
					$details = $this->UsuarioModel->getProfileFoto($comment->USUARIO);
					$comment->foto = base64_encode($details[0]->foto);
				}
				$newTasks->comments=$comments;
				$tasks[]=$newTasks;
			}
			print_r(json_encode($tasks,true));*/
		echo json_encode($details);
		exit;
	}

	public function getComments(){
		$comments = array();
		if($this->input->post()){
			$task_id = $this->input->post('task_id', true);
			if($task_id){
				$comments = $this->magaModel->selectComments('comentarios_de_tareas',array('tareasId' => $task_id));
			}
		}
		echo json_encode(array('comments' => $comments));
		exit;
	}
	public function specific_task(){
		
	}
	public function addTask(){
		$task_title = $this->input->get('task_title');
		$task_desc = $this->input->get('task_desc');
		$task_end = date('Y-m-d',strtotime($this->input->get('task_end')));
		$task_tags = $this->input->get('task_tags');
		$task_public = $this->input->get('task_public');
		$task_start = date('Y-m-d');
		$userData=$this->session->userdata('userData');
		$usuarioId=$userData[0]->Id;
		//vardump($task_end);vardump($this->input->get('task_end'));exit;
		$taskAdded = $this->magaModel->insert('avisos_notas',array('titulo'=>$task_title,'inicio'=>$task_start,'fin'=>$task_end,'mensaje'=>$task_desc,'publico'=>$task_public,'idusuario'=>$usuarioId,'etiqueta'=>$task_tags));
		$data = array();
		if($taskAdded){
			$data['status']=true;
			if($task_public == '0') {
				$user_data = $userData[0];
				if(!empty($user_data)) {
					$this->sendEmailPart($user_data, $task_start, $task_end);
				}
			}elseif($task_public == '1'){
				$users = $this->UsuarioModel->get_active_users_for_select();
				if(!empty($users)){
					foreach($users as $user_data){
						if(!empty($user_data)) {
							$user_data->Nombre = $user_data->user_name;
							$this->sendEmailPart($user_data, $task_start, $task_end);
						}
					}
				}
			}

		}
		else
		{
			$data['status']=false;	
		}
		print_r(json_encode($data,true));
	}
	private function sendEmailPart($user_data, $task_start, $task_end){
		$result = null;
		$replace_data = array(
			'FIRSTNAME' => $user_data->Nombre,
			'SURNAME' => $user_data->Nombre,
			'FULLNAME' => $user_data->Nombre,
			'PHONE1' => $user_data->Telefono,
			'MOBILE' => $user_data->Telefono,
			'EMAIL1' => $user_data->email,
			//'COURSE_NAME' => $course_data->course_name,
			'START_DATE' => $task_start,
			'END_DATE' => $task_end,
		);

		$this->load->model('ErpEmailsAutomatedModel');
		$template = $this->ErpEmailsAutomatedModel->getByTemplateId('19', array('notify_student' => 1));
		if (!empty($template) && !empty($user_data->email)) {
			$email_subject = replaceTemplateBody($template->Subject, $replace_data);
			$email_body = replaceTemplateBody($template->Body, $replace_data);
			$result = $this->send_automated_email($user_data->email, $email_subject, $email_body, $template->from_email);
		}
		return $result;
	}

	private function send_automated_email($email, $subject, $body, $from_email){
		$this->load->model('ErpEmailModel');
		$user_id = $this->session->userdata('userData')[0]->Id;

		$emails_limit_daily = $this->_db_details->emails_limit_daily;
		$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
		$count_emails_day = $this->ErpEmailModel->getEmailsCountDay();

		if ($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly) {
			$amazon = $this->config->item('amazon');
			$email_from = $this->config->item('email');

			$client = SesClient::factory(array(
				'version' => 'latest',
				'region' => $amazon['email_region'],
				'credentials' => array(
					'key' => $amazon['AWSAccessKeyId'],
					'secret' => $amazon['AWSSecretKey'],
				),
			));

			$request = array();
			$request['Source'] = $from_email.' <'.$email_from['from'].'>';
			$request['Destination']['ToAddresses'] = array($email);
			$request['Message']['Subject']['Data'] = $subject;
			$request['Message']['Subject']['Charset'] = "UTF-8";
			$request['Message']['Body']['Html']['Data'] = $body;
			$request['Message']['Body']['Charset'] = "UTF-8";
			$data_recipient = array(
				'from_userid' => $user_id,
				'from_usertype' => '0',
				'id_campaign' => '',
				'email_recipie' => $email,
				'Subject' => $subject,
				'Body' => $body,
				'date' => date('Y-m-d H:i:s'),
			);
			try {
				$result = $client->sendEmail($request);
				$messageId = $result->get('MessageId');
				//echo("Email sent! Message ID: $messageId"."\n");
				if ($messageId) {
					$response['success'] = $this->lang->line('send_email_success');
					$response['errors'] = false;
					$data_recipient['sucess'] = '1';
					$data_recipient['error_msg'] = ''; //$e->getMessage(),
				} else {
					$response['errors'] = $this->lang->line('no_send_email');
				}

			} catch (Exception $e) {
				//echo("The email was not sent. Error message: ");
				//$response['errors'] = $e->getMessage()."\n";
				$response['errors'] = $this->lang->line('no_send_email');
				$data_recipient['sucess'] = '0';
				$data_recipient['error_msg'] = $e->getMessage();
			}
			$added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
		}else{
			$response['errors'] = $this->lang->line('emails_limit_daily_msg');
		}
		return $response;
	}

	public function etiqueta(){
		$details=$this->magaModel->selectAll('etiquetas_notas');
		print_r(json_encode($details,true));
	}
	public function addComment(){
		$comments = array();
		if ($this->input->post()) {
			$userData=$this->session->userdata('userData');
			$usuarioId=$userData[0]->Id;
			$taskId = $this->input->post('taskId');
			$commentText = $this->input->post('commentText');
			$commentId = $this->magaModel->insert('comentarios_de_tareas',array('tareasId'=>$taskId,'comentario_de_texto'=>$commentText,'idusuario'=>$usuarioId,'timestamp'=>Date('Y-m-d')));
			$comments=$this->magaModel->selectComments('comentarios_de_tareas',array('comentarios_de_tareas.id'=>$commentId));
			/*foreach ($comments as $comment) {
				$details = $this->UsuarioModel->getProfileFoto($comment->USUARIO);
				$comment->foto = base64_encode($details[0]->foto);
			}*/
			$task_data = $this->AvisosNotaModel->getTaksDataById($taskId);
			if($task_data->activo == '0') {
				$user_data = $userData[0];
				if(!empty($user_data)) {
					$this->sendEmailPart($user_data, Date('Y-m-d'), Date('Y-m-d'));
				}
			}elseif($task_data->activo == '1'){
				$users = $this->UsuarioModel->get_active_users_for_select();
				if(!empty($users)){
					foreach($users as $user_data){
						if(!empty($user_data)) {
							$user_data->Nombre = $user_data->user_name;
							$this->sendEmailPart($user_data, Date('Y-m-d'), Date('Y-m-d'));
						}
					}
				}
			}
		}
		print_r(json_encode($comments));
		exit;
	}
	public function addTag(){
		$tag = array();
		if ($this->input->post()) {

			$tagName = $this->input->post('tagName');
			$tagColor = $this->input->post('tagColor');
			$tagId = $this->magaModel->insert('etiquetas_notas',array('descripcion'=>$tagName,'color'=>hexdec($tagColor)));
			$tag=$this->magaModel->selectOne('etiquetas_notas',array('id'=>$tagId),'hex(color) as color,descripcion as tagName');
		}
		print_r(json_encode($tag));
		exit;
	}
	public function tags(){
		$tag=$this->magaModel->selectTags('etiquetas_notas');
		print_r(json_encode($tag));
	}
	public function undoneTasksCount()
	{
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->Id;
  		$details=$this->AvisosNotaModel->getUndoneTasksCount($USUARIO);
		print_r(json_encode($details));
	}
	public function deleteTask(){
		if ($this->input->post()) {
			$task_id = $this->input->post('task_id');
			$success = false;
			$user_id = $this->session->userdata('userData')[0]->Id;
			$result_1 = $this->AvisosNotaModel->deleteTasks($task_id, $user_id);
			if($result_1){
				$result_2 = $this->magaModel->delete('comentarios_de_tareas',array('tareasId'=>$task_id));
				$success = true;
			}
		}
		print_r(json_encode(array('success' => $success)));
		exit;
	}

	public function changeDate(){
		$success = false;
		$error_msg = '';
		if ($this->input->post()) {
			$task_id = $this->input->post('task_id', true);
			$new_date = $this->input->post('new_date', true);
			if($this->validateDate($new_date)){
				$user_id = $this->session->userdata('userData')[0]->Id;
				$update_data = array('fin' => date('Y-m-d H:i:s', strtotime($new_date)));
				$where = array('idusuario' => $user_id, 'id' => $task_id);
				$success = $this->AvisosNotaModel->updateItem($update_data, $where);
			}else{
				$error_msg = $this->lang->line('date_is_not_valid');
			}
		}
		print_r(json_encode(array('success' => $success, 'error_msg' => $error_msg)));
		exit;
	}

	public function changeTaskState(){
		$success = false;
		$error_msg = '';
		if ($this->input->post()) {
			$task_id = $this->input->post('task_id', true);
			$state = $this->input->post('state', true) == '1' ? 1 : 0;
			if($task_id){
				$user_id = $this->session->userdata('userData')[0]->Id;
				$update_data = array('activo' => $state);
				$where = array('idusuario' => $user_id, 'id' => $task_id);
				$success = $this->AvisosNotaModel->updateItem($update_data, $where);
			}
		}
		print_r(json_encode(array('success' => $success, 'error_msg' => $error_msg)));
		exit;
	}

	public function changeTaskPublic(){
		$success = false;
		$error_msg = '';
		if ($this->input->post()) {
			$task_id = $this->input->post('task_id', true);
			$is_public = $this->input->post('is_public', true) == '1' ? 1 : 0;
			if($task_id){
				$user_id = $this->session->userdata('userData')[0]->Id;
				$update_data = array('publico' => $is_public);
				$where = array('idusuario' => $user_id, 'id' => $task_id);
				$success = $this->AvisosNotaModel->updateItem($update_data, $where);
			}
		}
		print_r(json_encode(array('success' => $success, 'error_msg' => $error_msg)));
		exit;
	}

	private function validateDate($date){
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') == $date;
	}
}

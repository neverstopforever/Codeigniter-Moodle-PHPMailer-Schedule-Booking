<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
class Messaging extends MY_Controller {

	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
		    $this->load->model('UserMessageModel');
		    $this->load->model('MensajeModel');
		    $this->layouts->add_includes('js', 'app/js/messaging/main.js');
    }
	public function index()
	{
        $this->lang->load('quicktips', $this->data['lang']);
        $this->data['referer_is_profile'] = false;
		if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
			$ex_referer = explode('/', $_SERVER['HTTP_REFERER']);
			$this->data['referer_is_profile'] = !empty($ex_referer) && isset($ex_referer[4]) && $ex_referer[4] == 'profile' ?  true : false;
		}

		$this->data['referer_is_dashboard'] = false;
		if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
			$ex_referer = explode('/', $_SERVER['HTTP_REFERER']);
			$this->data['referer_is_dashboard'] = !empty($ex_referer) && isset($ex_referer[3]) && $ex_referer[3] == 'dashboard' ?  true : false;
		}

		$this->layouts
		->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
		->add_includes('css', 'assets/global/plugins/typeahead/custom.css')
		->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
		->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
		->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
		->add_includes('css', 'assets/global/plugins/select2/select2.css')
		->add_includes('js', 'assets/global/plugins/select2/select2.js');

		$this->layouts->add_includes('js', 'app/js/messaging/index.js');
		$this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css');
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$this->data['page']='Messaging';
			$this->layouts->view('MessagingView',$this->data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function inbox()
	{
		$userData = $this->session->userdata('userData');
		$user_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
		//$details = $this->UserMessageModel->getInbox($USUARIO);
		$details = $this->MensajeModel->getUserInbox($user_id);
		print_r(json_encode($details));
	}
	public function sent()
	{
		$userData=$this->session->userdata('userData');
		$USUARIO = $userData[0]->Id;
		//$details = $this->UserMessageModel->getSent($USUARIO);
		$details = $this->MensajeModel->getUserOutbox($USUARIO);
		print_r(json_encode($details));
	}
	public function add(){
		$result = false;
		if ($this->input->post()) {
			$userData = $this->session->userdata('userData');
			$fromId = $userData[0]->Id;
			$toId = $this->input->post('to', true);
			$toGroupId = $this->input->post('to_group_id', true);
			$subject = $this->input->post('subject', true);
			$message = $this->input->post('message', true);
			$toType = $this->input->post('to_type', true);

			if($toType == '3' && !empty($toId) && !empty($toGroupId)){
				$group_ids_array = explode(',', $toGroupId);
				if($toId == 'all'){
					$courses_ids = array();
				}else{
					$courses_ids = explode(',', $toId);
				}
				//$ids_string = '';
				//foreach($ids_array as $id){
				//	$ids_string .= "'". $id ."',";
				//}
				//$ids_string = !empty($ids_string) ? trim($ids_string, ',') : null;
				if(!empty($group_ids_array)){
					$this->load->model('AlumnoModel');
					$user_data = $this->AlumnoModel->getStudentByGroupIdsForLms($group_ids_array, $courses_ids);
					if(!empty($user_data)) {
						$insert_data = array();
						foreach ($user_data as $student) {
							$insert_data[] = array(
									'FromId' => $fromId,
									'FromType' => '0',
									'ToType' => '2',
									'ToId' => $student->id,
									'Subject' => $subject,
									'Maildate' => date("Y-m-d H:i:s"),
									'Body' => $message,
									'Read' => '0'
								);
							$this->sendMessageToGroup($student);
						}
						if(!empty($insert_data)){
							$result = $this->MensajeModel->insertMsgBatch($insert_data);
						}
					}
				}
				echo json_encode(array('success' => $result));
				exit;
			}
			$insert_data = array(
				'FromId' => $fromId,
				'FromType' => '0',
				'ToType' => $toType,
				'ToId' => $toId,
				'Subject' => $subject,
				'Maildate' => date("Y-m-d H:i:s"),
				'Body' => $message,
				'Read' => '0');
			$detail = $this->MensajeModel->insertUsersMessage($insert_data);
			if($detail){
				$this->load->model('ErpEmailsAutomatedModel');
				$user_data = array();
				if($toType == '0'){
					$this->load->model('UsuarioModel');
					$user_data = $this->UsuarioModel->getUserDataById($toId);
				}elseif($toType == '1'){
					$this->load->model('ProfesorModel');
					$user_data = $this->ProfesorModel->getTeacherById($toId);
				}elseif($toType == '2'){
					$this->load->model('AlumnoModel');
					$user_data = $this->AlumnoModel->getStudentById($toId);
				}
				if(!empty($user_data)) {
					$replace_data = array(
						'FIRSTNAME' => isset($user_data->first_name_1) ? $user_data->first_name_1 : $user_data->full_name,
						'SURNAME' => isset($user_data->sur_name) ? $user_data->sur_name : $user_data->full_name,
						'FULLNAME' => $user_data->full_name,
						'PHONE1' => isset($user_data->phone1) ? $user_data->phone1 : '',
						'MOBILE' => isset($user_data->mobile) ? $user_data->mobile : '',
						'EMAIL1' => $user_data->email1,
						//'COURSE_NAME' => ,
						'START_DATE' => date('F j') . ' at  ' . date('G:i A'),
						'END_DATE' => date('F j') . ' at  ' . date('G:i A'),
					);
				}

				$template = $this->ErpEmailsAutomatedModel->getByTemplateId('16', array('notify_student' => 1));
				if (!empty($template)) {
					$email_subject = replaceTemplateBody($template->Subject, $replace_data);
					$email_body = replaceTemplateBody($template->Body, $replace_data);
					if(isset($user_data->email1)){
						$this->send_automated_email($user_data->email1, $email_subject, $email_body, $template->from_email);
					}
					if(isset($user_data->tutor1_email1)){
						$this->send_automated_email($user_data->tutor1_email1, $email_subject, $email_body, $template->from_email);
					}
					if(isset($user_data->tutor2_email1)){
						$this->send_automated_email($user_data->tutor2_email1, $email_subject, $email_body, $template->from_email);
					}
				}
				$result = true;
			}
		}
		echo json_encode(array('success' => $result));
		exit;
	}

	private function sendMessageToGroup($student_data){
		$replace_data = array(
			//'FIRSTNAME' => isset($student_data->first_name_1) ? $student_data->first_name_1 : $student_data->full_name,
			//'SURNAME' => isset($student_data->sur_name) ? $student_data->sur_name : $student_data->full_name,
			'FULLNAME' => $student_data->name,
			//'PHONE1' => isset($student_data->phone1) ? $student_data->phone1 : '',
			//'MOBILE' => isset($student_data->mobile) ? $student_data->mobile : '',
			'EMAIL1' => $student_data->email,
			//'COURSE_NAME' => ,
			'START_DATE' => date('F j') . ' at  ' . date('G:i A'),
			'END_DATE' => date('F j') . ' at  ' . date('G:i A'),
		);
		$this->load->model('ErpEmailsAutomatedModel');
		$template = $this->ErpEmailsAutomatedModel->getByTemplateId('16', array('notify_student' => 1));
		if (!empty($template)) {
			$email_subject = replaceTemplateBody($template->Subject, $replace_data);
			$email_body = replaceTemplateBody($template->Body, $replace_data);
			if(isset($student_data->email)){
				$this->send_automated_email($student_data->email, $email_subject, $email_body, $template->from_email);
			}
		}
	}

	private function send_automated_email($email, $subject, $body, $from_email){
		$this->load->model('ErpEmailModel');
		$this->load->model('UsuarioModel');
		$user_id = $this->session->userdata('userData')[0]->Id;
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
		$data_recipient = array(
			'from_userid' => $user_id,
			'from_usertype' => '0',
			'id_campaign' => '',
			'email_recipie' => $email,
			'Subject' => $subject,
			'Body' => $body,
			'date' => date('Y-m-d H:i:s'),
		);
		if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
			if($smtp_data->auth_method == 0){
				$smtpSecure = 'ssl';
			}elseif($smtp_data->auth_method == 1){
				$smtpSecure = 'ssl';
			}elseif($smtp_data->auth_method == 2){
				$smtpSecure = 'tls';
			}

			$mail = new PHPMailer();

			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->Host = $smtp_data->hostname;  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Port =  $smtp_data->port;
			$mail->SMTPSecure =  $smtpSecure;
			$mail->Username = $smtp_data->user;  // SMTP username
			$mail->Password = $smtp_data->pwd; // SMTP password

			$mail->From =  $smtp_data->user;
			$mail->FromName = '';
			$mail->AddAddress($email);
			$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
			$mail->IsHTML(true);
			// set email format to HTML

			$mail->Subject = $subject;
			$mail->Body    = $body;

			$mail->AltBody = "";
			if(!$mail->Send()) {
				$response['errors'] = $this->lang->line('enrollments_no_send_email');
			}else {
				$response['success'] = $this->lang->line('enrollments_send_email_success');
				$response['errors'] = false;
				$data_recipient['sucess'] = '1';
				$data_recipient['error_msg'] = ''; ;
			}
			$this->ErpEmailModel->insertEmailData($data_recipient);
		}
		else {
			$emails_limit_daily = $this->_db_details->emails_limit_daily;
			$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
			$count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);

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
				$request['Source'] = $from_email . ' <' . $email_from['from'] . '>';
				$request['Destination']['ToAddresses'] = array($email);
				$request['Message']['Subject']['Data'] = $subject;
				$request['Message']['Subject']['Charset'] = "UTF-8";
				$request['Message']['Body']['Html']['Data'] = $body;
				$request['Message']['Body']['Charset'] = "UTF-8";
				try {
					$result = $client->sendEmail($request);
					$messageId = $result->get('MessageId');
					//echo("Email sent! Message ID: $messageId"."\n");
					if ($messageId) {
						$response['success'] = $this->lang->line('enrollments_send_email_success');
						$response['errors'] = false;
						$data_recipient['sucess'] = '1';
						$data_recipient['error_msg'] = ''; //$e->getMessage(),
					} else {
						$response['errors'] = $this->lang->line('enrollments_no_send_email');
					}

				} catch (Exception $e) {
					//echo("The email was not sent. Error message: ");
					//$response['errors'] = $e->getMessage()."\n";
					$response['errors'] = $this->lang->line('enrollments_no_send_email');
					$data_recipient['sucess'] = '0';
					$data_recipient['error_msg'] = $e->getMessage();
				}
				$added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
			} else {
				$response['errors'] = $this->lang->line('emails_limit_daily_msg');
			}
		}
		return $response;
	}
	public function notificationCount(){
		$userData = $this->session->userdata('userData');
		//$USUARIO = $userData[0]->USUARIO;
		$message_count = array();
		if(isset($userData[0]->Id)){
			$this->load->model('MensajeModel');
			$message_count = $this->MensajeModel->getNewMessages($userData[0]->Id, '0');
		}
		print_r(json_encode($message_count));
	}
	public function messageslist(){
		$userData=$this->session->userdata('userData');
		$user_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
		//$USUARIO=$userData[0]->USUARIO;
		//$details = $this->UserMessageModel->getMessagesList($USUARIO);
		$details = $this->MensajeModel->getUserMessagesList($user_id);
		print_r(json_encode($details));
	}
	public function readUpdate(){
		$detail = array();
		if ($this->input->post()) {
			$userData=$this->session->userdata('userData');
			$user_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
			$messageId = $this->input->post('messageId', true);
			$read = $this->input->post('read', true);
			$read = $read == '1' ? '1' : '0';
			$toType = '0';
			$detail = $this->MensajeModel->updateRead($messageId, $user_id, $toType, $read);
		}
		print_r($detail);
		exit;
	}

	public function getAllUsers(){
		$this->load->model('ErpEmailModel');
		if($this->input->is_ajax_request()){
			$emails_limit_daily = $this->_db_details->emails_limit_daily;
			$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
			$count_emails_day = $this->ErpEmailModel->getEmailsCountDay();
			$userData=$this->session->userdata('userData');
			$id = isset($userData[0]->Id) ? $userData[0]->Id : null;
			$result_data = array();
			if($id) {
				$users = $this->UserMessageModel->getAllUsers($id);
				foreach($users as $user){
					/*$ids = explode(',', 'key', $user->_id);
					$names = explode('|', 'key', $user->names);
					$data_array = array_merge_recursive($ids, $names);*/
					if($user->role == '0'){
						$result_data['staff'][] = array('text' => ($user->name ? $user->name : ''), 'id' => $user->id, 'role' => $user->role);
					}elseif($user->role == '1'){
						$result_data['teachers'][] = array('text' => ($user->name ? $user->name : ''), 'id' => $user->id, 'role' => $user->role);
					}elseif($user->role == '2'){
						$result_data['students'][] = array('text' => ($user->name ? $user->name : ''), 'id' => $user->id, 'role' => $user->role);
					}
				}
				//var_dump($result_data);exit;
				$mess_count_daily = $emails_limit_daily - $count_emails_day->count_daily;
				$mess_count_monthly = $emails_limit_monthly - $count_emails_day->count_monthly;
				$mess_count = min($mess_count_daily, $mess_count_monthly);
			}

			echo json_encode(array('data' => $result_data, 'mess_count' => $mess_count));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteMessage(){
		if($this->input->is_ajax_request()) {
			$success = false;
			$userData=$this->session->userdata('userData');
			$user_id = isset($userData[0]->Id) ? $userData[0]->Id : null;
			$message_id = $this->input->post('message_id');
			if($user_id && $message_id){
				$success = $this->MensajeModel->deleteMessage($message_id);
			}
			echo json_encode(array('success' => $success));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getGroupsList(){
		$this->load->model('GrupoModel');
		$this->load->model('ErpEmailModel');
		$emails_limit_daily = $this->_db_details->emails_limit_daily;
		$emails_limit_monthly = $this->_db_details->emails_limit_monthly;
		$count_emails_day = $this->ErpEmailModel->getEmailsCountDay();
		$groups = $this->GrupoModel->getGroupsForLMSMessage();//$this->GruposlModel->getGroupsForLMSMessage();
		$mess_count_daily = $emails_limit_daily - $count_emails_day->count_daily;
		$mess_count_monthly = $emails_limit_monthly - $count_emails_day->count_monthly;
		$mess_count = min($mess_count_daily, $mess_count_monthly);
		print_r(json_encode(array('data' =>$groups,'mess_count'=>$mess_count )));
		exit;
	}
	
	public function getCourses(){
		$this->load->model('GruposlModel');
		$group_ids = $this->input->post('group_id');
		$courses = array();
		if(!empty($group_ids)) {
			$group_ids_array = explode(',', $group_ids);
			$courses = $this->GruposlModel->getCoursesByGroupId($group_ids_array);
		}
		print_r(json_encode($courses));
		exit;
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
class Events extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->lang->load('campus',$this->data['lang']);
		if(empty($this->_identity['loggedIn'])){
			redirect('/auth/login/', 'refresh');
		}
		$this->load->model('ErpEventoModel');
		$this->layouts->add_includes('js', 'app/js/events/main.js');
	}
	
	public function index(){
		$this->data['page']='events';
		$this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/events/index.js');
		$this->layouts->view('events/index', $this->data, $this->layout);
	}

	public function get_events(){
		$html = '';
		if ($this->input->is_ajax_request()) {
			$events_type = $this->input->post('events_type', true);
			$show_more = $this->input->post('show_more', true);
			$events = $this->ErpEventoModel->getItems($events_type, 5, $show_more);
			if(isset($events) && !empty($events)){
				foreach($events as $event){

					$event_type_class = 'public_event';
					if($event->public != 1){
						$event_type_class = 'private_event';
					}

					$html .= ' <div class="row event_item_row event_item_row_all" data-event_id="'.$event->id .'">
                                    <div class="col-xs-12">
                                        <div class=" margin-right-10  box_event text-center pull-left '.$event_type_class.'">
                                            <p>'. date("F",strtotime($event->event_date)).'</p>
                                            <span>'.date("j",strtotime($event->event_date)).'</span>
                                        </div>

                                        <h4>'.$event->title.'</h4>
                                        <p style="word-break: normal;">'.$event->content.'</p>

                                    </div>
                                </div>';
					$html .= '<hr>';
				}
				$html .= '<a type="button" href="/events" class="btn btn-circle btn-back  pull-right" id="show_more">'.$this->lang->line('campus_display_more').'</a>';
			}else{
				$html .= '<p style="color:red">'.$this->lang->line('campus_no_any_data').'</p>';
			}
		}

		print_r(json_encode($html));
		exit;
	}

	public function get_event_details(){
		$html = '';
		if ($this->input->is_ajax_request()) {
			$event_id = $this->input->post('event_id', true);
			$event = $this->ErpEventoModel->getItemById($event_id);
			if(isset($event[0]) && !empty($event[0])){
					$event = $event[0];
					$event_type_class = 'public_event';
					if($event->public != 1){
						$event_type_class = 'private_event';
					}

					$html .= '<div class="row event_item_row" data-event_id="'.$event->id .'">
                                    <div class="col-xs-12">


                                        <div class="box_event pull-right text-center maregin-top-10 margin-left-10 margin-bottom-10 '.$event_type_class.'">
                                            <p>'. date("F",strtotime($event->event_date)).'</p>
                                            <span>'.date("j",strtotime($event->event_date)).'</span>
                                        </div>
                                        	<h4 class="margin-top-0">'.$event->title.'</h4>
											<p class="text-justify" style="word-break: normal;">'.$event->content.'</p>
                                    </div>
                                </div>';
			}else{
				$html .= '<p style="color:red">'.$this->lang->line('campus_no_any_data').'</p>';
			}
		}

		print_r(json_encode($html));
		exit;
	}

	public function add_event(){
		$result['success'] = false;
		$result['errors'] = null;

		$this->load->library('form_validation');

		$this->form_validation->set_rules('public', $this->lang->line('events_select_option'),'trim|required');
		$this->form_validation->set_rules('event_date', $this->lang->line('events_event_date'), 'trim|required');
		$this->form_validation->set_rules('title', $this->lang->line('events_title'), 'trim|required');
		$this->form_validation->set_rules('content', $this->lang->line('events_content'), 'trim|required');

		if ($this->form_validation->run()) {
			$data_post = $this->input->post(null, true);
			$this->load->model('UsuarioModel');
			$this->load->model('ProfesorModel');
			//vardump();exit;
			if(!empty($data_post)){
				$event_id = $this->ErpEventoModel->insertItem($data_post);
				if($event_id){
					$result['success'] = $this->lang->line('events_added');
					$users = $this->UsuarioModel->get_active_users_for_select();
					if(!empty($users)){
						foreach($users as $user_data){
							if(!empty($user_data)) {
								$replace_data = array(
									'FIRSTNAME' => $user_data->user_name,
									'SURNAME' => $user_data->user_name,
									'FULLNAME' => $user_data->user_name,
									'PHONE1' => $user_data->Telefono,
									'MOBILE' => $user_data->Telefono,
									'EMAIL1' => $user_data->email,
									//'COURSE_NAME' => $course_data->course_name,
									'START_DATE' => $data_post['event_date'],
									'END_DATE' => $data_post['event_date'],
								);
								$this->sendEmailPart($replace_data, $user_data->email);
							}
						}
					}
					$teachers = $this->ProfesorModel->getAllActiveTeachers();
					if(!empty($teachers)){
						foreach($teachers as $teacher_data){
							if(!empty($teacher_data)) {
								$replace_data = array(
									'FIRSTNAME' => $teacher_data->first_name,
									'SURNAME' => $teacher_data->sur_name,
									'FULLNAME' => $teacher_data->full_name,
									'PHONE1' => $teacher_data->phone1,
									'MOBILE' => $teacher_data->mobile,
									'EMAIL1' => $teacher_data->email,
									//'COURSE_NAME' => $course_data->course_name,
									'START_DATE' => $data_post['event_date'],
									'END_DATE' => $data_post['event_date'],
								);
								$this->sendEmailPart($replace_data, $teacher_data->email);
							}
						}
					}
					if(isset($data_post['public']) && $data_post['public']  == '1'){
						$this->load->model('AlumnoModel');
						$students = $this->AlumnoModel->getAllActiveStudents();
						if(!empty($students)){
							foreach($students as $student_data){
								if(!empty($student_data)) {
									$replace_data = array(
										'FIRSTNAME' => $student_data->first_name,
										'SURNAME' => $student_data->sur_name,
										'FULLNAME' => $student_data->full_name,
										'PHONE1' => $student_data->phone1,
										'MOBILE' => $student_data->mobile,
										'EMAIL1' => $student_data->email,
										//'COURSE_NAME' => $course_data->course_name,
										'START_DATE' => $data_post['event_date'],
										'END_DATE' => $data_post['event_date'],
									);
									$this->sendEmailPart($replace_data, $student_data->email);
								}
							}
						}
					}
				}else{
					$result['errors'][] = $this->lang->line('db_err_msg');
				}
			}else{
				$result['errors'][] = $this->lang->line('db_err_msg');
			}
		}else{
			$errors = $this->form_validation->error_array();
			foreach($errors as $e_k=>$error){
				$result['errors'][$e_k] = $error;
			}
		}
		print_r(json_encode($result));
		exit;
	}

	private function sendEmailPart($replace_data,$email){
		$result = null;
		$this->load->model('ErpEmailsAutomatedModel');
		$template = $this->ErpEmailsAutomatedModel->getByTemplateId('15', array('notify_student' => 1));
		if (!empty($template) && !empty($email)) {
			$email_subject = replaceTemplateBody($template->Subject, $replace_data);
			$email_body = replaceTemplateBody($template->Body, $replace_data);
			$result = $this->send_automated_email($email, $email_subject, $email_body, $template->from_email);
		}
		return $result;
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
}
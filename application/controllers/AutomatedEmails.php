<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
class AutomatedEmails extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->lang->load('automated_emails', $this->data['lang']);

		$this->load->model('ErpEmailsTemplatesFolderModel');
		$this->load->model('ErpEmailsTemplateModel');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	
	public function index(){
		$this->load->model('ErpEmailsAutomatedModel');
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/automated_emails/index.js');
		$this->data['page'] = 'email_templates';
		$this->layouts->view('automated_emails/index', $this->data);
	}

	public function editTemplate($template_id = null){
		$this->load->model('ErpEmailsAutomatedModel');
		if(!$template_id){
			redirect('automatedEmails');
		}
		$this->layouts->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js');
		$this->layouts->add_includes('js', 'app/js/automated_emails/edit.js');

		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'template_title',
					'label' => $this->lang->line('automated_emails_template_name'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email_subject',
					'label' => $this->lang->line('automated_emails_new_subject'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'template_body',
					'label' => $this->lang->line('automated_emails_new_body'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'from_email',
					'label' => $this->lang->line('automated_emails_from_email'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');


			if ($this->form_validation->run()) {
				$data_template['Subject'] = html_purify($this->input->post('email_subject', true));
				$data_template['Body'] = html_purify($this->input->post('template_body', true));
				$data_template['from_email'] = $this->input->post('from_email', true);
				//echo '<pre>';var_dump($data_template);exit;
				$this->ErpEmailsAutomatedModel->updateTemplate($template_id, $data_template);
			}else{
				$this->session->set_flashdata('errors', $this->form_validation->error_array() );
			}
		}

		$this->data['page']='automated_template_edit';

		$this->data['template_id'] = $template_id;
		$this->data['template'] = $this->ErpEmailsAutomatedModel->getByTemplateId($template_id);

		$this->layouts->view('automated_emails/edit', $this->data);
	}


	private function getRefereAutomatedEmails(){
		return (object)[
			(object)array(
				'id' => 'ST101',
				'role' => 'studnet',
				'name' => 'automated_emails_course_enrollment',
			),(object)array(
				'id' => 'ST102',
				'role' => 'studnet',
				'name' => 'automated_emails_course_unenrollment',
			),(object)array(
				'id' => 'ST103',
				'role' => 'studnet',
				'name' => 'automated_emails_passed_course',
			),(object)array(
				'id' => 'ST104',
				'role' => 'studnet',
				'name' => 'automated_emails_cancelled_course',
			),(object)array(
				'id' => 'ST105',
				'role' => 'studnet',
				'name' => 'automated_emails_non_attendance_event',
			),(object)array(
				'id' => 'ST106',
				'role' => 'studnet',
				'name' => 'automated_emails_forgot_login_password',
			),(object)array(
				'id' => 'ST107',
				'role' => 'studnet',
				'name' => 'automated_emails_added_new_event',
			),(object)array(
				'id' => 'ST108',
				'role' => 'studnet',
				'name' => 'automated_emails_new_message',
			),(object)array(
				'id' => 'ST109',
				'role' => 'studnet',
				'name' => 'automated_emails_changed_event',
			),(object)array(
				'id' => 'ST110',
				'role' => 'studnet',
				'name' => 'automated_emails_new_resources',
			),

			//teachers

			(object)array(
				'id' => 'TE101',
				'role' => 'teacher',
				'name' => 'automated_emails_group_assigment',
			),(object)array(
				'id' => 'TE102',
				'role' => 'teacher',
				'name' => 'automated_emails_group_cancelled',
			),(object)array(
				'id' => 'TE103',
				'role' => 'teacher',
				'name' => 'automated_emails_cancelled_deleted_event',
			),(object)array(
				'id' => 'TE104',
				'role' => 'teacher',
				'name' => 'automated_emails_forgot_login_password',
			),(object)array(
				'id' => 'TE105',
				'role' => 'teacher',
				'name' => 'automated_emails_added_new_event',
			),(object)array(
				'id' => 'TE106',
				'role' => 'teacher',
				'name' => 'automated_emails_new_message',
			),(object)array(
				'id' => 'TE107',
				'role' => 'teacher',
				'name' => 'automated_emails_changed_event',
			)
		];
	}




	public function get_templates(){
		$response = array();
		if($this->input->post()){
			if($this->input->is_ajax_request()){

				$start =$this->input->post('start',  true);
				$length =$this->input->post('length', true);
				$draw = $this->input->post('draw', true);
				$search =$this->input->post('search', true);
				$order = $this->input->post('order', true);
				$columns = $this->input->post('columns', true);
				$column = $order[0]['column'];
				$this->load->model('ErpEmailsAutomatedModel');
				$refere = isset($columns[0]['search']['value']) && !empty($columns[0]['search']['value']) ? $columns[0]['search']['value'] : null;
				$total_templates = $this->ErpEmailsAutomatedModel->getTotalCount($refere);
				$total_records = $total_templates;
				$email_templates = $this->ErpEmailsAutomatedModel->getTemplatesByAjax($start, $length, $draw, $search, $order, $columns);


				$items = $email_templates;
				$items_count = count($items);
				$recordsTotal = (int)$total_records - $items_count;
				$response = array(
					"start"=>$start,
					"length"=>$length,
					"search"=>$search,
					"order"=>$order,
					"column"=>$column,
					"draw"=>$draw,
					"recordsFiltered"=>$total_records,
					"recordsTotal"=>$recordsTotal,
//					"recordsFiltered"=>$items_count,
//					"recordsTotal"=>(int)$total_records,
					"data"=>$items
				);
			}
		}
		print_r(json_encode($response));
		exit;
	}

	public function changeTemplateActivity(){
		if($this->input->is_ajax_request()){
			$this->load->model('ErpEmailsAutomatedModel');
			$template_id = $this->input->post('template_id', true);
			$active = $this->input->post('active', true) == '1' ? 1 : 0;
			$result = $this->ErpEmailsAutomatedModel->changeActive($template_id, $active);

			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}


	public function send_test_email(){
		$response['success'] = false;
		$response['errors'] = array();
		$response['test_email_id'] = null;
		if($this->input->post()){
			$this->load->model('ErpEmailModel');
			$post_data = $this->input->post(null, true);
			$emails = $post_data['test_emails'];
			$subject = $post_data['Subject'];
			$body = html_purify($post_data['Body']);

			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'test_emails',
					'label' => $this->lang->line('campaigns_test_emails'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run()) {


				$emails_arr = array_map('trim', explode(',', $emails));
				foreach($emails_arr as $k=>$email_item) {
					if (!filter_var($email_item, FILTER_VALIDATE_EMAIL) === false) {
						$user_id = $this->session->userdata('userData')[0]->Id;

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
							$request['Source'] = $email_from['from'];
							$request['Destination']['ToAddresses'] = array($email_item);
							$request['Message']['Subject']['Data'] = $subject;
							$request['Message']['Subject']['Charset'] = "UTF-8";
							$request['Message']['Body']['Html']['Data'] = $body;
							$request['Message']['Subject']['Charset'] = "UTF-8";
							try {
								$result = $client->sendEmail($request);
								$messageId = $result->get('MessageId');
								if ($messageId) {
									$data_recipient = array(
										'from_userid' => $user_id,
										'id_campaign' => '',
										'email_recipie' => $email_item,
										'Subject' => $subject,
										'Body' => $body,
										'date' => date('Y-m-d H:i:s'),
										'sucess' => '1',
									);
									$added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
									$response['success'] = $this->lang->line('automated_emails_send_test_email_success');
									$response['errors'] = false;
								}
								//echo("Email sent! Message ID: $messageId"."\n");

							} catch (Exception $e) {
								//echo("The email was not sent. Error message: ");
								//$response['errors'] = $e->getMessage()."\n";
								$data_recipient = array(
									'from_userid' => $user_id,
									'id_campaign' => '',
									'email_recipie' => $email_item,
									'Subject' => $subject,
									'Body' => $body,
									'date' => date('Y-m-d H:i:s'),
									'sucess' => '0',
									'error_msg' => $e->getMessage(),
								);
								$added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
								$response['errors'][] = $this->lang->line('automated_emails_no_send_test_email');
							}


						} else {
							$response['errors'][] = $this->lang->line('emails_limit_daily_msg');
						}
					} else {
						$response['errors'] = $this->lang->line('db_err_msg');
					}
				}
			}else{
				$response['errors'] =  $this->form_validation->error_array();
			}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}

		print_r(json_encode($response));
		exit;
	}

}

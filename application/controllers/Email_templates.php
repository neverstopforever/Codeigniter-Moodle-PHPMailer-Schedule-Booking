<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;

class Email_templates extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->load->model('ErpEmailsTemplatesFolderModel');
		$this->load->model('ErpEmailsTemplateModel');
		$this->load->model('ErpEmailModel');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
		$this->layouts->add_includes('js', 'app/js/email_templates/main.js');
	}
	
	public function index(){
		$this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/email_templates/index.js');
		$this->data['page']='email_templates';
		$this->data['all_templates_count'] = $this->ErpEmailsTemplateModel->getTotalCount();
		$this->data['folders'] = $this->ErpEmailsTemplatesFolderModel->getFoldersWithTemplatesCounts();

		$this->layouts->view('email_templates/index', $this->data);
	}

	public function chnageFolderName(){
		if($this->input->is_ajax_request()){
			$folder_id = $this->input->post('folder_id');
			$folder_name = $this->input->post('folder_name');
			$result = false;
			if($folder_id && $folder_name) {
				$result = $this->ErpEmailsTemplatesFolderModel->chnageFolderName($folder_id, $folder_name);
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteFolder(){
		if($this->input->is_ajax_request()){
			$folder_id = $this->input->post('folder_id');
			$this->load->model('ErpEmailsCampaignFolderModel');
			$result = false;
			if($folder_id) {
				$result = $this->ErpEmailsTemplatesFolderModel->deleteFolder($folder_id);
				if($result){
					$this->ErpEmailsTemplateModel->deleteItemByFolder($folder_id);
				}
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function add(){
		$this->layouts->add_includes('css', 'assets/global/css/steps.css');
		$this->layouts->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js');
		$this->layouts->add_includes('js', 'app/js/email_templates/add.js');
		$this->data['page']='email_templates_add';
//		$this->data['all_templates_count'] = $this->ErpEmailsTemplateModel->getTotalCount();
		$this->data['folders'] = $this->ErpEmailsTemplatesFolderModel->getFoldersWithTemplatesCounts();

		$this->layouts->view('email_templates/add', $this->data);
	}

	public function edit($template_id = null){
		if(empty($template_id) || !is_numeric($template_id)){
			$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
			redirect('email_templates');
		}
		$this->layouts->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js');
		$this->layouts->add_includes('js', 'app/js/email_templates/edit.js');

		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'template_title',
					'label' => $this->lang->line('email_templates_new_title'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email_subject',
					'label' => $this->lang->line('email_templates_new_subject'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'template_folder',
					'label' => $this->lang->line('email_templates_new_id_folder'),
					'rules' => 'trim|required|is_natural_no_zero'
				),
//				array(
//					'field' => 'template_body',
//					'label' => $this->lang->line('email_templates_new_body'),
//					'rules' => 'trim|required'
//				)
			);

			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');


			if ($this->form_validation->run()) {
				$data_template_post = $this->input->post(NULL, true);
				$data_template['title'] = html_purify($data_template_post['template_title']);
				$data_template['Subject'] = html_purify($data_template_post['email_subject']);
				$data_template['Body'] = html_purify($data_template_post['template_body']);
				$data_template['id_folder'] = html_purify($data_template_post['template_folder']);
				$edited_template = $this->ErpEmailsTemplateModel->editTemplate($template_id, $data_template);
				if($edited_template){
					$this->session->set_flashdata('success', $this->lang->line('email_templates_template_edited'));
				}else{
					$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
				}
			}else{
				$this->session->set_flashdata('errors', $this->form_validation->error_array() );
			}
		}


		$this->data['page']='email_templates_edit';
		$this->data['folders'] = $this->ErpEmailsTemplatesFolderModel->getFoldersWithTemplatesCounts();
		$template = $this->ErpEmailsTemplateModel->getById($template_id);
		if(isset($template[0])){
			$this->data['template'] = $template[0];
		}else{
			$this->data['template'] = new ErpEmailsTemplateModel();
		}

		$this->data['template_id'] = $template_id;


		$this->layouts->view('email_templates/edit', $this->data);
	}

	public function delete($template_id = null){
		if(empty($template_id) || !is_numeric($template_id)){
			$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
		}else{
			$delete_template = $this->ErpEmailsTemplateModel->deleteItem($template_id);
			if($delete_template){
				$this->session->set_flashdata('success', $this->lang->line('email_templates_template_deleted'));
			}else{
				$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
			}
		}
		redirect('email_templates');
	}

	public function delete_all_checked(){
		$response['success'] = false;
		$response['errors'] = array();
		if($this->input->post()){
			$template_ids = $this->input->post('template_ids', true);
			$deleted = $this->ErpEmailsTemplateModel->bulk_delete($template_ids);
			if($deleted){
				$response['success'] = $this->lang->line('email_templates_templates_deleted');
				$response['errors'] = false;
			}else{
				$response['errors'][] = $this->lang->line('db_err_msg');
			}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}

		print_r(json_encode($response));
		exit;
	}

	public function add_new_folder(){
		$response['success'] = false;
		$response['errors'] = array();
		$response['new_folder_id'] = null;
		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'new_folder_name',
					'label' => $this->lang->line('email_templates_new_folder_name'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);
//			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

			if ($this->form_validation->run()) {
					$new_folder_name = $this->input->post('new_folder_name', true);
					$folder_exist = $this->ErpEmailsTemplatesFolderModel->getFolderByTitle($new_folder_name);
					if(empty($folder_exist)){
						$folder_insert = $this->ErpEmailsTemplatesFolderModel->insertFolder($new_folder_name);
						if($folder_insert){
							$response['new_folder_id'] = $folder_insert;
							$response['success'] = $this->lang->line('email_templates_create_folder_success');
							$response['errors'] = false;
						}else{
							$response['errors'][] = $this->lang->line('db_err_msg');
						}
					}else{
						$response['errors'][] = $this->lang->line('email_templates_folder_exist');
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

	public function add_template_steps(){
		$html = '';
		$step_id = $this->input->get('step_id', true);
		if(!empty($step_id)){
//			$this->data['all_templates_count'] = $this->ErpEmailsTemplateModel->getTotalCount();
			$this->data['folders'] = $this->ErpEmailsTemplatesFolderModel->getFoldersWithTemplatesCounts();
			switch ($step_id) {
				case 1:
					$html .= $this->load->view('email_templates/partials/add_template_steps/step1.php', $this->data, true);
        		break;
				case 2:
					$html .= $this->load->view('email_templates/partials/add_template_steps/step2.php', $this->data, true);
        		break;
				case 3:
					$this->data['templates'] = $this->ErpEmailsTemplateModel->getAllTemplates();
					$html .= $this->load->view('email_templates/partials/add_template_steps/step3.php', $this->data, true);
        		break;
				case 4:
					$html .= $this->load->view('email_templates/partials/add_template_steps/step4.php', $this->data, true);
        		break;
				default:
			}
		}

		print_r(json_encode($html));
		exit;
	}

	public function add_template_finish(){

		$response['success'] = false;
		$response['errors'] = array();
		$response['new_template_id'] = null;
		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'title',
					'label' => $this->lang->line('email_templates_new_title'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'Subject',
					'label' => $this->lang->line('email_templates_new_subject'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'id_folder',
					'label' => $this->lang->line('email_templates_new_id_folder'),
					'rules' => 'trim|required|is_natural_no_zero'
				),
				array(
					'field' => 'Body',
					'label' => $this->lang->line('email_templates_new_body'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run()) {
					$data_template = $this->input->post(NULL, true);
					$data_template['title'] = html_purify($data_template['title']);
					$data_template['Subject'] = html_purify($data_template['Subject']);
					$data_template['Body'] = html_purify($data_template['Body']);
					$added_template_id = $this->ErpEmailsTemplateModel->addTemplate($data_template);
					if($added_template_id){
						$response['new_template_id'] = $added_template_id;
						$response['success'] = $this->lang->line('email_templates_add_success');
						$response['errors'] = false;
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
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


	public function send_test_email(){
		$response['success'] = false;
		$response['errors'] = array();
		$response['test_email_id'] = null;
		if($this->input->post()){

			$post_data = $this->input->post(null, true);
			$emails = $post_data['test_emails'];
			$subject = $post_data['Subject'];
			$body = html_purify($post_data['Body']);
			$email_conf = (object)$this->config->item('email');

			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'test_emails',
					'label' => $this->lang->line('email_templates_test_emails'),
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
							$request['Message']['Body']['Charset'] = "UTF-8";

							try {
								$result = $client->sendEmail($request);
								$messageId = $result->get('MessageId');
								//echo("Email sent! Message ID: $messageId"."\n");
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
									$response['success'][] = $this->lang->line('email_templates_send_test_email_success');
									$response['errors'] = false;
								} else {
									$response['errors'][] = $this->lang->line('email_templates_no_send_test_email');
								}

							} catch (Exception $e) {
								//echo("The email was not sent. Error message: ");
								//$response['errors'] = $e->getMessage()."\n";
								$response['errors'][] = $this->lang->line('email_templates_no_send_test_email');
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
							}
						} else {
							$response['errors'][] = $this->lang->line('emails_limit_daily_msg');
						}

					} else {
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
				}
			}else{
				$response['errors'][] =  $this->form_validation->error_array();
			}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}

		print_r(json_encode($response));
		exit;
	}

	public function get_templates(){
		$response = array();
		$total_templates = $this->ErpEmailsTemplateModel->getTotalCount();

		if($this->input->post()){
			if($this->input->is_ajax_request()){

				$start =$this->input->post('start',  true);
				$length =$this->input->post('length', true);
				$draw = $this->input->post('draw', true);
				$search =$this->input->post('search', true);
				$order = $this->input->post('order', true);
				$columns = $this->input->post('columns', true);
				$column = $order[0]['column'];



				$total_records = $total_templates;

				$email_templates = $this->ErpEmailsTemplateModel->getTemplatesByAjax($start, $length, $draw, $search, $order, $columns);

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

}

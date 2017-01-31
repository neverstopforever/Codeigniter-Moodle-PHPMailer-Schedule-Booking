<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
class Webservice extends Public_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->layout = 'public';
		$this->load->model('WebformModel');
		$this->load->model('ContactosModel');
		$this->load->model('LeadsModel');
		$this->load->model('PresupuestotModel');
		$this->load->model('PresupuestosTabAdModel');
		$this->load->model('ContactosTabAdModel');
		$this->load->model('PresupuestoSolicitudModel');
		$this->load->model('WebformErrorlogModel');
		$this->load->model('ClientesPortaleModel');
		$this->load->library('user_agent');
		$this->layouts->add_includes('js', 'app/js/webservice/main.js');
		header('Access-Control-Allow-Origin: *');
	}
	
	public function index(){
		$this->layouts->add_includes('js', 'app/js/webservice/index.js');
		$this->data['page']='webservice_index';

		$this->layouts->view('webservice/index', $this->data, $this->layout);
	}

	public function create(){
		$this->layouts->add_includes('js', 'app/js/webservice/create.js');
		$this->data['page']='webservice_create';
		$redirect_url = base_url();
		if($this->input->post()){
			$post_data = $this->input->post(NULL, true);
			$data['webform'] = array();
			$data['co'] = array();
			$data['pt'] = array();
			foreach($post_data as $field=>$value){
				if(strpos($field, 'co-') !== false) {
					$field_arr = explode('co-', $field);
					if(isset($field_arr[1])){
						$data['co'][$field_arr[1]] = $value;
					}
				}elseif(strpos($field, 'pt-') !== false){
					$field_arr = explode('pt-', $field);
					if(isset($field_arr[1])){
						$data['pt'][$field_arr[1]] = $value;
					}

				}else{
					$data['webform'][$field] = $value;
				}
			}
			if(!empty($data['webform'])){
				$webform_data = $data['webform'];

				$url_error = isset($webform_data['url_error']) ? $webform_data['url_error'] : null;
				$url_destino = isset($webform_data['url_destino']) ? $webform_data['url_destino'] : null;
				$apikey = isset($webform_data['apikey']) ? $webform_data['apikey'] : null;
				$idmedio = isset($webform_data['idmedio']) ? $webform_data['idmedio'] : null;
				$idportal = isset($webform_data['idportal']) ? $webform_data['idportal'] : null;
				$_db_details = null;
				if($apikey){
					$db_details = $this->ClientesPortaleModel->getDbDetailsByApiKey($apikey);
					if(isset($db_details[0])){
						$_db_details = $db_details[0];
					}
				}
				if($_db_details){ //db details for different clients
					$this->_db_details = $_db_details;
					$content_array = $webform_data;
					if(isset($content_array['url_error'])){
						unset($content_array['url_error']);
					}
					if(isset($content_array['url_destino'])){
						unset($content_array['url_destino']);
					}
					if(isset($content_array['apikey'])){
						unset($content_array['apikey']);
					}
					if(isset($content_array['validate_data'])){
						unset($content_array['validate_data']);
					}
					$content_array_new = json_encode($content_array);
					$source = $this->agent->referrer();
					$webform_data_new  = array(
						'idportal'=>$idportal,
						'read'=>0,
						'datetime'=>date('Y-m-d H:i:s'),
						'apikey'=>$apikey,
						'content'=>null,
						'source'=>$source,
						'content_array'=>$content_array_new,
						'idmedio'=>$idmedio
					);
					$valid_form = $this->validate_form_error_log($webform_data);
					if ($valid_form) {
						$webform_id = $this->WebformModel->addItem($webform_data_new);
						if ($webform_id) {
							$redirect_url = $url_destino;
							if(isset($data['webform']['validate_data']) && $data['webform']['validate_data'] == 1){
								//check contacts
								$contact = $this->ContactosModel->getByEmail($data['webform']['email']);
								if($contact){ //create from exist
									//contactos
									$contact_data = array();
									if(isset($webform_data['nombre'])){
										$contact_data['Nombre'] = $webform_data['nombre'];
									}
									if(isset($webform_data['apellidos'])){
										$contact_data['sApellidos'] = $webform_data['apellidos'];
									}
									if(isset($webform_data['domicilio'])){
										$contact_data['Domicilio'] = $webform_data['domicilio'];
									}
									if(isset($webform_data['cp'])){
										$contact_data['Distrito'] = $webform_data['cp'];
									}
									if(isset($webform_data['problacion'])){
										$contact_data['Poblacion'] = $webform_data['problacion'];
									}
									if(isset($webform_data['provincia'])){
										$contact_data['Provincia'] = $webform_data['provincia'];
									}
									if(isset($webform_data['telefono'])){
										$contact_data['Telefono1'] = $webform_data['telefono'];
									}
									if(isset($webform_data['Movil'])){
										$contact_data['movil'] = $webform_data['Movil'];
									}
									$contact_id = isset($contact[0]->Id) ? $contact[0]->Id : null;
									$contact_added = $this->ContactosModel->updateRecord($contact_data, $contact_id);
									$contactosTabAd_data = array();
									if(isset($data['co']) && !empty($data['co'])){
										foreach($data['co'] as $k_c=>$v_c){
											$contactosTabAd_data[$k_c] = $v_c;
										}
									}
									if(!empty($contactosTabAd_data)){
										$c_added = $this->ContactosTabAdModel->addItem($contactosTabAd_data);
									}

									//presupuestot
									$leadId = $this->LeadsModel->updateVariable();
									if($leadId){
										$descripcion = isset($webform_data['comentarios']) ? $webform_data['comentarios'] : null;
										$presupuestot_added = $this->PresupuestotModel->addLeadsRecordsByContact($leadId, $contact_id, $descripcion);
										if($presupuestot_added) {
											$prospect_data = $this->LeadsModel->getProspectDataById($leadId);
											$replace_data = array(
												'FIRSTNAME' => $prospect_data->first_name,
												'SURNAME' => $prospect_data->last_name,
												'FULLNAME' => $prospect_data->full_name,
												//'PHONE1' => $prospect_data->,
												'MOBILE' => $prospect_data->mobile,
												'EMAIL1' => $prospect_data->email,
												//'COURSE_NAME' => $course_data->course_name,
												'START_DATE' => date('"F j, Y'),
												'END_DATE' => date('"F j, Y'),
											);

											$this->load->model('ErpEmailsAutomatedModel');
											$template = $this->ErpEmailsAutomatedModel->getByTemplateId('18', array('notify_student' => 1));
											if (!empty($template) && !empty($prospect_data->email)) {
												$email_subject = replaceTemplateBody($template->Subject, $replace_data);
												$email_body = replaceTemplateBody($template->Body, $replace_data);
												$this->send_automated_email($prospect_data->email, $email_subject, $email_body, $template->from_email);
											}
										}
										if($presupuestot_added){
											$presupuestosTabAd_data = array(
												'NumPresupuesto' => $leadId
											);
											if(isset($data['pt']) && !empty($data['pt'])){
												foreach($data['pt'] as $k_p=>$v_p){
													$presupuestosTabAd_data[$k_p] = $v_p;
												}
											}
											$p_added =$this->PresupuestosTabAdModel->addItem($presupuestosTabAd_data);

											//presupuesto_solicitud
											if(isset($webform_data['curso']) && $webform_data['curso'] ){
											$where_in = $webform_data['curso'];
											$where_in = '"' . implode('", "', explode(',', $where_in)) . '"';
											$ps_added = $this->PresupuestoSolicitudModel->addCourses($leadId, $where_in);
										}
											if($webform_data['tags']) {
												$tags = explode(',', $webform_data['tags']);
												$this->insertTag($leadId, $tags);
											}
											
										}else{

										}
									}
								}else{
									//create new
									$this->create_blank($data);
								}
							}elseif(isset($data['webform']['validate_data']) && $data['webform']['validate_data'] == 0){						//create new
								//create new
								$this->create_blank($data);
							}else{
								$redirect_url = $url_error;
							}
						}else{
							$redirect_url = $url_error;
						}
					}else{
						$redirect_url = $url_error;
					}
				}else{

				}

			}else{
				//$data['webform'] is empty
			}
		}
		if(empty($redirect_url)){
			$redirect_url = base_url();
		}
		redirect($redirect_url);
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

	protected function create_blank($data){

		if(!empty($data['webform'])) {
			$webform_data = $data['webform'];

			//presupuestot
			$leadId = $this->LeadsModel->updateVariable();
			if($leadId){
				$presupuestot_data = array(
					'NumPresupuesto' => trim($leadId),
					'Nombre' => isset($webform_data['nombre']) ? $webform_data['nombre'] : null,
					'sApellidos' => isset($webform_data['apellidos']) ? $webform_data['apellidos'] : null,
					'Descripcion' => isset($webform_data['comentarios']) ? $webform_data['comentarios'] : null,

					'email' => isset($webform_data['email']) ? $webform_data['email'] : null,
					'domicilio' => isset($webform_data['domicilio']) ? $webform_data['domicilio'] : null,
					'Poblacion' => isset($webform_data['problacion']) ? $webform_data['problacion'] : null,
					'Provincia' => isset($webform_data['provincia']) ? $webform_data['provincia'] : null,
					'Telefono' => isset($webform_data['telefono']) ? $webform_data['telefono'] : null,
					'Movil' => isset($webform_data['Movil']) ? $webform_data['Movil'] : null
				);
				$presupuestot_added = $this->PresupuestotModel->addLeadsRecords($presupuestot_data);
				if($presupuestot_added){
					$presupuestosTabAd_data = array(
						'NumPresupuesto' => $presupuestot_data['NumPresupuesto']
					);
					if(isset($data['pt']) && !empty($data['pt'])){
						foreach($data['pt'] as $k_p=>$v_p){
							$presupuestosTabAd_data[$k_p] = $v_p;
						}
					}
					$this->PresupuestosTabAdModel->addItem($presupuestosTabAd_data);

					//presupuesto_solicitud
					if(isset($webform_data['curso']) && $webform_data['curso'] ) {
						$where_in = $webform_data['curso'];
						$where_in = '"' . implode('", "', explode(',', $where_in)) . '"';
						$this->PresupuestoSolicitudModel->addCourses($leadId, $where_in);
					}
					if(isset($webform_data['tags']) && $webform_data['tags']) {
						$tags = explode(',', $webform_data['tags']);
						$this->insertTag($leadId, $tags);
					}

				}else{

				}
			}

			//contactos
			$contact_data = array(
				'Nombre' => isset($webform_data['nombre']) ? $webform_data['nombre'] : null,
				'Email' => isset($webform_data['email']) ? $webform_data['email'] : null,
				'sApellidos' => isset($webform_data['apellidos']) ? $webform_data['apellidos'] : null,
				'Domicilio' => isset($webform_data['domicilio']) ? $webform_data['domicilio'] : null,
				'Distrito' => isset($webform_data['cp']) ? $webform_data['cp'] : null,
				'Poblacion' => isset($webform_data['problacion']) ? $webform_data['problacion'] : null,
				'Provincia' => isset($webform_data['provincia']) ? $webform_data['provincia'] : null,
				'Telefono1' => isset($webform_data['telefono']) ? $webform_data['telefono'] : null,
				'movil' => isset($webform_data['Movil']) ? $webform_data['Movil'] : null
			);
			$contact_added = $this->ContactosModel->addRecord($contact_data);

			$contactosTabAd_data = array();
			if(isset($data['co']) && !empty($data['co'])){
				foreach($data['co'] as $k_c=>$v_c){
					$contactosTabAd_data[$k_c] = $v_c;
				}
			}
			if(!empty($contactosTabAd_data)){
				$this->ContactosTabAdModel->addItem($contactosTabAd_data);
			}
		}
	}

	protected function validate_form_error_log($webform_data = array()){

		if(empty($webform_data)){
			return false;
		}

		$email = isset($webform_data['email']) ? $webform_data['email'] : null;
		$nombre = isset($webform_data['nombre']) ? $webform_data['nombre'] : null;
		$apikey = isset($webform_data['apikey']) ? $webform_data['apikey'] : null;

		$description = array();
		if (empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) != true){
			$description[] = $this->lang->line('webservice_wrong_email');
		}else if (empty($nombre)){
			$description[] = $this->lang->line('webservice_empty_name');
		}else if (empty($apikey)){
			$description[] = $this->lang->line('webservice_apikey_empty');
		}else if (!empty($apikey)){
			$apikey_length= strlen($apikey);
			if ($apikey_length < 252)
			{
				$description[] = $this->lang->line('webservice_apikey_format_wrong');
			}
		}
		if(!empty($description)){
			$description_new = json_encode($description);
			$content_array = $webform_data;
			if(isset($content_array['apikey'])){
				unset($content_array['apikey']);
			}
			if(isset($content_array['validate_data'])){
				unset($content_array['validate_data']);
			}
			$content_array_new = json_encode($content_array);
			$source = $this->agent->referrer();

			$webform_errorlog_data  = array(
				'ip_remota' => getUserIP(),
				'datetime' => date('Y-m-d H:i:s'),
				'apikey' => $apikey,
				'content' => $content_array_new,
				'description' => $description_new,
				'source' => $source
			);

			$this->WebformErrorlogModel->addItem($webform_errorlog_data);
			return false;
		}else{
			return true;
		}

	}
	protected  function insertTag($client_id, $tags){
		if($client_id){
			$this->load->model('PresupuestoTagsModel');
			$this->load->model('ErpTagsModel');
			$this->PresupuestoTagsModel->deleteAllItems($client_id);
			if(!empty($tags) && is_array($tags)) {

				$checking_ids = $this->ErpTagsModel->getNotExistTags($tags, $client_id, 'presupuesto_tags', 'numpresupuesto'); // presupuesto_tags is table name  and numpresupuesto is foreign key column name
				$insert_data = array();
				if(!empty($checking_ids)) {
					foreach ($checking_ids as $tag) {
						if(empty($tag->current_table_tag_id) && empty($tag->numpresupuesto)) {
							$insert_data[] = array('numpresupuesto' => $client_id, 'id_tag' => $tag->tag_id);
							$tags_ids_array[] = $tag->tag_id;
						}
					}
				}
				$this->PresupuestoTagsModel->insertBatch($insert_data);
			}
		}
	}
	public function getAllCoursesAndTags(){
			$this->load->model('CursoModel');
			$this->load->model('PresupuestoTagsModel');
			$courses = array();
			$tags = array();
			$apikey = $this->input->post('apikey', true);
			$get_course = $this->input->post('get_course', true);
			$get_tags = $this->input->post('get_tags', true);
			if ($apikey) {
				$db_details = $this->ClientesPortaleModel->getDbDetailsByApiKey($apikey);
				if (isset($db_details[0])) {
					$_db_details = $db_details[0];
					if ($_db_details) { //db details for different clients
						$this->_db_details = $_db_details;
						if ($get_course) {
							$courses = $this->CursoModel->getForSelect();
						}
						if($get_tags){
							$tags = $this->PresupuestoTagsModel->getAllTags();
						}

					}
				}

			}
			echo json_encode(array('courses' => $courses, 'tags' => $tags));
			exit;
		}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
/**
 *@property CourseModel $CourseModel
 *@property ProfesorModel $ProfesorModel
 *@property ProfesoresDocModel $ProfesoresDocModel
 *@property LstInformesProfesorModel $LstInformesProfesorModel
 *@property ProfesoresTabAdModel $ProfesoresTabAdModel
 *@property AlumnoTabAdModel $AlumnoTabAdModel
 *@property AlumnosSeguiModel $AlumnosSeguiModel
 *@property MatriculaDocModel $MatriculaDocModel
 *@property TarifasTModel $TarifasTModel
 *@property TarifasLModel $TarifasLModel
 *@property MatriculaTagsModel $MatriculaTagsModel
 */
class Enrollments extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('AlumnoModel');
		$this->load->model('MatriculalModel');

		$this->load->model('ReciboModel');
		$this->lang->load('quotes', $this->data['lang']);

		$this->load->library('user_agent');

		$this->lang->load('rates', $this->data['lang']);
		$this->lang->load('enrollments', $this->data['lang']);
		$this->load->library('form_validation');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
	}
	
	public function index(){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->load->model('MatriculatModel');
		$this->load->model('CursoModel');
		$this->load->model('GrupoModel');
		$this->load->model('AlumnoModel');
		$this->load->model('ErpTagsModel');
		$this->data['page'] = 'enrollments_index';
		$this->layouts->add_includes('css', 'assets/global/plugins/select2/select2.css');
		$this->layouts->add_includes('css', 'assets/global/plugins/jquery-multi-select/css/multi-select.css');
		$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
		$this->layouts->add_includes('js', 'assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js');
		$this->layouts->add_includes('js', 'app/js/enrollments/index.js');
		//$this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsList();
        $this->data['students_names'] =  $this->AlumnoModel->getAlumnoForFilter();
        $this->data['courses'] =  $this->CursoModel->getCourseForFilter();
        $this->data['groups'] =  $this->GrupoModel->getGroupsForFilter();

		$this->data['tags'] =  $this->ErpTagsModel->getTags();
		$tags_group_by_tag_id = array();
		$tags_for_filter = array();
		if(!empty($this->data['tags'])) {
			foreach ($this->data['tags'] as $tags){
				$tags_group_by_tag_id[$tags->id] = $tags;
				$tags_for_filter[] = array('id' => $tags->id, 'text' => $tags->tag_name,
					'back_color' => $tags->hex_backcolor, 'text_color' => $tags->hex_forecolor);
			}
		}
		$this->data['tags_group_by_tag_id'] = $tags_group_by_tag_id;
		$this->data['tags_for_filter'] = $tags_for_filter;

		$this->layouts->view('enrollments/indexView', $this->data);
	}
	public function getGroups(){
		if($this->input->is_ajax_request()){
			$this->load->model('GruposlModel');
			$course_id = $this->input->post('course_id');
			$groups = $this->GruposlModel->getGroupsForEnroll("('".$course_id."')");
			echo json_encode($groups);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getEnrollmentsData(){
		$this->load->model('MatriculatModel');
		$start =$this->input->post('start',  true);
		$length =$this->input->post('length', true);
		$draw = $this->input->post('draw', true);
		$search =$this->input->post('search', true);
		$order = $this->input->post('order', true);
		$columns = $this->input->post('columns', true);

		$filter_tags = (object)array(
			'selected_courses' => $this->input->post('selected_courses', true),
			'selected_groups' => $this->input->post('selected_groups', true),
			'selected_state' => $this->input->post('selected_state', true),
			'selected_names' => $this->input->post('selected_names', true),
			'tag_ids' => $this->input->post('tag_ids', true),
		);

		$column = $order[0]['column'];
		$total_enrollments = $this->MatriculatModel->getTotalCount();
		$enrollments_data = $this->MatriculatModel->getEnrollmentsAjax($start, $length, $draw, $search, $order, $columns, $filter_tags);
		$recordsTotal = (int)$enrollments_data->rows;
		$response = array(
			"start"=>$start,
			"length"=>$length,
			"search"=>$search,
			"order"=>$order,
			"column"=>$column,
			"draw"=>$draw,
			"recordsFiltered"=>$recordsTotal,
			"recordsTotal"=>$recordsTotal,
			"data"=>$enrollments_data->items,
			"table_total_rows"=> $total_enrollments
		);
		echo json_encode($response); exit;
	}

	public function add(){
		$this->load->model('CourseModel');
		$this->load->model('GruposlModel');
		$this->load->model('Variables2Model');
		$this->data['page'] = 'enrollments_add';
		$this->layouts
			->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
			->add_includes('css', 'assets/global/plugins/typeahead/custom.css')
			->add_includes('css', 'assets/global/plugins/jquery-ui/jquery-ui.min.css')
			->add_includes('css', 'assets/global/plugins/select2/select2.css')
			->add_includes('js', 'assets/global/plugins/jquery-ui/jquery-ui.min.js')
			->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
			->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
			->add_includes('js', 'assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js')
			->add_includes('js', 'assets/global/plugins/select2/select2.js')
//			->add_includes('css', 'assets/global/css/components.min.css')
			->add_includes('css', 'assets/global/css/steps.css')
			->add_includes('js', 'app/js/enrollments/add.js');
		$cisess = $this->session->userdata('_cisess');
		$membership_type = $cisess['membership_type'];
		if($membership_type != 'FREE'){
			$this->data['customfields_fields'] = $this->get_customfields_data();
		}
		$this->data['courses'] = $this->CourseModel->getCoursesForEnrrol();
		$this->data['groups'] = $this->GruposlModel->getGroupsForEnroll();
//		$this->data['not_enrolled_students'] = $this->AlumnoModel->getNotEnrolledStudnts();
		$settings = $this->Variables2Model->getGeneralSettings();
		$this->data['allow_group_change_startdate'] =$settings->allow_group_change_startdate;
		$this->data['allow_group_multicourse'] =$settings->allow_group_multicourse;
		//$this->data['enrolaeds_students'] = $this->MatriculalModel->getEnrolledStudents();
		$this->layouts->view('enrollments/addView', $this->data);
	}

	public function edit($id = null){
		if($id) {
			$this->load->model('ClientModel');
			$this->load->model('AlumnoTabAdModel');
			$this->load->model('MatriculaDocModel');
			$this->load->model('AlumnosSeguiModel');
			$this->load->model('ErpTagsModel');
			$this->load->model('MatriculaTagsModel');
			$this->layouts
				->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css')
				->add_includes('css', 'assets/global/plugins/typeahead/custom.css')
				->add_includes('css', 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css')
				->add_includes('css', 'assets/global/plugins/select2/css/select2.min.css')
				->add_includes('js', 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js')
				->add_includes('js', 'assets/global/plugins/select2/js/select2.full.min.js')

				->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js')
				->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js')
				->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js')
				->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
				->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
				->add_includes('js', 'assets/js/jspdf.min.js')
				->add_includes('js', 'app/js/enrollments/edit.js');
			$this->data['student'] = $this->AlumnoModel->getStudentByEnrollId($id);
			if(!empty($this->data['student'])) {
				$this->data['active_tab'] = $this->input->get('active_tab', true);
				$this->data['referrer_url'] = $this->agent->referrer();

                $student_id = $this->data['student']->id;
				$this->data['documents'] = $this->MatriculaDocModel->getByEnrollId($id);
				$this->data['company_name'] = false;
				$this->data['availability'] = array();//$this->getAvailability($id);
				$foloow_up_count = $this->AlumnosSeguiModel->getFollowUpCount($student_id);
				$this->data['follow_up_count'] = isset($foloow_up_count->f_count) ? $foloow_up_count->f_count : 0;
				$this->data['availability_times'] = array();//$this->getAvailabilityTimaes();

				$this->data['personalized_fields'] = $this->get_personalized_data($student_id);
				$cisess = $this->session->userdata('_cisess');
				$membership_type = $cisess['membership_type'];
				if($membership_type != 'FREE'){
					$this->data['customfields_fields'] = $this->get_customfields_data();
				}
				$this->data['courses'] = $this->MatriculalModel->getCourses($id);
				$this->data['enroll_id'] = $id;
				$quotes_count = $this->ReciboModel->getQuotesCountByEnrollId($id);
				$this->data['quotes_count'] = isset($quotes_count->q_count) ? $quotes_count->q_count : 0;
//				$this->data['templates'] = $this->LstPlantillaModel->getByCatId(6);
				$this->data['enroll_tags'] = $this->MatriculaTagsModel->getTags($id);
				$this->data['enroll_tag_ids'] = array();
				if(!empty($this->data['enroll_tags'])){
					foreach($this->data['enroll_tags'] as $tag){
						$this->data['enroll_tag_ids'][] = $tag->tag_id;
					}
				}
				//$where_not_in = "SELECT id_tag FROM matricula_tags WHERE nummatricula ='".$id."'";
				$this->data['tags'] = $this->ErpTagsModel->getTagsForfilterBytable();

				$this->layouts->view('enrollments/editView', $this->data);
			}else{
				redirect('enrollmrnts');
			}
		}else{
			redirect('enrollmrnts');
		}
	}

 public function get_customfields_data() {
		$this->load->model('MatriculaDocModel');
         $type = 'enrollments';
        $custom_fields = $this->MatriculaDocModel->getFieldsList($type);
        if(count($custom_fields) > 0){
                
            return $custom_fields;

        }else{
            return false;
        }
       
    }
	public function getNotEnrooledStudents(){
		if($this->input->is_ajax_request()){
			$this->load->model('AlumnoModel');
			$result = $this->AlumnoModel->getNotEnrolledStudnts();
			echo json_encode(array('data' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getCoursesCategories(){
		if($this->input->is_ajax_request()){
			$this->load->model('GrupoModel');
			$group_id = $this->input->post('group_id');
			if(!empty($group_id)) {
				$categories = $this->GrupoModel->getCategories($group_id);
				$courses = $this->GrupoModel->getCoursesByGroup($group_id);
			}
			echo json_encode(array('categoris' => $categories, 'courses' => $courses));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getRates(){
		if($this->input->is_ajax_request()){
			$this->load->model('TarifasTModel');
			$rates = $this->TarifasTModel->getRates();
			echo json_encode(array('data' => $rates));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function addEnroll(){
		if($this->input->is_ajax_request()){
			$this->load->model('Variables2Model');
			$this->load->model('GrupoModel');
			$this->load->model('MatriculatModel');
			$this->load->model('MatriculalModel');
			$this->load->model('TarifasLModel');
			$this->load->model('ReciboModel');
			$this->load->model('AgendaModel');
			$this->load->model('CourseModel');

			$group_id = $this->input->post('group_id', true);
			$studentsData = $this->input->post('studentsData', true);
			$slected_courses = $this->input->post('slected_courses', true);
			$custom_fields = $this->input->post('custom_fields', true);
			$start_date = $this->input->post('start_date', true);
			$end_date = $this->input->post('end_date', true);
			$selected_fees = $this->input->post('selected_fees', true);
			$rate_id = $this->input->post('rate_id', true);
			$categories = $this->GrupoModel->getCategories($group_id);
			$categories = isset($categories[0]) ? $categories[0] : (object)array('category_id' => null, 'category_name' => null, 'start_date' => null, 'end_date' => null);
			$errors = array();
			$result = false;
			if(!empty($studentsData) && !empty($group_id) && !empty($slected_courses)){
				if(is_array($studentsData)){
					foreach($studentsData as $student){
						if($this->Variables2Model->updateEnrollId()) { // 1 query
							$enroll_data = $this->Variables2Model->getEnrollId(); //2 query
							$enroll_id = $enroll_data->enroll_id;
							$student_id = $student['id'];
							$student_data = $this->AlumnoModel->get_student_by_id($student_id);
							$start_date = $this->checkDate($start_date) ? $start_date : $categories->start_date;
							$end_date = $this->checkDate($end_date) ? $end_date : $categories->end_date;
							$category_id = $categories->category_id;
							if (!empty($student_data)) {
								if ($this->MatriculatModel->insertEnroll($enroll_id, $student_id, $category_id, $start_date, $end_date,$custom_fields)) { // 3 query
									$courses_ids_str = '';
									foreach ($slected_courses as $course) {
										$course_id = $course;
										if ($course_id) {
											$courses_ids_str .= "'" . $course_id . "',";
											$this->MatriculalModel->insertEnrollCourses($enroll_id, $group_id, $course_id); //4 query
										}
									}
									if (!empty($courses_ids_str)) {
										$courses_ids_str = trim($courses_ids_str, ',');
										$this->AgendaModel->insertEnroll($student_id, $group_id, $enroll_id, $courses_ids_str, $start_date, $end_date);
									}
									$this->MatriculatModel->insertEvalNotas($group_id, $enroll_id); //5 query
									$this->MatriculatModel->insertEvalNotasParams($group_id, $enroll_id); // 6 query
									$course_data = $this->CourseModel->getCoursesByEnroll($enroll_id);
									$course_data = $course_data[0];
									if (!empty($selected_fees) && is_array($selected_fees)) {
										foreach ($selected_fees as $fee) {
											$fee_data = $this->TarifasLModel->getFees($rate_id, $fee);
											if (!empty($fee_data) && isset($fee_data[0])) {
												$insert_data = (object)array(
													'start_date' => $start_date,
													'end_date' => $end_date,
													'subject' => $fee_data[0]->subject,
													'enroll_id' => $enroll_id,
													'amount' => $fee_data[0]->amount,
													'percentage_fees' => $fee_data[0]->fees,
													'total_fees' => $fee_data[0]->total_fees,
													'total_amount' => $fee_data[0]->total_amount,
													'payment_date' => $fee_data[0]->payment_date,
													'group_id' => $group_id,
													'student_id' => $student_id,
												);
												$this->ReciboModel->insertFees($insert_data); // 7 query
											}
										}
									}
									$replace_data = array(
										'FIRSTNAME' => $student_data->student_first_name,
										'SURNAME' => $student_data->student_last_name,
										'FULLNAME' => $student_data->student_name,
										'PHONE1' => $student_data->student_phone,
										'MOBILE' => $student_data->student_mobile,
										'EMAIL1' => $student_data->student_email,
										'COURSE_NAME' => $course_data->course_name,
										'START_DATE' => date('"F j, Y', strtotime($start_date)),
										'END_DATE' => date('"F j, Y', strtotime($end_date)),
									);

									$this->load->model('ErpEmailsAutomatedModel');
									$template = $this->ErpEmailsAutomatedModel->getByTemplateId('1', array('notify_student' => 1));
									if(!empty($template) && (!empty($student_data->student_email) ||  !empty($student_data->tut1_email1) || !empty($student_data->tut2_email2))){
										$email_subject = replaceTemplateBody($template->Subject, $replace_data);
										$email_body = replaceTemplateBody($template->Body, $replace_data);
										if (!empty($template) && !empty($student_data->student_email)) {
											$this->send_automated_email($student_data->student_email, $email_subject, $email_body, $template->from_email);
										}
										if (!empty($template) && !empty($student_data->tut1_email1)) {
											$this->send_automated_email($student_data->tut1_email1, $email_subject, $email_body, $template->from_email);
										}
										if (!empty($template) && !empty($student_data->tut2_email1)) {
											$this->send_automated_email($student_data->tut2_email1, $email_subject, $email_body, $template->from_email);
										}
									}
									$result = true;

								} else {
									$errors[] = $student['name'] . '  does not enrolled';
								}

							}
						}
					}
				}


			}
			
			echo json_encode(array('result' => $result, 'errors' => $errors));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
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

	private function checkDate($date){
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
		{
			return true;
		}else{
			return false;
		}
	}

	public function delete(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculatModel');
			$enroll_id = $this->input->post('enroll_id', true);
			$result = false;
			if(!empty($enroll_id)) {
				$result = $this->MatriculatModel->deleteEnrollments($enroll_id);
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function changeState(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculatModel');
			$this->load->model('CourseModel');
			$this->load->model('ErpEmailsAutomatedModel');
			$state_ids = array(0, 1, 2, 3, 4);
			$enroll_id = $this->input->post('enroll_id', true);
			$student_id = $this->input->post('student_id', true);
			$state_id = $this->input->post('state_id', true);
			$start_date = $this->input->post('start_date', true);
			$end_date = $this->input->post('end_date', true);
			$result = false;
			$result_email = array();
			if(!empty($enroll_id)) {
				if(!in_array((int)$state_id, $state_ids)){
					$state_id = 0;
				}
				$result = $this->MatriculatModel->updateEnrollmentState($enroll_id,$state_id);
				if($result){
					$this->load->model('ErpEmailsAutomatedModel');
					if($state_id != '0') {
						$template = $this->ErpEmailsAutomatedModel->getByTemplateId('3', array('notify_student' => 1));
					}elseif($state_id != '3'){
						$template = $this->ErpEmailsAutomatedModel->getByTemplateId('4', array('notify_student' => 1));
					}
					$student_data = $this->AlumnoModel->get_student_by_id($student_id);
					$course_data = $this->CourseModel->getCoursesByEnroll($enroll_id);
					$course_data = $course_data[0];
					if(!empty($student_data)) {
						$replace_data = array(
							'FIRSTNAME' => $student_data->student_first_name,
							'SURNAME' => $student_data->student_last_name,
							'FULLNAME' => $student_data->student_name,
							'PHONE1' => $student_data->student_phone,
							'MOBILE' => $student_data->student_mobile,
							'EMAIL1' => $student_data->student_email,
							'COURSE_NAME' => isset($course_data->course_name) ? $course_data->course_name : '',
							'START_DATE' => !empty($start_date) ? date('"F j, Y', strtotime($start_date)) : '',
							'END_DATE' => !empty($end_date) ? date('"F j, Y', strtotime($end_date)) : '',
						);
						if(!empty($template) && (!empty($student_data->student_email) ||  !empty($student_data->tut1_email1) || !empty($student_data->tut2_email2))){
							$email_subject = replaceTemplateBody($template->Subject, $replace_data);
							$email_body = replaceTemplateBody($template->Body, $replace_data);
							if (!empty($template) && !empty($student_data->student_email)) {
								$result_email = $this->send_automated_email($student_data->student_email, $email_subject, $email_body, $template->from_email);
							}
							if (!empty($template) && !empty($student_data->tut1_email1)) {
								$result_email = $this->send_automated_email($student_data->tut1_email1, $email_subject, $email_body, $template->from_email);
							}
							if (!empty($template) && !empty($student_data->tut2_email1)) {
								$result_email = $this->send_automated_email($student_data->tut2_email1, $email_subject, $email_body, $template->from_email);
							}
						}
					}
				}

			}
			echo json_encode(array('success' => $result, 'result_email' => $result_email));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getEnrolledStudents(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculalModel');
			$group_id = $this->input->post('group_id', true);
			$result = array();
			if(!empty($group_id)) {
				$result = $this->MatriculalModel->getEnrolledStudents($group_id);
				$not_enrolled_students = $this->AlumnoModel->getNotEnrolledStudntsByCourse($group_id);
			}
			echo json_encode(array('data' => $result, 'not_enrolled_students' => $not_enrolled_students));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function filterBytags(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculatModel');
			$selected_courses = $this->input->post('selected_courses', true);
			$selected_state = $this->input->post('selected_state', true);
			$selected_groups = $this->input->post('selected_groups', true);
			$selected_names = $this->input->post('selected_names', true);

			$this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsByTags($selected_courses, $selected_state, $selected_groups, $selected_names);
            $html = $this->load->view('enrollments/filtringTableView', $this->data, true);
			echo json_encode(array('html' => $html));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Courses Start
	public function getNotExistCourses(){
		if($this->input->is_ajax_request()) {
			$id = $this->input->post('id', true);
			$exist_ids = $this->MatriculalModel->getExistCourses($id);
			$exist_data = array();
			if(!empty($exist_ids)){
				foreach($exist_ids as $exist){
					$exist_data[] = $exist->id;
				}
			}
			$courses = $this->MatriculalModel->getNotExistCourses($exist_data);
			echo json_encode(array('data' => $courses));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function saveCoursesData(){
		if($this->input->is_ajax_request()){
			$this->load->model('CourseModel');
			$data = array(
				'success' => false,
				'error' => ''
			);
			$enroll_id = $this->input->post('enroll_id', true);
			$course_ids = $this->input->post('course_ids', true);
			$this->load->model('MatriculatModel');
			$check_id = $enroll_id ? $this->MatriculatModel->getEnrollById($enroll_id) : null;
			if(!empty($check_id) && !empty($course_ids)) {
				$checked_course_ids = $this->CourseModel->getCourseIds($course_ids);
				if (!empty($checked_course_ids)) {
					foreach ($checked_course_ids as $course_id) {
						$insert_data[] = array('NumMatricula' => $enroll_id, 'codigocurso' => $course_id->codigo, 'Descripcion' => $course_id->Course);
					}
					if ($this->MatriculalModel->insertCourses($insert_data)) {
						$data['success'] = true;
						$data['insert_data'] = $checked_course_ids;
					} 
				}
			}
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteCourse(){
		if($this->input->is_ajax_request()){
			$data = array(
				'success' => false,
				'error' => ''
			);
			$enroll_id = $this->input->post('enroll_id', true);
			$course_id = $this->input->post('course_id', true);
			$check_id = $enroll_id ? $this->MatriculalModel->getEnrollById($enroll_id) : null;
			if(!empty($check_id)){
				if($this->MatriculalModel->deleteCourse(array('NumMatricula' => $enroll_id, 'codigocurso' => $course_id))) {
					$data['success'] = true;
				}
			}
			echo json_encode($data);
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Courses End
	// Calendar Start
	public function getCalendar(){
		if($this->input->is_ajax_request()){
			$this->load->model('AgendaModel');
			$enroll_id = $this->input->post('enroll_id', true);
			$result = array();
			if($enroll_id){
				$result = $this->AgendaModel->getEnrollCalendar($enroll_id);
			}

			echo json_encode(array('data' => $result));
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// Calendar End

	private function get_personalized_data($id = null) {
		$result_data = array();
		$personalized_data = array();
		if($id) {
			$personalized_data = (array)$this->AlumnoTabAdModel->getBystudentId($id);
		}

		$personalized_fields = $this->AlumnoTabAdModel->getFieldList();

		if(count($personalized_fields) > 1){
			foreach($personalized_fields as $fields) {
				if (!$fields->primary_key){
					switch ($fields->type) {
						case "longtext":
							$type = "textarea";
							break;
						case "date":
							$type = "date";
							break;
						default:
							$type = "text";
					}
					$result_data[] = (object)array(
						'name' => $fields->name,
						'type' => $type,
						'value' => isset($personalized_data[$fields->name]) ? $personalized_data[$fields->name] : ''

					);
				}
			}
		}
		return $result_data;
	}

	//Documents Starat
	public function getDocuments(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculaDocModel');
			$enroll_id = (int)$this->input->post('enroll_id', true);
			$documents = array();
			if($enroll_id) {
				$documents = $this->MatriculaDocModel->getByEnrollId($enroll_id);

			}

			echo json_encode(array('data' => $documents));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function changeDocumentVisible(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculaDocModel');
			$enroll_id = (int)$this->input->post('enroll_id', true);
			$document_id = (int)$this->input->post('document_id', true);
			$visible = (int)$this->input->post('visible', true);
			if($enroll_id) {
				$_visible = $visible == '1' ? 1 : 0;
				$this->MatriculaDocModel->update('matricula_doc', array('visible' => $_visible), array('nummatricula' => $enroll_id, 'id' => $document_id));

			}

			echo json_encode(array('success' => true));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function downloadDoc($student_id = null, $fid=null){
		if(!empty($fid) && !empty($student_id)){
			$result = (array)$this->DocumentModel->student_download($student_id,$fid);
			$docname=str_replace(" ","_",$result['documento']);
			header ("Content-Disposition: attachment; filename=".$docname." ");
			header ("Content-Type: application/octet-stream");
			header ("Content-Length: ".$result['blob']);
			echo $result['docblob'];
			exit();
		}
	}

	//Documents End


	//Follow Up Start

	public function getFollowUp(){
		if($this->input->is_ajax_request()){
			$this->load->model('AlumnosSeguiModel');
			$student_id = (int)$this->input->post('student_id', true);
			$follow_up = array();
			if($student_id){
				$follow_up = $this->AlumnosSeguiModel->getByStudentId($student_id);
			}

			echo json_encode(array('data' => $follow_up));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function saveFollowUp(){
		if($this->input->is_ajax_request()){
			$this->load->model('AlumnosSeguiModel');
			$result = false;
			$last_id = false;

			$student_id = (int)$this->input->post('student_id', true);
			$follow_up_id = (int)$this->input->post('follow_up_id', true);
			$title = $this->input->post('title', true);
			$date = $this->validateDate($this->input->post('date', true)) ? $this->input->post('date', true) : date('Y-m-d') ;

			$comment = $this->input->post('comment', true);
			if($student_id && $title){
				if($follow_up_id){
					$follow_up_data = $this->AlumnosSeguiModel->getFolloUpById($follow_up_id, $student_id);
					if(!empty($follow_up_data)){
						$update_data = array(
							'fecha' => $date,
							'titulo' => $title,
							'comentarios' => $comment,
							'id_user' => $this->user_id,
						);
						$result = $this->AlumnosSeguiModel->updateFollowUp($follow_up_id, $update_data);
					}
				}else{
					$insert_data = array(
						'ccodcli' => $student_id,
						'fecha' => $date,
						'titulo' => $title,
						'comentarios' => $comment,
						'id_user' => $this->user_id,
					);
					$last_id = $this->AlumnosSeguiModel->insertFollowUp($insert_data);
					if($last_id){
						$result = true;
					}
				}
			}

			echo json_encode(array('success' => $result, 'id' => $last_id));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteFollowUp(){
		if($this->input->is_ajax_request()){
			$this->load->model('AlumnosSeguiModel');
			$result = false;
			$follow_up_id = (int)$this->input->post('follow_up_id', true);
			if($follow_up_id){
				$result = $this->AlumnosSeguiModel->deleteFollowUp($follow_up_id);
			}

			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}



	//Quotes Start
	public function getQuotes(){
		if($this->input->is_ajax_request()){
			$this->load->model('ReciboModel');
			$enroll_id = (int)$this->input->post('enroll_id', true);
			$quotes = array();
			if($enroll_id){
				$quotes = $this->ReciboModel->getListByEnrollId($enroll_id);
			}

			echo json_encode(array('data' => $quotes));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function cashQuotes(){
		if($this->input->is_ajax_request()){
			$this->load->model('CajasModel');
			$this->load->model('ReciboModel');
			$enroll_id = $this->input->post('enroll_id', true);
			$quote_id = $this->input->post('quote_id', true);
//			$amount = $this->input->post('amount', true);
//			$amount_due = $this->input->post('amount_due', true);
			$payment_method = $this->input->post('payment_type', true) ? $this->input->post('payment_type', true) : 0;
			$history_date = $this->input->post('history_date', true);
			$cash_id = '';
			if($history_date) {
				$search_date = date('Y-m-d H:i:s', strtotime($history_date));
				$cash_id_obj = $this->CajasModel->getDailyCashByDate($search_date);
				if (!empty($cash_id_obj)) {
					$cash_id = $cash_id_obj->cash_id;

				}
			}
			$memo = $this->input->post('memo', true);
			$update_data = array();
			$new_data = false;
			$result = false;
			$last_id = false;
			if($enroll_id && $quote_id ){
				    $update_data['ESTADO'] = '1';
					$update_data['ID_FP'] = $payment_method;
					$update_data['memo'] = $memo;
				if($cash_id){
					$update_data['IdCaja'] = $cash_id;
				}
					$result = $this->ReciboModel->updateQuotes($quote_id, $enroll_id, $update_data, $cash_id);
					$last_id = $quote_id;
//				f($enroll_id && $quote_id && $amount_due >= $amount){
//
//				if($amount_due ==  $amount){
//					$update_data['ESTADO'] = '1';
//					$update_data['ID_FP'] = $payment_method;
//					$update_data['memo'] = $memo;
//					$result = $this->ReciboModel->updateQuotes($quote_id, $enroll_id, $update_data);
//					$last_id = $quote_id;
//
//				}else{
//					$qoute_data = $this->ReciboModel->getQuoteById($enroll_id, $quote_id);
//					if(!empty($qoute_data)){
//						$insert_data = $qoute_data;
//						unset($insert_data->NUM_RECIBO);
//
//						$insert_data->IMPORTE = $amount;
//						$insert_data->ESTADO = '1';
//						$insert_data->FECHA_VTO = date('Y-m-d H:i:s');
//						$update_data['importe'] = $amount_due - $amount;
//						if($this->ReciboModel->updateQuotes($quote_id, $enroll_id, $update_data, $payment_method)){
//							$last_id = $this->ReciboModel->insertQuote((array)$insert_data);
//							$result = true;
//						}
//					}

//				}
				if($result){
					if(!empty($history_date)){
						$history_date = date('Y-m-d H:i:s', strtotime($history_date));
						$this->load->model('RecibosHistoricoModel');
						$insert_data['num_recibo'] = $quote_id;
						$insert_data['fecha'] = $history_date;
						$this->RecibosHistoricoModel->insertItem($insert_data);
					}
					$new_data = $this->ReciboModel->getListByEnrollId($enroll_id);
				}
			}

			echo json_encode(array('success' => $result, 'new_data' => $new_data, 'last_id' => $last_id));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function editQuotes(){
		if($this->input->is_ajax_request()){
			$this->load->model('ReciboModel');
			$enroll_id = (int)$this->input->post('enroll_id', true);
			$quote_id = $this->input->post('quote_id', true);
			$value = $this->input->post('value', true);
			$name_of_input = $this->input->post('name_of_input', true);
			$update_data = array();
			$error = '';
			$result = false;
			if($name_of_input == 'appointment_date_edit'){
				if($this->validateDate($value)){
					$update_data['fecha_vto'] = date('Y-m-d H:i:s', strtotime($value));
				}else{
					$error = $this->lang->line('quotes_date_is_not_valid');
				}
			}

			if($name_of_input == 'amount_edit'){
				if(preg_match('/^[0-9]{1,7}(?:\.[0-9]{1,2})?$/',$value)){
					$update_data['importe'] = $value;
				}else{
					$error = $this->lang->line('quotes_amount_is_not_valid');
				}
			}
			if($name_of_input == 'payment_type_edit'){
				if($value){
					$update_data['id_fp'] = $value;
				}else{
					$error = $this->lang->line('quotes_payment_type_is_not_valid');
				}
			}

			if(!empty($update_data) && $quote_id){
				$result = $this->ReciboModel->updateQuotes($quote_id,$enroll_id, $update_data);
			}
			echo json_encode(array('error' => $error, 'success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private function check_linked_invoices($quote_ids = null){
		if(empty($quote_ids)){
			return false;
		}
		return $this->ReciboModel->check_linked_invoice($quote_ids);
	}
	
	public function add_free_quote(){

		$response['success'] = false;
		$response['errors'] = array();
		$response['_html'] = '';
		if($this->input->is_ajax_request()){
			$this->data['student_id'] = $this->input->post('student_id', true);
			$this->data['enroll_id'] = $this->input->post('enroll_id', true);
			
			$this->data['payment_type'][0] = $this->lang->line('quotes_cash');
			$this->data['payment_type'][1] = $this->lang->line('quotes_credit_card');
			$this->data['payment_type'][2] = $this->lang->line('quotes_direct_debit');
			$this->data['payment_type'][3] = $this->lang->line('quotes_transfer');
			$this->data['payment_type'][4] = $this->lang->line('quotes_check');
			$this->data['payment_type'][5] = $this->lang->line('quotes_financed');
			$this->data['payment_type'][6] = $this->lang->line('quotes_online_payment');
			
			$response['_html'] = $this->load->view('enrollments/partials/add_free_quote', $this->data, true);
			$response['success'] = true;
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}
		print_r(json_encode($response));
		exit;
	}

	public function add_free_quote_save(){
		$this->load->helper('security');
		$response['success'] = false;
		$response['errors'] = array();
		$response['quotes'] = array();
		if($this->input->is_ajax_request()){
			$appointment_date = $this->input->post('appointment_date', true);
			$amount = $this->input->post('amount', true);
			$number_of_quotes = $this->input->post('number_of_quotes', true);
			$service = $this->input->post('service', true);
			$total = $this->input->post('total', true);
			$payment_type = $this->input->post('payment_type', true);
			$student_id = $this->input->post('student_id', true);
			$enroll_id = $this->input->post('enroll_id', true);
			$porcentaje_impuesto = $this->input->post('discount', true);
			$reference_of_quote = $this->input->post('reference_of_quote', true);
			if($reference_of_quote){
				$reference_validation = 'trim|xss_clean|callback_alpha_dash_space';
			}else{
				$reference_validation = 'trim|xss_clean';
			}
			$interval_array = array('1','2','3','4','6','12');
			$interval_between_quotes = $this->input->post('interval_between_quotes', true);

			$this->config->set_item('language', $this->data['lang']);
			$this->form_validation->set_rules('payment_type', $this->lang->line('quotes_payment_type'), 'trim|required');
			$this->form_validation->set_rules('amount', $this->lang->line('quotes_amount'), 'trim|required|numeric');
			if($this->input->post('discount', true)) {
				$this->form_validation->set_rules('discount', $this->lang->line('quotes_discount_to_apply'), 'trim|numeric');
			}
			$this->form_validation->set_rules('service', $this->lang->line('quotes_service'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('reference_of_quote', $this->lang->line('quotes_reference_of_quote'), $reference_validation);
			$this->form_validation->set_rules('appointment_date', $this->lang->line('quotes_appointment_date'), 'trim|required');
			if ($this->form_validation->run() == false) {
				$response["errors"] = $this->form_validation->error_array();
			} else {
				if($number_of_quotes > 1 && $number_of_quotes < 1000) {
					$interval_quotes = in_array($interval_between_quotes, $interval_array) ? $interval_between_quotes : 1;
					$insert_data = array();
					$date_interval = $appointment_date ? date('Y-m-d H:i:s', strtotime($appointment_date)) : date('Y-m-d H:i:s');
					for ($i = 0; $i < $number_of_quotes; $i++) {
						$insert_data[$i]['fecha_vto'] = $date_interval;
						$insert_data[$i]['n_factura'] = 0;
						$insert_data[$i]['idtipocliente'] = 1;
						$insert_data[$i]['estado'] = 0;
						$insert_data[$i]['fecha_fra'] = date('Y-m-d H:i:s');
						$insert_data[$i]['importe'] = $amount ? $amount : 0;
						$insert_data[$i]['impuesto'] = 0;
						$insert_data[$i]['porcentaje_impuesto'] = 0;
						if ($service) {
							$insert_data[$i]['concepto'] = $service;
						}
						$insert_data[$i]['neto'] = $total ? $total : 0;
						$insert_data[$i]['id_fp'] = $payment_type ? $payment_type : 0;
						if ($reference_of_quote) {
							$insert_data[$i]['referencia'] = $reference_of_quote;
						}
						if ($student_id) {
							$insert_data[$i]['idcliente'] = $student_id;
						}
						if ($enroll_id) {
							$insert_data[$i]['nummatricula'] = $enroll_id;
						}
						$date_interval = date('Y-m-d H:i:s', strtotime("+".$interval_quotes." months", strtotime($date_interval)));
					}
					$inserted = $this->ReciboModel->add_free_quote_Batch($insert_data);
				}else{
					$insert_data = array();
					$insert_data['fecha_vto'] = $appointment_date ? date('Y-m-d H:i:s', strtotime($appointment_date)) : date('Y-m-d H:i:s');;
					if ($amount) {
						$insert_data['neto'] = $amount;
					}
					if ($service) {
						$insert_data['concepto'] = $service;
					}
					if ($total) {
						$insert_data['importe'] = $total;
					}
					if ($payment_type) {
						$insert_data['id_fp'] = $payment_type;
					}
					if ($reference_of_quote) {
						$insert_data['referencia'] = $reference_of_quote;
					}
					if ($student_id) {
						$insert_data['idcliente'] = $student_id;
					}
					if ($enroll_id) {
						$insert_data['nummatricula'] = $enroll_id;
					}
					if($porcentaje_impuesto){
						$insert_data['porcentaje_impuesto'] = $porcentaje_impuesto;
					}
					if($porcentaje_impuesto && $amount){
						$insert_data['impuesto'] = $porcentaje_impuesto*$amount/100;
					}
					$inserted = $this->ReciboModel->add_free_quote($insert_data);
				}
				if($inserted){
					$response['success'] = $this->lang->line('data_success_saved');
					$response['quotes'] = $this->ReciboModel->getListByEnrollId($enroll_id);
				}else{
					$response['errors'][] = $this->lang->line('db_err_msg');
				}
			}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}
		print_r(json_encode($response));
		exit;
	}
	public function edit_free_quote(){
		$this->load->helper('security');
		$response['success'] = false;
		$response['errors'] = array();
		$response['quotes'] = array();
		$edited = false;
		if($this->input->is_ajax_request()){
			$appointment_date = $this->input->post('appointment_date', true);
			$amount = $this->input->post('amount', true);
			$service = $this->input->post('service', true);
			$total = $this->input->post('total', true);
			$payment_type = $this->input->post('payment_type', true);
			$student_id = $this->input->post('student_id', true);
			$enroll_id = $this->input->post('enroll_id', true);
			$porcentaje_impuesto = $this->input->post('discount', true);
			$reference_of_quote = $this->input->post('reference_of_quote', true);
			$quote_id = $this->input->post('quote_id', true);
			if($reference_of_quote){
				$reference_validation = 'trim|xss_clean|callback_alpha_dash_space';
			}else{
				$reference_validation = 'trim|xss_clean';
			}

			$this->config->set_item('language', $this->data['lang']);
			$this->form_validation->set_rules('payment_type', $this->lang->line('quotes_payment_type'), 'trim|required');
			$this->form_validation->set_rules('amount', $this->lang->line('quotes_amount'), 'trim|required|numeric');
			if($this->input->post('discount', true)) {
				$this->form_validation->set_rules('discount', $this->lang->line('quotes_discount_to_apply'), 'trim|numeric');
			}
			$this->form_validation->set_rules('service', $this->lang->line('quotes_service'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('reference_of_quote', $this->lang->line('quotes_reference_of_quote'), $reference_validation);
			$this->form_validation->set_rules('appointment_date', $this->lang->line('quotes_appointment_date'), 'trim|required');
			if ($this->form_validation->run() == false) {
				$response["errors"] = $this->form_validation->error_array();
			} else {
				$edit_data = array();
				$edit_data['fecha_vto'] = $appointment_date ? date('Y-m-d H:i:s', strtotime($appointment_date)) : date('Y-m-d H:i:s');
				if ($amount) {
					$edit_data['neto'] = $amount;
				}
				if ($service) {
					$edit_data['concepto'] = $service;
				}
				if ($total) {
					$edit_data['importe'] = $total;
				}
				if ($payment_type) {
					$edit_data['id_fp'] = $payment_type;
				}
				if ($reference_of_quote) {
					$edit_data['referencia'] = $reference_of_quote;
				}
				if ($student_id) {
					$edit_data['idcliente'] = $student_id;
				}
				if ($enroll_id) {
					$edit_data['nummatricula'] = $enroll_id;
				}
				if($porcentaje_impuesto){
					$edit_data['porcentaje_impuesto'] = $porcentaje_impuesto;
				}
				if($porcentaje_impuesto && $amount){
					$edit_data['impuesto'] = $porcentaje_impuesto*$amount/100;
				}
					$edited = $this->ReciboModel->edit_free_quote($edit_data, $quote_id);
				}
				if($edited){
					$response['success'] = $this->lang->line('data_success_saved');
					$response['quotes'] = $this->ReciboModel->getListByEnrollId($enroll_id);
				}else{
					$response['errors'][] = $this->lang->line('db_err_msg');
				}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}
		print_r(json_encode($response));
		exit;
	}


	public function add_from_rates(){

		$response['success'] = false;
		$response['errors'] = array();
		$response['_html'] = '';
		if($this->input->is_ajax_request()){
			$this->data['student_id'] = $this->input->post('student_id', true);
			$this->data['enroll_id'] = $this->input->post('enroll_id', true);
			$this->load->model('TarifasTModel');
			$this->data['rates'] = $this->TarifasTModel->getRates();
			$response['_html'] = $this->load->view('enrollments/partials/add_from_rates', $this->data, true);
			$response['success'] = true;
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}
		print_r(json_encode($response));
		exit;
	}

	public function add_from_rates_save(){

		$response['success'] = false;
		$response['errors'] = array();
		$response['quotes'] = array();
		if($this->input->is_ajax_request()){
			$rate_id = $this->input->post('rate_id', true);
			$student_id = $this->input->post('student_id', true);
			$enroll_id = $this->input->post('enroll_id', true);
			$selected_fees = $this->input->post('selected_fees_ids', true);
			if (!empty($selected_fees) && is_array($selected_fees)) {
				$this->load->model('TarifasLModel');
				$start_date = null;
				$end_date = null;
				$this->load->model('MatriculatModel');
				$enrollment = $this->MatriculatModel->getEnrollmentsList(array(
					"student_id"=>$student_id,
					"enroll_id"=>$enroll_id
				));
				if(isset($enrollment[0]) && !empty($enrollment[0])){
					$enrollment = $enrollment[0];
					$start_date = isset($enrollment->start_date) ? $enrollment->start_date : null;
					$end_date = isset($enrollment->end_date) ? $enrollment->end_date : null;
				}
				$this->load->model('MatriculalModel');
				$group_id = $this->MatriculalModel->getGroupIdByEnrollId($enroll_id);
				$group_id = (!empty($group_id) && isset($group_id->idgrupo)) ? $group_id->idgrupo : null;

				foreach ($selected_fees as $fee) {
					$fee_data = $this->TarifasLModel->getFees($rate_id, $fee);					
					if (!empty($fee_data) && isset($fee_data[0])) {
						$insert_data = (object)array(
							'start_date' => $start_date,
							'end_date' => $end_date,
							'subject' => $fee_data[0]->subject,
							'enroll_id' => $enroll_id,
							'amount' => $fee_data[0]->amount,
							'percentage_fees' => $fee_data[0]->fees,
							'total_fees' => $fee_data[0]->total_fees,
							'total_amount' => $fee_data[0]->total_amount,
							'payment_date' => $fee_data[0]->payment_date,
							'group_id' => $group_id,
							'student_id' => $student_id,
						);
						$this->ReciboModel->insertFees($insert_data); // 7 query
					}
				}
				$response['success'] = $this->lang->line('data_success_saved');
				$response['quotes'] = $this->ReciboModel->getListByEnrollId($enroll_id);
			}else{
				$response['errors'][] = $this->lang->line('db_err_msg');
			}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}
		print_r(json_encode($response));
		exit;
	}
	

	public function alpha_dash_space($str_in = '')
	{
		if (! preg_match("/^([-a-z0-9_ ])+$/i", $str_in))
		{
			$this->form_validation->set_message('_alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function quotes_bulk_operation() {

		$response['success'] = false;
		$response['errors'] = array();
		$response['deleted_ids'] = array();
		if ($this->input->post()) {
			$ids = $this->input->post('ids', true);
			$action = $this->input->post('action', true);

			switch ($action) {
				case 'delete':

					if(!empty($ids) && is_array($ids)){
						foreach ($ids as $doc_id){
							$checked = $this->check_linked_invoices(array($doc_id));
							if(isset($checked[0]) && isset($checked[0]->num)){
								if($checked[0]->num == 0){// there are not invoices
									$delete_receipt = $this->ReciboModel->delete_item($doc_id);
									if($delete_receipt){
										$response['deleted_ids'][] = $doc_id;
									}else{
										if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
											$response['errors'][] = $this->lang->line('db_err_msg');
										}
									}
								}else if($checked[0]->num == 1){//there are invoices
									if(!in_array($this->lang->line('quotes_receipt_has_linked_delete'), $response['errors'])){
										$response['errors'][] = $this->lang->line('quotes_receipt_has_linked_delete');
									}
								}else{
									if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
										$response['errors'][] = $this->lang->line('db_err_msg');
									}
								}
							}else{
								if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
									$response['errors'][] = $this->lang->line('db_err_msg');
								}
							}
						}
						if(!empty($response['deleted_ids'])){
							$response['success'] = $this->lang->line('quotes_receipt_deleted');
						}
					}else{
						if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
							$response['errors'][] = $this->lang->line('db_err_msg');
						}
					}
					break;
				default:
					if(!in_array($this->lang->line('db_err_msg'), $response['errors'])){
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
			}
		}
		echo json_encode($response);
		exit;
	}
	//Quotes end

	private function validateDate($date){
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') == $date;
	}

	//Follow Up End

	public function html_to_Pdf($enroll_id = null, $quote_id = null){
		//if($enroll_id && $quote_id) {
		$qoute_data = $this->ReciboModel->getQuoteById($enroll_id, $quote_id);
		$this->data['quote'] = $qoute_data;
		$this->html_pdf = $this->load->view('enrollments/partials/print_to_pdf', $this->data, true);

		$file_name = 'Cashed-qoute';
		$mpdf = new mPDF('utf-8', 'A4', '', '', 0, 0, 0, 0, 0, 0);
		$mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list

		$mpdf->WriteHTML($this->html_pdf);
		$this->html_pdf = false;
		$mpdf->Output($file_name . '.pdf', 'D');

		//}
	}

	public function html_to_Pdf_new($enroll_id = null, $quote_id = null){
		$receipt = $this->ReciboModel->getQuotesDataPrint($quote_id);
		$this->lang->load('manage_invoice', $this->data['lang']);
		$this->data['quote'] = $receipt;
		$this->load->model('MiempresaModel');
		$this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();
		//$scholl_name = $this->MiempresaModel->selectCustom("SELECT nombrecomercial AS company_name FROM miempresa");
		//$scholl_name = isset($scholl_name[0]->company_name) ? $scholl_name[0]->company_name : '';
		if ($this->_db_details->plan != '1') {
			$this->load->model('Variables2Model');
			$logo = $this->Variables2Model->get_logo();
			$this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
		}else{
			$this->data['logo'] = '';
		}
		$this->data['payment_methods'] = array(
			0 => $this->lang->line('quotes_cash'),
			1 => $this->lang->line('quotes_credit_card'),
			2 => $this->lang->line('quotes_direct_debit'),
			3 => $this->lang->line('quotes_transfer'),
			4 => $this->lang->line('quotes_check'),
			5 => $this->lang->line('quotes_financed'),
			6 => $this->lang->line('quotes_online_payment')
		);
		if(!empty($this->data['quote'])) {
			$this->html_pdf = $this->load->view('quotes/partials/print_individual_quote', $this->data, true);
			$file_name = 'Cashed-qoute';
			$mpdf = new mPDF('utf-8', 'A4', '', '', 0, 0, 0, 0, 0, 0);
			$mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list

			//$mpdf->WriteHTML($this->html_pdf);
			//$this->html_pdf = false;
			// LOAD a stylesheet
			$stylesheet = file_get_contents('assets/global/plugins/font-awesome/css/font-awesome.min.css');
			$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet = file_get_contents('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/global/plugins/bootstrap/css/bootstrap.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/global/css/components.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/global/css/plugins.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/pages/css/invoice.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/layouts/layout3/css/layout.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/layouts/layout3/css/themes/default.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/layouts/layout3/css/custom.min.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents('assets/layouts/layout3/css/custom.min.css');
			$mpdf->WriteHTML($stylesheet, 1);


			$mpdf->WriteHTML($this->html_pdf);
			$mpdf->Output($file_name . '.pdf', 'D');

		}
	}
	

	// Add PAST GROUP

	public function getPastGroups(){
		if($this->input->is_ajax_request()){
			$this->load->model('GrupoModel');
			$current_group_id = $this->input->post('group_id', true);
			$groups = array();
			if($current_group_id){
				$groups = $this->GrupoModel->getPastGroups($current_group_id);
			}
			echo json_encode(array('groups' => $groups));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function getStudentsFromPastGroup(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculalModel');
			$current_group_id = $this->input->post('current_group_id', true);
			$past_group_id = $this->input->post('past_group_id', true);
			$students = array();
			if($current_group_id && $past_group_id){
				$students = $this->MatriculalModel->getPastStudents($past_group_id, $current_group_id);
			}
			echo json_encode(array('students' => $students));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	// tagging

	public function add_tags(){  // this is old version not used
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculaTagsModel');
			$this->load->model('ErpTagsModel');
			$enroll_id= $this->input->post('enroll_id', true);
			$tags_ids = $this->input->post('tag_ids', true);
			$result = false;
			$tags_not_added = array();
			$enroll_tags = array();
			if($enroll_id && $tags_ids){
				$tags_ids_array = explode(',', $tags_ids);
				if(!empty($tags_ids_array)) {
					$checking_ids = $this->ErpTagsModel->getNotExistTags($tags_ids_array, $enroll_id, 'matricula_tags', 'nummatricula'); // matricula_tags is table name  and nummatricula is foreign key column name
					$insert_data = array();
					if(!empty($checking_ids)) {
						foreach ($checking_ids as $tag) {
							if(empty($tag->current_table_tag_id) && empty($tag->nummatricula)) {
								$insert_data[] = array('nummatricula' => $enroll_id, 'id_tag' => $tag->tag_id);
							}
						}
					}
					$result = $this->MatriculaTagsModel->insertBatch($insert_data);
				}
				if($result) {
					$enroll_tags = $this->MatriculaTagsModel->getTags($enroll_id);
					$where_not_in = "SELECT id_tag FROM matricula_tags WHERE nummatricula ='".$enroll_id."'";
					$tags_not_added = $this->ErpTagsModel->getTagsForfilterBytable($where_not_in);
				}
			}
			echo json_encode(array('result' => $result, 'tags' => $tags_not_added, 'enroll_tags' => $enroll_tags));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function update_tags(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculaTagsModel');
			$this->load->model('ErpTagsModel');
			$enroll_id= $this->input->post('enroll_id', true);
			$tags_ids = $this->input->post('value', true);
			$tags_ids = trim($tags_ids, ',');
			$result = false;
			$tags_ids_array = array();
			if($enroll_id){
				$tags_ids_array = explode(',', $tags_ids);
				$this->MatriculaTagsModel->deleteAllItems($enroll_id);

				if (!empty($tags_ids_array)) {
					$checking_ids = $this->ErpTagsModel->getNotExistTags($tags_ids_array, $enroll_id, 'matricula_tags', 'nummatricula'); // matricula_tags is table name  and nummatricula is foreign key column name
					$insert_data = array();
					if (!empty($checking_ids)) {
						foreach ($checking_ids as $tag) {
							if (empty($tag->current_table_tag_id) && empty($tag->nummatricula)) {
								$insert_data[] = array('nummatricula' => $enroll_id, 'id_tag' => $tag->tag_id);
							}
						}
					}
					$result = $this->MatriculaTagsModel->insertBatch($insert_data);
				}

			}
			echo json_encode(array('result' => $result, 'tag_ids' => $tags_ids_array));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function deleteTag(){ // this is old version not used
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculaTagsModel');
			$this->load->model('ErpTagsModel');
			$enroll_id = $this->input->post('enroll_id', true);
			$tag_id = $this->input->post('tag_id', true);
			$result = false;
			$tags_not_added = array();
			if($enroll_id && $tag_id){
				$result = $this->MatriculaTagsModel->deleteItem($enroll_id, $tag_id);
				$where_not_in = "SELECT id_tag FROM matricula_tags WHERE nummatricula ='".$enroll_id."'";
				$tags_not_added = $this->ErpTagsModel->getTagsForfilterBytable($where_not_in);
			}
			echo json_encode(array('success' => $result, 'tags' => $tags_not_added));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function getTemplates(){
		$this->load->model('LstPlantillasCatModel');
		$this->load->model('TemplateModel');

		if($this->input->is_ajax_request()){
			$enr_id = $this->input->post('enr_id', true);
			if(!empty($enr_id)) {
				$plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre('Matrículas');
				$id_cat = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "1";
				$document_cat = $this->TemplateModel->getAllUsersTemplates($id_cat);//$this->get_documentos($this->data['id_cat']);
			}
			echo json_encode(array('templates'=>$document_cat, 'cat_id'=>$id_cat));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function getCourses(){
		if($this->input->is_ajax_request()){
			$this->load->model('GruposlModel');
			$courses = false;
			$group_id = $this->input->post('group_id', true);
			if(!empty($group_id)) {
				$courses = $this->GruposlModel->getCoursesByGroupEnroll($group_id);
			}
			echo json_encode(array('courses' => $courses));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
/**
 * @property TaskModel $TaskModel
 * @property ProfesorModel $ProfesorModel
 */
class Attendance extends MY_controller {


	 public function __construct(){
		parent::__construct();
		 $this->load->model('ProfesorModel');
		 $this->load->model('MatriculalModel');
		 $this->load->model('AgendaModel');

	 	if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
//		$this->layouts->add_includes('js', 'app/js/home/main.js');
		 $this->layout = 'attendance';
	}
	
	public function index(){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->load->model('MatriculalModel');
		$this->layouts->add_includes('css', 'assets/global/plugins/typeahead/typeahead.css');
		$this->layouts->add_includes('css', 'assets/global/plugins/typeahead/custom.css');
//		$this->layouts->add_includes('css', 'app/css/campus/style.css');
		$this->layouts->add_includes('js', 'assets/global/plugins/typeahead/handlebars.min.js');
		$this->layouts->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.js');
		$this->layouts->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js');
		$this->layouts->add_includes('js', 'assets/global/plugins/typeahead/typeahead.bundle.min.js');
		$this->layouts->add_includes('js', 'app/js/attendance/index.js');


		$teachers	= $this->ProfesorModel->getTeachersForAttendance();
		$new_teachers = array();
		foreach($teachers as $teacher){
			$new_teachers[] = array('name' => $teacher->teacher_name, 'ID' => $teacher->teacherid);
		}
		$this->data['teachers'] = $new_teachers;
		$this->data['all_courses'] = $this->MatriculalModel->getAllCourses();
		$this->layouts->view('attendance/index', $this->data, $this->layout);

	}

	public function getTeacherCourses(){
		if($this->input->post()){
			$trecher_id = $this->input->post('teacher_id', true);
			if($trecher_id) {
				$courses = $this->MatriculalModel->sa_courses_assigned('teacher', $trecher_id);
			}else{
				$courses = $this->MatriculalModel->getAllCourses();
			}
			echo json_encode(array('data' => $courses));
			exit;
		}
	}

	public function get_course_type_select(){
		$course_type_select = '<script>
						$(function() {
							if (isFirefox) {
								$("select").addClass(\'for_mozilla\');
							}
						});
					</script>
					<div class="form-group">
					<label for="optval">'.$this->lang->line("_type").':</label>
					<div class="circle_select_div"><select name="optval" id="optval" class=" form-control">
						<option>--'.$this->lang->line("attendance_select_type").'--</option>
						<option value="1">'. $this->lang->line("group").'</option>
						<option value="2">'. $this->lang->line("tutorials").'</option>
					</select></div></div>';
		print_r(json_encode($course_type_select));
		exit;
	}

	public function sa_groups(){
		$sa_groups = array();
		if($this->input->post(null, true)){
			$this->load->model('GruposlModel');
			$course_id = $this->input->post('course_id', true);
			$teacher_id = $this->input->post('teacher_id', true);
			$optval = $this->input->post('optval', true);
			if($optval == 1){ //group
				$sa_groups = $this->GruposlModel->sa_groups($course_id, $teacher_id);
			}elseif($optval == 2){ //individual

			}elseif($optval == 3){ //all_types

			}
		}
		$course_type_type_select = '';
		if(!empty($sa_groups)) {

			$course_type_type_select = '
					<script>
						$(function() {
							if (isFirefox) {
								$("select").addClass(\'for_mozilla\');
							}
						});
					</script>
					<label for="groupid">' . $this->lang->line("group") . ':</label>
						<div class="circle_select_div"><select name="groupid" id="groupid" class="form-control ">
							<option>--' . $this->lang->line('attendance_select_group') . '--</option>';
			foreach ($sa_groups as $group) {
				$course_type_type_select .= '<option value="' . $group->Idgrupo . '">' . $group->grupo . '</option>';
			}
			$course_type_type_select .= '</select></div>';
		}
		print_r(json_encode($course_type_type_select));
		exit;
	}

	public function sa_dates(){
		$str = array();
		if($this->input->post(null, true)){
			$this->load->model('GruposlModel');
			$course_id = $this->input->post('course_id', true);
			$optval = $this->input->post('optval', true);
			$group_id = $this->input->post('group_id', true);
			$teacher_id = $this->input->post('teacher_id', true);

			if(($group_id == "0") || ($group_id == "")) { //individual
				$dates = $this->AgendaModel->sa_class_dates($course_id, $teacher_id);
			}else{ //group
				$this->load->model('AgendaGrupoModel');
				$dates = $this->AgendaGrupoModel->sa_class_dates($group_id, $course_id, $teacher_id);
			}

			if($dates){
				foreach($dates as $date){
					$str[] = convert_date($date->FECHA, 'Y-m-d H:i:s', 'j-n-Y');
				}
			}
		}
		print_r(json_encode($str));
		exit;
	}
	public function sa_hours(){
		$resultado = '';
		$str = array();
		if($this->input->post(null, true)){
			$course_id = $this->input->post('course_id', true);
			$optval = $this->input->post('optval', true);
			$group_id = $this->input->post('group_id', true);
			$date = $this->input->post('date', true);
			$teacher_id = $this->input->post('teacher_id', true);

			$dt = $date;
			if($this->data['lang'] == "spanish"){
				$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
			}
			$res = $this->AgendaModel->sa_franja_horaria($group_id, $course_id, $dt, $teacher_id);

			$i=0;
			foreach($res as $rs){
				$inicio = $rs->INICIO;
				$fin = $rs->FIN;
				$i++;
			}
			if($i>1){
				$resultado = 1;
			}else{
				$resultado = 0;
			}
			$str['horario'] = $resultado;
		}

		print_r(json_encode($str));
		exit;
	}

	public function sa_attendees(){
		$form_html = '';
		if($this->input->post(null, true)){
			$course_id = $this->input->post('course_id', true);
			$optval = $this->input->post('optval', true);
			$group_id = $this->input->post('group_id', true);
			$date = $this->input->post('date', true);
			$option = $this->input->post('option', true);
			$ini = $this->input->post('ini', true);
			$teacher_id = $this->input->post('teacher_id', true);

			$dt = $date;
			if($this->data['lang'] == "spanish"){
				$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
			}

			if($option == 0){
				$attendees = $this->AgendaModel->sa_attendees($course_id, $group_id, $dt, $teacher_id);
			}else if($option == 1){
				$attendees = $this->AgendaModel->sa_attendees2($course_id, $group_id, $dt, $teacher_id, $ini);
			}

			if(isset($attendees) && !empty($attendees)){
				$form_html = '<form action="" method="post" name="form-atendance" id="form-atendance">';
				$j = 1;

				//$user_role = $this->session->userdata('user_role');
				foreach ($attendees as $attendee) {

					$form_html .= '<div class="row ts_item for_list_border_colors">
 													<div class="btn-group inline" id="'.$attendee->IdAlumno .'">
														<div class="btn-group inline attendance_list_setting_icon pull-right">
															<i class="fa fa-cog"></i>
														</div>

													</div>';


					//if ($user_role == 2) {
						$this->load->model('AlumnoModel');
						$photo = $this->AlumnoModel->getPhotoLink($attendee->IdAlumno);

					/*} elseif ($user_role == 1) {
						$this->load->model('ProfesorModel');
						$photo = $this->ProfesorModel->getPhoto($attendee->IdAlumno);
					}*/
					$img_src = base_url()."assets/img/dummy-image.jpg";
					if(isset($photo->photo_link) && !empty($photo->photo_link)){
						$img_src = $photo->photo_link;
					}

					if($attendee->IdEstado == '2'){
						$select_2 = 'selected="selected"';
					}else{
						$select_2 = '';
					}

					if($attendee->IdEstado == '1'){
						$select_1 = 'selected="selected"';
					}else{
						$select_1 = '';
					}

					if($attendee->IdEstado == '3'){
						$select_3 = 'selected="selected"';
					}else{
						$select_3 = '';
					}

					if($attendee->IdEstado == '4'){
						$select_4 = 'selected="selected"';
					}else{
						$select_4 = '';
					}

					$form_html .= '<div class="col-sm-6 ts_info">
											<div class="row">
												<div class="col-xs-4 text-center attendance_user_img">
													<img src="'.$img_src.'" alt="">
												</div>
												<div class="col-xs-8 ts_info_text text-left">
													<div class="text-primary ts_info_name">'.$attendee->sApellidos.' '. $attendee->sNombre . '</div>
													<div class="number_attendance_list">'.$attendee->phone_numbers.'</div>
													<div class="email_list"><span>'.$attendee->emails.'</span></div>
													<div id="students_list_select" class="circle_select_div margin-bottom-10">
													<script>
														$(function() {
															if (isFirefox) {
																$("select").addClass(\'for_mozilla\');
															}
														});
													</script>
													<select name="state_'.$attendee->IdAlumno.'" class="select_state width_auto  form-control">
														<option value="">--'.$this->lang->line('attendance_select_state').'--</option>
														<option value="2" '.$select_2.'>'.$this->lang->line('attendance_present').'</option>
														<option value="1" '.$select_1.'>'.$this->lang->line('attendance_delay').'</option>
														<option value="3" '.$select_3.'>'.$this->lang->line('attendance_absent').'</option>
														<option value="4" '.$select_4.'>'.$this->lang->line('attendance_justified').'</option>
													</select>
													</div>
												</div>
											</div>
                                    	</div>';


					$form_html .= '<div class="col-sm-6">';
					$form_html .= '<div class="row">
									<div class=" attendance_user_img_sim text-left col-xs-4 margin-top-10">
									</div>
												<div class="the-basics col-sm-10 text-left col-xs-8">';
					$form_html .= '<div>'.$this->lang->line('date').' : <span>'.date($this->data['datepicker_format'], strtotime($attendee->FECHA)).'</span></div>';

					//								$form_html .= '<p><strong>Ausencias:</strong>'.$attendee->Ausente.'</p>';
					$form_html .= '<div>'.$this->lang->line('interval').' : <span>'.$attendee->Time_Interval.'</span></div>';
					if(isset($attendee->curso)){
						$form_html .= '<div>'.$this->lang->line('course').' : <span>'.$attendee->curso.'</span></div>';
					}
					if(!empty($group_id)){
						$form_html .= '<div>'.$this->lang->line('group').' : <span> '. $attendee->grupo .'</span> </div>';
					}else{
						$form_html .= '<div>'.$this->lang->line('tutorial').'</div>';
					}
					if($attendee->ml_IdEstado != 0 && $attendee->ml_IdEstado != 1){
						if ('' != trim($attendee->estmat)){
							$form_html .= '<div class="edit-note"><a href="#" class="edit"><img
												src="'.base_url().'/images/alerta.png" class="ttip"
												title="'. $attendee->estmat .'" width="64px" height="64px"
												onclick="return false;"/></a>
												</div>';
						}else{
							$form_html .= '<div class="edit-note"></div>';
						}
					}
					$form_html .=	'</div>
												<div class="col-sm-2">

												</div>
											</div>';
					$form_html .= '</div>';

					$form_html .= '</div><hr>';
					$j++;
				}
				$form_html .= '<input id="courseid1" name="courseid1" value="'.$course_id.'" type="hidden">
								<input id="groupid1" name="groupid1" value="'.$group_id.'" type="hidden">
								<input id="date1" name="date1" value="'.$dt.'" type="hidden">';
				$form_html .=  '<div class="text-left"> <button id="todos" name="todos" type="button"
													class="btn btn-primary btn-circle">'.$this->lang->line('attendance_everyone').'
											</button>';
				$form_html .=  '<button id="update" name="update" type="submit"
													class="btn btn-primary btn-circle">'.$this->lang->line('attendance_to_update').'
											</button></div>';
				$form_html .=  '</form>';
				$form_html .=  '<div id="processing" class="update-process" style="display:none; float:right; margin-top:10px"></div>';
			}else{
				$form_html = '<p>'.$this->lang->line('attendance_no_any_data').'</p>';
			}

		}

		print_r($form_html);
		exit;
	}

	public function sa_profile(){
		$html_profile = '';
		if($this->input->post(null, true)){

			$course_id = $this->input->post('course_id', true);
			$group_id = $this->input->post('group_id', true);
			$student_id = $this->input->post('student_id', true);
			$option = $this->input->post('option', true);
			$ini = $this->input->post('ini', true);
			$date = $this->input->post('date', true);
			$teacher_id = $this->input->post('teacher_id', true);
			$dt = $date;
			if($this->data['lang'] == "spanish"){
				$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
			}
			if($option == 0){
				$attendees = $this->AgendaModel->sa_attendees($course_id, $group_id, $dt, $teacher_id);
			}else if($option == 1){
				$attendees = $this->AgendaModel->sa_attendees2($course_id, $group_id, $dt, $teacher_id, $ini);
			}


			$matricula = 0;

			foreach($attendees as $attendee){
				if($attendee->IdAlumno == $student_id ){
					$matricula = $attendee->matricula;
					$asignatura = $attendee->IdActividad;
					break;
				}
			}


			if($option == 0){
				$inicio = 0;
			}else{
				$inicio = $ini;
			}
			if($student_id) {
				$datos = $this->AgendaModel->getDates($option, $student_id, $dt, $matricula, $asignatura, $ini, $group_id);

				$html_profile = $this->sa_overlay_profile($teacher_id, $student_id, $date, $matricula, $course_id, $group_id, $datos[0]->INDICE, $option, $inicio);
			}else{
				$html_profile = '';
			}
		}
		print_r(json_encode($html_profile));
		exit;
	}

	public function sa_franja()
	{
		$html_hours = '';
		if ($this->input->post(null, true)) {

			$course_id = $this->input->post('course_id', true);
			$group_id = $this->input->post('group_id', true);
			$date = $this->input->post('date', true);
			$teacher_id = $this->input->post('teacher_id', true);
			$dt = $date;
			if ($this->data['lang'] == "spanish") {
				$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
			}

			$html_hours .= '
					<script>
						$(function() {
							if (isFirefox) {
								$("select").addClass(\'for_mozilla\');
							}
						});
					</script>
					<div id="hours_id">
						<label for="hoursid" >'.$this->lang->line('schedule').':</label>
					<div class="circle_select_div">
						<select name="hoursid" id="hoursid" class="form-control" >
							<option value="-1">--'.$this->lang->line('attendance_select_time').'--</option>';
			$hours = $this->AgendaModel->sa_franja_horaria($group_id, $course_id, $dt, $teacher_id);
			foreach ($hours as $hour) {
				if ($hour->INICIO < 1000) {
					$inicio = substr($hour->INICIO, 0, 2).":".substr($hour->INICIO, 2, 2);
				} else {
					$inicio = substr($hour->INICIO, 0, 2).":".substr($hour->INICIO, 2, 2);
				}
				if ($hour->FIN < 1000) {
					$fin = substr($hour->FIN, 0, 2).":".substr($hour->FIN, 2, 2);
				} else {
					$fin = substr($hour->FIN, 0, 2).":".substr($hour->FIN, 2, 2);
				}
				$html_hours .= '<option value="'.$hour->INICIO.'">'.$inicio.' - '.$fin.'</option>';
			}
			$html_hours .= '</select>
		</div></div>';

		}
		print_r(json_encode(array('html' => $html_hours)));
		exit;
	}

	public function sa_tracing(){
		$sa_tracing = array();
		$sa_tracing['success'] = false;
		$sa_tracing['error'] = false;
		if($this->input->post(null, true)){
			$campos = $this->input->post('campos', true);
			$ncampos = $this->input->post('ncampos', true);
			$accion = $this->input->post('accion', true);
			$matricula = $this->input->post('matricula', true);
			$indice = $this->input->post('indice', true);

			$campos = explode(",",$campos);
			$ncampos = explode(",",$ncampos);

			$count_campos = count($campos);
			for($i=0; $i < $count_campos; $i++){
				$campos[$i] = decharespeciales($campos[$i]);
			}

			$this->load->model('AgendaTabAdModel');
			$update_insert = $this->AgendaTabAdModel->update_or_insert($matricula,$campos,$ncampos,$indice, $accion);

			if($update_insert){
				$sa_tracing['success'] = $this->lang->line('attendance_action_success');
			}else{
				$sa_tracing['error'] = $this->lang->line('attendance_query_failed');
			}
		}else{
			$sa_tracing['error'] = $this->lang->line('attendance_db_err_msg');
		}

		print_r(json_encode($sa_tracing));
		exit;
	}

	public function sa_attendees_update(){
		$message = array();
		if($this->input->post(null, true)){
			$course_id = $this->input->post('course_id', true);
			$group_id = $this->input->post('group_id', true);
			$date = $this->input->post('date', true);
			$inicio = $this->input->post('inicio', true);
			$teacher_id = $this->input->post('teacher_id', true);
			$dt = $date;
//			if($this->data['lang'] == "spanish"){
//				$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
//			}

			$option = $this->input->post('option', true);
			$data_form = $this->input->post('data_form', true);
			$_data = array();
			foreach($data_form as $form_input){
				$_data[$form_input['name']] = $form_input['value'];
			}
			if($option == 0){
				$attendees = $this->AgendaModel->sa_attendees($course_id, $group_id, $dt, $teacher_id);
			}else if($option == 1){
				$attendees = $this->AgendaModel->sa_attendees2($course_id, $group_id, $dt, $teacher_id, $inicio);
			}

			if(isset($attendees) && !empty($attendees)){
				$i = 0;
				foreach($attendees as $attendee){
					if(isset($_data['state_'.$attendee->IdAlumno])){
						$state = $_data['state_'.$attendee->IdAlumno];
						if ('' != trim ($state))
						{
							$data_update = array(
								"estado" => (int)$state
							);
							$data_where = array('indice'=>(int)$attendee->Id);

							$updated = $this->AgendaModel->_update($data_update, $data_where);
							if($updated){
								$i++;
								if($state == '3'){
									$this->load->model('AlumnoModel');
									$student_data = $this->AlumnoModel->getStudentById($attendee->IdAlumno);
									if(!empty($student_data)){
										$replace_data = array(
											'FIRSTNAME' => $student_data->first_name,
											'SURNAME' => $student_data->sur_name,
											'FULLNAME' => $student_data->full_name,
											'PHONE1' => $student_data->phone1,
											'MOBILE' => $student_data->mobile,
											'EMAIL1' => $student_data->email1,
											//'COURSE_NAME' => $course_data->course_name,
											'START_DATE' => $date,
											'END_DATE' => $date,
										);
										$this->sendEmailPart($replace_data, $student_data->email1);

									}
									
									
								}
							}
						}
					}

				}
				$message[] = sprintf($this->lang->line('attendance_updated_records'), $i);
			}
		}
		if(empty($message)){
			$message[] = $this->lang->line('attendance_db_err_msg');
		}
		print_r(json_encode($message));
		exit;
	}

	private function sendEmailPart($replace_data,$email){
		$result = null;
		$this->load->model('ErpEmailsAutomatedModel');
		$template = $this->ErpEmailsAutomatedModel->getByTemplateId('5', array('notify_student' => 1));
		if (!empty($template) && !empty($email)) {
			$email_subject = replaceTemplateBody($template->Subject, $replace_data);
			$email_body = replaceTemplateBody($template->Body, $replace_data);
			$result = $this->send_automated_email($email, $email_subject, $email_body, $template->from_email);
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

	protected function sa_overlay_profile($id,$userid,$date,$matricula,$curso,$grupo,$indice,$option,$inicio){

		$html_pop_up_form = '';
		$db_name = $this->_db_details->DBHost_db;

		$this->load->model('InformationSchemaTablesModel');
		$res = $this->InformationSchemaTablesModel->getCount($db_name);

		if(isset($res[0]) && $res[0]->COUNT == 1){
			$this->load->model('AlumnoModel');

			$resultados = $this->AlumnoModel->getByUserId($userid);
			if (isset($resultados[0])) {
					$resultados = $resultados[0];
			}

			$this->load->model('AgendaTabAdModel');
			$datos = $this->AgendaTabAdModel->getByIndice($indice);
			if(isset($datos[0])){
				$datos = $datos[0];
				$html_pop_up_form .= '<form enctype="multipart/form-data" action="" method="get">';
				$html_pop_up_form .= '';
				if(!empty($resultados)) {
					$html_pop_up_form .= '<h4><strong>' . $this->lang->line('attendance_user_role_student') . ': ' . $resultados->cnomcli . '</strong></h4>';
				}
				$dt = $date;
				if($this->data['lang'] == "spanish"){
					$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
				}


				if($option == 0){
					$attendees = $this->AgendaModel->sa_attendees($curso, $grupo, $dt, $id);
				}else if($option == 1){
					$attendees = $this->AgendaModel->sa_attendees2($curso, $grupo, $dt, $id, $inicio);
				}

				if(isset($attendees) && !empty($attendees)){
					foreach($attendees as $attendee){
						$html_pop_up_form .= '<h4><strong>'.$this->lang->line('date').': '.$date.'</strong></h4>';
						$html_pop_up_form .= '<h4><strong>'.$this->lang->line('hour').': '.$attendee->Time_Interval.'</strong></h4>';
						break;
					}					}
				$campos = array();
				$arr_datos = (array)$datos;
				foreach($arr_datos as $key_d=>$val_d){
//						$key_d = str_replace(' ', '-', trim($key_d));
					$campos[] = $key_d;
				};
				$count_campos = count($campos);
				$html_pop_up_form .= '<table class="table">';

				for($i=2; $i < $count_campos; $i++){
					$html_pop_up_form .= '<tr>';
					$html_pop_up_form .= '<td scope="row" align="left" valign="top" class="cabeceras">'.$campos[$i].'</td>';
					$html_pop_up_form .= '<td align="left" valign="top"><textarea class="txtarea">'. $datos->{$campos[$i]}.'</textarea></td>';
					$html_pop_up_form .= '</tr>';
				}
				$html_pop_up_form .= '</table>';
				$html_pop_up_form .= '<input type="hidden" id="userid" value="'.$userid.'" />';
				$html_pop_up_form .= '<input type="hidden" id="matricula" value="'.$matricula.'" />';
				$html_pop_up_form .= '<input type="hidden" id="indice" value="'.$indice.'" />';
				$html_pop_up_form .= '<input type="hidden" id="accion" value="update" />';
				$html_pop_up_form .= '<div style="text-align:right">
											<a href="" id="btntracing" class="btn btn-primary">'.$this->lang->line('attendance_accept').'</a>
										</div>';
				$html_pop_up_form .= '</form>';

			}else{

				$html_pop_up_form .= '<form enctype="multipart/form-data" action="" method="get">';
				$html_pop_up_form .= '';
				$html_pop_up_form .= '<h4><strong>'.$this->lang->line('attendance_user_role_student').': '.$resultados->cnomcli.'</strong></h4>';


				$dt = $date;
				if($this->data['lang'] == "spanish"){
					$dt = convert_date($date, 'd-m-Y H:i:s', 'Y-m-d');
				}

				if($option == 0){
					$attendees = $this->AgendaModel->sa_attendees($curso, $grupo, $dt, $id);
				}else if($option == 1){
					$attendees = $this->AgendaModel->sa_attendees2($curso, $grupo, $dt, $id, $inicio);
				}

				if(isset($attendees) && !empty($attendees)){
					foreach($attendees as $attendee){
						$html_pop_up_form .= '<h4><strong>'.$this->lang->line('date').': '.$date.'</strong></h4>';
						$html_pop_up_form .= '<h4><strong>'.$this->lang->line('hour').': '.$attendee->Time_Interval.'</strong></h4>';
						break;
					}

				}

				$campos = $this->AgendaTabAdModel->get_col_info();
				$count_campos = count($campos);
				$html_pop_up_form .= '<table class="table">';

				for($i=2; $i < $count_campos; $i++){
					$html_pop_up_form .= '<tr>';
					$html_pop_up_form .= '<td scope="row" align="left" valign="top" class="cabeceras">'.$campos[$i].'</td>';
					$html_pop_up_form .= '<td align="left" valign="top"><textarea class="txtarea"></textarea></td>';
					$html_pop_up_form .= '</tr>';
				}
				$html_pop_up_form .= '</table>';
				$html_pop_up_form .= '<input type="hidden" id="userid" value="'.$userid.'" />';
				$html_pop_up_form .= '<input type="hidden" id="matricula" value="'.$matricula.'" />';
				$html_pop_up_form .= '<input type="hidden" id="indice" value="'.$indice.'" />';
				$html_pop_up_form .= '<input type="hidden" id="accion" value="insert" />';
				$html_pop_up_form .= '<div style="text-align:right">
											<a href="" id="btntracing" class="btn btn-primary">'.$this->lang->line('attendance_accept').'</a>
										  </div>';
				$html_pop_up_form .= '</form>';
			}
		}else{
			$html_pop_up_form .= '<h3>'.$this->lang->line('attendance_not_configured').'</h3>';
			$html_pop_up_form .= '<br />';
			$html_pop_up_form .= '<h4><p>'.$this->lang->line('attendance_tracking_form_linked').'</p></h4>';
			$html_pop_up_form .= $this->lang->line('attendance_additional_table');
			$html_pop_up_form .= $this->lang->line('attendance_not_created');
			$html_pop_up_form .= '<p>'.$this->lang->line('attendance_create_items').'</p>';
			$html_pop_up_form .= '<p>'.$this->lang->line('attendance_technical_staff').'</p>';
		}
		return $html_pop_up_form;
	}
}

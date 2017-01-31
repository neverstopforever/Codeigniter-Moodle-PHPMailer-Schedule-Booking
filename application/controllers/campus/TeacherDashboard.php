<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherDashboard extends MY_Campus_Controller {

	 public function __construct(){
		parent::__construct();
		$this->data['user_role'] = $this->session->userdata('user_role');
	 	$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user') && $this->data['user_role'] != 1){ //no user or not teacher
//			$this->session->set_flashdata('errors', array($this->lang->line('campus_access_denied')));
			redirect('campus/auth/login/', 'refresh');
		}
		$this->data['campus_user'] = (array)$this->session->userdata('campus_user');
		$this->data['user_id'] = $this->data['campus_user']['INDICE'];

		$this->load->model('ErpEventoModel');
		$this->load->model('MensajeModel');
		$this->load->model('MatriculalModel');
		$this->load->model('GruposlModel');
		$this->layouts->add_includes('js', 'app/js/campus/teacher_dashboard/main.js');
	}

	public function index(){

		$this->layouts->add_includes('js', 'app/js/campus/teacher_dashboard/index.js');
		$teacher_id = $this->data['user_id'];
		$this->data['page']='teacher_dashboard';

		//count of active students
		$active_students = $this->MatriculalModel->getCountActiveStudents($teacher_id);
		if(isset($active_students[0]) && isset($active_students[0]->active_students)){
			$this->data['count_active_students'] = $active_students[0]->active_students;
		}else{
			$this->data['count_active_students'] = 0;
		}

		//count of active groups
		$active_groups = $this->GruposlModel->getCountActiveGroups($teacher_id);
		if(isset($active_groups[0]) && isset($active_groups[0]->active_groups)){
			$this->data['count_active_groups'] = $active_groups[0]->active_groups;
		}else{
			$this->data['count_active_groups'] = 0;
		}

		//count of num_messages
		$num_messages = $this->MensajeModel->getNumMessages($teacher_id);
		if(isset($num_messages[0]) && isset($num_messages[0]->num_messages)){
			$this->data['num_messages'] = $num_messages[0]->num_messages;
		}else{
			$this->data['num_messages'] = 0;
		}

		//count of recent events
		$recent_events = $this->ErpEventoModel->getCountRecentEvents();
		if(isset($recent_events[0]) && isset($recent_events[0]->recent_events)){
			$this->data['count_recent_events'] = $recent_events[0]->recent_events;
		}else{
			$this->data['count_recent_events'] = 0;
		}
		$this->layouts->view('campus/teacher_dashboard/indexView',$this->data, $this->layout);
	}

	public function get_messages(){
		$html = '';
		if ($this->input->is_ajax_request()) {
			$messages_from = $this->input->post('messages_from', true);
			if($messages_from == 'inbox'){
				$messages = $this->MensajeModel->getInbox($this->data['user_id'], 5);
			}else if($messages_from == 'outbox'){
				$messages = $this->MensajeModel->getOutbox($this->data['user_id'], 5);
			}

			if(isset($messages) && !empty($messages)){
				foreach($messages as $message){
					$user_name = '';
					$user_photo = '';
					$read_messaeg_inbox = 'read_message';
					if($messages_from == 'inbox'){
						$user_name = $message->from_user_name;
						$user_photo = $message->from_user_photo;
					}else if($messages_from == 'outbox'){
						$user_name = $message->to_user_name;
						$user_photo = $message->to_user_photo;
					}

					$img_src = "/assets/img/dummy-image.png";
					if(!empty($user_photo)){
						$img_src = image_parser_from_db($user_photo);
					}
					if($message->Read == '1'){
						$message_read = "";
						$message_read_color="";
					}else{
						if($messages_from == 'inbox') {
							$read_messaeg_inbox = 'read_message_inbox';
						}
						$message_read = "bold_text";
						$message_read_color = "read_text_color";
					}

					$html .= '<div class="'. $read_messaeg_inbox .'" data-message_id="'. $message->id.'" ><div class="row">
								<div class="col-xs-12 col-sm-2 text-center text-xs-left">
									<img src="'.$img_src.'" class="user_img" alt="" >
								</div>
								<div class="col-xs-9 col-sm-7 ts_info_text">
									<div class="'.$message_read.' title">'.$user_name. '</div>
									<div class="role_type_mess_send">'.$this->lang->line($message->roletype).'</div>
								</div>
								<div class="col-xs-3 col-sm-3">
									<div class="text-right date_time_dashboard '.$message_read_color.'">
											<p class="no_margin">'.date("M, d",strtotime($message->maildate)).'</p>
											<span>'.date("H:i A",strtotime($message->maildate)).'</span>
									</div>
								</div>
						  </div>';

					$html .= '<div class="row">
								<div class="col-xs-0 col-sm-2"></div>
								<div class="col-xs-12 col-sm-10 dashboard_message_text message_subject '.$message_read_color.'">
									'. $message->subject.'
								</div>
						  </div>';
					$message_body = $message->body;
					$text_more = '';
					$full_message = true;
					if(strlen($message_body) > 150){
						$message_body = substr($message_body, 0, 150);
						$text_more = '<span class="hidden more_message_'.$message->id.'"" >'.substr($message->body,10,strlen($message->body)).'</span>
									<a class="hidden less_message_link text-primary"  href="#" > '.$this->lang->line('campus_less_message').'</a>';
						$message_body .= ' ...';
						$full_message = false;
					}
					$html .= '<div class="row">
								<div class="col-xs-0 col-sm-2"></div>
								<div class="col-xs-12 col-sm-10 dashboard_message_text message_body '.$message_read_color.'" data-full-message="'.$full_message.'">
									'.$message_body.$text_more.'
								</div>
						  </div></div>';
					$html .= '<hr>';
				}
				$html .= '<div class="text-center"><a type="button" href="/campus/message" class="btn btn-primary btn-circle">'.$this->lang->line('campus_display_more').'</a></div>';
			}else{
				$html .= '<p>'.$this->lang->line('campus_no_any_data').'</p>';
			}
		}

		print_r(json_encode($html));
		exit;
	}

	public function get_events(){
		$html = '';
		if ($this->input->is_ajax_request()) {
			$events_type = $this->input->post('events_type', true);
			$events = $this->ErpEventoModel->getItems($events_type, 5);
			if(isset($events) && !empty($events)){
				foreach($events as $event){

					$event_type_class = 'public_event';
					if($event->public != 1){
						$event_type_class = 'private_event';
					}

					$html .= ' <div class="row" data-event_id="'.$event->id .'">
                                    <div class="col-xs-4">
                                        <div class="box_event text-center '.$event_type_class.'">
                                            <p>' .date("j",strtotime($event->event_date)).' '. date("F",strtotime($event->event_date)).'</p>

                                        </div>
                                    </div>
                                    <div class="col-xs-8 box_event_text">
                                        <h4>'.$event->title.'</h4>
                                        <p class="role_type_mess_send" style="word-break: normal;">'.$event->content.'</p>
                                    </div>
                                </div>';
					$html .= '<hr>';
				}
				$html .= '<div class="text-center"><a type="button" href="/campus/events" class="btn btn-primary btn-circle">'.$this->lang->line('campus_display_more').'</a> </div>';
			}else{
				$html .= '<p>'.$this->lang->line('campus_no_any_data').'</p>';
			}
		}

		print_r(json_encode($html));
		exit;
	}
}

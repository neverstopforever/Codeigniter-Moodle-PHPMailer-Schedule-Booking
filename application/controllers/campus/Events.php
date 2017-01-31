<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Campus_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->lang->load('campus',$this->data['lang']);
		if(!$this->session->userdata('campus_user')){
			redirect('campus/auth/login/', 'refresh');
		}
		$this->load->model('ErpEventoModel');
		$this->data['campus_user'] = (array)$this->session->userdata('campus_user');
		$this->data['user_id'] = $this->data['campus_user']['INDICE'];
		$this->layouts->add_includes('js', 'app/js/campus/events/main.js');
	}
	
	public function index(){
		$this->data['page']='campus_events';
		$this->layouts->add_includes('js', 'app/js/campus/events/index.js');
		$this->layouts->view('campus/events/index', $this->data, $this->layout);
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

					$html .= ' <div class="row event_item_row" data-event_id="'.$event->id .'">
                                    <div class="col-xs-3">
                                        <div class="box_event text-center '.$event_type_class.'">
                                            <p>'. date("F",strtotime($event->event_date)).'</p>
                                            <span>'.date("j",strtotime($event->event_date)).'</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <h4>'.$event->title.'</h4>
                                        <p style="word-break: normal;">'.$event->content.'</p>
                                    </div>
                                </div>';
					$html .= '<hr>';
				}
				$html .= '<a type="button" href="/campus/events" class="btn btn-primary pull-right" id="show_more">'.$this->lang->line('campus_display_more').'</a>';
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
                                    <div class="col-xs-9">
                                        <h4>'.$event->title.'</h4>
                                        <p style="word-break: normal;">'.$event->content.'</p>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="box_event text-center '.$event_type_class.'">
                                            <p>'. date("F",strtotime($event->event_date)).'</p>
                                            <span>'.date("j",strtotime($event->event_date)).'</span>
                                        </div>
                                    </div>
                                </div>';
			}else{
				$html .= '<p style="color:red">'.$this->lang->line('campus_no_any_data').'</p>';
			}
		}

		print_r(json_encode($html));
		exit;
	}
}
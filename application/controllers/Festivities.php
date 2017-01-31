<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Festivities extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		if (empty($this->_identity['loggedIn'])) {
			redirect('/auth/login/', 'refresh');
		}
		$this->lang->load('festivities', $this->data['lang']);
		$this->load->model('FestividadeModel');
		$this->load->library('form_validation');
		$this->layouts->add_includes('js', 'app/js/festivities/main.js');
	}

	/*
	* @Method : Method for show festivity calendar on calendar page
	* @Parameters :
	* @Retun : Festivity calendar page
	*/
	public function index(){
		//Include jcal-custom css for calendar
		$this->layouts->add_includes('css', 'app/js/festivities/jcal/jCal-custom.css');

		//Include jcal-custom css for festivity calendar
//		$this->layouts->add_includes('js', 'app/js/festivities/index.js');
		$this->layouts->add_includes('js', 'app/js/festivities/jcal/jCal.js');
		$this->layouts->add_includes('js', 'app/js/festivities/jcal/jCal-functions.js');
		$this->lang->load('quicktips', $this->data['lang']);
		$this->data['page'] = 'festivities_calendar';
		//Get all festivities in array format
		$festivities = $this->FestividadeModel->getAll();

		/*
			Required JSON type for festivity calendar

			"107": {"m": 12,"d": 25},
		  	"195": {"m": 1,"d": 9,"y": 2017},
		*/

		//Convert all festivities in json format for show in calendar
		$temp_festivity = array();
		foreach($festivities as $fetivity_key => $fetivity_val) {
			//Assign month in temp_array
			$temp_festivity[$fetivity_val->id]['m']                 = date('n', strtotime($fetivity_val->Fecha));

			//Assign date in temp_array
			$temp_festivity[$fetivity_val->id]['d']                 = date('j', strtotime($fetivity_val->Fecha));

			//Assign description in temp_array
			$temp_festivity[$fetivity_val->id]['description'] = $fetivity_val->Descripcion;

			//Assign year in temp_array
			$temp_festivity[$fetivity_val->id]['y'] = date('Y', strtotime($fetivity_val->Fecha));
		}

		//Set default language for spanish/english
		$this->data['selected_language'] = $this->session->userdata('lang');

		$this->data['festivities'] = $temp_festivity;
		$this->layouts->view('festivities/festivity_calendar', $this->data);
	}
//    public function index(){
////
////		$this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-year-calendar/css/bootstrap-year-calendar.min.css');
////		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-year-calendar/js/bootstrap-year-calendar.min.js');
////		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-year-calendar/js/languages/bootstrap-year-calendar.es.js');
//        $this->lang->load('quicktips', $this->data['lang']);
//        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
//		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
//		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-daterangepicker/moment.min.js');
//		$this->layouts->add_includes('js', 'app/js/festivities/index.js');
//
//		$this->data['page'] = 'festivities_index';
//		$this->data['festivities'] = $this->FestividadeModel->getAll();
//		$this->layouts->view('festivities/index', $this->data);
//
//	}

	public function add(){
		$response['success'] = false;
		$response['errors'] = array();
		if($this->input->is_ajax_request()){
			$data_post = $this->input->post(null, true);

			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'add_description',
					'label' => $this->lang->line('festivities_description'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'add_date',
					'label' => $this->lang->line('festivities_date'),
					'rules' => 'trim|required'
				),
//				array(
//					'field' => 'add_id_center',
//					'label' => $this->lang->line('festivities_id_center'),
//					'rules' => 'trim|required|is_natural'
//				)
			);

			$this->form_validation->set_rules($config);
//			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
			if ($this->form_validation->run()) {
				if(!empty($data_post)){
					$item = array(
						'Descripcion'=>isset($data_post['add_description']) ?$data_post['add_description']:null,
						'Fecha'=>isset($data_post['add_date']) ? $data_post['add_date']:'0000-00-00 00:00:00',
//						'IdCentro'=>isset($data_post['add_id_center']) ? $data_post['add_id_center']:0,
					);
					$add_festivity_id = $this->FestividadeModel->add_item($item);
					if($add_festivity_id){
						$response['success'] = $this->lang->line('festivities_festivity_added');
						$response['insert_id'] = $add_festivity_id;
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
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

	public function edit(){
		$response['success'] = false;
		$response['errors'] = array();
		if($this->input->is_ajax_request()){
			$data_post = $this->input->post(null, true);
			$get_festivity = null;

     		$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'new_edit_description',
					'label' => $this->lang->line('festivities_description'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'new_edit_date',
					'label' => $this->lang->line('festivities_date'),
					'rules' => 'trim|required'
				),
//				array(
//					'field' => 'new_edit_id_center',
//					'label' => $this->lang->line('festivities_id_center'),
//					'rules' => 'trim|required|is_natural'
//				)
			);

			$item_old = array(
				'Descripcion'=>isset($data_post['old_edit_description']) ?$data_post['old_edit_description']:null,
				'Fecha'=>isset($data_post['old_edit_date']) ? $data_post['old_edit_date']:'0000-00-00 00:00:00',
//				'IdCentro'=>isset($data_post['old_edit_id_center']) ? $data_post['old_edit_id_center']:0,
			);
			$item_new = array(
				'Descripcion'=>isset($data_post['new_edit_description']) ?$data_post['new_edit_description']:null,
				'Fecha'=>isset($data_post['new_edit_date']) ? $data_post['new_edit_date']:'0000-00-00 00:00:00',
//				'IdCentro'=>isset($data_post['new_edit_id_center']) ? $data_post['new_edit_id_center']:0,
			);

			$this->form_validation->set_rules($config);
//			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');
			if ($this->form_validation->run()) {
				$item_id = isset($data_post['id']) ? $data_post['id']:null;
				$get_festivity = $this->FestividadeModel->get_itemById($item_id);

				if(!empty($get_festivity)){
					if($item_old != $item_new){
						$update_festivity = $this->FestividadeModel->update_item($item_new, $item_id);
						if($update_festivity){
							$response['success'] = $this->lang->line('festivities_festivity_updated');
						}else{
							$response['errors'][] = $this->lang->line('db_err_msg');
						}
					}else{
						$response['errors'][] = $this->lang->line('festivities_no_changes');
					}
				}else{
					if(!empty($get_festivity)){
						$response['errors'][] = $this->lang->line('festivities_festivity_no_exist');
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
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

	public function delete(){
		$response['success'] = false;
		$response['errors'] = array();
		if($this->input->is_ajax_request()){
			$data_post = $this->input->post(null, true);
			if(isset($data_post['id'])){
				$delete_festivity = $this->FestividadeModel->delete_item($data_post['id']);
				if($delete_festivity){
					$response['success'] = $this->lang->line('festivities_festivity_deleted');
				}else{
					$response['errors'][] = $this->lang->line('db_err_msg');
				}
			}else{
				$response['errors'][] = $this->lang->line('db_err_msg');
			}
		}else{
			$response['errors'][] = $this->lang->line('db_err_msg');
		}
		print_r(json_encode($response));
		exit;
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;

class Campaigns extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
		$this->load->model('ErpEmailsCampaignModel');
		$this->load->model('ErpEmailsCampaignFolderModel');
		$this->load->model('ErpEmailsSegmentModel');
		$this->load->model('ErpEmailModel');
		$this->load->model('ErpEmailsCampaignRecipieModel');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
		$this->layouts->add_includes('js', 'app/js/campaigns/main.js');
	}
	
	public function index(){
		$this->lang->load('quicktips', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/campaigns/index.js');
		$this->data['page']='campaigns';
		$this->data['all_campaign_count'] = $this->ErpEmailsCampaignModel->getTotalCount();
		$this->data['folders'] = $this->ErpEmailsCampaignFolderModel->getFoldersWithCampaignCounts();

		$this->layouts->view('campaigns/index', $this->data);
	}

	public function chnageFolderName(){
		if($this->input->is_ajax_request()){
			$folder_id = $this->input->post('folder_id');
			$folder_name = $this->input->post('folder_name');
			$result = false;
			if($folder_id && $folder_name) {
				$result = $this->ErpEmailsCampaignFolderModel->chnageFolderName($folder_id, $folder_name);
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
			$result = false;
			if($folder_id) {
				$result = $this->ErpEmailsCampaignFolderModel->deleteFolder($folder_id);
				if($result){
					$this->ErpEmailsCampaignModel->deleteItemByFolder($folder_id);
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
		$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
		if($this->data['lang'] == "spanish"){
			$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
		}
		$this->layouts->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js');
		$this->layouts->add_includes('js', 'app/js/campaigns/add.js');
		$this->data['page']='campaigns_add';
//		$this->data['all_campaigns_count'] = $this->ErpEmailscampaignModel->getTotalCount();
		$this->data['folders'] = $this->ErpEmailsCampaignFolderModel->getFoldersWithCampaignCounts();

		$this->layouts->view('campaigns/add', $this->data);
	}

	public function get_state(){
		$response['success'] = false;
		$response['errors'] = true;
		$campaign_id = $this->input->post('campaign_id', true);
		if(empty($campaign_id) || !is_numeric($campaign_id)){
			print_r(json_encode($response));
			exit;
		}

		$campaign = $this->ErpEmailsCampaignModel->getById($campaign_id);

		if(isset($campaign[0]->State)){
			$response['success'] = $campaign[0]->State;
			$response['errors'] = false;
		}
		print_r(json_encode($response));
		exit;
	}


	public function state_update_item(){
		$response['success'] = false;
		$response['errors'] = true;
		$campaign_id = $this->input->post('campaign_id', true);
		$state = $this->input->post('state', true);
		if(empty($campaign_id) || !is_numeric($campaign_id)){
			print_r(json_encode($response));
			exit;
		}

		$campaign = $this->ErpEmailsCampaignModel->getById($campaign_id);
		if(isset($campaign[0]->state) && $campaign[0]->state != 2){
			$state_changed = $this->ErpEmailsCampaignModel->stateUpdateItem($campaign_id, $state);

			if($state_changed){
				$response['success'] = true;
				$response['errors'] = false;
			}
		}

		print_r(json_encode($response));
		exit;
	}

	public function state_check($num)
	{
		if ($num != "0" && $num != "1"){ //0‐paused, 1‐scheduled
			$this->form_validation->set_message('state_check', $this->lang->line('campaigns_wrong_state'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	protected function recipients_segments(){
		$all_segments_count = 0;
		$segments = $this->ErpEmailsSegmentModel->getAll();

		$segments_data = array();
		foreach($segments as $k=>$segment){ //Contacts, Students, Teachers
			$segments_data[$k] = $segment;
			$segments_data[$k]->items_count = 0;
			if(!empty($segment->items_count_csql)){
				$items_count = $this->magaModel->selectCustom($segment->items_count_csql);
				if(isset($items_count[0]->items_count) && !empty($items_count[0]->items_count)){
					$segments_data[$k]->items_count = $items_count[0]->items_count;
					$all_segments_count += $items_count[0]->items_count;
				}
			}
		}
		$this->data['all_segments_count'] = $all_segments_count;
		$this->data['segments'] = $segments_data;
	}
	protected function get_ajax_filter_by_items($data_arr, $segment_id = 1){

		$count_surname = 0;
		$count_first_name = 0;
		$count_email = 0;
		$surname_data_arr = array();
		$first_name_data_arr = array();
		$email_data_arr = array();

		//Prospects
		$count_prospect_score = 0;
		$prospect_score_data_arr = array();
		$response['prospects_source_data'] = array();
		$response['prospects_campaign_data'] = array();
		$response['prospects_state_data'] = array();
		$response['prospects_stars_data'] = array();


		$response['enrollments_course_data'] = array();
		$response['enrollments_group_data'] = array();

		if(!empty($data_arr) && is_array($data_arr)){
			foreach ($data_arr as $k => $item) {
				if (!empty($item->surname)) {
					//surname_data
					if (!in_array(array('id' => $item->surname, 'text' => $item->surname), $surname_data_arr)) {
						$surname_data_arr[$count_surname]['id'] = $item->surname;
						$surname_data_arr[$count_surname]['text'] = $item->surname;
						$count_surname++;
					}
				}
				if (!empty($item->first_name)) {
					//first_name_data
					if (!in_array(array('id' => $item->first_name, 'text' => $item->first_name), $first_name_data_arr)) {
						$first_name_data_arr[$count_first_name]['id'] = $item->first_name;
						$first_name_data_arr[$count_first_name]['text'] = $item->first_name;
						$count_first_name++;
					}
				}
				if (!empty($item->email)) {
					//email_data
					if (!in_array(array('id' => $item->email, 'text' => $item->email), $email_data_arr)) {
						$email_data_arr[$count_email]['id'] = $item->email;
						$email_data_arr[$count_email]['text'] = $item->email;
						$count_email++;
					}
				}
				
				if($segment_id == 4){ //Prospects
					if(isset($item->prospect_score) && !empty($item->prospect_score)) {
						if (!in_array(array('id' => $item->prospect_score, 'text' => $item->prospect_score), $prospect_score_data_arr)) {
							$prospect_score_data_arr[$count_prospect_score]['id'] = $item->prospect_score;
							$prospect_score_data_arr[$count_prospect_score]['text'] = $item->prospect_score;
							$count_prospect_score++;
						}
					}
				}
			}
		}
		$response['surname_data'] = $surname_data_arr;
		$response['first_name_data'] = $first_name_data_arr;
		$response['email_data'] = $email_data_arr;
		
		$response['prospects_score_data'] = $prospect_score_data_arr;		
		if($segment_id == 4){ //Prospects
			$prospect_filters = $this->get_prospects_filter_items();
			$response['prospects_source_data'] = isset($prospect_filters['source']) ? $prospect_filters['source'] : array();
			$response['prospects_campaign_data'] = isset($prospect_filters['campaign']) ? $prospect_filters['campaign'] : array();
			$response['prospects_state_data'] = isset($prospect_filters['state_data']) ? $prospect_filters['state_data'] : array();
			$response['prospects_stars_data'] = isset($prospect_filters['stars_data']) ? $prospect_filters['stars_data'] : array();
		}
		if($segment_id == 5){ //Enrollments
			$enrollment_filters = $this->get_enrollments_filter_items();
			$response['enrollments_course_data'] = isset($enrollment_filters['courses']) ? $enrollment_filters['courses'] : array();
			$response['enrollments_group_data'] = isset($enrollment_filters['groups']) ? $enrollment_filters['groups'] : array();
		}
		return $response;
	}
	
	protected function get_prospects_filter_items() {

		$response = array();
	
		//Filtring data
		$this->load->model('MedioModel');
		$response['source'] = $this->MedioModel->getSourceForFilter();
		
		$this->load->model('CompanyModel');
		$response['campaign'] = $this->CompanyModel->getAllCampaigns();

		$this->load->model('PresupuestotModel');
		$states = $this->PresupuestotModel->get_states();
		if(!empty($states)){
			foreach($states as $state){
				$response['state_data'][] = array('id' => $state->id, 'text' => $state->valor, 'color' => $state->color);
			}
		}
		$response['stars_data'] = [
			array('id' => 0, 'text' => $this->lang->line("priority_normal")),
			array('id' => 1, 'text' => $this->lang->line("priority_high")),
			array('id' => 2, 'text' => $this->lang->line("priority_veryhigh")),
		];

		return $response;
	}
	
	protected function get_enrollments_filter_items() {

		$response = array();
	
		//Filtring data
		$this->load->model('CursoModel');
		$response['courses'] =  $this->CursoModel->getCourseForFilter();

		$this->load->model('GrupoModel');
		$response['groups'] =  $this->GrupoModel->getGroupsForFilter();

		return $response;
	}
	
	protected function get_filters_by_segment($segment_id = null){
		$filter_data['surname_data'] = array();
		$filter_data['first_name_data'] = array();
		$filter_data['email_data'] = array();
		switch ($segment_id) {
			case 1: //Contactos
				$data = $this->ContactosModel->get_contacts();
				$filter_data = $this->get_ajax_filter_by_items($data, $segment_id);
				break;
			case 2: //Studnents
				$data = $this->AlumnoModel->get_students();
				$filter_data = $this->get_ajax_filter_by_items($data, $segment_id);
				break;
			case 3: //Teachers
				$data = $this->ProfesorModel->get_teachers();
				$filter_data = $this->get_ajax_filter_by_items($data, $segment_id);
				break;
			default:
		}

		return $filter_data;
	}

	public function edit($campaign_id = null){
		if(empty($campaign_id) || !is_numeric($campaign_id)){
			$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
			redirect('campaigns');
		}
		$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
		if($this->data['lang'] == "spanish"){
			$this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
		}
		$this->layouts->add_includes('js', 'app/vendor/ckeditor/ckeditor/ckeditor.js');
		$this->layouts->add_includes('js', 'app/js/campaigns/edit.js');


		$this->recipients_segments();
		$this->data['selected_recipients'] = $this->ErpEmailsCampaignRecipieModel->getByCompaignId($campaign_id);

		$this->data['page']='campaigns_edit';
		$this->data['folders'] = $this->ErpEmailsCampaignFolderModel->getFoldersWithCampaignCounts();
		$campaign = $this->ErpEmailsCampaignModel->getById($campaign_id);
		if(isset($campaign[0])){
			$this->data['campaign'] = $campaign[0];
		}else{
			$this->data['campaign'] = new ErpEmailsCampaignModel();
		}

		$this->data['campaign_id'] = $campaign_id;
		$this->data['sent_recipients'] = $this->get_sent_recipients($campaign_id);



		//get filter by items
//		$this->get_filter_by_items($this->data['contacts'], $this->data['students'], $this->data['teachers']);

		if(isset($campaign[0]->state) && $campaign[0]->state == 2){
			$this->layouts->view('campaigns/edit_sent', $this->data);
		}else{
			$this->layouts->view('campaigns/edit', $this->data);
		}
	}


	public function filterBytags(){
		if($this->input->is_ajax_request()){

			$segment_id = $this->input->post('segment_id', true);
			$search_data = $this->input->post('search_data', true);

			$selected_surname = isset($search_data['selected_surname']) ? $search_data['selected_surname']: null;
			$selected_first_name = isset($search_data['selected_first_name']) ? $search_data['selected_first_name']: null;
			$selected_email = isset($search_data['selected_email']) ? $search_data['selected_email']: null;
			$selected_prospects_source = isset($search_data['selected_prospects_source']) ? $search_data['selected_prospects_source']: null;
			$selected_prospects_state = isset($search_data['selected_prospects_state']) ? $search_data['selected_prospects_state']: null;
			$selected_prospects_campaign = isset($search_data['selected_prospects_campaign']) ? $search_data['selected_prospects_campaign']: null;
			$selected_prospects_stars = isset($search_data['selected_prospects_stars']) ? $search_data['selected_prospects_stars']: null;
			$selected_prospects_score = isset($search_data['selected_prospects_score']) ? $search_data['selected_prospects_score']: null;

			$selected_enrollments_state = isset($search_data['selected_enrollments_state']) ? $search_data['selected_enrollments_state']: null;
			$selected_enrollments_course = isset($search_data['selected_enrollments_course']) ? $search_data['selected_enrollments_course']: null;
			$selected_enrollments_group = isset($search_data['selected_enrollments_group']) ? $search_data['selected_enrollments_group']: null;

			$selected_students_tag_ids = isset($search_data['selected_students_tag_ids']) ? $search_data['selected_students_tag_ids']: null;
			$selected_enrollments_tag_ids = isset($search_data['selected_enrollments_tag_ids']) ? $search_data['selected_enrollments_tag_ids']: null;
			$selected_prospects_tag_ids = isset($search_data['selected_prospects_tag_ids']) ? $search_data['selected_prospects_tag_ids']: null;

			$tags = array(
				'selected_surname' => $selected_surname,
				'selected_first_name' => $selected_first_name,
				'selected_email' => $selected_email,
				'selected_prospects_source' => $selected_prospects_source,
				'selected_prospects_state' => $selected_prospects_state,
				'selected_prospects_campaign' => $selected_prospects_campaign,
				'selected_prospects_stars' => $selected_prospects_stars,
				'selected_prospects_score' => $selected_prospects_score,
				'selected_enrollments_state' => $selected_enrollments_state,
				'selected_enrollments_course' => $selected_enrollments_course,
				'selected_enrollments_group' => $selected_enrollments_group,
				'selected_students_tag_ids' => $selected_students_tag_ids,
				'selected_enrollments_tag_ids' => $selected_enrollments_tag_ids,
				'selected_prospects_tag_ids' => $selected_prospects_tag_ids,
			);
			$response['data'] = array();
//			$response['filter_data'] = array();
			switch ($segment_id){
				case 1: //Contacts
					$this->load->model('ContactosModel');
					$data = $this->ContactosModel->get_contacts($tags);
//					$filter_data = $this->get_filters_by_segment($segment_id);
					break;
				case 2: //Students
					$this->load->model('AlumnoModel');
					$data = $this->AlumnoModel->get_students($tags);
//					$filter_data = $this->get_filters_by_segment($segment_id);
					break;
				case 3://Teachers
					$this->load->model('ProfesorModel');
					$data = $this->ProfesorModel->get_teachers($tags);
//					$filter_data = $this->get_filters_by_segment($segment_id);
					break;
				case 4://Prospects
					$this->load->model('PresupuestotModel');
					$data = $this->PresupuestotModel->get_prospects($tags);
//					$filter_data = $this->get_filters_by_segment($segment_id);
					break;
				case 5://Prospects
					$this->load->model('MatriculatModel');
					$data = $this->MatriculatModel->get_enrollments($tags);
//					$filter_data = $this->get_filters_by_segment($segment_id);
					break;
				default:
					$data = array();
					$filter_data = array();
			}
			$response['data'] = $data;
//			$response['filter_data'] = $filter_data;
			echo json_encode($response);
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function edit_campaign_finish(){

		$response['success'] = false;
		$response['errors'] = array();

		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'campaign_title',
					'label' => $this->lang->line('campaigns_new_title'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email_subject',
					'label' => $this->lang->line('campaigns_new_subject'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'id_folder',
					'label' => $this->lang->line('campaigns_new_id_folder'),
					'rules' => 'trim|required|is_natural_no_zero'
				),
				array(
					'field' => 'campaign_body',
					'label' => $this->lang->line('campaigns_new_body'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'state',
					'label' => $this->lang->line('campaigns_new_state'),
					'rules' => 'trim|required|is_natural|callback_state_check'
				),
				array(
					'field' => 'date_sending',
					'label' => $this->lang->line('campaigns_new_date_sending'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run()) {
				$data_campaign_post = $this->input->post(NULL, true);
				$data_campaign['title'] = html_purify($data_campaign_post['campaign_title']);
				$data_campaign['Subject'] = html_purify($data_campaign_post['email_subject']);
				$data_campaign['Body'] = html_purify($data_campaign_post['campaign_body']);
				$data_campaign['id_folder'] = $data_campaign_post['id_folder'];
				$data_campaign['state'] = $data_campaign_post['state'];
				$data_campaign['date_sending'] = $data_campaign_post['date_sending'];
				$data_campaign['user_id'] = $this->data['userData'][0]->Id;
				$campaign_id = $data_campaign_post['campaign_id'];

				$edited_campaign = $this->ErpEmailsCampaignModel->editCampaign($campaign_id, $data_campaign);
				if($edited_campaign){
					if(isset($data_campaign_post['check_recipient']) && !empty($data_campaign_post['check_recipient'])){
						$this->ErpEmailsCampaignRecipieModel->deleteByCampaignId($campaign_id);
						$campaign_recipie_unique = array();
						foreach($data_campaign_post['check_recipient'] as $k=>$recipient){
							if (isset($recipient['email']) && !empty($recipient['email'])
								&& !filter_var($recipient['email'], FILTER_VALIDATE_EMAIL) === false
							){
								$campaign_recipie = array(
									'id_campaign' => $campaign_id,
									'email_recipie' => $recipient['email'],
								);
								if(!in_array($campaign_recipie, $campaign_recipie_unique)){
									$campaign_recipie_unique[$k] = $campaign_recipie;
									$this->ErpEmailsCampaignRecipieModel->addItem($campaign_recipie);
								}
							}
						}
					}
					$response['success'] = $this->lang->line('campaigns_campaign_edited');
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

	public function get_contacts(){
		if($this->input->is_ajax_request()){
			$this->load->model('ContactosModel');
			$data = $this->ContactosModel->get_contacts();
			$filter_data = $this->get_ajax_filter_by_items($data, 1);
			echo json_encode(array('data' => $data, 'filter_data'=>$filter_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function get_students(){
		if($this->input->is_ajax_request()){
			$this->load->model('AlumnoModel');
			$data = $this->AlumnoModel->get_students();
			$filter_data = $this->get_ajax_filter_by_items($data, 2);
			echo json_encode(array('data' => $data, 'filter_data'=>$filter_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function get_teachers(){
		if($this->input->is_ajax_request()){
			$this->load->model('ProfesorModel');
			$data = $this->ProfesorModel->get_teachers();
			$filter_data = $this->get_ajax_filter_by_items($data, 3);
			echo json_encode(array('data' => $data, 'filter_data'=>$filter_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function get_prospects(){
		if($this->input->is_ajax_request()){
			$this->load->model('PresupuestotModel');
			$data = $this->PresupuestotModel->get_prospects();
			$filter_data = $this->get_ajax_filter_by_items($data, 4);
			echo json_encode(array('data' => $data, 'filter_data'=>$filter_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function get_enrollments(){
		if($this->input->is_ajax_request()){
			$this->load->model('MatriculatModel');
			$data = $this->MatriculatModel->get_enrollments();
			$filter_data = $this->get_ajax_filter_by_items($data, 5);
			echo json_encode(array('data' => $data, 'filter_data'=>$filter_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
		
	protected function filter_by_items(){

		$count_surname = 0;
		$count_first_name = 0;
		$count_email = 0;
		$surname_data_arr = array();
		$first_name_data_arr = array();
		$email_data_arr = array();

		$this->load->model('ContactosModel');
		$data_contacts = $this->ContactosModel->getContactsIdFields();

		foreach ($data_contacts as $k=>$item){
			if(!empty($item->surname)){
				//surname_data
				if (!in_array(array('id'=>$item->surname, 'text'=>$item->surname), $surname_data_arr)){
					$surname_data_arr[$count_surname]['id'] = $item->surname;
					$surname_data_arr[$count_surname]['text'] = $item->surname;
					$count_surname++;
				}
			}
			if(!empty($item->first_name)){
				//first_name_data
				if (!in_array(array('id'=>$item->first_name, 'text'=>$item->first_name), $first_name_data_arr)){
					$first_name_data_arr[$count_first_name]['id'] = $item->first_name;
					$first_name_data_arr[$count_first_name]['text'] = $item->first_name;
					$count_first_name++;
				}
			}
			if(!empty($item->email)){
				//email_data
				if (!in_array(array('id'=>$item->email, 'text'=>$item->email), $email_data_arr)){
					$email_data_arr[$count_email]['id'] = $item->email;
					$email_data_arr[$count_email]['text'] = $item->email;
					$count_email++;
				}
			}
		}

		$this->load->model('AlumnoModel');
		$data_students = $this->AlumnoModel->getStudentsIdFields();

		foreach ($data_students as $k=>$item){
			if(!empty($item->surname)){
				//surname_data
				if (!in_array(array('id'=>$item->surname, 'text'=>$item->surname), $surname_data_arr)){
					$surname_data_arr[$count_surname]['id'] = $item->surname;
					$surname_data_arr[$count_surname]['text'] = $item->surname;
					$count_surname++;
				}
			}

			if(!empty($item->first_name)){
				//first_name_data
				if (!in_array(array('id'=>$item->first_name, 'text'=>$item->first_name), $first_name_data_arr)){
					$first_name_data_arr[$count_first_name]['id'] = $item->first_name;
					$first_name_data_arr[$count_first_name]['text'] = $item->first_name;
					$count_first_name++;
				}
			}
			if(!empty($item->email)){
				//email_data
				if (!in_array(array('id'=>$item->email, 'text'=>$item->email), $email_data_arr)){
					$email_data_arr[$count_email]['id'] = $item->email;
					$email_data_arr[$count_email]['text'] = $item->email;
					$count_email++;
				}
			}
		}

		$this->load->model('ProfesorModel');
		$data_teachers = $this->ProfesorModel->getTeachersIdFields();

		foreach ($data_teachers as $k=>$item){
			if(!empty($item->surname)){
				//surname_data
				if (!in_array(array('id'=>$item->surname, 'text'=>$item->surname), $surname_data_arr)){
					$surname_data_arr[$count_surname]['id'] = $item->surname;
					$surname_data_arr[$count_surname]['text'] = $item->surname;
					$count_surname++;
				}
			}

			if(!empty($item->first_name)){
				//first_name_data
				if (!in_array(array('id'=>$item->first_name, 'text'=>$item->first_name), $first_name_data_arr)){
					$first_name_data_arr[$count_first_name]['id'] = $item->first_name;
					$first_name_data_arr[$count_first_name]['text'] = $item->first_name;
					$count_first_name++;
				}
			}

			if(!empty($item->email)){
				//email_data
				if (!in_array(array('id'=>$item->email, 'text'=>$item->email), $email_data_arr)){
					$email_data_arr[$count_email]['id'] = $item->email;
					$email_data_arr[$count_email]['text'] = $item->email;
					$count_email++;
				}
			}
		}
		$this->data['surname_data'] = $surname_data_arr;
		$this->data['first_name_data'] = $first_name_data_arr;
		$this->data['email_data'] = $email_data_arr;
	}

	protected function get_sent_recipients($campaign_id){

		$this->load->model('ContactosModel');
		$this->load->model('AlumnoModel');
		$this->load->model('ProfesorModel');
		$this->load->model('PresupuestotModel');
		$this->load->model('MatriculatModel');

		$recipients = array();
		if(empty($campaign_id) || !is_numeric($campaign_id)
		){
			return null;
		}
		$selected_recipients = $this->data['selected_recipients'];


		foreach($selected_recipients as $recipient_email){


			if (isset($recipient_email->email_recipie) && !empty($recipient_email->email_recipie)
				&& !filter_var($recipient_email->email_recipie, FILTER_VALIDATE_EMAIL) === false
			){
				$recipient = $this->ContactosModel->getContactosByEmailForRecipient($recipient_email->email_recipie);

				if(empty($recipient)){
					$recipient = $this->AlumnoModel->getStudentsByEmailForRecipient($recipient_email->email_recipie);
				}
				if(empty($recipient)){
					$recipient = $this->ProfesorModel->getTeachersByEmailForRecipient($recipient_email->email_recipie);
				}
				if(empty($recipient)){
					$recipient = $this->PresupuestotModel->getProspectsByEmailForRecipient($recipient_email->email_recipie);
				}
				if(empty($recipient)){
					$recipient = $this->MatriculatModel->getEnrollmentsByEmailForRecipient($recipient_email->email_recipie);
				}
				if(isset($recipient[0]) && !empty($recipient[0])){
					$recipients[] = $recipient[0];
				}
			}
		}

		return $recipients;
	}

	/*
	public function delete($campaign_id = null){
		if(empty($campaign_id) || !is_numeric($campaign_id)){
			$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
		}else{
			$delete_campaign = $this->ErpEmailsCampaignModel->deleteItem($campaign_id);
			if($delete_campaign){
				$this->session->set_flashdata('success', $this->lang->line('campaigns_campaign_deleted'));
			}else{
				$this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
			}
		}
		redirect('campaigns');
	}
	*/

	public function delete_item(){
		$response['success'] = false;
		$response['errors'] = true;
		$campaign_id = $this->input->post('campaign_id', true);
		if(empty($campaign_id) || !is_numeric($campaign_id)){
			print_r(json_encode($response));
			exit;
		}

		$campaign = $this->ErpEmailsCampaignModel->getById($campaign_id);
		if(isset($campaign[0]->state) && $campaign[0]->state != 2){
			$deleted = $this->ErpEmailsCampaignModel->deleteItem($campaign_id);

			if($deleted){
				$response['success'] = true;
				$response['errors'] = false;
			}
		}

		print_r(json_encode($response));
		exit;
	}

	public function delete_all_checked(){
		$response['success'] = false;
		$response['errors'] = array();
		if($this->input->post()){
			$campaign_ids = $this->input->post('campaign_ids', true);
			if(is_array($campaign_ids)){
				$affected_rows = $this->ErpEmailsCampaignModel->bulk_delete($campaign_ids);
				$campaign_ids_count = count($campaign_ids);
				if($campaign_ids_count > $affected_rows){
					if($affected_rows > 0){
						$response['success'] = $this->lang->line('campaigns_campaigns_deleted_not_all');
						$response['errors'] = false;
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
				}elseif($campaign_ids_count == $affected_rows){
					if($affected_rows > 0){
						$response['success'] = $this->lang->line('campaigns_campaigns_deleted');
						$response['errors'] = false;
					}else{
						$response['errors'][] = $this->lang->line('db_err_msg');
					}
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

	public function add_new_folder(){
		$response['success'] = false;
		$response['errors'] = array();
		$response['new_folder_id'] = null;
		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'new_folder_name',
					'label' => $this->lang->line('campaigns_new_folder_name'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);
//			$this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

			if ($this->form_validation->run()) {
					$new_folder_name = $this->input->post('new_folder_name', true);
					$folder_exist = $this->ErpEmailsCampaignFolderModel->getFolderByTitle($new_folder_name);
					if(empty($folder_exist)){
						$folder_insert = $this->ErpEmailsCampaignFolderModel->insertFolder($new_folder_name);
						if($folder_insert){
							$response['new_folder_id'] = $folder_insert;
							$response['success'] = $this->lang->line('campaigns_create_folder_success');
							$response['errors'] = false;
						}else{
							$response['errors'][] = $this->lang->line('db_err_msg');
						}
					}else{
						$response['errors'][] = $this->lang->line('campaigns_folder_exist');
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

	public function add_campaign_steps(){
		$this->load->model('ErpEmailsTemplateModel');
		$html = '';
		$step_id = $this->input->get('step_id', true);
		if(!empty($step_id)){
//			$this->data['all_campaigns_count'] = $this->ErpEmailsCampaignModel->getTotalCount();
			$this->data['folders'] = $this->ErpEmailsCampaignFolderModel->getFoldersWithCampaignCounts();
			switch ($step_id) {
				case 1:
					$html .= $this->load->view('campaigns/partials/add_campaign_steps/step1.php', $this->data, true);
        		break;
				case 2:
					$html .= $this->load->view('campaigns/partials/add_campaign_steps/step2.php', $this->data, true);
        		break;
				case 3:
					$this->data['templates'] = $this->ErpEmailsTemplateModel->getAllTemplates();
					$html .= $this->load->view('campaigns/partials/add_campaign_steps/step3.php', $this->data, true);
        		break;
				case 4:
					$this->recipients_segments();
					$this->filter_by_items();
					$this->load->model('ErpTagsModel');
					$this->data['tags'] =  $this->ErpTagsModel->getTags();
					$tags_for_filter = array();
					if(!empty($this->data['tags'])) {
						foreach ($this->data['tags'] as $tags){
							$tags_for_filter[] = array('id' => $tags->id, 'text' => $tags->tag_name,
								'back_color' => $tags->hex_backcolor, 'text_color' => $tags->hex_forecolor);
						}
					}
					$this->data['tags_for_filter'] = $tags_for_filter;
					$html .= $this->load->view('campaigns/partials/add_campaign_steps/step4.php', $this->data, true);
        		break;
				case 5:
					$html .= $this->load->view('campaigns/partials/add_campaign_steps/step5.php', $this->data, true);
        		break;
				default:
			}
		}

		print_r(json_encode($html));
		exit;
	}

	public function add_campaign_finish(){
		$this->load->model('UsuarioModel');

		$response['success'] = array();
		$response['errors'] = array();
		$response['new_campaign_id'] = null;
		if($this->input->post()){
			$this->config->set_item('language', $this->data['lang']);
			$config = array(
				array(
					'field' => 'title',
					'label' => $this->lang->line('campaigns_new_title'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'Subject',
					'label' => $this->lang->line('campaigns_new_subject'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'id_folder',
					'label' => $this->lang->line('campaigns_new_id_folder'),
					'rules' => 'trim|required|is_natural_no_zero'
				),
				array(
					'field' => 'Body',
					'label' => $this->lang->line('campaigns_new_body'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'state',
					'label' => $this->lang->line('campaigns_new_state'),
					'rules' => 'trim|required'
				),
				array(
					'field' => 'date_sending',
					'label' => $this->lang->line('campaigns_new_date_sending'),
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run()) {
					$data_campaign = $this->input->post(NULL, true);
					$data_campaign['title'] = html_purify($data_campaign['title']);
					$data_campaign['Subject'] = html_purify($data_campaign['Subject']);
					$data_campaign['Body'] = html_purify($data_campaign['Body']);
					$data_campaign['user_id'] = $this->data['userData'][0]->Id;

					$recipients = $data_campaign['recipients'];
					unset($data_campaign['recipients']);



					$added_campaign_id = $this->ErpEmailsCampaignModel->addCampaign($data_campaign);
					if($added_campaign_id){
						$response['new_campaign_id'] = $added_campaign_id;
						$response['success'][] = $this->lang->line('campaigns_add_success');

						$campaign_recipie_unique = array();						
						foreach ($recipients as $k=>$recipient) {
							$valid_recipie_email = false;
							if (isset($recipient['email'])
								&& !empty($recipient['email'])
								&& !filter_var($recipient['email'], FILTER_VALIDATE_EMAIL) === false
							) {
								
								$campaign_recipie = array(
									'id_campaign' => $added_campaign_id,
									'email_recipie' => $recipient['email'],
								);
								if(!in_array($campaign_recipie, $campaign_recipie_unique)){
									$campaign_recipie_unique[$k] = $campaign_recipie;
									$this->ErpEmailsCampaignRecipieModel->addItem($campaign_recipie);
									$valid_recipie_email = true;
								}
							}
							if ($data_campaign['state'] == 2) {
								if ($valid_recipie_email) {
									$user_id = $this->session->userdata('userData')[0]->Id;

									$cisess = $this->session->userdata('_cisess');
									$membership_type = $cisess['membership_type'];
									$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
									if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
										$data_recipient = array(
											'from_userid' => $user_id,
											'id_campaign' => '',
											'email_recipie' =>  $recipient['email'],
											'Subject' => $data_campaign['Subject'],
											'Body' =>$data_campaign['Body'],
											'date' => date('Y-m-d H:i:s'),
										);
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
										$mail->AddAddress($recipient['email']);
										$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
										$mail->IsHTML(true);
										// set email format to HTML

										$mail->Subject = $data_campaign['Subject'];
										$mail->Body    = $data_campaign['Body'];
										$mail->AltBody = "";
										if(!$mail->Send()) {
											$response['errors'][] = $this->lang->line('campaigns_no_send_test_email');
											$data_recipient['sucess'] = '0';
										}else {
											$response['success'][] = $this->lang->line('campaigns_send_email_success');
											$response['errors'] = false;
											$data_recipient['sucess'] = '1';
										}

										$this->ErpEmailModel->insertEmailData($data_recipient);

									}else {

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
											$request['Destination']['ToAddresses'] = array($recipient['email']);
											$request['Message']['Subject']['Data'] = $data_campaign['Subject'];
											$request['Message']['Subject']['Charset'] = "UTF-8";
											$request['Message']['Body']['Html']['Data'] = $data_campaign['Body'];
											$request['Message']['Body']['Charset'] = "UTF-8";

											try {
												$result = $client->sendEmail($request);
												$messageId = $result->get('MessageId');
												//echo("Email sent! Message ID: $messageId"."\n");
												if ($messageId) {
													$data_recipient = array(
														'from_userid' => $data_campaign['user_id'],
														'id_campaign' => $added_campaign_id,
														'email_recipie' => $recipient['email'],
														'Subject' => $data_campaign['Subject'],
														'Body' => $data_campaign['Body'],
														'date' => date('Y-m-d H:i:s'),
														'sucess' => '1',
													);
													$added_email_id = $this->ErpEmailModel->addEmail($data_recipient);
													$response['success'][] = $this->lang->line('campaigns_send_email_success');
													$response['errors'] = false;
												} else {
													$response['errors'][] = $this->lang->line('campaigns_no_send_email');
												}

											} catch (Exception $e) {
												//echo("The email was not sent. Error message: ");
												//$response['errors'] = $e->getMessage()."\n";
												$response['errors'] = true;
												$response['errors'][] = $e->getMessage();
												$data_recipient = array(
													'from_userid' => $data_campaign['user_id'],
													'id_campaign' => $added_campaign_id,
													'email_recipie' => $recipient['email'],
													'Subject' => $data_campaign['Subject'],
													'Body' => $data_campaign['Body'],
													'date' => date('Y-m-d H:i:s'),
													'sucess' => '0',
													'error_msg' => $e->getMessage(),
												);
												$added_email_id = $this->ErpEmailModel->addEmail($data_recipient);
											}
										} else {
											$response['errors'][] = $recipient['email'] . " " . $this->lang->line('emails_limit_daily_msg');
										}
									}
								} else {
									$response['errors'][] = $this->lang->line('db_err_msg');
								}
							}
						}
						//$response['errors'] = false;
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
		$this->load->model('UsuarioModel');
		$response['success'] = false;
		$response['errors'] = array();
		$response['test_email_id'] = null;
		if($this->input->post()){

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

						$cisess = $this->session->userdata('_cisess');
						$membership_type = $cisess['membership_type'];
						$smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
						if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
							$data_recipient = array(
								'from_userid' => $user_id,
								'id_campaign' => '',
								'email_recipie' => $email_item,
								'Subject' => $subject,
								'Body' => $body,
								'date' => date('Y-m-d H:i:s'),
							);
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
							$mail->AddAddress($email_item);
							$mail->WordWrap = 1000;                                 // set word wrap to 50 characters
							$mail->IsHTML(true);
							// set email format to HTML

							$mail->Subject = $subject;
							$mail->Body    =$body;
							$mail->AltBody = "";
							if(!$mail->Send()) {
								$response['errors'][] = $this->lang->line('campaigns_no_send_test_email');
								$data_recipient['sucess'] = '0';
							}else {
								$response['success'] = $this->lang->line('campaigns_send_email_success');
								$response['errors'] = false;
								$data_recipient['sucess'] = '1';
							}

							$this->ErpEmailModel->insertEmailData($data_recipient);

						}else{
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
										$response['success'] = $this->lang->line('campaigns_send_email_success');
										$response['errors'] = false;
									} else {
										$response['errors'][] = $this->lang->line('campaigns_no_send_email');
									}

								} catch (Exception $e) {
									//echo("The email was not sent. Error message: ");
									//$response['errors'] = $e->getMessage()."\n";
									$response['errors'][] = $this->lang->line('campaigns_no_send_test_email');
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

	public function get_campaigns(){
		$response = array();
		$total_campaigns = $this->ErpEmailsCampaignModel->getTotalCount();

		if($this->input->post()){
			if($this->input->is_ajax_request()){

				$start =$this->input->post('start',  true);
				$length =$this->input->post('length', true);
				$draw = $this->input->post('draw', true);
				$search =$this->input->post('search', true);
				$order = $this->input->post('order', true);
				$columns = $this->input->post('columns', true);
				$column = $order[0]['column'];



				$total_records = $total_campaigns;

				$campaigns = $this->ErpEmailsCampaignModel->getCampaignsByAjax($start, $length, $draw, $search, $order, $columns);

				$items = $campaigns;
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

	public function get_recipients(){
		$response = array();
		$this->load->model('ContactosModel');
		$this->load->model('AlumnoModel');
		$this->load->model('ProfesorModel');
		$total_contactos = $this->ContactosModel->getTotalCount();
		$total_students = $this->AlumnoModel->getTotalCount();
		$total_teachers = $this->ProfesorModel->getTotalCount();

		$total_recipients = $total_contactos + $total_students + $total_teachers;

		if($this->input->post()){
			if($this->input->is_ajax_request()){

				$start =$this->input->post('start',  true);
				$length =$this->input->post('length', true);
				$draw = $this->input->post('draw', true);
				$search =$this->input->post('search', true);
				$order = $this->input->post('order', true);
				$columns = $this->input->post('columns', true);
				$column = $order[0]['column'];

				$total_records = $total_recipients;
				$items = array();
				if(isset($columns[0]['search']['value']) && is_numeric($columns[0]['search']['value'])){
					switch ($columns[0]['search']['value']) {
						case 1: //Contactos
							$total_records = $total_contactos;
							$items = $this->ContactosModel->getContactosByAjax($start, $length, $draw, $search, $order, $columns);
							break;
						case 2: //Studnents
							$total_records = $total_students;
							$items = $this->AlumnoModel->getStudentsByAjax($start, $length, $draw, $search, $order, $columns);
							break;
						case 3: //Teachers
							$total_records = $total_teachers;
							$items = $this->ProfesorModel->getTeachersByAjax($start, $length, $draw, $search, $order, $columns);
							break;
						default:
					}
        		}else{
					$contactos = $this->ContactosModel->getContactosByAjax($start, $length / 3, $draw, $search, $order, $columns);
					$students = $this->AlumnoModel->getStudentsByAjax($start, $length / 3, $draw, $search, $order, $columns);
					$teachers = $this->ProfesorModel->getTeachersByAjax($start, $length / 3, $draw, $search, $order, $columns);

					foreach($contactos as $c){
						$items[] = $c;
					}
					foreach($students as $s){
						$items[] = $s;
					}
					foreach($teachers as $t){
						$items[] = $t;
					}
				}

				$items_count = count($items);
				$recordsTotal = (int)$total_records - $items_count;
//
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

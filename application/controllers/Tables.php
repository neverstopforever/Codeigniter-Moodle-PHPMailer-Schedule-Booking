<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property ErpTablesModel $ErpTablesModel
 */
class Tables extends MY_Controller {

	 public function __construct(){

         parent::__construct();
         $this->load->model('ErpTablesModel');
         $this->lang->load('quicktips', $this->data['lang']);
         $this->load->library('form_validation');
			// Your own constructor code
			// $this->config->set_item('language', $lang == '' ? "english" : $lang);
		 if(!$this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == ''){
			 redirect('/auth/login/', 'refresh');
		 }


         $this->layouts->add_includes('js', 'app/js/tables/main.js');
	 }

	public function index($IdMedio=''){
		$this->layouts->add_includes('js', 'app/js/tables/index.js');
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			if($IdMedio!='')
			{
				$this->data['page']='Data Records';
				$this->layouts->view('DataRecordsEntriesView', $this->data);
			}else
			{
				$this->data['page']='Data Records';
				$this->layouts->view('DataRecordsView', $this->data);
			}
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function tablesContainer(){
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$details = $this->magaModel->SelectAll('erp_tables');
			print_r(json_encode($details));
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}
	public function secondaryTables(){
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
			{
				$details = $this->magaModel->SelectAll('medios');
				print_r(json_encode($details));
			}
			else
			{
				redirect('/auth/login/', 'refresh');
			}
	}

	public function IdMedioExits(){
		if ($this->input->post()) {
			if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
			{
				$IdMedio = $this->input->post('IdMedio');
				$details = $this->magaModel->recordExist('medios',array('IdMedio'=>$IdMedio));
				print_r($details);
			}
			else
			{
				redirect('/auth/login/', 'refresh');
			}
		}

	}

	public function specific(){
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$tableName = $this->input->get('tableName');
            $check_table_name = $this->ErpTablesModel->getTables(array('table_name' => $tableName));
            if(!empty($check_table_name)) {
                $details = $this->magaModel->selectAllWithFieldsCustom($tableName);
                foreach ($details['result'] as $k => &$value) {
                    foreach($value as  &$val) {
                        $val = utf8_decode($val);
                    }
                }
                echo json_encode($details);
                exit;
            }
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function tableData(){
		if ($this->input->post()) {
			$tableName = $this->input->post('tableName', true);
			$formData = $this->input->post('formData', true);
			$task = $this->input->post('task', true);
			$details = '';
			$errors = '';
			$id_str = '';
			$primary_key = false;
			$primary_key_type = false;
			$check_table_name = $this->ErpTablesModel->getTables(array('table_name' => $tableName));
			//var_dump($check_table_name);exit;
			if(!empty($check_table_name)) {
				$getFieldList = $this->ErpTablesModel->getTableFields($tableName);
				foreach($getFieldList as $field){
					if($field->primary_key) {
						$primary_key = $field->name;
						$primary_key_type = $field->type;
						$id = isset($formData[$field->name]) ? $formData[$field->name] :
							($task == 'delete' && $this->input->post('id') ? $this->input->post('id') : null);
						$id_str = $field->name . "='" . $id . "'";
					}
					$fields_[$field->name] = $field->name;
				}

				//var_dump($getFieldList);exit;
				/*if($task == 'insert' || $task == 'update') {
					$newFormData = array();
					foreach ($formData as $k => $form) {
						if(!empty($form)) {
							$newFormData[$k] = utf8_encode($form);
						}
					}
				}*/

					if($task == 'insert') {
						if(!empty($id)){
							if($primary_key_type == 'int') {
								if (ctype_digit($id)) {
									$where = array($primary_key => $id);
									$checkingUnique = $this->ErpTablesModel->checkingUniqueId($tableName, $where);
									if (empty($checkingUnique)) {
										$newFormData = array();
										foreach ($formData as $k => $form) {
											if(isset($fields_[$k])) {
												$newFormData[$k] = utf8_encode($form);
											}
										}
									}else{
										$errors = $this->lang->line('id_is_not_unique');
									}
								}else{
									$errors = $this->lang->line('id_must_be_int');
								}
							}else{
								$where = array($primary_key => $id);
								$checkingUnique = $this->ErpTablesModel->checkingUniqueId($tableName, $where);
								if (empty($checkingUnique)) {
									$newFormData = array();
									foreach ($formData as $k => $form) {
										if(isset($fields_[$k])) {
											$newFormData[$k] = utf8_encode($form);
										}
									}
								}else{
									$errors = $this->lang->line('id_is_not_unique');
								}
							}
						}else{
							$errors = $this->lang->line('error_empty_form');
						}
					}

				if($task == 'update'){
					$newFormData = array();

					foreach ($formData as $k => $form) {
						if(isset($fields_[$k]) && $k != $primary_key) {
							$newFormData[$k] = utf8_encode($form);
						}
					}
				}

				if ($task == 'insert') {
					if(!empty($newFormData)) {
						$details = $this->magaModel->customInsert($tableName, $newFormData);
					}
				} elseif ($task == 'update') {
					if(!empty($newFormData) && !empty($id_str)) {
						$details = $this->magaModel->customUpdate($tableName, $newFormData, $id_str);
					}
				} elseif ($task == 'delete') {
					if(!empty($id_str)) {
						$details = $this->magaModel->customDelete($tableName, $id_str);
					}
				} elseif ($task == 'validateUniquePrimaryKey') {
					$id = $this->input->post('id', true);
					$details = $this->magaModel->recordExist($tableName, $id);
				}
				echo json_encode(array('data' => $details, 'errors' => $errors));
				exit;
			}
		}
	}


}


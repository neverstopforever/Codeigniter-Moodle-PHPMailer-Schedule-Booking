<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(E_ALL);
class Tables extends MY_Controller {

	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
			// $this->config->set_item('language', $lang == '' ? "english" : $lang);
       }
	public function index_get($IdMedio='')
	{
            
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			if($IdMedio!='')
			{
				$data=array();
				$data['page']='Data Records';
				$this->load->view('DataRecordsEntriesView', $data);	
			}else
			{
				$data=array();
				$data['page']='Data Records';
				$this->load->view('DataRecordsView', $data);	
			}
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}
	public function tablesContainer_get()
	{
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
	public function secondaryTables_get()
	{
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
	function IdMedioExits_post()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$IdMedio = $this->post('IdMedio');
			$details = $this->magaModel->recordExist('medios',array('IdMedio'=>$IdMedio));
			prinr_r($details);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}	
	}
	function specific_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$tableName = $this->get('tableName');
			$details = $this->magaModel->selectAllWithFields($tableName);
			print_r(json_encode($details));
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}		
	}
	function tableData_post()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$tableName = $this->post('tableName');
			$formData = $this->post('formData');
			$task = $this->post('task');
			if($task == 'insert')
			{
				$details = $this->magaModel->insert($tableName,$formData);
			}
			elseif ($task == 'update') {
				$id = $this->post('id');
				$details = $this->magaModel->update($tableName,$formData,$id);
			}
			elseif($task == 'delete')
			{
				$id = $this->post('id');
				$details = $this->magaModel->delete($tableName,$id);	
			}
			elseif ($task ==  'validateUniquePrimaryKey') {
				$id = $this->post('id');
				$details = $this->magaModel->recordExist($tableName,$id);	
			}
			print_r($details);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}		
	}

}

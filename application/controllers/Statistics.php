<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends MY_Controller {


	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
		   $this->layouts->add_includes('js', 'app/js/statistics/main.js');
    }
	public function index()
	{
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/statistics/index.js');
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$this->data['page']='Statistics';
			$this->layouts->view('StatisticsView',$this->data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function categorias()
	{
		$details=$this->magaModel->selectAll('lst_informes_sec');
		print_r(json_encode($details));
	}


	public function Statistics()
	{
		$id=$this->input->get('id');
		$details=array();
		$firstdetails=$this->magaModel->selectOne('lst_estadist',array('id'=>$id));
		if(sizeof($firstdetails))
		{
			$idinforme = $firstdetails[0]->id;
			$titulo = $firstdetails[0]->titulo;
			$csql = $firstdetails[0]->csql;
			$details['data']=$this->magaModel->selectCustom(encodeToUtf8($csql));
		}
		else
		{
			$details['data']=array();
		}
		print_r(json_encode($details));
	}
	public function comboStatistics()
	{
		$idsec=$this->input->get('idsec');
		$details=$this->magaModel->selectAllWhere('lst_estadist',array('idseccion'=>$idsec));
		print_r(json_encode($details,true));
	}
}

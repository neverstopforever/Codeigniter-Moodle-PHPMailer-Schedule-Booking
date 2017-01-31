<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 */
class Statistics extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://examplse.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
		    $this->load->model();
    }
	public function index_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='Statistics';
			$this->load->view('StatisticsView',$data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function categorias_get()
	{
		$details=$this->magaModel->selectAll('lst_informes_sec');
		print_r(json_encode($details));
	}


	public function Statistics_get()
	{
		$id=$this->get('id');
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
	public function comboStatistics_get()
	{
		$idsec=$this->get('idsec');
		$details=$this->magaModel->selectAllWhere('lst_estadist',array('idseccion'=>$idsec));
		print_r(json_encode($details,true));
	}
}

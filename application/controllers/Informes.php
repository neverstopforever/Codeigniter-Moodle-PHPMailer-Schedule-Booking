<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informes extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
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
			$this->load->model('LstInformesSecModel');
			$this->load->model('LstInformeModel');
		    $this->layouts->add_includes('js', 'app/js/informes/main.js');
    }
	public function index()
	{
        $this->lang->load('quicktips', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/informes/index.js');
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$this->data['page']='Information';
			$this->layouts->view('InformesView', $this->data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function categorias()
	{
		$details=$this->LstInformesSecModel->getCategorias();
		print_r(json_encode($details));
	}


	public function informes()
	{
		$id=$this->input->get('id');
		$details=array();
		$firstdetails= $this->LstInformeModel->getInformes($id);
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
	public function comboInformes()
	{
		$idsec=$this->input->get('idsec');
		$details = $this->LstInformeModel->getAllWhere($idsec);
		print_r(json_encode($details,true));
	}
}

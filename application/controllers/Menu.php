<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property magaModel $magaModel
 * @property ErpMenuToolbarModel $ErpMenuToolbarModel
 */
class Menu extends MY_Controller {

    public function __construct()
       {
            parent::__construct();
            // Your own constructor code
			$this->load->model('ErpMenuToolbarModel');
    }
    public function all()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$details= $this->ErpMenuToolbarModel->getAll();
		print_r(json_encode($details));
	}
	 public function all_en()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$details= $this->ErpMenuToolbarModel->getAllEn();
		print_r(json_encode($details));
	}
	 public function all_es()
	{
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$details= $this->ErpMenuToolbarModel->getAllEs();
		print_r(json_encode($details));
	}
}

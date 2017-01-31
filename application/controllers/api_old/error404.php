<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'Base_controller.php';
/**
 *
 */
class Error404 extends CI_controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('404');
//		$this->data['content'] = 'error_404'; // View name
		$this->load->view('error_404',$this->data);//loading in my template
	}
}

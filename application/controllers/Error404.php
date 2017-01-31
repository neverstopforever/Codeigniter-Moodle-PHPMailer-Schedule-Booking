<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Error404 extends MY_controller {

	public function __construct()
	{
		parent::__construct();
		$this->layout = 'error_404';
	}

	public function index()
	{
		$this->output->set_status_header('404');
		$this->layouts->view('error_404',$this->data, $this->layout);
	}
}

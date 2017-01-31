<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (empty($this->_identity['loggedIn'])) {
			redirect('/auth/login/', 'refresh');
		}
		$this->lang->load('help', $this->data['lang']);
		$this->layouts->add_includes('js', 'app/js/help/main.js');

		
	}

	public function index()
	{
		$this->data['page'] = 'help_index';
		$this->layouts->add_includes('js', 'app/js/help/index.js');
		$this->layouts->view('help/index', $this->data);
	}
	public function documentation()
	{
		$this->data['page'] = 'help_index';
		$this->layouts->add_includes('js', 'app/js/help/documentation.js');
		$this->layouts->view('help/documentation', $this->data);
	}
	public function training()
	{
		$this->data['page'] = 'help_index';
		$this->layouts->add_includes('js', 'app/js/help/training.js');
		$this->layouts->view('help/training', $this->data);
	}
	
	public function releases()
	{
		$this->data['page'] = 'help_index';
		$this->layouts->add_includes('js', 'app/js/help/releases.js');
		$this->layouts->view('help/releases', $this->data);
	}

	public function forums()
	{
		$this->data['page'] = 'help_index';
		$this->layouts->add_includes('js', 'app/js/help/forums.js');
		$this->layouts->view('help/forums', $this->data);
	}

	public function developers()
	{
		$this->data['page'] = 'help_index';
		$this->layouts->add_includes('js', 'app/js/help/developers.js');
		$this->layouts->view('help/developers', $this->data);
	}
	
}

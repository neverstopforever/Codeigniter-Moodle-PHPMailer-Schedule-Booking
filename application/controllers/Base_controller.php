<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Base_controller extends CI_Controller {

    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $this->data['lang']=$this->session->userdata('lang');
        $this->data['color']=$this->session->userdata('color') == '' ? 'default' : $this->session->userdata('color');
        $this->data['layoutFormat']=$this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['page']= $this->router->fetch_class();
        $this->lang->load('site', $this->data['lang']);


        if($this->session->has_userdata("_cisess")){
            $db_details = (object)$this->session->userdata("_cisess");
        }elseif($this->input->cookie('_cisess', TRUE)){
            $_cisess = $this->input->cookie('_cisess', TRUE);
//            $this->_db_details = json_decode(base64_decode($_cisess));
            $key = base64_decode($_cisess);
            $this->load->model('ClientesAkaudModel');
            $res = $this->ClientesAkaudModel->getByKey($key);
            $db_details = isset($res[0]) ? (array)$res[0] : null;
            $this->session->set_userdata('_cisess', $db_details);
            $db_details = !empty($db_details) ? (object)$db_details : null;
        }
        if(isset($db_details) && !empty($db_details)){
            $db_new_config = array(
                'dsn'	=> '',
                'hostname' => $db_details->DBHost_IPserver,
                'username' => $db_details->DBHost_user,
                'password' => $db_details->DBHost_pwd,
                'database' => $db_details->DBHost_db,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
            $this->db = $this->load->database($db_new_config, true);
        }
    }


}

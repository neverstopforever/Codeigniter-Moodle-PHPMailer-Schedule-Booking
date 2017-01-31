<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
* @property UsuarioModel $UsuarioModel

 **/
class LockedProfile extends Public_Controller {


    public  $data;
    public  $_user_details;

    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->data['page'] = 'profile';
        $this->_user_details = !empty($this->session->userdata("userLockedData")) ? (object)$this->session->userdata("userLockedData") : null;
        if(!empty($this->_user_details)) {
            $this->data['user'] = $this->_user_details;
            $this->data['user'] = (object)array(
                'id' => $this->_user_details->id,
                'name' => $this->_user_details->user_name,
                'email' => $this->_user_details->email,
                'photo' => $this->_user_details->photo
            );
            $this->layouts->view('user/locked_profile', $this->data, 'locked_profile');
        }else{
            redirect('/auth/login2/', 'refresh');
        }
    }
}

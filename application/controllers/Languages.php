<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Languages extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function getLanguages(){
//        'language = JSON.parse(' print_r(json_encode(languageEncodeToUtf8($this->lang->language)'
        echo "var language = JSON.parse('".json_encode(languageEncodeToUtf8($this->lang->language))."'); var lang ='".$this->session->userdata("lang")."'";
    }
}
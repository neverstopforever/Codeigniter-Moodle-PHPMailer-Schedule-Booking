<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Stripe\Stripe;
use Stripe\Customer;

class Ajax extends MY_Campus_Controller {

    /**
     * Information about the variables
     *
     * @var array
     */
    protected $_response = array();

    public function __construct(){

        parent::__construct();
        if(!$this->input->is_ajax_request()) {
            $this->_response['status'] = false;
            echo json_encode($this->_response);
            exit;
        }
        $this->layout = null;
    }



    public function terms_private() {
        $type = $this->input->post('type', true);
        $this->lang->load('terms_private', $this->data['lang']);
        $this->_response['body'] = '';
        if($type == "terms"){
            $this->_response['body'] .= '<h3>'.$this->lang->line('terms_of_use_access_restirictions').'</h3>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_access_restirictions_text').'</p>';
            $this->_response['body'] .= '<h3>'.$this->lang->line('terms_of_use_terms_of_use').'</h3>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_terms_of_use_text').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_general_terms').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_general_terms_text').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_general_terms_text1').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_general_terms_text2').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_general_terms_text3').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_no_offer').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_no_offer_text').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_intellectual_property').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_intellectual_property_text').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_intellectual_property_text1').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_links').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_links_text').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_links_text1').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_links_text2').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_links_text3').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_monitoring').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_monitoring_text').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_monitoring_text1').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_user_behavior').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_user_behavior_text').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_user_behavior_text1').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_user_behavior_text2').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_user_behavior_text3').'</p>';
            $this->_response['body'] .= '<h4>'.$this->lang->line('terms_of_use_applicable_jurisdiction').'</h4>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_applicable_jurisdiction_text').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_applicable_jurisdiction_text1').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('terms_of_use_applicable_jurisdiction_text2').'</p>';
        }else if($type == "private"){
            $this->_response['body'] .= '<h3>'.$this->lang->line('private_policy_title').'</h3>';
            $this->_response['body'] .= '<p>'.$this->lang->line('private_policy_text1').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('private_policy_text2').'</p>';
            $this->_response['body'] .= '<p>'.$this->lang->line('private_policy_text3').'</p>';
        }
        print_r(json_encode($this->_response['body']));
        exit;
    }


    public function reset_login()
    {
        if (isset($_COOKIE['_cisess']) && isset($_COOKIE['cisession'])) {
            unset($_COOKIE['_cisess']);
            unset($_COOKIE['cisession']);
            setcookie('_cisess', null, -1, '/');
            setcookie('cisession', null, -1, '/');
            $this->session->sess_destroy();
            $this->_response['status'] = true;
        } else {
            $this->_response['status'] = false;
        }
        echo json_encode($this->_response);
        exit;
    }
    public function notificationCount(){
        if($this->session->userdata('userId')){
            $userId = $this->session->userdata('userId');
            $user_role = $this->session->userdata('user_role');
            $this->load->model('MensajeModel');
            $this->load->model('Variables2Model');
            if($userId){
                $message_count = $this->MensajeModel->getNewMessages($userId, $user_role);
            }

            $allow_notification_show = $this->Variables2Model->get_notification_show_val();
            echo json_encode(array('messages_count'=>$message_count->num, 'allow_notification_show'=>$allow_notification_show));
            exit;
        }else{
            echo json_encode(array('redirect_to_login_page'=>true));
            exit;
        }
    }


}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Stripe\Stripe;
use Stripe\Customer;

class Ajax extends MY_Controller {

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

    //update user activity
    public function userLastActivity(){
        $this->_response['user_activity'] = false;
        if (!empty($this->data['userData'])) {
            $this->load->model('UserSessionModel');
            if(isset($this->data['userData'][0]) && isset($this->data['userData'][0]->Id)) {
                $user_id = $this->data['userData'][0]->Id;
                $user_activity = $this->UserSessionModel->getActivity($user_id);
                if(!empty($user_activity)){
                    $update_insert = $this->UserSessionModel->userLastActivity($user_id, 1, true);
                }else{
                    $update_insert = $this->UserSessionModel->userLastActivity($user_id, 1, false);
                }
                if(isset($update_insert) && $update_insert){
                    $this->_response['user_activity'] = true;
                }
            }

        }
        print_r(json_encode($this->_response));
        exit;
    }

    //checkConnection for offline.js
    public function checkConnection(){
        $this->_response['success'] = true;
        print_r(json_encode($this->_response));
        exit;
    }



    public function downgrade_plan_free(){
        
        $this->_response['success'] = false;
        $this->_response['errors'] = array();
        $owner_id = isset($this->_db_details->id) ? $this->_db_details->id : null;      
        if (!empty($owner_id)) {
            $file_path = FCPATH.'app/plan_fields.json';
            $fields = array();
            $update_data = array();
            if(file_exists($file_path)) {
                $plan_json_fields = file_get_contents($file_path);
                $fields = json_decode($plan_json_fields);
            }
            if(!empty($fields)){
                foreach ($fields as $k=>$field){
                   if($field->plan == 1){
                       $update_data = (array)$field;
                       break;
                   }
                }
            }
            if(!empty($update_data)){
                $update_data['paid'] = 0;
                
                $this->load->model('ClientesAkaudModel');                
                $updated = $this->ClientesAkaudModel->updateItem($update_data, array('id'=>$owner_id));
                if($updated){
                    $this->load->model('Variables2Model');
                    $this->Variables2Model->deleteLogo();
//                    Stripe change plan to FREE
                    if (isset($this->_db_details->stripe_customer_id) && !empty($this->_db_details->stripe_customer_id)) {
                        try{
                            Stripe::setApiKey($this->config->item('payment')['stripe']['secretKey']);
                            $customer = Customer::retrieve($this->_db_details->stripe_customer_id);
                            $sub_id = $customer->subscriptions->data[0]->id;
                            $subscription = $customer->subscriptions->retrieve($sub_id);
                            $subscription->plan = 'FREE';
                            $subscription->save();
                        }catch (Exception $er){

                        }
                    }

                    $res = $this->ClientesAkaudModel->findById($owner_id);

                    $db_details = (array)$res;
                    $plan_options = $this->session->userdata('_plan_options');

                    if(isset($db_details['plan'])){
                        $this->load->model('ClientesPlansRelationModel');
                        $plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
                    }
                    $this->session->set_userdata('_plan_options', $plan_options);

//                    $db_details_json_base64_encode = base64_encode(json_encode($db_details));
//                    setcookie('_cisess', $db_details_json_base64_encode,time() + (86400 * 30), "/"); //30 days
                    $key_base64_encode = base64_encode($res->key);
                    setcookie('_cisess', $key_base64_encode,time() + (86400 * 1), "/"); //1 day
                    $this->session->set_userdata('_cisess', $db_details);
                    $this->_response['success'] = $this->lang->line('downgrade_to_free_plan');
                }else{
                    $this->_response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $this->_response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $this->_response['errors'][] = $this->lang->line('db_err_msg');
        }
        echo json_encode($this->_response);
        exit;
        
    }

    public function invoice_pdf(){
        $this->lang->load('paymentsystem', $this->data['lang']);
        $invoice_id = $this->input->post('invoice_id', true);
        
        $this->load->model('InvoiceModel');
        $invoice = $this->InvoiceModel->findById($invoice_id);

        $discount = 0;

        if ($invoice) {
            if ($invoice->paid) {
                $this->data['success'] = $this->lang->line('paymentsystem_invoice_paid');
            }
            $this->data['invoice'] = $invoice;
            $this->data['discount'] = $discount;
            $this->data['_coupon'] = $this->InvoiceModel->getCoupon($invoice->coupon_id);
            
            $this->load->model('ClientesAkaudModel');
            $user = $this->ClientesAkaudModel->getAll(array('id'=>$invoice->owner_id));
            if(isset($user[0]) && !empty($user[0])){
                $user = $user[0];
            }else{
                $user = new ClientesAkaudModel();
            }
            $this->data['owner'] = $user;
            $this->load->model('MiempresaModel');
            $this->data['company'] = $this->MiempresaModel->getCompany();
        }
        if ($this->_db_details->plan != '1') {
            $this->load->model('Variables2Model');
            $logo = $this->Variables2Model->get_logo();
            if (!empty($logo) && isset($logo->logo)) {
                $this->data['customer_logo'] = $logo->logo;
            } else {
                $this->data['customer_logo'] = null;
            }
        }else{
            $this->data['customer_logo'] = null;
        }
        $this->_response['html'] = $this->load->view('ajax/invoice_pdf', $this->data, TRUE);

//        $mpdf = new mPDF('utf-8' , 'A4' , '' , '' , 0 , 0 , 0 , 0 , 0 , 0);
//        $mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list
//
//        $mpdf->WriteHTML($this->_response['html']);
//        $this->html_pdf = false;
//        $mpdf->Output('aaa.pdf', 'D');
//        exit;
//
        print_r(json_encode($this->_response['html']));
        exit;

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
        if(is_array($this->data['userData']) && isset($this->data['userData'][0]->Id)){
            $this->load->model('MensajeModel');
            $this->load->model('AvisosNotaModel');
            $this->load->model('Variables2Model');
            $USUARIO = $this->data['userData'][0]->Id;
            $messages = $this->MensajeModel->getNewMessages($USUARIO, '0');
            $undone_tasks = $this->AvisosNotaModel->getUndoneTasksCount($USUARIO);
            $allow_notification_show = $this->Variables2Model->get_notification_show_val();
            $messages_count =isset($messages->num) ? $messages->num : 0;
            $undone_tasks_count = (isset($undone_tasks[0]) && isset($undone_tasks[0]->num)) ? $undone_tasks[0]->num : 0;
            echo json_encode(array('messages_count'=>$messages_count, 'undone_tasks_count'=>$undone_tasks_count, 'allow_notification_show'=>$allow_notification_show));
            exit;
        }else{
            echo json_encode(array('redirect_to_login_page'=>true));
            exit;
        }
    }


}
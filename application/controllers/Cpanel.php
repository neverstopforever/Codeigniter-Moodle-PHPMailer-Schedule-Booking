<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Stripe\Stripe;
use Stripe\Error\Card as ErrorCard;
use Stripe\Customer;
use Stripe\Coupon as StripeCoupon;
use Aws\Ses\SesClient;
define("AGILE_DOMAIN", "akaud");  # Example : define("domain","jim");
define("AGILE_USER_EMAIL", "hola@akaud.com");
define("AGILE_REST_API_KEY", "hg3nhnpjhtgh232k2rfb1k14ac");
//define("AGILE_DOMAIN", "akaud");  # Example : define("domain","jim");
//define("AGILE_USER_EMAIL", "soporte2@softaula.com");
//define("AGILE_REST_API_KEY", "onag7honfi7107enc8eddpi21i");
class Cpanel extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if(empty($this->_identity['loggedIn']) && !isset($this->data['userData']->level_akaud)){
            $this->session->set_flashdata('errors', array( $this->lang->line('access_denied')));
            redirect('/auth/loginAdmin/', 'refresh');
        }
        $this->data['menu_json_name'] = 'cpanel_menu';
        $this->load->model('ClientesAkaudModel');
        $this->load->model('ClientesAvisosModel');
        $this->load->model('ClientesPlansNameModel');
        $this->load->model('ClientesPlansRelationModel');
        $this->load->model('ClientesPlansOptionModel');
        $this->load->library('form_validation');
        $this->load->library('controllerlist');
        $this->layout = 'cpanel';
        $this->lang->load('cpanel', $this->data['lang']);
        $this->layouts->add_includes('js', 'app/js/cpanel/main.js');
    }

    public function index() {
        $this->layouts->view('cpanel/indexView', $this->data, $this->layout);
    }

    public function alerts() {
        $this->layouts->add_includes('js', 'app/js/cpanel/alerts.js');
        $this->layouts->view('cpanel/alertsView', $this->data, $this->layout);
    }

    public function plan_options() {
        $this->layouts->add_includes('js', 'app/js/cpanel/plan_options.js');

        $this->data['plans'] = $this->ClientesPlansNameModel->getPlans();

        $this->data['current_plan'] = isset($this->_db_details->plan) ? $this->_db_details->plan : null;
        $this->layouts->view('cpanel/plan_options', $this->data, $this->layout);
    }
    public function get_plans_options() {
        $html_lists = '';
        if($this->input->is_ajax_request()){
            $this->data['plan_id'] = $this->input->post('plan_id', true);
            $this->data['plan_options'] = $this->ClientesPlansRelationModel->getOptions($this->data['plan_id']);
            //$this->data['controller_lists'] = $this->controllerlist->getControllers();
            $controllers_json = 'controllers_plan.json';
            $controllersJSON = file_get_contents(base_url().'app/'.$controllers_json);
            $controllers = json_decode($controllersJSON);
            switch ($this->data['plan_id']) {
                case '1':
                    $this->data['plan_type'] = 'FREE';
                break;
                case '2':
                    $this->data['plan_type'] = 'Starter';
                break;
                case '3':
                    $this->data['plan_type'] = 'Basic';
                break;
                case '4':
                    $this->data['plan_type'] = 'Advanced';
                break;
                case '5':
                    $this->data['plan_type'] = 'Corporate';
                break;
                default:
                    $this->data['plan_type'] = '';
            }

            $this->data['controller_lists'] = isset($controllers[0]) ? $controllers[0] : array();
            $html_lists .= $this->load->view('cpanel/partials/get_plans_options', $this->data, true);
        }
        print_r(json_encode($html_lists));
        exit;
    }
    public function edit_plan_options($id_plan) {
        if(!is_numeric($id_plan)){
            $this->session->set_flashdata('errors', array($this->lang->line('db_err_msg')));
            redirect('cpanel/plan_options');
        }
        $success = false;
        $errors = array();
        $data_post = $this->input->post(null, true);
        if(!empty($data_post)){
            $delete_plans_relation = false;
            foreach($data_post as $data_item){
                if(!$delete_plans_relation){
                    $delete_plans_relation = true;
                    $this->ClientesPlansRelationModel->deleteItemByPlanId($id_plan);
                }
                $exist_option = $this->ClientesPlansOptionModel->getOptionsByValue($data_item);
                if(!empty($exist_option)){
                    $id_option = isset($exist_option[0]->id) ? $exist_option[0]->id: null;
                    $plans_relations_data = array('id_plan'=> $id_plan, 'id_option' => $id_option);
                    $plans_relations_new_id = $this->ClientesPlansRelationModel->addItem($plans_relations_data);
                    if($plans_relations_new_id){
                        $success = true;
                        $errors = false;
                    }
                }else{
                    $plan_option_data = array(
                        'option_name' => $data_item,
                        'option_value' => $data_item
                    );
                    $plan_option_new_id = $this->ClientesPlansOptionModel->addItem($plan_option_data);
                    if($plan_option_new_id){
                        $plans_relations_data = array('id_plan'=> $id_plan, 'id_option' => $plan_option_new_id);
                        $plans_relations_new_id = $this->ClientesPlansRelationModel->addItem($plans_relations_data);
                        if($plans_relations_new_id){
                            $success = true;
                            $errors = false;
                        }
                    }else{
                        $errors[] = '<p>'.$data_item.'</p>'.$this->lang->line('db_err_msg');
                    }
                }
            }
        }
        if(!$errors && $success){
            $this->session->set_flashdata('success', $this->lang->line('cpanel_plan_options_updated'));
        }elseif(!empty($errors) && $errors){
            $this->session->set_flashdata('errors', $errors);
        }
        redirect('cpanel/plan_options');
    }

    public function get_alerts() {
        $data['content'] = $this->ClientesAvisosModel->getAlerts();
        echo json_encode($data);
        exit;
    }

    public function alertMessage() {

        $data['alertMessage'] = array();
        $_cisess = $this->session->userdata('_cisess');
        if(!$_cisess){
            $_cisess_hash = $this->input->cookie('_cisess', TRUE);
            if($_cisess_hash){
                $key = base64_decode($_cisess_hash);
                $this->load->model('ClientesAkaudModel');
                $res = $this->ClientesAkaudModel->getByKey($key);
                $_cisess = isset($res[0]) ? (array)$res[0] : null;
                $this->session->set_userdata('_cisess', $_cisess);
            }
        }

        if(isset($_cisess['idcliente'])){
            $id_cliente = $_cisess['idcliente'];
            $data['alertMessage'] = $this->ClientesAvisosModel->getAlertMessage($id_cliente);
        }
        echo json_encode($data);
        exit;

    }

    public function readAlertMessage() {

        $data = array(
            'read' => 1
        );
        $where = array(
            'id' => $this->input->post('alert_mes_id',TRUE)
        );
        $response['success'] = $this->ClientesAvisosModel->updateAlert($data, $where);
        echo json_encode($response);
        exit;
    }

    public function readGlobalAlertMessage() {
        $response['success'] = true;
        $alert_mes_id = $this->input->post('alert_mes_id',true);
        $read_alert_mes_ids = $this->session->userdata('read_alert_mes_ids');
        $read_alert_mes_ids[] = $alert_mes_id;
        $read_alert_mes_ids = array_unique($read_alert_mes_ids);
        $this->session->set_userdata('read_alert_mes_ids', $read_alert_mes_ids);

        echo json_encode($response);
        exit;
    }

    public function check_start_end_dates($start_date){
        $end_date = $this->input->post('enddate', TRUE);
        $end_date_time = strtotime($end_date);
        $start_date_time = strtotime($start_date);

        if ($start_date_time > $end_date_time){
            $this->form_validation->set_message('check_start_end_dates', $this->lang->line('alerts_start_end_dates'));
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function check_dates($date){
        $date_time = strtotime($date);
        if (!$date_time){
            $this->form_validation->set_message('check_dates', '%s ' . $this->lang->line('alerts_invalid_date_format'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function addAlert() {
        if($this->input->post(NULL)) {
            $config = array(
                array(
                    'field' => 'startdate',
                    'label' => $this->lang->line('cpanel_startdate'),
                    'rules' => 'required|callback_check_dates|callback_check_start_end_dates'
                ),
                array(
                    'field' => 'enddate',
                    'label' => $this->lang->line('cpanel_enddate'),
                    'rules' => 'required|callback_check_dates'
                ),
                array(
                    'field' => 'message',
                    'label' => $this->lang->line('cpanel_message'),
                    'rules' => 'required'
                ),
                array(
                    'field' => 'toast',
                    'label' => $this->lang->line('cpanel_toast'),
                    'rules' => 'required'
                ),
                array(
                    'field' => 'title',
                    'label' => $this->lang->line('cpanel_title'),
                    'rules' => 'required'
                )
            );

            $this->form_validation->set_rules($config);
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');


            if ($this->form_validation->run()) {
                $data = array(
                    'idcliente' => $this->input->post('idcliente', TRUE),
                    'read' => $this->input->post('read', TRUE),
                    'startdate' => $this->input->post('startdate', TRUE),
                    'enddate' => $this->input->post('enddate', TRUE),
                    'message' => $this->input->post('message', TRUE),
                    'title' => $this->input->post('title', TRUE),
                    'toast' => $this->input->post('toast', TRUE)
                );

                if ($this->ClientesAvisosModel->addAlert($data)) {
                    $this->session->set_flashdata('success', $this->lang->line('cpanel_add_msg') );
                }else{
                    $this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg') ) );
                }
                redirect('cpanel/alerts', 'refresh');
            }
        }
        $this->data['action'] = 'addAlert';
        $this->data['data'] = new ClientesAvisosModel();
        $this->data['companies'] = $this->ClientesAvisosModel->getCompanies();
        $this->layouts->view('cpanel/addAlertView', $this->data, $this->layout);

    }

    public function editAlert($id = NULL) {
        $this->data['data'] = $this->ClientesAvisosModel->getDataById($id);
        $this->data['action'] = 'editAlert';
        if( !empty($this->data['data']) ){
            if($this->input->post(NULL)) {
                $config = array(
                    array(
                        'field' => 'startdate',
                        'label' => $this->lang->line('cpanel_startdate'),
                        'rules' => 'required|callback_check_dates'
                    ),
                    array(
                        'field' => 'enddate',
                        'label' => $this->lang->line('cpanel_enddate'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'message',
                        'label' => $this->lang->line('cpanel_message'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'toast',
                        'label' => $this->lang->line('cpanel_toast'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'title',
                        'label' => $this->lang->line('cpanel_title'),
                        'rules' => 'required'
                    )
                );

                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

                if ($this->form_validation->run()) {
                    $data = array(
                        'idcliente' => $this->input->post('idcliente', TRUE),
                        'read' => $this->input->post('read', TRUE),
                        'startdate' => $this->input->post('startdate', TRUE),
                        'enddate' => $this->input->post('enddate', TRUE),
                        'message' => $this->input->post('message', TRUE),
                        'title' => $this->input->post('title', TRUE),
                        'toast' => $this->input->post('toast', TRUE)
                    );
                    $where = array(
                        'id' => $id
                    );

                    if ($this->ClientesAvisosModel->updateAlert($data, $where)) {
                        $this->session->set_flashdata('success', $this->lang->line('cpanel_update_msg'));
                    }else{
                        $this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg')));
                    }
                    redirect('cpanel/alerts', 'refresh');

                }
            }


            $this->data['companies'] = $this->ClientesAvisosModel->getCompanies();
            $this->layouts->view('cpanel/editAlertView', $this->data, $this->layout);
        }else{
            redirect('/cpanel', 'refresh');
        }
    }

    public function deleteAlert($id = NULL) {

        if($this->ClientesAvisosModel->deleteAlert($id)){
            $this->session->set_flashdata('success',  $this->lang->line('cpanel_delete_msg'));
        }else{
            $this->session->set_flashdata('errors', array( $this->lang->line('db_err_msg')));

        }
        redirect('cpanel/alerts', 'refresh');
    }

    //manage customers
    public function manage_customers($id = null) {
        $this->load->model('GrupoClientModel');
        $this->data['groups'] = $this->GrupoClientModel->getAll();
        if(!$id) {
            $this->layouts
                ->add_includes('css', 'assets/global/plugins/select2/select2.css')
                ->add_includes('js', 'assets/global/plugins/select2/select2.js')
                ->add_includes('js', 'app/js/cpanel/manage_customers.js');
            $this->load->model('ClientesMainModel');
            $this->data['customers'] = $this->ClientesMainModel->getAll();

            $this->layouts->view('cpanel/manage_customers', $this->data, $this->layout);
        }else{
            $this->layouts
                ->add_includes('css', 'assets/global/plugins/select2/select2.css')
                ->add_includes('js', 'assets/global/plugins/select2/select2.js')
//                ->add_includes('js', 'app/js/cpanel/edit_customer/agile-min.js')
//                ->add_includes('js', 'app/js/cpanel/agile.min.js')
                ->add_includes('js', 'app/js/cpanel/edit_customer/index.js');
            $this->load->model('ClientesMainModel');
            $this->data['customer'] = $this->ClientesMainModel->getAll('cli.ccodcli='.$id);
           
            $this->data['id'] = $id;
            if(isset($this->data['customer'][0]) && !empty($this->data['customer'][0])) {
                $this->data['plans'] = $this->ClientesPlansNameModel->getPlans();
                $this->data['current_plan'] = isset($this->_db_details->plan) ? $this->_db_details->plan : null;

                $this->load->model('ClientesMainModel');
                $this->data['not_exist_customers'] = $this->ClientesMainModel->getNotExistCustomers();
                //$this->data['account_data'] = $this->ClientesAkaudModel->getAll(array('clientes_akaud_accounts.idcliente'=>$id));
                //$this->data['account_data'] = isset($this->data['account_data'][0]) ? $this->data['account_data'][0] : array();
                $this->layouts->view('cpanel/customers_edit/index', $this->data, $this->layout);
            }else{
                redirect('cpanel/manage_customers');
            }
        }
    }

    //customer_accounts
    public function customer_accounts() {
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/select2/select2.css')
            ->add_includes('js', 'assets/global/plugins/select2/select2.js')
            ->add_includes('js', 'app/js/cpanel/customer_accounts.js');

        $this->data['customers'] = $this->ClientesAkaudModel->getAll();

        $this->data['plans'] = $this->ClientesPlansNameModel->getPlans();
        $this->data['current_plan'] = isset($this->_db_details->plan) ? $this->_db_details->plan : null;

        $this->load->model('ClientesMainModel');
        $this->data['not_exist_customers'] = $this->ClientesMainModel->getNotExistCustomers();
        $this->layouts->view('cpanel/customer_accounts', $this->data, $this->layout);
    }
    public function getCustomers(){
        if($this->input->is_ajax_request()){
            $customers = $this->ClientesAkaudModel->getAll();
            echo json_encode(array('data' => $customers));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function get_clients(){
        if($this->input->is_ajax_request()){
            $this->load->model('ClientesMainModel');
            $data = $this->ClientesMainModel->getAll();
            echo json_encode(array('data' => $data));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function add_edit_client($type = 'add'){
        $response['success'] = false;
        $response['errors'] = array();

        if($type != 'add' && $type != "edit"){
            $response['errors'][] = $this->lang->line('db_err_msg');
            print_r(json_encode($response));
            exit;
        }

        if($this->input->post()){
            $this->add_client_rules($type);
            $this->db = $this->load->database("admin_akaud", true);
            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, true);
                $this->load->model('ClientesMainModel');
                $added_edited = $this->ClientesMainModel->addEditCustomer($post_data, $type);
                if($added_edited){
                    if($type == 'add'){
                        $response['success'] = $this->lang->line('cpanel_customer_added');
                    }else{
                        $response['success'] = $this->lang->line('cpanel_customer_updated');
                    }
                    $response['errors'] = false;
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'] =  $this->form_validation->error_array();
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }

        print_r(json_encode($response));
        exit;
    }

    private function add_customer_rules(){
        $this->config->set_item('language', $this->data['lang']);
        $config = array(
            array(
                'field' => 'idcliente',
                'label' => $this->lang->line('cpanel_customer_name'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'start_date',
                'label' => $this->lang->line('cpanel_start_date'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'end_date',
                'label' => $this->lang->line('cpanel_end_date'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'DBHost_IPserver',
                'label' => $this->lang->line('cpanel_DBHost_IPserver'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'DBHost_port',
                'label' => $this->lang->line('cpanel_DBHost_port'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'DBHost_user',
                'label' => $this->lang->line('cpanel_DBHost_user'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'DBHost_pwd',
                'label' => $this->lang->line('cpanel_DBHost_pwd'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'DBHost_db',
                'label' => $this->lang->line('cpanel_DBHost_db'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'key',
                'label' => $this->lang->line('cpanel_key'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'plan',
                'label' => $this->lang->line('cpanel_plan'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
            array(
                'field' => 'concurrent_users',
                'label' => $this->lang->line('cpanel_concurrent_users'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
            array(
                'field' => 'trial_expire',
                'label' => $this->lang->line('cpanel_trial_expire'),
                'rules' => 'trim'
            ),
            array(
                'field' => 'module_campus_teachers_active',
                'label' => $this->lang->line('cpanel_module_campus_teachers_active'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'module_campus_teachers_max_users',
                'label' => $this->lang->line('module_campus_teachers_max_users'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
//            array(
//                'field' => 'module_campus_teachers_expire',
//                'label' => $this->lang->line('cpanel_module_campus_teachers_expire'),
//                'rules' => 'trim|required'
//            ),
            array(
                'field' => 'module_campus_students_active',
                'label' => $this->lang->line('cpanel_module_campus_students_active'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'module_campus_students_max_users',
                'label' => $this->lang->line('cpanel_module_campus_students_max_users'),
                'rules' => 'trim|required|is_natural'
            ),
//            array(
//                'field' => 'module_campus_students_expire',
//                'label' => $this->lang->line('cpanel_module_campus_students_expire'),
//                'rules' => 'trim|required'
//            ),
            array(
                'field' => 'module_campus_companies_active',
                'label' => $this->lang->line('cpanel_module_campus_companies_active'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'module_campus_companies_max_users',
                'label' => $this->lang->line('cpanel_module_campus_companies_max_users'),
                'rules' => 'trim|required|is_natural'
            ),
//            array(
//                'field' => 'module_campus_companies_expire',
//                'label' => $this->lang->line('cpanel_module_campus_companies_expire'),
//                'rules' => 'trim|required'
//            ),
            array(
                'field' => 'emails_limit_daily',
                'label' => $this->lang->line('cpanel_emails_limit_daily'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
            array(
                'field' => 'emails_limit_monthly',
                'label' => $this->lang->line('cpanel_emails_limit_monthly'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
            array(
                'field' => 'space_limit',
                'label' => $this->lang->line('cpanel_space_limit'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
            array(
                'field' => 'records_limit',
                'label' => $this->lang->line('cpanel_records_limit'),
                'rules' => 'trim|required|is_natural_no_zero'
            ),
            array(
                'field' => 'active',
                'label' => $this->lang->line('cpanel_active'),
                'rules' => 'trim|required'
            ),
        );
        $post_data = $this->input->post(NULL, true);
        $this->form_validation->set_data($post_data);
        $this->form_validation->set_rules($config);
    }

    private function add_client_rules($type = 'add'){

        if($type == 'edit'){
            if($this->input->post('old_login', true) != $this->input->post('login', true)) {
                $is_unique_login =  '|is_unique[clientes_akaud.login]';
            } else {
                $is_unique_login =  '';
            }
            $password_required = '';
            if($this->input->post('password', true) || $this->input->post('confirm_password', true)){
                $password_required = '|required';
            }
        }else{
            $is_unique_login =  '|is_unique[clientes_akaud.login]';

            $password_required = '|required';
        }
        
        $this->config->set_item('language', $this->data['lang']);
        $config = array(
            array(
                'field' => 'idgrupo',
                'label' => $this->lang->line('groups'),
                'rules' => 'trim|required|is_natural'
            ),
            array(
                'field' => 'commercial_name',
                'label' => $this->lang->line('cpanel_commercial_name'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'fiscal_name',
                'label' => $this->lang->line('cpanel_fiscal_name'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'country',
                'label' => $this->lang->line('cpanel_country'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'address',
                'label' => $this->lang->line('cpanel_address'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'city',
                'label' => $this->lang->line('cpanel_city'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'province',
                'label' => $this->lang->line('cpanel_province'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'zip_code',
                'label' => $this->lang->line('cpanel_zip_code'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'phone1',
                'label' => $this->lang->line('cpanel_phone1'),
                'rules' => 'trim|required'
            ),
//            array(
//                'field' => 'phone2',
//                'label' => $this->lang->line('cpanel_phone2'),
//                'rules' => 'trim|required'
//            ),
            array(
                'field' => 'contact',
                'label' => $this->lang->line('cpanel_contact'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'email',
                'label' => $this->lang->line('cpanel_email'),
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'web',
                'label' => $this->lang->line('cpanel_web'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'state',
                'label' => $this->lang->line('cpanel_active'),
                'rules' => 'trim|required|is_natural'
            ),
            array(
                'field' => 'state',
                'label' => $this->lang->line('cpanel_active'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'ipserver',
                'label' => $this->lang->line('cpanel_ipserver'),
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'login',
                'label' => $this->lang->line('cpanel_login'),
                'rules' => 'trim|required'.$is_unique_login
            ),
            array(
                'field' => 'password',
                'label' => $this->lang->line('cpanel_password'),
                'rules' => 'trim'.$password_required.'|min_length[6]|max_length[10]'
            ),
            array(
                'field' => 'confirm_password',
                'label' => $this->lang->line('cpanel_confirm_password'),
                'rules' => 'trim'.$password_required.'|min_length[6]|max_length[10]|matches[password]'
            )
        );
        $post_data = $this->input->post(NULL, true);
        $this->form_validation->set_data($post_data);
        $this->form_validation->set_rules($config);
    }

    public function addEditCustomer($type = 'add'){
        $response['success'] = false;
        $response['errors'] = array();
        if($type != 'add' && $type != "edit"){
            $response['errors'][] = $this->lang->line('db_err_msg');
            print_r(json_encode($response));
            exit;
        }

        if($this->input->post()){
            $this->add_customer_rules();

            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, true);
                $added_edited = $this->ClientesAkaudModel->addEditCustomer($post_data, $type);
                if($added_edited){
                    if($type == 'add'){
                        $response['success'] = $this->lang->line('cpanel_customer_added');
                    }else{
                        $response['success'] = $this->lang->line('cpanel_customer_updated');
                    }
                    $response['errors'] = false;
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'] =  $this->form_validation->error_array();
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }

        print_r(json_encode($response));
        exit;
    }
    
    public function getCustomerInfo(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('id', true);
            $client_id = $this->input->post('client_id', true);
            $customer = false;
            if($id){
                $customer = $this->ClientesAkaudModel->getAll(array('clientes_akaud_accounts.id'=>$id));
            }elseif($client_id){
                $customer = $this->ClientesAkaudModel->getAll(array('clientes_akaud_accounts.idcliente' => $client_id));
            }
            echo json_encode(array('data' => $customer));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    
    public function get_client_info(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('id', true);
            $customer = false;
            if($id){
                $this->load->model('ClientesMainModel');
                $customer = $this->ClientesMainModel->getAll('cli.ccodcli='.$id);
            }            
            echo json_encode(array('data' => $customer));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function deleteCustomer(){
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post(null, true);
            $id = isset($post_data['id']) ? $post_data['id'] : null;
            $deleted = false;
            if($id){
                $deleted = $this->ClientesAkaudModel->deleteItem(array('id' => $id));
            }
            echo json_encode(array('status' => $deleted));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
        
    }

    public function delete_client(){
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post(null, true);
            $id = isset($post_data['id']) ? $post_data['id'] : null;
            $deleted = false;
            if($id){
                $this->load->model('ClientesMainModel');
                $deleted = $this->ClientesMainModel->deleteItem(array('ccodcli'=>$id));
            }
            echo json_encode(array('status' => $deleted));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
        
    }

    public function setLang(){
        if($this->input->is_ajax_request()){
            $lang = $this->input->post('lang', true);
            $this->session->set_userdata('lang', $lang);
            echo json_encode(array('status' => 'OK'));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function setLayoutFormat() {
        if($this->input->is_ajax_request()){
            $layoutFormat=$this->input->post('layoutFormat', true);
            $this->session->set_userdata('layoutFormat', $layoutFormat);
            echo json_encode(array('status' => 'OK'));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function manage_invoices(){

        $this->layouts->add_includes('js', 'app/js/cpanel/manage_invoices/index.js');

        $this->load->model('InvoiceModel');
        $this->data['invoices'] = $this->InvoiceModel->findAll();

        $file_path = FCPATH.'app/plan_fields.json';
        $plan_fields = array();
        if(file_exists($file_path)) {
            $plan_json_fields = file_get_contents($file_path);
            $plan_fields = json_decode($plan_json_fields);
        }
        $this->data['plan_fields'] = $plan_fields;

        $this->load->model('ClientesAkaudModel');
        $this->data['customers'] = $this->ClientesAkaudModel->getAll();
        $this->data['payment_perfix'] = $this->config->item('payment_perfix');
        $this->layouts->view('cpanel/manage_invoices/index', $this->data, $this->layout);
    }

    function float_number_check($num)
    {
        if(!is_numeric($num)){
            $this->form_validation->set_message( 'float_number_check', $this->lang->line('form_validation_must_float_type') );
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function edit_invoice(){
        if($this->input->is_ajax_request()){
            $response['errors'] = array();
            $response['html'] = '';
            $invoice_id = $this->input->post('invoice_id', true);
            $this->data['invoice'] = $this->InvoiceModel->findById($invoice_id);
            if(!empty($this->data['invoice'])){
                if($this->data['invoice']->paid){
                    $response['errors'][] = $this->lang->line('cpanel_invoice_paid_no_edit');
                }else{
                    $this->load->model('ClientesImpuestoModel');
                    $this->data['vats'] = $this->ClientesImpuestoModel->get_all();

                    $file_path = FCPATH.'app/plan_fields.json';
                    $plan_fields = array();
                    if(file_exists($file_path)) {
                        $plan_json_fields = file_get_contents($file_path);
                        $plan_fields = json_decode($plan_json_fields);
                    }
                    $this->data['plan_fields'] = $plan_fields;
                    
                    $this->load->model('ClientesAkaudModel');
                    $this->data['customers'] = $this->ClientesAkaudModel->getAll();
                    
                    $response['html'] = $this->load->view('cpanel/manage_invoices/edit',$this->data,true);
                }
            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function edit_invoice_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['invoices'] = false;
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('title', $this->lang->line('cpanel_title'), 'trim|required');
            $this->form_validation->set_rules('description', $this->lang->line('cpanel_description'), 'trim|required');
            $this->form_validation->set_rules('membership_plan', $this->lang->line('cpanel_membership_plan'), 'trim|required');
            $this->form_validation->set_rules('qty', $this->lang->line('cpanel_qty'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('price', $this->lang->line('cpanel_price'), 'trim|required|callback_float_number_check');
//            $this->form_validation->set_rules('total_amount', $this->lang->line('mi_total_amount'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('purpose', $this->lang->line('cpanel_purpose'), 'trim|required|is_natural');
            $this->form_validation->set_rules('paid', $this->lang->line('cpanel_paid'), 'trim|required|is_natural');
            $this->form_validation->set_rules('owner_id', $this->lang->line('cpanel_owner_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('invoice_id', $this->lang->line('cpanel_invoice_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('vat', $this->lang->line('cpanel_vat'), 'trim|required|callback_float_number_check');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $invoice_id = $this->input->post('invoice_id', true);
                $owner_id = $this->input->post('owner_id', true);
                $coupon_id = $this->input->post('coupon_id', true);
                $title = $this->input->post('title', true);
                $description = $this->input->post('description', true);
                $qty = $this->input->post('qty', true);
                $price = $this->input->post('price', true);
                $purpose = $this->input->post('purpose', true);
                $paid = $this->input->post('paid', true);
                $vat = $this->input->post('vat', true);
                $membership_plan = $this->input->post('membership_plan', true);


                $update_invoice = array(
                    'owner_id' => $owner_id,
//                    'coupon_id' => $coupon_id, //TODO need to be implement
                    'title' => $title,
                    'description' => $description,
                    'qty' => $qty,
                    'price' => $price * 100, //by cents
                    'purpose' => $purpose,
                    'paid' => $paid,
                    'vat' => $vat,
                    'membership_plan' => $membership_plan,
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $where = array(
                    'id'=>$invoice_id,
                    'paid = NULL OR paid = 0',
                );
                $this->load->model('InvoiceModel');
                $updated = $this->InvoiceModel->updateItem($update_invoice, $where);
                if ($updated) {
                    $response['success'] =  $this->lang->line('data_success_saved');
                    $response['invoices'] = $this->InvoiceModel->findAll();
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function add_invoice(){
        if($this->input->is_ajax_request()){
            $response['html'] = '';

            $this->load->model('ClientesImpuestoModel');
            $this->data['vats'] = $this->ClientesImpuestoModel->get_all();

            $file_path = FCPATH.'app/plan_fields.json';
            $plan_fields = array();
            if(file_exists($file_path)) {
                $plan_json_fields = file_get_contents($file_path);
                $plan_fields = json_decode($plan_json_fields);
            }
            $this->data['plan_fields'] = $plan_fields;

            $this->load->model('ClientesAkaudModel');
            $this->data['customers'] = $this->ClientesAkaudModel->getAll();

            $response['html'] = $this->load->view('cpanel/manage_invoices/add',$this->data,true);

            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function add_invoice_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['invoices'] = false;
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('title', $this->lang->line('cpanel_title'), 'trim|required');
            $this->form_validation->set_rules('description', $this->lang->line('cpanel_description'), 'trim|required');
            $this->form_validation->set_rules('membership_plan', $this->lang->line('cpanel_membership_plan'), 'trim|required');
            $this->form_validation->set_rules('qty', $this->lang->line('cpanel_qty'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('price', $this->lang->line('cpanel_price'), 'trim|required|callback_float_number_check');
//            $this->form_validation->set_rules('total_amount', $this->lang->line('mi_total_amount'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('purpose', $this->lang->line('cpanel_purpose'), 'trim|required|is_natural');
            $this->form_validation->set_rules('paid', $this->lang->line('cpanel_paid'), 'trim|required|is_natural');
            $this->form_validation->set_rules('owner_id', $this->lang->line('cpanel_owner_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('vat', $this->lang->line('cpanel_vat'), 'trim|required|callback_float_number_check');

            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $owner_id = $this->input->post('owner_id', true);
                $coupon_id = $this->input->post('coupon_id', true);
                $title = $this->input->post('title', true);
                $description = $this->input->post('description', true);
                $qty = $this->input->post('qty', true);
                $price = $this->input->post('price', true);
                $purpose = $this->input->post('purpose', true);
                $paid = $this->input->post('paid', true);
                $vat = $this->input->post('vat', true);
                $membership_plan = $this->input->post('membership_plan', true);


                $insert_invoice = array(
                    'owner_id' => $owner_id,
//                    'coupon_id' => $coupon_id, //TODO need to be implement
                    'title' => $title,
                    'description' => $description,
                    'qty' => $qty,
                    'price' => $price * 100, //by cents
                    'purpose' => $purpose,
                    'paid' => $paid,
                    'vat' => $vat,
                    'membership_plan' => $membership_plan,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->load->model('InvoiceModel');
                $inserted = $this->InvoiceModel->insertItem($insert_invoice);
                if ($inserted) {
                    $response['success'] =  $this->lang->line('data_success_saved');
                    $response['invoices'] = $this->InvoiceModel->findAll();
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function delete_invoice(){
        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){
            $invoice_id = $this->input->post('invoice_id', true);
            $delete_where = array(
                'id'=>$invoice_id,
                'paid !='=>1,
            );
            $this->load->model('InvoiceModel');
            $deleted = $this->InvoiceModel->deleteItem($delete_where);
            if($deleted){
                $response['success'] = $this->lang->line('cpanel_invoice_deleted');
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function manage_coupons(){

        $this->layouts->add_includes('js', 'app/js/cpanel/manage_coupons/index.js');
        
        $this->load->model('CouponModel');
        $this->data['coupons'] = $this->CouponModel->findAll();

        $this->layouts->view('cpanel/manage_coupons/index', $this->data, $this->layout);
    }

    public function edit_coupon(){
        if($this->input->is_ajax_request()){
            $response['errors'] = array();
            $response['html'] = '';
            $coupon_id = $this->input->post('coupon_id', true);
            $this->load->model('CouponModel');
            $this->data['coupon'] = $this->CouponModel->findById($coupon_id);
            if(!empty($this->data['coupon'])){
                    $response['html'] = $this->load->view('cpanel/manage_coupons/edit',$this->data,true);

            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function edit_coupon_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['coupons'] = false;
        if ($this->input->is_ajax_request()) {
            
            switch_db_dynamic('admin_akaud');

            $old_code = $this->input->post('old_code',true);
            $code = $this->input->post('code',true);
            $code_unique = '';
            if($old_code != $code){
                $code_unique = '|is_unique[clientes_coupons.code]';
            }
//            $duration = $this->input->post('duration',true);
//            $duration_require = '';
//            if($duration == "repeating"){
//                $duration_require = '|required';
//            }
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('title', $this->lang->line('cpanel_title'), 'trim|required');
            $this->form_validation->set_rules('discount', $this->lang->line('cpanel_discount'), 'trim|callback_float_number_check|callback_use_discount_or_percent_off');
            $this->form_validation->set_rules('percent_off', $this->lang->line('cpanel_percent_off'), 'trim|callback_float_number_check|callback_use_discount_or_percent_off');
            $this->form_validation->set_rules('code', $this->lang->line('cpanel_code'), 'trim|required'.$code_unique);
            $this->form_validation->set_rules('coupon_id', $this->lang->line('cpanel_coupon_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('from', $this->lang->line('cpanel_from'), 'trim|required');
            $this->form_validation->set_rules('to', $this->lang->line('cpanel_to'), 'trim|required');
//            $this->form_validation->set_rules('duration', $this->lang->line('cpanel_duration'), 'trim|required');
//            $this->form_validation->set_rules('duration_in_months', $this->lang->line('cpanel_duration_in_months'), 'trim|is_natural_no_zero'.$duration_require);
//            $this->form_validation->set_rules('max_redemptions', $this->lang->line('cpanel_max_redemptions'), 'trim|is_natural_no_zero');
            
//            $discount = $this->input->post('discount', true);
//            $currency_require = !empty($discount) ? "|required": '';
//            $this->form_validation->set_rules('currency', $this->lang->line('cpanel_currency'), 'trim'.$currency_require);
            
            $this->form_validation->set_rules('enabled', $this->lang->line('cpanel_enabled'), 'trim|required|is_natural');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $title = $this->input->post('title', true);
                $discount = $this->input->post('discount', true);
                $coupon_id = $this->input->post('coupon_id', true);
                $percent_off = $this->input->post('percent_off', true);
                $code = $this->input->post('code', true);
                $from = $this->input->post('from', true);
                $to = $this->input->post('to', true); //redeem_by
                $enabled = $this->input->post('enabled', true);

//                $duration = $this->input->post('duration', true);
//                $duration_in_months = $this->input->post('duration_in_months', true);
//                if($duration != "repeating"){
//                    $duration_in_months = null;
//                }
//                $max_redemptions = $this->input->post('max_redemptions', true);
                $code_check = $code;
                if($code_unique != ''){
                    $code_check = $old_code;
                }

                Stripe::setApiKey($this->config->item('payment')['stripe']['secretKey']);
                try {
                    $coupon_retrieve = StripeCoupon::retrieve($code_check); //check coupon exists
                    if(!empty($coupon_retrieve)){
                        try{
                            $delete_coupon = $coupon_retrieve->delete();
                        }catch (Exception $e){

                        }
                    }
                    try{
                        $stripe_create_update = StripeCoupon::create(array(
                                "amount_off" => ($discount != 0) ? $discount : null,
                                "percent_off" => ($percent_off != 0) ? $percent_off : null,
//                                "duration" => $duration,
                                "duration" => 'once', //TODO need to replace for the future
//                                "duration_in_months" => !empty($duration_in_months) ? $duration_in_months : null,
                                "duration_in_months" => null, //TODO need to replace for the future
//                                "max_redemptions" => !empty($max_redemptions) ? $max_redemptions : null,
                                "max_redemptions" => null, //TODO need to replace for the future
                                "redeem_by" => strtotime(date('Y-m-d 23:59:59', strtotime($to))),
//                              "valid" => ($enabled == 1) ? true : false,
                                "currency" => ($discount != 0) ? "eur" : null, //TODO need to correct, and make it dynamically
                                "id" => $code)
                        );

                        if(!empty($stripe_create_update)){

                            $update_invoice = array(
                                'title' => $title,
                                'discount' => ($discount != 0) ? $discount : null,
                                'percent_off' => ($percent_off != 0) ? $percent_off : null,
                                'code' => $code,
                                'from' => date('Y-m-d H:i:s', strtotime($from)),
                                'to' => date('Y-m-d 23:59:59', strtotime($to)),
//                                "duration" => $duration,
                                "duration" => 'once', //TODO need to replace for the future
//                                "duration_in_months" => !empty($duration_in_months) ? $duration_in_months : null,
                                "duration_in_months" => null, //TODO need to replace for the future
//                                "max_redemptions" => !empty($max_redemptions) ? $max_redemptions : null,
                                "max_redemptions" => null, //TODO need to replace for the future
                                "currency" => ($discount != 0) ? "eur" : null, //TODO need to correct, and make it dynamically
                                'enabled' => $enabled,
                                'updated_at' => date('Y-m-d H:i:s')
                            );

                            $where = array(
                                'id'=>$coupon_id
                            );
                            $this->load->model('CouponModel');
                            $updated = $this->CouponModel->updateItem($update_invoice, $where);
                            if ($updated) {
                                $response['success'] =  $this->lang->line('data_success_saved');
                                $response['coupons'] = $this->CouponModel->findAll();
                            }else{
                                $response['errors'][] = $this->lang->line('db_err_msg');
                            }
                        }else{
                            $response['errors'][] = $this->lang->line('db_err_msg');
                        }
                    }catch (Exception $e) {
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }

                    // if we got here, the coupon is valid
                } catch (\Exception $e) {
                    // an exception was caught, so the code is invalid
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }

            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function add_coupon(){
        if($this->input->is_ajax_request()){
            $response['html'] = $this->load->view('cpanel/manage_coupons/add',$this->data,true);
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function add_coupon_save() {
        $response['success'] = false;
        $response['errors'] = true;
        $response['coupons'] = false;
        if ($this->input->is_ajax_request()) {

            switch_db_dynamic('admin_akaud');

//            $duration = $this->input->post('duration',true);
//            $duration_require = '';
//            if($duration == "repeating"){
//                $duration_require = '|required';
//            }
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('title', $this->lang->line('cpanel_title'), 'trim|required');
            $this->form_validation->set_rules('discount', $this->lang->line('cpanel_discount'), 'trim|callback_float_number_check|callback_use_discount_or_percent_off');
            $this->form_validation->set_rules('percent_off', $this->lang->line('cpanel_percent_off'), 'trim|callback_float_number_check|callback_use_discount_or_percent_off|callback_percent_off_maximum_check');
            $this->form_validation->set_rules('code', $this->lang->line('cpanel_code'), 'trim|required|is_unique[clientes_coupons.code]');
            $this->form_validation->set_rules('from', $this->lang->line('cpanel_from'), 'trim|required');
            $this->form_validation->set_rules('to', $this->lang->line('cpanel_to'), 'trim|required');
//            $this->form_validation->set_rules('duration', $this->lang->line('cpanel_duration'), 'trim|required');
//            $this->form_validation->set_rules('duration_in_months', $this->lang->line('cpanel_duration_in_months'), 'trim|is_natural_no_zero'.$duration_require);
//            $this->form_validation->set_rules('max_redemptions', $this->lang->line('cpanel_max_redemptions'), 'trim|is_natural_no_zero');
            
//            $discount = $this->input->post('discount', true);
//            $currency_require = !empty($discount) ? "|required": '';
//            $this->form_validation->set_rules('currency', $this->lang->line('cpanel_currency'), 'trim'.$currency_require);
            
            $this->form_validation->set_rules('enabled', $this->lang->line('cpanel_enabled'), 'trim|required|is_natural');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $title = $this->input->post('title', true);
                $discount = $this->input->post('discount', true);
                $percent_off = $this->input->post('percent_off', true);
                $code = $this->input->post('code', true);
                $from = $this->input->post('from', true);
                $to = $this->input->post('to', true); //redeem_by
                $enabled = $this->input->post('enabled', true);

                $duration = $this->input->post('duration', true);
                $duration_in_months = $this->input->post('duration_in_months', true);
                if($duration != "repeating"){
                    $duration_in_months = null;
                }
//                $max_redemptions = $this->input->post('max_redemptions', true);

                Stripe::setApiKey($this->config->item('payment')['stripe']['secretKey']);
                $valid_coupon = false;
                try {
                    $coupon_retrieve = StripeCoupon::retrieve( $code );
                    $valid_coupon = true;
                } catch (Exception $e) {
//                    $valid_coupon = false;
                }

                if(!$valid_coupon){ //coupon not exist
                    try{
                        $stripe_create = StripeCoupon::create(array(
                                "amount_off" => ($discount != 0) ? $discount : null,
                                "percent_off" => ($percent_off != 0) ? $percent_off : null,
//                                "duration" => $duration,
                                "duration" => 'once', //TODO need to replace for the future
//                                "duration_in_months" => !empty($duration_in_months) ? $duration_in_months : null,
                                "duration_in_months" => null, //TODO need to replace for the future
//                                "max_redemptions" => !empty($max_redemptions) ? $max_redemptions : null,
                                "max_redemptions" => null, //TODO need to replace for the future
                                "redeem_by" => strtotime(date('Y-m-d 23:59:59', strtotime($to))),
//                              "valid" => ($enabled == 1) ? true : false,
                                "currency" => ($discount != 0) ? "eur" : null, //TODO need to correct, and make it dynamically
                                "id" => $code)
                        );

                        if(!empty($stripe_create)){

                            $insert_invoice = array(
                                'title' => $title,
                                'discount' => ($discount != 0) ? $discount : null,
                                'percent_off' => ($percent_off != 0) ? $percent_off : null,
                                'code' => $code,
                                'from' => date('Y-m-d H:i:s', strtotime($from)),
                                'to' => date('Y-m-d 23:59:59', strtotime($to)),
//                                "duration" => $duration,
                                "duration" => 'once', //TODO need to replace for the future
//                                "duration_in_months" => !empty($duration_in_months) ? $duration_in_months : null,
                                "duration_in_months" => null, //TODO need to replace for the future
//                                "max_redemptions" => !empty($max_redemptions) ? $max_redemptions : null,
                                "max_redemptions" => null, //TODO need to replace for the future
                                "currency" => ($discount != 0) ? "eur" : null, //TODO need to correct, and make it dynamically
                                'enabled' => $enabled,
                                'updated_at' => date('Y-m-d H:i:s')
                            );

                            $this->load->model('CouponModel');
                            $inserted = $this->CouponModel->insertItem($insert_invoice);
                            if ($inserted) {
                                $response['success'] =  $this->lang->line('data_success_saved');
                                $response['coupons'] = $this->CouponModel->findAll();
                            }else{
                                $response['errors'][] = $this->lang->line('db_err_msg');
                            }
                        }else{
                            $response['errors'][] = $this->lang->line('db_err_msg');
                        }
                    }catch (Exception $e) {
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }


    public function delete_coupon(){
        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){
            $coupon_id = $this->input->post('coupon_id', true);
            $code = $this->input->post('code', true);
            $delete_where = array(
                'id'=>$coupon_id,
                'code'=>$code
            );
            Stripe::setApiKey($this->config->item('payment')['stripe']['secretKey']);
            try {
                $coupon_retrieve = StripeCoupon::retrieve($code); //check coupon exists
                if(!empty($coupon_retrieve)){
                    try{
                        $delete_coupon = $coupon_retrieve->delete();
                        if(isset($delete_coupon->deleted) && $delete_coupon->deleted){
                            $this->load->model('CouponModel');
                            $deleted = $this->CouponModel->deleteItem($delete_where);
                            if($deleted){
                                $response['success'] = $this->lang->line('cpanel_coupon_deleted');
                                $this->load->model('UsedCouponsModel');
                                $this->UsedCouponsModel->deleteItem(array(
                                    'coupon_id'=>$coupon_id
                                ));
                            }else{
                                $response['errors'][] = $this->lang->line('db_err_msg');
                            }
                        }
                    }catch (Exception $e){
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }
            }catch (Exception $e){
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }


    function use_discount_or_percent_off(){
        $discount = $this->input->post('discount', true);
        $percent_off = $this->input->post('percent_off', true);
        if($discount && $percent_off){
            $this->form_validation->set_message('use_discount_or_percent_off', $this->lang->line('cpanel_use_discount_or_percent_off') );
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function percent_off_maximum_check($num)
    {
        if ($num > 100)
        {
            $this->form_validation->set_message(
                'percent_off_maximum_check',
                $this->lang->line('cpanel_percent_off_greater')
            );
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    // Manage Payment by transfer

    public function manage_transfers(){
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/select2/select2.css')
            ->add_includes('js', 'assets/global/plugins/select2/select2.js');
        $this->layouts->add_includes('js', 'app/js/cpanel/manage_payment/index.js');

        $this->load->model('ClientesTransfersModel');
        $this->data['clients_transfers'] = $this->ClientesTransfersModel->findAll();

        $file_path = FCPATH.'app/plan_fields.json';
        $plan_fields = array();
        if(file_exists($file_path)) {
            $plan_json_fields = file_get_contents($file_path);
            $plan_fields = json_decode($plan_json_fields);
        }
        $this->data['plan_fields'] = $plan_fields;

        $this->load->model('ClientesMainModel');
        $this->data['customers'] = $this->ClientesMainModel->getAll();


        $this->layouts->view('cpanel/manage_payment/index', $this->data, $this->layout);
    }

    public function add_transfer(){
        if($this->input->is_ajax_request()){
            $response['html'] = '';

            $this->load->model('ClientesImpuestoModel');
            $this->data['vats'] = $this->ClientesImpuestoModel->get_all();

            $file_path = FCPATH.'app/plan_fields.json';
            $plan_fields = array();
            if(file_exists($file_path)) {
                $plan_json_fields = file_get_contents($file_path);
                $plan_fields = json_decode($plan_json_fields);
            }
            $this->data['plan_fields'] = $plan_fields;

            $this->load->model('ClientesMainModel');
            $this->data['customers'] = $this->ClientesMainModel->getAll();
            $response['html'] = $this->load->view('cpanel/manage_payment/add',$this->data,true);

            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function add_transfer_save(){
        $response['success'] = false;
        $response['errors'] = true;
        $response['transfers'] = false;
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('title', $this->lang->line('cpanel_title'), 'trim|required');
            $this->form_validation->set_rules('description', $this->lang->line('cpanel_description'), 'trim|required');
            $this->form_validation->set_rules('membership_plan', $this->lang->line('cpanel_membership_plan'), 'trim|required');
            $this->form_validation->set_rules('qty', $this->lang->line('cpanel_qty'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('price', $this->lang->line('cpanel_price'), 'trim|required|callback_float_number_check');
//            $this->form_validation->set_rules('total_amount', $this->lang->line('mi_total_amount'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('purpose', $this->lang->line('cpanel_purpose'), 'trim|required|is_natural');
            $this->form_validation->set_rules('paid', $this->lang->line('cpanel_paid'), 'trim|required|is_natural');
            $this->form_validation->set_rules('client_id', $this->lang->line('cpanel_client_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('vat', $this->lang->line('cpanel_vat'), 'trim|required|callback_float_number_check');

            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $client_id = $this->input->post('client_id', true);
                $coupon_id = $this->input->post('coupon_id', true);
                $title = $this->input->post('title', true);
                $description = $this->input->post('description', true);
                $qty = $this->input->post('qty', true);
                $price = $this->input->post('price', true);
                $purpose = $this->input->post('purpose', true);
                $paid = $this->input->post('paid', true);
                $vat = $this->input->post('vat', true);
                $membership_plan = $this->input->post('membership_plan', true);


                $insert_transfer = array(
                    'client_id' => $client_id,
//                    'coupon_id' => $coupon_id, //TODO need to be implement
                    'title' => $title,
                    'description' => $description,
                    'qty' => $qty,
                    'price' => $price * 100, //by cents
                    'purpose' => $purpose,
                    'paid' => $paid,
                    'vat' => $vat,
                    'membership_plan' => $membership_plan,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->load->model('ClientesTransfersModel');
                $inserted = $this->ClientesTransfersModel->insertItem($insert_transfer);
                if ($inserted) {
                    $response['success'] =  $this->lang->line('data_success_saved');
                    $response['transfers'] = $this->ClientesTransfersModel->findAll();
                    if($paid == '1') {
                        $result_1 = $this->updateClientPlanData($client_id, $membership_plan);
                        if(!empty($result_1['errors'])){
                            foreach($result_1['errors'] as $error) {
                                $response['errors'][] = $error['message'];
                            }
                        }
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function edit_transfer(){
        if($this->input->is_ajax_request()){
            $response['errors'] = array();
            $response['html'] = '';
            $transfer_id = $this->input->post('transfer_id', true);
            $this->load->model('ClientesTransfersModel');
            $this->data['transfer'] = $this->ClientesTransfersModel->findById($transfer_id);
            if(!empty($this->data['transfer'])){
                if($this->data['transfer']->paid){
                    $response['errors'][] = $this->lang->line('cpanel_invoice_paid_no_edit');
                }else{
                    $this->load->model('ClientesImpuestoModel');
                    $this->data['vats'] = $this->ClientesImpuestoModel->get_all();

                    $file_path = FCPATH.'app/plan_fields.json';
                    $plan_fields = array();
                    if(file_exists($file_path)) {
                        $plan_json_fields = file_get_contents($file_path);
                        $plan_fields = json_decode($plan_json_fields);
                    }
                    $this->data['plan_fields'] = $plan_fields;

                    $this->load->model('ClientesMainModel');
                    $this->data['customers'] = $this->ClientesMainModel->getAll();

                    $response['html'] = $this->load->view('cpanel/manage_payment/edit',$this->data,true);
                }
            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function edit_transfer_save(){
        $response['success'] = false;
        $response['errors'] = true;
        $response['transfers'] = false;
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('title', $this->lang->line('cpanel_title'), 'trim|required');
            $this->form_validation->set_rules('description', $this->lang->line('cpanel_description'), 'trim|required');
            $this->form_validation->set_rules('membership_plan', $this->lang->line('cpanel_membership_plan'), 'trim|required');
            $this->form_validation->set_rules('qty', $this->lang->line('cpanel_qty'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('price', $this->lang->line('cpanel_price'), 'trim|required|callback_float_number_check');
//            $this->form_validation->set_rules('total_amount', $this->lang->line('mi_total_amount'), 'trim|required|callback_float_number_check');
            $this->form_validation->set_rules('purpose', $this->lang->line('cpanel_purpose'), 'trim|required|is_natural');
            $this->form_validation->set_rules('paid', $this->lang->line('cpanel_paid'), 'trim|required|is_natural');
            $this->form_validation->set_rules('client_id', $this->lang->line('cpanel_client_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('transfer_id', $this->lang->line('cpanel_transfer_id'), 'trim|required|is_natural');
            $this->form_validation->set_rules('vat', $this->lang->line('cpanel_vat'), 'trim|required|callback_float_number_check');
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $transfer_id = $this->input->post('transfer_id', true);
                $client_id = $this->input->post('client_id', true);
                $coupon_id = $this->input->post('coupon_id', true);
                $title = $this->input->post('title', true);
                $description = $this->input->post('description', true);
                $qty = $this->input->post('qty', true);
                $price = $this->input->post('price', true);
                $purpose = $this->input->post('purpose', true);
                $paid = $this->input->post('paid', true);
                $vat = $this->input->post('vat', true);
                $membership_plan = $this->input->post('membership_plan', true);


                $update_transfer = array(
                    'client_id' => $client_id,
//                    'coupon_id' => $coupon_id, //TODO need to be implement
                    'title' => $title,
                    'description' => $description,
                    'qty' => $qty,
                    'price' => $price * 100, //by cents
                    'purpose' => $purpose,
                    'paid' => $paid,
                    'vat' => $vat,
                    'membership_plan' => $membership_plan,
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $where = array(
                    'id'=>$transfer_id,
                    'paid = NULL OR paid = 0',
                );

                $this->load->model('ClientesTransfersModel');
                $updated = $this->ClientesTransfersModel->updateItem($update_transfer, $where);
                if ($updated) {
                    $response['success'] =  $this->lang->line('data_success_saved');
                    $response['transfers'] = $this->ClientesTransfersModel->findAll();
                    if($paid == '1') {
                        $result_1 = $this->updateClientPlanData($client_id, $membership_plan);
                        if(!empty($result_1['errors'])){
                            foreach($result_1['errors'] as $error) {
                                $response['errors'][] = $error['message'];
                            }
                        }
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    private function updateClientPlanData($client_id, $membership_plan){
        $response['success'] = false;
        $response['errors'] = array();

        $file_path = FCPATH.'app/plan_fields.json';
        $fields = array();
        $update_data = array();
        if(file_exists($file_path)) {
            $plan_json_fields = file_get_contents($file_path);
            $fields = json_decode($plan_json_fields);
        }
        if(!empty($fields)){
            foreach ($fields as $k=>$field){
                if($field->membership_plan == $membership_plan){
                    $update_data = (array)$field;
                    break;
                }
            }
        }

        if(!empty($update_data)) {
            $update_data['paid'] = true;

            $user_update = $this->ClientesAkaudModel->updateItem($update_data, array('idcliente' => $client_id));
            if ($user_update) {
                $res = $this->ClientesAkaudModel->findOne(array('idcliente' => $client_id));
                $this->load->model('Variables2Model');
                if($update_data['plan'] == '1'){
                    $this->Variables2Model->deleteLogo();
                    $this->data['customer_logo'] = null;
                }else {
                    $logo = $this->Variables2Model->get_logo();
                    if (!empty($logo) && isset($logo->logo)) {
                        $this->data['customer_logo'] = $logo->logo;
                    } else {
                        $this->data['customer_logo'] = null;
                    }
                }


                $amazon = $this->config->item('amazon');
                $email_from = $this->config->item('admin_info1');
                $admin_info = $this->config->item('admin_info');
                $client = SesClient::factory(array(
                    'version' => 'latest',
                    'region' => $amazon['email_region'],
                    'credentials' => array(
                        'key' => $amazon['AWSAccessKeyId'],
                        'secret' => $amazon['AWSSecretKey'],
                    ),
                ));
//
                //send notification for admin - start
                $message_admin = $this->load->view('cpanel/manage_payment/partials/send_admin_note.php', $this->data, TRUE);
                $request_admin = array();
                $request_admin['Source'] = $email_from['from'];
//                                                    $request_admin['Destination']['ToAddresses'] = array($admin_info['email']);
                $request_admin['Destination']['ToAddresses'] = $this->config->item('admin_info2');
                $request_admin['Message']['Subject']['Data'] = "Notification for new Payment";
                $request_admin['Message']['Subject']['Charset'] = "UTF-8";
                $request_admin['Message']['Body']['Html']['Data'] = $message_admin;
                $request_admin['Message']['Subject']['Charset'] = "UTF-8";

                try {
                    $result = $client->sendEmail($request_admin);
//                                                    $messageId = $result->get('MessageId');
                } catch (Exception $e) {
                    //echo("The email was not sent. Error message: ");
                    //$response['errors'] = $e->getMessage()."\n";
//                                                    $response['errors'][] = $this->get_stripe_errors($e);
                }
                //send notification for admin - end
                if (isset($res->idcliente)) {
                    $this->load->model('ClientesMainModel');
                    $client_main = $this->ClientesMainModel->getAll("CCODCLI='" . $res->idcliente . "'");

                    if (!empty($client_main) && isset($client_main[0])) {
                        $client_main = $client_main[0];

                        //send notification for customer - start
                        $this->data['commercial_name'] = $client_main->commercial_name;
                        $this->data['customer_email'] = $client_main->email;
                        $message_customer = $this->load->view('cpanel/manage_payment/partials/send_customer_note.php', $this->data, TRUE);
                        $request_customer = array();
                        $request_customer['Source'] = $email_from['from'];
                        $request_customer['Destination']['ToAddresses'] = array($this->data['customer_email']);
                        $request_customer['Message']['Subject']['Data'] = "Notification for new Payment";
                        $request_customer['Message']['Subject']['Charset'] = "UTF-8";
                        $request_customer['Message']['Body']['Html']['Data'] = $message_customer;
                        $request_customer['Message']['Subject']['Charset'] = "UTF-8";

                        try {
                            $result = $client->sendEmail($request_customer);
//                                                    $messageId = $result->get('MessageId');
                        } catch (Exception $e) {
                            //echo("The email was not sent. Error message: ");
                            //$response['errors'] = $e->getMessage()."\n";
//                                                    $response['errors'][] = $this->get_stripe_errors($e);
                        }
                        //send notification for customer - end
                    }
                    //}

                    $response['success'] = $this->lang->line('cpanel_client_paid_success');
                    return $response;
                    //}
                }
            }else{
                $response['errors'][] = array(
                    'status' => 500,
                    'message'=>$this->lang->line('cpanel_server_error')
                );
            }
        }

        return $response;

    }

    public function delete_transfer(){
        $response['success'] = false;
        $response['errors'] = array();
        if($this->input->is_ajax_request()){
            $transfer_id = $this->input->post('transfer_id', true);
            $delete_where = array(
                'id'=> $transfer_id,
                'paid !='=>1,
            );
            $this->load->model('ClientesTransfersModel');
            $deleted = $this->ClientesTransfersModel->deleteItem($delete_where);
            if($deleted){
                $response['success'] = $this->lang->line('cpanel_transfer_deleted');
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    // Customers Follow UP

    public function getCustomerFollowUp(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('customer_id', true);
            $html = '';
            if($id){
                $this->load->model('ClientesAkaudFollowupModel');
                $this->data['follow_up'] = $this->ClientesAkaudFollowupModel->getByIdCliente($id);
                $this->data['client_id'] = $id;
                $html = $this->load->view('cpanel/customers_edit/partials/follow_up', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function addFollowUp(){
        if($this->input->is_ajax_request()){
            $response['success'] = false;
            $response['errors'] = array();
            $response['last_id'] = null;

            if($this->input->post()){

                $this->config->set_item('language', $this->data['lang']);
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => $this->lang->line('cpanel_followup_title'),
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'comments',
                        'label' => $this->lang->line('cpanel_followup_fecha'),
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'follow_date',
                        'label' => $this->lang->line('cpanel_followup_comentario'),
                        'rules' => 'trim|required'
                    ),
                );

                $this->form_validation->set_rules($config);

                if ($this->form_validation->run()) {
                    $post_data = $this->input->post(null, true);
                    $usuar_id = isset($this->data['userData']->id) ? $this->data['userData']->id : null;
                    $client_id = isset($post_data['client_id']) ? $post_data['client_id'] : null;
                    if($client_id && $usuar_id) {
                        $dataArray = array(
                            'follow_date' => date('Y-m-d', strtotime($post_data['follow_date'])),
                            'title' => $post_data['title'],
                            'comments' => $post_data['comments'],
                            'user_id' => $usuar_id,
                            'ccodcli' => $client_id
                        );
                        $this->load->model('ClientesAkaudFollowupModel');
                        $last_id = $this->ClientesAkaudFollowupModel->insertData($dataArray);
                        if($last_id){
                            $response['last_id'] = $last_id;
                            $response['success'] = $this->lang->line('cpanel_follow_up_added');
                            $response['errors'] = false;
                        }else{
                            $response['errors'][] = $this->lang->line('db_err_msg');
                        }
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $response['errors'] =  $this->form_validation->error_array();
                }
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }

            print_r(json_encode($response));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function editFollowUp(){
        $response['success'] = false;
        $response['errors'] = array();

        if($this->input->post()){

            $this->config->set_item('language', $this->data['lang']);
            $config = array(
                array(
                    'field' => 'title',
                    'label' => $this->lang->line('cpanel_followup_title'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comments',
                    'label' => $this->lang->line('cpanel_followup_comentario'),
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'follow_date',
                    'label' => $this->lang->line('cpanel_followup_fecha'),
                    'rules' => 'trim|required'
                )
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, true);
                $usuar_id = isset($this->data['userData']->id) ? $this->data['userData']->id : null;
                $client_id = isset($post_data['client_id']) ? $post_data['client_id'] : null;
                $follow_up_id = isset($post_data['follow_up_id']) ? $post_data['follow_up_id'] : null;
                if($follow_up_id && $client_id && $usuar_id) {
                    $dataArray = array(
                        'follow_date' => date('Y-m-d', strtotime($post_data['follow_date'])),
                        'title' => $post_data['title'],
                        'comments' => $post_data['comments']
                    );
                    $where = array(
                        'id' => $follow_up_id,
                        'user_id' => $usuar_id,
                        'ccodcli' => $client_id
                    );
                    $this->load->model('ClientesAkaudFollowupModel');
                    $updated = $this->ClientesAkaudFollowupModel->updateFollowData($dataArray, $where);
                    if($updated){
                        $response['success'] = $this->lang->line('cpanel_follow_up_updated');
                        $response['errors'] = false;
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'] =  $this->form_validation->error_array();
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }

        print_r(json_encode($response));
        exit;
    }

    public function delete_follow_up() {
        if($this->input->is_ajax_request()){
            $post_data = $this->input->post(null, true);
            $usuar_id = isset($this->data['userData']->id) ? $this->data['userData']->id : null;
            $client_id = isset($post_data['client_id']) ? $post_data['client_id'] : null;
            $follow_up_id = isset($post_data['follow_up_id']) ? $post_data['follow_up_id'] : null;
            $deleted = false;
            if($follow_up_id && $client_id && $usuar_id) {
                $where = array(
                    'id' => $follow_up_id,
                    'user_id' => $usuar_id,
                    'ccodcli' => $client_id
                );
                $this->load->model('ClientesAkaudFollowupModel');
                $deleted = $this->ClientesAkaudFollowupModel->deleteFollowUp($where);
            }
            echo json_encode(array('status' => $deleted));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    // Customer LOG
    public function getCustomerLogs(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('customer_id', true);
            $html = '';
            if($id){
                //$this->data['logs'] = $this->ClientesLogModel->getByIdClienteAxjax($id);
                $this->data['client_id'] = $id;
                $html = $this->load->view('cpanel/customers_edit/partials/logs', $this->data, true);
            }
            echo json_encode(array('html' => $html));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function getCustomerLogsData(){
        if($this->input->is_ajax_request()){
            $this->load->model('ClientesLogModel');
            
            $start =$this->input->post('start',  true);
            $length =$this->input->post('length', true);
            $draw = $this->input->post('draw', true);
            $search =$this->input->post('search', true);
            $order = $this->input->post('order', true);
            $columns = $this->input->post('columns', true);

            $client_id = $this->input->post('client_id', true);


            $column = $order[0]['column'];

            $total_invoices = $this->ClientesLogModel->getTotalCount(array('ccodcli' => $client_id));
            $invoices_data = $this->ClientesLogModel->getByIdClienteAxjax($start, $length, $draw, $search, $order, $columns, $client_id);
            $recordsTotal = (int)$invoices_data->rows;

            $response = array(
                "start"=>$start,
                "length"=>$length,
                "search"=>$search,
                "order"=>$order,
                "column"=>$column,
                "draw"=>$draw,
                "recordsFiltered"=>$recordsTotal,
                "recordsTotal"=>$recordsTotal,
                "data"=> $invoices_data->items,
                "table_total_rows"=> $total_invoices
            );
            echo json_encode($response); exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function loginSuperAdmin(){
        $this->layouts
            ->add_includes('css', 'assets/global/plugins/select2/select2.css')
            ->add_includes('js', 'assets/global/plugins/select2/select2.js');
        if($this->data['lang'] == "spanish"){
            $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2_locale_es.js');
        }
        if($this->input->post()){
            $customer_key = $this->input->post('key_code', true);
            $res = $this->ClientesAkaudModel->getByKey($customer_key);
            if(isset($res[0])){
                if($res[0]->active == 0){
                    $response['msg'] = $this->lang->line('key_code_inactive');
                }else if($res[0]->start_date > date('Y-m-d') ||  $res[0]->end_date < date('Y-m-d')){
                    $response['msg'] = $this->lang->line('key_code_dates_msg');
                }else {
                    $db_details = (array)$res[0];
                    $test_connection = $this->_check_db('mysqli', $db_details['DBHost_IPserver'], $db_details['DBHost_user'], $db_details['DBHost_pwd'], $db_details['DBHost_db'], $port = NULL);
                    if ($test_connection) {
                        $plan_options = $this->session->userdata('_plan_options');
                        $this->_db_details = $db_details;
                        if (empty($plan_options)) {
                            if (isset($db_details['plan'])) {
                                $plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
                            }
                            $this->session->set_userdata('_plan_options', $plan_options);
                        }


//						$db_details_json_base64_encode = base64_encode(json_encode($db_details));
//						setcookie('_cisess', $db_details_json_base64_encode,time() + (86400 * 30), "/"); //30 days
                        $key_base64_encode = base64_encode($customer_key);
                        setcookie('_cisess', $key_base64_encode, time() + (86400 * 1), "/"); //1 day
                        $this->session->set_userdata('_cisess', $db_details);
                        $response['success'] = true;
                        $lang = $this->input->post('lang', true);
                        if ($lang == 'english' || $lang == 'spanish') {
                            $this->session->set_userdata('lang', $lang);
                        } else {
                            $this->session->set_userdata('lang', 'english');
                        }
                        $superadmin_data = $this->config->item('superadmin');
                        $this->session->set_userdata('super_admin_secretKey', $superadmin_data->secretKey);
                        $result[0] = $this->getSuperAdminData();
                        $this->session->set_userdata('loggedIn', true);
                        $this->session->set_userdata('logged_as', 'lms');
                        $this->session->set_userdata('userData', $result);
                        if (empty($this->data['lang'])) {
                            $this->session->set_userdata('lang', $result[0]->lang);
                        }
                        $this->session->set_userdata('color', $result[0]->themeColor);
                        $this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
                        $this->session->set_userdata('postWriter', $result[0]->post_writer);
                        $this->load->model('Variables2Model');
                        $start_end_time = $this->Variables2Model->getStartEndtime();

                        $start_itme = substr($start_end_time->start_time, 0, -2) . ':' . substr($start_end_time->start_time, -2);
                        $end_time = substr($start_end_time->end_time, 0, -2) . ':' . substr($start_end_time->end_time, -2);

                        $this->session->set_userdata('start_time', $start_itme);
                        $this->session->set_userdata('end_time', $end_time);

                        $plan_options = null;
                        if (isset($this->_db_details->plan)) {
                            $plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
                        }

                        $this->session->set_userdata('_plan_options', $plan_options);
                        $this->session->set_userdata('trial_expire', $this->_db_details->trial_expire);

                        $this->load->model('InvoiceModel');
                        $no_paid_invoices_exist = $this->InvoiceModel->check_no_paid_items($this->_db_details->id);
                        $this->session->set_userdata('no_paid_invoices_exist', $no_paid_invoices_exist);

                        if (!empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan != 1) {
                            $your_date = strtotime($this->_db_details->trial_expire);
                            $datediff = $your_date - time();
                            $remaining_days = floor($datediff / (60 * 60 * 24)) + 1;
                            $this->session->set_userdata('remaining_days', $remaining_days);
                            $this->session->set_userdata('remaining_days_show', 1);
                        } elseif(empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan == 1){
                            $this->session->set_userdata('remaining_days', 0);
                            $this->session->set_userdata('remaining_days_show', 0);
                        }elseif (empty($this->_db_details->trial_expire) && $this->_db_details->paid != 1 && $this->_db_details->plan) {
                            //$this->session->set_userdata('remaining_days', 0);
                            $this->session->set_userdata('remaining_days_show', 0);
                        } else {
                            $this->session->set_userdata('remaining_days', null);
                            $this->session->set_userdata('remaining_days_show', 0);
                        }

                        $response['success'] = true;
                        $db_debug = $this->db->db_debug;
                        $this->db->db_debug = false;
                        $this->executingUpdateVersion();
                        $this->executingUpdateBatch();
                        $this->db->db_debug = $db_debug;
                        redirect('home');
                    }else{
                        $this->data['db_connnection_error'] = $this->lang->line('db_connnection_error');
                    }
                }
            }else{
                $response['msg'] = $this->lang->line('keycode_invalid_try');
                $response['success'] = false;
            }
        }
        $this->layouts->add_includes('js', 'app/js/cpanel/login_super_admin.js');
        $this->data['clients_data'] = $this->ClientesAkaudModel->getclientsDataAjax('', 5);

        $this->layouts->view('cpanel/loginSuperAdmin',$this->data, $this->layout);
    }
    public function SelectCustomerData(){
        $this->data['clients_data'] = array();
        if($this->input->post()){
            $search = $this->input->post('q', true);
            $this->data['clients_data'] = $this->ClientesAkaudModel->getclientsDataAjax($search);
        }
        echo json_encode($this->data['clients_data']);exit;
    }

    private function getSuperAdminData(){
        return (object)array(
            "Id"=> 0,
            "USUARIO" => 'superadmin',
            "NIVELACCESO" => "0",
            "CLAVEACCESO" => "akaud",
            "Id2" => "0",
            "Filtrar" => NULL,
            "Nombre" => 'Super Admin',
            "skype" => "",
            "Telefono" => "8795522",
            "ControlRemoto" => "1",
            "VerTodoslosCentros" => "1",
            "allowupdate" => "0",
            "hostuser" => NULL,
            "foto" => "",
            "smtp" => "",
            "email" => "soporte2@softaula.com",
            "user" => "",
            "pwd" => "",
            "autenticado" => "2",
            "port" => "587",
            "firma"=> "Manuel García - Departamento Técnico

c/ Bori i Fontestá, 14 08021 Barcelona

Tlf-. +34 902 05 03 38     

soporte2@softaula.com      www.softaula.net

Advertencia: Este mensaje contiene información confidencial, destinada para ser leída exclusivamente por el destinatario. Queda prohibida la reproducción, publicación, divulgación, total o parcial del mensaje así como el uso no autorizado por el emisor. En caso de recibir el mensaje por error, se ruega su comunicación al remitente lo antes posible.",
        "mostrar_splash" => "0",
        "Google_Calendar_ID" => NULL,
        "signature_html" => "1",
        "leads_show_all" => "1",
        "leads_assign_user" => "1",
        "notificar_cambios_notas" => "0",
        "session_registered" => "1",
        "session_weekdays" => NULL,
        "session_fromday" => NULL,
        "session_today" => NULL,
        "session_fromtime" => NULL,
        "session_totime" => NULL,
        "notificar_cambios_notas_intervalo" => "0",
        "bloquear_cambios_notas_intervalo" => "1",
        "acceso_opciones_avanzadas" => "1",
        "lang"  => "english",
        "about" => "test 1  test 2",
        "post_writer" => "1",
        "acceso_reglas" => "0",
        "active" => "1",
        "layaoutFormat" => "boxed",
        "themeColor" => "dark_blue",
        "layoutFormat" => "boxed",
        "photo_link" => ""
        );
    }

    private function executingUpdateBatch(){
        $this->load->model('ApdateBatchModel');
        $csql_queries = $this->ApdateBatchModel->getCsqls();
        if(!empty($csql_queries)){
            foreach($csql_queries as $query){
                $this->ApdateBatchModel->executingQuery($query->csql);
            }
        }
    }

    private function executingUpdateVersion(){
        $this->load->model('ClientesUpdatesModel');
        $this->load->model('Variables2Model');
        $result = false;
        $exist_field = $this->Variables2Model->exist_field('version_akaud');
        if(!$exist_field){
            $result_add = $this->Variables2Model->add_version_akaud_field();
            if(!$result_add){
                return false;
            }
        }
        $version_akaud = $this->Variables2Model->get_version_akaud();
        $update_data = $this->ClientesUpdatesModel->getUpdateByVersion($version_akaud);
        if(!empty($update_data)){
            $latest_version = 0;
            foreach($update_data as $data) {
                try {
                    $this->Variables2Model->executingCsql($data->csql);
                    $latest_version = $data->version;
                } catch (Exception $e) {
                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                    break;
                }
            }
            if($latest_version){
                $result = $this->Variables2Model->updateVersionAkaud($latest_version);
            }
        }
        return 	$result;
    }

    private function _check_db($protocol,$host,$user,$password,$database,$port = NULL)
    {
        $dsn = "{$protocol}://{$user}:{$password}@{$host}/{$database}";
        if($port !== NULL)
        {
            $dsn .="?port={$port}";
        }

        $test = @$this->load->database($dsn, TRUE);
        if($test->conn_id){
            return true;
        }else{
            return false;
        }
    }

    public function getCustomerTags(){
        $email = $this->input->post('customer_email', true);
        $this->load->model('AgilecrmTagsModel');
        $data = $this->curl_wrap("contacts/search/email/".$email, null, "GET", "application/json");
        $tags = array();
        $data_not_exist_tags = array();
        if($data) {
            $data = json_decode($data);
            $tags = $data->tags;
            $data_not_exist_tags = $this->AgilecrmTagsModel->getNotExistTags($tags);
       }
        echo json_encode(array('tags' => $tags, 'not_exist_tags' => $data_not_exist_tags));exit;
    }

    public function addCustomerTags(){
        $this->load->model('AgilecrmTagsModel');
        $email = $this->input->post('customer_email', true);
        $tags = $this->input->post('tags', true);
        $success = true;
        $tags_data = array();
        if(!empty($tags)){
            $tags_array = explode(',', $tags);
            $tags_data = $this->AgilecrmTagsModel->getTagsByIds($tags_array);
            if(!empty($tags_data)){
                $str_data = '';
                foreach($tags_data as $tag){
                    $str_data .= "'".$tag->tag_name."',";
                }
                $str_data = trim($str_data, ',');

                $fields = array(
                    'email' => urlencode($email),
                    'tags' => urlencode('['.$str_data.']')
                );
                $fields_string = '';
                foreach ($fields as $key => $value) {
                    $fields_string .= $key . '=' . $value . '&';
                }

                $result =  $this->curl_wrap("contacts/email/tags/add", rtrim($fields_string, '&'), "POST", "application/x-www-form-urlencoded");
                if($result) {
                    $result = json_decode($result);
                    if (!empty($result) && isset($result[0]->createdTime) && $result[0]->createdTime) {
                        $success = true;
                    }
                }
            }
        }

        echo json_encode(array('success' => $success, 'tags_data' => $tags_data));exit;
    }

    public function deleteCustomerTags(){
        $email = $this->input->post('customer_email', true);
        $tag = $this->input->post('tag', true);
        $fields = array(
            'email' => urlencode($email),
            'tags' => urlencode('["'.$tag.'"]')
        );
        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        $result = $this->curl_wrap("contacts/email/tags/delete", rtrim($fields_string, '&'), "POST", "application/x-www-form-urlencoded");
        echo json_encode(array('result' => true));exit;
    }

    private function  curl_wrap($entity, $data, $method, $content_type)
    {
        if ($content_type == NULL) {
            $content_type = "application/json";
        }

        $agile_url = "https://" . AGILE_DOMAIN . ".agilecrm.com/dev/api/" . $entity;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
        switch ($method) {
            case "POST":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "GET":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "PUT":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                $url = $agile_url;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                break;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type : $content_type;", 'Accept : application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, AGILE_USER_EMAIL . ':' . AGILE_REST_API_KEY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}

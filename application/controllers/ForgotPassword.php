<?php
use Aws\Ses\SesClient;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
* @property UsuarioModel $UsuarioModel
* @property ProfesorModel $ProfesorModel
* @property AlumnoModel $AlumnoModel

 **/
class ForgotPassword extends Public_Controller {


    public  $data;
    public  $_user_details;

    public function __construct() {
        parent::__construct();
        $this->load->model('ProfesorModel');
        $this->load->model('UsuarioModel');
        $this->load->library('form_validation');

        $this->data['page'] = $this->router->fetch_class();
        $this->lang->load('forget_pass_email', $this->data['lang']);

    }

    public function index($code = null){
        $error_404 = true;
        if($code){
            $code = urldecode($code);
            $code = base64_decode($code);
            $access_date = explode('+', $code);
            if(isset($access_date[0]) && isset($access_date[1]) && isset($access_date[2]) && isset($access_date[5])) {
                $this->load->model('ClientesAkaudModel');
                $user_id = $access_date[2];
                $user_name = $access_date[4];
                $email = $access_date[3];
                $user_role = $access_date[1];
                $key_code = $access_date[5];
                $res = $this->ClientesAkaudModel->getByKey($key_code);
                $user_data = array();
                if (isset($res[0]) && !empty($res[0])) {

                    $db_details = (array)$res[0];
                    $test_connection = $this->_check_db('mysqli',$db_details['DBHost_IPserver'],$db_details['DBHost_user'],$db_details['DBHost_pwd'],$db_details['DBHost_db'],$port = 3306);
                    if($test_connection) {
                        $db_new_config = array(
                            'dsn'	=> '',
                            'hostname' => $db_details['DBHost_IPserver'],
                            'username' => $db_details['DBHost_user'],
                            'password' => $db_details['DBHost_pwd'],
                            'database' => $db_details['DBHost_db'],
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
                        if ($user_role == 'teacher') {
                            $user_data = $this->ProfesorModel->get_campus_teachers(array('INDICE' => $user_id, 'Activo' => 1, 'Email' => $email));
                        } elseif ($user_role == 'user') {
                            $user_data = $this->UsuarioModel->get_users(array('id' => $user_id, 'active' => 1, 'email' => $email));
                        } elseif ($user_role == 'student') {
                            $this->load->model('AlumnoModel');
                            $user_data = $this->AlumnoModel->get_campus_students(array('CCODCLI' => $user_id, 'enebc' => 1, 'email' => $email));
                        }
                        $today = date('Y-m-d');
                        $expiredate = $access_date[0];
                        if (strtotime($expiredate) >= strtotime($today) && !empty($user_data)) {
                            $this->session->set_userdata('forgot_pass_user_id', $user_id);
                            $this->session->set_userdata('forgot_pass_user_name', $user_name);
                            $this->session->set_userdata('forgot_pass_user_role', $user_role);
                            $this->session->set_userdata('forgot_pass_email', $email);
                            $this->session->set_userdata('forgot_pass_key_code', $key_code);
                            $this->layouts->add_includes('js', 'app/js/forgot_password/forgot_password.js');
                            $this->lang->load('forget_pass_email', $this->data['lang']);
                            $this->layouts->view('forgot_password/index', $this->data, 'locked_profile');
                            $error_404 = false;
                        }else{
                            $this->session->set_userdata('forgot_pass_date_expired', true);
                            if ($user_role == 'teacher' || $user_role == 'student') {
                                redirect('campus/auth/login2');
                            }else{
                                redirect('auth/login2');
                            }
                        }
                    }else{
                        redirect('auth/login2');
                    }
                }
            }
        }
        if($error_404){
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    public function change_password(){

        if($this->input->is_ajax_request()) {
           $password =  $this->input->post('password', true);
           $comfirm_password =  $this->input->post('comfirm_password', true);
            $data['error'] = 'Error';
            $data['success'] = false;

            $user_role = $this->session->userdata('forgot_pass_user_role');
            
            if(($comfirm_password == $password) && $password != ''){
                $user_role = $this->session->userdata('forgot_pass_user_role');
                if($this->session->userdata('forgot_pass_user_id') != '') {
                    $key_code = $this->session->userdata('forgot_pass_key_code');
                    $this->load->model('ClientesAkaudModel');
                    $res = $this->ClientesAkaudModel->getByKey($key_code);
                    $user_data = array();
                    if (isset($res[0]) && !empty($res[0])) {

                        $db_details = (array)$res[0];
                        $test_connection = $this->_check_db('mysqli',$db_details['DBHost_IPserver'],$db_details['DBHost_user'],$db_details['DBHost_pwd'],$db_details['DBHost_db'],$port = 3306);
                        if($test_connection) {
                            $db_new_config = array(
                                'dsn' => '',
                                'hostname' => $db_details['DBHost_IPserver'],
                                'username' => $db_details['DBHost_user'],
                                'password' => $db_details['DBHost_pwd'],
                                'database' => $db_details['DBHost_db'],
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
                            $user_id = $this->session->userdata('forgot_pass_user_id');
                            $user_name = $this->session->userdata('forgot_pass_user_name');
                            $email = $this->session->userdata('forgot_pass_email');
                            $update_data[0] = array('id' => $user_id, 'Clave' => $password);
                            $success = false;
                            if ($user_role == 'teacher') {
                                $user_type = '1';
                                $success = $this->ProfesorModel->update('profesor', array('Clave' => $password), array('INDICE' => $user_id));
                            } elseif ($user_role == 'user') {
                                $user_type = '0';
                                $success = $this->UsuarioModel->update('usuarios', array('CLAVEACCESO' => $password), array('Id' => $user_id));
                            } elseif ($user_role == 'student') {
                                $user_type = '2';
                                $this->load->model('AlumnoModel');
                                $success = $this->AlumnoModel->update('alumnos', array('Clave' => $password), array('CCODCLI' => $user_id));
                            }

                            if ($success) {
                                $data['success'] = true;
                                $data['error'] = '';
                                /*$company = $this->ProfesorModel->get_company_name();

                                $message = '';
                                $message .= ' <p>Hi ' . $user_name . ', </p> <br>';
                                $message .= '<p>Your Password has been updated at ' . date('F j').' at  '.date('G:i A') . '.</p> <br> ';
                                $message .= '<p> If this change has been made without your authorization, contact your</p> <br>';
                                $message .= '<p>Administrator immediately.</p> <br>';
                                $message .= '<br> <p>Regards</p><br>  <p>Akaud Team</p>';*/

                                $replace_data = array(
                                    'FIRSTNAME' => $user_name,
                                    'SURNAME' => $user_name,
                                    'FULLNAME' => $user_name,
                                    //'PHONE1' => ,
                                    //'MOBILE' => ,
                                    'EMAIL1' => $email,
                                    //'COURSE_NAME' => ,
                                    'START_DATE' => date('F j') . ' at  ' . date('G:i A'),
                                    'END_DATE' => date('F j') . ' at  ' . date('G:i A'),
                                );

                                $this->load->model('ErpEmailsAutomatedModel');
                                $template = $this->ErpEmailsAutomatedModel->getByTemplateId('14', array('notify_student' => 1));
                                if (!empty($template)) {
                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
                                    $this->send_automated_email($user_id, $user_type, $email, $email_subject, $email_body, $template->from_email);

                                }
                                $result = true;
                                /* $amazon = $this->config->item('amazon');
                                 $email_from = $this->config->item('email');

                                 $client = SesClient::factory(array(
                                     'version' => 'latest',
                                     'region' => $amazon['email_region'],
                                     'credentials' => array(
                                         'key' => $amazon['AWSAccessKeyId'],
                                         'secret' => $amazon['AWSSecretKey'],
                                     ),
                                 ));

                                 $request = array();
                                 $request['Source'] = $email_from['from'];
                                 $request['Destination']['ToAddresses'] = array($email);
                                 $request['Message']['Subject']['Data'] = "Notification for " . $company[0]->company_name . ' - Forgot Password';
                                 $request['Message']['Subject']['Charset'] = "UTF-8";
                                 $request['Message']['Body']['Html']['Data'] = $message;
                                 $request['Message']['Body']['Charset'] = "UTF-8";

                                 try {
                                     $result = $client->sendEmail($request);
                                     $messageId = $result->get('MessageId');
                                     //echo("Email sent! Message ID: $messageId"."\n");
                                     if ($messageId) {
                                         $data['success'] = true;
                                         $data['error'] = '';
                                     } else {
                                         $data['success'] = false;
                                         $data['error'] = '';
                                     }

                                 } catch (Exception $e) {
                                     //echo("The email was not sent. Error message: ");
                                     //$response['errors'] = $e->getMessage()."\n";
                                     $data['success'] = false;
                                     $data['error'] = '';
                                 }*/
                            }

                            $this->session->unset_userdata('forgot_pass_user_id');
                            $this->session->unset_userdata('forgot_pass_user_name');
                            $this->session->unset_userdata('forgot_pass_user_role');
                            $this->session->unset_userdata('forgot_pass_email');

                        }
                    }
                }else{
                    $data['success'] = false;
                }
            }else{
                $data['success'] = false;
                $data['error'] = 'Password does not matches confirm password';
            }
            echo json_encode(array('success' => $data['success'], 'error' => $data['error'], 'user_role' => $user_role));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    private function send_automated_email($user_id,$user_type,$email, $subject, $body, $from_email){
        $this->load->model('ErpEmailModel');
            $amazon = $this->config->item('amazon');
            $email_from = $this->config->item('email');

            $client = SesClient::factory(array(
                'version' => 'latest',
                'region' => $amazon['email_region'],
                'credentials' => array(
                    'key' => $amazon['AWSAccessKeyId'],
                    'secret' => $amazon['AWSSecretKey'],
                ),
            ));

            $request = array();
            $request['Source'] = $from_email.' <'.$email_from['from'].'>';
            $request['Destination']['ToAddresses'] = array($email);
            $request['Message']['Subject']['Data'] = $subject;
            $request['Message']['Subject']['Charset'] = "UTF-8";
            $request['Message']['Body']['Html']['Data'] = $body;
            $request['Message']['Body']['Charset'] = "UTF-8";
            $data_recipient = array(
                'from_userid' => $user_id,
                'from_usertype' => $user_type,
                'id_campaign' => '',
                'email_recipie' => $email,
                'Subject' => $subject,
                'Body' => $body,
                'date' => date('Y-m-d H:i:s'),
            );
            try {
                $result = $client->sendEmail($request);
                $messageId = $result->get('MessageId');
                //echo("Email sent! Message ID: $messageId"."\n");
                if ($messageId) {
                    $response['success'] = $this->lang->line('send_email_success');
                    $response['errors'] = false;
                    $data_recipient['sucess'] = '1';
                    $data_recipient['error_msg'] = ''; //$e->getMessage(),
                } else {
                    $response['errors'] = $this->lang->line('no_send_email');
                }

            } catch (Exception $e) {
                //echo("The email was not sent. Error message: ");
                //$response['errors'] = $e->getMessage()."\n";
                $response['errors'] = $this->lang->line('no_send_email');
                $data_recipient['sucess'] = '0';
                $data_recipient['error_msg'] = $e->getMessage();
            }
            $added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);

        return $response;
    }

    public function forgot_password_email(){
        if($this->input->is_ajax_request()) {
            $this->load->model('MiempresaModel');
            $email = $this->input->post('email', true);
            $user_role = $this->input->post('user_role', true);
            $data = array();
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run() == FALSE){
                $data = array('status' => false, 'error' => 'Invalid email');
            }else {
                if ($user_role == 'user') {
                    $user_data = $this->UsuarioModel->get_users(array('email' => $email));
                } elseif($user_role == 'teacher'){
                    $user_data = $this->ProfesorModel->get_campus_teachers(array('Email' => $email, 'Activo' => 1, 'enebc' => 1));
                }elseif ($user_role == 'student'){
                    $this->load->model('AlumnoModel');
                    $user_data = $this->AlumnoModel->get_campus_students(array('email' => $email, 'enebc' => 1));
                }
                if (!empty($user_data)) {
                    //$user_name = $user_role == 'user' ? $user_data[0]->user_name : $user_data[0]->teacher_name;
                    if ($user_role == 'user' || $user_role == 'student') {
                        $user_name = $user_data[0]->user_name;
                    } elseif($user_role == 'teacher'){
                        $user_name = $user_data[0]->teacher_name;
                    }else{
                        $user_name = '';
                    }

                    $company = $this->ProfesorModel->get_company_name();

                    $expiredate = date('Y-m-d', strtotime('+1 Day'));
                    $key_code = isset($this->_db_details->key) ? $this->_db_details->key : '';
                    $code = base64_encode($expiredate.'+'.$user_role.'+'.$user_data[0]->id.'+'.$email.'+'.$user_name.'+'.$key_code );
                    $href = base_url().'forgotPassword/index/'. urlencode($code);
                    
//                    $link = '<a href="' . $href . '"> Click here to reset the password. </a>';
//
//                    $message = '';
//                    $message .= ' <p>Hey ' . $user_name . ', </p>';
//                    $message .= '<p>A request to change your password has been made.</p>';
//                    $message .= '<p> To reset your password, click on the link below:</p>' . $link;
//                    $message .= '<p> If the above URL does not work, try copying and pasting it into your browser. Please feel free to contact us, if you continue to face any problems.</p>';
//                    $message .= '<br> <p>Regards</p>  <p>Akaud Team</p>';

                    $this->data['href'] = $href;
                    $this->data['user_name'] = $user_name;
                    $this->data['commercial_name'] = $this->MiempresaModel->getCompanyCommercialName();
//                    $this->lang->load('forget_pass_email', $this->data['lang']);

                    $message = $this->load->view('forgot_password/partials/email', $this->data, TRUE);
                    $amazon = $this->config->item('amazon');
                    $email_from = $this->config->item('email');

                    $client = SesClient::factory(array(
                        'version' => 'latest',
                        'region' => $amazon['email_region'],
                        'credentials' => array(
                            'key' => $amazon['AWSAccessKeyId'],
                            'secret' => $amazon['AWSSecretKey'],
                        ),
                    ));

                    $request = array();
                    $request['Source'] = $email_from['from'];
                    //$request['Destination']['ToAddresses'] = array('miasnikdavtyan@gmail.com');
                    $request['Destination']['ToAddresses'] = array($email);
                    $request['Message']['Subject']['Data'] =  $this->lang->line('forget_subject_text1'). " ". $company[0]->company_name . " ". $this->lang->line('forget_subject_text2');
                    $request['Message']['Subject']['Charset'] = "UTF-8";
                    $request['Message']['Body']['Html']['Data'] = $message;
                    $request['Message']['Body']['Charset'] = "UTF-8";

                    try {
                        $result = $client->sendEmail($request);
                        $messageId = $result->get('MessageId');
                        //echo("Email sent! Message ID: $messageId"."\n");
                        if ($messageId) {
                            $data = array('status' => true);
                        } else {
                            $data = array('status' => false);
                        }

                    } catch (Exception $e) {
                        //echo("The email was not sent. Error message: ");
                        //$response['errors'] = $e->getMessage()."\n";
                        $data = array('status' => false);
                    }
                }else{
                    $data = array('status' => false, 'error' => $this->lang->line('your_email_does_not_exist'));
                }
            }
            echo json_encode($data);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
}

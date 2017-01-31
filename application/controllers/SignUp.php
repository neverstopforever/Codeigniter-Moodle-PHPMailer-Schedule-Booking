<?php

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
class SignUp extends CI_Controller {


    public  $data;
    public  $_user_details;

    public function __construct() {
        parent::__construct();
        $this->load->model('ProfesorModel');
        $this->load->model('AlumnoModel');
        $this->load->library('form_validation');
        $this->data['variables2'] = null;
        if(!$this->input->is_ajax_request()) {
            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }
        }

    }


    public function teacher_activation($activation_code = null){
        $this->data['page'] = 'profile';
        if($activation_code){
            $activation_code = urldecode($activation_code);
            $activation_code = base64_decode($activation_code);
            $access_date = explode('+', $activation_code);
            if(isset($access_date[0]) && isset($access_date[1]) && isset($access_date[2])){
                $teacher_id = $access_date[2];
                $email = $access_date[1];
                $teacher_data = $this->ProfesorModel->get_campus_teachers(array('id' => $teacher_id, 'Activo' => 1, 'Email' => $email));
                $today = date('Y-m-d');
                $expiredate = $access_date[0];
               if(strtotime($expiredate) >= strtotime($today) && !empty($teacher_data)) {
                   $this->session->set_userdata('campus_teacher_id', $teacher_id);
                   $this->session->set_userdata('campus_teacher_name', $teacher_data[0]->user_name);
                   $update_data[0] = array('id' => $teacher_id, 'Clave' => '');
                   $this->ProfesorModel->update_teachers_data($update_data);
                   $this->data['teacher'] = $teacher_data[0];
                   $this->layouts->add_includes('js', '/app/js/sign_up/campus_teachers.js');

                  return  $this->layouts->view('sign_up/campus_teachers', $this->data, 'locked_profile');
               }
            }
        }

        $this->layouts->view('error_404',$this->data, 'error_404');
    }

    public function campus_teachers_sign_in(){
        if($this->input->is_ajax_request()) {
            $user_name = $this->input->post('user_name', true);
            $password = $this->input->post('password', true);
            $teacher_id = $this->input->post('teacher_id', true);
            $data = array();

            if($teacher_id == $this->session->userdata('campus_teacher_id')){
                if($this->session->userdata('campus_teacher_name') == ''){
                    $this->form_validation->set_rules('user_name', 'Username', 'required|is_unique[profesor.Usuario]');
                }else{
                    $user_name = $this->session->userdata('campus_teacher_name');
                }
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
                if ($this->form_validation->run() == FALSE) {
                    $data['err_name'] = form_error('user_name');
                    $data['err_pass'] = form_error('password');
                    $data['err_confirm_password'] = form_error('confirm_password');
                    $data['success'] = false;

                }else{
                    $update_data[0] = array('id' => $teacher_id, 'Clave' => $password, 'Usuario' => $user_name);
                    $this->ProfesorModel->update_teachers_data($update_data);
                    $this->session->unset_userdata('campus_teacher_id');
                    $this->session->unset_userdata('campus_teacher_name');
                    $data['success'] = true;
                    $data['err_name'] = '';
                    $data['err_pass'] = '';
                    $data['err_confirm_password'] = '';
                }


            }

            echo json_encode($data);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
// Camous students
    public function student_activation($activation_code = null){
        $this->data['page'] = 'profile';
        if($activation_code){
            $activation_code = urldecode($activation_code);
            $activation_code = base64_decode($activation_code);
            $access_date = explode('+', $activation_code);
            if(isset($access_date[0]) && isset($access_date[1]) && isset($access_date[2])){
                $student_id = $access_date[2];
                $email = $access_date[1];
                $student_data = $this->AlumnoModel->get_campus_students(array('ccodcli' => $student_id, 'enebc' => 1, 'email' => $email));
                $today = date('Y-m-d');
                $expiredate = $access_date[0];
                if(strtotime($expiredate) >= strtotime($today) && !empty($student_data)) {
                    $this->session->set_userdata('campus_student_id', $student_id);
                    $this->session->set_userdata('campus_student_name', $student_data[0]->usuario);
                    $update_data[0] = array('ccodcli' => $student_id, 'clave' => '');
                    $this->AlumnoModel->update_student_data($update_data);
                    $this->data['student'] = $student_data[0];
                    $this->layouts->add_includes('js', '/app/js/sign_up/campus_students.js');

                    return  $this->layouts->view('sign_up/campus_students', $this->data, 'locked_profile');
                }
            }
        }

        $this->layouts->view('error_404',$this->data, 'error_404');
    }

    public function campus_students_sign_in(){
        if($this->input->is_ajax_request()) {
            $user_name = $this->input->post('user_name', true);
            $password = $this->input->post('password', true);
            $student_id = $this->input->post('student_id', true);
            $data = array();

            if($student_id == $this->session->userdata('campus_student_id')){
                if($this->session->userdata('campus_student_name') == ''){
                    $this->form_validation->set_rules('user_name', 'Username', 'required|is_unique[alumnos.usuario]');
                }else{
                    $user_name = $this->session->userdata('campus_student_name');
                }
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
                if ($this->form_validation->run() == FALSE) {
                    $data['err_name'] = form_error('user_name');
                    $data['err_pass'] = form_error('password');
                    $data['err_confirm_password'] = form_error('confirm_password');
                    $data['success'] = false;

                }else{
                    $update_data[0] = array('ccodcli' => $student_id, 'clave' => $password, 'usuario' => $user_name);
                    $this->AlumnoModel->update_student_data($update_data);
                    $this->session->unset_userdata('campus_student_id');
                    $this->session->unset_userdata('campus_student_name');
                    $data['success'] = true;
                    $data['err_name'] = '';
                    $data['err_pass'] = '';
                    $data['err_confirm_password'] = '';
                }


            }

            echo json_encode($data);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
}

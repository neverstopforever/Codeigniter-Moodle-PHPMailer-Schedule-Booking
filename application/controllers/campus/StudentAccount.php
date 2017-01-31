<?php defined('BASEPATH') OR exit('No direct script access allowed');

class StudentAccount extends MY_Campus_Controller {

    public function __construct(){
        parent::__construct();
        $this->lang->load('campus',$this->data['lang']);
        if(!$this->session->userdata('campus_user')){
                redirect('campus/auth/login/', 'refresh');
        }
//        $this->layouts->add_includes('js', 'app/js/campus/student_resource/main.js');
        $this->data['student_id'] = isset($this->data['campus_user']['CCODCLI']) ? $this->data['campus_user']['CCODCLI'] : redirect('campus/auth/login/', 'refresh');
        $this->lang->load('manage_invoice', $this->data['lang']);
        $this->lang->load('quotes', $this->data['lang']);
    }

    public function index(){
        $this->layouts->add_includes('js', 'app/js/campus/student_account/index.js');
        $this->load->model('FacturaModel');
        $this->load->model('ReciboModel');
        $this->data['invoices'] = $this->FacturaModel->getInvoicesDataByStudent($this->data['student_id']);
        $this->data['quotes'] = $this->ReciboModel->getReceiptListByStudent($this->data['student_id']);
        $this->layouts->view('campus/student_account/index', $this->data, 'campus_student_account');
    }

    public function print_individual_invoice(){
        if($this->input->is_ajax_request()){
            $response['html'] = '';
            $invoice_id = $this->input->post('invoice_id', true);
            if(!empty($invoice_id)) {
                $this->load->model('FacturaModel');
                $this->load->model('FacturalModel');
                $this->data['page'] = "manage_invoices_edit";

                $this->data['personal_data'] = $this->FacturaModel->get_personal_data($invoice_id, $this->data['student_id']);
                if (!empty($this->data['personal_data'])) {
                    $this->data['details'] = $this->FacturaModel->get_details($invoice_id);
                    $this->data['services'] = $this->FacturalModel->get_services($invoice_id);

                    $this->load->model('MiempresaModel');
                    $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();

                    if ($this->_db_details->plan != '1') {
                        $this->load->model('Variables2Model');
                        $logo = $this->Variables2Model->get_logo();
                        $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
                    } else {
                        $this->data['logo'] = '';
                    }
//                $this->data['quotes'] = $this->ReciboModel->get_quotes_by_invoiceId($invoice_id);

                    $this->data['payment_methods'] = array(
                        0 => $this->lang->line('quotes_cash'),
                        1 => $this->lang->line('quotes_credit_card'),
                        2 => $this->lang->line('quotes_direct_debit'),
                        3 => $this->lang->line('quotes_transfer'),
                        4 => $this->lang->line('quotes_check'),
                        5 => $this->lang->line('quotes_financed'),
                        6 => $this->lang->line('quotes_online_payment')
                    );
                    $this->data['enrollments'] = null;
                    if (isset($this->data['personal_data']->role)
                        && $this->data['personal_data']->role == "student"
                    ) {
                        $this->load->model('MatriculatModel');
//            $this->data['enrollments'] = $this->MatriculatModel->getEnrollmentsByStudentId($this->data['personal_data']->customer_id);
                        $this->data['enrollments'] = $this->MatriculatModel->getStudentEnrollmentsForSelect();
                    }

                    $this->data['invoice_id'] = $invoice_id;

                    $response['html'] = $this->load->view('manage_invoices/partials/edit/print_individual_invoice', $this->data, true);
                }
            }
//            echo json_encode($response);
            echo $response['html'];
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function print_individual_quote(){
        $response = array();
        $response['html'] = '';
        if($this->input->post()) {
            $this->load->model('ReciboModel');
            $quote_id = $this->input->post('quote_id', true);
            $receipt = $this->ReciboModel->getQuotesDataPrint($quote_id, $this->data['student_id']);
            $this->load->model('MiempresaModel');
            $this->data['fiscal_data'] = $this->MiempresaModel->get_fiscal_data();
            if ($this->_db_details->plan != '1') {
                $this->load->model('Variables2Model');
                $logo = $this->Variables2Model->get_logo();
                $this->data['logo'] = isset($logo->logo) ? $logo->logo : '';
            }else{
                $this->data['logo'] = '';
            }
            $this->data['payment_methods'] = array(
                0 => $this->lang->line('quotes_cash'),
                1 => $this->lang->line('quotes_credit_card'),
                2 => $this->lang->line('quotes_direct_debit'),
                3 => $this->lang->line('quotes_transfer'),
                4 => $this->lang->line('quotes_check'),
                5 => $this->lang->line('quotes_financed'),
                6 => $this->lang->line('quotes_online_payment')
            );
            if (!empty($receipt)) {
                $this->data['quote'] = $receipt;
                $response['html'] = $this->load->view('quotes/partials/print_cashed_quote', $this->data, true);
            }
        }
        echo json_encode($response);exit;
    }

}
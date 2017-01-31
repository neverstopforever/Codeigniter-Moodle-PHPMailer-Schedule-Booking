<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'Base_controller.php';
/**
 * Description of LeadsView
 *
 * @author Basit Ullah
 * @property LeadsModel $LeadsModel
 * @property TemplateModel $TemplateModel
 */
class LeadsView extends Base_controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == '') {
            redirect('/auth/login/', 'refresh');
        }
        $this->output->enable_profiler(false);
        $this->load->model("TemplateModel");
        $ckeyslang = $this->my_language->load('column_key');
        $this->data['page'] = 'Data Records';
        $this->data['dataKeys'] = $ckeyslang;
        $this->load->model("LeadsModel");
    }

    public function addLeads() {
        $lang = $this->session->userdata('lang');
        $this->lang->load('clientes_form', $lang);
        $this->data["flashMsg"] = "";
        if ($this->session->flashdata('editMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('editMsg');
        } else if ($this->session->flashdata('addMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addMsg');
        } else if ($this->session->flashdata('deleteMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('deleteMsg');
        } else if ($this->session->flashdata('addErrorMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addErrorMsg');
        }
        $this->data['lang'] =  $lang;
        $this->data['clienteId'] = $this->session->userdata("userData")[0]->Id;

        $estado_data = $this->LeadsModel->getEstadoData();
        $this->data['estado_data'] = $estado_data;

        $medios_data = $this->LeadsModel->getMediosData();
        $this->data['medios_data'] = $medios_data;

        $this->load->view("leads/addLead", $this->data);
    }

    public function getIncreasedValue() {
        $leadsCheck = $this->input->post("leadsCheck");
        if ($leadsCheck) {
            if ($leadsCheck == "newAdd") {
                $leadId = $this->LeadsModel->updateVariable();
                echo trim($leadId);
            }
        }
    }

    public function getLeadIncrementedId() {
        $leadId = $this->LeadsModel->updateVariable();
        return trim($leadId);
    }

    public function addLeadsRecords() {
        $formData = $this->input->post();

        $result = $this->LeadsModel->addLeadsRecords($formData);
        if ($result > 0) {
            redirect(base_url() . "Leads");
        } else {
            $this->session->set_flashdata('addMsg', 'There is an error while adding user!');
            redirect(base_url() . "LeadsView/addLeads");
        }
    }

    public function getCopyUsers() {
        $this->data["users"] = $this->LeadsModel->getCopyUsers();
        $html = $this->load->view("leads/getCopyUsers", $this->data, true);
        echo $html;
    }

    public function getCopyUsersArray() {
        $formData = $this->input->post();
        $users = $this->LeadsModel->getCopyUsers($formData);
        $items = array();
        foreach ($users as $user) {
            array_push($items, $user);
        }
        $result["rows"] = $items;

        echo json_encode($result);
    }

    public function addExistUser($userId = false, $profileId = false) {
        $leadId = $this->getLeadIncrementedId();
//        echo $leadId; exit;
        if ($leadId > 0 && $userId > 0) {
            $result = $this->LeadsModel->addExistingUser($leadId, $userId, $profileId);
            if ($result > 0) {
                redirect(base_url() . "Leads/edit/" . $result);
            } else {
                $this->session->set_flashdata('addMsg', 'There is an error while add user!');
                redirect(base_url() . "LeadsView/addLeads/");
            }
        }
    }

    public function deleteLead($leadId = false, $profileId = false) {
        if ($leadId > 0) {
            $result = $this->LeadsModel->deleteLead($leadId, $profileId);
            redirect(base_url() . "Leads");
        }
    }

}

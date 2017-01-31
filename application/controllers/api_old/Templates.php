<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'Base_controller.php';
/**
 * Description of templates
 *
 * @author Basit Ullah
 *@property magaModel $magaModel
 *@property LstPlantillaModel $LstPlantillaModel
 */
class Templates extends Base_controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == '') {
            redirect('/auth/login/', 'refresh');
        }
        $this->output->enable_profiler(false);
        $this->load->model("TemplateModel");
        $this->load->model("LstPlantillaModel");
        $ckeyslang = $this->my_language->load('column_key');
        $this->data['page'] = 'Data Records';
        $this->data['dataKeys'] = $ckeyslang;
    }

    public function index() {
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
        $this->data["templates"] = $this->TemplateModel->getAllTemplates();
        $this->data["categories"] = $this->TemplateModel->getAllCategories();
        $this->load->view("templates/index", $this->data);
    }

    public function add() {
        $this->data["formData"] = "";
        $this->data["flashMsg"] = "";
        if ($this->session->flashdata('addErrorMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addErrorMsg');
        }
        $this->data["categories"] = $this->TemplateModel->getAllCategories();
        $this->load->view("templates/add", $this->data);
    }

    public function addConfirm() {
        $formData = $this->input->post();
        $formData["filename"] = "";
        $formData["data"] = "";
        $fileTrypes = array("doc", "xls");
        if (isset($_FILES['DocAsociado']) && $_FILES['DocAsociado']['size'] > 0) {
// Temporary file name stored on the server
            $tmpName = $_FILES['DocAsociado']['tmp_name'];
            $filename = $_FILES['DocAsociado']['name'];
            $filetype = $this->stripExtension($filename);
            if (in_array($filetype, $fileTrypes)) {
// Read the file
                $fp = fopen($tmpName, 'r');
                $data = fread($fp, filesize($tmpName));
                $data = addslashes($data);
                fclose($fp);
                $formData["filename"] = $filename;
                $formData["data"] = $data;
            } else {
                $this->session->set_flashdata('addErrorMsg', 'Document File should be .doc or .xls');
                redirect(base_url() . "Templates/add");
            }
        }
        $result = $this->TemplateModel->addTemplate($formData);
        if ($result > 0) {
            $this->session->set_flashdata('addMsg', 'Template has been successfully added!');
            redirect(base_url() . "Templates");
        } else {
            $this->data["categories"] = $this->TemplateModel->getAllCategories();
            $this->data["formData"] = $this->input->post();
            $this->load->view("templates/add", $this->data);
        }
    }

    public function edit($templateId = false) {
        $this->data["formData"] = "";
        $this->data["categories"] = $this->TemplateModel->getAllCategories();
        $this->data["template"] = $this->TemplateModel->getTemplateById($templateId);
        $this->data["documents"] = "";
        $this->data["macros"] = "";
        if ($this->data["template"]->id_cat > 0) {
            $this->data["documents"] = $this->TemplateModel->getAllTemplates($this->data["template"]->id_cat);
            $this->data["macros"] = $this->TemplateModel->getMacrosByCatId($this->data["template"]->id_cat);
        }
        $this->data["flashMsg"] = "";
        if ($this->session->flashdata('editErrorMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('editErrorMsg');
        }
        $this->load->view("templates/edit", $this->data);
    }

    public function editConfirm() {
        $formData = $this->input->post();
        $formData["filename"] = "";
        $formData["data"] = "";
        $fileTrypes = array("doc", "xls");
        if (isset($_FILES['DocAsociado']) && $_FILES['DocAsociado']['size'] > 0) {
// Temporary file name stored on the server
            $tmpName = $_FILES['DocAsociado']['tmp_name'];
            $filename = $_FILES['DocAsociado']['name'];
            $filetype = $this->stripExtension($filename);
// Read the file
            if (in_array($filetype, $fileTrypes)) {
                $fp = fopen($tmpName, 'r');
                $data = fread($fp, filesize($tmpName));
                $data = addslashes($data);
                fclose($fp);
                $formData["filename"] = $filename;
                $formData["data"] = $data;
            } else {
                $this->session->set_flashdata('editErrorMsg', 'Document File should be .doc or .xls');
                redirect(base_url() . "Templates/edit");
            }
        }
        $result = $this->TemplateModel->editTemplate($formData);
        if ($result > 0) {
            $this->session->set_flashdata('editMsg', 'Template has been successfully updated!');
            redirect(base_url() . "Templates");
        } else {
            $this->data["categories"] = $this->TemplateModel->getAllCategories();
            $this->data["formData"] = $this->input->post();
            $this->load->view("templates/add", $this->data);
        }
    }

    public function download($templateId = false) {
        $result = $this->TemplateModel->getTemplateById($templateId);
        if (isset($result->documento) && $result->documento != "") {
            $filename = isset($result->DocAsociado) ? str_replace(" ", "-", $result->DocAsociado) : "";
            $fullpath = $_SERVER["DOCUMENT_ROOT"] . '/crm/downloads/' . $filename;
            file_put_contents($fullpath, $result->documento);

            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Length: " . filesize($fullpath) . ";");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/pdf ");
            header("Content-Transfer-Encoding: binary");

            readfile($fullpath);
        }
//        echo $result->documento;
    }

    public function stripExtension($filename = '') {
        if (!empty($filename)) {
            $filename = strtolower($filename);
            $extArray = explode(".", $filename);
            $p = count($extArray);
            $p = $p - 1;
            $extension = $extArray[$p];
            return $extension;
        } else {
            return false;
        }
    }

    public function delete($templateId = false) {
        if ($templateId) {
            $this->TemplateModel->delete($templateId);
            $this->session->set_flashdata('deleteMsg', 'Template has been successfully deleted!');
            redirect(base_url() . "Templates");
        } else {
            redirect(base_url() . "Templates");
        }
    }

    public function search() {
        $formData = $this->input->post();
        if (isset($formData["searchCategory"])) {
            if ($formData["searchCategory"] != "all") {
                $this->data["templates"] = $this->TemplateModel->getAllTemplates($formData["searchCategory"]);
                $this->data["categories"] = $this->TemplateModel->getAllCategories();
                $this->data["searchCategory"] = $formData["searchCategory"];
                $this->load->view("templates/index", $this->data);
            } else {
                $this->data["templates"] = $this->TemplateModel->getAllTemplates();
                $this->data["categories"] = $this->TemplateModel->getAllCategories();
                $this->data["searchCategory"] = $formData["searchCategory"];
                $this->load->view("templates/index", $this->data);
            }
        } else {
            redirect(base_url() . "Templates");
        }
    }

    public function getDocumentoByCatId() {
        $formData = $this->input->post();
        $this->data["documents"] = $this->TemplateModel->getAllTemplates($formData["category_id"]);
        $html = $this->load->view("templates/getDocumentoByCatId", $this->data, true);
        echo $html;
    }

    public function getMacrosByCatId() {
//        $formData = $_REQUEST;
        $formData = $this->input->post();
        $this->data["macros"] = $this->TemplateModel->getMacrosByCatId($formData["category_id"]);
        $html = $this->load->view("templates/getMacrosByCatId", $this->data, true);
        echo $html;
    }

    public function printTemplate() {
        $formData = $this->input->post();
//        $result = $this->TemplateModel->getTemplateById($formData["templateId"]);
        if (isset($formData["templateId"]) && $formData["templateId"] > 0) {
            //no need php mysql_connect function or something else here
            $result = $this->LstPlantillaModel->getById($formData["templateId"]);
            $result = $result[0];
//            $extension = $this->stripExtension($result->DocAsociado);
            $filename = isset($result->DocAsociado) ? str_replace(" ", "-", $result->DocAsociado) : "";
//            $filename = rand(0000, 9999) . "." . $extension;
            $fullpath = $_SERVER["DOCUMENT_ROOT"] . '/crm/downloads/' . $filename;
//            $fullpath = $_SERVER["DOCUMENT_ROOT"] . '/downloads/' . $filename;
            file_put_contents($fullpath, $result->documento);
//            echo $formData["templateId"]; exit;
            $file_url = base_url() . 'crm/downloads/' . $filename;
//            $file_url = base_url() . 'downloads/' . $filename;
            $this->load->model("CompanyModel");
            $companyData = $this->CompanyModel->getCompantBtId($formData["clientId"]);
            $companyDataFields = $this->CompanyModel->getCompantByIdFields($formData["clientId"]);
//            $this->load->library("Word");
            $PHPWord = new \PhpOffice\PhpWord\PhpWord();
            $document = $PHPWord->loadTemplate($fullpath);

// simple parsing
            foreach ($companyDataFields as $fields) {
                $document->setValue("[$fields]", $companyData[$fields]);
            }
//            $document->setValue('[idempresa]', $companyData->CCODCLI);
//            $document->setValue('[nombre comercial]', $companyData->CnomCom);
//            $document->setValue('[Email]', $companyData->Email);
            $document->save($fullpath);
            redirect($file_url);
        }
        exit;
    }

    public function printTemplateLeads() {
        $formData = $this->input->post();

//        $result = $this->TemplateModel->getTemplateById($formData["templateId"]);
        if (isset($formData["templateId"]) && $formData["templateId"] > 0) {

            $result = $this->LstPlantillaModel->getById($formData["templateId"]);
            $result = $result[0];

//            $extension = $this->stripExtension($result->DocAsociado);
            $filename = isset($result->DocAsociado) ? str_replace(" ", "-", $result->DocAsociado) : "";
//            $filename = rand(0000, 9999) . "." . $extension;
            $fullpath = $_SERVER["DOCUMENT_ROOT"] . '/crm/downloads/' . $filename;
            file_put_contents($fullpath, $result->documento);
//            echo $formData["templateId"]; exit;
            $file_url = base_url() . 'crm/downloads/' . $filename;
//            $file_url = base_url() . 'downloads/' . $filename;
            $this->load->model("CompanyModel");
            $companyData = $this->CompanyModel->getLeadById($formData["clientId"]);
            $companyDataFields = $this->CompanyModel->getLeadByIdFields($formData["clientId"]);
//            $this->load->library("Word");
            $PHPWord = new \PhpOffice\PhpWord\PhpWord();
            $document = $PHPWord->loadTemplate($fullpath);

// simple parsing
            foreach ($companyDataFields as $fields) {
                $document->setValue("[$fields]", $companyData[$fields]);
            }
            $document->save($fullpath);
            redirect($file_url);
        }
        exit;
    }

}

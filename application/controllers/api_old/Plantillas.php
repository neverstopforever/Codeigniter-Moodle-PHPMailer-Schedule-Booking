<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/PhpWord/TemplateProcessor.php";
require_once APPPATH . "/third_party/PhpWord/PhpWord.php";
require_once APPPATH . "/third_party/PhpWord/Collection/Bookmarks.php";
require_once APPPATH . "/third_party/PhpWord/Collection/AbstractCollection.php";
require_once APPPATH . "/third_party/PhpWord/IOFactory.php";
;
require_once APPPATH . "/third_party/PhpWord/Exception/Exception.php";
;
require_once APPPATH . "/third_party/PhpWord/Settings.php";
;
require_once APPPATH . "/third_party/PhpWord/Shared/ZipArchive.php";
;
require_once APPPATH . "/third_party/PhpWord/TemplateProcessor.php";
;

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/28/15
 * Time: 1:01 PM
 *@property magaModel $magaModel
 *@property DocumentTemplateModel $DocumentTemplateModel
 *@property ContactosModel $ContactosModel
 *@property LstPlantillaModel $LstPlantillaModel
 *@property LstPlantillasCatModel $LstPlantillasCatModel
 */
class plantillas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("DocumentTemplateModel");
        $this->load->library("form_validation");
        $this->load->helper('download');
        $this->load->model('ContactosModel');
        $this->load->model('LstPlantillaModel');

        $this->config->set_item('language', $this->data['lang']);
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function index_get() {
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') != '') {
            $lang = $this->session->userdata('lang');
            $ckeyslang = $this->my_language->load('column_key');
            $data['page'] = 'Data Records';
            $data['dataKeys'] = $ckeyslang;
            $data['plantillas_cat'] = $this->plantillas_cat_get();
            $this->load->view('templateEditview', $data);
        } else {
            redirect('/auth/login/', 'refresh');
        }
    }

    public function template_get() {

        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules("id", "id", "required|integer");
        $data = array();
        if ($this->form_validation->run() == False) {
            $data['status'] = false;

            $data['error'] = validation_errors();
        } else {
            $doc = $this->DocumentTemplateModel->get_single_document($this->input->get('id'));
            $file = $doc[0]["documento"];
            $filename = "temp/" . uniqid() . $doc[0]['DocAsociado'];
            file_put_contents($filename, $file);
            chmod($filename, 0644);
            $document = \PhpOffice\PhpWord\IOFactory::load($filename, "MsDoc");
//            $d=new \PhpOffice\PhpWord\TemplateProcessor($filename);
//            echo "<pre>";print_r($document);echo "</pre>";exit;

            $writter = \PhpOffice\PhpWord\IOFactory::createWriter($document);
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=helloWorld.docx");
            header("Content-Type: application/application/vnd.openxmlformats-officedocument.wordprocessingml.document");
            header("Content-Transfer-Encoding: binary");
            ob_clean();
            ob_flush();
            $writter->save("php://output");

//            force_download($doc[0]['DocAsociado'],$file);
        }

        echo json_encode($data);
    }

    public function plantillas_add_update_post() {
        $id = $this->post('id');
        $data = ['id_cat' => $this->post('id_cat'), 'Nombre' => $this->post('Nombre'), 'webDocumento' => $this->post('webDocumento'), 'DocAsociado' => $this->post('DocAsociado')];
        if ($this->post('template_option') == 1) {
            $details = $this->magaModel->insert('lst_plantillas', $data);
        } else {
            $details = $this->magaModel->update('lst_plantillas', $data, array('id' => $id));
        }
        redirect('plantillas', 'refresh');
    }

    public function documentos_post($id) {
        $details = $this->LstPlantillaModel->getDocumentos($id);
        $docAsociado = [];
        if (!empty($details)) {
            $docAsociado[] = ['id' => '0', 'name' => 'select'];
            foreach ($details as $row) {
                $DocAsociado[] = ['id' => $row->id, 'name' => $row->DocAsociado];
            }
        }
        $attribute = [];
        $attribute[] = ['id' => '[idempresa]', 'name' => 'idempresa'];
        $attribute[] = ['id' => '[nombrecomercial]', 'name' => 'nombrecomercial'];
        $attribute[] = ['id' => '[nombrefiscal]', 'name' => 'nombrefiscal'];
        $attribute[] = ['id' => '[domicilio]', 'name' => 'domicilio'];
        $attribute[] = ['id' => '[poblacion]', 'name' => 'poblacion'];
        $attribute[] = ['id' => '[provincia]', 'name' => 'provincia'];
        $attribute[] = ['id' => '[distrito]', 'name' => 'distrito'];
        $attribute[] = ['id' => '[telefono1º]', 'name' => 'telefono1º'];
        $attribute[] = ['id' => '[telefono2º]', 'name' => 'telefono2º'];
        $attribute[] = ['id' => '[fax]', 'name' => 'fax'];
        $attribute[] = ['id' => '[dnicif]', 'name' => 'dnicif'];
        $attribute[] = ['id' => '[entidadbancaria]', 'name' => 'entidadbancaria'];
        $attribute[] = ['id' => '[oficinabancaria]', 'name' => 'oficinabancaria'];
        $attribute[] = ['id' => '[dc]', 'name' => 'dc'];
        $attribute[] = ['id' => '[cuentabancaria]', 'name' => 'cuentabancaria'];
        $attribute[] = ['id' => '[email]', 'name' => 'email'];
        $attribute[] = ['id' => '[banco]', 'name' => 'banco'];
        $attribute[] = ['id' => '[iban]', 'name' => 'iban'];
        $attribute[] = ['id' => '[skypeempresa]', 'name' => 'skypeempresa'];
        $attribute[] = ['id' => '[fechaalta]', 'name' => 'fechaalta'];
        $attribute[] = ['id' => '[lastupdate]', 'name' => 'lastupdate'];
        $attribute[] = ['id' => '[fechamodificación]', 'name' => 'fechamodificación'];
        $attribute[] = ['id' => '[Num_SS]', 'name' => 'Num_SS'];

        $data = ['DocAsociado' => $DocAsociado, 'attribute' => $attribute];
        echo json_encode($data);
        //return json_encode($DocAsociado);
    }

    public function documentodata_post($id) {
        $details =$this->LstPlantillaModel->getDocumentoData($id);
        echo json_encode($details);
    }

    public function plantillas_cat_get() {
        $details = $this->LstPlantillasCatModel->getPlantillasCat();
        $plantillas_cat = [];
        $plantillas_cat[''] = 'Select';
        if (!empty($details)) {
            foreach ($details as $row) {
                $plantillas_cat[$row->id] = $row->nombre;
            }
        }
        return $plantillas_cat;
    }

}

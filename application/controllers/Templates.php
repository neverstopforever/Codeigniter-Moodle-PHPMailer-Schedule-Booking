<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\S3\S3Client;
class Templates extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == '') {
            redirect('/auth/login/', 'refresh');
        }
        //$this->layout = 'templates';
        $this->output->enable_profiler(false);
        $this->load->model("TemplateModel");
        $this->lang->load('quicktips', $this->data['lang']);
        $this->lang->load('templates', $this->data['lang']);
        $this->load->model("LstPlantillaModel");
        $ckeyslang = $this->my_language->load('column_key');
        $this->data['page'] = 'Data Records';
        $this->data['dataKeys'] = $ckeyslang;
        $this->load->library('user_agent');
		$this->load->library('PdfCrowd');
        $this->layouts->add_includes('js', 'app/js/templates/main.js');
    }

    public function index() {
        $this->layouts->add_includes('css', 'assets/js/datagrid/themes/default/easyui.css')
            ->add_includes('css', 'assets/js/datagrid/themes/icon.css')
            ->add_includes('js', 'assets/js/datagrid/jquery.easyui.min.js')
            ->add_includes('js', 'app/js/templates/index.js');
        $this->data["page"] = "templates_index";
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
//        $this->data["templates"] = $this->TemplateModel->getAllTemplates();
//        $this->data["categories"] = $this->TemplateModel->getAllCategories();
        $this->data["categories"] =array(
            '0'=> array(
                'id' => '1',
                'nombre'=>$this->lang->line('Enrollments'),
                ),
            '1'=> array(
                'id' => '7',
                'nombre'=>$this->lang->line('Prospects'),
            ),
        );
        $this->layouts->view("templates/index", $this->data);
    }
   
    public function add() {
//		$this->layout = 'templates';
        //echo $this->router->fetch_class().'--' .$this->router->fetch_method();exit;
        $this->layouts->add_includes('css', 'app/css/style.css')
            ->add_includes('css', 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');

        $this->layouts->add_includes('js', 'editor/js/feather.js')
            ->add_includes('js', 'editor/js/jquery.ui.touch-punch.min.js')
            ->add_includes('js', 'assets/global/plugins/tinymce/tinymce.min.js')
            ->add_includes('js', 'assets/global/plugins/tinymce/jquery.tinymce.min.js')
            ->add_includes('js', 'editor/js/plugin.min.js')
            ->add_includes('js', 'editor/js/colpick.js')
            ->add_includes('js', 'editor/js/template.editor.js')
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('js', 'app/js/templates/add.js');

        $this->data["formData"] = "";
        $this->data["flashMsg"] = "";
       if ($this->session->flashdata('addErrorMsg')) {
           $this->data["flashMsg"] = $this->session->flashdata('addErrorMsg');
        }
//       $this->data["categories"] = $this->TemplateModel->getAllCategories();
        $this->data["categories"] =array(
            '0'=> array(
                'id' => '1',
                'nombre'=>$this->lang->line('Enrollments'),
            ),
            '1'=> array(
                'id' => '7',
                'nombre'=>$this->lang->line('Prospects'),
            ),
        );
       $this->layouts->view("templates/add", $this->data , $this->layout);
       
    }

    public function addConfirm() {
        $this->layouts->add_includes('js', 'app/js/templates/add.js');
        $formData = $this->input->post();
		
        $formData['aws_link'] = null;
		$formData["filename"] = "";
        $formData["data"] = "";
        $fileTrypes = array("docx");
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

                //aws s3
                $amazon = $this->config->item('amazon');
                $client = new S3Client(array(
                    'version' => 'latest',
                    'credentials' => array(
                        'key'       => $amazon['AWSAccessKeyId'],
                        'secret'    => $amazon['AWSSecretKey'],
                    ),
                    'region' => $amazon['region'],
                    'client_defaults' => ['verify' => false]
                ));
                $unique_name = md5(uniqid(rand(), true)) . '-' . $_FILES['DocAsociado']['name'];
                $key = $this->_db_details->idcliente .'/LMS/files/templates/'. $unique_name;
                $res = $client->putObject(array(
                    'Bucket' =>  $amazon['bucket'],
                    'Key' => $key,
                    'SourceFile' => $_FILES['DocAsociado']['tmp_name'],
                    'ACL' => 'public-read',
                    'ContentType' => 'text/plain'
                ));
                if(isset($res['ObjectURL'])){
                    $formData['aws_link'] = $res['ObjectURL'];
                }
                //aws s3 end
            } else {
                $this->session->set_flashdata('addErrorMsg', 'Document File should be .doc or .xls');
                redirect(base_url() . "Templates/add");
            }
        }
        //$result = $this->TemplateModel->addTemplate($formData);
        $result = $this->TemplateModel->addTemplateWithAws($formData);
        if ($result > 0) {
            $this->session->set_flashdata('addMsg', 'Template has been successfully added!');
            redirect(base_url() . "Templates");
        } else {
            $this->data["categories"] = $this->TemplateModel->getAllCategories();
            $this->data["formData"] = $this->input->post();
            $this->layouts->view("templates/add", $this->data);
        }
    }

    public function edit($templateId = false) {
//	$this->layout = 'templates';
        $this->layouts->add_includes('js', 'editor/js/feather.js')
            ->add_includes('js', 'editor/js/jquery.ui.touch-punch.min.js')
            ->add_includes('js', 'assets/global/plugins/tinymce/tinymce.min.js')
            ->add_includes('js', 'assets/global/plugins/tinymce/jquery.tinymce.min.js')
            ->add_includes('js', 'editor/js/plugin.min.js')
            ->add_includes('js', 'editor/js/colpick.js')
            ->add_includes('js', 'editor/js/template.editor.js')
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('js', 'app/js/templates/edit.js');
	$this->data["formData"] = "";
//	$this->data["categories"] = $this->TemplateModel->getAllCategories();
        $this->data["categories"] =array(
            '0'=> array(
                'id' => '1',
                'nombre'=>$this->lang->line('Enrollments'),
            ),
            '1'=> array(
                'id' => '7',
                'nombre'=>$this->lang->line('Prospects'),
            ),
        );
	$this->data["template"] = $this->TemplateModel->getTemplateById($templateId);
        if(empty($this->data["template"] )){
            redirect('templates');
        }
	$this->data["documents"] = "";
	$this->data["macros"] = "";
	if ($this->data["template"]->id_cat > 0) {
		$this->data["documents"] = $this->TemplateModel->getAllTemplates($this->data["template"]->id_cat);
		$this->data["macros"] = $this->TemplateModel->getMacrosByCatId($this->data["template"]->id_cat);
	}
	$this->data["flashMsg"] = "";
	$this->data["templateId"] = $templateId;
	if ($this->session->flashdata('editErrorMsg')) {
	$this->data["flashMsg"] = $this->session->flashdata('editErrorMsg');
	}
	$this->layouts->view("templates/edit", $this->data, $this->layout);
    }

    public function editConfirm() {
        $this->layouts->add_includes('js', 'app/js/templates/edit.js');
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

                //aws s3
                $amazon = $this->config->item('amazon');
                $client = new S3Client(array(
                    'version' => 'latest',
                    'credentials' => array(
                        'key'       => $amazon['AWSAccessKeyId'],
                        'secret'    => $amazon['AWSSecretKey'],
                    ),
                    'region' => $amazon['region'],
                    'client_defaults' => ['verify' => false]
                ));


                $unique_name = md5(uniqid(rand(), true)) . '-' . $_FILES['DocAsociado']['name'];
                $key = $this->_db_details->idcliente .'/LMS/files/templates/'. $unique_name;

                $res = $client->putObject(array(
                    'Bucket' =>  $amazon['bucket'],
                    'Key' => $key,
                    'SourceFile' => $_FILES['DocAsociado']['tmp_name'],
                    'ACL' => 'public-read',
                    'ContentType' => 'text/plain'
                ));
                if(isset($res['ObjectURL'])){
                    $formData['aws_link'] = $res['ObjectURL'];
                }
                //aws s3 end

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
            $this->layouts->view("templates/add", $this->data);
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
            $this->TemplateModel->deleteTemplate($templateId);
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
	public function inserpdfvalue(){
	   $this->layout = 'templates';
	   $this->layouts->view("templates/inserpdfvalue", $this->data , $this->layout);
	}
	public function pdfprint(){
		$pdfname = $this->uri->segment(3);
		$formData = $this->input->post();
		$filename = $pdfname.'.html';
		$filepath = base_url()."editor/tmp/".$filename;
		require_once("html2pdf/html2pdf.class.php");
		$html2pdf = new HTML2PDF("P", "A4", "en", array(10, 10, 10, 10));
		$html2pdf->setEncoding("ISO-8859-1");
		$html2pdf->WriteHTML($filename);
		$html2pdf->Output("pdf/PDF.pdf", "F"); //output to file
		$html2pdf->Output(); //output to browser

		try	{   
			$client = new Pdfcrowd("ratan", "cb43239f7f127bccb5f489001d1a5238");
			$filename = file_get_contents($filepath);
			$filename = str_replace(array('[FIRST_NAME]','[LAST_NAME]'),$formData,$filename);
			$pdf = $client->convertHtml($filename);
			header("Content-Type: text/html; charset=iso-8859-1");
			header("Cache-Control: max-age=0");
			header("Accept-Ranges: none");
			header("Content-Disposition: attachment; filename=".$pdfname."".'.pdf');
			echo $pdf;
		}
		catch(PdfcrowdException $why){
			echo "Pdfcrowd Error: " . $why;
		}
	} 
	
    public function get_templates(){
        $response['status'] = false;
        $response['_html'] = '';
        $html = '';
        if ($this->input->is_ajax_request()) {
            $cat_id = $this->input->post('cat_id', true);
            $show_more = $this->input->post('show_more', true);

            if($cat_id == "all"){
                $templates = $this->TemplateModel->getAllTemplates(false, 10, $show_more);
            }else{
                $templates = $this->TemplateModel->getAllTemplates($cat_id, 10, $show_more);
            }
            if(isset($templates) && !empty($templates)){      
                foreach($templates as $template){
                    $doc_ext = '';
                    if(isset($template->DocAsociado) && !empty($template->DocAsociado)){
                        $doc_ext = pathinfo($template->DocAsociado, PATHINFO_EXTENSION);
                    }
                    $doc_img = '<i class="fa fa-file-word-o fa-3x" aria-hidden="true"></i>';
                    if($doc_ext == 'xls' || $doc_ext == 'xlsx'){
                        $doc_img = '<i class="fa fa-file-excel-o fa-3x" aria-hidden="true"></i>';
                    }

                    $response['_html'] .=  '<tr class="row template_item_row" data-template_id="'.$template->id .'" data-template_id="'.$template->id .'">
                                    
                                    <td>
                                        '.$doc_img.'
                                    </td>
                                    <td>
                                        <p class="template_title" style="word-break: normal;"><a href="/templates/edit/'.$template->id.'" >'.$template->Nombre.'</a></p>
                                        <p style="word-break: normal;">'.$template->Descripcion.'</p>
                                        <p style="word-break: normal;">'.$this->lang->line('category').': <strong>'.$template->cat_name.'</strong></p>
                                    </td>
                                    <td>                                        
                                        <a href="/templates/delete/'.$template->id.'" class="delete_template" data-confirm="'.$this->lang->line('are_you_sure').'"><i class="fa fa-trash"></i> '.$this->lang->line('delete').'</a>
                                    </td>
									<td>                                        
                                        <a target="_blank" href="'.base_url().'templates/inserpdfvalue/" class="" ><i class="fa fa-pdf"></i>PDF</a>
                                    </td>
									                                   
                                </tr>';
                    $response['_html'] .= '<hr />';
                }
                $response['status'] = true;
//                $html .= '<a type="button" href="#" class="btn btn-primary pull-right" id="show_more">'.$this->lang->line('display_more').'</a>';
            }else{                
                $response['_html'] .= '<p class="text-danger text-center" id="no_any_data">'.$this->lang->line('no_any_data').'</p>';
            }
        }

        print_r(json_encode($response));
        exit;
    }

    public function getDocumentoByCatId() {
        $formData = $this->input->post();
        $this->data["documents"] = $this->TemplateModel->getAllTemplates($formData["category_id"]);
        $html = $this->load->view("templates/getDocumentoByCatId", $this->data, true);
        echo $html;
    }

    public function getMacrosByCatId() {
		//$formData = $_REQUEST;
        $formData = $this->input->post();
        $this->data["macros"] = $this->TemplateModel->getMacrosByCatId($formData["category_id"]);
        $html = $this->load->view("templates/getMacrosByCatId", $this->data, true);
        echo $html;
    }
	
	public function getOptionsByCatId()
    {
        $formData = $this->input->post();
        $categoryOptions = $this->TemplateModel->getOptionsByCatId($formData["category_id"]);
		$tempCategory = array();
		if(!empty($categoryOptions))
        {	
			foreach($categoryOptions[0] as $key=>$value)
            {
				$tempCategory[] = $key;
			}
		}
		echo trim(implode('**', $tempCategory));
		exit;
    }

    public function printTemplate() {
        $errors = array();
        $errors[] = $this->lang->line('db_err_msg');
        $formData = $this->input->post();
        if (isset($formData["templateId"]) && $formData["templateId"] > 0) {
            $result = $this->LstPlantillaModel->getById($formData["templateId"]);
            if(isset($result[0]) && !empty($result[0])){
                $result = $result[0];
                $filename = isset($result->DocAsociado) ? str_replace(" ", "-", $result->DocAsociado) : rand(). '.docx';
                $fullpath = 'crm/downloads/' . $filename;
                if($result->aws_link){
                    $file = file_get_contents($result->aws_link);
                }else{
                    $file = $result->documento;
                }
                file_put_contents($fullpath, $file);
                chmod($fullpath, 0777);
                $this->load->model("LstConsultaModel");
                $lst_consultas = $this->LstConsultaModel->getCsql($formData["id_cat"]);
                if(isset($lst_consultas['csql']) && !empty($lst_consultas['csql'])){
                    $csql = $lst_consultas['csql'];
                    if($formData['cat_type'] == "clientes"){
                        $where_cond = "WHERE cli.ccodcli = '".$formData['lead_client_id']."'";
                    }elseif($formData['cat_type'] == "leads") {
                        $where_cond = "WHERE pt.numpresupuesto = '".$formData['lead_client_id']."'";
                    }
                    if(isset($where_cond)){
                        $sql = str_replace("$$$", $where_cond, $csql);
                        $companyDataFields = $this->magaModel->selectCustom($sql);
                        if(isset($companyDataFields[0]) && !empty($companyDataFields[0])){
                            $companyDataFields = (array) $companyDataFields[0];
                            $PHPWord = new \PhpOffice\PhpWord\PhpWord();
                            try{
                                $document = $PHPWord->loadTemplate($fullpath);
                                foreach ($companyDataFields as $fk=>$fv) {
                                    $document->setValue('{'.$fk.'}', $fv);
                                }
                                $document->saveAs($fullpath);
                                chmod($fullpath, 0777);
                                //aws s3
                                $amazon = $this->config->item('amazon');
                                $client = new S3Client(array(
                                    'version' => 'latest',
                                    'credentials' => array(
                                        'key'       => $amazon['AWSAccessKeyId'],
                                        'secret'    => $amazon['AWSSecretKey'],
                                    ),
                                    'region' => $amazon['region'],
                                    'client_defaults' => ['verify' => false]
                                ));
                                $unique_name = md5(uniqid(rand(), true)) . '-' . $filename;
                                $key = $this->_db_details->idcliente .'/LMS/temp/templates/'.$formData["templateId"].'/'. $unique_name;
                                try{
                                    $res = $client->putObject(array(
                                        'Bucket' =>  $amazon['bucket'],
                                        'Key' => $key,
                                        'SourceFile' => $fullpath,
                                        'ACL' => 'public-read',
                                        'ContentType' => 'text/plain'
                                    ));
                                    if(isset($res['ObjectURL'])){
                                        unlink($fullpath);
                                        redirect($res['ObjectURL']);
                                    }else{
                                    }
                                }catch(\Aws\S3\Exception\S3Exception $e){
                                    $errors[] = $e->getMessage();
                                }
                                //aws s3 end
                            }catch(\PhpOffice\PhpWord\Exception\Exception $er){
                                $errors[] = $er->getMessage();
                            }
                        }else{
                            //err message
                        }
                    }else{
                        //err message
                    }


                }else{
                    //err message
                }

            }else{
                //err message
            }
        }else{
           //err message
        }
        if(!empty($errors) && isset($fullpath)){
            unlink($fullpath);
        }
        $this->session->set_flashdata('errors', $errors );
        redirect($this->agent->referrer());
    }
    public function save(){
        $this->load->library('form_validation');
        if($this->input->is_ajax_request()){
            $result=false;
            $errors = array();
            if($this->input->post()) {
                $this->config->set_item('language', $this->data['lang']);
                $this->form_validation->set_rules("nombre","nombre","trim|required");
                if ($this->form_validation->run()) {
                    $html = $this->input->post('html');
                    $formData['nombre'] = $this->input->post('nombre', true);
                    $formData['description'] = $this->input->post('description', true);
                    $formData['id_cat'] = $this->input->post('id_cat', true);
                    $formData["templateId"] = $this->input->post('id', true);;
                    if($formData["templateId"]){
                        $result = $this->TemplateModel->editTemplate($formData, $html);
                    }else {
                        $result = $this->TemplateModel->addTemplateToBase($formData, $html);
                    }
                }else{
                    $errors = $this->form_validation->error_array();
                }
                if ($result > 0) {
                    $this->session->set_flashdata('addMsg', 'Template has been successfully added!');
                }
            }
            echo json_encode(array('success'=>$result, 'errors'=>$errors));
        }
    }
    public function save_source(){
    $config = array();
    if ($this->input->post('data', true)) {
        $post_data = $this->input->post('data', true);
        $html_data = $this->input->post('html', true);
        foreach ($post_data as $param=>$value) {
            $config[$param] = $value;
        }
    }


    $html         = ( get_magic_quotes_gpc() ) ? stripslashes($html_data) : $html_data;
    $filename     = 'editor/tmp/body_'.time().'.html';

    /*
     * IN $config TROVI I VALORI DELLE VARIABILI PER INDICE
     */

    if (  file_put_contents($filename, $html) ) {
        // echo "File ".$filename.' was created';
        //echo str_replace(dirname(__FILE__), 'http://'.$_SERVER['HTTP_HOST'].$path ,$filename);
    }
        
    }

    public function getTemplatesById (){
        if($this->input->is_ajax_request()){
            $document = false;
            $client_id = $this->input->post('client_id');
            $template_id = $this->input->post('template_id');
            $cat_id = $this->input->post('cat_id');
            $cat_type = $this->input->post('cat_type');
            $template = $this->TemplateModel->getTemplateByIdAndCatId($template_id, $cat_id);

            $this->load->model("LstConsultaModel");
            $lst_consultas = $this->LstConsultaModel->getCsql($cat_id);
            if(isset($lst_consultas['csql']) && !empty($lst_consultas['csql'])){
                $csql = $lst_consultas['csql'];
                if($cat_type == "enrollments"){
                    $where_cond = "WHERE mt.nummatricula = '".$client_id."'";
                }elseif($cat_type == "leads") {
                    $where_cond = "WHERE pt.numpresupuesto = '".$client_id."'";
                }
                if(isset($where_cond)){
                    $sql = str_replace("$$$", $where_cond, $csql);
                    $companyDataFields = $this->magaModel->selectCustom($sql);
                    if(isset($companyDataFields[0]) && !empty($companyDataFields[0])){
                        $companyDataFields = (array) $companyDataFields[0];
                            $document = $template->content;
                            foreach ($companyDataFields as $fk=>$fv) {
                                if(!$fv || $fv == 'NULL'){
                                    $fv = '';
                                }
                                $document = str_replace('{{'.$fk.'}}', $fv, $document);
                            }
                    }else{

                        //err message
                    }
                }else{
                    //err message
                }


            }
            if($document){
                $document = str_replace('width="640"', 'width="100%"', $document);
                $template->content = $document;
            }
            
            echo json_encode(array('template'=>$template));

        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

}

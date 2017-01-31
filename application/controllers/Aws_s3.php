<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/24/15
 * Time: 10:25 PM
 * Time: 10:25 PM
 */
use Aws\S3\S3Client;
/**
 *@property ProfesoresDocModel $ProfesoresDocModel
 */

class Aws_s3 extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));

        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000000000';

        $this->load->library('Awslib');
        $this->load->library('upload', $config);
        $this->load->model('DocumentModel');
        $this->load->model('Variables2Model');
        $this->load->model('ResourceModel');
        $this->load->model('ProfesoresDocModel');
        $this->load->model('ErpFileSizesModel');
    }

    public function index(){
        $response = array();
        if ($this->input->post()) {
            //$this->load->spark('amazon-sdk/0.1.7');
            $s3 = $this->awslib->get_s3();
            @$s3->disable_ssl_verification();
//      var_dump($s3->create_bucket("te",AmazonS3::REGION_US_STANDARD,AmazonS3::ACL_PUBLIC)->isOK());
//     	$result = $s3->list_buckets();
            $response = $s3->create_object('softaula-file', $_FILES['document']['name'][0], array('fileUpload' => $_FILES['document']['tmp_name'][0],'acl'=>AmazonS3::ACL_PUBLIC));
//        $s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ)
        }
        echo '<pre>' . print_r($response, TRUE) . '</pre>';
        exit;
    }

    public function fileDelete()
    {
        $response_data=array();
        if ($this->input->post()) {
            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules("bucket_name","Bucket Name","required");
            $this->form_validation->set_rules("file_name","File Name","required");
			$this->form_validation->set_rules("documentId","File Id","required");
            if($this->form_validation->run()==False)
            {
                $response_data["error"]=validation_errors();
                $response_data['status']=false;
            }
            else
            {
                $amazon = $this->config->item('amazon');

                $bucket_name = $this->input->post("bucket_name");
                $file_name = $this->input->post("file_name");
                $doclink = $this->input->post("doclink");

                if($bucket_name == "s3"){
                    $path = explode(AMAZON_AWS_URL, $doclink);
                    if(isset($path[1])){
                        $file_name_path = explode('/'.$amazon['bucket'].'/', $path[1]);
                        if(isset($file_name_path[1])){
                            $main_bucket_name = $amazon['bucket'];
                            $main_file_name = $file_name_path[1];
                        }
                    }

                }

                $client = new S3Client(array(
                    'version' => 'latest',
                    'credentials' => array(
                        'key'       => $amazon['AWSAccessKeyId'],
                        'secret'    => $amazon['AWSSecretKey'],
                    ),
                    'region' => $amazon['region'],
                    'client_defaults' => ['verify' => false]
                ));

                try {
                    $result = $client->deleteObject(array(
                        // Bucket is required
                        'Bucket' => isset($main_bucket_name) ? $main_bucket_name: $bucket_name,
                        // Key is required
                        'Key' => isset($main_file_name) ? $main_file_name: $file_name
                    ));
                    $this->ErpFileSizesModel->deleteItem($doclink);
                    $response_data['status1'] = $result->get('DeleteMarker');
                }
                catch(Aws\S3\Exception\S3Exception $e)
                {
                    $response_data['status1'] = $e;
                }
            	//Check document exist in databbase or not
            	//if not return Invalid id
                if($this->input->post("_m")=="profesor"){
                	$this->DocumentModel->delete_profesor_documentos($this->input->post("documentId"));
                }elseif($this->input->post("_m")=="student"){
                	$this->DocumentModel->delete_student_documentos($this->input->post("documentId"));
                }elseif($this->input->post("_m")=="group"){
                	$this->DocumentModel->delete_group_documentos($this->input->post("documentId"));
                }elseif($this->input->post("_m")=="course"){
                	$this->DocumentModel->delete_course_documentos($this->input->post("documentId"));
                }elseif($this->input->post("_m")=="leads"){
                	$this->DocumentModel->deleteDocumentByIdModel($this->input->post("documentId", true), $this->input->post("_m", true));
                }elseif($this->input->post("_m")=="enrollment"){
                	$this->DocumentModel->deleteDocumentByIdModel($this->input->post("documentId", true), $this->input->post("_m", true));
                }else{
                	$this->DocumentModel->delete_documentos($this->input->post("documentId"));
                }
                $response_data['status']=true;
            }
        }
        echo json_encode($response_data);
        exit;
    }

    public function multiple_file_delete(){
        $response_data['status'] = false;
        $response_data["error"] = '';
        if ($this->input->post()) {
            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules("aws_bucket","Bucket Name","required");
            $this->form_validation->set_rules("aws_key","File path","required");
			$this->form_validation->set_rules("document_id","File Id","required");
            if ($this->form_validation->run() == false) {
                $response_data["error"] = validation_errors();
            } else {
                $amazon = $this->config->item('amazon');

                $aws_bucket = $this->input->post("aws_bucket", true);
                $aws_key = $this->input->post("aws_key", true);
                $document_id = $this->input->post("document_id", true);
                $model = $this->input->post("model", true);
                $id = $this->input->post("id", true);

                $client = new S3Client(
                    array(
                        'version' => 'latest',
                        'credentials' => array(
                            'key' => $amazon['AWSAccessKeyId'],
                            'secret' => $amazon['AWSSecretKey'],
                        ),
                        'region' => $amazon['region'],
                        'client_defaults' => ['verify' => false],
                    )
                );

                try {
                    $result = $client->deleteObject(
                        array(
                            // Bucket is required
                            'Bucket' => $aws_bucket,
                            // Key is required
                            'Key' => $aws_key,
                        )
                    );
                    $response_data['status1'] = $result->get('DeleteMarker');
                } catch (Aws\S3\Exception\S3Exception $e) {
                    $response_data['error'] = $e;
                }
                $doclink = $this->DocumentModel->getDocLinkByIdModel($document_id, $model);

                $response_data['status'] = $this->DocumentModel->deleteDocumentByIdModel($document_id, $model);

                if(isset($doclink->doclink) && $doclink->doclink) {
                    $this->ErpFileSizesModel->deleteItem($doclink->doclink);
                }
            }
        }
        echo json_encode($response_data);
        exit;
    }


    public function bucketDelete($bucket_name)
    {
        $s3 = $this->awslib->get_s3();
        @$s3->disable_ssl_verification();
        $s3->delete_bucket($bucket_name,true);
        return true;
    }

    public function sindex_post()
    {
        if ($this->input->post()) {
            //        $this->form_validation->set_rules('nombre',"Nombre","alpha|required");
            $this->form_validation->set_rules('clientid',"Client Id","integer|required");
//        $this->form_validation->set_rules('fecha',"Fecha","alpha|required");
            $clientid = $this->input->post('clientid');
            $s3 = $this->awslib->get_s3();
            @$s3->disable_ssl_verification();

            $response_data=array();
            if($this->form_validation->run()==False)
            {
                $response_data["error"]=validation_errors();
                $response_data['status']=false;
            }
            else
            {
                if ( ! $this->upload->do_upload("file_to_be_sent"))
                {

                    $response_data["error"]=$this->upload->display_errors();
                    $response_data['status']=false;
                }
                else
                {
                    $bucket="customer-".$this->input->post('clientid');

                    $data = $this->upload->data();
                    $ext = pathinfo($data['file_name'], PATHINFO_EXTENSION);
                    if(!$s3->if_bucket_exists($bucket))
                    {
                        $s3->create_bucket($bucket,AmazonS3::REGION_US_STANDARD,AmazonS3::ACL_PUBLIC);
                    }
                    $response = $s3->create_object($bucket, uniqid().'.'.$ext, array(
                        'fileUpload' => "uploads/".$data['file_name'],
                        'acl'=>AmazonS3::ACL_PUBLIC));

                    if($response->isOK())
                    {

                        $url=$response->header['_info']['url'];

                        $status=$this->DocumentModel->insert_document(intval($this->input->post('clientid')),$this->input->post('fecha'),$this->input->post('nombre'),$url);
                        $response_data['data_url']=$url;
                        $response_data['status']=$status;
                    }
                    else
                    {
                        $response_data['status']=false;
                        $response_data['error']="file has been uploaded to server but unable to transit S3 ";
                    }

                }
            }

            redirect('clientes/edit/'.$clientid.'#documentos');
            // echo json_encode($response_data);
        }
    }

    public function documents($clientId)
    {
        $documents=$this->DocumentModel->get_documents($clientId);
        $data['status']=true;
        $data['data']=$documents;
        echo json_encode($data);
    }
    
    public function files($docid=null){
	    $documents=$this->DocumentModel->download_file($docid);
	    $file = rand(10,1000).$documents[0]['documento'];
	    //Direct download not working for the doc file which was uploaded in test phase
	    //So file_put_contents used to save the file first and read again
	    //If have other way then ca
	    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tmpfile/'.$file, $documents[0]['docblob']);
	    $fn_ext = pathinfo($_SERVER['DOCUMENT_ROOT'].'/tmpfile/'.$file);
	    header("Date: ".gmdate("D, j M Y H:i:s e", time()));
	    header("Cache-Control: max-age=2592000");
	    header("Accept-Ranges: bytes");
	    header("Pragma: public"); // required
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: private",false); // required for certain browsers
	    header("Content-Description: File Transfer");
	    header("Content-Disposition: attachment; filename=\"".$documents[0]['documento']."\"");
	    header("Content-Transfer-Encoding: binary");
	    //Need to consider other extension too
    	if($fn_ext == "doc"||$fn_ext == "docx"){
	    	header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	    }else{
	    	header('Content-Type: application/octet-stream');
	    }
	    ob_clean();
		flush();	
	    echo @readfile($_SERVER['DOCUMENT_ROOT'].'/tmpfile/'.$file);
	    unlink($_SERVER['DOCUMENT_ROOT'].'/tmpfile/'.$file);
	    exit();
		//echo $documents[0]['docblob'];
    }
    public function uploadCampusDocument($model="",$id=null){

        $r = array();
        $r['aws_bucket'] = '';
        $r['aws_key'] = '';
        $r['document_id'] = '';

        if(!$model || !$id){
            $r['success']=0;
            $r['message']=$this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;

            if(in_array($model,array('clients','leads','profesor','student'))){
                    if (isset($_FILES)) {
                        $document_name = $_FILES['document']['name'];
                        $document_type = $_FILES['document']['type'];
                        $document_size = $_FILES['document']['size'];
                        $document_tmp_name = $_FILES['document']['tmp_name'];
                        $file_space = $this->ErpFileSizesModel->getTotalSize();
                        $limit_file_space = $this->_db_details->space_limit;
                        if($limit_file_space > ($file_space->total+$document_size)) {
                            $file_title = $this->input->post('nombre', true);
                            if (empty($file_title)) {
                                $path_parts = pathinfo($document_name);

                                if (isset($path_parts['filename']) && !empty($path_parts['filename'])) {
                                    $file_title = ucwords(strtolower(str_replace('-', " ", trim($path_parts['filename']))));
                                } else {
                                    $file_title = $document_name;
                                }
                            }

                            if ($this->_db_details) {
                                $amazon = $this->config->item('amazon');
                                $client = new S3Client(array(
                                    'version' => 'latest',
                                    'credentials' => array(
                                        'key' => $amazon['AWSAccessKeyId'],
                                        'secret' => $amazon['AWSSecretKey'],
                                    ),
                                    'region' => $amazon['region'],
                                    'client_defaults' => ['verify' => false]
                                ));


                                $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                                $key = $this->_db_details->idcliente . '/campus/files/' . $model . '/' . $id . '/' . $unique_name;

                                $res = $client->putObject(array(
                                    'Bucket' => $amazon['bucket'],
                                    'Key' => $key,
                                    'SourceFile' => $document_tmp_name,
                                    'ACL' => 'public-read',
                                    'ContentType' => 'text/plain'
                                ));

                                if (isset($res['ObjectURL'])) {
                                    $r['aws_bucket'] = $amazon['bucket'];
                                    $r['aws_key'] = $key;

                                    $url = $res['ObjectURL'];
                                    if ($model == 'clients') {
                                        $document_id = $this->DocumentModel->insert_document($id, date('Y-m-d'), $file_title, $url, 0);
                                    } else if ($model == 'leads') {
                                        $document_id = $this->DocumentModel->insert_document_lead($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                                    } else if ($model == 'profesor') {
                                        $document_id = $this->DocumentModel->insert_document_profesor($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                                    } else if ($model == 'student') {
                                        $document_id = $this->DocumentModel->insert_document_student($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                                    }


                                    if (isset($document_id)) {
                                        $r['document_id'] = $document_id;
                                        $r['d']['id'] = $document_id;
                                        $r['success'] = 1;
                                        $r['message'] = $this->lang->line('file_upload_success');
                                        $r['d']['fecha'] = date('Y-m-d');
                                        $r['d']['visible'] = 'No';
                                        $r['d']['doclink'] = $url;
                                        $r['d']['nombre'] = $file_title;
                                        $r['d']['docblob'] = 0;
                                        $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));

                                    } else {
                                        $r['success'] = 0;
                                        $r['message'] = $this->lang->line('file_not_save');
                                    }
                                } else {
                                    $r['success'] = 0;
                                    $r['message'] = $this->lang->line('db_err_msg');
                                }
                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('db_err_msg');
                            }
                        }else{
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('your_file_space_limit_finished');
                        }
                    } else {
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('no_file_uploaded');
                    }

            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('invalid_request');
            }

        echo json_encode($r);
        exit;
    }

    public function updateCampusProfilePhoto($model="", $user_id = null, $user_role = null){
        $this->load->model('ProfesorModel');
        $this->load->model('AlumnoModel');
        $r = array();
        $r['aws_bucket'] = '';
        $r['aws_key'] = '';
        $r['document_id'] = '';
        $user_role = $user_role ? $user_role : $this->session->userdata('user_role');
        if($model == 'profesor' && $user_role == '1'){
            //$userData= (array)$this->session->userdata('campus_user');
            $id = $user_id && $user_id != '0' ? $user_id : null;
            $last_photo_link = $this->ProfesorModel->getTeacherPhotoLink($id);
        }else if($model == 'student' && $user_role == '2'){
            //$userData = (array)$this->session->userdata('campus_user');
            $id = $user_id && $user_id != '0' ? $user_id : null;
            $last_photo_link = $this->AlumnoModel->getStudentPhotoLink($id);
        }else{
            $id = null;
            $last_photo_link = null;
        }

        if(!$model || !$id){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;




        if(isset($last_photo_link->photo_link) && !empty($last_photo_link->photo_link)) {
            $photo_link_array = explode('/', $last_photo_link->photo_link);
            $last_photo_name = end($photo_link_array);
            $last_aws_key = $this->_db_details->idcliente . '/campus/files/' . $model . '/' . $id . '/' . $last_photo_name;
            $this->deleteUserPhoto($last_aws_key);
            $this->ErpFileSizesModel->deleteItem($last_photo_link->photo_link);
        }


            if(in_array($model,array('profesor','student'))){
                if(isset($_FILES)){
                        $document_name = $_FILES['document']['name'];
                        $document_type = $_FILES['document']['type'];
                        $document_size = $_FILES['document']['size'];
                        $document_tmp_name = $_FILES['document']['tmp_name'];
                    $file_space = $this->ErpFileSizesModel->getTotalSize();
                    $limit_file_space = $this->_db_details->space_limit;
                    if($limit_file_space > ($file_space->total+$document_size)) {
                        $file_title = $this->input->post('nombre', true);
                        if (empty($file_title)) {
                            $path_parts = pathinfo($document_name);

                            if (isset($path_parts['filename']) && !empty($path_parts['filename'])) {
                                $file_title = ucwords(strtolower(str_replace('-', " ", trim($path_parts['filename']))));
                            } else {
                                $file_title = $document_name;
                            }
                        }

                        if ($this->_db_details) {
                            $amazon = $this->config->item('amazon');
                            $client = new S3Client(array(
                                'version' => 'latest',
                                'credentials' => array(
                                    'key' => $amazon['AWSAccessKeyId'],
                                    'secret' => $amazon['AWSSecretKey'],
                                ),
                                'region' => $amazon['region'],
                                'client_defaults' => ['verify' => false]
                            ));


                            $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                            $key = $this->_db_details->idcliente . '/campus/files/' . $model . '/' . $id . '/' . $unique_name;

                            $res = $client->putObject(array(
                                'Bucket' => $amazon['bucket'],
                                'Key' => $key,
                                'SourceFile' => $document_tmp_name,
                                'ACL' => 'public-read',
                                'ContentType' => 'text/plain'
                            ));

                            if (isset($res['ObjectURL'])) {
                                $r['aws_bucket'] = $amazon['bucket'];
                                $r['aws_key'] = $key;

                                $url = $res['ObjectURL'];
                                $result = false;
                                if ($model == 'profesor') {
                                    $result = $this->ProfesorModel->updateProfilePhoto($id, date('Y-m-d'), $url);
                                } else if ($model == 'student') {
                                    $result = $this->AlumnoModel->updateProfilePhoto($id, date('Y-m-d'), $url);
                                }


                                if ($result) {
                                    $r['success'] = 1;
                                    $r['message'] = $this->lang->line('file_upload_success');
                                    $r['d']['fecha'] = date('Y-m-d');
                                    $r['d']['visible'] = 'No';
                                    $r['d']['file_link'] = $url;
                                    $r['d']['nombre'] = $file_title;
                                    $r['d']['docblob'] = 0;
                                    $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));

                                } else {
                                    $r['success'] = 0;
                                    $r['message'] = $this->lang->line('file_not_save');
                                }
                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('db_err_msg');
                            }
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    }else{
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('your_file_space_limit_finished');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('no_file_uploaded');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('invalid_request');
            }
        echo json_encode($r);
        exit;
    }

    public function updateUserProfilePhoto($model=""){
        $this->load->model('UsuarioModel');

        $r = array();
        $r['aws_bucket'] = '';
        $r['aws_key'] = '';
        $r['document_id'] = '';
        $userData = $this->session->userdata('userData');
        //$user_role = $this->session->userdata('user_role');
        if($model == 'user' && isset($userData[0]->USUARIO)){
            $id = $userData[0]->Id;
            $last_photo_link = $this->UsuarioModel->getUserPhotoLink($id);
        }else{
            $id = null;
            $last_photo_link = null;
        }

        if(!$model || !$id){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;




        if(isset($last_photo_link->photo_link) && !empty($last_photo_link->photo_link)) {
            $photo_link_array = explode('/', $last_photo_link->photo_link);
            $last_photo_name = end($photo_link_array);
            $last_aws_key = $this->_db_details->idcliente . '/LMS/files/profile/' . $id . '/' . $last_photo_name;
            $this->deleteUserPhoto($last_aws_key);
            $this->ErpFileSizesModel->deleteItem($last_photo_link->photo_link);
        }


            if(in_array($model,array('user'))){
                if(isset($_FILES)){
                        $document_name = $_FILES['document']['name'];
                        $document_type = $_FILES['document']['type'];
                        $document_size = $_FILES['document']['size'];
                        $document_tmp_name = $_FILES['document']['tmp_name'];
                    $file_space = $this->ErpFileSizesModel->getTotalSize();
                    $limit_file_space = $this->_db_details->space_limit;
                    if($limit_file_space > ($file_space->total+$document_size)) {
                        $file_title = $this->input->post('nombre', true);
                        if (empty($file_title)) {
                            $path_parts = pathinfo($document_name);

                            if (isset($path_parts['filename']) && !empty($path_parts['filename'])) {
                                $file_title = ucwords(strtolower(str_replace('-', " ", trim($path_parts['filename']))));
                            } else {
                                $file_title = $document_name;
                            }
                        }

                        if ($this->_db_details) {
                            $amazon = $this->config->item('amazon');
                            $client = new S3Client(array(
                                'version' => 'latest',
                                'credentials' => array(
                                    'key' => $amazon['AWSAccessKeyId'],
                                    'secret' => $amazon['AWSSecretKey'],
                                ),
                                'region' => $amazon['region'],
                                'client_defaults' => ['verify' => false]
                            ));


                            $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                            $key = $this->_db_details->idcliente . '/LMS/files/profile/' . $id . '/' . $unique_name;

                            $res = $client->putObject(array(
                                'Bucket' => $amazon['bucket'],
                                'Key' => $key,
                                'SourceFile' => $document_tmp_name,
                                'ACL' => 'public-read',
                                'ContentType' => 'text/plain'
                            ));

                            if (isset($res['ObjectURL'])) {
                                $r['aws_bucket'] = $amazon['bucket'];
                                $r['aws_key'] = $key;

                                $url = $res['ObjectURL'];
                                $result = false;
                                if ($model == 'user') {
                                    $result = $this->UsuarioModel->updateProfilePhoto($id, date('Y-m-d'), $url, true);
                                    if($result){
                                        $this->session->userdata('userData')[0]->foto = '';
                                    }
                                } 


                                if ($result) {
                                    $r['success'] = 1;
                                    $r['message'] = $this->lang->line('file_upload_success');
                                    $r['d']['fecha'] = date('Y-m-d');
                                    $r['d']['visible'] = 'No';
                                    $r['d']['file_link'] = $url;
                                    $r['d']['nombre'] = $file_title;
                                    $r['d']['docblob'] = 0;
                                    $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));

                                } else {
                                    $r['success'] = 0;
                                    $r['message'] = $this->lang->line('file_not_save');
                                }
                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('db_err_msg');
                            }
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    }else{
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('your_file_space_limit_finished');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('no_file_uploaded');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('invalid_request');
            }
        echo json_encode($r);
        exit;
    }

    public function deleteCampusUserPhoto($model = null, $user_id = null, $user_role = null ){
        $this->load->model('ProfesorModel');
        $this->load->model('AlumnoModel');

        $r = array();
        $user_role = $user_role ? $user_role : $this->session->userdata('user_role');
        if($model == 'profesor' && $user_role == '1'){
            //$userData= (array)$this->session->userdata('campus_user');
            $id = $user_id && $user_id != '0' ? $user_id : null;
            $last_photo_link = $this->ProfesorModel->getTeacherPhotoLink($id);
        }else if($model == 'student' && $user_role == '2'){
            //$userData = (array)$this->session->userdata('campus_user');
            $id = $user_id && $user_id != '0' ? $user_id : null;
            $last_photo_link = $this->AlumnoModel->getStudentPhotoLink($id);
        }else{
            $id = null;
            $last_photo_link = null;
        }

        if(!$model || !$id){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;


        $r['success'] = false;
        if(!empty($last_photo_link->photo_link)) {
            $photo_link_array = explode('/', $last_photo_link->photo_link);
            $last_photo_name = end($photo_link_array);
            $last_aws_key = $this->_db_details->idcliente . '/campus/files/' . $model . '/' . $id . '/' . $last_photo_name;
            $this->deleteUserPhoto($last_aws_key);
            $this->ErpFileSizesModel->deleteItem($last_photo_link->photo_link);
            if($model == 'profesor'){
                $photo_link = '';
                $r['success'] = $this->ProfesorModel->updateProfilePhoto($id, date('Y-m-d'), $photo_link, true);
                //$this->session->userdata('campus_user')->foto = null;
            }else if($model == 'student'){

                $photo_link = '';
                $r['success'] = $this->AlumnoModel->updateProfilePhoto($id, date('Y-m-d'), $photo_link, true);
                //$this->session->userdata('campus_user')->foto = null;
            }
        }

        echo json_encode($r);
        exit;
    }

    public function deleteUserProfilePhoto($model = null){
        $this->load->model('UsuarioModel');

        $r = array();
        $userData = $this->session->userdata('userData');
        //$user_role = $this->session->userdata('user_role');
        if($model == 'user' && isset($userData[0]->USUARIO)){
            $id = $userData[0]->Id;
            $last_photo_link = $this->UsuarioModel->getUserPhotoLink($id);
        }else{
            $id = null;
            $last_photo_link = null;
        }

        if(!$model || !$id){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;


        $r['success'] = false;
        if(!empty($last_photo_link->photo_link)) {
            $photo_link_array = explode('/', $last_photo_link->photo_link);
            $last_photo_name = end($photo_link_array);
            $last_aws_key = $this->_db_details->idcliente . '/LMS/files/profile/' . $id . '/' . $last_photo_name;
            $this->deleteUserPhoto($last_aws_key);
            $this->ErpFileSizesModel->deleteItem($last_photo_link->photo_link);
            if($model == 'user'){
                $photo_link = '';
                $r['success'] = $this->UsuarioModel->updateProfilePhoto($id, date('Y-m-d'), $photo_link, true);
                $this->session->userdata('userData')[0]->foto = null;
            }
        }

        echo json_encode($r);
        exit;
    }

    public function uploadDocuments($model="",$id=null){

        $r = array();
        $r['aws_bucket'] = '';
        $r['aws_key'] = '';
        $r['document_id'] = '';

        if(!$model || !$id){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;

        if(in_array($model,array('profesor','student', 'group', 'course', 'clients', 'leads', 'enrollment'))){
            if(isset($_FILES)){
                $document_name = $_FILES['document']['name'];
                $document_type = $_FILES['document']['type'];
                $document_size = $_FILES['document']['size'];
                $document_tmp_name = $_FILES['document']['tmp_name'];

                $file_title = $this->input->post('title', true);
                if(empty($file_title)){
                    $path_parts = pathinfo($document_name);

                    if(isset($path_parts['filename']) && !empty($path_parts['filename'])){
                        $file_title = ucwords(strtolower(str_replace('-', " ", trim($path_parts['filename']))));
                    }else{
                        $file_title = $document_name;
                    }
                }
                $file_space = $this->ErpFileSizesModel->getTotalSize();
                $limit_file_space = $this->_db_details->space_limit;
                if($limit_file_space > ($file_space->total+$document_size)) {
                    if ($this->_db_details) {
                        $amazon = $this->config->item('amazon');
                        $client = new S3Client(array(
                            'version' => 'latest',
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                            'region' => $amazon['region'],
                            'client_defaults' => ['verify' => false]
                        ));


                        $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                        $key = $this->_db_details->idcliente . '/LMS/files/' . $model . '/' . $id . '/' . $unique_name;
                        $res = $client->putObject(array(
                            'Bucket' => $amazon['bucket'],
                            'Key' => $key,
                            'SourceFile' => $document_tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => 'text/plain'
                        ));

                        if (isset($res['ObjectURL'])) {
                            $r['aws_bucket'] = $amazon['bucket'];
                            $r['aws_key'] = $key;

                            $url = $res['ObjectURL'];
                            if ($model == 'profesor') {
                                $document_id = $this->DocumentModel->insert_document_profesor($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                            } else if ($model == 'student') {
                                $document_id = $this->DocumentModel->insert_document_student($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                            } else if ($model == 'group') {
                                $document_id = $this->DocumentModel->insert_document_group($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                            } else if ($model == 'course') {
                                $document_id = $this->DocumentModel->insert_document_course($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                            } else if ($model == 'clients') {
                                $document_id = $this->DocumentModel->insert_document($id, date('Y-m-d'), $file_title, $url, 0);
                            } else if ($model == 'leads') {
                                $document_id = $this->DocumentModel->insert_document_lead($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                            } else if ($model == 'enrollment') {
                                $document_id = $this->DocumentModel->insert_document_enrollment($id, date('Y-m-d'), $file_title, $document_type, $url, 0);
                            }


                            if (isset($document_id)) {
                                $r['document_id'] = $document_id;
                                $r['d']['id'] = $document_id;
                                $r['success'] = 1;
                                $r['message'] = $this->lang->line('file_upload_success');
                                $r['d']['fecha'] = date('Y-m-d');
                                $r['d']['visible'] = 'No';
                                $r['d']['doclink'] = $url;
                                $r['d']['nombre'] = $file_title;
                                $r['d']['docblob'] = 0;
                                $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));

                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('file_not_save');
                            }
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    } else {
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('your_file_space_limit_finished');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('no_file_uploaded');
            }
        }else{
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
        }
        echo json_encode($r);
        exit;
    }
    
    public function upload($model="",$id=null){
        $r = array();
        if(!$model || !$id){
            $r['success'] = 0;
            $r['message'] = 'Invalid Request.';
            echo json_encode($r);
            exit;
        }
        if ($this->input->post()) {
            if(in_array($model,array('clients','leads','profesor'))){
                if(isset($_FILES)){
                    $file_space = $this->ErpFileSizesModel->getTotalSize();
                    $limit_file_space = $this->_db_details->space_limit;
                    if($limit_file_space > ($file_space->total+$_FILES['document']['size'])) {
                        if ($this->_db_details) {
                            $amazon = $this->config->item('amazon');
                            $client = new S3Client(array(
                                'version' => 'latest',
                                'credentials' => array(
                                    'key' => $amazon['AWSAccessKeyId'],
                                    'secret' => $amazon['AWSSecretKey'],
                                ),
                                'region' => $amazon['region'],
                                'client_defaults' => ['verify' => false]
                            ));


                            $unique_name = md5(uniqid(rand(), true)) . '-' . $_FILES['document']['name'][0];
                            $key = $this->_db_details->idcliente . '/LMS/files/' . $model . '/' . $id . '/' . $unique_name;

                            $res = $client->putObject(array(
                                'Bucket' => $amazon['bucket'],
                                'Key' => $key,
                                'SourceFile' => $_FILES['document']['tmp_name'][0],
                                'ACL' => 'public-read',
                                'ContentType' => 'text/plain'
                            ));

                            if (isset($res['ObjectURL'])) {
                                $url = $res['ObjectURL'];
                                if ($model == 'clients') {
                                    $result = $this->DocumentModel->insert_document($id, date('Y-m-d'), $this->input->post('nombre'), $url, 0);
                                } else if ($model == 'leads') {
                                    $result = $this->DocumentModel->insert_document_lead($id, date('Y-m-d'), $this->input->post('nombre'), $_FILES['document']['type'][0], $url, 0);
                                } else if ($model == 'profesor') {
                                    $result = $this->DocumentModel->insert_document_profesor($id, date('Y-m-d'), $this->input->post('nombre'), $_FILES['document']['type'][0], $url, 0);
                                }

                                if (isset($result)) {
                                    $r['d']['id'] = $this->db->insert_id();
                                    $r['success'] = 1;
                                    $r['message'] = $this->lang->line('file_upload_success');
                                    $r['d']['fecha'] = date('Y-m-d');
                                    $r['d']['visible'] = 'No';
                                    $r['d']['doclink'] = $url;
                                    $r['d']['nombre'] = $this->input->post('nombre');
                                    $r['d']['docblob'] = 0;
                                    $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $_FILES['document']['size'], 'file_type' => $_FILES['document']['type']));

                                } else {
                                    $r['success'] = 0;
                                    $r['message'] = $this->lang->line('file_not_save');
                                }
                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('db_err_msg');
                            }
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    }else{
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('your_file_space_limit_finished');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('no_file_uploaded');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('invalid_request');
            }
        }
    	echo json_encode($r);
        exit;
    }


    public function uploadImg($field=""){

        $r = array();
        $r['aws_bucket'] = '';
        $r['aws_key'] = '';
        if(!$field){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['field'] = $field;
        $r['aws_url'] = '';


        if(in_array($field,array('logo','login2_picture'))){
            if(isset($_FILES)){
                $document_name = $_FILES['img']['name'];
                $document_type = $_FILES['img']['type'];
                $document_size = $_FILES['img']['size'];
                $document_tmp_name = $_FILES['img']['tmp_name'];
                $file_space = $this->ErpFileSizesModel->getTotalSize();
                $limit_file_space = $this->_db_details->space_limit;
                if($limit_file_space > ($file_space->total+$document_size)) {

                    if ($this->_db_details) {
                        $amazon = $this->config->item('amazon');
                        $client = new S3Client(array(
                            'version' => 'latest',
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                            'region' => $amazon['region'],
                            'client_defaults' => ['verify' => false]
                        ));


                        $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                        $key = $this->_db_details->idcliente . '/LMS/files/images/' . $field . '/' . $unique_name;

                        $res = $client->putObject(array(
                            'Bucket' => $amazon['bucket'],
                            'Key' => $key,
                            'SourceFile' => $document_tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => 'text/plain'
                        ));

                        if (isset($res['ObjectURL'])) {
                            $r['aws_bucket'] = $amazon['bucket'];
                            $r['aws_key'] = $key;

                            $url = $res['ObjectURL'];

                            $r['aws_url'] = $url;
                            $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));

                            $updated = $this->Variables2Model->updateImg($field, $url);

                            if ($updated) {
                                $r['success'] = 1;
                                $r['message'] = $this->lang->line('file_upload_success');
                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('file_not_save');
                            }
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    } else {
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('your_file_space_limit_finished');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('no_file_uploaded');
            }
        }else{
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
        }
        echo json_encode($r);
        exit;
    }

    public function deleteDocuments(){
        $response_data['status'] = false;
        $response_data["error"] = '';
        if ($this->input->post()) {
            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules("aws_bucket","Bucket Name","required");
            $this->form_validation->set_rules("aws_key","File path","required");
            $this->form_validation->set_rules("model","Model","required");
            $this->form_validation->set_rules("document_id","Document Id","required");
            if ($this->form_validation->run() == false) {
                $response_data["error"] = validation_errors();
            } else {
                $model = $this->input->post("model", true);
                $document_id = $this->input->post("document_id", true);

                if($model == "profesor"){
                    $docLink = $this->DocumentModel->getDocLinkByIdModel($document_id, 'profesor');
                    if($this->ProfesoresDocModel->deleteDocuments($document_id)){
                        $response_data['status'] = true;
                    };
                }else{
                    $response_data['status'] = false;
                }
                if( $response_data['status']) {
                    $amazon = $this->config->item('amazon');

                    $aws_bucket = $this->input->post("aws_bucket", true);
                    $aws_key = $this->input->post("aws_key", true);

                    $client = new S3Client(
                        array(
                            'version' => 'latest',
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                            'region' => $amazon['region'],
                            'client_defaults' => ['verify' => false],
                        )
                    );

                    try {
                        $result = $client->deleteObject(
                            array(
                                // Bucket is required
                                'Bucket' => $aws_bucket,
                                // Key is required
                                'Key' => $aws_key,
                            )
                        );
                        if(isset($docLink->doclink)) {
                            $this->ErpFileSizesModel->deleteItem($docLink->doclink);
                        }
                        $response_data['status1'] = $result->get('DeleteMarker');
                    } catch (Aws\S3\Exception\S3Exception $e) {
                        $response_data['error'] = $e;
                    }

                }
            }
        }
        echo json_encode($response_data);
        exit;
    }

    private function deleteUserPhoto($aws_key){
        $amazon = $this->config->item('amazon');

        $client = new S3Client(
            array(
                'version' => 'latest',
                'credentials' => array(
                    'key' => $amazon['AWSAccessKeyId'],
                    'secret' => $amazon['AWSSecretKey'],
                ),
                'region' => $amazon['region'],
                'client_defaults' => ['verify' => false],
            )
        );

        try {
            $result = $client->deleteObject(
                array(
                    // Bucket is required
                    'Bucket' => $amazon['bucket'],
                    // Key is required
                    'Key' => $aws_key,
                )
            );
            $response_data['status1'] = $result->get('DeleteMarker');
        } catch (Aws\S3\Exception\S3Exception $e) {
            $response_data['error'] = $e;
        }
    }

    public function img_delete(){
        $response_data['status'] = false;
        $response_data["error"] = '';
        if ($this->input->post()) {
            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules("aws_bucket","Bucket Name","required");
            $this->form_validation->set_rules("aws_key","File path","required");
            $this->form_validation->set_rules("img_field","Field","required");
            if ($this->form_validation->run() == false) {
                $response_data["error"] = validation_errors();
            } else {
                $amazon = $this->config->item('amazon');

                $aws_bucket = $this->input->post("aws_bucket", true);
                $aws_key = $this->input->post("aws_key", true);
                $img_field = $this->input->post("img_field", true);

                $client = new S3Client(
                    array(
                        'version' => 'latest',
                        'credentials' => array(
                            'key' => $amazon['AWSAccessKeyId'],
                            'secret' => $amazon['AWSSecretKey'],
                        ),
                        'region' => $amazon['region'],
                        'client_defaults' => ['verify' => false],
                    )
                );

                try {
                    $result = $client->deleteObject(
                        array(
                            // Bucket is required
                            'Bucket' => $aws_bucket,
                            // Key is required
                            'Key' => $aws_key,
                        )
                    );
                    $aws_link = 'https://s3.eu-central-1.amazonaws.com/'.$aws_bucket.'/'.$aws_key;
                    $this->ErpFileSizesModel->deleteItem($aws_link);
                    $response_data['status1'] = $result->get('DeleteMarker');
                } catch (Aws\S3\Exception\S3Exception $e) {
                    $response_data['error'] = $e;
                }
                if($img_field == "logo" || $img_field == "login2_picture"){
                    $response_data['status'] = $this->Variables2Model->emptyField($img_field);;
                }else{
                    $response_data['status'] = false;
                }
            }
        }
        echo json_encode($response_data);
        exit;
    }

    public function resource_upload() {
        
        if (isset($_FILES)) {
            $document_name = $_FILES['document']['name'];
            $document_type = $_FILES['document']['type'];
            $document_size = $_FILES['document']['size'];
            $document_tmp_name = $_FILES['document']['tmp_name'];
            $file_title = $this->input->post('title', true);
            $file_space = $this->ErpFileSizesModel->getTotalSize();
            $limit_file_space = $this->_db_details->space_limit;
            if($limit_file_space > ($file_space->total+$document_size)) {
                if (empty($file_title)) {
                    $path_parts = pathinfo($document_name);
                    if (isset($path_parts['filename']) && !empty($path_parts['filename'])) {
                        $file_title = ucwords(strtolower(str_replace('-', " ", trim($path_parts['filename']))));
                    } else {
                        $file_title = $document_name;
                    }
                }
                if ($this->_db_details) {
                    $amazon = $this->config->item('amazon');
                    $client = new S3Client(
                        array(
                            'version' => 'latest',
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                            'region' => $amazon['region'],
                            'client_defaults' => ['verify' => false],
                        )
                    );
                    $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                    $key = $this->_db_details->idcliente . '/resources/files/' . $unique_name;

                    $res = $client->putObject(
                        array(
                            'Bucket' => $amazon['bucket'],
                            'Key' => $key,
                            'SourceFile' => $document_tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => 'text/plain',
                        )
                    );

                    if (isset($res['ObjectURL'])) {
                        $r['aws_bucket'] = $amazon['bucket'];
                        $r['aws_key'] = $key;
                        $url = $res['ObjectURL'];
                        $data['title'] = "Sample Test";
                        $data['aws_link'] = $url;
                        $data['available'] = "1";
                        $document_id = $this->ResourceModel->add($data);
                        if (isset($document_id)) {
                            $r['document_id'] = $document_id;
                            $r['d']['id'] = $document_id;
                            $r['success'] = 1;
                            $r['message'] = $this->lang->line('file_upload_success');
                            $r['d']['doclink'] = $url;
                            $this->load->model('ErpFileSizesModel');
                            $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('file_not_save');
                        }
                    } else {
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('db_err_msg');
                    }
                } else {
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('db_err_msg');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('your_file_space_limit_finished');
            }
        } else {
            $r['success'] = 0;
            $r['message'] = $this->lang->line('no_file_uploaded');
        }
        echo json_encode($r);
        exit;
    }

    public function resourceUpload($model = "", $id = null){

        $r = array();
        $r['aws_bucket'] = null;
        $r['aws_key'] = null;
        $r['document_id'] = null;
        $r['file_title'] = null;

        if(!$model || !$id){
            $r['success']=0;
            $r['message']=$this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['model'] = $model;
        $r['id'] = $id;

        if(in_array($model,array('profesor','student'))){
            if(isset($_FILES)){
                $document_name = $_FILES['document']['name'];
                $document_type = $_FILES['document']['type'];
                $document_tmp_name = $_FILES['document']['tmp_name'];
                $document_size = $_FILES['document']['size'];
                $file_title = $this->input->post('title', true);
                $resource_type_id = $this->input->post('resource_type_id', true);

                $file_space = $this->ErpFileSizesModel->getTotalSize();
                $limit_file_space = $this->_db_details->space_limit;
                if($limit_file_space > ($file_space->total+$document_size)) {
                    if (empty($file_title)) {
                        $path_parts = pathinfo($document_name);

                        if (isset($path_parts['filename']) && !empty($path_parts['filename'])) {
                            $file_title = ucwords(strtolower(str_replace('-', " ", trim($path_parts['filename']))));
                        } else {
                            $file_title = $document_name;
                        }
                    }
                    $r['file_title'] = $file_title;

                    if ($this->_db_details) {
                        $amazon = $this->config->item('amazon');
                        $client = new S3Client(array(
                            'version' => 'latest',
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                            'region' => $amazon['region'],
                            'client_defaults' => ['verify' => false]
                        ));


                        $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                        $key = $this->_db_details->idcliente . '/campus/files/' . $model . '/' . $id . '/resource/' . $unique_name;
                        $res = $client->putObject(array(
                            'Bucket' => $amazon['bucket'],
                            'Key' => $key,
                            'SourceFile' => $document_tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => 'text/plain'
                        ));

                        if (isset($res['ObjectURL'])) {
                            $r['aws_bucket'] = $amazon['bucket'];
                            $r['aws_key'] = $key;

                            $url = $res['ObjectURL'];
//                        if($model == 'profesor'){

//                        }else if($model == 'student'){

//                        }

                            $r['aws_bucket'] = $amazon['bucket'];
                            $r['aws_key'] = $key;

                            $data['title'] = $file_title;
                            $data['aws_link'] = $url;
                            $data['available'] = "1";
                            $data['resource_type_id'] = $resource_type_id;
                            $document_id = $this->ResourceModel->add($data);


                            if (isset($document_id)) {
                                $r['document_id'] = $document_id;
                                $r['success'] = 1;
                                $r['message'] = $this->lang->line('file_upload_success');
                                $r['aws_link'] = $url;
                                if ($document_size) {
                                    $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));
                                }
                            } else {
                                $r['success'] = 0;
                                $r['message'] = $this->lang->line('file_not_save');
                            }
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    } else {
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('your_file_space_limit_finished');
                }
            }else{
                $r['success']=0;
                $r['message']= $this->lang->line('no_file_uploaded');
            }
        }else{
            $r['success']=0;
            $r['message']=$this->lang->line('invalid_request');
        }
        echo json_encode($r);
        exit;
    }

    public function resource_delete(){
        $response_data['status'] = false;
        $response_data["error"] = '';
        if ($this->input->post()) {
            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules("aws_bucket","Bucket Name","required");
            $this->form_validation->set_rules("aws_key","File path","required");
            $this->form_validation->set_rules("document_id","File Id","required");
            if ($this->form_validation->run() == false) {
                $response_data["error"] = validation_errors();
            } else {
                $amazon = $this->config->item('amazon');

                $aws_bucket = $this->input->post("aws_bucket", true);
                $aws_key = $this->input->post("aws_key", true);
                $document_id = $this->input->post("document_id", true);
                $model = $this->input->post("model", true);
                $id = $this->input->post("id", true);

                $client = new S3Client(
                    array(
                        'version' => 'latest',
                        'credentials' => array(
                            'key' => $amazon['AWSAccessKeyId'],
                            'secret' => $amazon['AWSSecretKey'],
                        ),
                        'region' => $amazon['region'],
                        'client_defaults' => ['verify' => false],
                    )
                );

                try {
                    $result = $client->deleteObject(
                        array(
                            // Bucket is required
                            'Bucket' => $aws_bucket,
                            // Key is required
                            'Key' => $aws_key,
                        )
                    );
                    $aws_link = $this->ResourceModel->getItemAwsLink($document_id);
                    $response_data['status'] = $this->ResourceModel->deleteItem($document_id);
                    if($aws_link && $response_data['status']){
                        $this->ErpFileSizesModel->deleteItem($aws_link->aws_link);
                    }
                    $response_data['status1'] = $result->get('DeleteMarker');
                } catch (Aws\S3\Exception\S3Exception $e) {
                    $response_data['error'] = $e;
                }
                $response_data['status'] = $this->ResourceModel->deleteItem($document_id);
            }
        }
        echo json_encode($response_data);
        exit;
    }
    public function uploadTemplateImg($field=""){

        $r = array();
        $r['aws_bucket'] = '';
        $r['aws_key'] = '';
        if(!$field){
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
            echo json_encode($r);
            exit;

        }
        $r['field'] = $field;
        $r['aws_url'] = '';


        if(in_array($field,array('templates'))){
            if(isset($_FILES)){
                $document_name = $_FILES['img']['name'];
                $document_type = $_FILES['img']['type'];
                $document_size = $_FILES['img']['size'];
                $document_tmp_name = $_FILES['img']['tmp_name'];
                $file_space = $this->ErpFileSizesModel->getTotalSize();
                $limit_file_space = $this->_db_details->space_limit;
                if($limit_file_space > ($file_space->total+$document_size)) {

                    if ($this->_db_details) {
                        $amazon = $this->config->item('amazon');
                        $client = new S3Client(array(
                            'version' => 'latest',
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                            'region' => $amazon['region'],
                            'client_defaults' => ['verify' => false]
                        ));

                        $unique_name = md5(uniqid(rand(), true)) . '-' . $document_name;
                        $key = $this->_db_details->idcliente . '/LMS/files/images/' . $field . '/' . $unique_name;

                        $res = $client->putObject(array(
                            'Bucket' => $amazon['bucket'],
                            'Key' => $key,
                            'SourceFile' => $document_tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => 'text/plain'
                        ));

                        if (isset($res['ObjectURL'])) {
                            $r['aws_bucket'] = $amazon['bucket'];
                            $r['aws_key'] = $key;

                            $url = $res['ObjectURL'];

                            $r['aws_url'] = $url;
                            $r['aws_name'] = $unique_name;
                            $r['success'] = 1;
                            $r['message'] = $this->lang->line('file_upload_success');
//                            $last_id = $this->ErpFileSizesModel->add(array('aws_link' => $url, 'file_size' => $document_size, 'file_type' => $document_type));
                        } else {
                            $r['success'] = 0;
                            $r['message'] = $this->lang->line('db_err_msg');
                        }
                    } else {
                        $r['success'] = 0;
                        $r['message'] = $this->lang->line('db_err_msg');
                    }
                }else{
                    $r['success'] = 0;
                    $r['message'] = $this->lang->line('your_file_space_limit_finished');
                }
            }else{
                $r['success'] = 0;
                $r['message'] = $this->lang->line('no_file_uploaded');
            }
        }else{
            $r['success'] = 0;
            $r['message'] = $this->lang->line('invalid_request');
        }
        echo json_encode($r);
        exit;
    }
    public function getAllTemplatesImages(){
        $result=array();
        if ($this->_db_details) {
            $amazon = $this->config->item('amazon');
            $client = new S3Client(array(
                'version' => 'latest',
                'credentials' => array(
                    'key' => $amazon['AWSAccessKeyId'],
                    'secret' => $amazon['AWSSecretKey'],
                ),
                'region' => $amazon['region'],
                'client_defaults' => ['verify' => false]
            ));
            $response = $client->listObjects(
                array('Bucket' =>  $amazon['bucket'],
                    'MaxKeys' => 1000,
                    'Prefix' => $this->_db_details->idcliente .'/LMS/files/images/templates/'));
            foreach ($response['Contents'] as $key =>$val){
                if($key != 0) {
                    $result[] = $client->getObjectUrl($amazon['bucket'], $val['Key']);
                }
            }
         echo json_encode($result); exit;
            }
    }

}

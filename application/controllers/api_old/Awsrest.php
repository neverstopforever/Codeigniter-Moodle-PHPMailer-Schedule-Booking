<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/24/15
 * Time: 10:25 PM
 */

class Awsrest extends MY_Controller
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
    }

    public function index_post(){
//      $this->load->spark('amazon-sdk/0.1.7');
        $s3 = $this->awslib->get_s3();
        @$s3->disable_ssl_verification();
//      var_dump($s3->create_bucket("te",AmazonS3::REGION_US_STANDARD,AmazonS3::ACL_PUBLIC)->isOK());
//     	$result = $s3->list_buckets();
        $response = $s3->create_object('softaula-file', $_FILES['document']['name'][0], array('fileUpload' => $_FILES['document']['tmp_name'][0],'acl'=>AmazonS3::ACL_PUBLIC));
//        $s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ)
        echo '<pre>' . print_r($response, TRUE) . '</pre>';
    }

    public function fileDelete_post()
    {

        $this->form_validation->set_data($this->input->post());
        $this->form_validation->set_rules("bucket_name","Bucket Name","required");
        $this->form_validation->set_rules("file_name","File Name","required");
        $response_data=array();
        if($this->form_validation->run()==False)
        {
            $response_data["error"]=validation_errors();
            $response_data['status']=false;
        }
        else
        {

            $s3 = $this->awslib->get_s3();
            @$s3->disable_ssl_verification();
            $result = $s3->delete_object($this->input->post("bucket_name"),$this->input->post("file_name"));
            $this->DocumentModel->delete_documentos($this->input->post("documentId"));
            $response_data['status']=true;
        }
          echo json_encode($response_data);
    }

    public function bucketDelete_get($bucket_name)
    {
        $s3 = $this->awslib->get_s3();
        @$s3->disable_ssl_verification();
        $s3->delete_bucket($bucket_name,true);
        return true;
    }

    public function sindex_post()
    {

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

    public function documents_get($clientId)
    {
        $documents=$this->DocumentModel->get_documents($clientId);
        $data['status']=true;
        $data['data']=$documents;
        echo json_encode($data);
    }
    
    public function files_get($docid=null){
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
    	if($ext == "doc"||$ext == "docx"){
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
    
    public function upload_post($model="",$id=null){
    	if(!empty($model)&&!empty($id)&&in_array($model,array('clients','leads'))){
    		if(isset($_FILES)){
    			$s3 = $this->awslib->get_s3();
				@$s3->disable_ssl_verification();
				$response = $s3->create_object('softaula-file', rand(10,2000).$_FILES['document']['name'][0], array('fileUpload' => $_FILES['document']['tmp_name'][0],'acl'=>AmazonS3::ACL_PUBLIC));
				if($response->status==200){
					$url = $response->header['_info']['url'];
					if($model=='clients'){
						$result = $this->DocumentModel->insert_document($id,date('Y-m-d'),$this->post('nombre'),$url,0);
					}else if($model=='leads'){
						$result = $this->DocumentModel->insert_document_lead($id,date('Y-m-d'),$this->post('nombre'),$_FILES['document']['type'][0],$url,0);
					}
					if($result){
						$r['d']['id']=$this->db->insert_id();
						$r['success']=1;
						$r['message']='File upload sucessfully';
						$r['d']['fecha'] = date('Y-m-d');
						$r['d']['visible'] = 'No';
						$r['d']['doclink'] = $url; 
						$r['d']['nombre'] = $this->post('nombre');
						$r['d']['docblob'] = 0;
					}else{
						$r['success']=0;
						$r['message']='File could not save.';
					}
				}else{
					$r['success']=0;
					$r['message']='File could not upload to aws s3';
				}
				//echo '<pre>' . print_r($response, TRUE) . '</pre>';
    		}else{
    			$r['success']=0;
				$r['message']='No file uploaded';
    		}
    	}else{
    		$r['success']=0;
			$r['message']='Invalid Request.';
    	}
    	echo json_encode($r);
    }

}

<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/24/15
 * Time: 10:25 PM
 * @property LeadDocumentModel $LeadDocumentModel
 */

class Leads_awsrest extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session','form_validation'));

        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000000000';

        $this->load->library('Awslib');
        $this->load->library('upload', $config);
        $this->load->model('LeadDocumentModel');
    }

    public function index(){
        if($this->input->post()){
            $this->index_post();
        }
//        $this->load->spark('amazon-sdk/0.1.7');
        $s3 = $this->awslib->get_s3();
        @$s3->disable_ssl_verification();
//        var_dump($s3->create_bucket("temp-bucketxx",AmazonS3::REGION_US_STANDARD,AmazonS3::ACL_PUBLIC)->isOK());
//        $result = $s3->list_buckets();

        $response = $s3->create_object('temp-bucketxx', 'testx.txt', array('body' => 'This is my body text.','acl'=>AmazonS3::ACL_PUBLIC));

//        var_dump($response);

//        $s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ)

        echo '<pre>' . print_r($response, TRUE) . '</pre>';
    }

    public function fileDelete_post()
    {
        $response_data = array();
        if($this->input->post()){
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
                $this->LeadDocumentModel->delete_documentos($this->input->post("documentId"));
                $response_data['status']=true;
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

    public function index_post()
    {
            $this->form_validation->set_rules('nombre',"Nombre","alpha|required");
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
                        $status=$this->LeadDocumentModel->insert_document(intval($this->input->post('clientid')),$this->input->post('fecha'),$this->input->post('nombre'),$url);
                        $response_data['data_url']=$url;
                        $response_data['status']=$status;

//                    print_r($response_data);exit;
                    }
                    else
                    {
                        $response_data['status']=false;
                        $response_data['error']="file has been uploaded to server but unable to transit S3 ";

                    }

                }
            }
            redirect('leads/edit/'.$clientid.'#documentos');
       // echo json_encode($response_data);
    }

    public function documents($clientId)
    {
        $documents=$this->LeadDocumentModel->get_documents($clientId);
        $data['status']=true;
        $data['data']=$documents;
        echo json_encode($data);
    }

}

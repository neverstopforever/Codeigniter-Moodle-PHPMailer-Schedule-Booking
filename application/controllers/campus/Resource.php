<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends MY_Campus_Controller {
    public $authid;
    public function __construct(){
        parent::__construct();
        $this->load->model('ResourceModel');
        $this->load->model('ResourceTemplateModel');
        $this->load->model('CourseModel');
        $this->load->model('ResourceGroupModel');
        $this->load->library('form_validation');
        $this->lang->load('campus',$this->data['lang']);
        if(!$this->session->userdata('campus_user')){
                redirect('campus/auth/login/', 'refresh');
        }
        $userData = (array)$this->session->userdata('campus_user');
        $this->authid = $userData['INDICE'];
    }  
	
    public function index(){
        $this->layouts
                ->add_includes('js', 'app/js/campus/resources/main.js')
                ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
                ->add_includes('js', 'assets/global/scripts/app.min.js')
                ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
                ->add_includes('css', 'assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css')
                ->add_includes('css', 'assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css')
                ->add_includes('js', 'app/js/campus/resources/index.js')
                ->add_includes('js', 'assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js')
                ->add_includes('js', 'assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js')
                ->add_includes('css', 'assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')
                ->add_includes('js', 'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        
        $resource = $this->ResourceModel->getlist();
        $this->data['json_resource'] = json_encode($resource);
        $template = $this->ResourceTemplateModel->getlist();
        $this->data['json_template'] = json_encode($template);
        $group = $this->ResourceGroupModel->getlist();
        $this->data['json_group'] = json_encode($group);
        $this->data['course'] = $this->CourseModel->getcourse($this->authid);
	$this->data['group'] = json_encode($this->CourseModel->getgroup($this->authid));
        $this->layouts->view('campus/resources/index', $this->data, $this->layout);
    }
    
    /** Resouce Template Action **/
    
    public function view_template(){
        
    }
    
    public function add_template(){
        //Add Ajax request case
        if($this->input->post()){
            $data['title'] = $this->input->post('name');
            $data['teacher_id'] = $this->authid;
            $templateid = $this->ResourceTemplateModel->add($data);
            $d['d']['title'] = $data['title'];
            $d['d']['id'] = $templateid;
            echo json_encode($d);
        }
    }
    
    public function edit_template($id=null){
        //Add Ajax request case
        if(!empty($id)){
            if($this->input->post()){
                $data['title'] = $this->input->post('name');
                $templateid = $this->ResourceTemplateModel->edit($data,$id,$this->authid);
                $d['d']['title'] = $data['title'];
                echo json_encode($d);
            }
        }
    }
    
    public function delete_template($id=null){
        //Add Ajax request case
        if(!empty($id)){
            //Check if id exist before delete step
            $result = $this->ResourceTemplateModel->delete($id,$this->authid);
            if($result){
                $d['success']='1';
                $d['message']='Templete delete Successfully';
            }else{
                $d['success']='0';
                $d['message']='Could not delete the Template';
            }
        }else{
            $d['success']='0';
            $d['message']='Invalid Request';
        }
        echo json_encode($d);
    }
    
    /** Add resources into Template **/
    
    public function get_template_resource(){
        if($this->input->post()){
            $templateId = $this->input->post('tid');
            $resouce = $this->ResourceTemplateModel->get_resource_template($templateId);
            echo (!empty($resouce))?json_encode($resouce):json_encode("");
        }
    }
    public function add_template_resource(){
        if($this->input->post()){
            $resId = $this->input->post('rid');
            $data['resource_id'] = (!empty($resId))?json_encode($resId):'';
            $data['template_id'] = $this->input->post('tid');
            $this->ResourceTemplateModel->save_resource_template($data['template_id'],$data);
            $resouce = $this->ResourceTemplateModel->get_resource_template($data['template_id']);
            echo (!empty($resouce))?json_encode($resouce):json_encode("");
        }
    }
    
    /** Add group ***/
    
    public function add_group(){
        if($this->input->post()){
            //validation required
            $data['title'] = $this->input->post('name');
            $data['course_id'] = $this->input->post('cid');
            $data['group_id'] = $this->input->post('gid');
            $data['teacher_id'] = $this->authid;
            $templateid = $this->ResourceGroupModel->add($data);
            $d['d']['title'] = $data['title'];
            $d['d']['id'] = $templateid;
            $d['d']['group_id'] = $data['group_id'];
            echo json_encode($d);
        }
    }
    
    public function delete_group($id=null){
        //Add Ajax request case
        if(!empty($id)){
            //Check if id exist before delete step
            $result = $this->ResourceGroupModel->delete($id,$this->authid);
            if($result){
                $d['success']='1';
                $d['message']='Group delete Successfully';
            }else{
                $d['success']='0';
                $d['message']='Could not delete the Group';
            }
        }else{
            $d['success']='0';
            $d['message']='Invalid Request';
        }
        echo json_encode($d);
    }
    
    public function get_group_resource(){
        if($this->input->post()){
            $groupId = $this->input->post('gid');
            $resource = $this->ResourceGroupModel->get_resource_group($groupId);
            echo (!empty($resource))?json_encode($resource):json_encode("");
        }
    }
    public function add_group_resource(){
        if($this->input->post()){
            $resId = $this->input->post('rid');
            $grpId = $this->input->post('gid');
            $exist = $this->ResourceGroupModel->exist($grpId,$this->authid);
            $result = "";
            if(!empty($exist)){
                $data = array();
                foreach($resId as $key=> $list){
                    $data[$key]['resource_group_id'] =$grpId;
                    $data[$key]['resource_id'] =$list;
                }
                $result = $this->ResourceGroupModel->save_resource_group_batch($grpId,$data);
            }
            echo (!empty($result))?json_encode($result):json_encode("");
        }
    }
    
    public function delete_group_resource($id=null){
        //Add teacher_id in column to allow to delete by respective teacher
        if(!empty($id)){
            //Check if id exist before delete step
            $result = $this->ResourceGroupModel->delete_resource($id,$this->authid);
            if($result){
                $d['success']='1';
                $d['message']='Resource from Group delete Successfully';
            }else{
                $d['success']='0';
                $d['message']='Could not delete the Resource from Group';
            }
        }else{
            $d['success']='0';
            $d['message']='Invalid Request';
        }
        echo json_encode($d);
    }
    
    public function import_template(){
        if($this->input->post()){
            $grpId = $this->input->post('gid');
            $tmpId = $this->input->post('tid');
            if(!empty($tmpId)){
                $data = array();
                $i=0;
                foreach($tmpId as $list){
                    $allresId = $this->ResourceTemplateModel->get_all_resource_template($list);
                    $resId = json_decode($allresId->resource_id);
                    foreach($resId as $key=> $list){
                        $i++;
                        $data[$i]['resource_group_id'] =$grpId;
                        $data[$i]['resource_id'] =$list;
                     }
                }
                $this->ResourceGroupModel->import_save_resource($data);
            }
            $resource = $this->ResourceGroupModel->get_resource_group($grpId);
            echo (!empty($resource))?json_encode($resource):json_encode("");
        }
    }
    /*** Comment ***/
    
    public function comment(){
        if($this->input->post()){
            $this->load->model('ResourcePostGroupModel');
            //need Vaildation
            $data['comments'] = $this->input->post('comment');
            $data['resource_group_id'] = $this->input->post('gid');
            $data['teacher_id'] = $this->authid;
            $result = $this->ResourcePostGroupModel->add($data);
            echo json_encode($result);
        }
    }
    
    public function get_comment($gid=null){
        if(!empty($gid)){
            $this->load->model('ResourcePostGroupModel');
            $result = $this->ResourcePostGroupModel->get_post($gid,$this->authid);
            echo json_encode($result);
        }
    }
    
    /*** Student ***/
   public function get_student(){
       if($this->input->post()){
           $this->load->model('AlumnoModel');
           $cid = $this->input->post('cid');
           $gid = $this->input->post('gid');
           $result = $this->AlumnoModel->getStudent($this->authid,$gid,$cid);
           foreach($result as $list){
               if(isset($list->foto) && !empty($list->foto)){
                        $list->foto = "<img src='".image_parser_from_db($list->foto)."' width='80' />";
                }
           }
           echo json_encode($result);
       }
   }
}
?>
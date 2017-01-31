<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\S3\S3Client;
use Aws\Ses\SesClient;
class TeacherResource extends MY_Campus_Controller {
    public $authid;
    public function __construct(){
        parent::__construct();
        $this->load->model('ResourceModel');
        $this->load->model('ResourceTemplateModel');
        $this->load->model('ScResourceTemplateModel');
        $this->load->model('ScResourceGroupItemsModel');
        $this->load->model('ScResourceGroupPlanningModel');
        $this->load->model('ScResourcePostGroupModel');
        
        
        $this->load->model('CourseModel');
        $this->load->model('ResourceGroupModel');
        $this->load->library('form_validation');
        $this->lang->load('campus',$this->data['lang']);
        if(!$this->session->userdata('campus_user')){
                redirect('campus/auth/login/', 'refresh');
        }
        $this->layouts->add_includes('js', 'app/js/campus/teacher_resource/main.js');
        $userData = (array)$this->session->userdata('campus_user');
        $this->authid  = $this->data['teacher_id'] = isset($userData['INDICE']) ? $userData['INDICE'] : null;
    }



    public function index(){
        $this->layouts


            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/global/scripts/app.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('css', 'assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css')
            ->add_includes('css', 'assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css')
            ->add_includes('js', 'app/js/campus/teacher_resource/index.js')
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
        $this->layouts->view('campus/teacher_resource/index', $this->data, $this->layout);
    }

    public function resources(){
        $this->data['page'] = 'teacher_resource_resources';
        $this->layouts
//                ->add_includes('css', 'assets/global/plugins/cubeportfolio/css/cubeportfolio.css')
//                ->add_includes('css', 'assets/pages/css/portfolio.min.css')

                ->add_includes('css', 'assets/global/plugins/fancybox/source/jquery.fancybox.css')

                ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
                ->add_includes('js', 'assets/global/scripts/app.min.js')
                ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')



//                ->add_includes('js', 'assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')
//                ->add_includes('js', 'assets/pages/scripts/portfolio-4.min.js')

            ->add_includes('js', 'app/js/campus/teacher_resource/resources.js');
//        ->add_includes('js', 'assets/global/plugins/fancybox/source/jquery.fancybox.pack.js');

        $this->data['resources']  = $this->ResourceModel->getlist();

        $this->layouts->view('campus/teacher_resource/resources', $this->data, $this->layout);
    }

    public function delete_resource(){
        
        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $resource_id = $this->input->post('resource_id', true);
            $aws_link = $this->ResourceModel->getItemAwsLink($resource_id);
            if($this->deleteFromAws($aws_link)) {
                $deleted = $this->ResourceModel->deleteItem($resource_id);
                if ($deleted) {
                    $this->load->model('ErpFileSizesModel');
                    $this->ErpFileSizesModel->deleteItem($aws_link->aws_link);
                    $response['success'] = $this->lang->line('teacher_resource_deleted_success');
                } else {
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('aws_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    private function deleteFromAws($aws_link){
        $amazon = $this->config->item('amazon');
        $explode_data = explode($amazon['bucket'].'/',$aws_link->aws_link);
        $aws_key = isset($explode_data[1]) ? $explode_data[1] : null;
        $client = new S3Client(array(
            'version' => 'latest',
            'credentials' => array(
                'key'       => $amazon['AWSAccessKeyId'],
                'secret'    => $amazon['AWSSecretKey'],
            ),
            'region' => $amazon['region'],
            'client_defaults' => ['verify' => false]
        ));
        if($aws_key) {
            try {
                $result = $client->deleteObject(array(
                    // Bucket is required
                    'Bucket' => $amazon['bucket'],
                    // Key is required
                    'Key' => $aws_key
                ));
                $result_2 = $client->doesObjectExist($amazon['bucket'], $aws_key);
               if(!$result_2) {
                   return true;
               }else{
                   return false;
               }
            } catch (Aws\S3\Exception\S3Exception $e) {
                $response_data['status1'] = $e;
                return false;
            }
        }else{
            return false;
        }
    }

    public function edit_resource(){

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->post()) {
                $this->config->set_item('language', $this->data['lang']);
//                $this->form_validation->set_data($this->input->post(null, true));
                $this->form_validation->set_rules("resource_id","Id","trim|required");
                $this->form_validation->set_rules("title",$this->lang->line('teacher_resource_title_document'),"trim|required");
                $this->form_validation->set_rules("available",$this->lang->line('teacher_resource_visible'),"trim|required");
                if ($this->form_validation->run() == false) {
                    $response["errors"] = $this->form_validation->error_array();
                } else {
                    $resource_id = $this->input->post('resource_id', true);
                    $title = $this->input->post('title', true);
                    $available = $this->input->post('available', true);
                    $edit_data = array(
                        'title' => $title,
                        'available' => $available
                    );
                    $edited = $this->ResourceModel->editItem($edit_data, $resource_id);
                    if($edited){
                        $response['success'] = $this->lang->line('teacher_resource_updated_success');
                    }else{
                        $response['errors'][] = $this->lang->line('db_err_msg');
                    }
                }            
            
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }


    //templates
    public function templates(){
        $this->data['page'] = 'teacher_resource_templates';        

        $this->layouts
            ->add_includes('js', 'app/js/campus/teacher_resource/templates.js');

        $this->data['templates'] = $this->ResourceTemplateModel->getByTeacherId($this->data['teacher_id']);

        $this->layouts->view('campus/teacher_resource/templates', $this->data, $this->layout);
    }      
    
    public function add_template(){
        $response['success'] = false;
        $response['errors'] = array();
        $response['template_id'] = null;
        $response['title'] = null;
        $response['action'] = null;
        //Add Ajax request case
        if($this->input->post()){
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules("template_title",$this->lang->line('teacher_resource_t_template_name'),"trim|required");
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $data['title'] = $this->input->post('template_title', true);
                $data['teacher_id'] = $this->data['teacher_id'];
                $template_id = $this->ResourceTemplateModel->add($data);
                if($template_id){
                    $response['success'] = $this->lang->line('teacher_resource_t_added_success');
                    $response['template_id'] = $template_id;
                    $response['title'] = $data['title'];
                    $response['action'] = '<div class="btn-group pull-right circle_dropdown_div" >
                                            <button type="button" class="btn btn-default btn-xs btn-default dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">'.$this->lang->line('teacher_resource_t_actions').'<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" id="ul_'.$template_id.'" data-template_id="'.$template_id.'" data-teacher_id="'.$this->data['teacher_id'].'">
                                                <li><a href="#" data-toggle="tooltip" class="t_edit edit_template_item"><i class="fa fa-edit"></i> '.$this->lang->line('teacher_resource_t_edit_template').'</a></li>
                                                <li><a href="#" data-toggle="tooltip" class="t_manage"><i class="fa fa-file-text-o"></i> '.$this->lang->line('teacher_resource_t_manage_resource').'</a></li>
                                                <li><a href="#" data-toggle="tooltip" class="t_delete delete_template_item" data-confirm="'.$this->lang->line('are_you_sure_delete').'"><i class="fa fa-trash-o"></i> '.$this->lang->line('teacher_resource_t_delete_template').'</a></li>
                                            </ul>
                                        </div>';
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function edit_template(){

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->post()) {
            $this->config->set_item('language', $this->data['lang']);
//                $this->form_validation->set_data($this->input->post(null, true));
            $this->form_validation->set_rules("template_id","Id","trim|required");
            $this->form_validation->set_rules("title",$this->lang->line('teacher_resource_t_title'),"trim|required");
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $template_id = $this->input->post('template_id', true);
                $title = $this->input->post('title', true);
                $edit_data = array(
                    'title' => $title
                );
                $edited = $this->ResourceTemplateModel->editItem($edit_data, $template_id, $this->data['teacher_id']);
                if($edited){
                    $response['success'] = $this->lang->line('teacher_resource_t_updated_success');
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function delete_template(){

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $template_id = $this->input->post('template_id', true);
            $deleted = $this->ResourceTemplateModel->deleteItem($template_id, $this->data['teacher_id']);
            if($deleted){
                try{
                    $this->ScResourceTemplateModel->deleteByTemplateId($template_id);
                    $this->load->model('ErpFileSizesModel');
                }catch(\Exception $er){
                    //error message if need
                }
                $response['success'] = $this->lang->line('teacher_resource_t_deleted_success');
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }


  
    /** Add resources into Template **/
    
    public function get_template_resource(){
        $response['resource_ids'] = null;
        $response["r_html"] = '';

        if($this->input->post()){
            $templateId = $this->input->post('tid', true);
            $this->data['resources'] = $this->ResourceModel->getlist();
            $selected_resources = $this->ScResourceTemplateModel->get_resource_id($templateId);
            $this->data['resource_ids'] = null;
            if(isset($selected_resources->resource_id)){
                $this->data['resource_ids'] = unserialize($selected_resources->resource_id);
            }
            $this->data['template_id'] = $templateId;
            $response['resource_ids'] = $this->data['resource_ids'];
            $response["r_html"] .= $this->load->view('campus/teacher_resource/partials/manage_template_resource', $this->data, true);
            
        }
        print_r(json_encode($response));
        exit;
    }
    
    public function remove_template_resource(){
        $response['success'] = false;
        if($this->input->post()){
            $checked_resource_ids = $this->input->post('checked_resource_ids', true);
            $template_id = $this->input->post('template_id', true);
            $resource_ids = serialize($checked_resource_ids);
            $delete_item = $this->ScResourceTemplateModel->deleteByTemplateId($template_id);
            if($delete_item){
                $insert_data  = array(
                   'resource_id'=> $resource_ids,
                   'template_id'=> $template_id,
                );
                $srt_insert_id = $this->ScResourceTemplateModel->addItem($insert_data);
                if($srt_insert_id){
                    $response['success'] = true; 
                }
            }     
            
        }
        print_r(json_encode($response));
        exit;
    }
    
    public function add_template_resource(){
        $response['success'] = false;
        if($this->input->post()){
            $checked_resource_ids = $this->input->post('checked_resource_ids', true);
            $template_id = $this->input->post('template_id', true);
            $resource_ids = serialize($checked_resource_ids);
            $this->ScResourceTemplateModel->deleteByTemplateId($template_id);
            $insert_data  = array(
                'resource_id'=> $resource_ids,
                'template_id'=> $template_id,
            );
            $srt_insert_id = $this->ScResourceTemplateModel->addItem($insert_data);
            if($srt_insert_id){
                $response['success'] = true;
            }

        }
        print_r(json_encode($response));
        exit;
    }
    


    /** Groups **/
    public function groups(){
        $this->layouts
            ->add_includes('js', 'assets/global/plugins/dropzone/dropzone.min.js')
            ->add_includes('js', 'assets/global/scripts/app.min.js')
            ->add_includes('js', 'assets/pages/scripts/form-dropzone.min.js')
            ->add_includes('js', 'app/js/campus/teacher_resource/groups.js');

//        $this->data['groups'] = $this->ResourceGroupModel->getlist();
        $this->data['groups'] = $this->ResourceGroupModel->getResourceList(array('teacher_id' => $this->data['teacher_id']));

        $this->data['courses'] = $this->CourseModel->getCourse($this->data['teacher_id']);
        $this->data['_groups'] = $this->CourseModel->getGroup($this->data['teacher_id']);

        $this->layouts->view('campus/teacher_resource/groups', $this->data, $this->layout);
    }
    
    /** Add group ***/
    public function add_group(){
        $response['success'] = false;
        $response['errors'] = array();
        //Add Ajax request case
        if($this->input->post()){
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules("CourseId",$this->lang->line('teacher_resource_g_course'),"trim|required");
            $this->form_validation->set_rules("GroupId",$this->lang->line('teacher_resource_g_group'),"trim|required");
            $this->form_validation->set_rules("group_title",$this->lang->line('teacher_resource_g_group_title'),"trim|required");

            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $data['title'] = $this->input->post('group_title', true);
                $data['course_id'] = $this->input->post('CourseId', true);
                $data['group_id'] = $this->input->post('GroupId', true);
                $data['teacher_id'] = $this->data['teacher_id'];
                $rg_id = $this->ResourceGroupModel->addItem($data);
                
                if($rg_id){
                    $response['success'] = $this->lang->line('teacher_resource_g_added_success');
                    $sc_resource_group = $this->ResourceGroupModel->getById($rg_id);
                    $response['resource_group'] = true;
                    if(isset($sc_resource_group[0]) && !empty($sc_resource_group[0])){
                        $response['grupo'] = $sc_resource_group[0]->grupo;
                        $response['title'] = $sc_resource_group[0]->title;
                        //$response['start_date'] = $sc_resource_group[0]->start_date;
                        //$response['end_date'] = $sc_resource_group[0]->end_date;

                        $response['action'] = '<div class="btn-group pull-right circle_dropdown_div" >
                                                    <button type="button" class="btn btn-default btn-xs  dropdown-toggle"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">'.$this->lang->line('teacher_resource_g_actions').'<span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" id="ul_'.$sc_resource_group[0]->id.'" data-sr_group_id="'.$sc_resource_group[0]->id.'" data-group_id="'.$sc_resource_group[0]->group_id.'" data-group_comment="'.@$sc_resource_group[0]->comments.'">
                                                        <li><a href="#" class="g_edit" data-toggle="tooltip"><i class="fa fa-edit"></i>'.$this->lang->line('teacher_resource_g_edit_group').'</a></li>
                                                        <li><a href="#" class="g_manage" data-toggle="tooltip"><i class="fa fa-file-text-o"></i>'.$this->lang->line('teacher_resource_g_manage_resource').'</a></li>
                                                        <li><a href="#" class="g_post" data-toggle="tooltip"><i class="fa fa-file-text-o"></i>'.$this->lang->line('teacher_resource_g_pmt_group').'</a></li>
                                                        <li><a href="#" data-toggle="tooltip" class="g_delete" data-confirm="'.$this->lang->line('are_you_sure_delete').'"><i class="fa fa-trash-o"></i>'.$this->lang->line('teacher_resource_g_delete_group').'</a></li>
                                                    </ul>
                                                </div>';
                    }else{
                        $response['resource_group'] = false;
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function get_group_resource(){
        $response['resource_ids'] = null;
        $response['selected_resources'] = array();
        $response['id'] = null;
        $response["r_html"] = '';

        if($this->input->post()){
            $this->data['resources'] = $this->ResourceModel->getlist();

            $resource_group_id = $this->input->post('gid', true);
            $group_id = $this->input->post('group_id', true);
            $response['selected_resources'] = $this->data['selected_resources'] = $this->ScResourceGroupItemsModel->getItemsByResourceGroupId($resource_group_id);
            $this->data['resource_ids'] = null;

            if($response['selected_resources']){
                foreach($response['selected_resources'] as $selected_resource){
                    $this->data['resource_ids'][] = $selected_resource->resource_id;
                }
            }

            $this->data['templates'] = $this->ResourceTemplateModel->getByTeacherId($this->data['teacher_id']);
            $this->data['template_ids'] = null;
//            $selected_templates = $this->ScResourceGroupItemsModel->getItemByResourceGroupId($resource_group_id);
//            if(isset($selected_templates->template_id)){
//                $this->data['template_ids'] = unserialize($selected_templates->template_id);
//            }

            $this->data['resource_group_id'] = $resource_group_id;
            $this->data['group_id'] = $group_id;
            $response['resource_ids'] = $this->data['resource_ids'];


            $response["r_html"] .= $this->load->view('campus/teacher_resource/partials/manage_group_resource', $this->data, true);

        }
        print_r(json_encode($response));
        exit;

    }
    
    public function add_group_resource(){
        $response['success'] = false;
        $response['selected_resources'] = array();
        if($this->input->post()){
            $resource_ids = $this->input->post('checked_resource_ids', true);
            $resource_group_id = $this->input->post('resource_group_id', true);
            
            $old_items = $this->ScResourceGroupItemsModel->getItemsByResourceGroupId($resource_group_id);

            if(!empty($resource_ids)){
                foreach ($old_items as $old_item){
                    if(!in_array($old_item->resource_id, $resource_ids) && $resource_group_id == $old_item->resource_group_id){
                        $this->ScResourceGroupItemsModel->deleteById($old_item->id);
                    }else{
                        $key = array_search($old_item->resource_id, $resource_ids);
                        unset($resource_ids[$key]);
                    }
                }
                if(!empty($resource_ids)){
                    foreach ($resource_ids as $resource_id){
                        $insert_data = array(
                            'resource_id'=> $resource_id,
                            'resource_group_id'=> $resource_group_id,
                        );
                        $srt_insert_id = $this->ScResourceGroupItemsModel->addItem($insert_data);
                        if(!$response['success']){
                            $response['success'] = true;
                        }
                    }
                }
                if($response['success']){
                    $response['selected_resources'] = $this->ScResourceGroupItemsModel->getItemsByResourceGroupId($resource_group_id);
                }
            }
        }
        print_r(json_encode($response));
        exit;
    }

    public function remove_group_resource(){
        $response['success'] = false;
        if($this->input->post()){
            $id = $this->input->post('id', true);
            if(!empty($id)){
                $response['success'] = $this->ScResourceGroupItemsModel->deleteById($id);
            }

        }
        print_r(json_encode($response));
        exit;
    }
    
    public function delete_group(){

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $sr_group_id = $this->input->post('sr_group_id', true);
            $deleted = $this->ResourceGroupModel->deleteItem($sr_group_id, $this->data['teacher_id']);

            if($deleted){
                $this->ScResourceGroupItemsModel->deleteByResourceGroupId($sr_group_id);
//                $this->ScResourceGroupPlanningModel->deleteByResourceGroupId($sr_group_id);
                $this->ScResourcePostGroupModel->deleteByResourceGroupId($sr_group_id, $this->data['teacher_id']);
                $response['success'] = $this->lang->line('teacher_resource_g_deleted_success');
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }


        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
    
    public function import_template(){

        $response['success'] = false;
        $response['resource_ids'] = null;
        $response['selected_resources'] = array();
        if($this->input->post()){
            $checked_template_ids = $this->input->post('checked_template_ids', true);
            $resource_group_id = $this->input->post('resource_group_id', true);

            $exist_resources = $this->ScResourceGroupItemsModel->getItemsByResourceGroupId($resource_group_id);

            $resource_ids = array();
            if(!empty($exist_resources)){
                foreach ($exist_resources as $exist_resource){
                    $resource_ids[] = $exist_resource->resource_id;
                }
            }

            foreach($checked_template_ids as $template_id){
                $allresId = $this->ScResourceTemplateModel->get_resource_id($template_id);

                if(isset($allresId->resource_id)){
                    $resIds = unserialize($allresId->resource_id);
                    foreach($resIds as $key=> $resId){
                        if (!in_array($resId, $resource_ids)){
                            $resource_ids[] = $resId;
                        }
                    }
                }
            }
            $response['resource_ids'] = $resource_ids;


            foreach ($exist_resources as $old_item){
                if(!in_array($old_item->resource_id, $resource_ids) && $resource_group_id == $old_item->resource_group_id){
                    $this->ScResourceGroupItemsModel->deleteById($old_item->id);
                }else{
                    $key = array_search($old_item->resource_id, $resource_ids);
                    unset($resource_ids[$key]);
                }
            }
            if(!empty($resource_ids)){
                foreach ($resource_ids as $resource_id){
                    $insert_data = array(
                        'resource_id'=> $resource_id,
                        'resource_group_id'=> $resource_group_id,
                    );
                    $srt_insert_id = $this->ScResourceGroupItemsModel->addItem($insert_data);
                    if(!$response['success']){
                        $response['success'] = true;
                    }
                }
            }
            if($response['success']){
                $response['selected_resources'] = $this->ScResourceGroupItemsModel->getItemsByResourceGroupId($resource_group_id);
            }
        }
        print_r(json_encode($response));
        exit;

    }
    /*** Comment ***/    
    public function comment(){

        $response['success'] = false;
        $response['errors'] = array();
        $response["result"] = null;
        //Add Ajax request case
        if($this->input->post()){
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules("comment",$this->lang->line('teacher_resource_g_comment'),"trim|required");

            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $data['comments'] = $this->input->post('comment', true);
                $data['resource_group_id'] = $this->input->post('gid', true);
                $data['teacher_id'] = $this->data['teacher_id'];
                $id = $this->ScResourcePostGroupModel->add($data);
                if($id){
                    $response["result"] = $this->ScResourcePostGroupModel->getInfoWithProfesor($id);
                    $response['success'] = $this->lang->line('teacher_resource_g_comment_added_success');
                    $resource_group_data = $this->ResourceGroupModel->getDataById($data['resource_group_id']);
                    if(!empty($resource_group_data)) {
                        $this->load->model('AlumnoModel');
                        $students = $this->AlumnoModel->getStudentsByGroupCourse($resource_group_data->group_id, $resource_group_data->course_id);
                        if (!empty($students)) {
                            foreach($students as $student_data) {
                                if (!empty($student_data)) {
                                    $replace_data = array(
                                        'FIRSTNAME' => $student_data->first_name,
                                        'SURNAME' => $student_data->sur_name,
                                        'FULLNAME' => $student_data->full_name,
                                        'PHONE1' => $student_data->phone1,
                                        'MOBILE' => $student_data->mobile,
                                        'EMAIL1' => $student_data->email,
                                        //'COURSE_NAME' => $course_data->course_name,
                                        'START_DATE' => date('Y-m-d'),
                                        'END_DATE' => date('Y-m-d'),
                                    );
                                    $this->sendEmailPart($replace_data, $student_data->email);
                                }
                            }
                        }
                    }
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }
    private function sendEmailPart($replace_data,$email){
        $result = null;
        $this->load->model('ErpEmailsAutomatedModel');
        $template = $this->ErpEmailsAutomatedModel->getByTemplateId('10', array('notify_student' => 1));
        if (!empty($template) && !empty($email)) {
            $email_subject = replaceTemplateBody($template->Subject, $replace_data);
            $email_body = replaceTemplateBody($template->Body, $replace_data);
            $result = $this->send_automated_email($email, $email_subject, $email_body, $template->from_email);
        }
        return $result;
    }

    private function send_automated_email($email, $subject, $body, $from_email){
        $this->load->model('ErpEmailModel');
        $user_id = $this->data['teacher_id'];

        $emails_limit_daily = $this->_db_details->emails_limit_daily;
        $emails_limit_monthly = $this->_db_details->emails_limit_monthly;
        $count_emails_day = $this->ErpEmailModel->getEmailsCountDay();

        if ($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly) {
            $amazon = $this->config->item('amazon');
            $email_from = $this->config->item('email');

            $client = SesClient::factory(array(
                'version' => 'latest',
                'region' => $amazon['email_region'],
                'credentials' => array(
                    'key' => $amazon['AWSAccessKeyId'],
                    'secret' => $amazon['AWSSecretKey'],
                ),
            ));

            $request = array();
            $request['Source'] = $from_email.' <'.$email_from['from'].'>';
            $request['Destination']['ToAddresses'] = array($email);
            $request['Message']['Subject']['Data'] = $subject;
            $request['Message']['Subject']['Charset'] = "UTF-8";
            $request['Message']['Body']['Html']['Data'] = $body;
            $request['Message']['Body']['Charset'] = "UTF-8";
            $data_recipient = array(
                'from_userid' => $user_id,
                'from_usertype' => '1',
                'id_campaign' => '',
                'email_recipie' => $email,
                'Subject' => $subject,
                'Body' => $body,
                'date' => date('Y-m-d H:i:s'),
            );
            try {
                $result = $client->sendEmail($request);
                $messageId = $result->get('MessageId');
                //echo("Email sent! Message ID: $messageId"."\n");
                if ($messageId) {
                    $response['success'] = $this->lang->line('send_email_success');
                    $response['errors'] = false;
                    $data_recipient['sucess'] = '1';
                    $data_recipient['error_msg'] = ''; //$e->getMessage(),
                } else {
                    $response['errors'] = $this->lang->line('no_send_email');
                }

            } catch (Exception $e) {
                //echo("The email was not sent. Error message: ");
                //$response['errors'] = $e->getMessage()."\n";
                $response['errors'] = $this->lang->line('no_send_email');
                $data_recipient['sucess'] = '0';
                $data_recipient['error_msg'] = $e->getMessage();
            }
            $added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
        }else{
            $response['errors'] = $this->lang->line('emails_limit_daily_msg');
        }
        return $response;
    }
    public function get_comment(){
        $response['success'] = false;
        if($this->input->post()){
            $resource_group_id = $this->input->post('resource_group_id', true);            
            $response['comments'] = $this->ScResourcePostGroupModel->get_post($resource_group_id, $this->data['teacher_id']);           
            if(!empty($response['comments'])){
                $response['success'] = true;
            }
        }
        print_r(json_encode($response));
        exit;
    }

    //planning resource
    public function save_plan(){

        $response['success'] = false;
        $response['errors'] = array();
        $response['selected_resources'] = array();
        //Add Ajax request case
        if($this->input->post()){
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules("plan_comment",$this->lang->line('teacher_resource_g_comment'),"trim|required");
            $this->form_validation->set_rules("group_start_date",$this->lang->line('teacher_resource_g_start_date'),"trim|required");
            $this->form_validation->set_rules("group_end_date",$this->lang->line('teacher_resource_g_end_date'),"trim|required");

            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $data['comments'] = $this->input->post('plan_comment', true);
                $data['start_date'] = $this->input->post('group_start_date', true);
                $data['end_date'] = $this->input->post('group_end_date', true);
                $resource_group_id = $this->input->post('resource_group_id', true);
                $data['id'] = $this->input->post('id', true);                
                $update_add = $this->ScResourceGroupItemsModel->updateItem($data, $data['id']);
                if($update_add){
                    $response['selected_resources'] = $this->ScResourceGroupItemsModel->getItemsByResourceGroupId($resource_group_id);
                    $response['success'] = $this->lang->line('teacher_resource_g_save_plan_success');
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
    }

    public function edit_group_title(){

        $response['success'] = false;
        $response['errors'] = array();
        if ($this->input->post()) {
            $this->config->set_item('language', $this->data['lang']);
//                $this->form_validation->set_data($this->input->post(null, true));
            $this->form_validation->set_rules("resource_group_id","Id","trim|required");
            $this->form_validation->set_rules("title",$this->lang->line('teacher_resource_g_title'),"trim|required");
            if ($this->form_validation->run() == false) {
                $response["errors"] = $this->form_validation->error_array();
            } else {
                $resource_group_id = $this->input->post('resource_group_id', true);
                $title = $this->input->post('title', true);
                $edit_data = array(
                    'title' => $title
                );
                $edited = $this->ResourceGroupModel->editItem($edit_data, $resource_group_id, $this->data['teacher_id']);
                if($edited){
                    $response['success'] = $this->lang->line('teacher_resource_g_updated_success');
                }else{
                    $response['errors'][] = $this->lang->line('db_err_msg');
                }
            }

        }else{
            $response['errors'][] = $this->lang->line('db_err_msg');
        }
        print_r(json_encode($response));
        exit;
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
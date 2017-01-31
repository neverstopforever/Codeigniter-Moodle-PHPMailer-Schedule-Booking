<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UserPostModel $UserPostModel
 *@property BlogModel $BlogModel
 */
class Blog extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (empty($this->_identity['loggedIn'])) {
			redirect('/auth/login/', 'refresh');
		}
		$this->layout = "blog";
		$this->load->helper('text');
		$this->load->model('BlogModel');
		$this->load->model('UserPostModel');
		$this->layouts->add_includes('js', 'app/js/blog/main.js');
	}
	
	public function index(){
		$this->layouts->add_includes('js', 'app/js/blog/index.js');
		$this->data['page'] = "blog_index";
		$this->data['posts'] = $this->BlogModel->getallpost();
		$this->layouts->view('blog/index', $this->data /*, $this->layout*/);
	}
	
	public function write(){
		$this->data['page']='blog';
		$this->load->view('blogWriteView', $this->data);
	}

	public function edit($id){
		if(!$id){
			redirect('blog/list', 'refresh');
		}
		$this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css');
		$this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js');
		$this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js');
		$this->layouts->add_includes('js', 'app/js/blog/edit.js');
		$this->data['page']='blog_edit';
		$this->data['post'] = $this->BlogModel->getpost($id);
//		$this->load->view('blogEdit', $this->data);
		$this->layouts->view('blog/edit', $this->data /*, $this->layout*/);
	}

	public function update(){
		if($this->input->post()){
			$userData=$this->session->userdata('userData');
			$usuario=$userData[0]->USUARIO;
			$id = $this->input->post('post_id');
			$data['post_title'] = $this->input->post('post_title');
			$data['post_content'] = $this->input->post('post_content');
			$filename = isset($_FILES['post_image']['tmp_name'])?$this->upload($usuario,$_FILES['post_image']['tmp_name'],'post_image'):"";
			$data['post_image'] = (!empty($filename))?$filename:$this->input->post('hidden_post_image');
			$res=$this->BlogModel->update_blog($data, $id);
			if($res){
				$this->session->set_flashdata('success', 'Post updated successfully.');
				redirect('blog');
			}else{
				$this->session->set_flashdata('error', 'Post could not updated.');
			}
		}
	}

	public function view($slug){

		$this->data['page'] = 'Blog';
		$this->db->where('slug', $slug);
		$post = $this->db->get('usuarios_post');
		$this->data["post"] = (array)$post->row();
		if(!empty($data["post"])){
			$nxt = $this->db->query("select slug,post_title from usuarios_post where post_id = (select max(post_id) from usuarios_post where post_id < ".$data['post']['post_id'].")");
			$this->data['nxt'] = (array)$nxt->row();
			$prev = $this->db->query("select slug,post_title from usuarios_post where post_id = (select min(post_id) from usuarios_post where post_id > ".$data['post']['post_id'].")");
			$this->data['prev'] = (array)$prev->row();
			$this->load->view('post', $this->data);
		}else{
			show_404();
		}

	}

	public function delete($id){
			print_r($this->BlogModel->delete_blog($id));
	}

	public function list_get(){
		$this->layouts->add_includes('js', 'app/js/blog/list.js');
		$this->data['page'] = "blog_list";
		$this->data['post'] = $this->BlogModel->getlist();
		$this->layouts->view('blog/list', $this->data /*, $this->layout*/);
	}
	
	public function create(){
		$details = array();

		if($this->input->post()){
			$userData=$this->session->userdata('userData');
			$usuario=$userData[0]->USUARIO;
			$post_title  = $this->input->post('post_title', true);
			$post_content  = $this->input->post('post_content', true);
			$post_slug = $this->BlogModel->getUniqueUrl($post_title,'slug');
			$filename = isset($_FILES['file']['tmp_name'])?$this->upload($usuario,$_FILES['file']['tmp_name'],'file'):"";
			$details = $this->magaModel->insert('usuarios_post',array(
				'slug'=>$post_slug,
				'post_date'=>Date('Y-m-d'),
				'post_title'=>$post_title,
				'post_content'=>$post_content,
				'post_image'=>$filename));
		}
		print_r($details);
		exit;
	}

	public function all(){
		$query = "SELECT
				post_id,
				post_date,
				post_title,
				post_content,
				post_image,
				slug
				FROM usuarios_post
				ORDER BY post_date DESC
				;";
		$details=$this->magaModel->selectCustom($query);
		// foreach ($details as $detail) {
		// 	$detail->post_image = base64_encode($detail->post_image);
		// }
		print_r(json_encode($details));
	}

	function upload($folder,$file=null,$field){
		$upload_path='uploads';
        $uid=$folder; //creare seperate folder for each user
        // $upPath=$upload_path."/".$uid;
        // if(!file_exists($upPath)) 
        // {
        //     mkdir($upPath, 777, true);
        // }
        $config = array(
        'upload_path' => $upload_path,
        'allowed_types' => "gif|jpg|png|jpeg",
        'file_name' => $folder.'_blog_'.Date('Hms'),
        'overwrite' => TRUE,
        'max_size' => "2048000"
        );
        $this->load->library('upload', $config);
        $image = "";
        if(!$this->upload->do_upload($field)){
            $data['imageError'] =  $this->upload->display_errors();
        }else{
            $imageDetailArray = $this->upload->data();
            $image =  $imageDetailArray['file_name'];
        }
        return $image;
	}
}

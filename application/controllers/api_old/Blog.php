<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UserPostModel $UserPostModel
 */
class Blog extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('text');
		$this->load->model('BlogModel');
		$this->load->model('UserPostModel');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
	}
	
	public function index_get(){
		$data=array();
		$data['page']='Blog';
		$data['posts'] = $this->BlogModel->getallpost();
		$this->load->view('blogView', $data);
	}
	
	public function write_get(){
		$this->data['page']='blog';
		$this->load->view('blogWriteView', $this->data);
	}

	public function edit_get($id){
		$data['page']='blog';
		$data['post'] = $this->BlogModel->getpost($id);
		$this->load->view('blogEdit', $data);
	}

	public function update_post(){
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

	public function view_get($slug){
		$data['page'] = 'Blog';
		$this->db->where('slug', $slug);
		$post = $this->db->get('usuarios_post');
		$data["post"] = (array)$post->row();
		if(!empty($data["post"])){
			$nxt = $this->db->query("select slug,post_title from usuarios_post where post_id = (select max(post_id) from usuarios_post where post_id < ".$data['post']['post_id'].")");
			$data['nxt'] = (array)$nxt->row();
			$prev = $this->db->query("select slug,post_title from usuarios_post where post_id = (select min(post_id) from usuarios_post where post_id > ".$data['post']['post_id'].")");
			$data['prev'] = (array)$prev->row();
			$this->load->view('post', $data);
		}else{
			show_404();
		}

	}

	public function delete_delete($id){
		print_r($this->BlogModel->delete_blog($id));
	}

	public function list_get(){
		$this->data['page'] = "blog";
		$this->data['post'] = $this->BlogModel->getlist();
		$this->load->view('list', $this->data);
	}
	
	public function create_post(){
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$post_title  = $this->post('post_title');
		$post_content  = $this->post('post_content');
		$post_slug = $this->BlogModel->getUniqueUrl($post_title,'slug');
		$filename = isset($_FILES['file']['tmp_name'])?$this->upload($usuario,$_FILES['file']['tmp_name'],'file'):"";
		$details=$this->magaModel->insert('usuarios_post',array(
			'slug'=>$post_slug,
			'post_date'=>Date('Y-m-d'),
			'post_title'=>$post_title,
			'post_content'=>$post_content,
			'post_image'=>$filename));
		print_r($details);
	}

	public function all_get(){
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(E_ALL);
/**
 *@property magaModel $magaModel
 *@property AvisosNotaModel $AvisosNotaModel
 *@property UsuarioModel $UsuarioModel
 */
class Tasks extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
		   $this->load->model('AvisosNotaModel');
		   $this->load->model('UsuarioModel');
			// $this->config->set_item('language', $lang == '' ? "english" : $lang);
       }
	public function index_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='Task Manager';
			$this->load->view('TasksView', $data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function tasks_get(){
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$details = $this->AvisosNotaModel->getAvisosNotas($usuario);
			$tasks=array();
			foreach ($details as $detail) {
				$newTasks=$detail;
				$details = $this->UsuarioModel->getProfileFoto($newTasks->USUARIO);
				$newTasks->foto = base64_encode($details[0]->foto);
				$comments=$this->magaModel->selectComments('comentarios_de_tareas',array('tareasId'=>$detail->id));
				foreach ($comments as $comment) {
					$details = $this->UsuarioModel->getProfileFoto($comment->USUARIO);
					$comment->foto = base64_encode($details[0]->foto);
				}
				$newTasks->comments=$comments;
				$tasks[]=$newTasks;
			}
			print_r(json_encode($tasks,true)); 
		}
	public function specific_task(){
		
	}
	public function addTask_get(){
		$task_title = $this->get('task_title');
		$task_desc = $this->get('task_desc');
		$task_end = date('Y-m-dTH:i:sZ',strtotime($this->get('task_end')));
		$task_tags = $this->get('task_tags');
		$task_public = $this->get('task_public');
		$task_start = date('Y-m-dTH:i:sZ');
		$userData=$this->session->userdata('userData');
		$usuarioId=$userData[0]->Id;
		$taskAdded = $this->magaModel->insert('avisos_notas',array('titulo'=>$task_title,'inicio'=>$task_start,'fin'=>$task_end,'mensaje'=>$task_desc,'publico'=>$task_public,'idusuario'=>$usuarioId,'etiqueta'=>$task_tags));
		$data = array();
		if($taskAdded){
			$data['status']=true;
		}
		else
		{
			$data['status']=false;	
		}
		print_r(json_encode($data,true));
	}
	public function etiqueta_get(){
		$details=$this->magaModel->selectAll('etiquetas_notas');
		print_r(json_encode($details,true));
	}
	public function addComment_post(){
		$userData=$this->session->userdata('userData');
		$usuarioId=$userData[0]->Id;
		$taskId = $this->post('taskId');
		$commentText = $this->post('commentText');
		$commentId = $this->magaModel->insert('comentarios_de_tareas',array('tareasId'=>$taskId,'comentario_de_texto'=>$commentText,'idusuario'=>$usuarioId,'timestamp'=>Date('Y-m-d')));
		$comments=$this->magaModel->selectComments('comentarios_de_tareas',array('comentarios_de_tareas.id'=>$commentId));
		foreach ($comments as $comment) {
			$details = $this->UsuarioModel->getProfileFoto($comment->USUARIO);
			$comment->foto = base64_encode($details[0]->foto);
		}
		print_r(json_encode($comments));
	}
	public function addTag_post(){
		$tagName = $this->post('tagName');
		$tagColor = $this->post('tagColor');
		$tagId = $this->magaModel->insert('etiquetas_notas',array('descripcion'=>$tagName,'color'=>hexdec($tagColor)));
		$tag=$this->magaModel->selectOne('etiquetas_notas',array('id'=>$tagId),'hex(color) as color,descripcion as tagName');
		print_r(json_encode($tag));
	}
	public function tags_get(){
		$tag=$this->magaModel->selectTags('etiquetas_notas');
		print_r(json_encode($tag));
	}
	public function undoneTasksCount_get()
	{
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->Id;
  		$details=$this->AvisosNotaModel->getUndoneTasksCount($USUARIO);
		print_r(json_encode($details));
	}
}

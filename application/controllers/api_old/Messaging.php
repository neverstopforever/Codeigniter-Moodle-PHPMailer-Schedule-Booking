<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property magaModel $magaModel
 *@property UserMessageModel $UserMessageModel
 */
class Messaging extends MY_Controller {

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
		    $this->load->model('UserMessageModel');
    }
	public function index_get()
	{
		if($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') !='')
		{
			$data=array();
			$data['page']='Messaging';
			$this->load->view('MessagingView',$data);
		}
		else
		{
  			redirect('/auth/login/', 'refresh');
		}
	}

	public function inbox_get()
	{
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->Id;
		$details = $this->UserMessageModel->getInbox($USUARIO);
		print_r(json_encode($details));
	}
	public function sent_get()
	{
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->Id;
		$details = $this->UserMessageModel->getSent($USUARIO);
		print_r(json_encode($details));
	}
	public function add_post(){
		$userData=$this->session->userdata('userData');
		$fromId=$userData[0]->Id;
		$toId = $this->post('to');
		$subject = $this->post('subject');
		$message = $this->post('message');
		$detail=$this->magaModel->insert('usuarios_mensajes',array('FromId'=>$fromId,'ToId'=>$toId,'Subject'=>$subject,'Body'=>$message,'Maildate'=>Date('Y-m-d'),'Read'=>'0'));
		print_r($detail);
	}
	public function notificationCount_get(){
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->USUARIO;
		$details = $this->UserMessageModel->getNotificationCount($USUARIO);
		print_r(json_encode($details));
	}
	public function messageslist_get(){
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->USUARIO;
		$details = $this->UserMessageModel->getMessagesList($USUARIO);
		print_r(json_encode($details));
	}
	public function readUpdate_post(){
		$messageId = $this->post('messageId');
		$read = $this->post('read');
		$detail = $this->magaModel->update('usuarios_mensajes',array('Read'=>$read),array('id'=>$messageId));
		print_r($detail);
	}
}

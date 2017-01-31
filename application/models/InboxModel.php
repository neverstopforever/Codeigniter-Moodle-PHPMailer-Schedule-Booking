<?php
class InboxModel extends MagaModel {
	public function __construct(){
		parent::__construct();
	}
	
	public function dashboard_inbox(){
		$userData=$this->session->userdata('userData');
		$USUARIO=$userData[0]->Id;
		$query="SELECT  
			um.id,
		  um.`Maildate` AS Fecha,
		  usd.`USUARIO` AS Destinatario,
		  um.`Subject` AS Asunto,
		  um.`Read` AS unread,
		  um.`Body` AS body
		 FROM
		  usuarios_mensajes AS um 
		  LEFT JOIN usuarios AS usr 
		    ON um.`ToId` = usr.`Id` 
		  LEFT JOIN usuarios AS usd 
		    ON um.`ToId` = usd.`Id` 
		WHERE um.`ToId` = '".$USUARIO."'
		ORDER BY  um.`Maildate` DESC limit 8
		;";
		return $this->selectCustom($query);
	}
	
	public function professor_inbox($userid){
		//Better change the table name with right naming convension
		$query = "SELECT
			id, 
			date AS Fecha,
		  to_user AS Destinatario,
		  message_title AS Asunto,
		  message_read AS unread,
		  message_contents AS body
		FROM wp_softaula_internal_msg
		WHERE (to_user = '".$userid."' AND parent_id = 0 AND to_del <> 1) 
		OR (from_user = '".$userid."' AND parent_id = 0 AND from_del <> 1) 
		ORDER BY last_date";
		return $this->selectCustom($query);
	}
	
	public function compose_email($id,$data){
		$detail = $this->magaModel->insert('wp_softaula_internal_msg',array(
			'from_user'=>$id,
			'to_user'=>$data['to'],
			'message_title'=>$data['subject'],
			'message_contents'=>$data['message'],
			'parent_id'=>0,
			'date'=>Date('Y-m-d'),
			'message_read'=>'0'));
		return $detail;
	}

	public function student_inbox(){
		return array();
	}
}


<?php

class UsuarioModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "usuarios";
    }

    public function getProfileFoto($usuario = null, $db = null) {

        if(!$usuario){
            return null;
        }
        if($this->checkExistColumn($db)){
            $photo_link = ',photo_link';
        }else{
            $photo_link = '';
        }

        $query= "
				SELECT foto $photo_link
				FROM ".$this->table."
				WHERE usuario = '".$usuario."'
			;";

        return $this->selectCustom($query);
    }
    
    private function checkExistColumn($DB){
        if(!$DB){
            return null;
        }
        $query = "SELECT * 
        FROM information_schema.COLUMNS 
        WHERE 
            TABLE_SCHEMA = '".$DB."' 
        AND TABLE_NAME = 'usuarios' 
        AND COLUMN_NAME = 'photo_link'";

        return $this->custom_sql($query);
    }

    public function getUserPhotoLink($id){
        $query = $this->db->select('photo_link')
            ->from($this->table)
            ->where('Id', $id)
            ->get();
        return $query->row();
    }

    public function updateProfilePhoto($id, $date, $url, $remove = false){
        $data = array(
            'photo_link' => $url
        );
        if($remove){
            $data['foto'] = '';
        }

        $query = $this->db->where('Id', $id)
            ->update($this->table, $data);

        return $query;
    }

    public function getUsers($usuario = null) {

        if(!$usuario){
            return null;
        }

        $query= "
			SELECT USUARIO,id
			FROM usuarios
			WHERE usuario != '".$usuario."'
		;";

        return $this->selectCustom($query);
    }

    public function getProfileInfo($user_id = null) {

        if(!$user_id){
            return null;
        }

        $query= "
			SELECT
				us .id,
				us.nombre AS user_name,
				us.email,
				us.Telefono AS phone_number,
				us.about,
				usg.valor AS group_name,
				us.post_writer,
				us.active AS status,
				us.CLAVEACCESO AS chabi,
				us.owner,
				us.allow_messaging_students,
				us.allow_messaging_teachers
				FROM usuarios AS us
				LEFT JOIN usr_grupos AS usg
				ON us.nivelacceso = usg.id
			WHERE us.id = '".$user_id."'
		;";

        return $this->selectCustom($query);
    }

    public function get_users($where = null){
        $query = $this->db->select('id, usuario AS usr, claveacceso AS pwd, nombre AS user_name,
                                     email, active as status, foto AS photo ')
                          ->from('usuarios');
                         if($where){
                             $query->where($where);
                         }
        return $query->get()->result();
    }

    public function change_user_status($user_id, $status){
        $this->db->where(array('id' => $user_id));
        $result = $this->db->update($this->table, array('active' => $status));
        return $result;
    }
    public function getSmtpSettings($user_id){
        $query = $this->db->select('us.`hostuser` AS `hostname`, us.`smtp` ,
                            us.`port`, us.`user`, us.`pwd`, us.`autenticado` AS `auth_method`, us.`mail_provider` ')
            ->from("$this->table as us")
            ->where(array('id' => $user_id));
        return $query->get()->row();
    }
    public function setSmtpSettings($user_id, $data){
        $this->db->where(array('id' => $user_id));
        $result = $this->db->update($this->table, $data );
        return $result;
    }
    public function update_mail_provider($user_id, $status){
        $this->db->where(array('id' => $user_id));
        $result = $this->db->update($this->table, array('mail_provider' => $status));
        return $result;
    }
    public function get_mail_provider ($user_id){
        $query = $this->db->where(array('id' => $user_id))
            ->select('mail_provider' )
            ->from($this->table);
        return $query->get()->row();
    }
    public function conut_active_users(){
        $query = $this->db->where(array('active' => 1))
                           ->get($this->table);
        $result = $query->num_rows();
        return $result;
    }

    public function get_active_users_for_select(){
        $query = "SELECT id, nombre AS user_name, email, Telefono
                    FROM usuarios
                    WHERE active = 1
                    ORDER BY 2
                    ;";
        return $this->selectCustom($query);
    }

    public function get_active_users_for_select_msg(){
        $query = "SELECT id, nombre AS user_name, email, Telefono
                    FROM usuarios
                    WHERE active = 1 AND allow_messaging_students = 1
                    ORDER BY 2
                    ;";
        return $this->selectCustom($query);
    }

    public function varifyLogin($username = null, $password = null){

        if(!$username || !$password){
            return false;
        }

        $data = array(
            'usuario' => $username,
            'claveacceso' => $password
        );
        $this->db->from($this->table);

        $this->db->where($data);
        $result = $this->db->get();

        return $result->result();
    }

    public function getById($user_id = null){

        if(!$user_id){
            return false;
        }

        $data = array(
            'id' => $user_id
        );
        $this->db->from($this->table);

        $this->db->where($data);
        $result = $this->db->get();

        return $result->result();
    }

    public function getRecords($customer_table){
       $query = "SELECT 
                SUM(table_rows) AS 'Num_rows'
                FROM information_schema.TABLES 
                WHERE table_schema = '".$customer_table."'
                AND table_rows>0
                ";
        return $this->selectCustom($query);
    }

    public function getUserDataById($user_id){
        $query = $this->db->select('id, nombre AS full_name,
                                     email AS email1, allow_messaging_students, allow_messaging_teachers')
                          ->from($this->table)
                          ->where('id', $user_id)
                          ->get();

        return $query->row();
    }
}
<?php

class UserAdminModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "user_admin"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function verifyLogin($username = null, $password = null) {

        if (!$username || !$password) {
            return null;
        }
        $this->_db->select('*');
        $this->_db->from( $this->table);
        $password = sha1($password . $this->config->item('encryption_key'));
        $this->_db->where(array('user_admin.user'=>$username, 'user_admin.`pwd_akaud`'=> $password));
        $query = $this->_db->get();

        return $query->result();
    }
}
<?php

class GrupoClientModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "grupoclientes"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function getAll() {
        $this->_db->select('*');
        $this->_db->from($this->table);
        $res = $this->_db->get();
        return $res->result();
    }
}
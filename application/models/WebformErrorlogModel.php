<?php

class WebformErrorlogModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "webform_errorlog";
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function addItem($data) {
        if (empty($data)
            || !isset($data['apikey']) || empty($data['apikey'])
            || !isset($data['datetime']) || empty($data['datetime'])){
            return false;
        }

        return $this->_db->insert($this->table, $data);
    }
}
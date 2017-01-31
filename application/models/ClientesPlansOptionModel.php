<?php

class ClientesPlansOptionModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_plans_options";
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function getOptions() {
        $this->_db->select("*");
        $this->_db->from($this->table);
        $res = $this->_db->get();
        return $res->result();
    }

    public function getOptionsByValue($option_value = null) {
        if(empty($option_value)){
            return null;
        }
        $this->_db->select("*");
        $this->_db->from($this->table);
        $this->_db->where('option_value', $option_value);
        $this->_db->distinct();
        $res = $this->_db->get();
        return $res->result();
    }

    public function addItem($data = array()) {
        if (empty($data)) {
            return null;
        }
        $data_insert = array(
            'option_name' => (isset($data['option_name'])) ? $data['option_name'] : null,
            'option_value' => (isset($data['option_value'])) ? $data['option_value'] : null,
        );
        $this->_db->insert($this->table, $data_insert);
        return $this->_db->insert_id();
    }
}
<?php

class ClientesPortaleModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_portales";
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function getDbDetailsByApiKey($api_key = null) {
        if (empty($api_key)){
            return false;
        }
        $this->_db->select('ca.*');
        $this->_db->from('clientes_portales AS cp');
        $this->_db->join('clientes_akaud AS ca', 'cp.idcliente = ca.CCODCLI', 'LEFT');
        $this->_db->where('cp.apikey', $api_key);
        $result = $this->_db->get();
        // print_r($result-db->queries);
        return $result->result();
    }
}
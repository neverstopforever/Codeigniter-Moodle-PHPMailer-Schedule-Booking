<?php

class ClientesImpuestoModel extends MagaModel {


    public function __construct() {
        parent::__construct();
        $this->table = "clientes_impuestos";
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->db = $this->load->database($this->_db_name, true);
    }
    public function get_all(){
        $this->db->select('id,concepto AS vat_name, porcentaje AS `percent_vat`');
        $this->db->from($this->table);
        $this->db->order_by(3);
        $res = $this->db->get();        
        return $res->result();
    }

}
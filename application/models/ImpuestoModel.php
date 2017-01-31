<?php

class ImpuestoModel extends MagaModel {


    public function __construct() {
        parent::__construct();
        $this->table = "impuestos";
    }
    public function get_all(){
        $this->db->select('id,concepto AS vat_name, porcentaje AS `percent_vat`');
        $this->db->from($this->table);
        $this->db->order_by(3);
        $res = $this->db->get();        
        return $res->result();
    }

}
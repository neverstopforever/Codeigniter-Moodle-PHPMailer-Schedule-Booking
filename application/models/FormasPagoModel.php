<?php

class FormasPagoModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "formaspago";
    }

    public function getMethods(){
        $query = $this->db->select('Codigo AS id, Descripcion AS descripcion')
                          ->from($this->table)
                          ->get();
        return $query->result();
    }

}
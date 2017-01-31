<?php

class ErpConsultaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_consultas";
    }

    public function getField($field = null, $ref = "lst_empresas") {

        if(!$field){
            return null;
        }

        $query = "SELECT " . $field . " FROM erp_consultas WHERE ref = '".$ref."'";

        return $this->selectCustom($query);
    }
}
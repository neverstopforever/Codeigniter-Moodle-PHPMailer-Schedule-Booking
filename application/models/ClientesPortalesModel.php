<?php

class ClientesPortalesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_portales"; //admin_akaud table
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function getSources($idcliente = null) {

        if(empty($idcliente) || !is_numeric($idcliente)){
            return null;
        }
        $query = "
            SELECT cp.`apikey`, IF(cp.title  IS NULL, po.`portal`,cp.title) AS title, cp.idportal
                    FROM clientes_portales AS cp
                    LEFT JOIN portales AS po
                    ON cp.`idportal` = po.`idportal`
                    WHERE idcliente = '".$idcliente."'
                    AND activo=1;
                                ";
        $res = $this->_db->query($query);

        return $res->result();
    }

    public function getCheckApiKey($idcliente = null, $api_key = null ) {

        if(empty($idcliente) || !is_numeric($idcliente) || empty($api_key)){
            return null;
        }
        $query = "
            SELECT cp.`apikey`, IF(cp.title  IS NULL, po.`portal`,cp.title) AS title
                    FROM clientes_portales AS cp
                    LEFT JOIN portales AS po
                    ON cp.`idportal` = po.`idportal`
                    WHERE idcliente = '".$idcliente."'
                    AND cp.`apikey`='".$api_key."'
                    AND activo=1;
                                ";
        $res = $this->_db->query($query);

        return $res->result();
    }
}
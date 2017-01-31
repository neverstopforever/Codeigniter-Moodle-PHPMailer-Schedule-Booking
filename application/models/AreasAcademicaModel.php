<?php

class AreasAcademicaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "areas academicas";
    }

    public function getAreaAcademica() {

        $query = "SELECT id, valor FROM `areas academicas` ORDER BY 2";

        return $this->selectCustom($query);
    }

    public function getAdicionales($id = null) {
        if(is_null($id)){
            return null;
        }
       $query = $this->db->select('*')
                         ->from('clientes_tab_ad')
                         ->where('ccodcli', $id)
                         ->get();
        return $query->result();
    }

    public function getPersonalizedFields(){

    }

    public function adicionalesAdd($id = null, $areaacademica = null, $comments = null, $fecha = null) {
        if(!$id){
            return null;
        }
        $query = "
            INSERT INTO `clientes_tab_ad` ( `CCodCli`,`area academica`, `comments`, `fecha`) VALUES ('$id', '$areaacademica',  '$comments','$fecha');
        ";

        return $this->insertCustom($query);
    }

    public function adicionalesUpdate($id = null, $areaacademica = null, $comments = null, $fecha = null) {
        if(!$id){
            return null;
        }
        $query = "
            UPDATE `clientes_tab_ad` SET `area academica`='$areaacademica', `comments`='$comments', `fecha`='$fecha' WHERE (`CCodCli`='$id');
        ";

        return $this->insertCustom($query);
    }

    public function getAcademicYears(){
        $query = "SELECT  id, valor AS title FROM
                          `año escolar`
                          ORDER BY 2
                          ";
        return $this->selectCustom($query);
    }
    
}
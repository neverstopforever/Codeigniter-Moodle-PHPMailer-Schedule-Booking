<?php

class LstInformeModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "lst_informes";
    }

    public function getInformes($id = null) {
        if(!$id){
            return null;
        }
        return  $this->selectOne($this->table,array('id'=>$id));
    }

    public function getAllWhere($idsec = null) {
        if(!$idsec){
            return null;
        }
        return $this->selectAllWhere($this->table,array('idseccion'=>$idsec));
    }
}
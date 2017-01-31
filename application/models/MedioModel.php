<?php

class MedioModel extends MagaModel {

    public $IdMedio;
    public $Descripcion;

    public function __construct() {
        parent::__construct();
        $this->table = "medios";
    }

    public function getAll(){
        $query = $this->db->select('*')
                          ->from($this->table);
        $query->order_by('2');
        return $query->get()->result();
    }

    public function getSourceForFilter(){
        $query = $this->db->select('IdMedio AS id, Descripcion AS text')
                          ->from($this->table);
        $query->order_by('2');
        return $query->get()->result();
    }

    public function getNotExistMedios($client_id){
        if(!$client_id){
            return null;
        }
        $query = "SELECT
                      idmedio AS `source_id`,
                      descripcion AS `source`
                    FROM medios
                    WHERE idmedio NOT IN
                          (
                            SELECT medio FROM presupuestot WHERE numpresupuesto = $client_id
                            AND medio IS NOT NULL
                          )
                    ;";
        return  $this->selectCustom($query);
    }
}
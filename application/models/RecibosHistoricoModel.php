<?php

class RecibosHistoricoModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "recibos_historico";
    }

    //insert item
    public function insertItem($data){
        if(empty($data)){
            return false;
        }
        
        $insert_data['num_recibo'] = isset($data['num_recibo']) ? $data['num_recibo']: null;
//        $insert_data['estado'] = isset($data['estado']) ? $data['estado']: 1;
        $insert_data['estado'] = 1;
//        $insert_data['timeorder'] = isset($data['timeorder']) ? $data['timeorder']: time();
        $insert_data['timeorder'] = date('Y-m-d H:i:s');
        $insert_data['fecha'] = isset($data['fecha']) ? date('Y-m-d', strtotime($data['fecha'])): null;
        
        return $this->insert($this->table,$insert_data);
    }
}
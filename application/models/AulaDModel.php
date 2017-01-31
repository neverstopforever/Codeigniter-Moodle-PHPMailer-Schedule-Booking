<?php

class AulaDModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "aula_d";
    }

    public function insertAulas($data){
        return $this->db->insert_batch($this->table, $data);
    }

    public function deleteAulas($data){
        return $this->db->delete($this->table, $data);
    }
}
<?php

class LstConsultaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "lst_consultas";
    }

    public function getCsql($id_cat) {
        $query = $this->db->query("SELECT `valor` AS `csql`
                                FROM `lst_consultas`
                                WHERE `id_cat` = '$id_cat'
                                ;
                                ");
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
    }

}
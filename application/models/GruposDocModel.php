<?php

class GruposDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "grupos_doc";
    }

    public function getByGroupId($id) {
        $query = $this->db->select("id, codigogrupo AS group_id, nombre AS name, documento, doclink, visible, (SELECT count(*) FROM ".$this->table." WHERE  codigogrupo='".$id."') AS doc_count")
                           ->from($this->table)
                           ->where('codigogrupo', $id)
                           ->get();

        return $query->result();
    }


}
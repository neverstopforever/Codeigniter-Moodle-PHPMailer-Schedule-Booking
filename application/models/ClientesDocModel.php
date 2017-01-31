<?php

class ClientesDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_doc";
    }

    public function getDocumentos($id) {

        if (!$id) {
            return null;
        }

        $query = "
            SELECT
            id,
            fecha,
            nombre,
            doclink,
            IF(visible IS NULL OR visible = 0,'NO','SI') AS visible
            FROM
            clientes_doc
            WHERE idcliente = $id;
            ";

        return $this->selectCustom($query);
    }
}
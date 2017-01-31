<?php

class LstInformesSecModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "lst_informes_sec";
    }

    public function getCategorias() {
        return  $this->selectAll($this->table);
    }
}
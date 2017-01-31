<?php

class ErpMappingAliasModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_mapping_alias";
    }
}
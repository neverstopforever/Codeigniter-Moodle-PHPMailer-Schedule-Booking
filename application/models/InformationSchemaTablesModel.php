<?php

class InformationSchemaTablesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "information_schema.tables";
    }

    public function getCount($db_name = null) {

        if (!$db_name) {
            return null;
        }
        $sql = "SELECT COUNT(*) AS COUNT
                FROM information_schema.tables
                WHERE table_name = 'agenda_tab_ad'
                AND table_schema='".$db_name."'";

        return $this->selectCustom($sql);
    }

}
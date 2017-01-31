<?php

class PresupuestoRuleModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuesto_rules";
    }

    public function getCsql() {

        $query = '
            SELECT `csql` FROM `presupuesto_rules` WHERE `active` = 1';

        return  $this->selectCustom($query);
    }

}
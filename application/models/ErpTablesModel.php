<?php

class ErpTablesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_tables";
    }

    public function getTables($where = array(), $fields = array()) {
        $str_fields = '*';
        if(!empty($field)){
            $str_fields = '';
            foreach($fields as $field ){
                $str_fields .= $field.',';
            }

        }
        rtrim($str_fields, ',');

        $this->db->select($str_fields);
        if(!empty($where)) {
            $this->db->where($where);
        }

       $result =  $this->db->get($this->table)->result();

        return $result;
    }

    public function getTableFields($tableName){
        $fields = $this->db->field_data($tableName);
        return $fields;
    }

    public function checkingUniqueId($tableName, $where){
        $query = $this->db->select('*')
                          ->where($where)
                          ->from($tableName)
                          ->get();
        return $query->row();
    }
}
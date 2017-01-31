<?php

class GruposTabAdModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "grupos_tab_ad";
    }

    public function getByGroupId($id) {
        $result = array();
        if($this->db->table_exists($this->table)) {
            $query = $this->db->select('*')
                ->from($this->table)
                ->where('codigogrupo', $id)
                ->get();
            $result = $query->row();
        }

        return $result;
    }

    public function getFieldList(){
        $fields = array();
        if($this->db->table_exists($this->table)) {
            $fields = $this->db->field_data($this->table);
        }
        return $fields;
    }

    public function updateFormData($form_data, $id){
        $result = $this->update($this->table, $form_data, array('codigogrupo' => $id));
        return $result;
    }

    public function insertFormData($form_data){
        $result = false;
        if($this->db->table_exists($this->table)) {
            $result = $this->insert($this->table, $form_data);
        }
        return $result;
    }

/*    public function deleteClient($id){
        $result = $this->delete($this->table, array('ccodcli' => $id));
        return $result;
    }*/

    public function deleteItem($id_group){
        if(!$this->db->table_exists($this->table)){
            return true;
        }
        $this->db->where('codigogrupo', $id_group);
        return $this->db->delete($this->table);
    }
}
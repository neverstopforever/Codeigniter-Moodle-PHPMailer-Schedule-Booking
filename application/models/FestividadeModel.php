<?php

class FestividadeModel extends MagaModel {

    public $Fecha;
    public $Descripcion;
    public $IdCentro;

    public function __construct() {
        parent::__construct();
        $this->table = "festividades";
    }

    public function getAll(){
        return $this->selectAll($this->table);
    }

    //get item by Id
    public function get_itemById($item_id = null){
        if(empty($item_id)){
            return false;
        }
        $where = array(
            'id'=>$item_id
        );
        return $this->selectOne($this->table, $where);
    }

    //update item
    public function update_item($new_data = null, $item_id = null){
        if(empty($item_id) || !is_numeric($item_id) || empty($new_data)
         || !isset($new_data['Fecha'])
         || !isset($new_data['Descripcion'])
//         || !isset($new_data['IdCentro'])
            ){
            return false;
        }
        $data = array(
            'Fecha'=>date('Y-m-d H:i:s', strtotime($new_data['Fecha'])),
            'Descripcion'=>$new_data['Descripcion'],
//            'IdCentro'=>$new_data['IdCentro']
        );
        $where = array(
            'id'=>$item_id
        );
        return $this->update($this->table,$data,$where);
    }

    //add item
    public function add_item($data = array()){

        if(empty($data)
             || !isset($data['Fecha'])
             || !isset($data['Descripcion'])
//             || !isset($data['IdCentro'])
           ){
            return false;
        }

        $data = array(
            'Fecha'=>date('Y-m-d H:i:s', strtotime($data['Fecha'])),
            'Descripcion'=>$data['Descripcion'],
//            'IdCentro'=>$data['IdCentro']
        );

       $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    //delete item
    public function delete_item($item_id = null){
        if(empty($item_id) || !is_numeric($item_id)){
            return false;
        }
        $where = array(
            'id'=>$item_id
        );
        return $this->delete($this->table,$where);
    }
}
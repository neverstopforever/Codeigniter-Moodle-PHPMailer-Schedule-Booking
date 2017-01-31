<?php

class ScResourcePostGroupModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_post_group";
    }

    public function deleteByResourceGroupId($resource_group_id, $teacher_id){
        if(empty($resource_group_id) || empty($teacher_id)){
            return false;
        }
        $where = array(
            'resource_group_id'=>$resource_group_id, 
            'teacher_id'=>$teacher_id
        );
        return $this->delete($this->table, $where);
    }

    public function get_post($gid,$authid){
        $sql = "SELECT $this->table.*, profesor.nombre FROM $this->table LEFT join profesor on "
            . "$this->table.teacher_id = profesor.INDICE WHERE "
            . "$this->table.resource_group_id = '$gid' AND "
            . "$this->table.teacher_id= '$authid'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function add($data = null){
        if(empty($data)){
            return false;
        }
        $insert_data = array(
            'resource_group_id'=> isset($data['resource_group_id']) ? $data['resource_group_id'] : null,
            'teacher_id'=> isset($data['teacher_id']) ? $data['teacher_id'] : null,
            'comments'=> isset($data['comments']) ? $data['comments'] : null,
            'created_date'=> date('Y-m-d h:i:s')
        );
        $this->db->insert($this->table, $insert_data);
        return $this->db->insert_id();
    }
    
    public function getInfoWithProfesor($id){
        if(empty($id)){
            return false;
        }       
        $sql = "SELECT $this->table.*, profesor.nombre FROM $this->table LEFT join profesor on "
            . "$this->table.teacher_id = profesor.INDICE WHERE "
            . "$this->table.id = '$id'";
        $query = $this->db->query($sql);
        return $query->row();
    }
   
}
<?php
class ResourcePostGroupModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_post_group";
    }
    
    public function get_post($gid,$authid){
        $sql = "SELECT $this->table.*, profesor.nombre FROM $this->table LEFT join profesor on "
                . "$this->table.teacher_id = profesor.INDICE WHERE "
                . "$this->table.resource_group_id = '$gid' AND "
                . "$this->table.teacher_id= '$authid'";
        $query = $this->db->query($sql);
	return $query->result();
    }
    
    public function add($data){
        $data['created_date'] = Date('Y-m-d h:i:s');
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();
         $sql = "SELECT $this->table.*, profesor.nombre FROM $this->table LEFT join profesor on "
                . "$this->table.teacher_id = profesor.INDICE WHERE "
                . "$this->table.id = '$id'";
        $query = $this->db->query($sql);
        return $query->row();
    }
}
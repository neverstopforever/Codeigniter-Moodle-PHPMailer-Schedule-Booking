<?php
class ScResourceTemplateModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_template";
    }

    public function deleteByTemplateId($template_id){
        if(empty($template_id)){
            return false;
        }
        $where = array(
            'template_id'=>$template_id
        );
        return $this->delete($this->table, $where);
    }

    public function get_resource_id($template_id){
        if(empty($template_id)){
            return false;
        }
        $where = array(
            'template_id'=>$template_id
        );
        $this->db->select('resource_id');
        $this->db->where($where);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    
    public function getResourceTemplateByTemplateId($template_id){
        if(empty($template_id)){
            return false;
        }
        $where = array(
            'template_id'=>$template_id
        );
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function addItem($data){
        if(empty($data)){
            return false;
        }
        $insert_data  = array(
            'resource_id'=> isset($data['resource_id']) ? $data['resource_id'] : null,
            'template_id'=> isset($data['template_id']) ? $data['template_id'] : null
        );
        return $this->insert($this->table, $insert_data);
    }
}
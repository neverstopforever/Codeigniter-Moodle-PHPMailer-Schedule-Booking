<?php

class ScResourceGroupItemsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_group_items";
    }

    public function deleteByResourceGroupId($resource_group_id){
        if(empty($resource_group_id)){
            return false;
        }
        $where = array(
            'resource_group_id'=>$resource_group_id
        );
        return $this->delete($this->table, $where);
    }

    public function deleteById($id){
        if(empty($id)){
            return false;
        }
        $where = array(
            'id'=>$id
        );
        return $this->delete($this->table, $where);
    }

    public function getItemByResourceGroupId($resource_group_id){
        if(empty($resource_group_id)){
            return false;
        }
        $where = array(
            'resource_group_id'=>$resource_group_id
        );
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getItemsByResourceGroupId($resource_group_id){
        if(empty($resource_group_id)){
            return false;
        }
        $where = array(
            'resource_group_id'=>$resource_group_id
        );
        $this->db->select($this->table.'.*, 
                sc_resources.title, 
                sc_resources.description, 
                sc_resources.available, 
                sc_resources.resource_type_id, 
                sc_resources.aws_link');
        $this->db->join('sc_resources', 'sc_resources.id = '.$this->table.'.resource_id', 'left');
        $this->db->where($where);
//        $this->db->where(array('sc_resources.available'=>1));
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function addItem($data){
        if(empty($data)){
            return false;
        }
        $insert_data  = array(
            'resource_id'=> isset($data['resource_id']) ? $data['resource_id'] : null,
            'resource_group_id'=> isset($data['resource_group_id']) ? $data['resource_group_id'] : null
        );
        return $this->insert($this->table, $insert_data);
    }
    
    public function updateItem($data, $id){
        if(empty($data) || empty($id)){
            return false;
        }
        $update_data = array();
        if(isset($data['resource_id'])){
            $update_data['resource_id'] = $data['resource_id'];
        }
        if(isset($data['resource_group_id'])){
            $update_data['resource_group_id'] = $data['resource_group_id'];
        }
        if(isset($data['start_date'])){
            $update_data['start_date'] = date('Y-m-d',strtotime($data['start_date']));
        }
        if(isset($data['end_date'])){
            $update_data['end_date'] = date('Y-m-d',strtotime($data['end_date']));
        }
        if(isset($data['comments'])){
            $update_data['comments'] = $data['comments'];
        }
        if(empty($update_data)){
            return false;
        }
        return $this->update($this->table, $update_data, array('id'=>$id));
    }


    public function getListByResourceGroupId($resource_group_id = null){
        if(!$resource_group_id){
            return false;
        }
        $query = "SELECT            
              scrt.`title` AS resource_type,
              scr.`title` AS resource_title,
              scgi.`start_date`,
              scgi.`end_date`,
              scr.`aws_link`,
             `scrt`.`title` AS `type`

            
            FROM
              sc_resource_group_items AS scgi
              LEFT JOIN sc_resources AS scr
                ON scgi.`resource_group_id` = scr.`id`
              LEFT JOIN sc_resource_type AS scrt
                ON scr.`resource_type_id` = scrt.`id`
            WHERE scgi.`resource_group_id` ='".$resource_group_id."'
                 AND (CURDATE() BETWEEN scgi.`start_date`  AND scgi.`end_date`)
            ORDER BY 1, 3,4;";

        return $this->selectCustom($query);
    }
}
<?php

class ScResourceGroupPlanningModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_group_planning";
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
    
    public function getItemByResourceGroupId($resource_group_id){
        if(empty($resource_group_id)){
            return false;
        }
        $where = array(
            'resource_group_id' => $resource_group_id
        );
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function addItem($data){
        if(empty($data)){
            return false;
        }
        $insert_data = array(
            'resource_group_id' => isset($data['resource_group_id']) ? $data['resource_group_id']: null,
            'comments' => isset($data['comments']) ? $data['comments']: null,
            'start_date' => isset($data['start_date']) ? date('Y-m-d H:i:s', strtotime($data['start_date'])) : null,
            'end_date' => isset($data['end_date']) ? date('Y-m-d H:i:s', strtotime($data['end_date'])) : null,
            'last_update' => date('Y-m-d H:i:s')
        );
        return $this->insert($this->table, $insert_data);
    }

    public function updateItemByResourceGroupId($data, $resource_group_id){
        if(empty($data) || empty($resource_group_id)){
            return false;
        }
        $where = array(
            'resource_group_id' => $resource_group_id
        );
        $update_data = array();
        if(isset($data['comments'])){
            $update_data['comments'] = $data['comments'];
        }
        if(isset($data['start_date'])){
            $update_data['start_date'] = date('Y-m-d H:i:s', strtotime($data['start_date']));
        }
        if(isset($data['end_date'])){
            $update_data['end_date'] = date('Y-m-d H:i:s', strtotime($data['end_date']));
        }
        
        if(empty($update_data)){
            return false;
        }
        $update_data['last_update'] = date('Y-m-d H:i:s');
        return $this->update($this->table, $update_data, $where);
    }
   
}
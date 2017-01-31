<?php

class ScResourceGroupItemModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_group_item";
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
   
}
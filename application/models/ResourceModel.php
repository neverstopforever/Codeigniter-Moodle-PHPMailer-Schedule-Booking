<?php
class ResourceModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resources";
    }
    
    public function getlist(){
        $this->db->select('`sc_resources`.`id` as `id`,`sc_resources`.`title` as `title`,`sc_resources`.`aws_link` as `link`, `sc_resources`.`available` as available, `sc_resource_type`.`title` as `type`');
        //how to use $this->table for join ???
        $this->db->join('sc_resource_type', '`sc_resources`.`resource_type_id` = `sc_resource_type`.`id`','left');
        $query = $this->db->get($this->table);
	return $query->result();
    }
    
    public function add($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function deleteItem($resource_id = null){
        if(empty($resource_id)){
            return false;
        }        
        return $this->delete($this->table, array('id'=>$resource_id));
    }
    
    public function editItem($data, $resource_id = null){
        if(empty($data) || empty($resource_id)){
            return false;
        }
        $edit_data = array(
            'title' => isset($data['title']) ? $data['title'] : null,
            'available' => isset($data['available']) ? $data['available'] : null
        );
        return $this->update($this->table, $edit_data, array('id'=>$resource_id));
    }

    public function getItemAwsLink($id){
        $query = $this->db->select('aws_link')
                          ->from($this->table)
                          ->where('id', $id)
                          ->get();

        return $query->row();
    }
}

?>
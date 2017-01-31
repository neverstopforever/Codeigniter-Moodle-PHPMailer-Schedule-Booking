<?php
class ResourceGroupModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_group";
    }
    
    public function getlist(){
        $this->db->select($this->table.'.*, sc_resource_group_planning.start_date,sc_resource_group_planning.end_date,sc_resource_group_planning.comments,grupos.Descripcion AS grupo');
        $this->db->join('grupos', '`grupos`.`codigogrupo` = `'.$this->table.'`.`group_id`','left');
        $this->db->join('sc_resource_group_planning', '`sc_resource_group_planning`.`resource_group_id` = `'.$this->table.'`.`id`','left');
        $query = $this->db->get($this->table);

	    return $query->result();
    }
    
    public function getResourceList($where = null){
        $this->db->select($this->table.'.*, grupos.Descripcion AS grupo');
        $this->db->join('grupos', '`grupos`.`codigogrupo` = `'.$this->table.'`.`group_id`','left');
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get($this->table);

	    return $query->result();
    }

    public function updateItemById($data, $id){
        if(empty($data) || empty($id)){
            return false;
        }
        $where = array(
            'id' => $id
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
        return $this->update($this->table, $update_data, $where);
    }
    
//    public function getById($id = null){
//        if(empty($id) || !is_numeric($id)){
//            return false;
//        }
//        $this->db->select($this->table.'.*, sc_resource_group_planning.start_date,sc_resource_group_planning.end_date,sc_resource_group_planning.comments,grupos.Descripcion AS grupo');
//        $this->db->join('grupos', '`grupos`.`codigogrupo` = `'.$this->table.'`.`group_id`','left');
//        $this->db->join('sc_resource_group_planning', '`sc_resource_group_planning`.`resource_group_id` = `'.$this->table.'`.`id`','left');
//        $this->db->where($this->table.'.id', $id);
//        $query = $this->db->get($this->table);
//	    return $query->result();
//    }
    public function getById($id = null){
        if(empty($id) || !is_numeric($id)){
            return false;
        }
        $this->db->select($this->table.'.*, grupos.Descripcion AS grupo');
        $this->db->join('grupos', '`grupos`.`codigogrupo` = `'.$this->table.'`.`group_id`','left');
        $this->db->where($this->table.'.id', $id);
        $query = $this->db->get($this->table);
	    return $query->result();
    }
    
    public function add($data){
         $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function addItem($data = null){
        if(empty($data)){
            return false;
        }
        $insert_data = array(
            'title' => isset($data['title']) ? $data['title'] : null,
            'course_id' => isset($data['course_id']) ? $data['course_id'] : null,
            'group_id' => isset($data['group_id']) ? $data['group_id'] : null,
            'teacher_id' => isset($data['teacher_id']) ? $data['teacher_id'] : null,
        );         
        return $this->insert($this->table, $insert_data);
    }
    
    public function deleteItem($id = null, $teacher_id = null){

        if(empty($id) || empty($teacher_id)){
            return false;
        }
        $where = array(
            'id' => $id,
            'teacher_id' => $teacher_id
        );
        $deleted = $this->delete($this->table,  $where);
        return $deleted;
    }
    
    public function get_resource_group($gId){
        $this->db->select('resource_id,id')
                ->group_by('resource_id');
        $query = $this->db->get_where('sc_resource_group_items',array('resource_group_id'=>$gId));        
        
        return $query->result();
    }
    
    public function exist($grpId,$authid){
        $this->db->select('id');
        $this->db->where($this->table.'.id',$grpId);
        $this->db->where($this->table.'.teacher_id',$authid);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function save_resource_group_batch($grpId,$data){
        $this->db->delete('sc_resource_group_items', array('resource_group_id' => $grpId)); 
        return $this->db->insert_batch('sc_resource_group_items', $data);
    }
    
    public function import_save_resource($data){
        return $this->db->insert_batch('sc_resource_group_items', $data);
    }
    
    public function delete_resource($id,$authid){
         $this->db->where('sc_resource_group_items.id',$id);
        return $this->db->delete('sc_resource_group_items');
    }

    public function editItem($data, $resource_group_id = null, $teacher_id = null){
        if(empty($data) || empty($resource_group_id) || empty($teacher_id)){
            return false;
        }
        $edit_data = array(
            'title' => isset($data['title']) ? $data['title'] : null
        );
        return $this->update($this->table, $edit_data, array('id'=>$resource_group_id, 'teacher_id'=>$teacher_id));
    }

    public function getDataById($id){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('id', $id)
                          ->get();

        return $query->row();
    }
}
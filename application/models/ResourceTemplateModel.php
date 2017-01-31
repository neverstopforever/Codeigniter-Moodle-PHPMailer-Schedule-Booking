<?php
class ResourceTemplateModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_templates";
    }
    
    public function getlist(){
        $query = $this->db->get($this->table);
	    return $query->result();
    }
    
    public function getByTeacherId($teacher_id){
        if(!$teacher_id){
            return false;
        }
        $this->db->where('teacher_id', $teacher_id);
        $query = $this->db->get($this->table);
	    return $query->result();
    }
    
    public function add($data = null){
        if(empty($data)){
            return false;
        }
        $insert_data = array(
            'title' => isset($data['title']) ? $data['title']: null,
            'teacher_id' => isset($data['teacher_id']) ? $data['teacher_id']: null
        );        
        return $this->insert($this->table, $insert_data);
    }
    
    public function edit($data,$id,$authid){
        $this->db->where($this->table.'.id',$id);
        $this->db->where($this->table.'.teacher_id',$authid);
	return $this->db->update($this->table, $data);
    }
   
    public function editItem($data, $template_id = null, $teacher_id = null){
        if(empty($data) || empty($template_id) || empty($teacher_id)){
            return false;
        }
        $edit_data = array(
            'title' => isset($data['title']) ? $data['title'] : null
        );
        return $this->update($this->table, $edit_data, array('id'=>$template_id, 'teacher_id'=>$teacher_id));
    }
    
    public function deleteItem($id = null, $teacher_id = null){
        if(empty($id) || empty($teacher_id)){
            return false;
        }
        $where = array(
            'id'=>$id,
            'teacher_id'=>$teacher_id,
        );
        //Delete associated table data info too
        return $this->delete($this->table, $where);
    }
    
    public function get_resource_template($tId){
        $this->db->select('resource_id');
        $query = $this->db->get_where('sc_resource_template',array('template_id'=>$tId));
        return $query->row();
    }
    
    public function save_resource_template($tId,$data){
        //Check template id is of same teacher session or not
        $query = $this->db->get_where('sc_resource_template',array('template_id'=>$tId));
        $result = $query->result();
        if ($result !== false && count($result) > 0) {
            $this->db->where('sc_resource_template.template_id',$tId);
            return $this->db->update('sc_resource_template', $data);
        }else{
            return $this->db->insert('sc_resource_template', $data);
        }
    }
    
    public function get_all_resource_template($tId){
        //Check template created by the teacher or not
        $this->db->select('resource_id');
        $query = $this->db->get_where('sc_resource_template',array('template_id'=>$tId));
        return $query->row();
    }
}?>
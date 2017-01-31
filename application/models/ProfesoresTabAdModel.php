<?php

class ProfesoresTabAdModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "profesor_tab_ad";
    }

    public function getByTeacherId($teacher_id) {
        $result = array();
        if($this->db->table_exists($this->table)) {
            $query = $this->db->select('*')
                ->from($this->table)
                ->where('Indice', $teacher_id)
                ->get();

            $result =$query->row();
            }
        return $result;

    }

    public function getFieldList(){
        $fields = array();
        if ($this->db->table_exists($this->table)) {
            $fields = $this->db->field_data($this->table);
        }
        return $fields;
    }

    public function updateFormData($form_data, $teacher_id){
        $result = false;
        if($this->db->table_exists($this->table)) {
            $result = $this->update($this->table, $form_data, array('Indice' => $teacher_id));
            return $result;
        }
    }

    public function insertFormData($form_data){
        $result = false;
        if($this->db->table_exists($this->table)) {
            $result = $this->insert($this->table, $form_data);
        }
        return $result;
    }

    public function deleteTeacher($teacher_id){
        if(!$this->db->table_exists($this->table)){
            return true;
        }
        $result = $this->delete($this->table, array('Indice' => $teacher_id));
        return $result;
    }


    public function get_personalized_data($id = null) {
        $result_data = array();
        if(!$this->db->table_exists($this->table)){
            return $result_data;
        }
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->getByTeacherId($id);
        }

        $personalized_fields = $this->getFieldList();

        if(count($personalized_fields) > 1){
            foreach($personalized_fields as $fields) {
                if (!$fields->primary_key){
                    switch ($fields->type) {
                        case "longtext":
                            $type = "textarea";
                            break;
                        case "date":
                            $type = "date";
                            break;
                        default:
                            $type = "text";
                    }
                    $result_data[] = (object)array(
                        'name' => $fields->name,
                        'type' => $type,
                        'value' => isset($personalized_data[$fields->name]) ? $personalized_data[$fields->name] : ''

                    );
                }
            }
        }
        return $result_data;
    }
}
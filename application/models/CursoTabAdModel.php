<?php


class CursoTabAdModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'curso_tab_ad';
    }

    public function getByCourseId($id) {
        $result = array();
        if ($this->db->table_exists($this->table) ) {
            $query = $this->db->select('*')
                ->from($this->table)
                ->where('codigo', $id)
                ->get();

            $result = $query->row();
        }
        return $result;
    }


    public function getFieldList(){
        $fields = array();
        if($this->db->table_exists($this->table)) {
            $fields = $this->db->field_data($this->table);
        }
        return $fields;
    }

    public function insertFormData($data = array()){
        if(empty($data) || !$this->db->table_exists($this->table)){
            return false;
        }
        return $this->db->insert($this->table, $data);
    }


    public function updateFormData($form_data, $id){
        if(empty($form_data) || empty($id) || !$this->db->table_exists($this->table)){
            return false;
        }
        return $this->update($this->table, $form_data, array('codigo' => $id));
    }


    public function get_personalized_data($id = null) {
        $result_data = array();
        if(!$this->db->table_exists($this->table)){
            return $result_data;
        }
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->getByCourseId($id);
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
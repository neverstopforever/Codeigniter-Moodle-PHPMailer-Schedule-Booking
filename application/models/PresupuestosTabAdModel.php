<?php


class PresupuestosTabAdModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'presupuestos_tab_ad';
    }

    public function getTotalCount() {
        if($this->db->table_exists($this->table)) {
            $this->db->from($this->table);
            return $this->db->count_all_results();
        }else{
            return 0;
        }
    }
    public function get_fields() {
        $result = array();
        if($this->db->table_exists($this->table)) {
            $result = $this->db->list_fields($this->table);
        }
        return $result;
    }

    public function addItem($data = null) {
        if(empty($data) || !$this->db->table_exists($this->table)){
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    public function getByPresupuestoId($id) {
        $result = array();
        if($this->db->table_exists($this->table)) {
            $query = $this->db->select('*')
                ->from($this->table)
                ->where('NumPresupuesto', $id)
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

    public function updateFormData($form_data, $id){
        if(empty($form_data) || !$this->db->table_exists($this->table)){
            return false;
        }
        $result = $this->update($this->table, $form_data, array('NumPresupuesto' => $id));
        return $result;
    }

    public function insertFormData($form_data){
        if(empty($form_data) || !$this->db->table_exists($this->table)){
            return false;
        }
        $result = $this->insert($this->table, $form_data);
        return $result;
    }

    public function get_personalized_data($id = null) {
        $result_data = array();
        if(!$this->db->table_exists($this->table)){
            return $result_data;
        }
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->getByPresupuestoId($id);
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
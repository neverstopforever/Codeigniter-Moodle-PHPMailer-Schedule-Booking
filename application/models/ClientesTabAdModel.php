<?php

class ClientesTabAdModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_tab_ad";
    }

    public function getByClientId($id) {
        $query = $this->db->select('*')
                           ->from($this->table)
                           ->where('ccodcli', $id)
                           ->get();

        return $query->row();
    }

    public function getFieldList(){
        $fields = $this->db->field_data($this->table);
        return $fields;
    }

    public function updateFormData($form_data, $id){
        $result = $this->update($this->table, $form_data, array('ccodcli' => $id));
        return $result;
    }

    public function insertFormData($form_data){
        $result = $this->insert($this->table, $form_data);
        return $result;
    }

    public function deleteClient($id){
        $result = $this->delete($this->table, array('ccodcli' => $id));
        return $result;
    }

    public function get_personalized_data($id = null) {
        $result_data = array();
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->getByClientId($id);
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
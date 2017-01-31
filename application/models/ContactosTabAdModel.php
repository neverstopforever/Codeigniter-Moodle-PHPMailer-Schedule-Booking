<?php


class ContactosTabAdModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'contactos_tab_ad';
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function get_fields() {
        return $this->db->list_fields($this->table);
    }

    public function addItem($data = null) {
        if(empty($data)){
            return false;
        }
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }
    public function getFieldList(){
        $fields = $this->db->field_data($this->table);
        return $fields;
    }

    public function getByContactId($id) {

        $query = $this->db->select('*')
            ->from($this->table)
            ->where('Id', $id)
            ->get();

        return $query->row();
    }

    public function get_personalized_data($id = null) {
        $result_data = array();
        $personalized_data = array();
        if($id) {
            $personalized_data = (array)$this->getByContactId($id);
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


    public function insertFormData($data = array()){
        if(empty($data)){
            return false;
        }
        return $this->db->insert($this->table, $data);
    }

}
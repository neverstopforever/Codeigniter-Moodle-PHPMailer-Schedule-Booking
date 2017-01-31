<?php

class ClientesPlansRelationModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_plans_relations";
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function getOptions($id_plan) {

        if (!$id_plan) {
            return null;
        }

        $this->_db->select("clientes_plans_options.*");
        $this->_db->from('clientes_plans_relations');
        $this->_db->join('clientes_plans_options', 'clientes_plans_options.id = clientes_plans_relations.id_option', 'left');

        $this->_db->where('id_plan', $id_plan);
        $this->_db->distinct();
        $res = $this->_db->get();
        return $res->result();
    }

    public function getOption($where = array()) {

        if (empty($where)) {
            return null;
        }
        $this->_db->select("*");
        $this->_db->from($this->table);
        $this->_db->where($where);
        $res = $this->_db->get();
        return $res->result();
    }

    public function addItem($data = array()) {

        if (empty($data)) {
            return null;
        }
        $data_insert = array(
            'id_plan' => (isset($data['id_plan'])) ? $data['id_plan'] : null,
            'id_option' => (isset($data['id_option'])) ? $data['id_option'] : null,
        );
        $this->_db->insert($this->table, $data_insert);
        return $this->_db->insert_id();
    }

    public function deleteItemByPlanId($id_plan = null) {

        if (empty($id_plan) || !is_numeric($id_plan)) {
            return null;
        }
        return $this->_db->delete($this->table, array('id_plan'=>$id_plan));
    }
}
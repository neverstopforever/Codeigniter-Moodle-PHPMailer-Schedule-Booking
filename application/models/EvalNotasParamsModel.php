<?php

class EvalNotasParamsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "eval_notas_params";
    }

    public function getNotesParams($ide){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('idevalnota', $ide);
        $query = $this->db->get();
        return $query->result();
    }
    public function getEditable($id_param){
        $this->db->select('editable');
        $this->db->from($this->table);
        $this->db->where('id', $id_param);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateItem($update_data, $id_param, $ide){
        return $this->update($this->table, $update_data, array('id' => $id_param, 'idevalnota' => $ide));
    }

    public function getParamsBiId($id, $ide){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('idevalnota', $ide);
        $query = $this->db->get();
        return $query->row();
    }
    

}
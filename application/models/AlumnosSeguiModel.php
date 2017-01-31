<?php

class AlumnosSeguiModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "alumnos_segui";
    }

    public function getByStudentId($id){
        $query = $this->db->select('id, fecha AS `date`, titulo AS title, comentarios AS comment, usuario AS user')
                          ->from($this->table)
                          ->where('ccodcli', $id)
                          ->get();

        return $query->result();
    }
    public function getFolloUpById($id, $student_id){
        $query = $this->db->select('id, fecha AS `date`, titulo AS title, comentarios AS comment, usuario AS user')
                          ->from($this->table)
                          ->where('id', $id)
                          ->where('ccodcli', $student_id)
                          ->get();

        return $query->result();
    }

    public function updateFollowUp($id,$update_data){
               $this->db->where('id', $id);
        return $this->db->update($this->table, $update_data);
    }

    public function insertFollowUp($insert_data){
        return $this->insert($this->table, $insert_data);
    }
    public function deleteFollowUp($follow_up_id){
        return $this->delete($this->table, array('id' => $follow_up_id));
    }

    public function getFollowUpCount($id){
        $query = $this->db->select(' count(*) AS f_count')
                          ->from($this->table)
                          ->where('ccodcli', $id)
                          ->get();
        return $query->row();
    }

}
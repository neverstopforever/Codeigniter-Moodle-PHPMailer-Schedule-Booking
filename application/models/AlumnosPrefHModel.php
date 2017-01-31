<?php

class AlumnosPrefHModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "alumnos_pref_h";
    }

    public function getAvailability($id){
        $query = $this->db->select('
                                    lu_inicio_m AS monday_moorning_start,
                                    lu_fin_m AS monday_moorning_end,
                                    lu_inicio_t AS monday_afternoon_start,
                                    lu_fin_t AS monday_afternoon_end,

                                    ma_inicio_m AS thuesday_moorning_start,
                                    ma_fin_m AS thuesday_moorning_end,
                                    ma_inicio_t AS thuesday_afternoon_start,
                                    ma_fin_t  AS thuesday_afternoon_end,

                                    Mi_inicio_m AS wednesday_moorning_start,
                                    Mi_fin_m AS wednesday_moorning_end,
                                    Mi_inicio_t AS wednesday_afternoon_start,
                                    Mi_fin_t AS wednesday_afternoon_end,

                                    Ju_inicio_m AS thursday_moorning_start,
                                    Ju_fin_m AS thursday_moorning_end,
                                    Ju_inicio_t AS thursday_afternoon_start,
                                    Ju_fin_t AS thursday_afternoon_end,

                                    vi_inicio_m  AS friday_moorning_start,
                                    vi_fin_m  AS friday_moorning_end,
                                    vi_inicio_t  AS friday_afternoon_start,
                                    vi_fin_t AS friday_afternoon_end,

                                    sa_inicio_m AS saturday_moorning_start,
                                    sa_fin_m AS saturday_moorning_end,
                                    sa_inicio_t AS saturday_afternoon_start,
                                    sa_fin_t AS saturday_afternoon_end,

                                    do_inicio_m AS sunday_moorning_start,
                                    do_fin_m AS sunday_moorning_end,
                                    do_inicio_t AS sunday_afternoon_start,
                                    do_fin_t AS sunday_afternoon_end,

                                    ')
                          ->from($this->table)
                          ->where('ccodcli', $id)
                          ->get();
        return $query->row();
    }

    public function getFields(){
       return $this->db->list_fields($this->table);
    }

    public function updateHoursData($student_id, $update_data){
        return  $this->update($this->table, $update_data, array('ccodcli' => $student_id));
    }

    public function insertHoursData($data){
        return  $this->db->insert($this->table, $data);
    }
}
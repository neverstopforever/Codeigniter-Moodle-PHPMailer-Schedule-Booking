<?php

class Variables2Model extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "variables2";
    }

    public function getAlumnos() {

        $query = "
            SELECT
            `alumnos`.`Id`
            ,`alumnos`.`facturara` as `Idalumnbo`
            ,`alumnos`.`cnomcli`
            ,`alumnos`.`Cdomicilio`
            ,`alumnos`.`CDNICIF`
            ,`alumnos`.`ctfo1cli`
            ,`alumnos`.`movil`
            ,`alumnos`.`email`
            FROM
                `alumnos`
        ";

        return $this->selectCustom($query);
    }

    // Activada opcion de Ciclos
    function sa_opcion_activa($opcion){

        $sql="SELECT ".$opcion." as estado FROM variables2";

        $res = $this->selectCustom($sql);

        if($res->estado ==1){
            return true;
        }
    }

    public function updateImg($field = null, $url = null){
        if (!$field || !$url) {
            return false;
        }

        $data = array(
            $field => $url,
        );

        return $this->db->update($this->table, $data);
    }

    public function emptyField($field = null){
        if (!$field) {
            return false;
        }

        $data = array(
            $field => null,
        );

        return $this->db->update($this->table, $data);
    }

    public function updateNumaula(){
       $query = "UPDATE variables2 SET numaula = numaula+1";
        return $this->updateCustom($query);
    }

    public function updateNumProfesor(){
       $query = "UPDATE variables2 SET numprofesor = numprofesor + 1";
        return $this->updateCustom($query);
    }

    public function getNumProfesor(){
       $query = "SELECT numprofesor FROM variables2";
        return $this->selectCustom($query);
    }

    public function getNumaula(){
        $query = "SELECT numaula FROM variables2";
        return $this->selectCustom($query);
    }

    public function updateNumStudent(){
        $query = "UPDATE variables2 SET numalumno = numalumno + 1";
        return $this->updateCustom($query);
    }

    public function getNumStudent(){
        $query = "SELECT numalumno FROM variables2";
        return $this->selectCustom($query);
    }


    public function updateNumClient(){
        $query = "UPDATE variables2 SET NumCliente = NumCliente + 1";
        return $this->updateCustom($query);
    }
    
    public function getNumClient(){
        $query = "SELECT NumCliente FROM variables2;";
        return $this->selectCustom($query);
    }
    public function getStartEndtime(){
        $query = $this->db->select('inicio as start_time, fin as end_time, Fracciones AS time_fractions')
                          ->from($this->table)
                          ->get();
        return $query->row();
    }

    public function updateNumGroup(){
        $query = "UPDATE variables2 SET numgrupo = numgrupo + 1";
        return $this->updateCustom($query);
    }

    public function getNumGroup(){
        $query = "SELECT numgrupo FROM variables2";
        return $this->selectCustom($query);
    }

    public function updateNumpresupuesto() {
        $updateQuery = $this->db->query(
            "UPDATE " . $this->table . " SET numpresupuesto = numpresupuesto + 1"
        );
        if ($updateQuery) {
            $query = $this->db->query(
                "SELECT numpresupuesto+1 as leadid FROM " . $this->table . " "
            );
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row["leadid"];
            }
        }
        return null;
    }

    public function updateEnrollId(){
        $query = "UPDATE variables2 SET nummatricula=nummatricula+1";
        return $this->updateCustom($query);
    }
    public function getEnrollId(){
        $query = $this->db->select('nummatricula as enroll_id')
                          ->from($this->table)
                          ->get();

        return $query->row();
    }

    public function getGeneralSettings($user_id=''){
        $select="";
        if($user_id){
            $select = ' (select `mail_provider` from usuarios where Id = "'.$user_id.'") AS `mail_provider`, ';
        }

        $query = $this->db->select('idanno AS academic_year,
                                    Inicio AS first_hour,
                                    Fin AS last_hour,
                                    limite_horas,
                                    porcentaje_faltas AS absences_limit ,
                                    fracciones AS time_fractions,
                                    Fp AS payment_method,
                                    allow_group_multicourse,
                                    allow_group_change_startdate,
                                    allow_conflicts_calendars,
                                    '.$select.
                                    'allow_notification_show
                                    ')
                          ->from($this->table)
                          ->get();

        return $query->row();
    }

    public function updateGeneralSettings($update_data){
         return $this->db->update($this->table, $update_data);
    }

    public function get_new_invoice_id(){
        $query = $this->db->query('SELECT numfactura+1 as invoice_id FROM variables2');
        return $query->row();
    }

    public function updateInvoiceId(){
        return $this->db->query('UPDATE variables2 SET numfactura=numfactura+1;');
    }
    public function getInvoiceId(){
        $query = $this->db->query('SELECT numfactura as invoice_id FROM variables2');
        return $query->row();
    }
    
    public function get_logo(){
        $query = $this->db->query('SELECT logo FROM variables2');
        return $query->row();
    }

    public function deleteLogo(){
        return $this->db->update($this->table, array('logo'=> ''));
    }

    public function exist_field($field_name){
        return $this->db->field_exists($field_name, $this->table);
    }

    public function add_version_akaud_field(){
        $query = "ALTER TABLE `variables2` ADD COLUMN `version_akaud` INT(11) DEFAULT 0";
        $result = $this->db->query($query);
        return $result;
    }
    public function get_version_akaud(){
        $query = $this->db->select('version_akaud')
                          ->from($this->table)
                          ->get();
        $reulst = $query->row();

        if(isset($reulst->version_akaud)){
            return $reulst->version_akaud;
        }else{
            return '0';
        }
    }

    public function executingCsql($csql){
        if(empty($csql)){
            return false;
        }
        return $this->custom_sql($csql);
    }

    public function updateVersionAkaud($version){
        return $this->db->update($this->table, array('version_akaud' => $version));
    }

    public function is_option_active($option){
        $this->db->select($option ." as estado");
        $this->db->from($this->table);
        $query = $this->db->get()->row();
        if($query->estado == '1'){
            return true;
        }else{
            return false;
        }
    }

    public function getTeacherCanDelParams(){
        $this->db->select('Campus_Teacher_CanDelParams');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row();
        return $result->Campus_Teacher_CanDelParams;
    }

    public  function getMaxParams(){
        $this->db->select('max_params_ev');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row();
        return $result->max_params_ev;
    }

    public function get_allow_group_multicourse(){
        $this->db->select('allow_group_multicourse');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row();
        return $result->allow_group_multicourse;
    }

    public function get_allow_group_change_startdate(){
        $this->db->select('allow_group_change_startdate');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row();
        return $result->allow_group_change_startdate;
    }
    public function get_allow_conflicts_calendars(){
        $this->db->select('allow_conflicts_calendars');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row();
        return $result->allow_conflicts_calendars;
    }
    public function get_notification_show_val(){
        $this->db->select('allow_notification_show');
        $this->db->from($this->table);
        $query = $this->db->get();
        $result = $query->row();
        return $result->allow_notification_show;
    }
}
<?php

class GrupoModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "grupos";
    }


    public function get_groups(){
        
        $query = "SELECT 
                      gr.codigogrupo AS idgroup,
                      gr.descripcion AS `group_name`,
                      gr.fechainicio AS `start_date`,
                      gr.fechafin AS `end_date`,
                      gr.horas AS `hours`,
                      gr.numalumnos AS `max_seats`,
                      (gr.numalumnos -
                      (SELECT COUNT(DISTINCT matriculat.ccodcli) FROM matriculal JOIN matriculat ON matriculal.`NumMatricula` = matriculat.`NumMatricula` WHERE matriculal.`IdGrupo` = gr.`codigogrupo` AND matriculat.`Estado`=1)
                      ) AS `available_seats`,
                      gr.`Estado` AS state
                    
                    
                    FROM
                      grupos AS gr 
                    ORDER BY 2;";

        return $this->selectCustom($query);
    }

    public function updateFirstLastDate($update_data, $group_id){
        return  $this->update($this->table,$update_data, array('codigogrupo' => $group_id));
    }

    public function getGroupById($id){
        $query = $this->db->select('
                           `codigogrupo` AS id,
                          HEX(`IdColor`) AS color,
                          `Descripcion` AS title,
                          `html_description` AS group_description,
                          `IdPeriodo` AS id_Academicyear,
                           IdAreaAcademica AS id_area_academic,
                          `idcurso` AS id_category,
                           estado AS id_state,
                          `NumAlumnos` AS max_seats,
                          `Minimo` AS min_seats,
                          `DescripcionHorario` AS group_time_short_desc,
                          `custom_fields` as custom_fields')

                          ->from($this->table)
                          ->where('codigogrupo', $id)
                          ->get();

        return $query->row();
    }
    public function getGroupCustomFieldsById($id){
        $query = $this->db->select('`custom_fields` as custom_fields')

            ->from($this->table)
            ->where('codigogrupo', $id)
            ->get();

        return $query->row();
    }

    public function insertGroup($insert_data){
       return $this->insert($this->table, $insert_data);
    }

    public function updateGroup($id,$update_data){
       $query =  $this->db->where('codigogrupo', $id)
                 ->update($this->table, $update_data);
        return  $query;
    }



    public function check_group($id_group = null){
        
        if(empty($id_group)){
            return false;
        }
        
        $query = "SELECT COUNT(*) as check_count FROM grupos
                    WHERE codigogrupo IN
                    
                    (SELECT codigogrupo FROM agenda
                    UNION
                    SELECT codigogrupo FROM agendagrupos
                    UNION
                    SELECT codigogrupo FROM gruposl
                    UNION
                    SELECT idgrupo FROM matriculal
                    ) 
                    AND codigogrupo = '".$id_group."'
                    ;";

        return $this->selectCustom($query);
    }

    public function deleteItem($id_group = null){

        if(empty($id_group)){
            return false;
        }

        return $this->delete($this->table, array('codigogrupo'=>$id_group));
    }

    public function updateItem($id_group = null, $data = array()){

        if(empty($id_group) || empty($data)){
            return false;
        }

        return $this->update($this->table, $data, array('codigogrupo'=>$id_group));
    }

    public function getGroupsForSchedule(){
        $query = "SELECT DISTINCT 
                      gr.codigogrupo AS group_id,
                      gr.descripcion AS group_name,
                      HEX(gr.idcolor) AS color
                    FROM
                      grupos AS gr 
                    WHERE gr.codigogrupo IS NOT NULL 
                      AND (gr.estado IN (1)) 
                    ORDER BY 2
                    ;";
        return $this->selectCustom($query);
    }
    public function getGroupsForFilter(){
        $query = "SELECT codigogrupo AS id, descripcion as text
                    FROM grupos WHERE descripcion IS NOT NULL
                    ORDER BY 2";
        return $this->selectCustom($query);
    }

    public function getCategories($group_id){
        $query = "SELECT
                  cus.id AS category_id,
                  cus.curso AS category_name,
                  (SELECT DATE(fecha) FROM agendagrupos WHERE codigogrupo = gr.codigogrupo ORDER BY 1 ASC LIMIT 1) AS start_date,
                  (SELECT DATE(fecha) FROM agendagrupos WHERE codigogrupo = gr.codigogrupo ORDER BY 1 DESC LIMIT 1) AS end_date
                FROM
                  gruposl AS gl
                  JOIN grupos AS gr
                    ON gl.`CodigoGrupo` = gr.`codigogrupo`
                  LEFT JOIN cursos AS cus
                    ON gr.`idcurso` = cus.`id`
                WHERE gr.`codigogrupo` = '".$group_id."'
                GROUP BY 1
                ORDER BY 2 ";
        return $this->selectCustom($query);
    }

    public function getCoursesByGroup($group_id){
//        $query = "SELECT
//                  cu.`codigo` AS course_id,
//                  cu.curso AS course_name,
//                  gr.FechaInicio AS start_date,
//                  gr.FechaFin AS end_date
//                FROM
//                  gruposl AS gl
//                  JOIN grupos AS gr
//                    ON gl.`CodigoGrupo` = gr.`codigogrupo`
//                  LEFT JOIN curso AS cu
//                    ON gl.`codigocurso`= cu.`codigo`
//                WHERE gr.`codigogrupo` = '".$group_id."'
//                ORDER BY 2"; // old

        $query = "SELECT 
              cu.`codigo` AS course_id,
              cu.curso AS course_name,
              (SELECT DATE(fecha) FROM agendagrupos WHERE codigogrupo = gr.codigogrupo ORDER BY 1 ASC LIMIT 1) AS start_date,
              (SELECT DATE(fecha) FROM agendagrupos WHERE codigogrupo = gr.codigogrupo ORDER BY 1 DESC LIMIT 1) AS end_date
            
            FROM
              gruposl AS gl 
              JOIN grupos AS gr 
                ON gl.`CodigoGrupo` = gr.`codigogrupo` 
              LEFT JOIN curso AS cu 
                ON gl.`codigocurso` = cu.`codigo` 
            WHERE gr.`codigogrupo` = '". $group_id ."' 
            ORDER BY 2 
            ";
        return $this->selectCustom($query);
    }

    public function getGroupsForLMSMessage(){
        $this->db->select("`codigogrupo` AS id, `descripcion` AS text");
        $this->db->from($this->table);
        $this->db->where('estado', '1');
        $this->db->order_by(2);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function getPastGroups($CURRENT_GROUP_ID){
        $this->db->select("codigogrupo AS group_id, descripcion AS group_name, CONCAT(codigogrupo,'-',descripcion) AS group_id_description");
        $this->db->from($this->table);
        $this->db->where('codigogrupo <>', $CURRENT_GROUP_ID);
        $this->db->where('descripcion IS NOT NULL');
        $this->db->order_by(2);

        return $this->db->get()->result();

    }

    public function getGroupsFromMatriculal ($group_id){
        $this->db->select('count(*) as group_count');
        $this->db->where('idgrupo', $group_id);
        $this->db->from('matriculal');
        return $this->db->get()->row();
//        $sql = "SELECT COUNT(*) FROM matriculal WHERE idgrupo = '. $group_id .'";
    }
    public function deleteRelations($group_id){
        $this->delete('agenda', array('codigogrupo'=>$group_id));
        $this->delete('agendagrupos', array('codigogrupo'=>$group_id));
        $this->delete('gruposl', array('codigogrupo'=>$group_id));
       
    }
    public function getStartEndDate($group_id)
    {
        $this->db->select('fechainicio as start_date, fechafin as end_date');
        $this->db->where('codigogrupo', $group_id);
        $this->db->from($this->table);
        return $this->db->get()->row();
    }
    public function getGroupsName(){
        $sql=" SELECT DISTINCT codigogrupo as `id`, descripcion as `text` FROM grupos ORDER BY 2 ";
        return $this->selectCustom($sql);

    }
}
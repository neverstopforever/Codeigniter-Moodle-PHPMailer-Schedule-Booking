<?php

class GruposlModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "gruposl";
    }

    public function sa_groups($courseid, $userid){
        if($userid) {
            $query = "SELECT DISTINCT gr.Descripcion AS grupo,
					gr.CodigoGrupo AS Idgrupo
					FROM gruposl AS gl
					LEFT JOIN grupos AS gr
					ON gl.`codigogrupo` = gr.`CodigoGrupo`
					WHERE gr.Estado=1
					AND (((gl.`IdProfesor` = '" . $userid . "') OR (gl.`idprofesoraux` = '" . $userid . "') OR (gl.`idprofesoraux2` = '" . $userid . "') OR (gl.`idprofesoraux3` = '" . $userid . "'))
				    OR ((SELECT sc_superprofesor FROM profesor WHERE indice='" . $userid . "') >0))
					AND gl.`codigocurso` = '" . $courseid . "'
					ORDER BY gr.Descripcion";
        }else{
            $query = "SELECT DISTINCT gr.Descripcion AS grupo,
					gr.CodigoGrupo AS Idgrupo
					FROM gruposl AS gl
					LEFT JOIN grupos AS gr
					ON gl.`codigogrupo` = gr.`CodigoGrupo`
					WHERE gr.Estado=1
					AND gl.`codigocurso` = '" . $courseid . "'
					ORDER BY gr.Descripcion";
        }

        return $this->selectCustom($query);
    }

    public function getGroupsByTeacher($userid){
        $query = "SELECT DISTINCT gr.Descripcion AS grupo,
					gr.CodigoGrupo AS Idgrupo
					FROM gruposl AS gl
					LEFT JOIN grupos AS gr
					ON gl.`codigogrupo` = gr.`CodigoGrupo`
					WHERE gr.Estado=1
					AND (((gl.`IdProfesor` = '" . $userid . "') OR (gl.`idprofesoraux` = '" . $userid . "') OR (gl.`idprofesoraux2` = '" . $userid . "') OR (gl.`idprofesoraux3` = '" . $userid . "'))
				    OR ((SELECT sc_superprofesor FROM profesor WHERE indice='" . $userid . "') >0))
				  	ORDER BY gr.Descripcion";
        return $this->selectCustom($query);
    }


    public function getCountActiveGroups($teacher_id){

        $query = "SELECT COUNT(DISTINCT gl.`CodigoGrupo`) AS active_groups
                       FROM gruposl AS gl
                         INNER JOIN grupos AS gr
                           ON gl.`CodigoGrupo` = gr.`codigogrupo`
                       WHERE (gl.`IdProfesor` = '".$teacher_id."' OR gl.`idprofesoraux2` = '".$teacher_id."' OR gl.`idprofesoraux3` = '".$teacher_id."');";

        return $this->selectCustom($query);
    }

    public function getCourses($group_id, $course_id = null){
        
        $query = "SELECT
                      gl.`codigocurso` AS courseid,
                      gl.`Descripcion` AS course_description,
                      gl.`Horas` AS hours,
                      pf.`INDICE` AS teacher_id,
                      CONCAT(pf.sapellidos,', ',pf.snombre) AS teacher,
                      au.`IdAula` AS classroom_id,
                      au.`Nombre` AS classroom,
                      cu.`CURSO` AS course_name,
                      gl.`idprofesoraux` as second_teacher1,
                      gl.`idprofesoraux2` as second_teacher2,
                      gl.`idprofesoraux3` as second_teacher3,
                      HEX(cu.`IdColor`) AS color

                    FROM gruposl AS gl
                      LEFT JOIN profesor AS pf
                        ON gl.`IdProfesor` = pf.`INDICE`
                      LEFT JOIN aulas AS au
                        ON gl.`IdAula` = au.`IdAula`
                      JOIN curso AS cu
                        ON gl.`codigocurso` = cu.`codigo`
                    WHERE gl.`CodigoGrupo` = '".$group_id."'
                    ";

        if($course_id){
            $query.= " AND gl.`codigocurso` = '".$course_id."'";
        }
        $query.= " ORDER BY 2;";
        
        return $this->selectCustom($query);;
    }
    public function getCoursesByGroupEnroll($group_id, $course_id = null){

        $query = "SELECT
                      gl.`codigocurso` AS id,
                      gl.`Descripcion` AS text
                    FROM gruposl AS gl
                      JOIN curso AS cu
                        ON gl.`codigocurso` = cu.`codigo`
                    WHERE gl.`CodigoGrupo` = '".$group_id."'
                    ";

        if($course_id){
            $query.= " AND gl.`codigocurso` = '".$course_id."'";
        }
        $query.= " ORDER BY 2;";

        return $this->selectCustom($query);;
    }

    public function getCoursesByGroup($group_id){
        $query = "SELECT
                      gl.`codigocurso` AS course_id,
                      cu.`CURSO` AS course_name,
                      HEX(cu.`IdColor`) AS color
                    FROM
                      gruposl AS gl
                      JOIN curso AS cu
                        ON gl.`codigocurso` = cu.`codigo`
                    WHERE gl.`CodigoGrupo` = '".$group_id."'
                    ORDER BY 2
                    ";
        return $this->selectCustom($query);
    }

    public function insertCourse($data){
        return $this->insert($this->table, $data);
    }

    public function updateCourse($data, $where){
        return $this->update($this->table, $data, $where);
    }

    public function getCourseLinks($group_id, $course_id){
        $query = "SELECT COUNT(*) AS count_links FROM gruposl
                  WHERE codigocurso IN

              (SELECT ccurso FROM agenda WHERE codigogrupo = gruposl.`CodigoGrupo` AND `ccurso` = '".$course_id."'
               UNION
               SELECT ccurso FROM agendagrupos WHERE codigogrupo = gruposl.`codigogrupo` AND `ccurso` = '".$course_id."'
               UNION
               SELECT codigocurso FROM matriculal WHERE idgrupo = gruposl.`codigogrupo` AND codigocurso = '".$course_id."'
              )
              AND codigogrupo = '".$group_id."' AND codigocurso = '".$course_id."'";

        return $this->selectCustom($query);
    }

    public function deleteCourse($group_id, $course_id){
       return $this->delete($this->table, array('CodigoGrupo' => $group_id, 'codigocurso' => $course_id));
    }

    public function getExistCoursesIds($group_id){
        $query = $this->db->select("GROUP_CONCAT(codigocurso SEPARATOR '|') AS ids")
                          ->from($this->table)
                          ->where('codigogrupo', $group_id)
                          ->group_by('codigogrupo')
                          ->get();

        return $query->row();
    }

    public function getExistCourse($course_id, $group_id){
        $query = $this->db->select("codigocurso AS id")
            ->from($this->table)
            ->where(array('codigogrupo' => $group_id, 'codigocurso' => $course_id))
            ->get();

        return $query->row();
    }

    public function getClassrooms($group_id, $where_not_in = null){
        $where_not_in = $where_not_in ? 'AND au.`IdAula` NOT IN ('.$where_not_in.')' : '';

        $query = "SELECT au.`IdAula` AS id,
                    au.`Nombre` AS classroom
                    FROM gruposl AS gl
                    LEFT JOIN aulas AS au
                    ON gl.`IdAula` = au.`IdAula`
                    WHERE codigogrupo = '".$group_id."'  AND au.`IdAula` IS NOT NULL $where_not_in
                    GROUP BY au.`IdAula`
                    ORDER BY 2";

        return $this->selectCustom($query);
    }

    public function getNotSelectedClassrooms($event_id, $date, $start, $end){
        $query = "SELECT au.`IdAula` AS id,
                    au.`Nombre` AS classroom
                    FROM aulas AS au
                    WHERE au.`IdAula` NOT IN(
                    select ag.aula
                    from agendagrupos as ag
                    where ag.id != '".$event_id."'
                    and ag.fecha ='".$date."'
                    and inicio <='".$end."' 
                    and fin >= '".$start ."'
                    );";
        return $this->selectCustom($query);
    }

    public function getHoursByCourse($groupId, $course_id){
        $query = $this->db->select('horas as `hours`')
                          ->from($this->table)
                          ->where(array('codigogrupo' => $groupId, 'codigocurso' => $course_id))
                          ->get();

        return $query->row();
    }

    public function getGroupsForEnroll($courses_id = null, $group_id = null){
        $and_where = '';
        if($group_id){
            $and_where .= "  AND gr.codigogrupo ='".$group_id."'";
        }
        if($courses_id){
                $and_where .= "  AND gl.`codigocurso` in " . $courses_id ;
        }
         $query = "SELECT 
                    gr.`codigogrupo` AS id,
                    gr.`Descripcion` AS name,
                    gr.`FechaInicio` AS start_date,
                    gr.`FechaFin` AS end_date,
                    gl.`codigocurso` AS course_id,
                    count(gr.`CodigoGrupo` ) as 'count_rows',
                    (SELECT IF(gr.estado=1,(gr.NumAlumnos-(SELECT COUNT(DISTINCT nummatricula) FROM matriculal WHERE matriculal.idgrupo=gr.codigogrupo AND matriculal.idestado NOT IN (1,2,3))),0)) AS available_seats

                    FROM gruposl AS gl
                    LEFT JOIN grupos AS gr
                    ON gl.codigogrupo = gr.codigogrupo
                    LEFT JOIN curso AS cu
                    ON gl.`codigocurso` = cu.codigo

                    WHERE gr.`Estado` = 1
                    AND (SELECT IF(gr.estado=1,(gr.NumAlumnos-(SELECT COUNT(DISTINCT nummatricula) FROM matriculal WHERE matriculal.idgrupo=gr.codigogrupo AND matriculal.idestado NOT IN (1,2,3))),0)) > 0
                     $and_where
                    GROUP BY 1
                    ORDER BY 2
                    ";
        return $this->selectCustom($query);
    }

    public function getGroupsForMessage($teacher_id){
        $query = "SELECT DISTINCT 
                  gl.`codigogrupo` AS id,
                  gl.`descripcion` AS text
                FROM
                  gruposl AS gl
                  LEFT JOIN grupos AS gr
                    ON gl.`CodigoGrupo` = gr.`codigogrupo`
                  LEFT JOIN curso AS cu 
                    ON gl.`codigocurso` = cu.`codigo` 
                WHERE (gr.estado = 1) 
                  AND (
                    (gl.idprofesor = '". $teacher_id ."') 
                    OR (gl.idprofesoraux = '". $teacher_id ."') 
                    OR (gl.idprofesoraux2 = '". $teacher_id ."') 
                    OR (gl.idprofesoraux3 = '". $teacher_id ."')
                  ) 
                ORDER BY 2 ";

        return $this->selectCustom($query);
    }

    public function getGroupsForLMSMessage(){
        $query = "SELECT DISTINCT 
                  CONCAT(gl.`codigogrupo`,'_',gl.`codigocurso`) AS id,
                  gl.`descripcion` AS text
                FROM
                  gruposl AS gl
                  LEFT JOIN grupos AS gr
                    ON gl.`CodigoGrupo` = gr.`codigogrupo`
                  LEFT JOIN curso AS cu 
                    ON gl.`codigocurso` = cu.`codigo` 
                WHERE (gr.estado = 1) 
                ORDER BY 2 ";
        return $this->selectCustom($query);
    }

    public function getCoursesByGroupId($group_ids = array()){
        if(empty($group_ids) || !is_array($group_ids)){
            return null;
        }
        $this->db->select("cu.codigo AS id, cu.CURSO AS text");
        $this->db->from($this->table.' AS gl');
        $this->db->join('curso AS cu', 'gl.codigocurso = cu.codigo', 'left');
        $this->db->where_in('gl.CodigoGrupo',$group_ids);
        $this->db->group_by('cu.codigo');
        $this->db->order_by(2);
        $query = $this->db->get();

        return $query->result();
    }

}
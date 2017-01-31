<?php

class MatriculalModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "matriculal";
    }

    public function sa_courses_assigned($userrole, $userid){

        if($userrole == 'student'){

            $query = "SELECT DISTINCT
				cu.codigo AS idactividad,
				CONCAT(cu.codigo,'-',cu.CURSO) AS actividad,
				mt.`CCODCLI`
				FROM matriculal AS ml
				LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.`codigo`
				LEFT JOIN matriculat AS mt
				ON ml.NumMatricula = mt.NumMatricula
				WHERE (mt.EsPreMatricula = 0) AND (mt.estado <>3)
				AND mt.`CCODCLI` = '".$userid."'
				ORDER BY 2";

        }
        elseif($userrole == 'teacher')
        {

            $query = "SELECT DISTINCT ml.`codigocurso` AS idactividad,
 				 CONCAT(cu.codigo,'-',cu.CURSO) AS actividad
				 FROM matriculal AS ml
				 LEFT JOIN matriculat AS mt ON ml.NumMatricula = mt.NumMatricula
				 LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.`codigo`
				 WHERE (ml.IdEstado = 0)
				 AND (mt.EsPreMatricula = 0)
				 AND (mt.estado <>3)
				 AND ((ml.idprofesor = '".$userid."') OR (ml.idprofesoraux = '".$userid."') OR (ml.idprofesoraux2 = '".$userid."') OR (ml.idprofesoraux3 = '".$userid."'))
				 OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$userid."') >0)
				 ORDER BY 2" ;



        }
        return $this->selectCustom($query);
    }

	public function courses_assigned_by_group($userrole, $userid, $group_id){

        if($userrole == 'student'){

            $query = "SELECT DISTINCT
				cu.codigo AS course_id,
				CONCAT(cu.codigo,'-',cu.CURSO) AS course_name,
				mt.`CCODCLI`
				FROM matriculal AS ml
				LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.`codigo`
				LEFT JOIN matriculat AS mt
				ON ml.NumMatricula = mt.NumMatricula
				WHERE (mt.EsPreMatricula = 0) AND (mt.estado <>3)
				AND mt.`CCODCLI` = '".$userid."'
				ORDER BY 2";

        }
        elseif($userrole == 'teacher')
        {

            $query = "SELECT DISTINCT ml.`codigocurso` AS course_id,
						CONCAT(cu.codigo,'-',cu.CURSO) AS course_name
						FROM matriculal AS ml
						  LEFT JOIN matriculat AS mt ON ml.NumMatricula = mt.NumMatricula
						  LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.`codigo`
						  JOIN gruposl AS gl
							ON gl.`codigocurso` = cu.`codigo`
						WHERE (ml.IdEstado = 0)
							  AND (mt.EsPreMatricula = 0)
							  AND (mt.estado <>3)
							  
							  AND (((ml.`IdProfesor` = '" . $userid . "') OR (ml.`idprofesoraux` = '" . $userid . "') OR (ml.`idprofesoraux2` = '" . $userid . "') OR (ml.`idprofesoraux3` = '" . $userid . "'))
								OR ((SELECT sc_superprofesor FROM profesor WHERE indice='" . $userid . "') >0))      
							  
							  AND (gl.`CodigoGrupo` = '".$group_id."')
						ORDER BY 2
						;" ;



        }
        return $this->selectCustom($query);
    }

	public function get_assessment_detail($idml){
		$sql = "SELECT ml.Nota as nota, ml.nota_uf_auto as nota_auto, gr.Horario as horario ,
						gr.IdPeriodo as periodo ,al.sNombre as st_nomb, al.sApellidos as st_apell, 
						al.CCODCLI AS idal, al.CNOMCLI AS alumno, al.RUTAIMAGEN, 
						mt.NumMatricula AS matricula, gr.Descripcion AS grupo, 
						ml.Descripcion AS actividad, pr.NOMBRE AS docente, 
						an.Valor AS anno, ml.nota, ml.idestadonota AS idestado,
						al.photo_link
				FROM matriculal AS ml
				LEFT JOIN matriculat AS mt ON ( ml.NumMatricula = mt.NumMatricula )
				LEFT JOIN `año escolar` AS an ON ( ml.`IdAño` = an.Id )
				LEFT JOIN profesor AS pr ON ( ml.IdProfesor = pr.INDICE )
				LEFT JOIN grupos AS gr ON ( ml.IdGrupo = gr.CodigoGrupo )
				LEFT JOIN alumnos AS al ON ( mt.CCODCLI = al.CCODCLI )
				WHERE ml.id = '". $idml ."'";
		return $this->selectCustom($sql);
	}

	public function get_student_assessment_detail($course_id, $user_id){
		$sql = "SELECT ml.Nota as nota, gr.Horario as horario ,gr.IdPeriodo as periodo ,al.sNombre as st_nomb, al.sApellidos as st_apell, al.CCODCLI AS idal, al.CNOMCLI AS alumno, al.RUTAIMAGEN, mt.NumMatricula AS matricula, gr.Descripcion AS grupo, ml.Descripcion AS actividad, pr.NOMBRE AS docente, an.Valor AS anno, ml.nota, ml.idestadonota AS idestado
				FROM matriculal AS ml
				LEFT JOIN matriculat AS mt ON ( ml.NumMatricula = mt.NumMatricula )
				LEFT JOIN `año escolar` AS an ON ( ml.`IdAño` = an.Id )
				LEFT JOIN profesor AS pr ON ( ml.IdProfesor = pr.INDICE )
				LEFT JOIN grupos AS gr ON ( ml.IdGrupo = gr.CodigoGrupo )
				LEFT JOIN alumnos AS al ON ( mt.CCODCLI = al.CCODCLI )
				WHERE mt.estado=1 AND mt.esprematricula=0 AND al.CCODCLI = ".$user_id." AND  ml.codigocurso='".$course_id."'";
		return $this->selectCustom($sql);
	}

    public function getAllCourses(){
        $query = "SELECT DISTINCT ml.`codigocurso` AS idactividad,
 				 CONCAT(cu.codigo,'-',cu.CURSO) AS actividad
				 FROM matriculal AS ml
				 LEFT JOIN matriculat AS mt ON ml.NumMatricula = mt.NumMatricula
				 LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.`codigo`
				 WHERE (ml.IdEstado = 0)
				 AND (mt.EsPreMatricula = 0)
				 AND (mt.estado <>3)
				 ORDER BY 2" ;
        return $this->selectCustom($query);
    }

    public function getCountActiveStudents($teacher_id){

        $query = "SELECT COUNT(DISTINCT mt.ccodcli) AS active_students
                   FROM matriculal AS ml
                     INNER JOIN matriculat AS mt ON ml.`NumMatricula` = mt.`NumMatricula`
                   WHERE ml.`IdEstado` = 0
                         AND (ml.`IdProfesor` = '".$teacher_id."' OR ml.`idprofesoraux2` = '".$teacher_id."' OR ml.`idprofesoraux3` = '".$teacher_id."');";
        return $this->selectCustom($query);
    }

	public function getForGroupById($group_id){
		$query = "SELECT
				DISTINCT CONCAT(al.`sApellidos`,', ',al.snombre) AS student_name,
				mt.`NumMatricula` AS enroll_id,
				DATE(mt.`Inicio`) AS `start_date`,
				DATE(mt.`FinMatricula`) AS `end_date`,
				mt.`Estado` AS status

				FROM matriculal AS ml
				LEFT JOIN matriculat AS mt
				ON ml.`NumMatricula`= mt.`NumMatricula`
				LEFT JOIN alumnos AS al
				ON mt.`CCODCLI` = al.`CCODCLI`
				WHERE ml.`IdGrupo` = '".$group_id."'
				ORDER BY 1
				";
		return $this->selectCustom($query);
	}

	public function getExistCourses($enroll_id){
		$exist = "SELECT DISTINCT codigocurso AS id  FROM $this->table
						WHERE  `NumMatricula` = '". $enroll_id ."'";
		$result = $this->selectCustom($exist);

		return $result;
	}

	public function getNotExistCourses($course_ids){

		$this->db->select('codigo AS CourseId, CURSO AS course_name');
		if($course_ids) {
			$this->db->where_not_in('codigo', $course_ids);
		}
		$query = $this->db->get('curso');
		return $query->result();
	}

	public function getCourses($id){
		$query = $this->db->select('codigocurso AS CourseId,
									descripcion AS course_name,
									horas AS hours,
									idgrupo AS Group_id')
						  ->from($this->table)
						  ->where('NumMatricula', $id)
			 			  ->get();

		return $query->result();
	}

	 public function insertCourses($data){
		return $this->db->insert_batch($this->table, $data);
	}

	public function deleteCourse($data){
		return $this->db->delete($this->table, $data);
	}

	public function getEnrollById($enroll_id){
		$query = $this->db->select('*')
						  ->from($this->table)
			              ->where('NumMatricula', $enroll_id)
			              ->get();

		return $query->row();
	}

	public function getEnrolledStudents($group_id = null){
		$where = '';
		if($group_id){
			$where = " WHERE ml.`IdGrupo` = '".$group_id."' ";
		}
	    $query = "SELECT
				  al.ccodcli AS id,
				  CONCAT(al.sapellidos,' ',al.snombre) AS name,
				  mt.`NumMatricula` AS enrol_id,
				  ml.`codigocurso` AS course_id,
				  DATE(mt.`FechaMatricula`) AS enrol_date,
				  DATE(mt.`Inicio`) AS start_date

				  FROM matriculal AS ml
				  LEFT JOIN matriculat AS mt ON ml.`NumMatricula` = mt.`NumMatricula`
				  LEFT JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI`
				 $where
				  GROUP BY 1
				  ORDER BY 2
				";
		return $this->selectCustom($query);
	}

	public function insertEnrollCourses($ENROL_ID, $GROUP_ID, $COURSE_ID){
		$query = "INSERT INTO matriculal
					(`nummatricula`,`codigocurso`,`descripcion`,`horas`,`idestado`,
					`precio`,`idagrupado`, `idplan`,`idaula`,`idprofesor`,`tipo`,
					`idgrupo`,`idmodalidad`,`creditos`,`idprofesoraux`,`idprofesoraux2`,`idprofesoraux3`
					)

					SELECT
					'".$ENROL_ID."',
					cu.codigo,
					cu.curso,
					gl.horas,
					'0',
					'0',
					gl.idagrupado,
					gl.idplan,
					gl.idaula,
					gl.idprofesor,
					gl.tipo,
					gl.codigogrupo,
					'0',
					gl.creditos,
					gl.idprofesoraux,
					gl.idprofesoraux2,
					gl.idprofesoraux3


					FROM gruposl AS gl
					LEFT JOIN curso AS cu
					ON gl.codigocurso = cu.codigo
					WHERE gl.codigogrupo = '".$GROUP_ID."'
					AND gl.codigocurso = '".$COURSE_ID."'";


		return $this->custom_sql($query);

	}
	
	public function getGroupIdByEnrollId($enroll_id){
		if(empty($enroll_id)){
			return false;
		}
		$query = "SELECT DISTINCT idgrupo
					FROM matriculal
					WHERE NumMatricula = '".$enroll_id."'
					LIMIT 1 
					;";
		$query = $this->db->query($query);
		return $query->row();
	}

	public function getPastStudents($PAST_GROUP_ID, $CURRENT_GROUP_ID){
		$sql = "SELECT DISTINCT
				  al.ccodcli AS student_id,
				  CONCAT(al.sapellidos, ', ', al.snombre) AS student_name
				FROM matriculal AS ml 
				  JOIN matriculat AS mt 
					ON ml.`NumMatricula` = mt.`NumMatricula` 
				  JOIN alumnos AS al 
					ON mt.`CCODCLI` = al.`CCODCLI` 
				  WHERE ml.`IdGrupo` = '". $PAST_GROUP_ID ."'  
				 
				 AND al.`CCODCLI` NOT IN 
				 (
				
				   SELECT al.ccodcli
				   FROM matriculal AS ml 
					 JOIN matriculat AS mt ON ml.`NumMatricula` = mt.`NumMatricula` 
					 JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI` 
					WHERE ml.`IdGrupo` = '". $CURRENT_GROUP_ID ."'    
				 )
					ORDER BY 2
					;";

		return $this->db->query($sql)->result();
	}

	public function updateNotes($note, $state_id, $idml){
		return $this->update($this->table, array('nota' => $note, 'idestadonota' => $state_id), array('id' => $idml));
	}
	
	public function updateCourse($data, $where){
		return $this->update($this->table, $data, $where);
	}
	
	public function insert_matriculal_notas_audit($idm, $idml){
		$query = "INSERT INTO `matriculal_notas_audit` (`id`,`mt`,`ml_id`,`leido`,`fecha`) VALUES (NULL,".$idm.",".$idml.",0,curdate())";
		
		return $this->custom_sql($query);
	}

}
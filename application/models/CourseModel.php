<?php
class CourseModel extends MagaModel {

	public function __construct() {
		parent::__construct();
		$this->table = 'curso';
	}
	
	public function getCourse($userid){
		$query = "SELECT DISTINCT
				  gl.`codigocurso` AS idactividad,
				  CONCAT(cu.codigo, '-', cu.CURSO) AS actividad
				FROM
				  gruposl AS gl
				  LEFT JOIN grupos AS gr
					ON gl.`CodigoGrupo` = gr.`codigogrupo`
				  LEFT JOIN curso AS cu
					ON gl.`codigocurso` = cu.`codigo`
				WHERE (gr.estado = 1)
					  AND (
						(gl.idprofesor = '".$userid."')
						OR (gl.idprofesoraux = '".$userid."')
						OR (gl.idprofesoraux2 = '".$userid."')
						OR (gl.idprofesoraux3 = '".$userid."')
					  )
				ORDER BY 2";
		return $this->selectCustom($query);
	}

	public function getCoursesByStudentId($student_id, $ml_id = null){
		if(empty($student_id)){
			return false;
		}
		$query = "SELECT 
				  ml.Id AS `ml_id`,  
				  ml.codigocurso AS `course_id`,  
				  ml.descripcion AS `course_name`,  
				  gr.descripcion AS `group_name`,
				  gr.codigogrupo AS `group_id`,
				  gr.fechainicio AS `start_date`,
				  gr.fechafin AS `end_date`,
				  gr.horas AS `hours`,
				  gr.`Estado` AS state,
			      pr.`indice` AS `teacher_id`,
			      CONCAT(pr.`sapellidos`,', ',pr.`snombre`) AS `teacher_name`,
				  srg.`id` AS `resource_group_id`,
				  sri.`id` AS `resource_individual_id`,
				  (SELECT nombre FROM aulas WHERE idaula = ml.idaula) AS classroom,
				  ml.idaula AS `classroom_id`
				
				FROM
				  matriculal AS ml
				LEFT JOIN grupos AS gr
				  ON ml.idgrupo = gr.codigogrupo
				LEFT JOIN profesor AS pr
    			  ON pr.indice =  ml.idprofesor
				INNER JOIN matriculat AS mt
				  ON ml.nummatricula = mt.nummatricula
			    LEFT JOIN sc_resource_group AS srg
				  ON (srg.`group_id` = gr.`codigogrupo`
					AND  srg.`course_id` = ml.`codigocurso`
					AND srg.`teacher_id` = `teacher_id`)
				LEFT JOIN sc_resource_individual AS sri
				  ON (sri.`course_id` = ml.`codigocurso`
					AND sri.`course_id` = ml.`codigocurso`
					AND sri.`student_id` = mt.`ccodcli`
					AND sri.`teacher_id` = (SELECT indice FROM profesor WHERE indice = ml.idprofesor)
					)
				  WHERE mt.ccodcli = '".$student_id."' AND ml.`IdGrupo` IS NOT NULL " ;
			if($ml_id){
				$query .= " AND ml.Id = '".$ml_id."'";
			}
				$query .= " GROUP BY ml.codigocurso, ml.idgrupo  
				ORDER BY 2
				;";
		return $this->selectCustom($query);
	}
	
	public function getGroup($userid){
		$query = "SELECT DISTINCT gr.Descripcion AS grupo,
					gr.CodigoGrupo AS Idgrupo,
					gl.`codigocurso`
					FROM gruposl AS gl
					LEFT JOIN grupos AS gr
					ON gl.`codigogrupo` = gr.`CodigoGrupo`   
					WHERE gr.Estado=1
					AND (((gl.`IdProfesor` = '".$userid."') OR (gl.`idprofesoraux` = '".$userid."') OR (gl.`idprofesoraux2` = '".$userid."') OR (gl.`idprofesoraux3` = '".$userid."')) 
				    OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$userid."') >0))
					ORDER BY gr.Descripcion";
		//AND gl.`codigocurso` = '".$courseid."'
		return $this->selectCustom($query);	
	}

	public function getCourseIds($cours_ids){
		$this->db->select('codigo, CURSO AS Course');
		$this->db->or_where_in('codigo',$cours_ids);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function getCoursesForEnrrol(){
		$query = "SELECT
					cu.`codigo` AS id,
					cu.curso AS `name`

					FROM gruposl AS gl
					LEFT JOIN grupos AS gr
					ON gl.codigogrupo = gr.codigogrupo
					LEFT JOIN curso AS cu
					ON gl.`codigocurso` = cu.codigo
					WHERE gr.`Estado` = 1
					GROUP BY 1
					ORDER BY 2";

		return $this->selectCustom($query);
	}

	public function getCoursesByEnroll($enroll_id){
		$query = "SELECT 
				  GROUP_CONCAT(cu.`CURSO`) AS course_name 
				FROM
				  matriculal AS ml 
				  LEFT JOIN curso AS cu 
					ON ml.codigocurso = cu.codigo 
					
				  WHERE ml.`NumMatricula` = '".$enroll_id."'
				";
		return $this->selectCustom($query);
	}
}



<?php

class AulasModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "aulas";
    }

	public function getClassroomList(){
		$query = "SELECT
					  au.`IdAula`,
					  au.nombre AS name_of_classroom,
					  au.capacidad AS `Capacity`,
					  cf.`Nombre` AS headquarter,
					  HEX(au.`IdColor`) AS colour

					FROM
					  aulas AS au
					  LEFT JOIN `centros formacion` AS cf
					  ON au.`IdCentro` = cf.`Id`

					ORDER BY 1";
		$result = $this->selectCustom($query);
		return $result;
	}

	public function getClassroomData($classroom_id){
		$query = "SELECT
			  `IdAula`,
			  nombre AS name_of_classroom,
			  capacidad AS `capacity`,
			  IdCentro AS idcentro,
			  Activo AS active,
			  HEX(`IdColor`) AS color

			FROM aulas
			 WHERE IdAula = '".$classroom_id."'";

		$result = $this->selectCustom($query);
		return $result;
	}

	public function existClassroomLink($classroom_id){
		$query = "SELECT COUNT(*) AS count_link FROM aulas
					WHERE idaula IN
					(SELECT aula AS idaula FROM agenda
					UNION
					SELECT aula AS idaula FROM agendagrupos
					UNION
					SELECT idaulapadre AS idaula FROM aulas_combinadas
					UNION
					SELECT idaula FROM matriculal
					)
					AND idaula = '".$classroom_id."'";
		$result = $this->selectCustom($query);
		return $result;
	}

	public function deleteClassroom($classroom_id){
		$result = $this->delete($this->table, array('IdAula' => $classroom_id));
		return $result;
	}

	public function getClassrooms($classroom_id = null){
		$this->db->select('*');
		if($classroom_id){
			$this->db->where('IdAula', $classroom_id);
		}
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function getClassroomCourses($classroom_id = null){
		if($classroom_id){
			$query = "SELECT DISTINCT
						  cu.codigo AS `CourseId`,
						  cu.CURSO AS `Course`
						FROM
						  aula_d AS ad
						  INNER JOIN curso AS cu
							ON ad.CodCurso = cu.codigo
						WHERE ad.Indice = '".$classroom_id."'
						ORDER BY cu.codigo
						";
		}else{
			$query = "SELECT
					  codigo AS `CourseId`,
					  Curso AS `Course`
					FROM
					  curso
					ORDER BY 2 ;";
		}
		$result = $this->selectCustom($query);
		return $result;
	}

	public function getExistCourses($classroom_id){
		$exist = "SELECT DISTINCT CodCurso AS id  FROM aula_d
					WHERE  Indice = '".$classroom_id."'";
		$result = $this->selectCustom($exist);

		return $result;
	}
	public function getNotExistCourses($course_ids){

		$this->db->select('codigo AS CourseId, CURSO AS Course');
		if($course_ids) {
			$this->db->where_not_in('codigo', $course_ids);
		}
		$query = $this->db->get('curso');
		return $query->result();
	}
	public function insertData($data){
		return $this->db->insert($this->table, $data);
	}

	public function updateClassroom($classroom_id, $update_data){
		return $this->update($this->table, $update_data, array('IdAula' => $classroom_id));

	}

	 public function getCalendar($classroom_id, $start_date = '', $end_date = ''){
		 $query = "SELECT DISTINCT
					  id,
					  idaula,
					  event_date,
					  start_date,
					  end_date,
					  MIN(tag) AS tag,
					  comments,
					  holiday,
					  Group_name,
					  course_name,
					  Teacher_name,
					  classroom_name
					FROM
					  (SELECT DISTINCT
						af.id,
						af.idaula,
						af.fecha AS event_date,
						af.inicio AS start_date,
						af.fin AS end_date,
						af.etiqueta AS tag,
						af.observaciones  AS comments,
						af.titulo,
						'' AS holiday,
						'' AS Group_name,
						'' AS course_name,
						'' AS Teacher_name,
						au.nombre AS classroom_name
					  FROM
						aula_fechas AS af
						LEFT JOIN aulas_combinadas AS ac
						  ON af.idaula = ac.idaulahijo
						LEFT JOIN aulas_combinadas AS ac2
						  ON af.idaula = ac2.idaulapadre
						LEFT JOIN aulas AS au
						  ON au.idaula = af.idaula
					  WHERE (
						  af.idaula = 1
						  OR ac.idaulapadre = '".$classroom_id."'
						  OR ac2.idaulahijo = '".$classroom_id."'
						)
						AND (
						  af.fecha BETWEEN '".$start_date."'
						  AND '".$end_date."'
						)
					  UNION
					  SELECT DISTINCT
						0 AS id,
						ag.aula AS idaula,
						ag.fecha AS event_date,
						ag.inicio AS start_date,
						ag.fin AS end_date,
						0 AS tag,
						'' AS comments,
						'' AS titulo,
						'' AS holiday,
						gr.descripcion AS Group_name,
						cu.curso AS course_name,
						pf.nombre AS Teacher_name,
						au.nombre AS classroom_name
					  FROM
						agenda AS ag
						LEFT JOIN curso AS cu
						  ON ag.ccurso = cu.codigo
						LEFT JOIN aulas_combinadas AS ac
						  ON ag.aula = ac.idaulahijo
						LEFT JOIN aulas_combinadas AS ac2
						  ON ag.aula = ac2.idaulapadre
						LEFT JOIN grupos AS gr
						  ON ag.codigogrupo = gr.codigogrupo
						LEFT JOIN `centros formacion` AS tc
						  ON gr.idcentro = tc.id
						LEFT JOIN profesor AS pf
						  ON ag.iprofesor = pf.indice
						LEFT JOIN aulas AS au
						  ON au.idaula = ag.aula
					  WHERE (
						  ag.aula = 1
						  OR ac.idaulapadre = '".$classroom_id."'
						  OR ac2.idaulahijo = '".$classroom_id."'
						)
						AND (gr.estado IN (1))
						AND (
						  ag.fecha BETWEEN '".$start_date."'
						  AND '".$end_date."'
						)
					  UNION
					  SELECT DISTINCT
						0 AS id,
						agg.aula AS idaula,
						agg.fecha AS event_date,
						agg.inicio AS start_date,
						agg.fin AS end_date,
						1 AS tag,
						'' AS comments,
						'' AS titulo,
						'' AS holiday,
						gr.descripcion AS Group_name,
						cu.curso AS course_name,
						pf.nombre AS Teacher_name,
						au.nombre AS classroom_name
					  FROM
						agendagrupos AS agg
						LEFT JOIN curso AS cu
						  ON agg.ccurso = cu.codigo
						LEFT JOIN grupos AS gr
						  ON agg.codigogrupo = gr.codigogrupo
						LEFT JOIN `centros formacion` AS tc
						  ON gr.idcentro = tc.id
						LEFT JOIN profesor AS pf
						  ON agg.iprofesor = pf.indice
						LEFT JOIN aulas_combinadas AS ac
						  ON agg.aula = ac.idaulahijo
						LEFT JOIN aulas_combinadas AS ac2
						  ON agg.aula = ac2.idaulapadre
						LEFT JOIN aulas AS au
						  ON au.idaula = agg.aula
					  WHERE (
						  agg.aula = 1
						  OR ac.idaulapadre = '".$classroom_id."'
						  OR ac2.idaulahijo = '".$classroom_id."'
						)
						AND (gr.estado IN (1))
						AND (
						  agg.fecha BETWEEN '2016-02-01'
						  AND '2016-03-13'
						)
					  UNION
					  SELECT DISTINCT
						0 AS id,
						'' AS idaula,
						fecha AS event_date,
						'0000' AS start_date,
						'2359' AS end_date,
						1 AS tag,
						'' AS comments,
						'' AS titulo,
						descripcion AS holiday,
						'' AS Group_name,
						'' AS course_name,
						'' AS Teacher_name,
						'' AS classroom_name
					  FROM
						festividades AS ft
						LEFT JOIN `centros formacion` AS tc
						  ON ft.idcentro = tc.id
					  WHERE (ft.idcentro = 1
						  OR ft.idcentro = - 1)
						AND (
						  ft.fecha BETWEEN  '".$start_date."'
						  AND '".$end_date."'
						)
					  ORDER BY 2,
						3,
						4) AS t1

					GROUP BY id,
					  idaula,
					  event_date,
					  start_date,
					  end_date,
					  comments,
					  holiday,
					  Group_name,
					  course_name,
					  Teacher_name,
					  classroom_name";
		 $result = $this->selectCustom($query);
		 return $result;
	 }

	public function getClassroomsForSchedule(){
		$query = "SELECT 
					  au.idaula AS classroom_id,
					  au.nombre AS classroom_name,
					  HEX(au.idcolor) AS color 
					FROM
					  aulas AS au 
					WHERE au.idaula IS NOT NULL 
					  AND au.activo = 1 
					ORDER BY 2 
					;";
		return $this->selectCustom($query);
	}
	public function getAll($selectParams = '', $where = array()) {
		return  $this->selectAll($this->table, $selectParams, $where);
	}
}
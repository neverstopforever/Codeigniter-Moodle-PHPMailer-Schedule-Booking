<?php

class AgendaGrupoModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "agendagrupos";
    }

    public function sa_class_dates($group_id, $course_id, $user_id){
       if($user_id) {
		   $sql_dates = "SELECT DISTINCT agg.FECHA
				FROM agendagrupos AS agg
				LEFT JOIN profesor AS pr ON agg.`IProfesor` = pr.INDICE
				LEFT JOIN grupos AS gr ON agg.`CodigoGrupo` = gr.`codigogrupo`
				WHERE
				(agg.CodigoGrupo = '" . $group_id . "' AND agg.CCURSO = '" . $course_id . "')
				AND (((agg.iprofesor = '" . $user_id . "') OR (agg.idprofesoraux = '" . $user_id . "') OR (agg.idprofesoraux2 = '" . $user_id . "') OR (agg.idprofesoraux3 = '" . $user_id . "') )
				OR ((SELECT sc_superprofesor FROM profesor WHERE indice='" . $user_id . "') >0))
				AND gr.`Estado` = 1
				AND (agg.fecha <= NOW())
				ORDER BY agg.FECHA";
	   }else{
		   $sql_dates = "SELECT DISTINCT agg.FECHA
				FROM agendagrupos AS agg
				LEFT JOIN profesor AS pr ON agg.`IProfesor` = pr.INDICE
				LEFT JOIN grupos AS gr ON agg.`CodigoGrupo` = gr.`codigogrupo`
				WHERE
				(agg.CodigoGrupo = '" . $group_id . "' AND agg.CCURSO = '" . $course_id . "')
				AND gr.`Estado` = 1
				AND (agg.fecha <= NOW())
				ORDER BY agg.FECHA";
	   }
        return $this->selectCustom($sql_dates);
    }

	public function getEventsList($group_id){
		$query = "SELECT
					agr. id,
					agr.`Fecha` AS `event_date`,
					cu.`CURSO` AS `course_name`,
					CONCAT(pf.sapellidos,', ',pf.snombre) AS `teacher_name`,
                      CONCAT(pf_1.sapellidos,'(',pf_1.email, ',' ,pf_1.TFO1 ,')') AS teacher_1,
                      CONCAT(pf_2.sapellidos,'(',pf_2.email, ',' ,pf_2.TFO1 ,')') AS teacher_2,
                      CONCAT(pf_3.sapellidos,'(',pf_3.email, ',' ,pf_3.TFO1 ,')') AS teacher_3,
					au.`Nombre` AS `classroom`,
					agr.`Aula` AS classroom_id,
					agr.`Inicio` AS `start_date`,
					agr.`Fin` AS `end_date`,
					WEEKDAY(agr.`fecha`) AS `week_day`,
					agr.`IProfesor` AS teacher_id,
					agr.`idprofesoraux` AS teacher_1_id,
					agr.`idprofesoraux2` AS teacher_2_id,
					agr.`idprofesoraux3` AS teacher_3_id,
					agr.`ccurso` AS  course_id

					FROM agendagrupos AS agr
					LEFT JOIN profesor AS pf
					ON agr.`IProfesor` = pf.`INDICE`
					LEFT JOIN profesor AS pf_1
                        ON agr.`idprofesoraux` = pf_1.`INDICE`
                      LEFT JOIN profesor AS pf_2
                        ON agr.`idprofesoraux2` = pf_2.`INDICE`
                      LEFT JOIN profesor AS pf_3
                        ON agr.`idprofesoraux3` = pf_3.`INDICE`
					LEFT JOIN aulas AS au
					ON agr.`Aula` = au.`IdAula`
					LEFT JOIN curso AS cu
					ON agr.`ccurso` = cu.`codigo`
					WHERE agr.`CodigoGrupo` = '".$group_id."'
					ORDER BY 2";

		return $this->selectCustom($query);
	}

	public function updateEventData($groupId, $event_id, $update_data){
		$this->db->where(array('CodigoGrupo' => $groupId, 'id' => $event_id));
		return $this->db->update($this->table, $update_data);
	}

	public function deleteEvents($events_ids){
		$this->db->where_in('id', $events_ids);
		$query = $this->db->delete($this->table);
		return $query;
	}

	public function getEvents($group_id, $courseId = null){

		$and_where = $courseId ? " AND agr.ccurso='".$courseId."'": '';
		$query = "SELECT * FROM
				 (
				 SELECT agr.id AS keyid,
				 cu.curso AS event_name,
				 agr.fecha AS event_date,
				 agr.inicio AS start_time,
				 agr.fin AS end_time,
				 cu.curso AS course_name,
				 pf.nombre AS teacher_name,
				 pf_1.nombre AS aux_teacher_1_name,
				 pf_2.nombre AS aux_teacher_2_name,
				 pf_3.nombre AS aux_teacher_3_name,
				 au.nombre AS classroom,
				  HEX(cu.`IdColor`) AS event_color,
				 agr.`observaciones` AS comments,
				 agr.custom_fields AS custom_fields,
				 null AS festivity
				 FROM
				 agendagrupos AS agr
				 LEFT JOIN curso AS cu
				 ON agr.ccurso = cu.codigo
				 LEFT JOIN profesor AS pf
				 ON agr.iprofesor = pf.indice
				 LEFT JOIN profesor AS pf_1
                 ON agr.`idprofesoraux` = pf_1.`INDICE`
                 LEFT JOIN profesor AS pf_2
                 ON agr.`idprofesoraux2` = pf_2.`INDICE`
                 LEFT JOIN profesor AS pf_3
                 ON agr.`idprofesoraux3` = pf_3.`INDICE`
				 LEFT JOIN aulas AS au
				 ON agr.aula = au.idaula
				 WHERE
				 agr.codigogrupo='".$group_id."'
				 $and_where
		  		UNION
				SELECT DISTINCT
				 0 AS keyid,
				 descripcion AS event_name,
				 fecha AS event_date,
				 '0000' AS start_time,
				 '2359' AS end_time,
				 '' AS course_name,
				 '' AS teacher_name,
				 '' AS aux_teacher_1_name,
				 '' AS aux_teacher_2_name,
				 '' AS aux_teacher_2_name,
				 '' AS classroom,
				 '' AS event_color,
				 '' AS comments,
				 '' AS custom_fields,
				 'true' AS festivity
				 FROM
				 festividades ) AS t1
				 ORDER BY 3,4
				";
		return $this->selectCustom($query);
	}

	public function getEventsByIds($group_id, $event_ids){
		$and_where_1 = $event_ids ? " AND agr.id IN($event_ids)" : '';
		$query = "SELECT * FROM
				 (
				 SELECT agr.id AS keyid,
				 cu.curso AS event_name,
				 agr.fecha AS event_date,
				 agr.inicio AS start_time,
				 agr.fin AS end_time,
				 cu.curso AS course_name,
				 pf.nombre AS teacher_name,
				 au.nombre AS classroom,
				  HEX(cu.`IdColor`) AS event_color,
				 agr.`observaciones` AS comments
				 FROM
				 agendagrupos AS agr
				 LEFT JOIN curso AS cu
				 ON agr.ccurso = cu.codigo
				 LEFT JOIN profesor AS pf
				 ON agr.iprofesor = pf.indice
				 LEFT JOIN aulas AS au
				 ON agr.aula = au.idaula
				 WHERE
				 agr.codigogrupo='".$group_id."'
		
				 $and_where_1
			  ) AS t1
				 ORDER BY 3,4
				";
		return $this->selectCustom($query);
	}

	public function unassignEventTeacher($groupId, $event_id, $teacher_type){
        $this->db->where(array('codigogrupo' => $groupId, 'id' => $event_id));
		if($teacher_type == 'IProfesor'){
			return $this->db->update($this->table, array($teacher_type => '0', 'idprofesoraux'=>'0', 'idprofesoraux2'=>'0', 'idprofesoraux3'=>'0'));
		}

		return $this->db->update($this->table, array($teacher_type => '0'));

	}
	public function assignEventTeacher($event_ids, $teacher_id){
		$this->db->where_in('id', $event_ids);

		return $this->db->update($this->table, array('iprofesor' => $teacher_id));

	}

	public function assignEventClassroom($event_ids, $classroom_id){
		$this->db->where_in('id', $event_ids);

		return $this->db->update($this->table, array('aula' => $classroom_id));

	}


	public function unassignEventClassroom($groupId, $event_id){
        $this->db->where(array('codigogrupo' => $groupId, 'id' => $event_id));

		return $this->db->update($this->table, array('Aula' => '0'));

	}

	public function getSecondaryTeachers($event_id){
		$query = $this->db->select("CONCAT(pf.sapellidos,'(',pf.email, ',' ,pf.TFO1 ,')') AS teacher_desc")
		                  ->from($this->table.' AS agr')
			              ->join('profesor AS pf', 'pf.`INDICE`=agr.`IProfesor` OR pf.`INDICE`=agr.`idprofesoraux` OR pf.`INDICE`=agr.`idprofesoraux1` OR pf.`INDICE`=agr.`idprofesoraux2`')
			              ->where('id', $event_id)
			              ->get();
		return $query->result();
	}

	public function checkingExistEvent($data){
		$query = "SELECT fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num FROM agendagrupos
					WHERE fecha BETWEEN '".$data->start_date."' AND '".$data->end_date."'
					AND inicio < '".$data->start_time."'
					AND fin > '".$data->end_time."'
					AND WEEKDAY(fecha) IN ($data->week_days)
					AND codigogrupo = '".$data->group_id."'";
		return $this->selectCustom($query);
	}
	public function checkingExistEventThisDay($data){
		$where = "";
		if(isset($data->event_id)){
			$where = " and id != '".$data->event_id."' ";
		}
		$query = "SELECT fecha AS `date`, inicio AS start_time, fin AS end_time FROM agendagrupos
					WHERE fecha = '".$data->date."'
					AND inicio < '".$data->start_time."'
					AND fin > '".$data->end_time."'
					".$where."
					AND codigogrupo = '".$data->group_id."'";
		return $this->selectCustom($query);
	}


	public function checkAvailabilityTeachers($where, $event_data){
		$query = "SELECT fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num FROM agendagrupos
					WHERE fecha BETWEEN '".$event_data->start_date."' AND '".$event_data->end_date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)
					AND
					(
					$where
					)";
		return $this->selectCustom($query);
	}
	
	public function availabilityTeachersBydate($where, $event_data){
		$where2 ='';
		if(isset($event_data->event_id)){
			$where2 = " and id != '".$event_data->event_id."' ";
		}
		$query = "SELECT fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num FROM agendagrupos
					WHERE fecha='".$event_data->date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					 $where2
					AND
					(
					$where
					)";
		return $this->selectCustom($query);
	}

	public function checkPersonalEventTeachers($where_id_in, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					profesor_fechas
					INNER JOIN etiquetas_profesor
					ON profesor_fechas.etiqueta = etiquetas_profesor.id
					WHERE idProfesor IN ($where_id_in)
					AND fecha <= '".$event_data->end_date."'
					AND fecha >= '".$event_data->start_date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)";
		return $this->selectCustom($query);
	}
	public function personalEventTeachersBydate($where_id_in, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					profesor_fechas
					INNER JOIN etiquetas_profesor
					ON profesor_fechas.etiqueta = etiquetas_profesor.id
					WHERE idProfesor IN ($where_id_in)
					AND fecha = '".$event_data->date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					";
		return $this->selectCustom($query);
	}
	public function personalEventTeachersBydateEventId($where_id_in, $event_data){
		$query = "SELECT
					profesor_fechas.id
					FROM
					profesor_fechas
					INNER JOIN etiquetas_profesor
					ON profesor_fechas.etiqueta = etiquetas_profesor.id
					left JOIN agendagrupos on agendagrupos.IProfesor = profesor_fechas.idprofesor
					WHERE idProfesor IN ($where_id_in)
					AND profesor_fechas.fecha = '".$event_data->date."'
					AND agendagrupos.id != '".$event_data->event_id."'
					AND profesor_fechas.inicio < '".$event_data->end_time."'
					AND profesor_fechas.fin > '".$event_data->start_time."'
					";
		return $this->selectCustom($query);
	}


	public function checkingAvailabilityClassroom($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					agendagrupos AS ag
					WHERE ag.id <> - 1
					AND fecha <= '".$event_data->end_date."'
					AND fecha >= '".$event_data->start_date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)
					AND (ag.aula = '".$classroom_id."')";
		return $this->selectCustom($query);
	}
	public function checkingAvailabilityClassroomByDay($classroom_id, $event_data){
		$where = '';
		if(isset($event_data->event_id)){
			$where = " and id != '".$event_data->event_id."' ";
		}
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					agendagrupos AS ag
					WHERE ag.id <> - 1
					AND fecha = '".$event_data->date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					$where
					AND (ag.aula = '".$classroom_id."')";
		return $this->selectCustom($query);
	}

	public function AvailabilityClassroomBydate($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					agendagrupos AS ag
					WHERE ag.id <> - 1
					AND fecha = '".$event_data->date."'
			  		AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
			  		AND (ag.aula = '".$classroom_id."')";
		return $this->selectCustom($query);
	}

	public function InternalEventClassroomBydate($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					aula_fechas AS af
					WHERE idaula = '".$classroom_id."'
					AND fecha = '".$event_data->date."'
			  		AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
			  		";
		return $this->selectCustom($query);
	}

	public function checkingInternalEventClassroom($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					aula_fechas AS af
					WHERE idaula = '".$classroom_id."'
					AND fecha <= '".$event_data->end_date."'
					AND fecha >= '".$event_data->start_date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)
					";
		return $this->selectCustom($query);
	}
	public function checkingInternalEventClassroomByDay($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					aula_fechas AS af
					WHERE idaula = '".$classroom_id."'
					AND fecha = '".$event_data->date."'
					AND inicio < '".$event_data->end_time."'
					AND fin > '".$event_data->start_time."'
					";
		return $this->selectCustom($query);
	}

   public function addEvents($insert_data){
	   $this->db->insert_batch($this->table, $insert_data);
	   $insert_id = $this->db->insert_id();
	   return  $insert_id;

   }
	public function addEvent($insert_data){
		$this->db->insert($this->table, $insert_data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;

	}

	public function getEventUsedTime($data){
		$query = "SELECT fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num FROM agendagrupos
					WHERE fecha BETWEEN '".$data->start_date."' AND '".$data->end_date."'
					AND WEEKDAY(fecha) IN ($data->week_days)
					AND codigogrupo = '".$data->group_id."'";
		return $this->selectCustom($query);
	}

	public function getTeachersUsedTime($where, $event_data){
		$query = "SELECT fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num FROM agendagrupos
					WHERE fecha BETWEEN '".$event_data->start_date."' AND '".$event_data->end_date."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)
					AND
					(
					$where
					)";
		return $this->selectCustom($query);
	}

	public function getPersonalEventTeachersUsedTime($where_id_in, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					profesor_fechas
					INNER JOIN etiquetas_profesor
					ON profesor_fechas.etiqueta = etiquetas_profesor.id
					WHERE idProfesor IN ($where_id_in)
					AND fecha < '".$event_data->end_date."'
					AND fecha > '".$event_data->start_date."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)";
		return $this->selectCustom($query);
	}

	public function getClassroomUsedTime($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					agendagrupos AS ag
					WHERE ag.id <> - 1
					AND fecha <= '".$event_data->end_date."'
					AND fecha >= '".$event_data->start_date."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)
					AND (ag.aula = '".$classroom_id."')";
		return $this->selectCustom($query);
	}
	public function getClassroomUsedTimeByDay($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					agendagrupos AS ag
					WHERE ag.id <> - 1
					AND fecha = '".$event_data->date."'
					AND (ag.aula = '".$classroom_id."')";
		return $this->selectCustom($query);
	}

	public function getInternalEventClassroomUsedTime($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					aula_fechas AS af
					WHERE idaula = '".$classroom_id."'
					AND fecha <= '".$event_data->end_date."'
					AND fecha >= '".$event_data->start_date."'
					AND WEEKDAY(fecha) IN ($event_data->week_days)
					";
		return $this->selectCustom($query);
	}
	public function getInternalEventClassroomUsedTimeByDay($classroom_id, $event_data){
		$query = "SELECT
					fecha AS `date`, inicio AS start_time, fin AS end_time, WEEKDAY(fecha) AS week_num
					FROM
					aula_fechas AS af
					WHERE idaula = '".$classroom_id."'
					AND fecha = '".$event_data->date."'
					";
		return $this->selectCustom($query);
	}

	public function getTeachersDataByEvent($where_ids){
		$query = $this->db->select('pf.nombre AS full_name, pf.sNombre AS first_name, 
							pf.sApellidos AS last_name, pf.Email AS email, 
							pf.Email2 AS email_2, pf.movil AS mobile, agr.Fecha AS start_date, cu.curso AS course_name')
				 ->from($this->table.' AS agr')
				 ->join('profesor AS pf', 'agr.iprofesor = pf.indice OR  agr.idprofesoraux = pf.indice 
				 										OR  agr.idprofesoraux2 = pf.indice OR  agr.idprofesoraux3 = pf.indice ', 'left')
				 ->join('curso AS cu','agr.ccurso = cu.codigo', 'left')
				 //->where('agr.id', $event_id)
				->where_in('agr.id', $where_ids)
				 ->get();

		return $query->result();
	}

	public function getGroupStartLastDate($GROUP_ID){
		$query = "SELECT 
					DATE((SELECT fecha FROM agendagrupos WHERE codigogrupo = '".$GROUP_ID."' ORDER BY 1 ASC LIMIT 1)) AS first_date,
					DATE((SELECT fecha FROM agendagrupos WHERE codigogrupo =  '".$GROUP_ID."' ORDER BY 1 DESC LIMIT 1)) AS last_date";

		return $this->selectCustom($query);
	}
	public function deleteByCourseId($course_id){
		$this->db->where('CodigoGrupo', $course_id);
		$query = $this->db->delete($this->table);
		return $query;
		
	}
	public function getStartEndDate($group_id){
		$this->db->select('min(Fecha) as start_date, max(Fecha) as end_date');
		$this->db->where('CodigoGrupo', $group_id);
		$query=$this->db->get($this->table);
		return $query->row();

	}

}
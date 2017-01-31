<?php
class EventModel extends MagaModel{
	
	public function __construct() {
		parent::__construct();
		//$this->table = "agenda";
	}
	
	public function getEvent($courseid, $groupid, $userid, $from, $to){
		$sql1 = "SELECT
			id AS keyid,
			fecha,
			inicio,
			fin,
			'' AS codigo_grupo,
			'' AS grupo,
			'' AS codigo_actividad,
			observaciones AS actividad,
			'' AS color,
			idprofesor,
			'' AS custom_fields,
			'' AS event_id,
			'' AS idaula,
			'' As aula,
			'' AS festivo,
			'' As idlogin,
			'' As nomcentro,
			etiqueta,
			observaciones,
			'' AS alumno
			FROM
			profesor_fechas
			WHERE (idprofesor = ".$userid." OR idprofesor IS NULL)
			UNION
			SELECT DISTINCT
			0 AS keyid,
			ag.fecha,
			ag.inicio,
			ag.fin,
			'' AS codigo_grupo,
			'' AS grupo,
			cu.codigo AS codigo_actividad,
			cu.curso As actividad,
			cu.IdColor AS color,
			ag.iprofesor AS idprofesor,
			'' AS custom_fields,
			ag.agendagrupos_id AS event_id,
			au.idaula,
			au.nombre AS aula,
			'' AS festivo,
			'' AS idlogin,
			tc.nombre As nomcentro,
			0 As etiqueta,
			'' As observaciones,
			al.cnomcli AS alumno
			FROM
			agenda AS ag
			LEFT JOIN aulas AS au
			ON ag.aula = au.idaula
			LEFT JOIN curso As cu
			ON ag.ccurso = cu.codigo
			LEFT JOIN alumnos AS al
			ON ag.calumno = al.ccodcli
			LEFT JOIN matriculat AS mt
			ON ag.matricula = mt.nummatricula
			LEFT JOIN `centros formacion` AS tc
			ON mt.idcentro = tc.id
			WHERE (mt.estado = 1) AND ((ag.iprofesor = ".$userid.") OR (ag.idprofesoraux = ".$userid.") OR (ag.idprofesoraux2 = ".$userid.") OR (ag.idprofesoraux3 = ".$userid."))
			AND (agenda.codigogrupo = '' OR ag.codigogrupo IS NULL)
			UNION
			SELECT DISTINCT
			0 AS keyid,
			agg.fecha,
			agg.inicio,
			agg.fin,
			gr.codigogrupo AS codigo_grupo,
			gr.descripcion AS grupo,
			cu.codigo As codigo_actividad,
			cu.curso AS actividad,
			cu.IdColor AS color,
			agg.iprofesor AS idprofesor,
			agg.custom_fields AS custom_fields,
			agg.id AS event_id,
			au.idaula,
			au.nombre AS aula,
			'' AS festivo,
			'' AS idlogin,
			tc.nombre AS nomcentro,
			1 AS etiqueta,
			'' AS observaciones,
			'' As alumno
			FROM
			agendagrupos AS agg
			LEFT JOIN curso AS cu
			ON agg.ccurso = cu.codigo
			INNER JOIN grupos AS gr
			ON agg.codigogrupo = gr.codigogrupo
			LEFT JOIN aulas AS au
			ON agg.aula = au.idaula
			LEFT JOIN `centros formacion` AS tc
			ON gr.idcentro = tc.id
			WHERE (agg.codigogrupo IS NOT NULL AND agg.codigogrupo<>'') AND (gr.estado =1)
			AND ((agg.iprofesor = ".$userid.") OR (agg.idprofesoraux = ".$userid.") OR (agg.idprofesoraux2 = ".$userid.") OR (agg.idprofesoraux3 = ".$userid."))
			UNION
			SELECT distinct
			0 AS keyid,
			fecha,
			'0800' AS inicio,
			'2359' AS fin,
			'' AS codigo_grupo,
			'' AS grupo,
			'' AS codigo_actividad,
			'' AS actividad,
			'' AS color,
			'' AS idprofesor,
			'' AS custom_fields,
			'' AS event_id,
			'' AS idaula,
			'' AS aula,
			descripcion AS festivo,
			'' AS idlogin,
			tc.nombre AS nomcentro,
			1 AS etiqueta,
			'' AS observaciones,
			'' AS alumno
			FROM
			festividades
			LEFT JOIN `centros formacion` AS tc
			ON festividades.idcentro = tc.id";
	$sql2 = "SELECT DISTINCT keyid,
			fecha, inicio, fin, codigo_grupo, grupo,
			codigo_actividad, actividad, idprofesor, idaula, aula, festivo,
			idlogin, nomcentro, MIN(etiqueta) AS etiqueta, observaciones, alumno
			,color
			FROM (".$sql1.") AS t1
			GROUP BY keyid, fecha, inicio, fin, codigo_grupo, grupo,
				codigo_actividad, actividad, idprofesor, idaula, aula, festivo,
				idlogin, nomcentro, observaciones, alumno ";
	$extra_sql = '';
	if($courseid != '' && $groupid != ''){
		$extra_sql .= " AND ( sb.codigo_grupo = '".$groupid."'  or sb.codigo_grupo = '' ) AND (sb.codigo_actividad = '".$courseid."' or sb.codigo_actividad = '' )";
	}
	if($courseid != '' && $groupid == ''){
		$extra_sql .= " AND (sb.codigo_actividad = '".$courseid."' or sb.codigo_actividad = '' )";
	}
	if ('' != trim($extra_sql)){
		$extra_sql = " $extra_sql AND ";
	}
	if (trim($from) != '' && trim($to) != '' ){
		$extra_sql = " $extra_sql ( concat(DATE(sb.fecha)) BETWEEN ".$from." AND ".$to.")  AND ";
	}
	$extra_sql = trim($extra_sql);
	$extra_sql = ltrim($extra_sql,'AND');
	//nuevo SQL
	//@TODO (agg.iprofesor = ".$userid." or agg.iprofesor is null)
	//$userid = "1";
	$sql2 = "SELECT
		distinct keyid, fecha, inicio, fin, codigo_grupo, grupo,
		codigo_actividad, actividad, idprofesor, custom_fields, event_id, idaula, aula, festivo,
		idlogin, nomcentro, min(etiqueta) AS etiqueta, observaciones,
		alumno, color
		from (
			SELECT
		pff.id AS keyid,
		pff.fecha,
		pff.inicio,
		fin,
		'' AS codigo_grupo,
		'' AS grupo,
		'' AS codigo_actividad,

		CONCAT(epf.descripcion,': ',pff.observaciones) AS actividad,

		pff.idprofesor,
		'' AS custom_fields,
		'' AS event_id,
		'' AS idaula,
		au.nombre AS aula,
		'' AS festivo,
		'' AS idlogin,
		'' AS nomcentro,
		pff.etiqueta,
		pff.observaciones,
		'' AS alumno,
		2982922 AS color
		FROM
		profesor_fechas AS pff
		LEFT JOIN aulas AS au
		ON pff.idaula = au.idaula
		LEFT JOIN etiquetas_profesor AS epf
		ON pff.etiqueta = epf.id
		WHERE pff.fecha >= (DATE_ADD(CURDATE(), INTERVAL - 1 YEAR))
		 AND pff.idprofesor=".$userid."
	UNION
		SELECT DISTINCT
			0 AS keyid, ag.fecha, ag.inicio, ag.fin,
			'' AS codigo_grupo, '' AS grupo,
			cu.codigo AS codigo_actividad, cu.curso AS actividad,
			ag.iprofesor AS idprofesor,  '' AS custom_fields, '' AS event_id, au.idaula,
			au.nombre AS aula, '' AS festivo, '' AS idlogin,
			tc.nombre AS nomcentro, 0 AS etiqueta, '' AS observaciones,
			al.cnomcli AS alumno , cu.IdColor AS color
		FROM
		  agenda AS ag
		  LEFT JOIN aulas AS au
			ON ag.aula = au.idaula
		  LEFT JOIN curso As cu
			on ag.ccurso = cu.codigo
		  LEFT JOIN alumnos AS al
			ON ag.calumno = al.ccodcli
		  LEFT JOIN matriculat AS mt
			ON ag.matricula = mt.nummatricula
		  LEFT JOIN `centros formacion` AS tc
			ON mt.idcentro = tc.id
		WHERE (mt.estado = 1) and ((ag.iprofesor = ".$userid.") OR (ag.idprofesoraux = ".$userid.") OR (ag.idprofesoraux2 = ".$userid.") OR (ag.idprofesoraux3 = ".$userid."))
		  AND (ag.codigogrupo = '' or ag.codigogrupo is null)
		  AND ag.fecha >= (DATE_ADD(CURDATE(), INTERVAL -1 YEAR))
		UNION
			SELECt DISTINCt
				0 AS keyid, agg.fecha, agg.inicio, agg.fin, gr.codigogrupo AS codigo_grupo,
				gr.descripcion AS grupo, cu.codigo AS codigo_actividad, cu.curso AS actividad,
				agg.iprofesor AS idprofesor,  agg.custom_fields AS custom_fields, agg.id AS event_id, au.idaula, au.nombre AS aula, '' AS festivo,
				'' AS idlogin, tc.nombre AS nomcentro, 1 AS etiqueta, '' AS observaciones,
				'' AS alumno , cu.IdColor AS color
		FROM
		  agendagrupos AS agg
		  LEFT JOIN curso AS cu
			 ON agg.ccurso = cu.codigo
		 INNER JOIN grupos AS gr
			 ON agg.codigogrupo = gr.codigogrupo
		LEFT JOIN aulas AS au
			 ON agg.aula = au.idaula
		LEFT JOIN `centros formacion` AS tc
			ON gr.idcentro = tc.id
		WHERE (agg.codigogrupo is not null AND agg.codigogrupo<>'') AND (gr.estado =1)
		AND ((agg.iprofesor = ".$userid.") OR (agg.idprofesoraux = ".$userid.") OR (agg.idprofesoraux2 = ".$userid.") OR (agg.idprofesoraux3 = ".$userid."))
		AND agg.fecha >= (DATE_ADD(CURDATE(), INTERVAL -1 YEAR))
		UNION
				SELECT DISTINCt
					0 AS keyid, fecha, '0800' AS inicio, '2359' AS fin,
					'' AS codigo_grupo, '' AS grupo, '' AS codigo_actividad,
					'' AS actividad, '' AS idprofesor,  '' AS custom_fields, '' AS event_id,'' AS idaula, '' AS aula,
					descripcion AS festivo, '' AS idlogin, tc.nombre AS nomcentro,
					1 AS etiqueta, '' AS observaciones, '' AS alumno ,0 AS color
				FROM festividades
					LEFT JOIN `centros formacion` AS tc ON festividades.idcentro=tc.id
				WHERE
					(festividades.idcentro=0 or festividades.idcentro=-1)) AS t1 GROUP BY keyid,
					fecha, inicio, fin, codigo_grupo, grupo, codigo_actividad, actividad,
					idprofesor, idaula, aula, festivo, idlogin, nomcentro, observaciones, alumno";
//buscamos los datos que necesitamos
	$sql3 = "SELECT
		concat(concat(DATE(sb.fecha) ,' '), TIME(concat(sb.inicio,'00'))) AS `start_date`,
		concat(concat(DATE(sb.fecha) ,' '), TIME(concat(sb.fin,'00'))) AS `end_date`,
		TIME(concat(sb.inicio,'00')) AS `stime`,
		TIME(concat(sb.fin,'00')) AS `etime`,
		sb.actividad AS text,
		DATE(sb.fecha) AS `dt`,
		TIME(concat(sb.inicio,'00')) AS `stime`,
		TIME(concat(sb.fin,'00')) AS `etime`,
		pro.nombre AS teacher,
		sb.aula AS classroom,
		'' AS `eventcolor`,
		HEX( sb.color ) AS `eventcolor`,
		sb.*
	FROM
		($sql2) AS sb
		, (SELECT profesor.INDICE AS id , profesor.nombre FROM profesor union select '' AS id , '' AS nombre ) AS pro
	WHERE
		$extra_sql
		sb.idprofesor = pro.id
	";
		return $this->selectCustom($sql3);
	}

	public function getStudentEvents($student_id, $from, $to){

		$sql = "SELECT DISTINCT 
				  CONCAT(
					CONCAT(DATE(ag.fecha), ' '),
					TIME(CONCAT(ag.inicio, '00'))
				  ) AS `start_date`,
				  CONCAT(
					CONCAT(DATE(ag.fecha), ' '),
					TIME(CONCAT(ag.fin, '00'))
				  ) AS `end_date`,
				  cu.curso AS `text`,
				  au.Nombre AS `classroom`,
				  pf.nombre AS `teacher`,
				  pf1.nombre AS `aux_teacher_1_name`,
				  pf2.nombre AS `aux_teacher_2_name`,
				  pf3.nombre AS `aux_teacher_3_name`,
				  agg.custom_fields AS custom_fields,
				  ag.agendagrupos_id AS event_id,
				  DATE(ag.fecha) AS `dt`,
				  ag.inicio AS `stime`,
				  ag.fin AS `etime`,
				  HEX(cu.IdColor) AS `eventcolor`,
				  NULL AS festivity 
				FROM
				  agenda AS ag 
				  LEFT JOIN aulas AS au 
					ON ag.aula = au.idaula 
				  LEFT JOIN agendagrupos as agg
				  ON agg.id = ag.agendagrupos_id
 				  LEFT JOIN profesor AS pf 
					ON ag.iprofesor = pf.indice 
				  LEFT JOIN profesor AS pf1 
					ON ag.idprofesoraux = pf1.indice 
				  LEFT JOIN profesor AS pf2 
					ON ag.idprofesoraux2 = pf2.indice 
				  LEFT JOIN profesor AS pf3 
					ON ag.idprofesoraux3 = pf3.indice 
				  LEFT JOIN curso AS cu 
					ON ag.ccurso = cu.codigo 
				  LEFT JOIN alumnos AS al 
					ON ag.calumno = al.ccodcli 
				  LEFT JOIN matriculat AS mt 
					ON ag.matricula = mt.nummatricula ";
							if (trim($from) != '' && trim($to) != '' ){
								$sql .= " WHERE CONCAT(DATE(ag.fecha)) BETWEEN '".$from."'' AND '".$to."') ";
							}

							$sql .=	"WHERE ag.`CALUMNO`= '".$student_id."'
									 AND mt.`Estado` = 1
				
									UNION
									SELECT DISTINCT 
				  CONCAT(
					CONCAT(DATE(fe.Fecha), ' '),
					TIME(CONCAT('00:00', '00'))
				  ) AS `start_date`,
				  CONCAT(
					CONCAT(DATE(fe.fecha), ' '),
					TIME(CONCAT('00:00', '00'))
				  ) AS `end_date`,
				  Descripcion AS `text`,
				  '' AS `classroom`,
				  '' AS `teacher`,
				  '' AS aux_teacher_1_name,
				  '' AS aux_teacher_2_name,
				  '' AS aux_teacher_2_name,
				  '' AS custom_fields,
				  '' AS event_id,
				  DATE(fe.Fecha) AS `dt`,
				  '0800' AS `stime`,
				  '2359' AS `etime`,
				  'FF8888' AS `eventcolor`,
				  'true' AS festivity 
				FROM
				  festividades AS fe 
				ORDER BY start_date DESC 
					 ;
					 ";
		return $this->selectCustom($sql);

	}
}
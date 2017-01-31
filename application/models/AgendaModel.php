<?php

class AgendaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "agenda";
    }

    public function sa_class_dates($course_id, $user_id){
       if($user_id) {
           $sql_dates = "SELECT DISTINCT ag.FECHA
            FROM agenda AS ag
            LEFT JOIN profesor AS pr
            ON (ag.IPROFESOR = pr.INDICE)
            WHERE
            ((ag.CodigoGrupo = '' OR ag.CodigoGrupo IS NULL) AND ag.CCURSO = '" . $course_id . "')
            AND ((ag.iprofesor = '" . $user_id . "') OR (ag.idprofesoraux = '" . $user_id . "') OR (ag.idprofesoraux2 = '" . $user_id . "') OR (ag.idprofesoraux3 = '" . $user_id . "')
            OR ((SELECT sc_superprofesor FROM profesor WHERE indice='" . $user_id . "') >0))
            AND (ag.fecha <= NOW())
            ORDER BY ag.FECHA";
       }else{
           $sql_dates = "SELECT DISTINCT ag.FECHA
            FROM agenda AS ag
            LEFT JOIN profesor AS pr
            ON (ag.IPROFESOR = pr.INDICE)
            WHERE
            ((ag.CodigoGrupo = '' OR ag.CodigoGrupo IS NULL) AND ag.CCURSO = '" . $course_id . "')
            AND (ag.fecha <= NOW())
            ORDER BY ag.FECHA";
       }
        return $this->selectCustom($sql_dates);

    }

    public function sa_franja_horaria($groupid,$courseid,$date,$iduser){
        if($iduser) {
            $sql = "SELECT
			 ag.INICIO AS INICIO,
			 ag.FIN AS FIN
			FROM
			 agenda AS ag
			 LEFT JOIN alumnos AS al
			   ON ag.CALUMNO = al.CCODCLI
			 LEFT JOIN matriculal AS ml
			   ON ag.MATRICULA = ml.NumMatricula
			 LEFT JOIN estado_actividad_matricula AS eam
			   ON ml.IdEstado = eam.Id
			 WHERE ((ag.CodigoGrupo = '" . $groupid . "') AND (ag.CCURSO = '" . $courseid . "')
			   AND (Fecha = '" . $date . "'))
			   AND ((((ag.iprofesor = '" . $iduser . "') OR (ag.idprofesoraux = '" . $iduser . "') OR (ag.idprofesoraux2 = '" . $iduser . "') OR (ag.idprofesoraux3 = '" . $iduser . "'))
			   OR ((SELECT sc_superprofesor FROM profesor WHERE indice='" . $iduser . "') >0)))
			GROUP BY 1,2
			ORDER BY 1,2";
        }else{
            $sql = "SELECT
			 ag.INICIO AS INICIO,
			 ag.FIN AS FIN
			FROM
			 agenda AS ag
			 LEFT JOIN alumnos AS al
			   ON ag.CALUMNO = al.CCODCLI
			 LEFT JOIN matriculal AS ml
			   ON ag.MATRICULA = ml.NumMatricula
			 LEFT JOIN estado_actividad_matricula AS eam
			   ON ml.IdEstado = eam.Id
			 WHERE ((ag.CodigoGrupo = '" . $groupid . "') AND (ag.CCURSO = '" . $courseid . "')
			   AND (Fecha = '" . $date . "'))
			GROUP BY 1,2
			ORDER BY 1,2";
        }
        return $this->selectCustom($sql);

    }

    public function sa_attendees($courseid, $groupid, $date, $user_id) {

        if ((($groupid == "0") || ($groupid == '') || ($groupid == null)) && $user_id) {

            $sql_attendees = "SELECT DISTINCT
                                 ag.CALUMNO AS IdAlumno,
                                 ag.Indice AS Id,
                                 ag.CCURSO AS IdActividad,
                                 ag.FECHA,
                                 ag.INICIO AS INICIO,
                                 ag.FIN AS FIN,
                                 CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                 CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                 CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
                                 ag.IPROFESOR AS IdProfesor,
                                 ag.ESTADO AS IdEstado,
                                 CONCAT(al.sapellidos,', ',al.snombre) as Alumno,
                                 al.sNombre,
                                 al.sApellidos,
                                 ml.IdEstado as ml_IdEstado,
                                 ag.MATRICULA as matricula,
                                 eam.Valor as `estmat`,
                                 0 as ausencias


                                FROM
                                 agenda AS ag
                                 LEFT JOIN alumnos AS al
                                   ON ag.CALUMNO = al.CCODCLI
                                 LEFT JOIN matriculal as ml
                                   ON ag.MATRICULA = ml.NumMatricula AND ag.ccurso=ml.codigocurso
                                 LEFT JOIN matriculat as mt
                                   ON ag.MATRICULA = mt.nummatricula
                                 LEFT JOIN estado_actividad_matricula as eam
                                   ON ml.IdEstado = eam.Id
                                    WHERE ((ag.CodigoGrupo IS NULL OR ag.CodigoGrupo='') AND (ag.CCURSO = '".$courseid."') AND (Fecha = '".$date." 00:00:00'))
                                   AND (((ag.iprofesor = '".$user_id."') OR (ag.idprofesoraux = '".$user_id."') OR (ag.idprofesoraux2 = '".$user_id."') OR (ag.idprofesoraux3 = '".$user_id."')) OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$user_id."') >0))
                                   AND (mt.esprematricula=0)
                                   AND mt.`Estado` = 1
                                ORDER BY al.sApellidos,
                                 al.sNombre ";


        } elseif($user_id){

            $sql_attendees = "SELECT * FROM (SELECT DISTINCT
                                  ag.CALUMNO AS IdAlumno,
                                  ag.Indice AS Id,
                                  ag.CCURSO AS IdActividad,
                                  ag.FECHA,
                                  ag.INICIO AS INICIO,
                                  ag.FIN AS FIN,
                                  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                  CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                  CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
                                  ag.IPROFESOR AS IdProfesor,
                                  ag.ESTADO AS IdEstado,
                                  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
                                  al.sNombre,
                                  al.sApellidos,
                                  ml.IdEstado AS ml_IdEstado,
                                  ag.MATRICULA AS matricula,
                                  eam.Valor AS `estmat`,
                                  0 AS `Ausencias`,
                                  ag.codigogrupo AS idgrupo,
                                  ag.ccurso AS idcurso,
                                  (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
                                  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

                                FROM agenda AS ag
                                 LEFT JOIN alumnos AS al
                                   ON ag.CALUMNO = al.CCODCLI
                                 LEFT JOIN matriculal as ml
                                   ON ag.MATRICULA = ml.NumMatricula
                                 LEFT JOIN matriculat as mt
                                   ON ag.MATRICULA = mt.nummatricula
                                 LEFT JOIN estado_actividad_matricula as eam
                                   ON ml.IdEstado = eam.Id


                                   WHERE ((ag.Fecha = '".$date." 00:00:00'))
                                   AND ((ag.CodigoGrupo = '".$groupid."') AND (ag.CCURSO = '".$courseid."'))
                                   AND (((ag.iprofesor = '".$user_id."') OR (ag.idprofesoraux = '".$user_id."') OR (ag.idprofesoraux2 = '".$user_id."') OR (ag.idprofesoraux3 = '".$user_id."')) OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$user_id."') >0))
                                   AND mt.`Estado` = 1
                                   AND (mt.esprematricula=0)

                                UNION


                                 SELECT DISTINCT

                                  ag.CALUMNO AS IdAlumno,
                                  ag.Indice AS Id,
                                  ag.CCURSO AS IdActividad,
                                  ag.FECHA,
                                  ag.INICIO AS INICIO,
                                  ag.FIN AS FIN,
                                  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                  CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                  CONCAT(al.`Email`,' ',al.`Email2`) AS emails,

                                  ag.IPROFESOR AS IdProfesor,
                                  ag.ESTADO AS IdEstado,
                                  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
                                  al.sNombre,
                                  al.sApellidos,
                                  ml.IdEstado AS ml_IdEstado,
                                  ag.MATRICULA AS matricula,
                                  eam.Valor AS `estmat`,
                                  0 AS `Ausencias`,
                                  ag.codigogrupo AS idgrupo,
                                  ag.ccurso AS idcurso,

                                 (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
                                  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

                                FROM grupos_clases AS gc
                                 LEFT JOIN agenda AS ag
                                   ON (gc.`codigogrupo2` = ag.`codigogrupo` AND gc.`codigocurso2` = ag.`ccurso`)
                                 LEFT JOIN alumnos AS al
                                   ON ag.CALUMNO = al.CCODCLI
                                 LEFT JOIN matriculal AS ml
                                   ON ag.MATRICULA = ml.NumMatricula
                                 LEFT JOIN matriculat AS mt
                                   ON ag.MATRICULA = mt.nummatricula
                                 LEFT JOIN estado_actividad_matricula AS eam
                                   ON ml.IdEstado = eam.Id

                                 WHERE ((ag.Fecha = '".$date." 00:00:00'))

                                AND ((gc.`codigogrupo1` = '".$groupid."' AND gc.`codigocurso1` = '".$courseid."'))
                                AND (((ag.iprofesor = '".$user_id."') OR (ag.idprofesoraux = '".$user_id."') OR (ag.idprofesoraux2 = '".$user_id."') OR (ag.idprofesoraux3 = '".$user_id."')) OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$user_id."') >0))
                                AND mt.`Estado` = 1
                                AND (mt.esprematricula=0)

                                 ) as t1
                                 ORDER BY idactividad,idgrupo,alumno

                                 ";

        }else{
            $sql_attendees = "SELECT * FROM (SELECT DISTINCT
                                  ag.CALUMNO AS IdAlumno,
                                  ag.Indice AS Id,
                                  ag.CCURSO AS IdActividad,
                                  ag.FECHA,
                                  ag.INICIO AS INICIO,
                                  ag.FIN AS FIN,
                                  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                  CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                  CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
                                  ag.IPROFESOR AS IdProfesor,
                                  ag.ESTADO AS IdEstado,
                                  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
                                  al.sNombre,
                                  al.sApellidos,
                                  ml.IdEstado AS ml_IdEstado,
                                  ag.MATRICULA AS matricula,
                                  eam.Valor AS `estmat`,
                                  0 AS `Ausencias`,
                                  ag.codigogrupo AS idgrupo,
                                  ag.ccurso AS idcurso,
                                  (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
                                  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

                                FROM agenda AS ag
                                 LEFT JOIN alumnos AS al
                                   ON ag.CALUMNO = al.CCODCLI
                                 LEFT JOIN matriculal as ml
                                   ON ag.MATRICULA = ml.NumMatricula
                                 LEFT JOIN matriculat as mt
                                   ON ag.MATRICULA = mt.nummatricula
                                 LEFT JOIN estado_actividad_matricula as eam
                                   ON ml.IdEstado = eam.Id


                                   WHERE ((ag.Fecha = '".$date." 00:00:00'))
                                   AND ((ag.CodigoGrupo = '".$groupid."') AND (ag.CCURSO = '".$courseid."'))
                                   AND mt.`Estado` = 1
                                   AND (mt.esprematricula=0)

                                UNION


                                 SELECT DISTINCT

                                  ag.CALUMNO AS IdAlumno,
                                  ag.Indice AS Id,
                                  ag.CCURSO AS IdActividad,
                                  ag.FECHA,
                                  ag.INICIO AS INICIO,
                                  ag.FIN AS FIN,
                                  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                  CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                  CONCAT(al.`Email`,' ',al.`Email2`) AS emails,

                                  ag.IPROFESOR AS IdProfesor,
                                  ag.ESTADO AS IdEstado,
                                  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
                                  al.sNombre,
                                  al.sApellidos,
                                  ml.IdEstado AS ml_IdEstado,
                                  ag.MATRICULA AS matricula,
                                  eam.Valor AS `estmat`,
                                  0 AS `Ausencias`,
                                  ag.codigogrupo AS idgrupo,
                                  ag.ccurso AS idcurso,

                                 (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
                                  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

                                FROM grupos_clases AS gc
                                 LEFT JOIN agenda AS ag
                                   ON (gc.`codigogrupo2` = ag.`codigogrupo` AND gc.`codigocurso2` = ag.`ccurso`)
                                 LEFT JOIN alumnos AS al
                                   ON ag.CALUMNO = al.CCODCLI
                                 LEFT JOIN matriculal AS ml
                                   ON ag.MATRICULA = ml.NumMatricula
                                 LEFT JOIN matriculat AS mt
                                   ON ag.MATRICULA = mt.nummatricula
                                 LEFT JOIN estado_actividad_matricula AS eam
                                   ON ml.IdEstado = eam.Id

                                 WHERE ((ag.Fecha = '".$date." 00:00:00'))

                                AND ((gc.`codigogrupo1` = '".$groupid."' AND gc.`codigocurso1` = '".$courseid."'))
                                AND mt.`Estado` = 1
                                AND (mt.esprematricula=0)

                                 ) as t1
                                 ORDER BY idactividad,idgrupo,alumno

                                 ";
        }

        return $this->selectCustom($sql_attendees);
    }

    public function sa_attendees2($courseid, $groupid, $date, $user_id,$start){

        if((($groupid=="0") || ($groupid== '') || ($groupid== NULL)) && $user_id){

            $sql_attendees = "SELECT DISTINCT
								 ag.CALUMNO AS IdAlumno,
								 ag.Indice AS Id,
								 ag.CCURSO AS IdActividad,
								 ag.FECHA,
								 ag.INICIO AS INICIO,
								 ag.FIN AS FIN,
								 CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                 CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                 CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
								 ag.IPROFESOR AS IdProfesor,
								 ag.ESTADO AS IdEstado,
								 CONCAT(al.sapellidos,', ',al.snombre) as Alumno,
								 al.sNombre,
								 al.sApellidos,
								 ml.IdEstado as ml_IdEstado,
								 ag.MATRICULA as matricula,
								 eam.Valor as `estmat`
								FROM
								 agenda AS ag
								 LEFT JOIN alumnos AS al
								   ON ag.CALUMNO = al.CCODCLI
								 LEFT JOIN matriculal as ml
								   ON ag.MATRICULA = ml.NumMatricula
								 LEFT JOIN matriculat as mt
								   ON ag.MATRICULA = mt.nummatricula
								 LEFT JOIN estado_actividad_matricula as eam
								   ON ml.IdEstado = eam.Id
									WHERE ((ag.CodigoGrupo IS NULL OR ag.CodigoGrupo='') AND (ag.CCURSO = '".$courseid."') AND (Fecha = '".$date." 00:00:00'))
								   AND (((ag.iprofesor = '".$user_id."') OR (ag.idprofesoraux = '".$user_id."') OR (ag.idprofesoraux2 = '".$user_id."') OR (ag.idprofesoraux3 = '".$user_id."'))
								   OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$user_id."') >0))
								   AND (ag.INICIO=".$start.")
								   AND mt.`Estado` = 1
								ORDER BY al.sApellidos,
								 al.sNombre ";


        } elseif($user_id) {

            $sql_attendees = "SELECT * FROM (SELECT DISTINCT
									  ag.CALUMNO AS IdAlumno,
									  ag.Indice AS Id,
									  ag.CCURSO AS IdActividad,
									  ag.FECHA,
									  ag.INICIO AS INICIO,
									  ag.FIN AS FIN,
									  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                      CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                      CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
									  ag.IPROFESOR AS IdProfesor,
									  ag.ESTADO AS IdEstado,
									  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
									  al.sNombre,
									  al.sApellidos,
									  ml.IdEstado AS ml_IdEstado,
									  ag.MATRICULA AS matricula,
									  eam.Valor AS `estmat`,
									  0 AS `Ausencias`,
									  ag.codigogrupo AS idgrupo,
									  ag.ccurso AS idcurso,
									  (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
									  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

									FROM agenda AS ag
									 LEFT JOIN alumnos AS al
									   ON ag.CALUMNO = al.CCODCLI
									 LEFT JOIN matriculal as ml
									   ON ag.MATRICULA = ml.NumMatricula
									 LEFT JOIN matriculat as mt
									   ON ag.MATRICULA = mt.nummatricula
									 LEFT JOIN estado_actividad_matricula as eam
									   ON ml.IdEstado = eam.Id


									   WHERE ((ag.Fecha = '".$date." 00:00:00'))
									   AND ((ag.CodigoGrupo = '".$groupid."') AND (ag.CCURSO = '".$courseid."'))
									   AND (((ag.iprofesor = '".$user_id."') OR (ag.idprofesoraux = '".$user_id."') OR (ag.idprofesoraux2 = '".$user_id."') OR (ag.idprofesoraux3 = '".$user_id."'))
									   OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$user_id."') >0))
									   AND (ag.inicio=".$start.")
									   AND mt.`Estado` = 1
									   AND (mt.esprematricula=0)

									UNION


									 SELECT DISTINCT

									  ag.CALUMNO AS IdAlumno,
									  ag.Indice AS Id,
									  ag.CCURSO AS IdActividad,
									  ag.FECHA,
									  ag.INICIO AS INICIO,
									  ag.FIN AS FIN,
									  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                      CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                      CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
									  ag.IPROFESOR AS IdProfesor,
									  ag.ESTADO AS IdEstado,
									  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
									  al.sNombre,
									  al.sApellidos,
									  ml.IdEstado AS ml_IdEstado,
									  ag.MATRICULA AS matricula,
									  eam.Valor AS `estmat`,
									  0 AS `Ausencias`,
									  ag.codigogrupo AS idgrupo,
									  ag.ccurso AS idcurso,

									 (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
									  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

									FROM grupos_clases AS gc
									 LEFT JOIN agenda AS ag
									   ON (gc.`codigogrupo2` = ag.`codigogrupo` AND gc.`codigocurso2` = ag.`ccurso`)
									 LEFT JOIN alumnos AS al
									   ON ag.CALUMNO = al.CCODCLI
									 LEFT JOIN matriculal AS ml
									   ON ag.MATRICULA = ml.NumMatricula
									 LEFT JOIN matriculat AS mt
									   ON ag.MATRICULA = mt.nummatricula
									 LEFT JOIN estado_actividad_matricula AS eam
									   ON ml.IdEstado = eam.Id

									 WHERE ((ag.Fecha = '".$date." 00:00:00'))

									AND ((gc.`codigogrupo1` = '".$groupid."' AND gc.`codigocurso1` = '".$courseid."'))
									AND (((ag.iprofesor = '".$user_id."') OR (ag.idprofesoraux = '".$user_id."') OR (ag.idprofesoraux2 = '".$user_id."') OR (ag.idprofesoraux3 = '".$user_id."'))
									OR ((SELECT sc_superprofesor FROM profesor WHERE indice='".$user_id."') >0))
									AND (ag.inicio=".$start.")
									AND mt.`Estado` = 1
									AND (mt.esprematricula=0)

									 ) as t1
									 ORDER BY idactividad,idgrupo,alumno

									";
        }else{
            $sql_attendees = "SELECT * FROM (SELECT DISTINCT
									  ag.CALUMNO AS IdAlumno,
									  ag.Indice AS Id,
									  ag.CCURSO AS IdActividad,
									  ag.FECHA,
									  ag.INICIO AS INICIO,
									  ag.FIN AS FIN,
									  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                      CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                      CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
									  ag.IPROFESOR AS IdProfesor,
									  ag.ESTADO AS IdEstado,
									  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
									  al.sNombre,
									  al.sApellidos,
									  ml.IdEstado AS ml_IdEstado,
									  ag.MATRICULA AS matricula,
									  eam.Valor AS `estmat`,
									  0 AS `Ausencias`,
									  ag.codigogrupo AS idgrupo,
									  ag.ccurso AS idcurso,
									  (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
									  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

									FROM agenda AS ag
									 LEFT JOIN alumnos AS al
									   ON ag.CALUMNO = al.CCODCLI
									 LEFT JOIN matriculal as ml
									   ON ag.MATRICULA = ml.NumMatricula
									 LEFT JOIN matriculat as mt
									   ON ag.MATRICULA = mt.nummatricula
									 LEFT JOIN estado_actividad_matricula as eam
									   ON ml.IdEstado = eam.Id


									   WHERE ((ag.Fecha = '".$date." 00:00:00'))
									   AND ((ag.CodigoGrupo = '".$groupid."') AND (ag.CCURSO = '".$courseid."'))
									   AND (ag.inicio=".$start.")
									   AND mt.`Estado` = 1
									   AND (mt.esprematricula=0)

									UNION


									 SELECT DISTINCT

									  ag.CALUMNO AS IdAlumno,
									  ag.Indice AS Id,
									  ag.CCURSO AS IdActividad,
									  ag.FECHA,
									  ag.INICIO AS INICIO,
									  ag.FIN AS FIN,
									  CONCAT(MID(ag.INICIO,1,2),':',MID(ag.INICIO,3,2),' h. - ',MID(ag.fin,1,2),':',MID(ag.fin,3,2),' h.') AS Time_Interval,
                                      CONCAT(al.`movil`,' ',al.ctfo1cli) AS phone_numbers,
                                      CONCAT(al.`Email`,' ',al.`Email2`) AS emails,
									  ag.IPROFESOR AS IdProfesor,
									  ag.ESTADO AS IdEstado,
									  CONCAT(al.sapellidos, ', ', al.snombre) AS Alumno,
									  al.sNombre,
									  al.sApellidos,
									  ml.IdEstado AS ml_IdEstado,
									  ag.MATRICULA AS matricula,
									  eam.Valor AS `estmat`,
									  0 AS `Ausencias`,
									  ag.codigogrupo AS idgrupo,
									  ag.ccurso AS idcurso,

									 (SELECT concat(codigo,'-',MID(curso,1,80)) FROM curso WHERE codigo = ag.ccurso LIMIT 1) AS curso,
									  (SELECT concat(codigogrupo,'-',MID(descripcion,1,80)) FROM grupos WHERE codigogrupo = ag.`codigogrupo` LIMIT 1) AS grupo

									FROM grupos_clases AS gc
									 LEFT JOIN agenda AS ag
									   ON (gc.`codigogrupo2` = ag.`codigogrupo` AND gc.`codigocurso2` = ag.`ccurso`)
									 LEFT JOIN alumnos AS al
									   ON ag.CALUMNO = al.CCODCLI
									 LEFT JOIN matriculal AS ml
									   ON ag.MATRICULA = ml.NumMatricula
									 LEFT JOIN matriculat AS mt
									   ON ag.MATRICULA = mt.nummatricula
									 LEFT JOIN estado_actividad_matricula AS eam
									   ON ml.IdEstado = eam.Id

									 WHERE ((ag.Fecha = '".$date." 00:00:00'))

									AND ((gc.`codigogrupo1` = '".$groupid."' AND gc.`codigocurso1` = '".$courseid."'))
									AND (ag.inicio=".$start.")
									AND mt.`Estado` = 1
									AND (mt.esprematricula=0)

									 ) as t1
									 ORDER BY idactividad,idgrupo,alumno

									";
        }
        return $this->selectCustom($sql_attendees);
    }

    public function _update($data, $where)
    {
        return parent::update($this->table, $data, $where);
    }

    public function getDates($option, $student_id, $dt, $matricula, $asignatura, $ini, $group_id = null){
        if($option == 0){
            $sql ="SELECT INDICE,Matricula
							FROM agenda
							WHERE CAlumno=".$student_id."
							AND FECHA='".$dt."'
							AND Matricula=".$matricula."
							AND ccurso='".$asignatura."'";


            $sql .=	" AND codigogrupo='".$group_id."'";
        }else{
            $sql ="SELECT INDICE,Matricula
                    FROM agenda
                    WHERE CAlumno=".$student_id."
                    AND FECHA='".$dt."'
                    AND Matricula=".$matricula."
                    AND ccurso='".$asignatura."'
                    AND INICIO='".$ini."'";
        }
        if($group_id){
            $sql .= " AND codigogrupo ='".$group_id."'";
        }else{
            $sql .= " AND (codigogrupo ='' OR codigogrupo IS NULL)";
        }

        $sql .= " LIMIT 1";

        return $this->selectCustom($sql);
    }

    public function getForGroupById($group_id, $course_id = null){
        $where = '';
        if(!empty($course_id)){
           $where =  " AND ag.CCURSO='".$course_id."'";
        }
        $query = "SELECT
                  CONCAT(al.sapellidos,', ',al.snombre) AS student,
                  ag.CCURSO AS course_id,
                  cu.CURSO AS couse,
                  ag.CALUMNO AS student_id,
                  ag.matricula,
                  SUM(IF(ag.estado = 0, ag.numhoras, 0)) AS `Booked`,
                  SUM(IF(ag.estado = 1, ag.numhoras, 0)) AS `Delay`,
                  SUM(IF(ag.estado = 2, ag.numhoras, 0)) AS `Attendance`,
                  SUM(IF(ag.estado = 3, ag.numhoras, 0)) AS `no_attend`,
                  SUM(IF(ag.estado = 4, ag.numhoras, 0)) AS `Cancelled`,
                  SUM(ag.NumHoras) AS `Total`
                FROM
                  agenda AS ag
                  INNER JOIN curso AS cu
                    ON ag.CCURSO = cu.CODIGO
                  INNER JOIN matriculal AS ml
                    ON ((ag.matricula = ml.NumMatricula) AND (ag.ccurso = ml.codigocurso))
                  INNER JOIN alumnos AS al
                    ON ag.calumno = al.ccodcli
                WHERE ag.codigogrupo = '".$group_id."'
                      ".$where."
                GROUP BY al.ccodcli,ag.CCURSO,cu.CURSO
                ORDER BY 1,2";
        return $this->selectCustom($query);
    }
    public function getForGroupByIdForEnroll($group_id, $course_id = null){
        $where = '';
        if(!empty($course_id)){
           $where =  " AND ml.`codigocurso` ='".$course_id."'";
        }
        $query = "
                 SELECT 
                 ml.nummatricula AS matricula, 
                 CONCAT(al.`sApellidos`,', ',al.`sNombre`) Student_name,
                 al.CCODCLI as student_id
                FROM matriculal AS ml
                LEFT JOIN matriculat AS mt
                ON ml.`NumMatricula`= mt.`NumMatricula`
                LEFT JOIN alumnos AS al
                ON mt.`CCODCLI`= al.`CCODCLI`
                WHERE mt.`Estado`=1
               AND ml.`IdGrupo` = '".$group_id."'
                      ".$where;
        return $this->selectCustom($query);
    }

    public function getForSchedules($start, $end, $type, $ids){
        
        switch($type){
            case "teachers":
                $extra_where = " AND pf.INDICE IN ( ".$ids." ) ";
                break;
            case "classrooms":
                $extra_where = " AND au.IdAula IN ( ".$ids." ) ";
                break;
            case "groups":
                $extra_where = " AND gr.CodigoGrupo IN ( ".$ids." ) ";
                break;
            case "courses":
                $extra_where = " AND cu.CODIGO IN ( ".$ids." ) ";
                break;
            default:
                $extra_where = "";
        }

        $query = "SELECT
                      ag.FECHA AS event_date,
                      ag.INICIO AS start_time,
                      ag.FIN AS end_time,
                      '008282' AS event_color,
                      gr.CodigoGrupo AS group_id,
                      gr.Descripcion AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      au.IdAula classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      NULL AS event_id,
                      NULL AS event_name,
                      NULL AS comments,
                      NULL AS event_type
                    FROM agenda AS ag LEFT JOIN grupos AS gr ON ag.CodigoGrupo = gr.CodigoGrupo
                      LEFT JOIN aulas AS au ON ag.Aula = au.IdAula
                      LEFT JOIN profesor AS pf ON ag.IPROFESOR = pf.INDICE
                      LEFT JOIN curso AS cu ON ag.CCURSO = cu.CODIGO
                      LEFT JOIN alumnos AS al ON ag.CALUMNO=al.CCODCLI
                      LEFT JOIN matriculat AS mt ON ag.Matricula=mt.NumMatricula
                      LEFT JOIN `centros formacion` AS tc ON gr.idcentro=tc.id
                    WHERE mt.nummatricula IS NOT NULL
                          AND mt.estado IN (1,2)
                          AND fecha BETWEEN '".$start."' AND '".$end."'
                          AND cu.tipo<>3 
                          ".$extra_where." 
                    GROUP BY ag.FECHA, ag.INICIO, ag.FIN, gr.CodigoGrupo, cu.CODIGO, pf.INDICE, au.IdAula
                    
                    UNION
                    
                    SELECT
                      agg.Fecha AS event_date,
                      agg.Inicio AS start_time,
                      agg.Fin AS end_time,
                      'a8d1ff' AS event_color,
                      gr.CodigoGrupo AS group_id,
                      gr.Descripcion AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      au.IdAula AS classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      NULL AS event_id,
                      NULL AS event_name,
                      NULL AS comments,
                      NULL AS event_type
                    FROM agendagrupos AS agg LEFT JOIN curso AS cu ON agg.CCurso = cu.CODIGO
                      LEFT JOIN grupos AS gr ON agg.CodigoGrupo = gr.CodigoGrupo
                      LEFT JOIN profesor AS pf ON agg.IProfesor = pf.INDICE
                      LEFT JOIN aulas AS au ON agg.Aula = au.IdAula
                      LEFT JOIN matriculal AS ml ON ml.IdGrupo=agg.codigogrupo AND ml.codigocurso=agg.ccurso AND (ml.idEstado <> 1 OR ml.idEstado IS NULL)
                      LEFT JOIN matriculat AS mt ON ml.nummatricula=mt.nummatricula AND mt.estado IN (1,2)
                      LEFT JOIN alumnos AS al ON mt.CCODCLI=al.CCODCLI
                      LEFT JOIN `centros formacion` AS tc ON gr.idcentro=tc.id
                    WHERE (gr.codigogrupo IS NOT NULL)
                          AND fecha BETWEEN '".$start."'
                          AND '".$end."'
                          AND cu.tipo<>3
                          AND (gr.estado IN (1)) 
                          ".$extra_where." 
                    GROUP BY agg.FECHA, agg.INICIO, agg.FIN, gr.CodigoGrupo, cu.CODIGO, pf.INDICE, au.IdAula
                    
                    UNION
                    
                    SELECT
                      af.FECHA AS event_date,
                      af.INICIO AS start_time,
                      af.FIN AS end_time,
                      HEX(ea.color) AS event_color,
                      NULL AS group_id,
                      NULL AS group_name,
                      NULL AS course_id,
                      NULL AS course_name,
                      NULL AS teacher_id,
                      NULL AS teacher_name,
                      au.IdAula AS classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity,
                      af.etiqueta AS event_id,
                      ea.descripcion AS event_name,
                      af.observaciones AS comments,
                      ea.idtipo AS event_type
                    FROM aula_fechas AS af LEFT JOIN etiquetas_aula AS ea ON af.etiqueta=ea.id
                      LEFT JOIN aulas AS au ON af.idaula=au.idaula
                      LEFT JOIN `centros formacion` AS tc ON au.idcentro=tc.id
                    WHERE (af.etiqueta IS NOT NULL)
                          AND fecha BETWEEN '".$start."'
                          AND '".$end."'                   
                    
                    ;";
        return $this->selectCustom($query);
    }

    public function getForSchedules_groups($start, $end, $ids){

        $extra_where = " AND agg.`CodigoGrupo` IN ( ".$ids." ) ";

        $query = "SELECT
                      agg.Fecha AS event_date,
                      agg.Inicio AS start_time,
                      agg.Fin AS end_time,
                      HEX(gr.`IdColor`) AS event_color,
                      gr.CodigoGrupo AS group_id,
                      gr.Descripcion AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      pf1.NOMBRE AS second_teacher_1_name,
                      pf2.NOMBRE AS second_teacher_2_name,
                      pf3.NOMBRE AS second_teacher_3_name,
                      au.IdAula AS classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      agg.`id` AS event_id,
                      'Group Class' AS event_name,
                      NULL AS comments,
                      1 AS event_type
                    
                    FROM
                      agendagrupos AS agg
                      LEFT JOIN curso AS cu
                        ON agg.CCurso = cu.CODIGO
                      LEFT JOIN grupos AS gr
                        ON agg.CodigoGrupo = gr.CodigoGrupo
                      LEFT JOIN profesor AS pf
                        ON agg.IProfesor = pf.INDICE
                      LEFT JOIN profesor AS pf1
                        ON agg.idprofesoraux = pf1.INDICE
                      LEFT JOIN profesor AS pf2
                        ON agg.idprofesoraux2 = pf2.INDICE
                      LEFT JOIN profesor AS pf3
                        ON agg.idprofesoraux3 = pf3.INDICE
                      LEFT JOIN aulas AS au
                        ON agg.Aula = au.IdAula
                      LEFT JOIN matriculal AS ml
                        ON ml.IdGrupo = agg.codigogrupo
                           AND ml.codigocurso = agg.ccurso
                           AND (
                             ml.idEstado <> 1
                             OR ml.idEstado IS NULL
                           )
                      LEFT JOIN matriculat AS mt
                        ON ml.nummatricula = mt.nummatricula
                           AND mt.estado IN (1, 2)
                      LEFT JOIN alumnos AS al
                        ON mt.CCODCLI = al.CCODCLI
                    
                    WHERE (gr.codigogrupo IS NOT NULL)
                          AND fecha BETWEEN '".$start."' AND '".$end."'
                          AND cu.tipo <> 3
                          AND (gr.estado IN (1))
                          ".$extra_where." 
                    GROUP BY agg.FECHA,
                      agg.INICIO,
                      agg.FIN,
                      gr.CodigoGrupo,
                      cu.CODIGO,
                      pf.INDICE,
                      au.IdAula
                    
                    
                    UNION
                    
                    SELECT
                      FECHA AS event_date,
                      '0000' AS start_time,
                      '2359' AS end_time,
                      'CB5A5E' AS event_color,
                      NULL AS group_id,
                      NULL AS group_name,
                      NULL AS course_id,
                      NULL AS course_name,
                      NULL AS teacher_id,
                      NULL AS teacher_name,
                      NULL AS second_teacher_1_name,
                      NULL AS second_teacher_2_name,
                      NULL AS second_teacher_3_name,
                      NULL AS classroom_id,
                      NULL AS classroom_name,
                      descripcion AS festivity,
                      NULL AS event_id,
                    'Festivity'  AS event_name,
                    NULL AS comments,
                    0 AS event_type
                    FROM
                    festividades
                    WHERE fecha BETWEEN '".$start."' AND '".$end."'
                    ;";

        return $this->selectCustom($query);
    }

    public function getForSchedules_courses($start, $end, $ids){

        $extra_where = " AND cu.CODIGO IN ( ".$ids." ) ";

        $query = "SELECT 
                      agg.Fecha AS event_date,
                      agg.Inicio AS start_time,
                      agg.Fin AS end_time,
                      'a8d1ff' AS event_color,
                      gr.CodigoGrupo AS group_id,
                      gr.Descripcion AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      pf1.NOMBRE AS second_teacher_1_name,
                      pf2.NOMBRE AS second_teacher_2_name,
                      pf3.NOMBRE AS second_teacher_3_name,
                      au.IdAula AS classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      NULL AS event_id,
                      'Group Class' AS event_name,
                      NULL AS comments,
                      1 AS event_type 
                    
                    FROM
                      agendagrupos AS agg 
                      LEFT JOIN curso AS cu 
                        ON agg.CCurso = cu.CODIGO 
                      LEFT JOIN grupos AS gr 
                        ON agg.CodigoGrupo = gr.CodigoGrupo 
                      LEFT JOIN profesor AS pf 
                        ON agg.IProfesor = pf.INDICE 
                      LEFT JOIN profesor AS pf1
                        ON agg.idprofesoraux = pf1.INDICE
                      LEFT JOIN profesor AS pf2
                        ON agg.idprofesoraux2 = pf2.INDICE
                      LEFT JOIN profesor AS pf3
                        ON agg.idprofesoraux3 = pf3.INDICE
                      LEFT JOIN aulas AS au 
                        ON agg.Aula = au.IdAula 
                      LEFT JOIN matriculal AS ml 
                        ON ml.IdGrupo = agg.codigogrupo 
                        AND ml.codigocurso = agg.ccurso 
                        AND (
                          ml.idEstado <> 1 
                          OR ml.idEstado IS NULL
                        ) 
                      LEFT JOIN matriculat AS mt 
                        ON ml.nummatricula = mt.nummatricula 
                        AND mt.estado IN (1, 2) 
                      LEFT JOIN alumnos AS al 
                        ON mt.CCODCLI = al.CCODCLI 
                    WHERE (gr.codigogrupo IS NOT NULL) 
                      AND fecha BETWEEN '".$start."' AND '".$end."' 
                      AND cu.tipo <> 3 
                      AND (gr.estado IN (1)) 
                      AND pf.INDICE IN (2, 3, 1) 
                       ".$extra_where." 
                    GROUP BY agg.FECHA,
                      agg.INICIO,
                      agg.FIN,
                      gr.CodigoGrupo,
                      cu.CODIGO,
                      pf.INDICE,
                      au.IdAula 
                      
                    UNION
                    
                    SELECT 
                      ag.FECHA AS event_date,
                      ag.INICIO AS start_time,
                      ag.FIN AS end_time,
                      '008282' AS event_color,
                      '' AS group_id,
                      '' AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      pf1.NOMBRE AS second_teacher_1_name,
                      pf2.NOMBRE AS second_teacher_2_name,
                      pf3.NOMBRE AS second_teacher_3_name,
                      au.IdAula classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      NULL AS event_id,
                      'Individual Class' AS event_name,
                      NULL AS comments,
                      '2' AS event_type 
                    FROM
                      agenda AS ag 
                      LEFT JOIN aulas AS au 
                        ON ag.Aula = au.IdAula 
                      LEFT JOIN profesor AS pf 
                        ON ag.IPROFESOR = pf.INDICE 
                      LEFT JOIN profesor AS pf1
                        ON ag.idprofesoraux = pf1.INDICE
                      LEFT JOIN profesor AS pf2
                        ON ag.idprofesoraux2 = pf2.INDICE
                      LEFT JOIN profesor AS pf3
                        ON ag.idprofesoraux3 = pf3.INDICE
                      LEFT JOIN curso AS cu 
                        ON ag.CCURSO = cu.CODIGO 
                      LEFT JOIN alumnos AS al 
                        ON ag.CALUMNO = al.CCODCLI 
                      LEFT JOIN matriculat AS mt 
                        ON ag.Matricula = mt.NumMatricula 
                    WHERE mt.nummatricula IS NOT NULL 
                      AND mt.estado IN (1, 2) 
                      AND fecha BETWEEN '".$start."' AND '".$end."'
                      AND cu.tipo <> 3 
                      AND pf.INDICE IN (2, 3, 1) 
                       ".$extra_where." 
                    GROUP BY ag.FECHA,
                      ag.INICIO,
                      ag.FIN,
                      cu.CODIGO,
                      pf.INDICE,
                      au.IdAula 
                        
                    UNION
                    
                    SELECT 
                      FECHA AS event_date,
                      '0000' AS start_time,
                      '2359' AS end_time,
                      'CB5A5E' AS event_color,
                      NULL AS group_id,
                      NULL AS group_name,
                      NULL AS course_id,
                      NULL AS course_name,
                      NULL AS teacher_id,
                      NULL AS teacher_name,
                      NULL AS second_teacher_1_name,
                      NULL AS second_teacher_2_name,
                      NULL AS second_teacher_3_name,
                      NULL AS classroom_id,
                      NULL AS classroom_name,
                      descripcion AS festivity,
                      NULL AS event_id,
                      'Festivity' AS event_name,
                      NULL AS comments,
                      0 AS event_type 
                    FROM
                      festividades
                    WHERE fecha BETWEEN '".$start."' AND '".$end."'
                        ;";

        return $this->selectCustom($query);
    }

    public function getForSchedules_classrooms($start, $end, $ids){

        $extra_where = " AND au.IdAula IN ( ".$ids." ) ";

        $query = "SELECT 
                      agg.Fecha AS event_date,
                      agg.Inicio AS start_time,
                      agg.Fin AS end_time,
                      'a8d1ff' AS event_color,
                      gr.CodigoGrupo AS group_id,
                      gr.Descripcion AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      pf1.NOMBRE AS second_teacher_1_name,
                      pf2.NOMBRE AS second_teacher_2_name,
                      pf3.NOMBRE AS second_teacher_3_name,
                      au.IdAula AS classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      NULL AS event_id,
                      'Group Class' AS event_name,
                      NULL AS comments,
                      1 AS event_type 
                    FROM
                      agendagrupos AS agg 
                      LEFT JOIN curso AS cu 
                        ON agg.CCurso = cu.CODIGO 
                      LEFT JOIN grupos AS gr 
                        ON agg.CodigoGrupo = gr.CodigoGrupo 
                      LEFT JOIN profesor AS pf 
                        ON agg.IProfesor = pf.INDICE 
                      LEFT JOIN profesor AS pf1
                        ON agg.idprofesoraux = pf1.INDICE
                      LEFT JOIN profesor AS pf2
                        ON agg.idprofesoraux2 = pf2.INDICE
                      LEFT JOIN profesor AS pf3
                        ON agg.idprofesoraux3 = pf3.INDICE
                      LEFT JOIN aulas AS au 
                        ON agg.Aula = au.IdAula 
                      LEFT JOIN matriculal AS ml 
                        ON ml.IdGrupo = agg.codigogrupo 
                        AND ml.codigocurso = agg.ccurso 
                        AND (
                          ml.idEstado <> 1 
                          OR ml.idEstado IS NULL
                        ) 
                      LEFT JOIN matriculat AS mt 
                        ON ml.nummatricula = mt.nummatricula 
                        AND mt.estado IN (1, 2) 
                      LEFT JOIN alumnos AS al 
                        ON mt.CCODCLI = al.CCODCLI 
                    WHERE (gr.codigogrupo IS NOT NULL) 
                      AND fecha BETWEEN '".$start."' AND '".$end."' 
                      AND cu.tipo <> 3 
                      AND (gr.estado IN (1)) 
                      AND pf.INDICE IN (2, 3, 1) 
                      ".$extra_where." 
                    GROUP BY agg.FECHA,
                      agg.INICIO,
                      agg.FIN,
                      gr.CodigoGrupo,
                      cu.CODIGO,
                      pf.INDICE,
                      au.IdAula 
                      
                    UNION
                    
                    SELECT 
                      ag.FECHA AS event_date,
                      ag.INICIO AS start_time,
                      ag.FIN AS end_time,
                      '008282' AS event_color,
                      '' AS group_id,
                      '' AS group_name,
                      cu.CODIGO AS course_id,
                      cu.CURSO AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      pf1.NOMBRE AS second_teacher_1_name,
                      pf2.NOMBRE AS second_teacher_2_name,
                      pf3.NOMBRE AS second_teacher_3_name,
                      au.IdAula classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      NULL AS event_id,
                      'Individual Class' AS event_name,
                      NULL AS comments,
                      '2' AS event_type 
                    FROM
                      agenda AS ag 
                      LEFT JOIN aulas AS au 
                        ON ag.Aula = au.IdAula 
                      LEFT JOIN profesor AS pf 
                        ON ag.IPROFESOR = pf.INDICE 
                      LEFT JOIN profesor AS pf1
                        ON ag.idprofesoraux = pf1.INDICE
                      LEFT JOIN profesor AS pf2
                        ON ag.idprofesoraux2 = pf2.INDICE
                      LEFT JOIN profesor AS pf3
                        ON ag.idprofesoraux3 = pf3.INDICE
                      LEFT JOIN curso AS cu 
                        ON ag.CCURSO = cu.CODIGO 
                      LEFT JOIN alumnos AS al 
                        ON ag.CALUMNO = al.CCODCLI 
                      LEFT JOIN matriculat AS mt 
                        ON ag.Matricula = mt.NumMatricula 
                    WHERE mt.nummatricula IS NOT NULL 
                      AND mt.estado IN (1, 2) 
                      AND fecha BETWEEN '".$start."' AND '".$end."' 
                      AND cu.tipo <> 3 
                      AND pf.INDICE IN (2, 3, 1) 
                      ".$extra_where." 
                    GROUP BY ag.FECHA,
                      ag.INICIO,
                      ag.FIN,
                      cu.CODIGO,
                      pf.INDICE,
                      au.IdAula 
                        
                    UNION
                    
                    SELECT 
                      af.FECHA AS event_date,
                      af.INICIO AS start_time,
                      af.FIN AS end_time,
                      HEX(ea.`color`) AS event_color,
                      '' AS group_id,
                      '' AS group_name,
                      '' AS course_id,
                      '' AS course_name,
                      pf.INDICE AS teacher_id,
                      pf.NOMBRE AS teacher_name,
                      '' AS second_teacher_1_name,
                      '' AS second_teacher_2_name,
                      '' AS second_teacher_3_name,
                      au.IdAula classroom_id,
                      au.Nombre AS classroom_name,
                      NULL AS festivity_name,
                      af.`id` AS event_id,
                      ea.`descripcion` AS event_name,
                      af.`titulo` AS comments,
                      '3' AS event_type 
                     
                    FROM aula_fechas AS af
                    LEFT JOIN aulas AS au
                    ON af.idaula = au.`IdAula`
                    LEFT JOIN etiquetas_aula AS ea
                    ON af.`etiqueta` = ea.id
                    LEFT JOIN profesor AS pf
                    ON af.`idprofesor` = pf.`INDICE`
                    
                    UNION
                    
                    SELECT 
                      FECHA AS event_date,
                      '0000' AS start_time,
                      '2359' AS end_time,
                      'CB5A5E' AS event_color,
                      NULL AS group_id,
                      NULL AS group_name,
                      NULL AS course_id,
                      NULL AS course_name,
                      NULL AS teacher_id,
                      NULL AS teacher_name,
                      NULL AS second_teacher_1_name,
                      NULL AS second_teacher_2_name,
                      NULL AS second_teacher_3_name,
                      NULL AS classroom_id,
                      NULL AS classroom_name,
                      descripcion AS festivity,
                      NULL AS event_id,
                      'Festivity' AS event_name,
                      NULL AS comments,
                      0 AS event_type 
                    FROM
                      festividades
                    WHERE fecha BETWEEN '".$start."' AND '".$end."'                       
                      ;";

        return $this->selectCustom($query);
    }

    public function getForSchedules_teachers($start, $end, $ids){

        $extra_where = " AND pf.INDICE IN ( ".$ids." ) ";

        $query = "SELECT 
                  agg.Fecha AS event_date,
                  agg.Inicio AS start_time,
                  agg.Fin AS end_time,
                  'a8d1ff' AS event_color,
                  gr.CodigoGrupo AS group_id,
                  gr.Descripcion AS group_name,
                  cu.CODIGO AS course_id,
                  cu.CURSO AS course_name,
                  pf.INDICE AS teacher_id,
                  pf.NOMBRE AS teacher_name,
                  pf1.NOMBRE AS second_teacher_1_name,
                  pf2.NOMBRE AS second_teacher_2_name,
                  pf3.NOMBRE AS second_teacher_3_name,
                  au.IdAula AS classroom_id,
                  au.Nombre AS classroom_name,
                  NULL AS festivity_name,
                  NULL AS event_id,
                  'Group Class' AS event_name,
                  NULL AS comments,
                  1 AS event_type 
                FROM
                  agendagrupos AS agg 
                  LEFT JOIN curso AS cu 
                    ON agg.CCurso = cu.CODIGO 
                  LEFT JOIN grupos AS gr 
                    ON agg.CodigoGrupo = gr.CodigoGrupo 
                  LEFT JOIN profesor AS pf 
                    ON agg.IProfesor = pf.INDICE 
                  LEFT JOIN profesor AS pf1 
                    ON agg.idprofesoraux = pf1.INDICE
                  LEFT JOIN profesor AS pf2 
                    ON agg.idprofesoraux2 = pf2.INDICE
                  LEFT JOIN profesor AS pf3 
                    ON agg.idprofesoraux3 = pf3.INDICE 
                  LEFT JOIN aulas AS au 
                    ON agg.Aula = au.IdAula 
                  LEFT JOIN matriculal AS ml 
                    ON ml.IdGrupo = agg.codigogrupo 
                    AND ml.codigocurso = agg.ccurso 
                    AND (
                      ml.idEstado <> 1 
                      OR ml.idEstado IS NULL
                    ) 
                  LEFT JOIN matriculat AS mt 
                    ON ml.nummatricula = mt.nummatricula 
                    AND mt.estado IN (1, 2) 
                  LEFT JOIN alumnos AS al 
                    ON mt.CCODCLI = al.CCODCLI 
                WHERE (gr.codigogrupo IS NOT NULL) 
                  AND fecha BETWEEN '".$start."' AND '".$end."' 
                  AND cu.tipo <> 3 
                  AND (gr.estado IN (1)) 
                  AND pf.INDICE IN (2, 3, 1)
                    ".$extra_where."
                GROUP BY agg.FECHA,
                  agg.INICIO,
                  agg.FIN,
                  gr.CodigoGrupo,
                  cu.CODIGO,
                  pf.INDICE,
                  au.IdAula 
                  
                UNION
                
                SELECT 
                  ag.FECHA AS event_date,
                  ag.INICIO AS start_time,
                  ag.FIN AS end_time,
                  '008282' AS event_color,
                  '' AS group_id,
                  '' AS group_name,
                  cu.CODIGO AS course_id,
                  cu.CURSO AS course_name,
                  pf.INDICE AS teacher_id,
                  pf.NOMBRE AS teacher_name,
                  pf1.NOMBRE AS second_teacher_1_name,
                  pf2.NOMBRE AS second_teacher_2_name,
                  pf3.NOMBRE AS second_teacher_3_name,
                  au.IdAula classroom_id,
                  au.Nombre AS classroom_name,
                  NULL AS festivity_name,
                  NULL AS event_id,
                  'Individual Class' AS event_name,
                  NULL AS comments,
                  '2' AS event_type 
                FROM
                  agenda AS ag 
                  LEFT JOIN aulas AS au 
                    ON ag.Aula = au.IdAula 
                  LEFT JOIN profesor AS pf 
                    ON ag.IPROFESOR = pf.INDICE
                  LEFT JOIN profesor AS pf1 
                    ON ag.idprofesoraux = pf1.INDICE
                  LEFT JOIN profesor AS pf2 
                    ON ag.idprofesoraux2 = pf2.INDICE
                  LEFT JOIN profesor AS pf3 
                    ON ag.idprofesoraux3 = pf3.INDICE 
                  LEFT JOIN curso AS cu 
                    ON ag.CCURSO = cu.CODIGO 
                  LEFT JOIN alumnos AS al 
                    ON ag.CALUMNO = al.CCODCLI 
                  LEFT JOIN matriculat AS mt 
                    ON ag.Matricula = mt.NumMatricula 
                WHERE mt.nummatricula IS NOT NULL 
                  AND mt.estado IN (1, 2) 
                  AND fecha BETWEEN '".$start."' AND '".$end."' 
                  AND cu.tipo <> 3 
                  AND pf.INDICE IN (2, 3, 1)
                   ".$extra_where."
                GROUP BY ag.FECHA,
                  ag.INICIO,
                  ag.FIN,
                  cu.CODIGO,
                  pf.INDICE,
                  au.IdAula 
                    
                UNION
                
                SELECT 
                  pf.FECHA AS event_date,
                  pf.INICIO AS start_time,
                  pf.FIN AS end_time,
                  HEX(ep.`color`) AS event_color,
                  '' AS group_id,
                  '' AS group_name,
                  '' AS course_id,
                  '' AS course_name,
                  pr.INDICE AS teacher_id,
                  pr.NOMBRE AS teacher_name,
                  '' AS second_teacher_1_name,
                  '' AS second_teacher_2_name,
                  '' AS second_teacher_3_name,
                  au.IdAula classroom_id,
                  au.Nombre AS classroom_name,
                  NULL AS festivity_name,
                  pf.`id` AS event_id,
                  ep.`descripcion` AS event_name,
                  pf.`observaciones` AS comments,
                  '4' AS event_type 
                 
                FROM profesor_fechas AS pf
                LEFT JOIN profesor AS pr
                ON pf.idprofesor = pr.indice
                LEFT JOIN etiquetas_profesor AS ep
                ON pf.`etiqueta` = ep.id
                LEFT JOIN aulas AS au
                ON pf.`idaula` = au.`IdAula`
                
                UNION
                
                SELECT 
                  FECHA AS event_date,
                  '0000' AS start_time,
                  '2359' AS end_time,
                  'CB5A5E' AS event_color,
                  NULL AS group_id,
                  NULL AS group_name,
                  NULL AS course_id,
                  NULL AS course_name,
                  NULL AS teacher_id,
                  NULL AS teacher_name,
                  NULL AS second_teacher_1_name,
                  NULL AS second_teacher_2_name,
                  NULL AS second_teacher_3_name,
                  NULL AS classroom_id,
                  NULL AS classroom_name,
                  descripcion AS festivity,
                  NULL AS event_id,
                  'Festivity' AS event_name,
                  NULL AS comments,
                  0 AS event_type 
                FROM
                  festividades
                WHERE fecha BETWEEN '".$start."' AND '".$end."'                   
                  ;";

        return $this->selectCustom($query);
    }

    public function getEnrollCalendar($enroll_id){
        $query = "SELECT
                    ag.indice AS event_id,
                    DATE(ag.fecha) AS event_date,
                    ag.inicio AS start_time,
                    ag.fin AS end_time,
                    ag.codigogrupo AS group_id,
                    CONCAT(pf.snombre,' ',pf.sapellidos) AS teacher_name,
                    CONCAT(pf1.snombre,' ',pf1.sapellidos) AS second_teacher_name_1,
                    CONCAT(pf2.snombre,' ',pf2.sapellidos) AS second_teacher_name_2,
                    CONCAT(pf3.snombre,' ',pf3.sapellidos) AS second_teacher_name_3,
                    au.nombre AS classroom,
                    ag.ccurso as course,
                    curso.CURSO as course_name

                    FROM agenda AS ag
                    LEFT JOIN profesor AS pf
                    ON ag.iprofesor = pf.indice
                    LEFT JOIN profesor AS pf1
                    ON ag.idprofesoraux = pf1.indice
                    LEFT JOIN profesor AS pf2
                    ON ag.idprofesoraux2 = pf2.indice
                    LEFT JOIN profesor AS pf3
                    ON ag.idprofesoraux3 = pf3.indice
                    LEFT JOIN aulas AS au
                    ON ag.aula = au.idaula
                    LEFT JOIN curso
                    ON ag.ccurso = curso.codigo
                    WHERE ag.matricula = '".$enroll_id."'
                    ORDER BY 2,3";
        return $this->selectCustom($query);
    }

    public function insertEnroll($STUDENT_ID, $GROUP_ID, $ENROL_ID, $course_ids, $START_DATE, $END_DATE){
        $query = "INSERT INTO agenda (
                          cAlumno,
                          fecha,
                          Matricula,
                          cCurso,
                          inicio,
                          fin,
                          estado,
                          codigogrupo,
                          iprofesor,
                          Aula,
                          NumHoras,
                          idprofesoraux,
                          idprofesoraux2,
                          idprofesoraux3,
                          agendagrupos_id
                        ) 
                        SELECT 
                          '".$STUDENT_ID."',
                          agg.fecha,
                          '".$ENROL_ID."',
                          agg.cCurso,
                          agg.inicio,
                          agg.fin,
                          0 AS estado,
                          agg.codigogrupo,
                          agg.iprofesor,
                          agg.Aula,
                          agg.NumHoras,
                          agg.idprofesoraux,
                          agg.idprofesoraux2,
                          agg.idprofesoraux3,
                          agg.id
                        FROM
                          agendagrupos AS agg 
                        WHERE codigogrupo = '".$GROUP_ID."' 
                          AND agg.ccurso IN (".$course_ids.") 
                          AND agg.fecha BETWEEN '".$START_DATE."' AND '".$END_DATE."' ;";
        return $this->custom_sql($query);
    }

    public function CheckLinkingEvents($event_id){
        $query = $this->db->select('agenda.*')
            ->from($this->table)
            ->join('agendagrupos', 'agenda.FECHA = agendagrupos.Fecha
                              AND agenda.INICIO = agendagrupos.Inicio
                              AND agenda.FIN = agendagrupos.Fin
                              AND agenda.codigogrupo = agendagrupos.CodigoGrupo
                              AND agenda.ccurso = agendagrupos.ccurso', 'inner')
            ->where('agendagrupos.id', $event_id)
            ->get();

        return $query->result();
    }
    public function CheckLinkingEventsById($event_id){
        $query = $this->db->select('agenda.*')
            ->from($this->table)
            ->join('agendagrupos', 'agenda.agendagrupos_id = agendagrupos.id', 'inner')
            ->where('agendagrupos.id', $event_id)
            ->get();

        return $query->result();
    }

    public function getStudentsDataByEvent($where_ids){
        $query = $this->db->select('al.cnomcli AS full_name, al.sNombre AS first_name, al.sApellidos AS last_name
                            ,al.Email AS email, al.movil AS mobile, al.tut1_email1, al.tut2_email1, ag.Fecha AS start_date, cu.curso AS course_name')
                          ->from($this->table.' AS ag')
                          ->join('alumnos AS al', 'al.CCODCLI = ag.CALUMNO', 'left')
                          ->join('curso AS cu','ag.ccurso = cu.codigo', 'left')
                          ->where_in('INDICE', $where_ids)
                          ->get();
        
        return $query->result();
    }

    public function CheckLinkingEventsIdsById($event_ids){
        $query = $this->db->select('agenda.*')
            ->from($this->table)
            ->join('agendagrupos', 'agenda.agendagrupos_id = agendagrupos.id', 'inner')
            ->where_in('agendagrupos.id', $event_ids)
            ->get();

        return $query->result();
    }
    public function CheckLinkingEventsIds($event_ids){
        $query = $this->db->select('agenda.*')
            ->from($this->table)
            ->join('agendagrupos', 'agenda.FECHA = agendagrupos.Fecha
                              AND agenda.INICIO = agendagrupos.Inicio
                              AND agenda.FIN = agendagrupos.Fin
                              AND agenda.codigogrupo = agendagrupos.CodigoGrupo
                              AND agenda.ccurso = agendagrupos.ccurso', 'inner')
            ->where_in('agendagrupos.id', $event_ids)
            ->get();

        return $query->result();
    }

    public function updateStudentEvent($where_ids, $update_data){
        $this->db->where_in('INDICE', $where_ids);
        return $this->db->update($this->table, $update_data);
    }

    public function deleteEvents($events_ids){
        $this->db->where_in('INDICE', $events_ids);
       return $this->db->delete($this->table);
    }
    
    public function addEvents($insert_data){
        $query = $this->db->insert_batch($this->table, $insert_data);
        return $query;
    }
    public function addEvent($insert_data){
        $query = $this->db->insert($this->table, $insert_data);
        return $query;
    }
    public function getEnrollmentsByGroup($group_id){
        $this->db->distinct($this->table.'.CALUMNO');
        $this->db->select($this->table.'.CALUMNO as id, ' .$this->table.'.MATRICULA as enroll_id, alumnos.cnomcli as student_name');
        $this->db->where($this->table.'.codigogrupo', $group_id);
        $this->db->join('alumnos', 'alumnos.CCODCLI = '.$this->table.'.CALUMNO', 'left');
        $query = $this->db->get($this->table);
        return $query->result();
        
    }
    public function assignEventTeacher($event_ids, $teacher_id){
        $this->db->where_in('INDICE', $event_ids);

        return $this->db->update($this->table, array('iprofesor' => $teacher_id));

    }
    public function assignEventClassroom($event_ids, $classroom_id){
        $this->db->where_in('INDICE', $event_ids);

        return $this->db->update($this->table, array('aula' => $classroom_id));

    }

}
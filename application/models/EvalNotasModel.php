<?php

class EvalNotasModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "eval_notas";
    }

    public function getNotasData($idml){
        $sql = "SELECT ev. * , (UNIX_TIMESTAMP(ev.fecha)*1000) AS f, CAST( IF( en.descripcion IS NULL , 'por evaluar', en.descripcion ) AS CHAR ) AS estado	FROM eval_notas AS ev LEFT JOIN eval_estadonotas AS en ON ev.idestado = en.id  WHERE ev.idmatriculal ='". $idml ."'";
        return $this->selectCustom($sql);
    }
    
    public function getNotasDataById($ide){
        $sql = "SELECT ev. * , (UNIX_TIMESTAMP(ev.fecha)*1000) AS f, CAST( IF( en.descripcion IS NULL , 'por evaluar', en.descripcion ) AS CHAR ) AS estado	FROM eval_notas AS ev LEFT JOIN eval_estadonotas AS en ON ev.idestado = en.id  WHERE ev.id ='". $ide ."'";
        return $this->selectCustom($sql);
    }

    public function getNotas(){
        $sql = "SELECT id, Descripcion, valor AS valorfijo FROM eval_estadonotas ORDER BY id";
        return $this->selectCustom($sql);
    }

    public function comperNotes($note){
        $sql="SELECT id 
              FROM eval_estadonotas
              WHERE ((valor = '". $note."' 
              AND rangovalor = 0) OR ('". $note ."' <= rango2 
              AND '". $note ."' >= rango1 AND rangovalor =1))";

        return $this->selectCustom($sql);
    }

    public function getStateIdByNote($note){
        $sql="SELECT id 
                FROM eval_estadonotas
                WHERE ((valor = '". $note ."'
                AND rangovalor = 0) OR ('". $note ."' <= rango2 
                AND '". $note ."' >= rango1 AND rangovalor =1))";
        return $this->selectCustom($sql);
    }

    public function updateItem($update_data, $ide){
        return $this->update($this->table, $update_data, array('id' => $ide));
    }

    public function getRecoveriesData($idml){
        $sql = "SELECT rec.id, rec.fecha, rec.nota, CONCAT(SUBSTRING(rec.observaciones,1,30), ' ...') AS Observa, st.descripcion AS estado, ev.idmatriculal, rec.convocatoria, rec.idestado FROM eval_recup AS rec LEFT JOIN eval_notas AS ev ON rec.idevalnota = ev.id LEFT JOIN eval_estadonotas AS st ON rec.idestado = st.id WHERE ev.idmatriculal = '". $idml ."'  ORDER BY rec.id DESC";
        return $this->selectCustom($sql);
    }

    public function updateRecoveriesData($update_data, $recovery_id){
        return $this->update('eval_recup', $update_data, array('id' => $recovery_id));
    }

    public function getRecoveriesDataById($recovery_id){
        $sql = "SELECT rec.id, rec.fecha, rec.nota, CONCAT(SUBSTRING(rec.observaciones,1,30), ' ...') AS Observa, st.descripcion AS estado, ev.idmatriculal, rec.convocatoria, rec.idestado FROM eval_recup AS rec LEFT JOIN eval_notas AS ev ON rec.idevalnota = ev.id LEFT JOIN eval_estadonotas AS st ON rec.idestado = st.id WHERE rec.id = '". $recovery_id ."'  ORDER BY rec.id DESC";
        return $this->selectCustom($sql);
    }
    
    public function getStudentNotesData($enroll_id, $course_id){
       $sql = "SELECT ev. * ,(UNIX_TIMESTAMP(ev.fecha)*1000) AS f, CAST( IF( en.descripcion IS NULL , 'por evaluar', en.descripcion ) AS CHAR ) AS estado 
			   FROM eval_notas AS ev LEFT JOIN eval_estadonotas AS en ON ev.idestado = en.id 
			   LEFT JOIN matriculal AS ml ON ev.`idmatriculal` = ml.`Id`  
			   WHERE ev.`visible_campus`=1 AND ml.idestado=0 AND ml.nummatricula = '".$enroll_id."' AND ml.codigocurso='".$course_id."'";
        
        return $this->selectCustom($sql);
    }

    public function getStudentRecoveriesData($matricula, $course_id){
        $sql = "SELECT rec.id, rec.fecha, rec.nota, rec.convocatoria AS titulo, CONCAT(SUBSTRING(rec.observaciones,1,30), ' ...') AS observaciones, 
  						 st.descripcion AS estado, rec.idmatriculal,ml.`Descripcion` AS actividad,ev.`descripcion` AS evaluacion 
						 FROM eval_recup AS rec 
						 LEFT JOIN eval_notas AS ev ON rec.idevalnota= ev.id
						 LEFT JOIN matriculal AS ml ON rec.`idmatriculal` = ml.id 
						 LEFT JOIN eval_estadonotas AS st ON rec.idestado = st.id 
						 WHERE ml.nummatricula = ".$matricula."  AND ml.codigocurso='".$course_id."'
						 ORDER BY rec.id DESC";
        return $this->selectCustom($sql);
    }

}
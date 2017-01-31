<?php

class MatriculatModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "matriculat";
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function getHistoricFees($id) {

        if (!$id) {
            return null;
        }

        $query = " SELECT
            mt.Nummatricula AS Matricula,
            DATE(mt.fechamatricula) AS fecha ,
            al.`cnomcli` AS Alumno,
            em.`DescripcionEstado` AS `EstadoMatrícula`
            FROM
            matriculat AS mt
            LEFT JOIN alumnos AS al
            ON mt.`CCODCLI` = al.`CCODCLI`
            LEFT JOIN estadomatricula AS em
            ON mt.`Estado` = em.`Estado`
            WHERE mt.`FacturarA` = $id ";

        return $this->selectCustom($query);
    }

    public function getEnrollments($student_id){
         $query = $this->db->select('NumMatricula` AS enrollid,
                                     DATE_FORMAT(`Inicio`,"%d/%m/%Y") AS start_date,
                                     DATE_FORMAT(`FinMatricula`,"%d/%m/%Y") AS end_date,
                                    `Estado` AS state ')
                           ->from($this->table)
                           ->where('ccodcli', $student_id)
                           ->order_by('1', 'DESC')
                           ->get();
        return $query->result();
    }

    public function getEnrollmentsList($where = array()){
        $query = "SELECT
                    mt.`NumMatricula` AS id,
                    CONCAT(al.sapellidos,', ',al.snombre) AS student_name,
                    al.photo_link,
                    LTRIM(CONCAT(al.`CTFO1CLI`,' ',al.ctfo2cli,' ',al.movil)) AS phone_numbers,
                    al.`email`,
                    al.`CCODCLI` AS student_id,
                    mt.`Estado` AS state,
                    mt.`FechaMatricula` AS enroll_date,
                    mt.`Inicio` AS start_date,
                    mt.`FinMatricula` AS end_date,
                    IF(LENGTH(mt.descripcion)>100,MID(mt.`Descripcion`,1,100),mt.descripcion) AS course_description

                    FROM
                    matriculat AS mt
                    LEFT JOIN alumnos AS al
                    ON mt.`CCODCLI` = al.`CCODCLI` ";
        
        if(!empty($where)){
            $w = '';
            if(isset($where['student_id'])){
                $w = ' WHERE ';
                $w .= " al.CCODCLI='".$where['student_id']."'";
            }
            if(isset($where['enroll_id'])){
                if(empty($w)) {
                    $w = ' WHERE ';
                }else{
                    $w .= ' AND ';
                }
                $w .= " mt.`NumMatricula`='".$where['enroll_id']."'";
            }
            if(!empty($w)){
                $query .= $w;
            }
        }
        $query .=" ORDER BY 1 DESC";
        return $this->selectCustom($query);
    }

    public function getEnrollmentsAjax($start, $length, $draw, $search, $order, $columns, $filter_tags){
        $where = '';
        if(!empty($filter_tags->selected_courses)){
            //$where = ' WHERE ';
            foreach($filter_tags->selected_courses as $key=>$course){
                $or = $key == 0 ? '' : ' OR ';
                $where .= " $or '".$course."' IN (SELECT codigocurso FROM matriculal WHERE nummatricula = mt.nummatricula)";
            }
        }
        if(!empty($filter_tags->selected_groups)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            foreach($filter_tags->selected_groups as $key=>$group){
                $or = $key == 0 ? '' : ' OR ';
                $where .= " $or '".$group."' IN (SELECT idgrupo FROM matriculal WHERE nummatricula = mt.nummatricula)";
            }
        }
        if(!empty($filter_tags->selected_state)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->selected_state as $key=>$course){
                $ids_st .= "'".$course."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "mt.`estado` IN (".$ids_st_.")";
        }

        if(!empty($filter_tags->selected_names)){
            if(empty($where)) {
               // $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }

            foreach($filter_tags->selected_names as $key=>$name){
                $or = $key == 0 ? '( ' : ' OR ';
                $where .= " ".$or." CONCAT(sapellidos,', ',snombre) LIKE '%".$name."%'";
            }
            $where .= ' ) ';

        }
        
        if(!empty($filter_tags->tag_ids) && is_array($filter_tags->tag_ids)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->tag_ids as $key=>$tags){
                $ids_st .= "'".$tags."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "mtags.id_tag IN (".$ids_st_.")";
        }

        $this->db->select("
                    SQL_CALC_FOUND_ROWS null AS rows,
                     mt.`NumMatricula` AS id,
                    CONCAT(al.sapellidos,', ',al.snombre) AS student_name,
                    al.photo_link,
                    LTRIM(CONCAT(al.`CTFO1CLI`,' ',al.ctfo2cli,' ',al.movil)) AS phone_numbers,
                    al.`email`,
                    al.`CCODCLI` AS student_id,
                    mt.`Estado` AS state,
                    mt.`FechaMatricula` AS enroll_date,
                    mt.`Inicio` AS start_date,
                    mt.`FinMatricula` AS end_date,
                    group_concat(mtags.id_tag separator ',') AS tag_ids,
                   (SELECT MID(GROUP_CONCAT(curso.curso),1,100) FROM matriculal LEFT JOIN curso ON matriculal.`codigocurso` = curso.`codigo`
     WHERE matriculal.`NumMatricula` = mt.`NumMatricula`
  ) AS course_description", false);
        $this->db->from($this->table.' AS mt ');
        $this->db->join('alumnos AS al', 'mt.CCODCLI = al.CCODCLI');
        $this->db->join('matricula_tags AS mtags', 'mtags.nummatricula = mt.NumMatricula', 'left');
        $this->db->distinct();
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('al.sapellidos', $search['value']);
            $this->db->or_like('al.snombre', $search['value']);
            $this->db->or_like('al.CTFO1CLI', $search['value']);
            $this->db->or_like('al.ctfo2cli', $search['value']);
            $this->db->or_like('al.movil', $search['value']);
            $this->db->or_like('al.email', $search['value']);
            $this->db->or_like('mt.FechaMatricula', $search['value']);
            $this->db->or_like('mt.Inicio', $search['value']);
            $this->db->or_like('mt.FinMatricula', $search['value']);
            $this->db->or_like('mt.descripcion', $search['value']);
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->group_by('mt.`NumMatricula`');
        $this->db->order_by(2, 'DESC');


        $this->db->limit($length, $start);

        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }

    public function deleteEnrollments($enroll_id){
        $this->db->where('NumMatricula', $enroll_id);
        $this->db->delete('matriculat');

        $this->db->where('NumMatricula', $enroll_id);
        $this->db->delete('matriculal');

        $this->db->where('Matricula', $enroll_id);
        $this->db->delete('matriculah');

        $this->db->where('Matricula', $enroll_id);
        $this->db->delete('agenda');

        $this->db->where('Matricula', $enroll_id);
        $this->db->delete('prorrogas');

        $this->db->where('NumMatricula', $enroll_id);
        $this->db->delete('diplomal');

        $this->db->where('NumMatricula', $enroll_id);
        $this->db->delete('materiall');

        $this->db->where('NumMatricula', $enroll_id);
        $this->db->delete('documentacionl');

        $this->db->where('Matricula', $enroll_id);
        $this->db->delete('agenda_t');

        $this->db->where('Indice', $enroll_id);
        $this->db->delete('agenda_segui');

        $this->db->where('Matricula', $enroll_id);
        $this->db->delete('matricula_eval');

        $this->db->where('n_factura = 0 AND estado<>1');
        $this->db->where('NumMatricula', $enroll_id);
        $this->db->delete('recibos');

        if($this->db->table_exists('matricula_tab_ad')) {
            $this->db->where('CCODCLI', $enroll_id);
            $this->db->delete('matricula_tab_ad');
        }

        $this->custom_sql("DELETE FROM eval_notas_params WHERE id IN (SELECT id FROM eval_notas WHERE idmatriculal = '".$enroll_id."') ");

        $this->db->where('idmatriculal', $enroll_id);
        $this->db->delete('eval_notas');

        $this->custom_sql("UPDATE recibos SET nummatricula = '0' WHERE NumMatricula = '".$enroll_id."'");
        $this->custom_sql("UPDATE facturas SET nummatricula = '0' WHERE NumMatricula = '".$enroll_id."'");
        $this->custom_sql("UPDATE factural SET nummatricula = '0' WHERE NumMatricula = '".$enroll_id."'");
        $this->custom_sql("UPDATE presupuestot SET estado = 0, Matricula = 0 WHERE Matricula = '".$enroll_id."'");

        return true;
    }

    public function updateEnrollmentState($enroll_id,$state_id){
        return $this->update($this->table, array('Estado' => $state_id), array('NumMatricula' => $enroll_id));

    }

    public function getEnrollmentsByTags($selected_courses = null, $selected_state = null, $selected_groups = null, $selected_names = null){
        $where = '';
        if(!empty($selected_courses)){
            $where = ' WHERE ';
            foreach($selected_courses as $key=>$course){
                $or = $key == 0 ? '' : ' OR ';
                $where .= " $or '".$course."' IN (SELECT codigocurso FROM matriculal WHERE nummatricula = mt.nummatricula)";
            }
        }
        if(!empty($selected_groups)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            foreach($selected_groups as $key=>$group){
                $or = $key == 0 ? '' : ' OR ';
                $where .= " $or '".$group."' IN (SELECT idgrupo FROM matriculal WHERE nummatricula = mt.nummatricula)";
            }
        }
        if(!empty($selected_state)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($selected_state as $key=>$course){
                $ids_st .= "'".$course."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "mt.`estado` IN (".$ids_st_.")";
        }

        if(!empty($selected_names)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }

            foreach($selected_names as $key=>$name){
                $or = $key == 0 ? '' : ' OR ';
               $where .= " ".$or." CONCAT(sapellidos,', ',snombre) LIKE '%".$name."%'";
            }

        }

        $query = "SELECT
                    mt.`NumMatricula` AS id,
                    CONCAT(al.sapellidos,', ',al.snombre) AS student_name,
                    al.photo_link,
                    LTRIM(CONCAT(al.`CTFO1CLI`,' ',al.ctfo2cli,' ',al.movil)) AS phone_numbers,
                    al.`email`,
                    mt.`Estado` AS state,
                    mt.`FechaMatricula` AS enroll_date,
                    mt.`Inicio` AS start_date,
                    mt.`FinMatricula` AS end_date,
                    IF(LENGTH(mt.descripcion)>100,MID(mt.`Descripcion`,1,100),mt.descripcion) AS course_description

                    FROM
                    matriculat AS mt
                    LEFT JOIN alumnos AS al
                    ON mt.`CCODCLI` = al.`CCODCLI`
                    ".$where."
                    ORDER BY 1 DESC";
        return $this->selectCustom($query);
    }

    public function insertEnroll($enroll_id,$student_id, $category_id, $start_date, $end_date){
        $start_date = date('Y-m-d H:i:s', strtotime($start_date));
        $end_date = date('Y-m-d H:i:s', strtotime($end_date));
        $query = "
                    INSERT INTO matriculat
                    (ccodcli,fp,idperiodo,nummatricula,esprematricula,
                    estado,inicio,finmatricula,fechamatricula,totalhoras,
                    facturara,tipofact,idcurso
                    )
                    SELECT
                    ccodcli,
                    IF(facturara=0,
                      IF(idfp IS NULL,'0',idfp),
                      (SELECT IF(idfp IS NULL,'0',idfp) FROM clientes WHERE ccodcli = alumnos.`facturara`)
                      ),
                    '0',
                    '".$enroll_id."',
                    '0',
                    '1',
                    '".$start_date."',
                    '".$end_date."',
                    CURDATE(),
                    facturara,
                    '0',
                    '0',
                    '".$category_id."'

                    FROM alumnos  WHERE ccodcli = '".$student_id."'";

        return $this->custom_sql($query);
    }

    public function insertEvalNotas($GROUP_ID, $ENROL_ID){
        $query = "INSERT INTO eval_notas
                    (
                      idmatriculal,
                      idevalgrupo,
                      descripcion,
                      fecha,
                      recuperable,
                      peso,
                      reqaprov,
                      idestado,
                      idProfesor
                    )
                    SELECT DISTINCT
                      ml.id,
                      evg.id AS idevalgrupo,
                      evg.descripcion AS descripcion,
                      evg.fecha,
                      evg.recuperable,
                      evg.peso,
                      evg.reqaprov,
                      0 AS idestado,
                      ml.idProfesor
                    FROM
                      eval_grupos AS evg
                      LEFT JOIN matriculal AS ml  ON evg.codigogrupo = ml.idgrupo  AND ml.codigocurso = evg.codigocurso
                    WHERE ml.idgrupo = '".$GROUP_ID."'   AND ml.nummatricula = '".$ENROL_ID."' ";
        return $this->custom_sql($query);
    }

    public function insertEvalNotasParams($enroll_id){
        $query = "INSERT INTO eval_notas_params
				(idevalnota,  idgruposparams, descripcion, nota, peso, Editable)
				SELECT DISTINCT
				  en.id,
				  NULL AS idgruposparams,
				  egp.descripcion,
				  NULL AS nota,
				  egp.peso AS peso,
				  0 AS editable
				FROM
				  eval_notas AS en
				  LEFT JOIN eval_grupos_params AS egp
					ON en.idevalgrupo = egp.`idevalgrupos`
				  LEFT JOIN matriculal AS ml
					ON en.idmatriculal = ml.id
				WHERE ml.nummatricula = '".$enroll_id."'
				ORDER BY en.id, egp.`id` ";

        return $this->custom_sql($query);
    }


    public function get_enrollments($tags = array()){
        $this->db->select(''.$this->table.'.NumMatricula as id, CONCAT("en_", '.$this->table.'.NumMatricula) as _id, sapellidos AS `surname`, snombre AS `first_name`, al.email as email')
            ->from($this->table);
        $this->db->join('alumnos as al',$this->table.'.CCODCLI = al.CCODCLI', 'left');
        $this->db->join('matricula_tags AS mtags', 'mtags.nummatricula = '.$this->table.'.NumMatricula', 'left');

        if(!empty($tags)){
            $selected_surname = isset($tags['selected_surname']) ? $tags['selected_surname']: null;
            $selected_first_name = isset($tags['selected_first_name']) ? $tags['selected_first_name']: null;
            $selected_email = isset($tags['selected_email']) ? $tags['selected_email']: null;
            $selected_tag_ids = isset($tags['selected_enrollments_tag_ids']) ? $tags['selected_enrollments_tag_ids']: null;

            $like_exit = false;
//
            if(!empty($selected_surname)){
                foreach ($selected_surname as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like('al.sapellidos', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like('al.sapellidos', $value);
                        }
                    }
                }
            }
//
            if(!empty($selected_first_name)){
                foreach ($selected_first_name as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like('al.snombre', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like('al.snombre', $value);
                        }
                    }
                }
            }
//
            if(!empty($selected_email)){
                foreach ($selected_email as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like('al.email', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like('al.email', $value);
                        }
                    }
                }
            }

            if(!empty($selected_tag_ids) && is_array($selected_tag_ids)){
                $ids_st = '';
                foreach($selected_tag_ids as $key=>$tags_loc){
                    $ids_st .= "'".$tags_loc."',";
                }
                $ids_st_ = trim($ids_st, ',');
                $this->db->where("mtags.id_tag IN (".$ids_st_.")");
            }

            $selected_courses = isset($tags['selected_enrollments_course']) ? $tags['selected_enrollments_course']: null;
            if(!empty($selected_courses)){
                $where = '';
                foreach($selected_courses as $key=>$course){
                    $or = $key == 0 ? '' : ' OR ';
                    $where .= " $or '".$course."' IN (SELECT codigocurso FROM matriculal WHERE nummatricula = matriculat.nummatricula)";


                }
                if(!empty($where)){
                    $this->db->where($where);
                }
            }
            $selected_groups = isset($tags['selected_enrollments_group']) ? $tags['selected_enrollments_group']: null;
            if(!empty($selected_groups)){
                $where = '';
                foreach($selected_groups as $key=>$group){
                    $or = $key == 0 ? '' : ' OR ';
                    $where .= " $or '".$group."' IN (SELECT idgrupo FROM matriculal WHERE nummatricula = matriculat.nummatricula)";
                }

                if(!empty($where)){
                    $this->db->where($where);
                }
            }
            $selected_state = isset($tags['selected_enrollments_state']) ? $tags['selected_enrollments_state']: null;
            if(!empty($selected_state) && is_array($selected_state)){
                $ids_st = '';
                foreach($selected_state as $key=>$course){
                    $ids_st .= "'".$course."',";
                }
                $ids_st_ = trim($ids_st, ',');
                $this->db->where($this->table.".estado IN (".$ids_st_.")");
            }

        }
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_object();
    }

    public function getEnrollmentsIdFields(){

        $this->db->select('NumMatricula as id, CONCAT("en_", NumMatricula) as _id, sapellidos AS `surname`, snombre AS `first_name`, al.email as email')
            ->from($this->table);
        $this->db->join('alumnos as al',$this->table.'.CCODCLI = al.CCODCLI', 'left');
        $query = $this->db->get();

        return $query->result_object();

    }

    public function getEnrollmentsByStudentId($student_id = null){
        if(empty($student_id)){
            return false;
        }

        $this->db->select('NumMatricula as enroll_id, CONCAT(snombre, " ", sapellidos) as enroll_name')
            ->from($this->table);
        $this->db->join('alumnos as al',$this->table.'.CCODCLI = al.CCODCLI', 'left');
        $this->db->where($this->table.'.CCODCLI', $student_id);
        $query = $this->db->get();

        return $query->result_object();

    }

    public function getStudentEnrollmentsForSelect(){        
        $this->db->select('NumMatricula as enroll_id, CONCAT(snombre, " ", sapellidos) as enroll_name')
            ->from($this->table);
        $this->db->join('alumnos as al',$this->table.'.CCODCLI = al.CCODCLI', 'left');
        $query = $this->db->get();

        return $query->result_object();

    }

    public function getEnrollmentsByEmailForRecipient($email = null) {

        if(empty($email)){
            return false;
        }

        $this->db->select('NumMatricula as id, CONCAT("en_", NumMatricula) as _id, al.sapellidos AS `surname`, al.snombre AS `first_name`, al.email as email')
            ->from($this->table);
        $this->db->where('al.email', $email);
        $this->db->join('alumnos as al',$this->table.'.CCODCLI = al.CCODCLI', 'left');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_object();

    }

    public function getEnrollById($enroll_id){
        $query = $this->db->select('*')
            ->from($this->table)
            ->where('NumMatricula', $enroll_id)
            ->get();

        return $query->row();
    }

    public function getNotes($teacher_id, $group_id, $course_id){
        $sql = "SELECT mt.nummatricula, al.CCODCLI AS IdAl, al.sapellidos AS sapellidos, al.snombre AS snombre, al.cnomcli AS nombre, al.photo_link, ml.Id, ml.descripcion AS			actividad, ae.Valor AS anno, pf.NOMBRE AS profesor, gr.Descripcion AS Grupo, ROUND( 100 * SUM(			IF( ag.estado =1
				OR ag.estado =2, 1, 0 ) ) / SUM( IF( ag.estado >0, 1, 0 ) ) , 2 ) AS 'Asistencias', ROUND( 100 * SUM( IF( ag.estado =3
				OR ag.estado =4, 1, 0 ) ) / SUM( IF( ag.estado >0, 1, 0 ) ) , 2 ) AS 'Faltas', ml.nota, CAST( IF( eam.descripcion IS NULL , 'por evaluar', eam.descripcion ) AS CHAR ) AS estado, ml.idestadonota
				FROM matriculat AS mt
				LEFT JOIN alumnos AS al ON mt.ccodcli = al.ccodcli
				LEFT JOIN matriculal AS ml ON mt.nummatricula = ml.nummatricula
				LEFT JOIN agenda AS ag ON ag.matricula = mt.nummatricula
				LEFT JOIN eval_estadonotas AS eam ON eam.id = ml.idestadonota
				LEFT JOIN profesor AS pf ON ml.idProfesor = pf.INDICE
				LEFT JOIN grupos AS gr ON ml.IdGrupo = gr.CodigoGrupo
				LEFT JOIN `año escolar`  ae ON ml.`IdAño` = ae.Id
				WHERE ml.codigocurso = '".$course_id."'
				AND ml.idgrupo = '".$group_id."'
				AND ((ml.idprofesor = '".$teacher_id."') OR (ml.idprofesoraux = '".$teacher_id."') OR (ml.idprofesoraux2 = '".$teacher_id."') OR (ml.idprofesoraux3 = '".$teacher_id."'))
				AND ml.idestado=0 AND (mt.esprematricula=0) 
				GROUP BY ml.id
				ORDER BY al.sapellidos, al.snombre
				";

        return $this->selectCustom($sql);
    }

    public function getEnrollAssignedEval($userid){
        $sql = "SELECT DISTINCT cu.codigo AS idactividad, cu.curso AS actividad, al.`CCODCLI` AS CALUMNO,
		mt.NumMatricula AS enrollment
		FROM matriculat AS mt 
		LEFT JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI`
		LEFT JOIN matriculal AS ml ON mt.NumMatricula = ml.NumMatricula
		LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.codigo
		WHERE ml.IdEstado = 0 AND mt.esprematricula=0 AND cu.codigo IS NOT NULL AND al.`CCODCLI` = '".$userid."'
		ORDER BY cu.curso";
        return $this->selectCustom($sql);
    }

    public function get_matricula($user_id, $course_id){
        $sql="SELECT DISTINCT mt.NumMatricula AS matricula
			FROM matriculat AS mt 
			LEFT JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI`
			LEFT JOIN matriculal AS ml ON mt.NumMatricula = ml.NumMatricula
			LEFT JOIN curso AS cu ON ml.`codigocurso` = cu.codigo
			WHERE ml.IdEstado = 0 AND cu.codigo IS NOT NULL AND al.`CCODCLI` =".$user_id." AND cu.codigo='".$course_id."'";
        return $this->selectCustom($sql);
    }
}
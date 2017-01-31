<?php

class AlumnoModel extends MagaModel {

    public $fields = array(
            'ccodcli',
            'snombre',
            'sapellidos',
            'cdomicilio',
            'cpobcli',
            'cptlcli',
            'ccodprov',
            'cnaccli',
            'LugarNacimiento',
            'tipodoc',
            'cdnicif',
            'idsexo',
            'COBSCLI',
            'nacimiento',
            'FirstUpdate',
            'LastUpdate',
            'ctfo1cli',
            'ctfo2cli',
            'movil',
            'email',
            'email2',
            // Tutor 1 data
            'tut1_nombre',
            'tut1_idparentesco',
            'tut1_sapellido1',
            'tut1_sapellido2',
            'tut1_direccion',
            'tut1_poblacion',
            'tut1_cp',
            'tut1_provincia',
            'tut1_pais',
            'tut1_dni',
            'tut1_tfno1',
            'tut1_tfno2',
            'tut1_movil',
            'tut1_email1',
            'tut1_email2',
            'tut1_tipodoc',
            // Tutor 2 data
            'tut2_nombre',
            'tut2_idparentesco',
            'tut2_sapellido1',
            'tut2_sapellido2',
            'tut2_direccion',
            'tut2_poblacion',
            'tut2_cp',
            'tut2_provincia',
            'tut2_pais',
            'tut2_dni',
            'tut2_tipodoc',
            'tut2_tfno1',
            'tut2_tfno2',
            'tut2_movil',
            'tut2_email1',
            'tut2_email2',
        );
    
    public function __construct() {
        parent::__construct();
        $this->table = "alumnos";
    }
 public function getFieldsList($form_type = null){
        $this->db->select('*');
        $this->db->from('erp_custom_fields');
        if($form_type) {
            $this->db->where('form_type', $form_type);
        }
        $query = $this->db->get();
        
        return $query->result_array();
        
    }


    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getAlumnos() {

        $query = "
            SELECT
            `alumnos`.`CCODCLI` AS Id
            ,`alumnos`.`facturara` as `Idalumnbo`
            ,`alumnos`.`cnomcli`
            ,`alumnos`.`Cdomicilio`
            ,`alumnos`.`CDNICIF`
            ,`alumnos`.`ctfo1cli`
            ,`alumnos`.`movil`
            ,`alumnos`.`email`
            FROM
                `alumnos`
        ";

        return $this->selectCustom($query);
    }

    public function getAlumnosNotLinked($client_id = null) {

        if(empty($client_id)){
            return false;
        }
        $this->db->select("CCODCLI AS student_id,
                          CONCAT(sapellidos, ', ', snombre) AS student_name,
                          facturara AS company_id,
                          Cdomicilio AS student_adress,
                          CDNICIF AS student_dni,
                          ctfo1cli AS student_phone,
                          movil AS student_mobile,
                          email AS student_email
                        ");
        $this->db->from($this->table);
        $this->db->where("facturara <>", $client_id);
        $this->db->order_by(2);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student_by_id($id) {

        if(empty($id)){
            return false;
        }
        $this->db->select("CCODCLI AS student_id,
                          CONCAT(sapellidos, ', ', snombre) AS student_name,
                          sapellidos AS student_last_name,
                          snombre AS student_first_name,
                          facturara AS company_id,
                          Cdomicilio AS student_adress,
                          CDNICIF AS student_dni,
                          ctfo1cli AS student_phone,
                          movil AS student_mobile,
                          email AS student_email,
                          email2,
                          tut1_email1,
                          tut2_email1
                        ");
        $this->db->from($this->table);
        $this->db->where("CCODCLI", $id);
        $query = $this->db->get();
        return $query->row();
    }



    public function getEmployee($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT
            `alumnos`.`CCODCLI` AS student_id
            ,`alumnos`.`facturara` AS company_id
             ,CONCAT(sapellidos, ', ', snombre) AS student_name
            ,`alumnos`.`Cdomicilio` AS student_adress
            ,`alumnos`.`CDNICIF` AS student_dni
            ,`alumnos`.`ctfo1cli` AS student_phone
            ,`alumnos`.`movil` AS student_mobile
            ,`alumnos`.`email` AS student_email
            FROM
                `alumnos`
                INNER JOIN `clientes`
                    ON(`alumnos`.`FacturarA` = `clientes`.`CCODCLI`)
                    WHERE (`clientes`.`CCODCLI` = $id)
                    ORDER BY `alumnos`.`facturara` ASC;";

        return $this->selectCustom($query);
    }

    public function getByUserId($user_id = null) {
        if(!$user_id){
            return null;
        }
        $sql = "SELECT * FROM `alumnos` WHERE `CCODCLI` =  '".$user_id."'";

        return $this->selectCustom($sql);
    }

    public function getAll($selectParams = '', $where = array()) {
        return  $this->selectAll($this->table, $selectParams, $where);
    }

    public function checkAlumno($user = null, $clave = null) {

        if(!$user || !$clave){
            return false;
        }

        $query = "SELECT COUNT(*) AS num
                        FROM alumnos
                        WHERE usuario = '$user' AND clave = '$clave'
                        AND ccodcli IN (SELECT ccodcli FROM matriculat WHERE estado = 1)
                  ;";

        $r = $this->db->query($query);
        return $r->result_array();
    }

    public function checkAlumnoByemail($email = null, $clave = null) {

        if(!$email || empty($email) || !$clave){
            return false;
        }

        $query = "SELECT COUNT(*) AS num
                        FROM alumnos
                        WHERE email = '$email' AND clave = '$clave' AND enebc = '1'
                  ";

        $r = $this->db->query($query);
        return $r->result_array();
    }

    public function getAlumno($user = null, $clave = null) {

        if(!$user || !$clave){
            return false;
        }

//        $query = "SELECT `ccodcli` as userid, `cnomcli` as username FROM alumnos WHERE `usuario` = '$user' AND `clave` = '$clave';";
        $query = "SELECT * FROM `alumnos` WHERE `usuario` = '$user' AND `clave` = '$clave';";

        $r = $this->db->query($query);

        return $r->result();
    }
    public function getAlumnoByemail($email = null, $clave = null) {

        if(!$email || empty($email) || !$clave){
            return false;
        }

//        $query = "SELECT `ccodcli` as userid, `cnomcli` as username FROM alumnos WHERE `usuario` = '$user' AND `clave` = '$clave';";
        $query = "SELECT * FROM `alumnos` WHERE `email` = '$email' AND `clave` = '$clave' AND enebc = '1'";

        $r = $this->db->query($query);

        return $r->result();
    }
    
    public function listAlumno($idprofessor){
    	$query = "SELECT DISTINCT
					 al.cnomcli as USUARIO ,al.ccodcli as id
					FROM
					 agenda AS ag
					 LEFT JOIN alumnos AS al
					   ON ag.CALUMNO = al.CCODCLI
					 LEFT JOIN matriculal as ml
					   ON ag.MATRICULA = ml.NumMatricula
					 LEFT JOIN estado_actividad_matricula as eam
					   ON ml.IdEstado = eam.Id
						WHERE (ag.iprofesor = '".$idprofessor."')   
					ORDER BY 1";
		return $this->selectCustom($query);
	}

    public function getPhoto($uid){
//        $sql_photo = "SELECT foto_thumb, IF( Length(foto) > 0 , '1', '0' ) AS tienefoto, IF(  Length(foto_thumb) > 0 , '1', '0' ) AS tienethumb  FROM `alumnos` WHERE `CCODCLI`='".$uid."'";
        $sql_photo = "SELECT
					  foto,
					  IF(LENGTH(foto) > 0, '0', '1') AS photo_is_empty
					FROM
					  `alumnos`
					WHERE `CCODCLI` ='".$uid."'";
        return $this->selectCustom($sql_photo);
	}
    public function getPhotoLink($uid){
        $this->db->select('photo_link');
        $this->db->from($this->table);
        $this->db->where('CCODCLI', $uid);
        $query = $this->db->get();
        return $query->row();
	}

    public function getProfileSetting($student_id = null){
        $query = "SELECT snombre AS firs_name, sapellidos AS sure_name,
                    email, email2, ctfo1cli AS Phone, movil AS mobile,
                    foto AS photo
                    FROM alumnos
                    WHERE ccodcli = $student_id
                    ";
        return $this->selectCustom($query);
    }

    public function updateProfileSettings($user_id, $data){
        $this->db->where('ccodcli', $user_id);

        return  $this->db->update($this->table, $data);
    }

    public function check_password($oldpassword,$id){
        $this->db->where('ccodcli', $id);
        $this->db->where('clave', $oldpassword);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function get_campus_students($where = null){
        $query = $this->db->select('foto AS photo, usuario, ccodcli AS id, cnomcli AS user_name, email, ctfo1cli AS phone, movil AS mobile, enebc AS status, clave')
            ->from($this->table);
        if($where){
            $query->where($where);
        }
        $query->order_by('cnomcli', "desc");
        return $query->get()->result();
    }

    public function get_campus_students_ajax($start, $length, $draw, $search, $order, $columns, $filter_tags){
        $where = null;
        $from_table = $this->table;
        if(!empty($filter_tags->selected_groups)){
            $from_table = 'matriculal AS ml';
            $where = $filter_tags->selected_groups;
        }
         $this->db->select('
                    SQL_CALC_FOUND_ROWS null AS rows,
                      '.$this->table.'.photo_link, 
                    '.$this->table.'.usuario, 
                    '.$this->table.'.ccodcli AS id, 
                    '.$this->table.'.cnomcli AS user_name, email, 
                    '.$this->table.'.ctfo1cli AS phone, 
                    '.$this->table.'.movil AS mobile, 
                    '.$this->table.'.enebc AS status', false);
        $this->db->from($from_table);
        if(!empty($filter_tags->selected_groups)){
            $this->db->join('matriculat as mt', 'ml.nummatricula = mt.nummatricula');
            $this->db->join($this->table, 'mt.ccodcli = '.$this->table.'.ccodcli', 'left');
        }
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like(''.$this->table.'.cnomcli', $search['value']);
            $this->db->or_like($this->table.'.usuario', $search['value']);
            $this->db->or_like($this->table.'.email', $search['value']);
            $this->db->or_like($this->table.'.ccodcli', $search['value']);
            $this->db->or_like($this->table.'.movil', $search['value']);
            $this->db->or_like($this->table.'.email', $search['value']);
            $this->db->or_like($this->table.'.`FirstUpdate`', $search['value']);
            $this->db->or_like($this->table.'.`LastUpdate`', $search['value']);
        }
        if(isset($columns[0]['search']['value']) && $columns[0]['search']['value'] == 'as_locked'){
            $this->db->where($this->table.'.enebc', 0);
        }
        if(isset($columns[0]['search']['value']) && $columns[0]['search']['value'] == 'as_active'){
            $this->db->where($this->table.'.enebc', 1);
        }
        if(!empty($where)){
            $this->db->where_in('ml.idgrupo', $where);
        }
        $this->db->distinct();
        $this->db->order_by($this->table.'.cnomcli', "desc");
        $this->db->limit($length, $start);
        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }

    public function conut_active_students(){
        $query = $this->db->where(array('enebc' => 1))
            ->get($this->table);
        $result = $query->num_rows();
        return $result;
    }

    public function update_student_data($data = null){
        $result = $this->db->update_batch($this->table, $data, 'ccodcli');
        return $result;
    }

    public function getStudentsByAjax($start, $length, $draw, $search, $order, $columns = '') {

        $this->db->select('ccodcli AS id, CONCAT("st_", ccodcli) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);

        $like_exit = false;
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like($this->table.'.sapellidos', $search['value']);
            $this->db->or_like($this->table.'.snombre', $search['value']);
            $this->db->or_like($this->table.'.email', $search['value']);
            $like_exit = true;
        }
        foreach ($columns as $k=>$item){
            if($k != 0){
                if(!empty($item['search']['value'])){
                    $values = explode(',',$item['search']['value']);
                    foreach($values as $value){
                        $value = trim($value);
                        switch ($k){
                            case 1:
                                if(!$like_exit){
                                    $this->db->like($this->table.'.sapellidos', $value);
                                    $like_exit = true;
                                }else{
                                    $this->db->or_like($this->table.'.sapellidos', $value);
                                }
                                break;
                            case 2:
                                if(!$like_exit){
                                    $this->db->like($this->table.'.snombre', $value);
                                    $like_exit = true;
                                }else{
                                    $this->db->or_like($this->table.'.snombre', $value);
                                }
                                break;
                            case 3:
                                if(!$like_exit){
                                    $this->db->like($this->table.'.email', $value);
                                    $like_exit = true;
                                }else{
                                    $this->db->or_like($this->table.'.email', $value);
                                }
                                break;
                            default:
                        }
                    }

                }
            }
        }

//        if(isset($columns[0]['search']['value']) && is_numeric($columns[0]['search']['value'])){
//            $this->db->where('erp_emails_campaign.id_folder', $columns[0]['search']['value']);
//        }

        $this->db->distinct();

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = $this->table.".id";
                    break;
                case 2:
                    $column = $this->table.".sapellidos";
                    break;
                case 3:
                    $column = $this->table.".snombre";
                    break;
                default:
                    $column = $this->table.".email";
            }
            $this->db->order_by($column, $column_dir);
        }

        $query = $this->db->get('', $length, $start);

        return $query->result_object();

    }
    
    public function get_students($tags = array()){
        
        $this->db->select("alumnos.ccodcli AS id, CONCAT('st_', alumnos.ccodcli) as _id, sapellidos AS `surname`, snombre AS `first_name`, email")
            ->from($this->table);
        $this->db->join('alumnos_tags AS atags', 'atags.ccodcli = alumnos.Ccodcli', 'left');
        if(!empty($tags)){
            $selected_surname = isset($tags['selected_surname']) ? $tags['selected_surname']: null;
            $selected_first_name = isset($tags['selected_first_name']) ? $tags['selected_first_name']: null;
            $selected_email = isset($tags['selected_email']) ? $tags['selected_email']: null;
            $selected_tag_ids = isset($tags['selected_students_tag_ids']) ? $tags['selected_students_tag_ids']: null;

            $like_exit = false;
//
            $where = '';
            if(!empty($selected_tag_ids) && is_array($selected_tag_ids)){
                if(empty($where)) {
                    //$where = ' WHERE ';
                }else{
                    $where .= ' AND ';
                }
                $ids_st = '';
                foreach($selected_tag_ids as $key=>$tags_loc){
                    $ids_st .= "'".$tags_loc."',";
                }
                $ids_st_ = trim($ids_st, ',');
                $where .= "atags.id_tag IN (".$ids_st_.")";
            }
            if(!empty($where)){
                $this->db->where($where);
            }

            if(!empty($selected_surname)){
                foreach ($selected_surname as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like($this->table.'.sapellidos', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like($this->table.'.sapellidos', $value);
                        }
                    }
                }
            }
//
            if(!empty($selected_first_name)){
                foreach ($selected_first_name as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like($this->table.'.snombre', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like($this->table.'.snombre', $value);
                        }
                    }
                }
            }
//
            if(!empty($selected_email)){
                foreach ($selected_email as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like($this->table.'.email', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like($this->table.'.email', $value);
                        }
                    }
                }
            }
        }
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_object();
    }


    public function getStudentsIdFields(){
        $this->db->select('ccodcli AS id, CONCAT("st_", ccodcli) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);
        
        $query = $this->db->get();

        return $query->result_object();

    }

    public function getStudentsByEmailForRecipient($email = null) {

        if(empty($email)){
            return false;
        }

        $this->db->select('ccodcli AS id, CONCAT("st_", ccodcli) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);
        $this->db->where($this->table.'.email', $email);
        $this->db->distinct();
        $query = $this->db->get();
//        $str = $this->db->last_query();
//        print_r($str);
        return $query->result_object();

    }
    
    public function getStudent($teacher,$groupId=null,$courseId=null){
        $groupCase = !empty($groupId)?"AND ml.IdGrupo = '$groupId' ":"";
        $courseId = !empty($groupId)?"AND ml.codigocurso = '$courseId' ":"";
        $sql = "SELECT al.CCODCLI AS studentid,
        CONCAT(al.sApellidos,', ',al.sNombre) AS Student_name,
        al.foto
        FROM
        matriculal AS ml 
        JOIN matriculat AS mt 
        ON ml.NumMatricula = mt.NumMatricula 
        LEFT JOIN alumnos AS al
        ON mt.CCODCLI = al.CCODCLI
        WHERE (ml.IdEstado = 0) AND (mt.Estado = 1) 
        $groupCase $courseId 
        AND (ml.IdProfesor = $teacher OR ml.idprofesoraux2 = $teacher OR ml.idprofesoraux2 = $teacher OR ml.idprofesoraux3 = $teacher)
        GROUP BY al.ccodcli
        ORDER BY studentid";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function getStudensCustom(){
        $query = "SELECT
                    al.Ccodcli  AS id,
                    al.photo_link,
                    al.sapellidos AS surname,
                    al.snombre AS firstname,
                    al.ctfo1cli AS phone,
                    al.movil AS mobile,
                    al.email,
                    IF((SELECT COUNT(DISTINCT ccodcli) FROM matriculat WHERE estado = 1 AND ccodcli = al.ccodcli)>0,'Active','Not Active') AS status,

                    DATE(al.`FirstUpdate`) AS `date_creation`,
                    DATE(al.`LastUpdate`) AS `last_update`,
                    (SELECT DATE(`fecha`) FROM alumnos_segui WHERE `ccodcli`= al.`CCODCLI` ORDER BY 1 DESC LIMIT 1) AS `last_followUp`,

                    IF(
                    (SELECT COUNT(*) FROM matriculat WHERE estado =1 AND ccodcli = al.ccodcli)>0,
                       (SELECT `Descripcion` FROM matriculat WHERE ccodcli = al.ccodcli ORDER BY nummatricula DESC LIMIT 1),
                       '') AS course

                    FROM alumnos AS al
                    ORDER BY 4,3
                     ";
        return $this->selectCustom($query);
    }

    public function getStudensCustomAjax($start, $length, $draw, $search, $order, $columns, $filter_tags){
        $where = '';
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
            $where .= "atags.id_tag IN (".$ids_st_.")";
        }

        $this->db->select(" SQL_CALC_FOUND_ROWS null AS rows,
                    al.Ccodcli  AS id,
                    al.photo_link,
                    al.sapellidos AS surname,
                    al.snombre AS firstname,
                    al.ctfo1cli AS phone,
                    al.movil AS mobile,
                    al.email,
                    group_concat(atags.id_tag separator ',') AS tag_ids,
                    IF((SELECT COUNT(DISTINCT ccodcli) FROM matriculat WHERE estado = 1 AND ccodcli = al.ccodcli)>0,'Active','Not Active') AS status,
                   
                    DATE(al.`FirstUpdate`) AS `date_creation`,
                    DATE(al.`LastUpdate`) AS `last_update`,
                    (SELECT DATE(`fecha`) FROM alumnos_segui WHERE `ccodcli`= al.`CCODCLI` ORDER BY 1 DESC LIMIT 1) AS `last_followUp`,

                    IF(
                    (SELECT COUNT(*) FROM matriculat WHERE estado =1 AND ccodcli = al.ccodcli)>0,
                       (SELECT `Descripcion` FROM matriculat WHERE ccodcli = al.ccodcli ORDER BY nummatricula DESC LIMIT 1),
                       '') AS course
                   ", false);
        $this->db->from($this->table.' AS al');
        $this->db->join('alumnos_tags AS atags', 'atags.ccodcli = al.Ccodcli', 'left');
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('al.sapellidos', $search['value']);
            $this->db->or_like('al.snombre', $search['value']);
            $this->db->or_like('al.ctfo1cli', $search['value']);
            $this->db->or_like('al.movil', $search['value']);
            $this->db->or_like('al.email', $search['value']);
            $this->db->or_like('al.`FirstUpdate`', $search['value']);
            $this->db->or_like('al.`LastUpdate`', $search['value']);
        }
        if(isset($filter_tags->selected_state[0]) && $filter_tags->selected_state[0] == '1') {
            $this->db->where('(SELECT COUNT(DISTINCT ccodcli) FROM matriculat WHERE estado = 1 AND ccodcli = al.ccodcli) > 0');
        }elseif(isset($filter_tags->selected_state[0]) && $filter_tags->selected_state[0] == '2'){
            $this->db->where('(SELECT COUNT(DISTINCT ccodcli) FROM matriculat WHERE estado = 1 AND ccodcli = al.ccodcli) = 0');
        }elseif(isset($filter_tags->selected_state[0]) && isset($filter_tags->selected_state[1])){
            $this->db->where('(SELECT COUNT(DISTINCT ccodcli) FROM matriculat WHERE estado = 1 AND ccodcli = al.ccodcli) >= 0');
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->distinct();
        $this->db->group_by('al.Ccodcli');
        $this->db->order_by('5,4');
        $this->db->limit($length, $start);
        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }


    public function getAlumnoTopData(){
        $query = "SELECT 
  (SELECT 
    COUNT(*) 
  FROM
    alumnos 
  WHERE ccodcli IN 
    (SELECT 
      ccodcli 
    FROM
      matriculat 
    WHERE estado = 1)) AS active_students,
  (SELECT 
    COUNT(*) 
  FROM
    alumnos 
  WHERE ccodcli IN 
    (SELECT DISTINCT 
      ccodcli 
    FROM
      matriculat 
    WHERE estado <> 1)) AS ex_students,


  (SELECT 
    COUNT(DISTINCT ccodcli) 
  FROM
    alumnos 
  WHERE ccodcli IN 
    (SELECT 
      ccodcli 
    FROM
      matriculat 
    WHERE (
        YEAR(matriculat.`FechaMatricula`) = YEAR(CURDATE())
      ) 
      AND (
        MONTH(matriculat.`FechaMatricula`) = MONTH(CURDATE())
      ))) AS last_month,

  (
    (SELECT 
      COUNT(*) 
    FROM
      alumnos 
)
  ) AS total_students";

        return $this->selectCustom($query);
    }

    public function insertStudent($insert_data){
        return $this->db->insert($this->table, $insert_data);
    }

    public function getStudentById($id){
        $query = $this->db->select('
                                      ccodcli AS id,
                                      snombre AS first_name,
                                      sapellidos AS sur_name,
                                      CONCAT(snombre,"  ",sapellidos) AS full_name,
                                      cdomicilio AS address,
                                      cpobcli AS city,
                                      ccodprov AS provincia,
                                      LugarNacimiento AS place_birth,
                                      COBSCLI AS social_security,
                                      cptlcli AS postal_code,
                                      cnaccli AS country,
                                      tipodoc AS doc_type,
                                      cdnicif AS dni,
                                      ctfo1cli AS phone1,
                                      ctfo2cli AS phone2,
                                      movil AS mobile,
                                      email AS email1,
                                      email2,
                                      photo_link,
                                      skypealumno AS skype,
                                      idsexo AS sex,
                                      nacimiento AS `birthday`,
                                      '.'IF((SELECT COUNT(DISTINCT ccodcli) FROM matriculat AS mt WHERE estado = 1 AND mt.ccodcli = alumnos.ccodcli)>0,"Active","Not Active") AS status,'.
                                      'YEAR(FROM_DAYS(DATEDIFF(NOW(),nacimiento))) AS `years_old`,
                                      autoriza_apd AS apd,

                                      `tut1_snombre` AS tutor1_firstname,
                                      `tut1_nombre` AS tutor1_fullname,
                                      `tut1_sapellido1` AS tutor1_firstsurname,
                                      `tut1_sapellido2` AS tutor1_lastsurname,
                                      `tut1_direccion` AS tutor1_address,
                                      `tut1_email1` AS tutor1_email1,
                                      `tut1_email2` AS tutor1_email2,
                                      `tut1_cp` AS tutor1_postal_code,
                                      `tut1_dni` AS tutor1_dni,
                                      `tut1_pais` AS tutor1_country,
                                      `tut1_poblacion` AS tutor1_city,
                                      `tut1_provincia` AS tutor1_provincia,
                                      `tut1_tfno1` AS tutor1_phone1,
                                      `tut1_tfno1` AS tutor1_phone2,
                                      `tut1_movil` AS tutor1_mobile,
                                       `tut1_tipodoc` AS tutor1_doc_type,
                                       `tut1_idparentesco` AS tutor1_relationship,

                                      `tut2_snombre` AS tutor2_firstname,
                                      `tut2_nombre` AS tutor2_fullname,
                                      `tut2_sapellido1` AS tutor2_firstsurname,
                                      `tut2_sapellido2` AS tutor2_lastsurname,
                                      `tut2_direccion` AS tutor2_address,
                                      `tut2_email1` AS tutor2_email1,
                                      `tut2_email2` AS tutor2_email2,
                                      `tut2_cp` AS tutor2_postal_code,
                                      `tut2_dni` AS tutor2_dni,
                                      `tut2_pais` AS tutor2_country,
                                      `tut2_poblacion` AS tutor2_city,
                                      `tut2_provincia` AS tutor2_provincia,
                                      `tut2_tfno1` AS tutor2_phone1,
                                      `tut2_tfno1` AS tutor2_phone2,
                                      `tut2_movil` AS tutor2_mobile,
                                      `tut2_tipodoc` AS tutor2_doc_type,
                                      `tut2_idparentesco` AS tutor2_relationship,

                                       IdFP` AS id_payment_method,
                                       ccodpago AS payment_description,
                                      `dto` AS special_discount,
                                      `precio_hora` AS hour_rate,
                                      `DniTitular` AS fiscal_code,
                                       CNBRBCO AS account_holder,
                                      `nacionalidad_titular` AS nationality,
                                      `titular_email` AS headline_email,
                                      `IBAN` AS bank_account,
                                      `firmado_sepa` AS signed_sepa,
                                      `FacturarA` AS invoices_company,
                                       `custom_fields` AS custom_fields
                                    ')
                          ->from($this->table)
                          ->where('ccodcli', $id)
                          ->get();
        return $query->row();
    }

    public function getStudentByGroupIds($ids, $teacher_id){
        $query = "SELECT DISTINCT al.`CCODCLI` AS student_id, CONCAT(al.`sApellidos` ,', ',al.snombre) AS student_name, al.email as student_email, al.tut1_email1, al.tut2_email1
                    FROM matriculal AS ml
                    LEFT JOIN matriculat AS mt ON ml.`NumMatricula` = mt.`NumMatricula`
                    LEFT JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI`
                    WHERE 
                    (ml.`IdProfesor` = '". $teacher_id ."' OR ml.`idprofesoraux` = '". $teacher_id ."' OR ml.`idprofesoraux2`= '". $teacher_id ."' OR ml.`idprofesoraux3`= '". $teacher_id ."')
                    AND mt.`Estado` = 1
                    and ml.`idgrupo` IN (". $ids .")
                    and al.email IS NOT NULL
                    ";
        return $this->selectCustom($query);
    }

    public function getStudentByGroupIdsForLms($id_group = array(), $id_course = array()){
        $this->db->select("al.`CCODCLI` AS id, CONCAT(al.`sApellidos` ,', ',al.snombre) AS name, al.email");
        $this->db->from('matriculal AS ml');
        $this->db->join('matriculat AS mt', 'ml.NumMatricula = mt.NumMatricula', 'left');
        $this->db->join('alumnos AS al', 'mt.CCODCLI = al.CCODCLI', 'left');
        $this->db->where('mt.Estado', '1');
        $this->db->where_in('ml.idgrupo', $id_group);
        $this->db->distinct();
        if(!empty($id_course)) {
            $this->db->where_in('ml.codigocurso', $id_course);
        }
        $this->db->where("al.email IS NOT NULL");
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentByEnrollId($id){
        $query = $this->db->select('
                                      al.ccodcli AS id,
                                      al.snombre AS first_name,
                                      al.sapellidos AS sur_name,
                                      al.cdomicilio AS address,
                                      al.cpobcli AS city,
                                      al.ccodprov AS provincia,
                                      al.LugarNacimiento AS place_birth,
                                      al.COBSCLI AS social_security,
                                      al.cptlcli AS postal_code,
                                      al.cnaccli AS country,
                                      al.tipodoc AS doc_type,
                                      al.cdnicif AS dni,
                                      al.ctfo1cli AS phone1,
                                      al.ctfo2cli AS phone2,
                                      al.movil AS mobile,
                                      al.email AS email1,
                                      al.email2,
                                      al.skypealumno AS skype,
                                      al.idsexo AS sex,
                                      al.nacimiento AS `birthday`,
                                      '.'IF((SELECT COUNT(DISTINCT ccodcli) FROM matriculat AS mt WHERE estado = 1 AND mt.ccodcli = al.ccodcli)>0,"Active","Not Active") AS status,'.
                                      'YEAR(FROM_DAYS(DATEDIFF(NOW(),al.nacimiento))) AS `years_old`,
                                      al.autoriza_apd AS apd,

                                      al.tut1_nombre` AS tutor1_firstname,
                                      al.`tut1_sapellido1` AS tutor1_firstsurname,
                                      al.`tut1_sapellido2` AS tutor1_lastsurname,
                                      al.`tut1_direccion` AS tutor1_address,
                                      al.`tut1_email1` AS tutor1_email1,
                                      al.`tut1_email2` AS tutor1_email2,
                                      al.`tut1_cp` AS tutor1_postal_code,
                                      al.`tut1_dni` AS tutor1_dni,
                                      al.`tut1_pais` AS tutor1_country,
                                      al.`tut1_poblacion` AS tutor1_city,
                                      al.`tut1_provincia` AS tutor1_provincia,
                                      al.`tut1_tfno1` AS tutor1_phone1,
                                      al.`tut1_tfno1` AS tutor1_phone2,
                                      al.`tut1_movil` AS tutor1_mobile,
                                       al.`tut1_tipodoc` AS tutor1_doc_type,
                                       al.`tut1_idparentesco` AS tutor1_relationship,

                                      al.`tut2_nombre` AS tutor2_firstname,
                                      al.`tut2_sapellido1` AS tutor2_firstsurname,
                                      al.`tut2_sapellido2` AS tutor2_lastsurname,
                                      al.`tut2_direccion` AS tutor2_address,
                                      al.`tut2_email1` AS tutor2_email1,
                                      al.`tut2_email2` AS tutor2_email2,
                                      al.`tut2_cp` AS tutor2_postal_code,
                                      al.`tut2_dni` AS tutor2_dni,
                                      al.`tut2_pais` AS tutor2_country,
                                      al.`tut2_poblacion` AS tutor2_city,
                                      al.`tut2_provincia` AS tutor2_provincia,
                                      al.`tut2_tfno1` AS tutor2_phone1,
                                      al.`tut2_tfno1` AS tutor2_phone2,
                                      al.`tut2_movil` AS tutor2_mobile,
                                      al.`tut2_tipodoc` AS tutor2_doc_type,
                                      al.`tut2_idparentesco` AS tutor2_relationship,

                                       al.IdFP` AS id_payment_method,
                                       al.ccodpago AS payment_description,
                                      al.`dto` AS special_discount,
                                      al.`precio_hora` AS hour_rate,
                                      al.`DniTitular` AS fiscal_code,
                                       al.CNBRBCO AS account_holder,
                                      al.`nacionalidad_titular` AS nationality,
                                      al.`titular_email` AS headline_email,
                                      al.`IBAN` AS bank_account,
                                      al.`firmado_sepa` AS signed_sepa,
                                      al.`FacturarA` AS invoices_company
                                    ')
                          ->from($this->table.' AS al')
                          ->join('matriculat AS mt', 'mt.ccodcli=al.ccodcli', 'left')
                          ->where('mt.nummatricula', $id)
                          ->get();
        return $query->row();
    }


    public function updateStudent($id,$update_data){
        return $this->update($this->table, $update_data, array('ccodcli' => $id));
    }

    public function updateStudentBilling($student_id, $update_data){
        return $this->update($this->table, $update_data, array('ccodcli' => $student_id));
    }


    public function updateItem($data, $indice){
        return $this->update($this->table, $data, array('CCODCLI'=>$indice));
    }


    public function updateItemById($data, $id){
        return $this->update($this->table, $data, array('Id'=>$id));
    }


     public function getStudentLinks($student_id){
         $query = "SELECT COUNT(*) AS count_link FROM alumnos
                    WHERE ccodcli IN
                    (SELECT calumno AS ccodcli FROM agenda
                    UNION
                    SELECT ccodcli FROM matriculat
                    )
                    AND ccodcli = '".$student_id."'
                    ";
         return $this->selectCustom($query);
     }

    public function deleteStudent($studnet_id){
        return $this->delete($this->table, array('ccodcli' => $studnet_id));
    }

   public function getStudentPhotoLink($id){
       $query = $this->db->select('photo_link')
           ->from($this->table)
           ->where('CCODCLI', $id)
           ->get();
       return $query->row();
   }

    public function updateProfilePhoto($id, $date, $url, $remove = false){
        $data = array(
            'LastUpdate' => $date,
            'photo_link' => $url
        );
        if($remove){
            $data['foto'] = '';
        }

        $query = $this->db->where('CCODCLI', $id)
            ->update($this->table, $data);

        return $query;
    }

    public function getAlumnoForFilter(){
        $query = "SELECT CONCAT(sapellidos,', ',snombre) AS text, ccodcli AS id
                    FROM alumnos
                    WHERE ccodcli IN
                    (SELECT ccodcli FROM matriculat)
                    ORDER BY 1";
        return $this->selectCustom($query);
    }

    public function getNotEnrolledStudnts(){
        $query = "SELECT
                al.ccodcli AS id,
                CONCAT(al.sapellidos,' ',al.snombre) AS name

                FROM alumnos AS al
                WHERE al.`CCODCLI` NOT IN
                (
                  SELECT matriculat.`CCODCLI` FROM matriculat LEFT JOIN matriculal ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
                    WHERE matriculat.`Estado` = 1 OR matriculal.`IdEstado` IN (0,2,4)
                )
                GROUP BY 1
                ORDER BY 2";

        return $this->selectCustom($query);
    }

    public function getNotEnrolledStudntsByCourse($group_id){
        $query = "SELECT
                    al.ccodcli AS id,
                    CONCAT(al.sapellidos,' ',al.snombre) AS `name`
                    
                    FROM alumnos AS al
                    WHERE al.`CCODCLI` NOT IN
                    (
                    SELECT matriculat.`CCODCLI` FROM matriculat LEFT JOIN matriculal ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
                    WHERE (matriculat.`Estado` = 1 OR matriculal.`IdEstado` IN (0,2,4)) AND matriculal.`codigocurso` IN ( 
                    SELECT 
                          cu.`codigo` AS course_id
                        
                        FROM
                          gruposl AS gl 
                          JOIN grupos AS gr 
                            ON gl.`CodigoGrupo` = gr.`codigogrupo` 
                          LEFT JOIN curso AS cu 
                            ON gl.`codigocurso` = cu.`codigo` 
                        WHERE gr.`codigogrupo` = '". $group_id ."' 
                     )
                    )
                    GROUP BY 1
                    ORDER BY 2";

        return $this->selectCustom($query);
    }

    public function makeInsertData($post_data){

        $insert_data = array();
        foreach ($this->fields as $field){
            if(isset($post_data[$field])){
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'
                    || $field == 'nacimiento'){
                    $insert_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[$field]));
                }else{
                    $insert_data[$field] = $post_data[$field];
                }
            }else{
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'
                    || $field == 'nacimiento'){
                    $insert_data[$field] = date('Y-m-d H:i:s');
                }else{
                    $insert_data[$field] = null;
                }
            }
        }
        return $insert_data;
    }

    public function makeUpdateData($post_data){
        $update_data = array();        
        foreach ($this->fields as $field){
            if(isset($post_data[$field])){
                if($field == 'FirstUpdate'
                || $field == 'LastUpdate'
                || $field == 'nacimiento'){
                    $update_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[$field]));
                }else{
                    $update_data[$field] = $post_data[$field];
                }
            }
        }
       
        return $update_data;
    }

    public function get_students_for_select(){
        $query = "SELECT 
                    ccodcli as studentid, 
                    concat(sapellidos,', ',snombre) as student_name 
                    FROM alumnos ORDER BY 2;";
        
        return  $this->selectCustom($query);
    }
    public function getAllActiveStudents(){
        $query = $this->db->select('ctfo1cli AS phone1,
                                    ctfo2cli AS phone2,
                                    movil AS mobile,
									Email AS email,
									Email2 AS email2,
									nacimiento AS birth_date,
									CONCAT(sNombre, " ", sApellidos) AS full_name,
									sNombre AS first_name,
									sApellidos AS sur_name')
            ->from($this->table)
            ->where('enebc', '1')
            ->get();

        return $query->result();
    }

    public function getStudentsByGroupCourse($geoup_id, $course_id){
        $query = "SELECT DISTINCT al.ctfo1cli AS phone1,
                                    al.ctfo2cli AS phone2,
                                    al.movil AS mobile,
									al.Email AS email,
									al.Email2 AS email2,
									al.nacimiento AS birth_date,
									CONCAT(al.sNombre, ' ', al.sApellidos) AS full_name,
									al.sNombre AS first_name,
									al.sApellidos AS sur_name
                    FROM matriculal AS ml
                      JOIN matriculat AS mt ON ml.`NumMatricula` = mt.`NumMatricula`
                      JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI`
                    WHERE ml.`IdGrupo` = '".$geoup_id."' AND ml.`codigocurso` = '".$course_id."' AND 
                          ml.`IdEstado`=0 AND mt.`Estado`=1 AND al.`Email` IS NOT NULL
                    ";

        return $this->selectCustom($query);
    }
}
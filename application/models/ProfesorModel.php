<?php

class ProfesorModel extends MagaModel {

	public $fields = array(
		'INDICE',
		'sNombre',
		'sApellidos',
		'Domicilio',
		'POBLACION',
		'PROVINCIA',
		'DISTRITO',
		'Nacionalidad',
		'TFO1',
		'TFO2',
		'movil',
		'DNI',
		'Email',
		'Email2',
		'nombre',
		'skypeprofesor',
		'FirstUpdate',
		'LastUpdate',
		'Activo',
		'NumSS',
		'Nacionalidad',
		'nacimiento',
	);
    public function __construct() {
        parent::__construct();
        $this->table = "profesor";
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

	public function getAll($selectParams = '', $where = array()) {
		return  $this->selectAll($this->table, $selectParams, $where);
	}

	public function checkProfesor($user = null, $clave = null) {

        if(!$user || !$clave){
            return false;
        }
        $query = "SELECT count(*) as num FROM profesor WHERE usuario = '$user' AND clave = '$clave' and activo=1 AND enebc=1;";

        $r = $this->db->query($query);

        return $r->result_array();
    }
	public function checkProfesorByemail($email = null, $clave = null) {

        if(!$email || empty($email) || !$clave){
            return false;
        }
        $query = "SELECT count(*) as num FROM profesor WHERE email = '$email' AND clave = '$clave' and activo=1 AND enebc=1;";

        $r = $this->db->query($query);

        return $r->result_array();
    }

    public function getProfesor($user = null, $clave = null) {

        if(!$user || !$clave){
            return false;
        }
//        $query = "SELECT `indice` as userid, `nombre` as username FROM profesor WHERE `usuario` = '$user' AND `clave` = '$clave';";
        $query = "SELECT * FROM profesor WHERE `usuario` = '$user' AND `clave` = '$clave' and activo=1 AND enebc=1;";

        $r = $this->db->query($query);

        return $r->result();
    }
	public function getProfesorByemail($email = null, $clave = null) {

        if(!$email || empty($email) || !$clave){
            return false;
        }
//        $query = "SELECT `indice` as userid, `nombre` as username FROM profesor WHERE `usuario` = '$user' AND `clave` = '$clave';";
        $query = "SELECT * FROM profesor WHERE `email` = '$email' AND `clave` = '$clave' and activo=1 AND enebc=1;";

        $r = $this->db->query($query);

        return $r->result();
    }
    
    public function profile($id){
    	$this->db->where('INDICE', $id);
		$query = $this->db->get('profesor');
		$result = (array)$query->row_array();
    	return $result;
    }
    
	public function change_password($id=null,$password=null){
		$this->db->where('profesor.INDICE',$id);
		$query = $this->db->update('profesor', array('clave'=>$password));
		return $query;
	}

	public function updateProfilePhoto($id, $date, $url, $remove = false){
     $data = array(
		 		'LastUpdate' => $date,
		 		'photo_link' => $url
		 );
		if($remove){
			$data['foto'] = '';
		}

		$query = $this->db->where('INDICE', $id)
						  ->update($this->table, $data);

		return $query;
	}

	public function forget_password($email){
		$this->load->library('email');
		$this->db->where('Email', $email);
		$query = $this->db->get('profesor');
		$result = (array)$query->row_array();
		if(!empty($result)){
			$newpassword = substr(uniqid(mt_rand(), true), 0, 9);;
			$this->db->where('profesor.INDICE',$result['INDICE']);
			if($this->db->update('profesor', array('clave'=>$newpassword))){
				$this->email->from('soporte4@softaula.com', 'soporte4@softaula.com');
				$this->email->to($email); 
				$this->email->subject('Password Reset');
				$this->email->message('New Password : '.$newpassword);
				if($this->email->send()){
					//Send
				}else{
					//Not Send
				}
			}else{
				//Not updated
			}
			//redirect();
		}else{
			//This email Id doesn't exist;
		}
    }
    
	public function check_password($oldpassword,$id){
		$this->db->where('usuario', $id);
		$this->db->where('clave', $oldpassword);
		$query = $this->db->get('profesor');
		return $query->num_rows(); 
    }

	public function get_campus_teachers($where = null){
		 $this->db->select('pf.indice AS id, pf.nombre AS teacher_name, pf.Usuario AS user_name, pf.TFO1 AS
                   					 phone, pf.movil AS mobile, pf.enebc AS Allowed, pf.Activo AS status, pf.Email AS email, pf.foto AS photo')
							->from('profesor AS pf');
							if($where){
								$this->db->where($where);
							}
		$query = $this->db->get();
		return $query->result();
	}

	public function conut_active_teachers(){
		$query = $this->db->where(array('enebc' => 1))
			->get($this->table);
		$result = $query->num_rows();
		return $result;
	}

	public function update_teachers_data($data = null){
		$this->db->where('Activo', '1');
		$result = $this->db->update_batch($this->table, $data, 'INDICE');
		return $result;
	}
	public function get_company_name($where = null){
		$query = $this->db->select('nombrecomercial AS company_name')
			->from('miempresa');
		if($where){
			$query->where($where);
		}
		return $query->get()->result();
	}



	public function getPhoto($uid){
//		$sql_photo = "SELECT foto_thumb, IF( Length(foto) > 0 , '1', '0' ) AS tienefoto, IF(  Length(foto_thumb) > 0 , '1', '0' ) AS tienethumb   FROM `profesor` WHERE `INDICE`='".$uid."'";
		$sql_photo = "SELECT
					  foto,
					  IF(LENGTH(foto) > 0, '0', '1') AS photo_is_empty
					FROM
					  `profesor`
					WHERE `INDICE` ='".$uid."'";
		return $this->selectCustom($sql_photo);
	}

	public function listTeachers($user_id = null, $teacher_id = null){
		$query = "SELECT
				   indice AS `id`,
				   nombre AS `teacher_name`
				   FROM profesor WHERE indice IN
				   (
				 		SELECT DISTINCT matriculal.idprofesor FROM matriculal
				 		LEFT JOIN matriculat
				 			ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
				 		WHERE matriculat.`Estado`=1
				 			AND matriculat.`CCODCLI` = $user_id
				   ) ". ($teacher_id ? ' AND profesor.indice = '. $teacher_id : '') ."
					ORDER BY 2";
		return $this->selectCustom($query);
	}

	public function getTeachersByAjax($start, $length, $draw, $search, $order, $columns = '') {

		$this->db->select('indice AS id, CONCAT("te_", indice) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
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
//		$str = $this->db->last_query();
//		print_r($str);
		return $query->result_object();

	}


	public function get_teachers($tags = array()){
		
		$this->db->select('indice AS id, CONCAT("te_", indice) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
			->from($this->table);

		if(!empty($tags)){
			$selected_surname = isset($tags['selected_surname']) ? $tags['selected_surname']: null;
			$selected_first_name = isset($tags['selected_first_name']) ? $tags['selected_first_name']: null;
			$selected_email = isset($tags['selected_email']) ? $tags['selected_email']: null;

			$like_exit = false;
//
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
		
		$query = $this->db->get();
		return $query->result_object();
	}

	public function getTeachersIdFields(){
		
		$this->db->select('indice AS id, CONCAT("te_", indice) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
			->from($this->table);
		$query = $this->db->get();

		return $query->result_object();

	}

	public function getTeachers(){
		$query = "SELECT
					indice AS id,
					CONCAT(sapellidos,', ',snombre) AS teacher_name,
					foto AS photo,
					tfo1 AS phone,
					movil AS cell,
					email,
					activo AS status

					FROM profesor
					ORDER BY 2

					";
		return $this->selectCustom($query);
	}

	public function getTeachersForSchedule(){
		$query = "SELECT DISTINCT 
					  pf.indice AS teacher_id,
					  pf.nombre AS teacher_name,
					  HEX(pf.idcolor) AS color 
					FROM
					  profesor AS pf 
					WHERE pf.indice IS NOT NULL 
					  AND pf.activo = 1 
					ORDER BY 2
					;";
		return $this->selectCustom($query);
	}

	public function insertProfesor($data){
		return $this->insert($this->table, $data);
	}

	public function getTeacherById($id){
		$query = $this->db->select("
									INDICE AS id,
									snombre AS first_name,
								  	POBLACION AS city,
								  	PROVINCIA AS provincia,
			                        DISTRITO AS  postal_code,
			                        DNI AS passport,
									TFO1 AS phone1,
									TFO2 AS phone2,
									movil AS mobile,
									skypeprofesor AS skype,
									FirstUpdate AS date_of_creation,
									LastUpdate AS last_update,
									activo AS active,
									Email AS email1,
									Email2 AS email2,
									Foto AS photo,
									numss AS social_security,
									nacionalidad AS nacionality,
									nacimiento AS birth_date,
									nombre AS full_name,
									sNombre AS first_name_1,
									sApellidos AS sur_name,
									custom_fields AS custom_fields
								  ")
							->from($this->table)
							->where('INDICE', $id)
							->get();
		return $query->row();
	}

	public function updateProfesor($id, $data){
		return $this->update($this->table, $data, array('INDICE' => $id));
	}

	public function getExistCourses($teacher_id){
		$exist = "SELECT DISTINCT codcurso AS id  FROM profesor_d
						WHERE  `Indice` = '". $teacher_id ."'";
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

	public function getCourses($teacher_id){
		$query = "SELECT DISTINCT
					  cu.codigo AS `CourseId`,
					  cu.CURSO AS `Course`
					FROM
					  profesor_d AS pd
					  INNER JOIN curso AS cu
						ON pd.CodCurso = cu.CODIGO
					WHERE pd.Indice = '".$teacher_id."'
					ORDER BY cu.CODIGO
					";
		$result = $this->selectCustom($query);
		return $result;
	}

	public function insertCourses($data){
		return $this->db->insert_batch('profesor_d', $data);
	}

	public function deleteCourse($data){
		return $this->db->delete('profesor_d', $data);
	}

	public function existTeacherLink($teacher_id){
		$query = "SELECT COUNT(*) AS count_link FROM profesor
					WHERE indice IN
					(SELECT iprofesor FROM agenda
					UNION
					SELECT iprofesor FROM agendagrupos
					UNION
					SELECT idprofesor FROM matriculal
					UNION
					SELECT idprofesor FROM gruposl
					)
					AND indice = '".$teacher_id."'";

		$result = $this->selectCustom($query);
		return $result;
	}

	public function deleteTeacher($teacher_id){
		$result = $this->delete($this->table, array('INDICE' => $teacher_id));
		return $result;
	}


	public function getTeachersByEmailForRecipient($email = null) {

		if(empty($email)){
			return false;
		}

		$this->db->select('indice AS id, CONCAT("te_", indice) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
			->from($this->table);
		$this->db->where($this->table.'.email', $email);
		$this->db->distinct();
		$query = $this->db->get();
//        $str = $this->db->last_query();
//        print_r($str);die;
		return $query->result_object();

	}

	public function getTeacherTags(){
		$query = "SELECT id, descripcion AS tag, HEX(color) AS color
					FROM etiquetas_profesor
					ORDER BY 2
					";
		$result = $this->selectCustom($query);
		return $result;
	}

	public function getTeacherDataFields($teacher_id){
		$query = $this->db->select("indice as Idprofesor,
		 							nombre,domicilio, poblacion, provincia, distrito as `cod postal`,
		 							dni, tfo1 as `telefono`,tfo2 as `telefono 2`, movil,fax, email,
		 							email2 as `email 2`, skypeprofesor as `skype`, ccodpago as `forma de pago`, cnbrbco as `entidad de cargo`,
		 							 concat(ifnull(centidad,'?'),'-',ifnull(cagencia,'?'),'-',ifnull(cctrlbco,'?'),'-',ifnull(ccuenta,'?')) as `cuenta bancaria`, swift , iban")

						 ->from($this->table)
						 ->where('indice', $teacher_id)
		                 ->get();

		return $query->row();
	}

	public function getTeachersForAttendance(){
		$query = "SELECT indice AS teacherid,
					CONCAT(sapellidos,', ',snombre) AS teacher_name
					FROM profesor
					WHERE activo=1
					ORDER BY sapellidos";


		$result = $this->selectCustom($query);
		return $result;
	}

	public function updateItem($data, $indice){
		return $this->update($this->table, $data, array('INDICE'=>$indice));
	}

	public function getTeacherPhotoLink($id){
		$query = $this->db->select('photo_link')
						  ->from($this->table)
						  ->where('INDICE', $id)
						  ->get();
		return $query->row();
	}

	public function getTeacherBygroup($group_id, $search = null, $event_id = null, $where_not_in = null){
		$where_event = $event_id ? " AND agendagrupos.id=$event_id" : '';
		$where_search = $search ? " AND CONCAT(pf.sapellidos,', ',pf.snombre) LIKE '%$search%'" : '';
		$where_search .= $where_not_in ? "AND pf.`INDICE` not in (" .$where_not_in .")" : '';
		$query = "SELECT pf.`INDICE` AS teacher_id, CONCAT(pf.sapellidos,', ',pf.snombre) AS teacher_name
					FROM profesor AS pf
					WHERE pf.`INDICE` NOT IN
					(
					SELECT agendagrupos.`iprofesor`
					FROM agendagrupos WHERE agendagrupos.`CodigoGrupo` = '".$group_id."' $where_event
					UNION
					SELECT agendagrupos.`idprofesoraux`
					FROM agendagrupos WHERE agendagrupos.`CodigoGrupo` = '".$group_id."' $where_event
					UNION
					SELECT agendagrupos.`idprofesoraux2`
					FROM agendagrupos WHERE agendagrupos.`CodigoGrupo` = '".$group_id."' $where_event
					UNION
					SELECT agendagrupos.`idprofesoraux3`
					FROM agendagrupos WHERE agendagrupos.`CodigoGrupo` = '".$group_id."' $where_event
					)
					$where_search
					GROUP BY pf.`INDICE`
					ORDER BY 2";

		return $this->selectCustom($query);
	}

	public function getTeacherForEvents($group_id, $where_not_in = null){
		$where_not_in = $where_not_in ? 'AND pf.`INDICE` NOT IN ('.$where_not_in.')' : '';
		$query = "SELECT pf.`INDICE` AS teacher_id, CONCAT(pf.sapellidos,', ',pf.snombre) AS teacher_name
					FROM profesor AS pf
					WHERE pf.`INDICE` IN
					(
					SELECT gruposl.`IdProfesor`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."'
					UNION
					SELECT gruposl.`idprofesoraux`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."'
					UNION
					SELECT gruposl.`idprofesoraux2`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."'
					UNION
					SELECT gruposl.`idprofesoraux3`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."'
					)
					$where_not_in
					GROUP BY pf.`INDICE`
					ORDER BY 2
					 ";

		return $this->selectCustom($query);
	}

	public function getTeacherForEventsByCourseId($group_id, $course_id, $where_not_in = null){
		$where_not_in = $where_not_in ? 'AND pf.`INDICE` NOT IN ('.$where_not_in.')' : '';
		$query = "SELECT pf.`INDICE` AS teacher_id, CONCAT(pf.sapellidos,', ',pf.snombre) AS teacher_name
					FROM profesor AS pf
					WHERE pf.`INDICE` IN
					(
					SELECT gruposl.`IdProfesor`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."' and  gruposl.`codigocurso` = '".$course_id."'
					UNION
					SELECT gruposl.`idprofesoraux`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."' and gruposl.`codigocurso` = '".$course_id."'
					UNION
					SELECT gruposl.`idprofesoraux2`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."' and gruposl.`codigocurso` = '".$course_id."'
					UNION
					SELECT gruposl.`idprofesoraux3`
					FROM gruposl WHERE gruposl.`CodigoGrupo` = '".$group_id."' and  gruposl.`codigocurso` = '".$course_id."'
					)
					$where_not_in
					GROUP BY pf.`INDICE`
					ORDER BY 2
					 ";

		return $this->selectCustom($query);
	}


	/**
	public function makeInsertData($post_data){
		
		$active = isset($post_data['active']) ? $post_data['active'] : 0;
		$active = ($active == "1") ? 1 : 0;
		$snambre = isset($post_data['snombre']) ? $post_data['snombre'] : null;
		$sapellidos = isset($post_data['sapellidos']) ? $post_data['sapellidos'] : null;

		$insert_data = array(
			'INDICE' => isset($post_data['indice']) ? $post_data['indice'] : null,
			'sNombre' => $snambre,
			'sApellidos' => $sapellidos,
			'Domicilio' => isset($post_data['domicilio']) ? $post_data['domicilio'] : null,
			'POBLACION' => isset($post_data['poblacion']) ? $post_data['poblacion'] : null,
			'PROVINCIA' => isset($post_data['provincia']) ? $post_data['provincia'] : null,
			'DISTRITO' => isset($post_data['distrito']) ? $post_data['distrito'] : null,
			'Nacionalidad' => isset($post_data['nacionalidad']) ? $post_data['nacionalidad'] : null,
			'TFO1' => isset($post_data['tfo1']) ? $post_data['tfo1'] : null,
			'TFO2' => isset($post_data['tfo2']) ? $post_data['tfo2'] : null,
			'movil' => isset($post_data['movil']) ? $post_data['movil'] : null,
			'DNI' => isset($post_data['dni']) ? $post_data['dni'] : null,
			'Email' => isset($post_data['email']) ? $post_data['email'] : null,
			'Email2' => isset($post_data['email2']) ? $post_data['email2'] : null,
			'nombre' => $snambre. " ". $sapellidos, //TODO need to be check
			'skypeprofesor' => isset($post_data['skypeprofesor']) ? $post_data['skypeprofesor'] : null,
			'FirstUpdate' => isset($post_data["FirstUpdate"]) ? date('Y-m-d H:i:s', strtotime($post_data["FirstUpdate"])) : date('Y-m-d H:i:s'),
			'LastUpdate' => isset($post_data["LastUpdate"]) ? date('Y-m-d H:i:s', strtotime($post_data["LastUpdate"])) : date('Y-m-d H:i:s'),
			'Activo' => $active,
			'NumSS' => isset($post_data['numss']) ? $post_data['numss'] : null,
			'Nacionalidad' => isset($post_data['nacionalidad']) ? $post_data['nacionalidad'] : null,
			'nacimiento' => isset($post_data['nacimiento']) ? $post_data['nacimiento'] : null,
		);
		return $insert_data;
	}
	**/



	public function makeInsertData($post_data){

		$active = isset($post_data['active']) ? $post_data['active'] : 0;
		$active = ($active == "1") ? 1 : 0;
		$snambre = isset($post_data['snombre']) ? $post_data['snombre'] : null;
		$sapellidos = isset($post_data['sapellidos']) ? $post_data['sapellidos'] : null;

		$insert_data = array();
		foreach ($this->fields as $field){
			if(isset($post_data[$field]) || isset($post_data[strtolower($field)])){
				if($field == 'FirstUpdate'
					|| $field == 'LastUpdate'){
					$insert_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[strtolower($field)]));
				}else{
					if($field == "Active"){
						$insert_data[$field] = $active;
					}else if($field == "sNombre"){
						$insert_data[$field] = $snambre;
					}else if($field == "sApellidos"){
						$insert_data[$field] = $sapellidos;
					}else if($field == "nombre"){
						$insert_data[$field] = $snambre." ".$sapellidos;
					}else{
						$insert_data[$field] = $post_data[strtolower($field)];
					}
				}
			}else{
				if($field == 'FirstUpdate'
					|| $field == 'LastUpdate'){
					$insert_data[$field] = date('Y-m-d H:i:s');
				}else{
					if($field == "nombre"){
						if($snambre || $sapellidos){
							$insert_data[$field] = trim($snambre." ".$sapellidos);
						}else{
							$insert_data[$field] = null;
						}
					}else{
						$insert_data[$field] = null;
					}
				}
			}
		}
		return $insert_data;
	}

	public function makeUpdateData($post_data){

		if(isset($post_data['snombre'])){
			$snambre = $post_data['snombre'];
		}
		if(isset($post_data['sapellidos'])){
			$sapellidos = $post_data['sapellidos'];
		}
		$update_data = array();
		foreach ($this->fields as $field){

			if(isset($post_data[$field]) || isset($post_data[strtolower($field)]) ){
				if($field == 'FirstUpdate'
					|| $field == 'LastUpdate'){
					$update_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[strtolower($field)]));
				}else{
					$update_data[$field] = $post_data[strtolower($field)];
				}
			}else{
				if($field == "nombre"){
					if(isset($snambre) && isset($sapellidos)){
						$update_data[$field] = trim($snambre." ".$sapellidos);
					}else if(isset($snambre) && !isset($sapellidos)){
						$update_data[$field] = trim($snambre);
					}else if(!isset($snambre) && isset($sapellidos)){
						$update_data[$field] = trim($sapellidos);
					}
				}
			}
		}
		return $update_data;
	}


	public function insertTeacher($insert_data){
		return $this->db->insert($this->table, $insert_data);
	}

	public function getAllTeachers(){
		$query = $this->db->select('INDICE AS id , CONCAT(sapellidos, " " , snombre) AS teacher_name')
				 ->from($this->table)
				// ->where(array('Activo' => 1))
				 ->order_by('2')
				 ->get();

		return $query->result();
	}

	public function getAllActiveTeachers(){
		$query = $this->db->select('TFO1 AS phone1,
									TFO2 AS phone2,
									movil AS mobile,
									activo AS active,
									Email AS email,
									Email2 AS email2,
									numss AS social_security,
									nacimiento AS birth_date,
									nombre AS full_name,
									sNombre AS first_name,
									sApellidos AS sur_name')
						  ->from($this->table)
						  ->where('Activo', '1')
						  ->get();

		return $query->result();
	}

	public function getStudentsTeachersByGroup($GROUP_ID){
		$query = "SELECT DISTINCT
				  al.ctfo1cli AS phone1,
				  al.ctfo2cli AS phone2,
				  al.movil AS mobile,
				  al.Email AS email,
				  al.Email2 AS email2,
				  al.tut1_email1, 
				  al.tut2_email1,
				  al.nacimiento AS birth_date,
				  CONCAT(al.sNombre, ' ', al.sApellidos) AS full_name,
				  al.sNombre AS first_name,
				  al.sApellidos AS sur_name
				FROM matriculal AS ml
				  JOIN matriculat AS mt ON ml.`NumMatricula` = mt.`NumMatricula`
				  JOIN alumnos AS al ON mt.`CCODCLI` = al.`CCODCLI`
				WHERE ml.`IdGrupo` = '".$GROUP_ID."' AND ml.`IdEstado`=0 AND mt.`Estado`=1 AND al.`Email` IS NOT NULL
				
				UNION

				SELECT DISTINCT TFO1 AS phone1,
                        TFO2 AS phone2,
                        movil AS mobile,
                        Email AS email,
                        Email2 AS email2,
                        nacimiento AS birth_date,
                        CONCAT(sNombre, ' ', sApellidos) AS full_name,
                        sNombre AS first_name,
                        sApellidos AS sur_name

					FROM profesor
					WHERE `INDICE` IN
						  (
							SELECT matriculal.idprofesor
							FROM matriculal JOIN matriculat ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
							  WHERE matriculal.`IdGrupo` = '".$GROUP_ID."' AND matriculal.`IdEstado`=0 AND matriculat.`Estado`=1
							UNION
							SELECT matriculal.`idprofesoraux`
							FROM matriculal JOIN matriculat ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
							WHERE matriculal.`IdGrupo` = '".$GROUP_ID."' AND matriculal.`IdEstado`=0 AND matriculat.`Estado`=1
							UNION
							SELECT matriculal.`idprofesoraux2`
						   FROM matriculal JOIN matriculat ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
							WHERE matriculal.`IdGrupo` = '".$GROUP_ID."' AND matriculal.`IdEstado`=0 AND matriculat.`Estado`=1
							UNION
							SELECT matriculal.`idprofesoraux3`
							FROM matriculal JOIN matriculat ON matriculal.`NumMatricula` = matriculat.`NumMatricula`
							WHERE matriculal.`IdGrupo` = '".$GROUP_ID."' AND matriculal.`IdEstado`=0 AND matriculat.`Estado`=1
						  )

					";

		return $this->selectCustom($query);
	}

	public function updateProfileSettings($user_id, $data){
		$this->db->where('INDICE', $user_id);
		return  $this->db->update($this->table, $data);
	}

}
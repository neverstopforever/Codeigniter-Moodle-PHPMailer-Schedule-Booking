<?php

class ManageMoodleModel extends MagaModel {

    public function __construct() {
        parent::__construct();
    }
	
	public function getTotalCount($table) {
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    function insertRecord($TableName,$Data){
		$this->db->insert($TableName, $Data); 
		return $this->db->insert_id();
	}
	
	function updateRecord($TableName,$Data,$WhereData=NULL){
		
		if($WhereData!=NULL){
			$this->db->where($WhereData);
		}
		$Result = $this->db->update($TableName,$Data);  
		return $Result;
	}
	
	function deleteRecord($TableName,$WhereData=""){
		
		$this->db->where($WhereData);
		$this->db->delete($TableName); 
		return 1;
	}

	function SelectRecord($TableName,$Selectdata,$WhereData,$orderby="",$groupby=""){
		
		$this->db->select($Selectdata);
		if(!empty($orderby)){
			$this->db->order_by($orderby);
		}
		if(!empty($WhereData)){
			$this->db->where($WhereData);
		}
		if(!empty($groupby)){
			$this->db->group_by($groupby);
		}
		$query = $this->db->get($TableName);
		//echo $this->db->last_query();
		return $query->row_array();
	}
	
	function SelectRecords($TableName,$Selectdata,$WhereData,$orderby="",$groupby=""){
		
		$this->db->select($Selectdata);
		if(!empty($orderby)){
			$this->db->order_by($orderby);
		}
		if(!empty($WhereData)){
			$this->db->where($WhereData);
		}
		if(!empty($groupby)){
			$this->db->group_by($groupby);
		}
		$query = $this->db->get($TableName);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	public function getCourse($course_id) {

		$field = "codigo AS courseid,
			curso AS brief_description,
			contenido AS full_description,
			idmoodle AS moodle_id";

		 $this->db->select($field, false);
		 $this->db->from('curso');		
		 $this->db->where('codigo', $course_id);	
		 $query = $this->db->get();
		 return $query->row_array();
    }
	
	public function getUserdetail($table,$user_id) {

		$fields = "id,Usuario as username,sapellidos AS firstname,snombre AS lastname,email,idmoodle";
		
		$this->db->select($fields, false);
		$this->db->from($table);			
		$this->db->like('id', $user_id);	
		
		$query = $this->db->get();
		return $query->row_array();	
    }
	
	public function getCoursesData($start, $length, $draw, $search, $order, $columns,$count) {

		if($count==""){ 
			$field = "codigo AS courseid,
			curso AS brief_description,
			contenido AS full_description,
			idmoodle AS moodle_id";
			$this->db->order_by(2, 'ASC');
			$this->db->limit($length, $start);	
		
		}else{
			$field = "codigo AS courseid";
		}
		 
		 $this->db->select($field, false);
		 $this->db->from('curso');			
		 
		 if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('codigo', $search['value']);
            $this->db->or_like('curso', $search['value']);
            $this->db->or_like('contenido', $search['value']);
            $this->db->or_like('idmoodle', $search['value']);
        }
		
		
        $query = $this->db->get();
		
		if($count==""){
			return $query->result();
		}else{
			return $query->num_rows();
		}

    }
	
	public function getUser($table,$start, $length, $draw, $search, $order, $columns,$count) {
		
		if($count==""){
			$fields = "Id,TRIM(CONCAT(sapellidos,', ',snombre)) AS name,email,idmoodle";
			$this->db->order_by(1, 'ASC');
			$this->db->limit($length, $start);	
			
		}else{
			$fields = "TRIM(CONCAT(sapellidos,', ',snombre)) AS name";
		}

		 $this->db->select($fields, false);
		 $this->db->from($table);			
		 
		 if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('sapellidos', $search['value']);
            $this->db->or_like('snombre', $search['value']);
            $this->db->or_like('email', $search['value']);
            $this->db->or_like('idmoodle', $search['value']);
        }
		 		
		
        $query = $this->db->get();
		
		if($count==""){
			return $query->result();
		}else{
			return $query->num_rows();
		}

    }
	
	public function getGroups123() {
		
		$insertData = array('rpc_server'=>'http://yashco.info/demo/neocrm','rpc_token'=>'1f27f3fef0eee9abba9d2509e916c8ba','rpc_user'=>'admin','rpc_pwd'=>'Yashco123');
		
		//$this->db->insert('sftconfig_moodle', $insertData);
		
        $query= "
				SELECT
					rpc_server,
					rpc_token,
					rpc_user,
					rpc_pwd
				FROM sftconfig_moodle";

        return $this->selectCustom($query);
    }

	public function getGroups() {
		
        $query= "
				SELECT
					codigogrupo AS group_id,
					descripcion AS group_name
				FROM grupos
				WHERE estado =1
				ORDER BY 2";

        return $this->selectCustom($query);
    }
	
	public function getCourses($GROUP_ID) {
		
		$Where = "";
		if(!empty($GROUP_ID)){
			$Where = " AND gl.CodigoGrupo = '".$GROUP_ID."'";
		}
		
        $query= "
				SELECT DISTINCT
					cu.codigo AS course_id,
					cu.curso AS course_name
					FROM
					gruposl AS gl
				LEFT JOIN curso AS cu ON gl.codigocurso = cu.codigo
				LEFT JOIN grupos AS gr ON gl.codigogrupo = gr.codigogrupo
				WHERE gr.estado = 1".$Where."
				ORDER BY 2";

        return $this->selectCustom($query);
    }
	
	public function getEnrollment($start, $length, $draw, $search, $order, $columns, $filter_tags,$count) {
		
		 if($count==""){
			 $fields = "ml.NumMatricula AS enroll_id,
					CONCAT(al.sApellidos,', ',al.snombre) AS student_name,
					al.email,
					al.id as student_id,
					ml.codigocurso as course_id,
					ml.idmoodle,
					DATE(mt.Inicio) AS start_date,
					DATE(mt.FinMatricula) AS end_date";
			$this->db->order_by(2, 'ASC');	
		 	$this->db->limit($length, $start);	// Add Limit when we not use count dataa
		 }else{
			  $fields = "DISTINCT ml.NumMatricula AS enroll_id";
		 }

		 $this->db->select($fields, false);
		 $this->db->from('matriculal AS ml ');		
		 $this->db->join('matriculat AS mt','ml.NumMatricula = ml.NumMatricula','left');
		 $this->db->join('alumnos AS al','mt.CCODCLI = al.CCODCLI','left');

		 
		 if(!empty($filter_tags['selected_courses'])){
			 $this->db->where('ml.codigocurso', $filter_tags['selected_courses']);
		}
		
		if($filter_tags['selected_groups']){
			$this->db->where('ml.IdGrupo', $filter_tags['selected_groups']);
			
		}
		 
		 if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('mt.NumMatricula', $search['value']);
            $this->db->or_like('al.sApellidos', $search['value']);
            $this->db->or_like('al.snombre', $search['value']);
            $this->db->or_like('al.idmoodle', $search['value']);
			$this->db->or_like('email', $search['value']);
        }
		 
		 $this->db->distinct();
        $query = $this->db->get();
		 if($count==""){
			// echo $this->db->last_query();
		 	return $query->result();
		 }else{
			return $query->num_rows();
		 }
		
    }
	
	
	
	
}
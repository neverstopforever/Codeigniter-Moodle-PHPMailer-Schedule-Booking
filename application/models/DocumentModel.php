<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/25/15
 * Time: 12:39 AM
 */
class DocumentModel extends MagaModel{
	
    public function __construct(){
        parent::__construct();
    }

    public function get_documents($idcliente){
        $query="SELECT
                id,
                fecha,
                IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
                doclink,
                IF(visible IS NULL OR visible = 0,'NO','SI') AS visible,
                IF(docblob IS NULL OR docblob = '',0,1) AS docblob,
                documento
                FROM
                clientes_doc
                WHERE idcliente = $idcliente";
        return $this->db->query($query)->result_array();
    }

    public function delete_documentos($documentId){
        $query="DELETE
                FROM
                clientes_doc
                WHERE id = $documentId";
        return $this->db->query($query);
    }

    public function insert_document($idcliente,$fecha,$nombre,$doclink,$visible=0){
        $query="INSERT INTO clientes_doc(fecha,nombre,doclink,visible,idcliente) VALUES ('".$fecha."','".$nombre."','".$doclink."',$visible,$idcliente)";
		$this->db->query($query);
		return $this->db->insert_id();
    }
    
	public function insert_document_lead($id,$fecha,$nombre,$documento, $doclink,$visible=0){
		$query="INSERT INTO presupuesto_doc
			(idpresupuesto,fecha,nombre,documento,doclink,visible)
			VALUES($id,'".$fecha."','".$nombre."','".$documento."','".$doclink."',$visible)";
		$this->db->query($query);
		return $this->db->insert_id();
	}
    
	public function download_file($id=null){
		$query="SELECT
                docblob,
                documento
                FROM
                clientes_doc
                WHERE id = $id";
        return $this->db->query($query)->result_array();
	}
	
	public function upload($id,$model){
		
	}
	
	public function get_profesor_document($id){
		$query = "SELECT 
			id,
			fecha, 
			fecha,
			IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
			doclink,
			IF(visible IS NULL OR visible = 0,'NO','SI') AS visible,
			IF(docblob IS NULL OR docblob = '',0,1) AS docblob,
			documento
			FROM profesor_doc 
			WHERE idprofesor = ".$id." ORDER BY fecha";
		return $this->db->query($query)->result_array();
	}

	public function insert_document_profesor($id,$fecha,$nombre,$documento, $doclink,$visible=0){
		$query="INSERT INTO profesor_doc
			(idprofesor,fecha,nombre,documento,doclink,visible)
			VALUES($id,'".$fecha."','".$nombre."','".$documento."','".$doclink."',$visible)";
		$this->db->query($query);
		return $this->db->insert_id();
	}
	
	public function profesor_download($id,$fid){
		$this->db->select("OCTET_LENGTH(docblob) AS 'blob', docblob, fecha, nombre AS titulo, documento,  doclink");
		$this->db->where('idprofesor', $id);
		$this->db->where('id', $fid);
		$query = $this->db->get('profesor_doc');
		return $query->row_array(); 
	}

	public function delete_profesor_documentos($documentId){
		//make one function and use switch case or use one table with extra colum for all file upload
		$query="DELETE
				FROM
				profesor_doc
				WHERE id = $documentId";
		return $this->db->query($query);
	}

	public function deleteDocumentByIdModel($documentId, $model, $table = false){

		if(!isset($documentId)){
			return false;
		}

		if($model == 'clients'){
			$table = 'clientes_doc';
		}else if($model == 'leads'){
			$table = 'presupuesto_doc';
		}else if($model == 'profesor'){
			$table = 'profesor_doc';
		}else if($model == 'student'){
			$table = 'alumnos_doc';
		}else if($model == 'group'){
			$table = 'grupos_doc';
		}else if($model == 'course'){
			$table = 'curso_doc';
		}else if($model == 'enrollment'){
			$table = 'matricula_doc';
		}

		if($table){
			return $this->delete($table, array('id'=>$documentId));
		}
		return false;
	}

	public function getDocLinkByIdModel($documentId, $model, $table = false){

		if(!isset($documentId)){
			return false;
		}

		if($model == 'clients'){
			$table = 'clientes_doc';
		}else if($model == 'leads'){
			$table = 'presupuesto_doc';
		}else if($model == 'profesor'){
			$table = 'profesor_doc';
		}else if($model == 'student'){
			$table = 'alumnos_doc';
		}else if($model == 'group'){
			$table = 'grupos_doc';
		}else if($model == 'course'){
			$table = 'curso_doc';
		}else if($model == 'enrollment'){
			$table = 'matricula_doc';
		}

		if($table){
			$query = $this->db->select('doclink')
							->from($table)
							->where('id', $documentId)
							->get();
			return $query->row();

		}else{
			return false;
		}

	}


	//Student

	public function get_student_document($student_id){
		$query = "SELECT *, IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
			doclink,
			IF(visible IS NULL OR visible = 0,'NO','SI') AS visible FROM alumnos_doc WHERE idalumno = ".$student_id;
		return $this->db->query($query)->result();
	}

	public function insert_document_student($id,$fecha,$nombre,$documento, $doclink,$visible=0){
		$query="INSERT INTO alumnos_doc
			(idalumno,fecha,nombre,documento,doclink,visible)
			VALUES($id,'".$fecha."','".$nombre."','".$documento."','".$doclink."',$visible)";
		$this->db->query($query);
		return $this->db->insert_id();
	}

	public function delete_student_documentos($documentId){
		$this->db->where('id', $documentId);
		return $this->db->delete('alumnos_doc');

	}

	public function student_download($id,$fid){
		$this->db->select("OCTET_LENGTH(docblob) AS 'blob', docblob, fecha, nombre AS titulo, documento,  doclink");
		$this->db->where('idalumno', $id);
		$this->db->where('id', $fid);
		$query = $this->db->get('alumnos_doc');
		return $query->row_array();
	}

	//Student

	public function get_enrollment_document($enroll_id){
		$query = "SELECT *, IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
			doclink,
			IF(visible IS NULL OR visible = 0,'NO','SI') AS visible FROM matricula_doc WHERE nummatricula = '".$enroll_id."'";
		return $this->db->query($query)->result();
	}

	public function insert_document_enrollment($id,$fecha,$nombre,$documento, $doclink,$visible=0){
		$query="INSERT INTO matricula_doc
			(nummatricula,fecha,nombre,documento,doclink,visible)
			VALUES($id,'".$fecha."','".$nombre."','".$documento."','".$doclink."',$visible)";
		$this->db->query($query);
		return $this->db->insert_id();
	}

	public function delete_enrollment_documentos($documentId){
		$this->db->where('id', $documentId);
		return $this->db->delete('matricula_doc');

	}

	public function enrollment_download($id,$fid){
		$this->db->select("OCTET_LENGTH(docblob) AS 'blob', docblob, fecha, nombre AS titulo, documento,  doclink");
		$this->db->where('nummatricula', $id);
		$this->db->where('id', $fid);
		$query = $this->db->get('matricula_doc');
		return $query->row_array();
	}

	//Group

	public function get_group_document($group_id){
		$query = "SELECT *, IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
			doclink,
			IF(visible IS NULL OR visible = 0,'NO','SI') AS visible FROM grupos_doc WHERE codigogrupo = ".$group_id;
		return $this->db->query($query)->result();
	}

	public function insert_document_group($id,$fecha,$nombre,$documento, $doclink,$visible=0){
		$query="INSERT INTO grupos_doc
			(codigogrupo,fecha,nombre,documento,doclink,visible)
			VALUES('".$id."','".$fecha."','".$nombre."','".$documento."','".$doclink."',$visible)";
		$this->db->query($query);
		return $this->db->insert_id();
	}

	public function insert_document_course($id,$fecha,$nombre,$documento, $doclink,$visible=0){
		$query="INSERT INTO curso_doc
			(codigocurso,fecha,nombre,documento,doclink,visible)
			VALUES('".$id."','".$fecha."','".$nombre."','".$documento."','".$doclink."',$visible)";
		$this->db->query($query);
		return $this->db->insert_id();
	}

	public function delete_group_documentos($documentId){
		$this->db->where('id', $documentId);
		return $this->db->delete('grupos_doc');

	}

	public function delete_course_documentos($documentId){
		$this->db->where('id', $documentId);
		return $this->db->delete('curso_doc');

	}

	public function group_download($id,$fid){
		$this->db->select("OCTET_LENGTH(docblob) AS 'blob', docblob, fecha, nombre AS titulo, documento,  doclink");
		$this->db->where('codigogrupo', $id);
		$this->db->where('id', $fid);
		$query = $this->db->get('grupos_doc');
		return $query->row_array();
	}


	public function deleteDocumentByIdClientId($documentId, $client_id){
		if(empty($documentId) || empty($client_id)){
			return false;
		}
		$this->db->where('id', $documentId);
		$this->db->where('idcliente', $client_id);
		return $this->db->delete('clientes_doc');
	}
}
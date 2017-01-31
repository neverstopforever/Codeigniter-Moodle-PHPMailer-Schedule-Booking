<?php
class LstInformesProfesorModel extends MagaModel {

	public function __construct() {
		parent::__construct();
		$this->table = "lst_informes_profesor";
	}
	
	public function getlist(){
		$this->db->select('id,titulo');
		$this->db->where('visible_campus', 1);
		$this->db->order_by('titulo','asc');
		$query = $this->db->get('lst_informes_profesor');
		return (array)$query->result_array();
		/*$list = array();
		foreach($data as $k=> $l){
			$list[$l['id']] = $l['titulo'];
		} 
		return $list;*/
	}
	
	public function report($id,$proId){
		$this->db->select('csql');
		$this->db->where('id', $id);
		$query = $this->db->get('lst_informes_profesor');
		$csql = (array)$query->row_array();
		$consulta = str_replace('@',$proId,$csql['csql']);
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
}
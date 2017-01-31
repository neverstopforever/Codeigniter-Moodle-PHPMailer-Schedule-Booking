<?php
class LstInformesGruposModel extends MagaModel {

	public function __construct() {
		parent::__construct();
		$this->table = "lst_informes_grupo";
	}
	
	public function getlist(){
		$this->db->select('id, titulo AS title, csql');
		//$this->db->where('visible_campus', 1);
		$this->db->order_by('titulo','asc');
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	public function report($id,$group_id){
		$this->db->select('csql');
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		$csql = (array)$query->row_array();
		$consulta = str_replace('@',$group_id,$csql['csql']);
		$result = $this->db->query($consulta);
		return $result->result();
	}
	
}
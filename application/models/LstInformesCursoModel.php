<?php
class LstInformesCursoModel extends MagaModel {

	public function __construct() {
		parent::__construct();
		$this->table = "lst_informes_curso";
	}
	
	public function getList(){
		$this->db->select('id, titulo AS title, sql');
		$this->db->order_by('titulo','asc');
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	public function report($id, $course_id){
		$this->db->select('sql');
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		$sql = (array)$query->row_array();
		$consulta = str_replace('@',"'".$course_id."'",$sql['sql']);
		$result = $this->db->query($consulta);
		return $result->result();
	}

	public function get_count() {
		$query = $this->db->select("COUNT(*) AS reports_count")
			->from($this->table)
			->get();
		return $query->row();
	}
	
}
<?php
class BlogModel extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}
	
	public function getallpost(){
		$query = "SELECT
				post_id,
				post_date,
				post_title,
				post_content,
				post_image,
				slug
				FROM usuarios_post
				ORDER BY post_date DESC
				;";
		return $this->magaModel->selectCustom($query);
	}
	
	public function getlist(){
		$query = "SELECT
				post_id,
				post_title
				FROM usuarios_post
				ORDER BY post_date DESC
				;";
		return $this->magaModel->selectCustom($query);
	}
	
	public function getpost($id){
		$query=$this->db->get_where('usuarios_post',array('post_id'=>$id));
		return $query->row_array();
	}
	
	public function insert_blog($data){
		$data['slug'] = $this->getUniqueUrl($data['slug'],'slug');
		return $this->db->insert('usuarios_post', $data);
	}
	
	public function update_blog($data,$id){
		$this->db->where('usuarios_post.post_id',$id);
		return $this->db->update('usuarios_post', $data);
	}
	
	public function delete_blog($id){
		$this->db->where('usuarios_post.post_id',$id);
		return $this->db->delete('usuarios_post');
	}
	
	function getUniqueUrl($string, $field) {
		$currentUrl = $this->_getStringAsURL($string);
		$this->db->like($field, $currentUrl, 'after');
		$query = $this->db->get('usuarios_post'); 
		$result = $query->result();
		if ($result !== false && count($result) > 0) {
			$sameUrls = array();
			foreach($result as $record) {
				if(strpos($record->$field, '.')) {
					$sameUrls[] = substr($record->$field, 0, strpos($record->$field, '.'));
				} else {
					$sameUrls[] = $record->$field;
				}
			}
		}
		if (isset($sameUrls) && count($sameUrls) > 0) {
			$currentBegginingUrl = $currentUrl;
			$currentIndex = 1;
			while($currentIndex > 0) {
				if (!in_array($currentBegginingUrl . '-' . $currentIndex, $sameUrls)) {
					$currentUrl = $currentBegginingUrl . '-' . $currentIndex;
					$currentIndex = -1;
				}
				$currentIndex++;
			}
		}
		return $currentUrl;
	}
	
	function _getStringAsURL($string){
		$currentMaximumURLLength = 100;
		$string = strtolower($string);
		$string = preg_replace('/[^a-z0-9_]/i', '-', $string);
		$string = preg_replace('/-[-]*/i', '-', $string);
		if (strlen($string) > $currentMaximumURLLength){
			$string = substr($string, 0, $currentMaximumURLLength);
		}
		$string = preg_replace('/-$/i', '', $string);
		$string = preg_replace('/^-/i', '', $string);
		return $string;
	}
}
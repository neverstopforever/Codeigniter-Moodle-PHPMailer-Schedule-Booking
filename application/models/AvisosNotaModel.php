<?php

class AvisosNotaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "avisos_notas";
    }

    public function getAvisosNotas($usuario = null, $tag_name = null) {

        if(!$usuario){
            return null;
        }
        $where = !empty($tag_name) && $tag_name != 'all' ? ' AND  en.descripcion = "'.$tag_name.'"' : '';
        $query="SELECT
				  an.id,
				  an.inicio AS start_date,
				  an.fin AS end_date,
				  an.etiqueta AS id_label,
				  an.titulo AS title,
				  an.mensaje AS content,
				  an.activo AS status,
				  an.publico AS public,
				  us.USUARIO AS USUARIO,
				  us.photo_link,
				  an.idusuario AS user_id,

				  CASE
				    an.prioridad
				    WHEN 1
				    THEN 'Normal'
				    WHEN 2
				    THEN 'Alta'
				    WHEN 3
				    THEN 'Muy Alta'
				  END AS Priority,
				  an.activo AS Active,
				  an.completada AS finished,
				  en.descripcion AS labeltask,
				  HEX(en.color) AS labelcolor
				FROM
				  avisos_notas AS an
				LEFT JOIN usuarios AS us
				   ON an.idusuario= us.id
				LEFT JOIN etiquetas_notas AS en
				   ON an.etiqueta = en.id
				WHERE (us.usuario = '".$usuario."' OR an.publico = '1')
				$where
				ORDER BY `inicio` desc
				";

        return $this->selectCustom($query);
    }

    public function getUndoneTasksCount($usuario = null) {

        if(!$usuario){
            return null;
        }

        $query="
				SELECT
				COUNT(*) num
				FROM
				avisos_notas
				WHERE activo = 1
				AND completada = 0
				AND idusuario = ".$usuario.";
  				";
        return $this->selectCustom($query);
    }

    public function getTaksDataById($id){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('id', $id)
                          ->get();

        return $query->row();
    }

    public function deleteTasks($id, $user_id = null){
         $this->db->delete($this->table, array('id' => $id, 'idusuario' => $user_id));
        if($this->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

    public function updateItem($update_data, $where){
        $this->db->update($this->table, $update_data, $where);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}
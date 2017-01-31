<?php
class TaskModel extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}
	
	public function dashboard_task(){
		$userData=$this->session->userdata('userData');
		$usuario=$userData[0]->USUARIO;
		$query="SELECT
				  an.id,
				  an.inicio AS start_date,
				  an.fin AS end_date,
				  an.etiqueta AS id_label,
				  an.titulo AS title,
				  an.mensaje AS content,
				  an.publico AS public,
				  us.USUARIO AS USUARIO,

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
				WHERE us.usuario = '".$usuario."' OR an.publico = '1'
				ORDER BY `inicio` desc limit 8";
		return $this->magaModel->selectCustom($query);
	}
}
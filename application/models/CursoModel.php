<?php


class CursoModel extends MagaModel
{
    public $fields = array(
        'IdColor',
        'estado', //active by default
        'codigo',
        'CURSO',
        'HORAS',
        'Creditos',
        'CONTENIDO',
        'PRECIO',
        'TIPO',
    );
    public function __construct()
    {
        parent::__construct();
        $this->table = 'curso';
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function get_fields() {
        return $this->db->list_fields($this->table);
    }

    public function getForSelect() {

        $query = 'SELECT codigo as id,
                          curso as text,
                          estado
                        FROM curso
                        WHERE estado = 0
                        ORDER BY 2
                        ';

        return $this->selectCustom($query);
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
    public function getAllCourses(){
        $query = $this->db->select('codigo AS id , CONCAT(codigo, "|" , curso) AS courseName')
                          ->from($this->table)
                          ->order_by('2')
                          ->get();
        return $query->result();
    }

    public function getCourseById($course_id){
        if(!$course_id){
            return null;
        }
        $query = $this->db->select("co.codigo, co.`curso`, co.`horas`, co.`precio`,
                                   co.`idprofesor`, co.`idaula`, co.`tipo`, co.`idmodalidadtipologia`,
                                   CONCAT(sapellidos,', ',snombre) AS teacher, au.`Nombre` AS classroom"
                               )
            ->from($this->table.' AS  co')
            ->join('profesor AS pf', 'pf.INDICE=co.idprofesor', 'left')
            ->join('aulas AS au', 'co.idaula=au.IdAula', 'left')
            ->where('co.codigo', $course_id)
            ->get();

        return $query->row();
    }

    public function getNotExistCourses($ids){
        $array_ids = array();
        if(!empty($ids)){
            $array_ids = explode('|', $ids);
        }

         $this->db->select('codigo AS id , CONCAT(codigo, " | " , curso) AS courseName')
            ->from($this->table);
        if(!empty($array_ids)) {
            $this->db->where_not_in('codigo', $array_ids);
        }

        $query = $this->db ->order_by('2')
                            ->get();
        return $query->result();
    }


    public function get_courses(){

        $query = "SELECT cu.codigo AS course_id, cu.curso AS course_name, cu.horas AS hours, cu.creditos AS credits, cu.estado AS state,
                (SELECT COUNT(DISTINCT gruposl.codigogrupo) FROM gruposl LEFT JOIN grupos ON gruposl.`CodigoGrupo` = grupos.`codigogrupo` WHERE grupos.`Estado` = 1 AND gruposl.codigocurso = cu.codigo) AS active_groups,
                (SELECT COUNT(DISTINCT matriculat.ccodcli) FROM matriculal INNER JOIN matriculat ON matriculal.nummatricula = matriculat.nummatricula WHERE matriculal.codigocurso = cu.codigo AND matriculat.`Estado`=1) AS active_students
                FROM curso AS cu
                ORDER BY 2;";

        return $this->selectCustom($query);
    }


    public function getById($course_id = null){
        if(!$course_id){
            return null;
        }
        $query = "SELECT cu.codigo AS course_id, cu.curso AS course_name,cu.custom_fields AS custom_fields, cu.horas AS hours, cu.creditos AS credits, cu.estado AS state, HEX(cu.IdColor) as color, cu.contenido as course_description, 
                           (SELECT COUNT(DISTINCT codigogrupo) FROM gruposl WHERE codigocurso = cu.codigo AND estado=1) AS active_groups,
                           (SELECT COUNT(DISTINCT ccodcli) FROM matriculal LEFT JOIN matriculat ON matriculal.nummatricula = matriculat.nummatricula
                           WHERE matriculal.codigocurso = cu.codigo AND estado=0) AS active_students
                    FROM curso AS cu
                    WHERE cu.codigo = '".$course_id."'
                    ORDER BY 2;";

        return $this->selectCustom($query);
    }

    public function check_course($course_id = null){

        if(empty($course_id)){
            return false;
        }

        $query = "SELECT COUNT(*) as check_count FROM curso
                    WHERE codigo IN
                    
                    (SELECT ccurso FROM agenda
                    UNION
                    SELECT ccurso FROM agendagrupos
                    UNION
                    SELECT codigocurso FROM gruposl
                    UNION
                    SELECT codigocurso FROM matriculal
                    ) 
                    AND codigo = '".$course_id."'
                    ;";

        return $this->selectCustom($query);
    }

    public function deleteItem($course_id = null){

        if(empty($course_id)){
            return false;
        }

        return $this->delete($this->table, array('codigo'=>$course_id));
    }


    public function updateItem($course_id = null, $data = array()){

        if(empty($course_id) || empty($data)){
            return false;
        }

        return $this->update($this->table, $data, array('codigo'=>$course_id));
    }


    public function insertItem($data = array()){

        if(empty($data)){
            return false;
        }

        return $this->db->insert($this->table, $data);
    }

    public function getCoursesForSchedule(){
        $query = "SELECT DISTINCT 
                      cu.codigo AS course_id,
                      cu.curso AS course_name,
                      HEX(cu.idcolor) color 
                    FROM
                      curso AS cu 
                      LEFT JOIN agenda AS ag 
                        ON cu.codigo = ag.ccurso 
                    WHERE cu.codigo IS NOT NULL 
                      AND cu.estado = 0 
                      AND cu.tipo <> 4 
                      AND (
                        (SELECT 
                          COUNT(*) 
                        FROM
                          agendagrupos 
                        WHERE ccurso = cu.codigo) > 0
                      ) 
                    ORDER BY 2 
                    ;";
        return $this->selectCustom($query);
    }

    public function getCourseForFilter(){
        $query = "SELECT codigo AS id, curso as text
                    FROM curso
                    ORDER BY 2";
        return $this->selectCustom($query);
    }

    public function makeInsertData($post_data){
        if(isset($post_data['color'])){
            $color = trim($post_data['color'], '#');
            $color = hexdec($color);
        }else{
            $color = 0;
        }
        $insert_data = array();
        foreach ($this->fields as $field){
            if(isset($post_data[$field]) || isset($post_data[strtolower($field)])){
                $insert_data[$field] = $post_data[strtolower($field)];
            }else{
                $insert_data[$field] = null;
            }
        }
        $insert_data['estado'] = 1; //active by default
        $insert_data['IdColor'] = $color;
        return $insert_data;
    }

    public function makeUpdateData($post_data){

        if(isset($post_data['color'])){
            $color = trim($post_data['color'], '#');
            $color = hexdec($color);
        }
        $update_data = array();
        foreach ($this->fields as $field){
            if(isset($post_data[$field]) || isset($post_data[strtolower($field)]) ){
                $update_data[$field] = $post_data[strtolower($field)];
            }
        }
        if(isset($color)){
            $update_data['IdColor'] = $color;
        }
        return $update_data;
    }

    public function getAll($selectParams = '', $where = array()) {
        return  $this->selectAll($this->table, $selectParams, $where);
    }
}
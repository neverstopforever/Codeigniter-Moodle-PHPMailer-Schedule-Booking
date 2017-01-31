<?php

class MagaModel extends CI_Model {

    protected $_db;
    protected $_db_name;
    protected $table;

    function __construct() {
        parent::__construct();
    }

    function varifyLogin($table, $data) {
        $this->db->from($table);
        $this->db->where($data);
        $result = $this->db->get();
        return $result->result();
    }

    function selectAll($table, $selectParams = '', $where = null) {
        if ($selectParams != '') {
            $this->db->select($selectParams);
        }
        $this->db->from($table);
        if(!empty($where)){
            $this->db->where($where);
        }
        $result = $this->db->get();
        return $result->result();
    }

    function selectAllWithFields($table, $selectParams = '') {
        if ($selectParams != '') {
            $this->db->select($selectParams);
        }
        $this->db->from($table);
        $result = $this->db->get();
        $fields = $result->field_data();
        return array('result' => $result->result(), 'fields' => $fields);
    }

    function selectAllWithFieldsCustom($table, $selectParams = '*') {
        $query = 'SELECT '. $selectParams .' FROM  `'.$table.'` ';
        $result = $this->db->query($query);
        $fields = $result->field_data();
        return array('result' => $result->result(), 'fields' => $fields);
    }

    public function customInsert($table, $data = null){
        $fields = '';
        $values = '';
        if(!empty($data)){
            foreach($data as $k=>$value){
                $fields .= $k.',';
                $values .= "'".$value."',";
            }
        }
        $tr_fields = trim($fields, ",");
        $tr_values = trim($values, ",");
        $query = "INSERT INTO `".$table ."` (". $tr_fields .")
                         VALUES (". $tr_values .")";
        $result = $this->db->query($query);
        return  $result;
    }

    public function customUpdate($table, $data = null, $id = null){
        $str_set = '';
        if(!empty($data)){
            foreach($data as $k=>$value){
                $str_set .= $k."='". $value ."',";
            }
        }
        $str_set = trim($str_set, ",");
        $query = "UPDATE `". $table ."` SET ". $str_set ." WHERE ".$id;
        $result = $this->db->query($query);
        return  $result;
    }

    public function customDelete($table, $id = null){
        $result = false;
        if($id) {
            $query = "DELETE FROM `" . $table . "` WHERE ".$id;
            $result = $this->db->query($query);
        }
        return  $result;
    }

    function selectAllWhere($table, $params) {
        $this->db->from($table);
        $this->db->where($params);
        $result = $this->db->get();
        return $result->result();
    }

    function selectCustom($query) {
        $query = $this->db->query($query);
        //$result=$this->db->get();   
        return $query->result();
    }
    
    function runQuery($query){
        $query = $this->db->query($query);
        //$result=$this->db->get();   
        return $query->row();
    }

    function selectOne($table, $params, $selectParams = '') {
        if ($selectParams != '') {
            $this->db->select($selectParams);
        }
        $this->db->from($table);
        $this->db->where($params);
        $this->db->limit(1);
        $result = $this->db->get();
        return $result->result();
    }

    function update($table, $data, $where) {
        $this->db->where($where);
        $result = $this->db->update($table, $data);
        return $result;
    }

    function delete($table, $where) {
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    function selectComments($table, $params) {
        $this->db->select('comentarios_de_tareas.*,usuarios.Id as idusuario,usuarios.USUARIO, usuarios.Nombre AS  user_name, usuarios.photo_link');
        $this->db->from($table);
        $this->db->where($params);
        $this->db->join('usuarios', 'comentarios_de_tareas.idusuario = usuarios.Id', 'LEFT');
        $result = $this->db->get();
        // print_r($result-db->queries);
        return $result->result();
    }

    function insert($table, $data) {
        $result = $this->db->insert($table, $data);
        // return  $this->selectOne($table,array('id'=>$this->db->insert_id()));
        return $this->db->insert_id();
    }

    function updateCustom($query) {
        return $this->db->query($query);
    }


    public function custom_sql($sql){
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    function insertCustom($query) {
        $result = $this->db->query($query);
        return $this->db->insert_id();
    }

    function deleteCustom($query) {
        $result = $this->db->query($query);
        return $this->db->result();
    }

    function selectTags($table) {
        $this->db->select('hex(color) as color,descripcion as tagName');
        $this->db->from($table);
        $result = $this->db->get();
        return $result->result();
    }

    function recordExist($table, $params) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($params);
        $result = $this->db->get();
        return $result->num_rows();
    }

    public function maxID($table, $primary_key) {
        $this->db->select_max($primary_key);
        $this->db->from($table);
        $result = $this->db->get();
        return $result->result();
    }

    public function deleteClientes($id) {
        $this->db->where('Id', $id);
        $query1 = "DELETE FROM clientes where ccodcli = $id";
        $query2 = "DELETE FROM clientes_tab_ad where ccodcli = $id";
        $query3 = "DELETE FROM clientes_doc where idcliente = $id";
        $result = $this->db->query($query1);
        if($result) {
            $this->db->query($query2);
            $this->db->query($query3);
            return true;
        }else{
            return false;
        }
    }
    
    function get_details_leads($id){
        //$this->db->select('comentarios_de_tareas.*,usuarios.Id as idusuario,usuarios.USUARIO');
        $this->db->from('presupuestot');
        $this->db->where('presupuestot.NumPresupuesto',$id);
        $this->db->join('medios', 'medios.IdMedio = presupuestot.medio', 'LEFT');
//        $this->db->join('campañas', 'campañas.IdCampaña = presupuestot.Campaña', 'LEFT');
        $result = $this->db->get();
        return $result->result();
    }
    function get_where($table,$where){
        $query = $this->db->get_where($table,$where);
        return $query->result();
        
    }
    function updatedata($data){
       $query = $this->db->get_where('presupuestos_tab_ad',array('NumPresupuesto'=>$data['id'])); 

       if($query->num_rows() > 0){
        $this->db->where('NumPresupuesto',$data['id']);
        $updatedata['Asesor']=$data['Asesor'];
        $updatedata['comentarios']=$data['comentarios'];
        $this->db->update('presupuestos_tab_ad', $updatedata);   
       }else{
           $insertdata['NumPresupuesto']=$data['id'];
        $insertdata['Asesor']=$data['Asesor'];
        $insertdata['comentarios']=$data['comentarios'];
        $this->db->insert('presupuestos_tab_ad', $insertdata);   
       }
       return TRUE;
    }

    public function getAutomatedEmailBodyKays(){
        return array(
            'FIRSTNAME',
            'SURNAME',
            'FULLNAME',
            'PHONE1',
            'PHONE2',
            'MOBILE',
            'EMAIL1',
            'EMAIL2',
            'USERNAME',
            'COURSE_NAME',
            'GROUP',
            'START_DATE',
            'END_DATE'
        );
    }

    public function CustomQuery($query)
    {
        $result = $this->db->query($query);
        if (count($result->result_array()) > 0)
        {
            return $result->result_array();
        }
        return array();
    }

    public function findById($id)
    {
        return $this->findOne(array('id'=>$id));
    }

    public function findOne($where, $order_field = "", $order = "asc")
    {
        if(isset($where['or_where'])){
            $or_where = $where['or_where'];
            unset($where['or_where']);
        }
        $this->db->from($this->table);
        $this->db->where($where);
        if(isset($or_where) && !empty($where)){
            $this->db->or_where($or_where);
        }
        if(!empty($order_field)){
            $this->db->order_by($order_field, $order);
        }
        $this->db->limit(1);
        $r = $this->db->get();
        $v = $r->row();
        return $v;
    }

    public function findAll($where = array())
    {
        if(isset($where['or_where'])){
            $or_where = $where['or_where'];
            unset($where['or_where']);
        }
        $this->db->from($this->table);
        $this->db->where($where);
        if(isset($or_where) && !empty($where)){
            $this->db->or_where($or_where);
        }
        $r = $this->db->get();
        return $r->result_object();
    }
    
    

}

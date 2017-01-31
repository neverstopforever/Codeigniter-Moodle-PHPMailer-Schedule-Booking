<?php

class ApiPortalesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "api_portales";
    }

    public function getSourceState() {

        $query = "SELECT ap.`id`, IF(ap.`title` IS NULL,po.portal,ap.title) AS title, ap.`activo` AS `active` , ap.apikey
                FROM api_portales AS ap
                LEFT JOIN portales AS po ON ap.`idportal` = po.`idportal`
                ORDER BY 2
                ";

        return  $this->selectCustom($query);
    }
    
    public function getNotExistMedios($where = array(), $where_or = array()) {
        $where_str = '';
        $where_or_str = '';
        if(!empty($where)){
            foreach($where as $key=>$val){
                $where_str .= ' AND '.$key.'='.'"'.$val.'"';
            }
        }
        if(!empty($where_or)){
            foreach($where_or as $key=>$val){
                $where_or_str .= ' OR '.$key.'='.'"'.$val.'"';
            }
        }
        $query = "SELECT * FROM medios WHERE IdMedio NOT IN (SELECT idmedio FROM api_portales) $where_str  $where_or_str;";
        return  $this->selectCustom($query);
    }

    public function getNotExistTypeOfSource($where = array(), $where_or = array()){
        $where_str = '';
        $where_or_str = '';
        if(!empty($where)){
            foreach($where as $key=>$val){
                $where_str .= ' AND '.$key.'='.'"'.$val.'"';
            }
        }
        if(!empty($where_or)){
            foreach($where_or as $key=>$val){
                $where_or_str .= ' OR '.$key.'='.'"'.$val.'"';
            }
        }
        $query = "SELECT portal AS portal_name, idportal AS portal_id
                FROM portales
        WHERE idportal NOT IN
                (SELECT idportal FROM api_portales) $where_str $where_or_str";
        return  $this->selectCustom($query);
    }

    public function getTypeOfSource(){
        $this->db->select("portal AS portal_name, idportal AS portal_id");
        $this->db->from('portales');
        $this->db->order_by(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateSource($state = null, $id = null) {

        if($state == null || !$id){
            return false;
        }
//        $query = "UPDATE ".$this->table." SET `activo` = '$state' WHERE `id` = '$id';";
        $data_array = array('activo'=>$state);
        $this->db->where(array('id'=>$id));
        return $this->db->update($this->table, $data_array);
    }

    public function insertData($insert_data){
        return $this->insert($this->table, $insert_data);
    }

    public function updateItem($update_data, $where = array()){
        return $this->update($this->table, $update_data, $where);
    }

    public function deleteItem($source_id){
        return $this->delete($this->table, array('id' => $source_id));
    }

    public function getSourceBiId($source_id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $source_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getSources(){
        $query = "
            SELECT ap.`id`,
  IF(
      ap.`title` IS NULL,
      po.portal,
      ap.title
  ) AS title,
  ap.`idportal` as idportal,
  ap.`activo` AS `active`,
  ap.apikey FROM api_portales AS ap
  LEFT JOIN portales AS po
    ON ap.`idportal` = po.`idportal`
  where ap.`activo` = 1
ORDER BY 2;";
        $res = $this->db->query($query);
        return $res->result();

    }

}
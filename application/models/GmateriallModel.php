<?php

class GmateriallModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "gmateriall";
    }

    public function getByGroupId($id, $book_id = null){
        $where = array(
            'codigogrupo' => $id
        );
        if($book_id){
            $where['codigomaterial'] = $book_id;
        }
       $query = $this->db->select('codigomaterial AS book_id,
                                    descripcion AS title,
                                    fechaprevista AS `delivery_date`
                                    ')
                         ->from($this->table)
                         ->where($where)
                         ->order_by('2')
                         ->get();
        return $query->result();
    }

    public function insertBookData($group_id, $book_id, $title){
        $query = "INSERT INTO gmateriall
        (`codigogrupo`,`codigomaterial`,`fechaprevista`, `FechaEntrega`, `Descripcion`, `unidades` )
        VALUES
        ('".$group_id."', '".$book_id."',CURDATE(), CURDATE(), '".$title."', '1')
        ";
       return $this->insertCustom($query);
    }

    public function deleteBook($group_id, $book_id){
       return $this->delete($this->table,array('codigogrupo' => $group_id, 'codigomaterial' => $book_id));
    }


}
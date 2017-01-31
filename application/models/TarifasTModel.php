<?php


class TarifasTModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tarifas_t';
    }


    public function getRates(){
        $query = $this->db->select('`id`,
                                    `nombre` AS `name`')
                          ->from($this->table)
                          ->order_by(2)
                          ->get();

        return $query->result();
    }

    public function insertRate($rate_name){
        return $this->insert($this->table, array('nombre' => $rate_name));
    }

    public function updateRate($rate_id, $rate_name){
        $query = $this->db->where('id', $rate_id)
                          ->update($this->table, array('nombre' => $rate_name));

        return $query;
    }

    public function deleteRate($id){
       return $this->delete($this->table, array('id' => $id));
    }


}
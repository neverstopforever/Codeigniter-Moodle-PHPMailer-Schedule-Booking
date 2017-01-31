<?php


class TarifasLModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tarifas_l';
    }


    public function getFees($rate_id = null, $fee_id = null){
         $this->db->select('id,
                            fecha_vto AS `payment_date`,
                            concepto AS `subject`,
                            neto AS `amount`,
                            porcentaje_impuesto AS `fees`,
                            impuesto AS `total_fees`,
                            importe AS `total_amount` ')
                          ->from($this->table);
        if(!empty($rate_id)) {
            $this->db->where('idtarifa', $rate_id);
        }
        if(!empty($fee_id)) {
            $this->db->where('id', $fee_id);
        }
        $query = $this->db->order_by(2)
                 ->get();

        return $query->result();
    }

    public function deleteFees($ids){
        $query = $this->db->where_in('id', $ids)
                          ->delete($this->table);
        return $query;
    }

    public function insertFee($insert_data){
        return $this->insert($this->table, $insert_data);
    }
    public function insertFeeBatch($insert_data){
        $count_rows = $this->db->insert_batch($this->table, $insert_data);
        $first_id = $first_id = $this->db->insert_id();
        return (object)array('count_rows' => $count_rows, 'first_id' => $first_id);
    }

    public function updateFee($update_data, $where){
      return  $this->update($this->table, $update_data, $where);
    }
}
<?php


class SftConfigEgoiModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'sftconfig_egoi';
    }

   public function getEgoiData(){
       $query = $this->db->select('*')
                         ->from($this->table)
                         ->limit(1)
                         ->get();
       return $query->row();
   }

    public function updateEgoiData($update_data){
        return $this->db->update($this->table, $update_data);
    }

    public function insertData($insert_data){
        return $this->db->insert($this->table, $insert_data);
    }
    public function deleteItem(){
               $this->db->where('id !=', null);
        return $this->db->delete($this->table);
    }

}
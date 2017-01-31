<?php
class ErpFileSizesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_file_sizes";
    }
    

    public function add($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function deleteItem($aws_link){
        return $this->db->delete($this->table, array('aws_link' => $aws_link));
    }

    public function getTotalSize(){
        $query = $this->db->select('IFNULL(SUM(file_size), 0) AS total')
                          ->from($this->table)
                          ->get();

        return $query->row();
    }

}

?>
<?php
/**
 *@property InvoiceModel $InvoiceModel
 */
class ClientesAkaudFollowupModel extends MagaModel {


    
    public function __construct() {
        parent::__construct();
        $this->table = "clientes_akaud_followup"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    public function getByid($id = null) {
        if(!$id){
            return null;
        }
        $query = $this->_db->select('*')
                          ->from($this->table)
                          ->where('id', $id)
                          ->get();

        return $query->row();
    }

    public function getByIdCliente($idcliente = null) {
        if(!$idcliente){
            return null;
        }
        $query = $this->_db->select('*')
            ->from($this->table)
            ->where('ccodcli', $idcliente)
            ->get();

        return $query->result();
    }

    public function insertData($insert_data){
        return $this->insert($this->table, $insert_data);
    }

    public function updateFollowData($dataArray, $where){
        $this->_db->where($where);
        $this->_db->update($this->table, $dataArray);
        if ($this->_db->affected_rows() > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function deleteFollowUp($where){
        $this->_db->delete($this->table, $where);
        if ($this->_db->affected_rows() > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}
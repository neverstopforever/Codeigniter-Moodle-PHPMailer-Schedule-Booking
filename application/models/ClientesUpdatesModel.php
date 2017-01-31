<?php
/**
 *@property
 */
class ClientesUpdatesModel extends MagaModel {


    /**
     * @var bigint
     */
    public $version;
    
    /**
     * @var longtext
     */
    public $csql;
    

    
    public function __construct() {
        parent::__construct();
        $this->table = "clientes_updates";
        $this->_db_name = "admin_akaud";
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    public function getUpdateByVersion($version_akaud){
        $query = $this->_db->select('*')
                           ->from($this->table)
                           ->where('version > '.$version_akaud)
                           ->get();

        return  $query->result();
    }

}
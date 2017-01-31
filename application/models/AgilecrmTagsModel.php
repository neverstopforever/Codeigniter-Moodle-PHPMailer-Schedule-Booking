<?php
/**
 *@property InvoiceModel $InvoiceModel
 */
class AgilecrmTagsModel extends MagaModel {


    
    public function __construct() {
        parent::__construct();
        $this->table = "agile_tags"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    public function getNotExistTags($tags = array()) {
        if(!$tags){
            return null;
        }
        $query = $this->_db->select('id, tag_name AS text')
                          ->from($this->table)
                          ->where_not_in('tag_name', $tags)
                          ->get();
        return $query->result();
    }
    public function getTagsByIds($tags = array()) {
        if(!$tags){
            return null;
        }
        $query = $this->_db->select('tag_name')
                          ->from($this->table)
                          ->where_in('id', $tags)
                          ->get();
        return $query->result();
    }

}
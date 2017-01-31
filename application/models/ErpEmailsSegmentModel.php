<?php

class ErpEmailsSegmentModel extends MagaModel {

    public $id;
    public $title;
    public $csql;
    public $items_count_csql;

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_segments";
    }
    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function  getAll(){
        return $this->selectAll($this->table);
    }
}
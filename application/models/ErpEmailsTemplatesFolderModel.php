<?php

class ErpEmailsTemplatesFolderModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_templates_folder";
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getFoldersWithTemplatesCounts(){
        $query = "SELECT erp_emails_templates_folder.id_folder, erp_emails_templates_folder.title, COUNT(erp_emails_templates.id_folder) AS templates_count
                    FROM ".$this->table."
                      LEFT JOIN erp_emails_templates USING(id_folder)
                    GROUP BY erp_emails_templates_folder.id_folder
                    ORDER BY `templates_count` DESC;";

        return $this->selectCustom($query);
    }
    public function getFolders(){
        $query = "SELECT * FROM ".$this->table."
                        ORDER BY 1 DESC";

        return $this->selectCustom($query);
    }

    public function getFolderByTitle($title = null){

        if (!$title) {
            return false;
        }

        $this->db->from($this->table);
        $this->db->where('title', $title);
        $query = $this->db->get();
        return $query->result();
    }
    public function insertFolder($title = null){

        if (!$title) {
            return false;
        }
        $data = array(
            'title'=>$title
        );
        return $this->insert($this->table, $data);
    }

    public function chnageFolderName($folder_id, $folder_name){
        return $this->update($this->table, array('title' => $folder_name), array('id_folder' => $folder_id));
    }

    public function deleteFolder($folder_id){
        return $this->delete($this->table, array('id_folder' => $folder_id));
    }
}
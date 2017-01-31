<?php

class ErpEmailsCampaignFolderModel extends MagaModel {

    public $id_folder;
    public $title;

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_campaign_folder";
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getFoldersWithCampaignCounts(){
        $query = "SELECT erp_emails_campaign_folder.id_folder, erp_emails_campaign_folder.title, COUNT(erp_emails_campaign.id_folder) AS campaign_count
                    FROM ".$this->table."
                      LEFT JOIN erp_emails_campaign USING(id_folder)
                    GROUP BY erp_emails_campaign_folder.id_folder
                    ORDER BY `campaign_count` DESC;";

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
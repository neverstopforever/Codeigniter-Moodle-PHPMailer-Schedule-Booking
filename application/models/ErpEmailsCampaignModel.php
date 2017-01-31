<?php

class ErpEmailsCampaignModel extends MagaModel {

    public $id;
    public $title;
    public $Subject;
    public $id_folder;
    public $date_creation;
    public $date_sending;
    public $user_id;
    public $state; //0‐paused, 1‐scheduled, 2‐sent

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_campaign";
    }

    public function addCampaign($data = null) {

        if(empty($data) || !isset($data['title']) || empty($data['title'])
            || !isset($data['Subject']) || empty($data['Subject'])
            || !isset($data['id_folder']) || empty($data['id_folder'])
            || !isset($data['Body']) || empty($data['Body'])
            || !isset($data['state']) || empty($data['state'])
            || !isset($data['date_sending']) || empty($data['date_sending'])
        ){

            return false;
        }
        $data['date_sending'] = date('Y-m-d',strtotime($data['date_sending']));
        $data['date_creation'] = date('Y-m-d H:i:s');

        return $this->insert($this->table, $data);

    }

    public function editCampaign($campaign_id, $data = null) {

        if(empty($campaign_id) || !is_numeric($campaign_id) || empty($data)
            || !isset($data['title']) || empty($data['title'])
            || !isset($data['Subject']) || empty($data['Subject'])
            || !isset($data['id_folder']) || empty($data['id_folder'])
            || !isset($data['Body']) || empty($data['Body'])
            || !isset($data['state'])
            || !isset($data['date_sending']) || empty($data['date_sending'])
        ){
            return false;
        }
        $data['date_sending'] = date('Y-m-d', strtotime($data['date_sending']));

        return $this->update($this->table, $data, array('id'=>$campaign_id));

    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function bulk_delete($campaign_ids) {
//        $campaign_ids = array(1,2,...) like this
        if(is_array($campaign_ids)){
            $campaign_ids_filtered = array_filter($campaign_ids, 'is_numeric');
            if (!empty($campaign_ids_filtered)) {
                $this->db->where_in('id', $campaign_ids);
                $this->db->where('state !=', 2);
                $this->db->delete($this->table);
                return $this->db->affected_rows();
            }
        }
        return false;
    }

    public function getCampaignsByAjax($start, $length, $draw, $search, $order, $columns = '') {

        $this->db->select('erp_emails_campaign.*, erp_emails_campaign_folder.title as folder_name')
            ->from('erp_emails_campaign')
            ->join('erp_emails_campaign_folder','erp_emails_campaign_folder.id_folder = erp_emails_campaign.id_folder', 'left');


        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('erp_emails_campaign.title', $search['value']);
            $this->db->or_like('erp_emails_campaign.Subject', $search['value']);
            $this->db->or_like('erp_emails_campaign_folder.title', $search['value']);
        }

        if(isset($columns[0]['search']['value']) && is_numeric($columns[0]['search']['value'])){
            $this->db->where('erp_emails_campaign.id_folder', $columns[0]['search']['value']);
        }

        $this->db->distinct();

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = "erp_emails_campaign.id";
                    break;
                case 2:
                    $column = "erp_emails_campaign.title";
                    break;
                case 3:
                    $column = "erp_emails_campaign.Subject";
                    break;
                case 4:
                    $column = "folder_name";
                    break;
                default:
                    $column = "erp_emails_campaign.title";
            }
            $this->db->order_by($column, $column_dir);
        }

        $query = $this->db->get('', $length, $start);

        return $query->result_object();

    }

    public function getById($campaign_id){
        if(!$campaign_id || !is_numeric($campaign_id)){
            return false;
        }
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $campaign_id);
        $query = $this->db->get();

        return $query->result_object();
    }

    public function deleteItem($campaign_id){
        if(!$campaign_id || !is_numeric($campaign_id)){
            return false;
        }

        return $this->db->delete($this->table, array('id' => $campaign_id));
    }

    public function stateUpdateItem($campaign_id, $state){
        if(!$campaign_id || !is_numeric($campaign_id)
            || !is_numeric($state)
        ){
            return false;
        }
        return $this->update($this->table, array('state'=>$state), array('id' => $campaign_id));
    }
    public function deleteItemByFolder($folder_id){
        return $this->delete($this->table, array('id_folder' => $folder_id));
    }
    
    public function get_todays_mails (){
        $this->db->where('date_sending',  date('Y-m-d'));
        $this->db->join('erp_emails_campaign_recipies AS er', $this->table.'.id = er.id_campaign', 'left');
        $query = $this->db->get($this->table);
        return($query->result());
    }
}
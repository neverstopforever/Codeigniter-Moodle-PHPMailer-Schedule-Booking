<?php

class ErpEmailsTemplateModel extends MagaModel {

    public $id;
    public $title;
    public $Subject;
    public $id_folder;
    public $Body;

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_templates";
    }

    public function addTemplate($data = null) {

        if(empty($data) || !isset($data['title']) || empty($data['title'])
            || !isset($data['Subject']) || empty($data['Subject'])
            || !isset($data['id_folder']) || empty($data['id_folder'])
            || !isset($data['Body']) || empty($data['Body'])){

            return false;
        }


        return $this->insert($this->table, $data);

    }

    public function editTemplate($template_id, $data = null) {

        if(empty($template_id) || !is_numeric($template_id) || empty($data)
            || !isset($data['title']) || empty($data['title'])
            || !isset($data['Subject']) || empty($data['Subject'])
            || !isset($data['id_folder']) || empty($data['id_folder'])
            || !isset($data['Body']) || empty($data['Body'])){

            return false;
        }


        return $this->update($this->table, $data, array('id'=>$template_id));

    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function bulk_delete($template_ids) {
//        $template_ids = array(1,2,...) like this
        if(is_array($template_ids)){
            $template_ids_filtered = array_filter($template_ids, 'is_numeric');
            if (!empty($template_ids_filtered)) {
                $this->db->where_in('id', $template_ids);
                return $this->db->delete($this->table);
            }
        }
        return false;
    }

    public function getTemplatesByAjax($start, $length, $draw, $search, $order, $columns = '') {

        $this->db->select('erp_emails_templates.*, erp_emails_templates_folder.title as folder_name')
            ->from('erp_emails_templates')
            ->join('erp_emails_templates_folder','erp_emails_templates_folder.id_folder = erp_emails_templates.id_folder', 'left');


        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('erp_emails_templates.title', $search['value']);
            $this->db->or_like('erp_emails_templates.Subject', $search['value']);
            $this->db->or_like('erp_emails_templates_folder.title', $search['value']);
        }

        if(isset($columns[0]['search']['value']) && is_numeric($columns[0]['search']['value'])){
            $this->db->where('erp_emails_templates.id_folder', $columns[0]['search']['value']);
        }

        $this->db->distinct();

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = "erp_emails_templates.id";
                    break;
                case 2:
                    $column = "erp_emails_templates.title";
                    break;
                case 3:
                    $column = "erp_emails_templates.Subject";
                    break;
                case 4:
                    $column = "folder_name";
                    break;
                default:
                    $column = "erp_emails_templates.title";
            }
            $this->db->order_by($column, $column_dir);
        }

        $query = $this->db->get('', $length, $start);

        return $query->result_object();

    }

    public function getAllTemplates(){
        $this->db->select('erp_emails_templates.*, erp_emails_templates_folder.title as folder_name')
            ->from('erp_emails_templates')
            ->join('erp_emails_templates_folder','erp_emails_templates_folder.id_folder = erp_emails_templates.id_folder', 'left');
        $query = $this->db->get();

        return $query->result();
    }

    public function getById($template_id){
        if(!$template_id || !is_numeric($template_id)){
            return false;
        }
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $template_id);
        $query = $this->db->get();

        return $query->result_object();
    }

    public function deleteItem($template_id){
        if(!$template_id || !is_numeric($template_id)){
            return false;
        }

        return $this->db->delete($this->table, array('id' => $template_id));
    }
    public function deleteItemByFolder($folder_id){
        return $this->delete($this->table, array('id_folder' => $folder_id));
    }
}
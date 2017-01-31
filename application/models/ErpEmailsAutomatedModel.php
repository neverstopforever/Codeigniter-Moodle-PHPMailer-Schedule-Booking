<?php

class ErpEmailsAutomatedModel extends MagaModel {

    public $id;
    public $title;
    public $Subject;
    public $id_folder;
    public $Body;

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_automated";
    }

    public function getTotalCount($refere = null) {
        $this->db->from($this->table);
        if($refere) {
            $this->db->where('reference', $refere);
        }
        return $this->db->count_all_results();
    }

    public function getTemplateCounts(){
        $query = $this->db->select('COUNT(*) AS _count, reference AS refere')
                          ->from($this->table)
                          ->group_by('reference')
                          ->get();
        return $query->result();
    }


    public function getTemplatesByAjax($start, $length, $draw, $search, $order, $columns = '') {

        $this->db->select('*')
            ->from('erp_emails_automated');
            //->join('erp_emails_templates_folder','erp_emails_templates_folder.id_folder = erp_emails_templates.id_folder', 'left');


        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('erp_emails_automated.title', $search['value']);
           /* $this->db->or_like('erp_emails_automated.body', $search['value']);
            $this->db->or_like('erp_emails_automated.title', $search['value']);*/
        }

        if(isset($columns[0]['search']['value']) && !empty($columns[0]['search']['value'])){
            $this->db->where('reference', $columns[0]['search']['value']);
        }
        $this->db->distinct();

       /* if (isset($order) && !empty($order)) {
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
        }*/

        $query = $this->db->get('', $length, $start);

        return $query->result_object();

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

    public function getByTemplateId($template_id, $where = null){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $template_id);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();

        return $query->row();
    }

    public function deleteItem($template_id){
        if(!$template_id || !is_numeric($template_id)){
            return false;
        }

        return $this->db->delete($this->table, array('id' => $template_id));
    }

    public function updateTemplate($template_id, $data_template){
        return $this->update($this->table, $data_template, array('id' => $template_id));
    }

    public function changeActive($template_id, $active){
        return $this->update($this->table, array('notify_student' => $active), array('id' => $template_id));
    }

    public function changeActivityAllOff(){
        return $this->db->update($this->table, array('notify_student' => '0'));
    }
}
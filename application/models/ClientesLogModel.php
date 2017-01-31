<?php

class ClientesLogModel extends MagaModel {

    public $fields = array(
        'id',
        'ccodcli',
        'ip',
        'usuario',
        'url',
        'date_time',
    );
    
    public function __construct() {
        parent::__construct();
        $this->table = "clientes_log";
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    public function getTotalCount($where = array()) {
        $this->_db->from($this->table);
        if(!empty($where)){
            $this->_db->where($where);
        }
        return $this->_db->count_all_results();
    }

    public function insertData($insert_data){
        return $this->_db->insert($this->table, $insert_data);
    }

    public function getByIdClienteAxjax($start, $length, $draw, $search, $order, $columns,$id){
        $this->_db->select("
                        SQL_CALC_FOUND_ROWS null AS rows,
                        id,
                        ccodcli AS client_id,
                        ip,
                        usuario AS username,
                        url,
                        date_time,
                        ", false);
        $this->_db->from($this->table);
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('usuario', $search['value']);
            $this->db->or_like('url', $search['value']);
            $this->db->or_like('ip', $search['value']);
            $this->db->or_like('date_time', $search['value']);
            $this->db->or_like('id', $search['value']);
        }
        $this->_db->where('ccodcli', $id);
        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 0:
                    $column = "id";
                    break;
                case 1:
                    $column = "date_time";
                    break;
                case 3:
                    $column = "usuario";
                    break;
                case 4:
                    $column = "ip";
                    break;
                case 5:
                    $column = "url";
                    break;
                default:
                    $column = 'date_time';
                    $column_dir = 'DESC';
            }
            $this->db->order_by($column, $column_dir);
        }
        $this->db->limit($length, $start);

        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }

}
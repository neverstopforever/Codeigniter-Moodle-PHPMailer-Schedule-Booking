<?php

class ClientesAvisosModel extends MagaModel {

    public $id;
    public $idcliente;
    public $startdate;
    public $enddate;
    public $message;
    public $read;
    public $title;
    public $toast;

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_avisos"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->db = $this->load->database($this->_db_name, true);
    }

    public function getAlerts() {
        $query = "
            SELECT  ca.`id` as ID, ca.`idcliente` as 'Customer Id',cli.`CNOMCOM` as Company, ca.`title` as Title, ca.`message` as Message, ca.`startdate` as 'Start Date', ca.`enddate` as 'End Date', ca.`read` as 'Read',ca.`toast` as Toast
            FROM clientes_avisos AS ca
            LEFT JOIN clientes_akaud AS cli
            ON ca.`idcliente` = cli.`CCODCLI`;
        ";

        $res = $this->db->query($query);

        return $res->result();
    }

    public function getCompanies() {
        $query = "
            SELECT ca.`idcliente` as Customer_id, cli.`CNOMCOM` AS Company
            FROM clientes_akaud_accounts AS ca
            LEFT JOIN clientes_akaud AS cli
            ON ca.`idcliente` = cli.`CCODCLI`;
        ";

        $res = $this->db->query($query);

        return $res->result();
    }

    public function getAlertMessage($id_cliente) {

        if(empty($id_cliente) || !is_numeric($id_cliente)){
            return null;
        }
        $read_global_alert_ids = $this->session->userdata('read_alert_mes_ids');
        if(!empty($read_global_alert_ids)){
            $read_global_alert_ids = implode(",", $read_global_alert_ids);
            $not_in_where = 'AND ca.`id` NOT IN ('.$read_global_alert_ids.')';
        }else{
            $not_in_where = '';
        }
        $query = "
           (SELECT ca.`message`,ca.`id`,ca.`toast`, ca.`idcliente`, ca.`read`, ca.`title`
            FROM clientes_avisos AS ca
            WHERE ca.`idcliente` = ".$id_cliente ."
            AND CURDATE() BETWEEN ca.startdate AND ca.enddate
            AND ca.`read` = 0
            )
            UNION
            (
            SELECT ca.`message`, ca.`id`,ca.`toast`, ca.`idcliente`, ca.`read`, ca.`title`
            FROM clientes_avisos AS ca
            WHERE ca.`idcliente` = 0 ". $not_in_where .
            " AND CURDATE() BETWEEN ca.startdate AND ca.enddate
            );
        ";

        $res = $this->db->query($query);

        return $res->result_array();
    }

    public function updateAlert($data, $where) {
        return $this->update($this->table, $data, $where);
    }

    public function addAlert($data) {
        return $this->insert($this->table, $data);
    }

    public function deleteAlert($id = null) {
        if (!$id) {
            return false;
        }
        $where = array(
            'id' => $id
        );
        return $this->delete($this->table, $where);
    }




    public function getDataById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        return $query->row();
    }



}
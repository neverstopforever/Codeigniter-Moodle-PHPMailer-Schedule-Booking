<?php

class ClientModel extends MagaModel {

    public $fields = array(
        'ccodcli',
        'FirstUpdate',
        'LastUpdate',
        'cnomcli',
        'cnomcom',
        'Cpobcli',
        'Cdomicilio',
        'cprovincia',
        'cnaccli',
        'cdnicif',
        'cobscli',
        'ctfo1cli',
        'Ctfo2cli',
        'SkypeEmpresa',
        'movil',
        'cfaxcli',
        'email',
        'web',
        'ccontacto',
        'cargo',
        'cobserva',
        'custom_fields',
        'idfp',
        'tarjetanum',
        'tarjetacadmes',
        'tarjetacadano',
        'irpf',
        'centidad',
        'cagencia',
        'cctrlbco',
        'ccuenta',
        'iban',
        'banco',
        'Firmado_sepa',
    );
    
    public function __construct() {
        parent::__construct();
        $this->table = "clientes";
    }

    public function getClientById($id){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('ccodcli', $id)
                          ->get();
        return $query->row();
    }

public function getFieldsList($form_type = null){
        $this->db->select('*');
        $this->db->from('erp_custom_fields');
        if($form_type) {
            $this->db->where('form_type', $form_type);
        }
        $query = $this->db->get();
        
        return $query->result_array();
        
    }
    public function getContent($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT
                ccodcli,
                FirstUpdate,
                LastUpdate,
                cnomcli,
                cnomcom,
                Cdomicilio,
                Cpobcli,
                cprovincia,
                cnaccli,
                cdnicif,
                cobscli,
                ctfo1cli,
                Ctfo2cli,
                SkypeEmpresa,
                movil,
                cfaxcli,
                email,
                web,
                ccontacto,
                cargo,
                cobserva,
                idfp,
                tarjetanum,
                tarjetacadmes,
                tarjetacadano,
                custom_fields,
                irpf,
                centidad,
                cagencia,
                cctrlbco,
                ccuenta,
                banco,
                iban,
                Firmado_sepa
                FROM clientes
                WHERE ccodcli = $id";

        return $this->selectCustom($query);
    }

    public function getEmpleados($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT
            `alumnos`.`Id`,
            `alumnos`.`facturara` as `Idalumnbo`
            ,`alumnos`.`cnomcli`
            ,`alumnos`.`Cdomicilio`
            ,`alumnos`.`CDNICIF`
            ,`alumnos`.`ctfo1cli`
            ,`alumnos`.`movil`
            ,`alumnos`.`email`
            FROM
                `alumnos`
                INNER JOIN `clientes`
                    ON(`alumnos`.`FacturarA` = `clientes`.`CCODCLI`)
                    WHERE (`clientes`.`CCODCLI` = $id)
                    ORDER BY `Idalumnbo` ASC";

        return $this->selectCustom($query);
    }

    public function getFiliales($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT
            ccodcli AS id,
            cnomcli AS `NombreFiscal`,
            cnomcom AS `NombreComercial`,
            cdnicif AS nif
            FROM
            clientes
            WHERE ccodcli_matriz=$id
            ORDER BY 2
            ;";

        return $this->selectCustom($query);
    }

    public function getNotExistFiliales($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT
            ccodcli AS id,
            cnomcli AS `NombreFiscal`,
            cnomcom AS `NombreComercial`,
            cdnicif AS nif
            FROM
            clientes
            WHERE ccodcli_matriz != $id
            ORDER BY 2
            ;";

        return $this->selectCustom($query);
    }

    public function getClientes($clienteId = null) {

        if (!$clienteId) {
            return null;
        }

        $query = 'SELECT
				DISTINCT
				cli.ccodcli
				AS
				idempresa,
				cli.cnomcli
				AS
				`nombre
				comercial`,
				cli.cnomcom
				AS
				`nombre
				fiscal`,
				cli.cdomicilio
				AS
				domicilio,
				cli.cpobcli
				AS
				poblacion,
				cli.ccodprov
				AS
				provincia,
				cli.cptlcli
				AS
				distrito,
				cli.ctfo1cli
				AS
				`telefono
				1º`,
				cli.ctfo2cli
				AS
				`telefono
				2º`,
				cli.cfaxcli
				AS
				fax,
				cli.cdnicif
				AS
				dnicif,
				cli.centidad
				AS
				`entidad
				bancaria`,
				cli.cagencia
				AS
				`oficina
				bancaria`,
				cli.cctrlbco
				AS
				dc,
				cli.ccuenta
				AS
				`cuenta
				bancaria`,
				cli.email
				AS
				email,
				cli.banco,
				cli.iban,
				cli.skypeempresa,
				cli.firstupdate
				AS
				`fecha
				alta`,
				cli.lastupdate
				AS
				`fecha
				modificación`,
				cli.cobscli
				AS
				Num_SS
				FROM
				clientes
				AS
				cli
				WHERE
				cli.`CCODCLI`=' . $clienteId;

        return $this->selectCustom($query);
    }

    public function getInvoicesCompany(){
        $query = $this->db->select('ccodcli as Id, cnomcli as name')
                          ->from($this->table)
                          ->order_by('2')
                          ->get();
        return $query->result();
    }

    public function getList(){

        $this->db->select("cli.ccodcli AS id,
                      cli.cnomcli AS `fiscal_name`,
                      cli.cnomcom AS `comercial_name`,  
                      CONCAT(cli.ctfo1cli,' ',cli.ctfo2cli) AS `phones`,
                      cli.email AS email")
                ->from($this->table ." as cli");
        $this->db->distinct();
        $this->db->order_by(2);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateItem( $data = null,$ccodcli = null){
        
        if(empty($ccodcli) || empty($data)){
            return false;
        }
        return $this->update($this->table, $data, array('CCODCLI'=>$ccodcli));
    }

    public function getAll($selectParams = '', $where = array()) {
        return  $this->selectAll($this->table, $selectParams, $where);
    } 


    public function makeInsertData($post_data){

        $insert_data = array();
        foreach ($this->fields as $field){
            if(isset($post_data[$field])){
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'){
                    $insert_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[$field]));
                }else{
                    $insert_data[$field] = $post_data[$field];
                }
            }else{
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'){
                    $insert_data[$field] = date('Y-m-d H:i:s');
                }else{
                    $insert_data[$field] = null;
                }
            }
        }
        return $insert_data;
    }
    
    public function makeUpdateData($post_data){
        $update_data = array();
        foreach ($this->fields as $field){
            if(isset($post_data[$field])){
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'){
                    $update_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[$field]));
                }else{
                    $update_data[$field] = $post_data[$field];
                }
            }
        }
        if(!isset($update_data['Firmado_sepa'])){
            $update_data['Firmado_sepa'] = 0;
        }

        return $update_data;
    }
    
    public function insertClient($insert_data){
        return $this->db->insert($this->table, $insert_data);
    }


    public function get_companies_for_select(){
        $query = "SELECT ccodcli as companyid, cnomcli as company_name FROM clientes ORDER BY 2;";

        return  $this->selectCustom($query);
    }
}
<?php

class FacturaModel extends MagaModel {


    public function __construct() {
        parent::__construct();
        $this->table = "facturas";
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_for_invoices(){
        
        $query = "SELECT 
                  fa.n_factura AS `invoice_id`,
                  DATE(fa.fecha_factura) AS `Date`,
                  fa.nummatricula AS `Enroll_id`,
                  fa.codigoalumno AS `customer_id`,
                  IF(fa.ccliente > 0, cli.cnomcli, CONCAT(al.sapellidos,', ',al.snombre)) AS customer_name,
                
                  IF(
                    fa.nummatricula > 0,
                    CONCAT(al2.sapellidos,', ',al2.snombre),
                    '---'
                  ) AS student,
                
                  fa.importefactura AS `amount`,
                  fa.id_fp AS `payment_method`,
                  fa.fa AS doc_type,
                 
                  (
                    CASE
                
                      WHEN 
                        (SELECT COUNT(n_factura) FROM facturas WHERE n_factura = fa.n_factura LIMIT 1) = 0 
                         THEN 'p' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) 
                           AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0)) 
                         THEN 'c' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) <> 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1)) AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0) 
                         THEN 'pc' 
                
                      WHEN 
                      (SELECT 
                        COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado <> 1 LIMIT 1) 
                        THEN 'p' 
                      
                      ELSE 'p' 
                    END
                  ) AS `state`
                
                FROM
                  facturas AS fa 
                  LEFT JOIN matriculat AS mt 
                    ON fa.nummatricula = mt.nummatricula 
                  LEFT JOIN alumnos AS al 
                    ON fa.codigoalumno = al.ccodcli 
                  LEFT JOIN alumnos AS al2 
                    ON mt.ccodcli = al2.ccodcli 
                  LEFT JOIN clientes AS cli 
                    ON fa.ccliente = cli.ccodcli 
                    
                ORDER BY 1 DESC";
        
        return $this->selectCustom($query);
    }

    public function insertNewInvoice($quote_id){
        $query = " INSERT INTO `facturas`
            (`N_FACTURA`,
             `FECHA_FACTURA`,
             `TotalFactura`,
             `NumMatricula`,
             `IdDivisa`,
             `FA`,
             `ImporteFactura`,
             `CodigoAlumno`,
             `CCliente`,
             `IdCentro`,
             `irpf`,
             `totalirpf`,
             `id_fp`)
            
   SELECT
    (SELECT numfactura+1 FROM variables2),
    CURDATE() ,
    re.`IMPORTE`,
    re.`NumMatricula`,
    '1',
    'F',
    re.`neto`,
    IF(re.`IdTipoCliente`=1,re.`IdCliente`,0),
    IF(re.`IdTipoCliente`=2,re.`IdCliente`,0),
    '0',
    '0',
    '0',
    re.`ID_FP`
    FROM recibos AS re
    WHERE re.`NUM_RECIBO` =  ".$quote_id." ;" ;
        return $this->db->query($query);

    }

    public function getInvoicesDataAjax($start, $length, $draw, $search, $order, $columns, $filter_tags){
        $where = '';

        $selected_invoice_id = $filter_tags['selected_invoice_id'];
        $selected_customer_name = $filter_tags['selected_customer_name'];
        $selected_doc_type = $filter_tags['selected_doc_type'];
        $selected_date = $filter_tags['selected_date'];


        if(!empty($selected_invoice_id) && is_array($selected_invoice_id)){
            $selected_invoice_ids = implode(',', $selected_invoice_id);
            $selected_invoice_ids = rtrim($selected_invoice_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " fa.n_factura IN (".$selected_invoice_ids.")";
        }

        if(!empty($selected_customer_name) && is_array($selected_customer_name)){
            $selected_customer_ids = implode(',', $selected_customer_name);
            $selected_customer_ids = rtrim($selected_customer_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " fa.codigoalumno IN (".$selected_customer_ids.")";
        }


        if(!empty($selected_doc_type) && is_array($selected_doc_type)){

            $selected_doc_type_ids = '';
            foreach ($selected_doc_type as $doc_type){
                if(empty($selected_doc_type_ids)){
                    $selected_doc_type_ids .= "'".$doc_type."'";
                }else{
                    $selected_doc_type_ids .= ",'".$doc_type."'";
                }
            }
            $selected_doc_type_ids = rtrim($selected_doc_type_ids, ",");
//            $selected_doc_type_ids = implode(',', $selected_doc_type);
//            $selected_doc_type_ids = rtrim($selected_doc_type_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " fa.fa IN (".$selected_doc_type_ids.")";
        }

        if(!empty($selected_date) && is_array($selected_date)){
            $from = '';
            if(isset($selected_date['from'])){
                $from = date('Y-m-d', strtotime($selected_date['from']));
            }
            $to = '';
            if(isset($selected_date['to'])){
                $to = date('Y-m-d', strtotime($selected_date['to']));
            }
            if(!empty($from) && !empty($to)){
                if(empty($where)){
                    //$where .= " WHERE ";
                }else{
                    $where .= " AND ";
                }
                $where .= " DATE(fa.fecha_factura) BETWEEN '".$from."' AND '".$to."' ";
            }
        }

        $this->db->select("
                SQL_CALC_FOUND_ROWS null AS rows,
                    fa.n_factura AS `invoice_id`,
                  DATE(fa.fecha_factura) AS `Date`,
                  fa.nummatricula AS `Enroll_id`,
                  fa.codigoalumno AS `customer_id`,
                  IF(fa.ccliente > 0, cli.cnomcli, CONCAT(al.sapellidos,', ',al.snombre)) AS customer_name,
                
                  IF(
                    fa.nummatricula > 0,
                    CONCAT(al2.sapellidos,', ',al2.snombre),
                    '---'
                  ) AS student,
                
                  fa.importefactura AS `amount`,
                  fa.id_fp AS `payment_method`,
                  fa.fa AS doc_type,
                 
                  (
                    CASE
                
                      WHEN 
                        (SELECT COUNT(n_factura) FROM facturas WHERE n_factura = fa.n_factura LIMIT 1) = 0 
                         THEN 'p' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) 
                           AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0)) 
                         THEN 'c' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) <> 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1)) AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0) 
                         THEN 'pc' 
                
                      WHEN 
                      (SELECT 
                        COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado <> 1 LIMIT 1) 
                        THEN 'p' 
                      
                      ELSE 'p' 
                    END
                  ) AS `state`", false);
        $this->db->from($this->table.' AS fa');
        $this->db->join('matriculat AS mt', 'fa.nummatricula = mt.nummatricula', 'left');
        $this->db->join('alumnos AS al', 'fa.codigoalumno = al.ccodcli', 'left');
        $this->db->join('alumnos AS al2', 'mt.ccodcli = al2.ccodcli', 'left');
        $this->db->join('clientes AS cli', 'fa.ccliente = cli.ccodcli', 'left');
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('al.sapellidos', $search['value']);
            $this->db->or_like('al.snombre', $search['value']);
            $this->db->or_like('fa.fecha_factura', $search['value']);
            $this->db->or_like('fa.codigoalumno', $search['value']);
            $this->db->or_like('fa.nummatricula', $search['value']);
            $this->db->or_like('fa.importefactura', $search['value']);
            $this->db->or_like('fa.id_fp', $search['value']);
            $this->db->or_like('fa.fa', $search['value']);
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = "fa.n_factura";
                    break;
                case 2:
                    $column = "cli.cnomcli";
                    break;
                case 3:
                    $column = "fa.fecha_factura";
                    break;
                case 4:
                    $column = "al2.snombre";
                    break;
                case 5:
                    $column = "fa.importefactura";
                    break;
                case 6:
                    $column = "fa.fa";
                    break;
                case 7:
                    $column = "fa.id_fp";
                    break;
                /*case 8:
                    $column = "re.ESTADO";
                    break;*/
                default:
                    $column = 2;
                    $column_dir = 'DESC';
            }
            $this->db->order_by($column, $column_dir);
        }



        $this->db->limit($length, $start);

        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }

    public function getInvoicesDataByStudent($student_id){
        $this->db->select("
                    fa.n_factura AS `invoice_id`,
                  DATE(fa.fecha_factura) AS `Date`,
                  fa.nummatricula AS `Enroll_id`,
                  fa.codigoalumno AS `customer_id`,
                  IF(fa.ccliente > 0, cli.cnomcli, CONCAT(al.sapellidos,', ',al.snombre)) AS customer_name,
                
                  IF(
                    fa.nummatricula > 0,
                    CONCAT(al2.sapellidos,', ',al2.snombre),
                    '---'
                  ) AS student,
                
                  fa.importefactura AS `amount`,
                  fa.id_fp AS `payment_method`,
                  fa.fa AS doc_type,
                 
                  (
                    CASE
                
                      WHEN 
                        (SELECT COUNT(n_factura) FROM facturas WHERE n_factura = fa.n_factura LIMIT 1) = 0 
                         THEN 'p' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) 
                           AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0)) 
                         THEN 'c' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) <> 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1)) AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0) 
                         THEN 'pc' 
                
                      WHEN 
                      (SELECT 
                        COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado <> 1 LIMIT 1) 
                        THEN 'p' 
                      
                      ELSE 'p' 
                    END
                  ) AS `state`", false);
        $this->db->from($this->table.' AS fa');
        $this->db->join('matriculat AS mt', 'fa.nummatricula = mt.nummatricula', 'left');
        $this->db->join('alumnos AS al', 'fa.codigoalumno = al.ccodcli', 'left');
        $this->db->join('alumnos AS al2', 'mt.ccodcli = al2.ccodcli', 'left');
        $this->db->join('clientes AS cli', 'fa.ccliente = cli.ccodcli', 'left');
        $this->db->where('al2.ccodcli', $student_id);
        $this->db->order_by(2, 'DESC');

        $query = $this->db->get();
        return  $query->result();
    }

    public function get_personal_data($INVOICE_ID, $student_id = null){
        $id_is_array = false;
        if (empty($INVOICE_ID)) {
            return false;
        }
        if(is_array($INVOICE_ID)){
            $id_is_array = true;
        }
        
         $this->db->select("fa.`N_FACTURA` AS invoice_id,
                      IF(ccliente>0,
                       ('company'),
                       ('student')
                       ) AS `role`,
                      IF(ccliente>0,
                       (SELECT ccodcli FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT ccodcli FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_id`,
                      IF(ccliente>0,
                       (SELECT cnomcom FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT CONCAT(sapellidos, ', ', snombre) FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_name`,
                      IF(ccliente>0,
                       (SELECT cdnicif FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT cdnicif FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_cif`,
                      IF(ccliente>0,
                       (SELECT cdomicilio FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT cdomicilio FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_address`,
                      IF(ccliente>0,
                       (SELECT cpobcli FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT cpobcli FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_city`,
                      IF(ccliente>0,
                       (SELECT ccodprov FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT ccodprov FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_city`,
                      IF(ccliente>0,
                       (SELECT LTRIM(CONCAT(ctfo1cli, ' ', ctfo2cli, ' ', movil)) FROM clientes WHERE ccodcli = fa.ccliente),
                       (SELECT LTRIM(CONCAT(ctfo1cli, ' ', ctfo2cli, ' ', movil)) FROM alumnos WHERE ccodcli = fa.codigoalumno)
                       ) AS `customer_phones`");
                    
                    $this->db->from('facturas AS fa');
        if($student_id){
            $this->db->where('fa.codigoalumno', $student_id);
        }
        if(!$id_is_array) {
            $this->db->where('fa.`N_FACTURA`', $INVOICE_ID);
        }else{
            $this->db->where_in('fa.`N_FACTURA`', $INVOICE_ID);
        }
        $res = $this->db->get();
        if(!$id_is_array) {
            return $res->row();
        }else{
            return $res->result();
        }
    }

    public function get_details($INVOICE_ID){
        $id_is_array = false;
        if (empty($INVOICE_ID)) {
            return false;
        }
        if(is_array($INVOICE_ID)){
            $id_is_array = true;
        }

        $this->db->select("
                    DATE(fa.fecha_factura) AS `invoice_date`,
                      fa.nummatricula as `enroll_id`,
                      fa.`N_FACTURA` AS invoice_id,
                      fa.id_fp AS `payment_method`,
                      fa.fa AS doc_type,
                     
                      (
                        CASE
                    
                          WHEN 
                            (SELECT COUNT(n_factura) FROM facturas WHERE n_factura = fa.n_factura LIMIT 1) = 0 
                             THEN 'p' 
                    
                          WHEN 
                            ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = 
                            (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) 
                               AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0)) 
                             THEN 'c' 
                    
                          WHEN 
                            ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) <> 
                            (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1)) AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0) 
                             THEN 'pc' 
                    
                          WHEN 
                          (SELECT 
                            COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado <> 1 LIMIT 1) 
                            THEN 'p' 
                          
                          ELSE 'p' 
                        END
                      ) AS `state`,
                      
                      fa.importefactura AS `amount` "
                );

        $this->db->from('facturas AS fa');
        if($id_is_array){
            $this->db->where_in('fa.`N_FACTURA`', $INVOICE_ID);
        }else{
            $this->db->where('fa.`N_FACTURA`', $INVOICE_ID);
        }
        $res = $this->db->get();
        if($id_is_array) {
            return $res->result();
        }else{
            return $res->row();
        }
    }


    public function getInvoicesByTags($tags = array()){

        $where = '';

        $selected_invoice_id = isset($tags['selected_invoice_id']) ? $tags['selected_invoice_id']: null;
        $selected_customer_name = isset($tags['selected_customer_name']) ? $tags['selected_customer_name']: null;
        $selected_doc_type = isset($tags['selected_doc_type']) ? $tags['selected_doc_type']: null;
        $selected_date = isset($tags['selected_date']) ? $tags['selected_date']: null;


        if(!empty($selected_invoice_id) && is_array($selected_invoice_id)){
            $selected_invoice_ids = implode(',', $selected_invoice_id);
            $selected_invoice_ids = rtrim($selected_invoice_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " fa.n_factura IN (".$selected_invoice_ids.")";
        }

        if(!empty($selected_customer_name) && is_array($selected_customer_name)){
            $selected_customer_ids = implode(',', $selected_customer_name);
            $selected_customer_ids = rtrim($selected_customer_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " fa.codigoalumno IN (".$selected_customer_ids.")";
        }


        if(!empty($selected_doc_type) && is_array($selected_doc_type)){

            $selected_doc_type_ids = '';
            foreach ($selected_doc_type as $doc_type){
                if(empty($selected_doc_type_ids)){
                    $selected_doc_type_ids .= "'".$doc_type."'";
                }else{
                    $selected_doc_type_ids .= ",'".$doc_type."'";
                }
            }
            $selected_doc_type_ids = rtrim($selected_doc_type_ids, ",");
//            $selected_doc_type_ids = implode(',', $selected_doc_type);
//            $selected_doc_type_ids = rtrim($selected_doc_type_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " fa.fa IN (".$selected_doc_type_ids.")";
        }

        if(!empty($selected_date) && is_array($selected_date)){
            $from = '';
            if(isset($selected_date['from'])){
                $from = date('Y-m-d', strtotime($selected_date['from']));
            }
            $to = '';
            if(isset($selected_date['to'])){
                $to = date('Y-m-d', strtotime($selected_date['to']));
            }
            if(!empty($from) && !empty($to)){
                if(empty($where)){
                    $where .= " WHERE ";
                }else{
                    $where .= " AND ";
                }
                $where .= " DATE(fa.fecha_factura) BETWEEN '".$from."' AND '".$to."' ";
            }
        }

        $query = "SELECT 
                  fa.n_factura AS `invoice_id`,
                  DATE(fa.fecha_factura) AS `Date`,
                  fa.nummatricula AS `Enroll_id`,
                  fa.codigoalumno AS `customer_id`,
                  IF(fa.ccliente > 0, cli.cnomcli, CONCAT(al.sapellidos,', ',al.snombre)) AS customer_name,
                
                  IF(
                    fa.nummatricula > 0,
                    CONCAT(al2.sapellidos,', ',al2.snombre),
                    '---'
                  ) AS student,
                
                  fa.importefactura AS `amount`,
                  fa.id_fp AS `payment_method`,
                  fa.fa AS doc_type,
                 
                  (
                    CASE
                
                      WHEN 
                        (SELECT COUNT(n_factura) FROM facturas WHERE n_factura = fa.n_factura LIMIT 1) = 0 
                         THEN 'p' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) 
                           AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0)) 
                         THEN 'c' 
                
                      WHEN 
                        ((SELECT COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) <> 
                        (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1)) AND ((SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado = 1 LIMIT 1) > 0) 
                         THEN 'pc' 
                
                      WHEN 
                      (SELECT 
                        COUNT(n_factura) FROM recibos WHERE n_factura = fa.n_factura LIMIT 1) = (SELECT COUNT(num_recibo) FROM recibos WHERE n_factura = fa.n_factura AND estado <> 1 LIMIT 1) 
                        THEN 'p' 
                      
                      ELSE 'p' 
                    END
                  ) AS `state` ";

        $query .="       
                FROM
                  facturas AS fa 
                  LEFT JOIN matriculat AS mt 
                    ON fa.nummatricula = mt.nummatricula 
                  LEFT JOIN alumnos AS al 
                    ON fa.codigoalumno = al.ccodcli 
                  LEFT JOIN alumnos AS al2 
                    ON mt.ccodcli = al2.ccodcli 
                  LEFT JOIN clientes AS cli 
                    ON fa.ccliente = cli.ccodcli ";

        if(!empty($where)){
            $query .= $where;
        }

        $query .= " ORDER BY 1 DESC;";

        return $this->selectCustom($query);
    }

    public function add_student_item($INVOICE_ID, $DATE, $TYPE_OF_DOCUMENT, $STUDENT_ID, $PAYMENT_METHOD){
        
        $query = "INSERT INTO facturas (`n_factura`,`fecha_factura`,`fa`,`codigoalumno`,`id_fp`,ccliente,idcentro)

        SELECT '".$INVOICE_ID."', '". date('Y-m-d', strtotime($DATE))."' ,'".$TYPE_OF_DOCUMENT."', ccodcli, '".$PAYMENT_METHOD."', 0,0 
        FROM alumnos WHERE ccodcli = '".$STUDENT_ID."'
        ;";
        return $this->db->query($query);
    }

    public function add_company_item($INVOICE_ID, $DATE, $TYPE_OF_DOCUMENT, $COMPANY_ID, $PAYMENT_METHOD){
        
        $query = "INSERT INTO facturas (`n_factura`,`fecha_factura`,`fa`,`codigoalumno`,`id_fp`,ccliente,idcentro)

                SELECT '".$INVOICE_ID."', '".$DATE."' ,'".$TYPE_OF_DOCUMENT."', 0, '".$PAYMENT_METHOD."',ccodcli,0
                FROM clientes WHERE ccodcli = '".$COMPANY_ID."' ;";
        return $this->db->query($query);
    }
    
    public function updateItem($data, $where){
        return $this->db->update($this->table, $data, $where);
    }


    public function deleteItem($where){
        return $this->db->delete($this->table, $where);
    }


    public function check_linked_invoice($invoice_id = null){
        if(empty($invoice_id)){
            return false;
        }
        $query = "SELECT
                      fa.nummatricula as `enroll_id`,
                      IF(fa.nummatricula>0,
                         1,
                         0
                      ) AS `invoice_linked`
                    
                    FROM facturas AS fa
                    WHERE fa.`N_FACTURA` = '".$invoice_id."'
                    ;";
        
        
        return $this->db->query($query)->row();
    }


}
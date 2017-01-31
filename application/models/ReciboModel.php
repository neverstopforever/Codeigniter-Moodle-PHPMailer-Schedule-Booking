<?php

class ReciboModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "recibos";
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getHistoricAccount($id) {

        if (!$id) {
            return null;
        }

        $query = "SELECT
            r.NumMatricula,
            r.N_FACTURA,
            r.Concepto ,
            r.NUM_RECIBO,
            r.FECHA_VTO,
            r.Concepto,
            IF(r.estado=1,r.importe,'') AS Cobro,
            IF(r.estado<>1,r.importe,'') AS Adeudo,
            er.Descripcion AS `EstadoRecibo`,
            (SELECT fecha FROM recibos_historico WHERE num_recibo = r.num_recibo AND estado = 1 ORDER BY id
            DESC LIMIT 1) AS `FechaCobro`,
            IF(r.n_factura IS NULL OR r.n_factura=0,'No','Sí') AS `Facturado`,
            IF((SELECT COUNT(*) FROM remesal WHERE `NUM_RECIBO` = r.num_recibo) > 0,'SI','NO') AS Remesado,
            (SELECT GROUP_CONCAT(DISTINCT idremesa) FROM remesal WHERE num_recibo = r.num_recibo) AS
            `Remesas`
            FROM recibos AS r
            INNER JOIN estadorecibo AS er ON r.ESTADO = er.IdEstado
            LEFT JOIN matriculat AS mt ON r.NumMatricula = mt.NumMatricula
            LEFT JOIN alumnos AS al ON r.IdCliente = al.CCODCLI
            LEFT JOIN clientes AS cl ON r.IdCliente = cl.CCODCLI
            WHERE (r.IdTipoCliente=2) AND (r.IdCliente=$id)
            ORDER BY 10 DESC";

        return $this->selectCustom($query);
    }

    public function getAccounting($student_id){
        $query = $this->db->select('`NumMatricula` AS enroll,
                                      N_FACTURA AS invoice,
                                      DATE_FORMAT(`FECHA_VTO`,"%d/%m/%Y") AS doc_date,
                                      Concepto AS concept,
                                      NUM_RECIBO AS receipt,
                                      IMPORTE AS amount,
                                      `ID_FP` AS payment_method,
                                      ESTADO AS state')
                          ->from($this->table)
                          ->where('IdTipoCliente', 1)
                          ->where('IdCliente', $student_id)
                          ->order_by('3')
                          ->get();

        return $query->result();
    }

    public function getAccountingForGroup($group_id){
        $query = "SELECT * FROM
                    (

                    SELECT al.cnomcli AS customer, r.nummatricula AS enrollid, r.fecha_vto AS `date`, r.num_recibo AS `receipt`, r.concepto AS concept,
                     r.importe AS `amount`, r.id_fp AS `payment_method`, r.estado AS state
                     FROM recibos AS r
                     LEFT JOIN alumnos AS al ON r.idcliente = al.ccodcli
                     LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                     WHERE (r.idtipocliente = 1 OR r.idtipocliente IS NULL)
                     AND r.nummatricula>0
                     AND ml.idgrupo='".$group_id."'

                     UNION

                     SELECT cl.cnomcli AS customer, r.nummatricula AS enrollid, r.fecha_vto AS `date`, r.num_recibo AS `receipt`, r.concepto AS concept,
                     r.importe AS `amount`, r.id_fp AS `payment_method`, r.estado AS state
                     FROM recibos AS r
                     LEFT JOIN clientes AS cl ON r.idcliente = cl.ccodcli
                     LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                     WHERE r.idtipocliente = 2
                     AND r.nummatricula>0
                     AND ml.idgrupo='".$group_id."'

                     UNION

                     SELECT cl.cnomcli AS customer, r.nummatricula AS enrollid, r.fecha_vto AS `date`, r.num_recibo AS `receipt`, r.concepto AS concept,
                     r.importe AS `amount`, r.id_fp AS `payment_method`, r.estado AS state
                     FROM recibos AS r
                     LEFT JOIN clientes AS cl ON r.idcliente = cl.ccodcli
                     LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                     WHERE r.idtipocliente = 2
                     AND ((r.nummatricula=0) OR (r.nummatricula IS NULL))
                     AND r.idrecgrp IN (SELECT id FROM grupos_fact_rec WHERE grupos_fact_rec.`idgrupo` = '".$group_id."')

                    ) AS t1

                    ORDER BY 1,2,3";
        return $this->selectCustom($query);
    }

    public function getTotalDue($group_id){
        $query  = "SELECT SUM(t1.importe) AS total FROM
                    (

                    SELECT r.importe
                     FROM recibos AS r
                     LEFT JOIN alumnos AS al ON r.idcliente = al.ccodcli
                     LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                     WHERE (r.idtipocliente = 1 OR r.idtipocliente IS NULL)
                     AND r.nummatricula>0
                     AND r.`ESTADO` IN (0,2,3)
                     AND ml.idgrupo= '".$group_id."'

                     UNION

                     SELECT r.importe
                     FROM recibos AS r
                     LEFT JOIN clientes AS cl ON r.idcliente = cl.ccodcli
                     LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                     WHERE r.idtipocliente = 2
                     AND r.nummatricula>0
                     AND r.`ESTADO` IN (0,2,3)
                     AND ml.idgrupo= '".$group_id."'

                     UNION

                     SELECT r.importe
                     FROM recibos AS r
                     LEFT JOIN clientes AS cl ON r.idcliente = cl.ccodcli
                     LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                     WHERE r.idtipocliente = 2
                     AND ((r.nummatricula=0) OR (r.nummatricula IS NULL))
                     AND r.idrecgrp IN (SELECT id FROM grupos_fact_rec WHERE grupos_fact_rec.`idgrupo` = '".$group_id."')
                     AND r.`ESTADO` IN (0,2,3)

                    ) AS t1";
        return $this->selectCustom($query);

    }

    public function getTotalCashed($group_id){
        $query  = "SELECT SUM(t1.importe) AS total FROM
                        (

                        SELECT r.importe
                         FROM recibos AS r
                         LEFT JOIN alumnos AS al ON r.idcliente = al.ccodcli
                         LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                         WHERE (r.idtipocliente = 1 OR r.idtipocliente IS NULL)
                         AND r.nummatricula>0
                         AND r.`ESTADO` IN (1)
                         AND ml.idgrupo='".$group_id."'

                         UNION

                         SELECT r.importe
                         FROM recibos AS r
                         LEFT JOIN clientes AS cl ON r.idcliente = cl.ccodcli
                         LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                         WHERE r.idtipocliente = 2
                         AND r.nummatricula>0
                         AND r.`ESTADO` IN (1)
                         AND ml.idgrupo='".$group_id."'

                         UNION

                         SELECT r.importe
                         FROM recibos AS r
                         LEFT JOIN clientes AS cl ON r.idcliente = cl.ccodcli
                         LEFT JOIN matriculal AS ml ON r.nummatricula = ml.nummatricula
                         WHERE r.idtipocliente = 2
                         AND ((r.nummatricula=0) OR (r.nummatricula IS NULL))
                         AND r.idrecgrp IN (SELECT id FROM grupos_fact_rec WHERE grupos_fact_rec.`idgrupo` = '".$group_id."')
                         AND r.`ESTADO` IN (1)

                        ) AS t1";
        return $this->selectCustom($query);

    }
    
    public function insertFees($insert_data){
        $query = "INSERT INTO recibos (fecha_vto, estado, fecha_fra, concepto, id_fp, idtipocliente, idcliente,nummatricula,idcaja,neto,porcentaje_impuesto,impuesto,importe,codigogrupo)

                SELECT 
                '".$insert_data->payment_date."',
                '0',
                NOW(),
                '".$insert_data->subject."',
                IF(facturara=0,IF(idfp IS NULL,'0',idfp),(SELECT IF(idfp IS NULL,'0',idfp) FROM clientes WHERE ccodcli = alumnos.`facturara`)),
                IF(facturara=0,'1','2'),
                ccodcli,
                '".$insert_data->enroll_id."',
                '0',
                '".$insert_data->amount."',
                '".$insert_data->percentage_fees."',
                '".$insert_data->total_fees."',
                '".$insert_data->total_amount."',
                '".$insert_data->group_id."'
                
                FROM alumnos
                WHERE ccodcli = '".$insert_data->student_id."'
                LIMIT 1";

        return $this->custom_sql($query);
    }
    
    public function getReceiptList($num_recibo = null, $memo = false){
       
        $query = "SELECT 
                  FLOOR(re.idcliente) AS `client_id`,
                  re.num_recibo AS `doc_id`,
                  re.nummatricula AS enroll_id,
                  DATE(re.fecha_vto) AS `appointment_date`,
                  IF(
                    re.`idtipocliente` = 1,
                    CONCAT(al.sapellidos,', ',al.snombre),
                    cli.`cnomcli`
                  ) AS customer_name,
                  IF(
                    re.`idtipocliente` = 1,
                    al.email,
                    cli.`Email`
                  ) AS email,
                  IF(
                    re.`idtipocliente` = 1,
                    al.cdomicilio,
                    cli.`cdomicilio`
                  ) AS customer_address,
                  IF(
                    re.`idtipocliente` = 1,
                    al.ccodprov,
                    cli.`ccodprov`
                  ) AS customer_city,
                  IF(
                    re.`idtipocliente` = 1,
                    al.cdnicif,
                    cli.`cdnicif`
                  ) AS customer_cif,
                  IF(
                    re.`idtipocliente` = 1,
                    LTRIM(CONCAT(al.ctfo1cli, ' ', al.ctfo2cli, ' ', al.movil)),
                    LTRIM(CONCAT(cli.ctfo1cli, ' ', cli.ctfo2cli, ' ', cli.movil))
                  ) AS customer_phones,
                  IF(
                    re.idtipocliente = 1,
                    'student',
                    'company'
                  ) AS `customer_type`,
                  re.`ID_FP` `payment_type`,
                  re.concepto AS `service`,
                  ROUND(re.importe, 2) AS `amount`,
                  re.`ESTADO` AS `state`,
                  IF(
                    re.`n_factura` < 1 
                    OR re.`n_factura` IS NULL,
                    'not_invoiced',
                    re.`n_factura`
                  ) AS invoiced,
                  re.idcaja AS `cash_id`";
        if($memo){
            $query .= ",re.memo AS `comments` ";
        }
        $query .="       
                FROM
                  recibos AS re 
                  LEFT JOIN alumnos AS al 
                    ON re.idcliente = al.ccodcli 
                  LEFT JOIN clientes AS cli 
                    ON re.idcliente = cli.ccodcli ";
        
        if($num_recibo){
            $query .= " WHERE re.num_recibo='".$num_recibo."'";
        }
        $query .= " ORDER BY 1 DESC;";

        return $this->selectCustom($query);
    }

    public function getReceiptListAjax($start, $length, $draw, $search, $order, $columns, $filter_tags){
        $where = '';

        $selected_doc_id =  $filter_tags['selected_doc_id'];
        $selected_customer_name =  $filter_tags['selected_customer_name'];
        $selected_state =  $filter_tags['selected_state'];
        $selected_payment_type = $filter_tags['selected_payment_type'];
        $selected_appointment_date = $filter_tags['selected_appointment_date'];

        if(!empty($selected_doc_id) && is_array($selected_doc_id)){
            $selected_doc_ids = implode(',', $selected_doc_id);
            $selected_doc_ids = rtrim($selected_doc_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " re.num_recibo IN (".$selected_doc_ids.")";
        }

        if(!empty($selected_customer_name) && is_array($selected_customer_name)){
            $selected_customer_ids = implode(',', $selected_customer_name);
            $selected_customer_ids = rtrim($selected_customer_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " FLOOR(re.idcliente) IN (".$selected_customer_ids.")";
        }

        if(!empty($selected_state) && is_array($selected_state)){
            $selected_state_ids = implode(',', $selected_state);
            $selected_state_ids = rtrim($selected_state_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " re.`ESTADO` IN (".$selected_state_ids.")";
        }

        if(!empty($selected_payment_type) && is_array($selected_payment_type)){
            $selected_payment_type_ids = implode(',', $selected_payment_type);
            $selected_payment_type_ids = rtrim($selected_payment_type_ids, ',');
            if(empty($where)){
                //$where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " re.`ID_FP` IN (".$selected_payment_type_ids.")";
        }

        if(!empty($selected_appointment_date) && is_array($selected_appointment_date)){
            $from = '';
            if(isset($selected_appointment_date['from'])){
                $from = date('Y-m-d', strtotime($selected_appointment_date['from']));
            }
            $to = '';
            if(isset($selected_appointment_date['to'])){
                $to = date('Y-m-d', strtotime($selected_appointment_date['to']));
            }
            if(!empty($from) && !empty($to)){
                if(empty($where)){
                    //$where .= " WHERE ";
                }else{
                    $where .= " AND ";
                }
                $where .= " DATE(re.fecha_vto) BETWEEN '".$from."' AND '".$to."' ";
            }
        }

        $this->db->select(" 
                  SQL_CALC_FOUND_ROWS null AS rows,
                  FLOOR(re.idcliente) AS `client_id`,
                  re.num_recibo AS `doc_id`,
                  DATE(re.fecha_vto) AS `appointment_date`,
                  IF(
                    re.`idtipocliente` = 1,
                    CONCAT(al.sapellidos,', ',al.snombre),
                    cli.`cnomcli`
                  ) AS customer_name,
                  IF(
                    re.idtipocliente = 1,
                    'student',
                    'company'
                  ) AS `customer_type`,
                  re.`ID_FP` `payment_type`,
                  re.concepto AS `service`,
                  ROUND(re.importe, 2) AS `amount`,
                  re.`ESTADO` AS `state`,
                  IF(
                    re.`n_factura` < 1 
                    OR re.`n_factura` IS NULL,
                    'not_invoiced',
                    re.`n_factura`
                  ) AS invoiced,
                  re.idcaja AS `cash_id`", false);
        $this->db->from($this->table.' AS re');
        $this->db->join('alumnos AS al', 're.idcliente = al.ccodcli', 'left');
        $this->db->join('clientes AS cli', 're.idcliente = cli.ccodcli', 'left');
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('re.num_recibo', $search['value']);
            $this->db->or_like('DATE(re.fecha_vto)', $search['value']);
            $this->db->or_like('al.sapellidos', $search['value']);
            $this->db->or_like('al.snombre', $search['value']);
            $this->db->or_like('re.concepto', $search['value']);
        }
        if(!empty($where)){
           $this->db->where($where);
        }

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = "al.snombre";
                    break;
                case 2:
                    $column = "re.idtipocliente";
                    break;
                case 3:
                    $column = "re.concepto";
                    break;
                case 4:
                    $column = "re.importe";
                    break;
                case 5:
                    $column = "re.fecha_vto";
                    break;
                case 6:
                    $column = "re.n_factura";
                    break;
                case 7:
                    $column = "re.ID_FP";
                    break;
                case 8:
                    $column = "re.ESTADO";
                    break;
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
    
    public function getReceiptListByStudent($student_id){
        
        $this->db->select(" 
                  FLOOR(re.idcliente) AS `client_id`,
                  re.num_recibo AS `doc_id`,
                  DATE(re.fecha_vto) AS `appointment_date`,
                  IF(
                    re.`idtipocliente` = 1,
                    CONCAT(al.sapellidos,', ',al.snombre),
                    cli.`cnomcli`
                  ) AS customer_name,
                  IF(
                    re.idtipocliente = 1,
                    'student',
                    'company'
                  ) AS `customer_type`,
                  re.`ID_FP` `payment_type`,
                  re.concepto AS `service`,
                  ROUND(re.importe, 2) AS `amount`,
                  re.`ESTADO` AS `state`,
                  IF(
                    re.`n_factura` < 1 
                    OR re.`n_factura` IS NULL,
                    'not_invoiced',
                    re.`n_factura`
                  ) AS invoiced,
                  re.idcaja AS `cash_id`", false);
        $this->db->from($this->table.' AS re');
        $this->db->join('alumnos AS al', 're.idcliente = al.ccodcli', 'left');
        $this->db->join('clientes AS cli', 're.idcliente = cli.ccodcli', 'left');
        $this->db->where('al.ccodcli', $student_id);
        $this->db->order_by(2, 'DESC');

        $query = $this->db->get();
        return  $query->result();
    }
    public function getQuotesByTags($tags = array()){

        $where = '';

        $selected_doc_id = isset($tags['selected_doc_id']) ? $tags['selected_doc_id']: null;
        $selected_customer_name = isset($tags['selected_customer_name']) ? $tags['selected_customer_name']: null;
        $selected_state = isset($tags['selected_state']) ? $tags['selected_state']: null;
        $selected_payment_type = isset($tags['selected_payment_type']) ? $tags['selected_payment_type']: null;
        $selected_appointment_date = isset($tags['selected_appointment_date']) ? $tags['selected_appointment_date']: null;


        if(!empty($selected_doc_id) && is_array($selected_doc_id)){
            $selected_doc_ids = implode(',', $selected_doc_id);
            $selected_doc_ids = rtrim($selected_doc_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " re.num_recibo IN (".$selected_doc_ids.")";
        }

        if(!empty($selected_customer_name) && is_array($selected_customer_name)){
            $selected_customer_ids = implode(',', $selected_customer_name);
            $selected_customer_ids = rtrim($selected_customer_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " FLOOR(re.idcliente) IN (".$selected_customer_ids.")";
        }

        if(!empty($selected_state) && is_array($selected_state)){
            $selected_state_ids = implode(',', $selected_state);
            $selected_state_ids = rtrim($selected_state_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " re.`ESTADO` IN (".$selected_state_ids.")";
        }

        if(!empty($selected_payment_type) && is_array($selected_payment_type)){
            $selected_payment_type_ids = implode(',', $selected_payment_type);
            $selected_payment_type_ids = rtrim($selected_payment_type_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " re.`ID_FP` IN (".$selected_payment_type_ids.")";
        }

        if(!empty($selected_appointment_date) && is_array($selected_appointment_date)){
            $from = '';
            if(isset($selected_appointment_date['from'])){
                $from = date('Y-m-d', strtotime($selected_appointment_date['from']));
            }
            $to = '';
            if(isset($selected_appointment_date['to'])){
                $to = date('Y-m-d', strtotime($selected_appointment_date['to']));
            }
            if(!empty($from) && !empty($to)){
                if(empty($where)){
                    $where .= " WHERE ";
                }else{
                    $where .= " AND ";
                }
                $where .= " DATE(re.fecha_vto) BETWEEN '".$from."' AND '".$to."' ";
            }
        }

        $query = "SELECT 
                  FLOOR(re.idcliente) AS `client_id`,
                  re.num_recibo AS `doc_id`,
                  DATE(re.fecha_vto) AS `appointment_date`,
                  IF(
                    re.`idtipocliente` = 1,
                    CONCAT(al.sapellidos,', ',al.snombre),
                    cli.`cnomcli`
                  ) AS customer_name,
                  IF(
                    re.idtipocliente = 1,
                    'student',
                    'company'
                  ) AS `customer_type`,
                  re.`ID_FP` `payment_type`,
                  re.concepto AS `service`,
                  ROUND(re.importe, 2) AS `amount`,
                  re.`ESTADO` AS `state`,
                  IF(
                    re.`n_factura` < 1 
                    OR re.`n_factura` IS NULL,
                    'not_invoiced',
                    re.`n_factura`
                  ) AS invoiced,
                  re.idcaja AS `cash_id`";
//        if($memo){
            $query .= ",re.memo AS `comments` ";
//        }
        $query .="       
                FROM
                  recibos AS re 
                  LEFT JOIN alumnos AS al 
                    ON re.idcliente = al.ccodcli 
                  LEFT JOIN clientes AS cli 
                    ON re.idcliente = cli.ccodcli ";

//        if($num_recibo){
//            $query .= " WHERE re.num_recibo='".$num_recibo."'";
//        }
        if(!empty($where)){
            $query .= $where;
        }

        $query .= " ORDER BY 1 DESC;";

        return $this->selectCustom($query);
    }

    public function getListByEnrollId($enroll_id = null){
        if(empty($enroll_id) || !$enroll_id){
            return false;
        }

        $query = "SELECT 
                  rec.num_recibo AS `quote_id`,
                  rec.nummatricula AS `enroll_id`,
                  rec.fecha_vto AS `appointment_date`,
                  rec.concepto AS `service`,
                  rec.neto AS `total`,
                  rec.porcentaje_impuesto `percentage_tax`,
                  rec.impuesto AS `tax`,
                  ROUND(rec.importe, 2) AS `amount`,
                  rec.id_fp AS `payment_type`,
                  IF(
                    rec.`n_factura` < 1 
                    OR rec.`n_factura` IS NULL,
                    'not_invoiced',
                    rec.`n_factura`
                  ) AS invoiced,
                  rec.`ESTADO` AS `state`,
                  IF (rec.idtipocliente = 1, 'S', 'C') as `customer_type_sc`,
                  rec.idtipocliente AS `customer_type`,
                  rec.idcliente AS `customer_id`,
                  rec.referencia AS `reference` 
                FROM
                  recibos AS rec 
                WHERE rec.nummatricula = '".$enroll_id."'
                ORDER BY 3, 1
                ;";
        return $this->selectCustom($query);
    }

    public function getQuoteById($enroll_id, $quote_id, $status = null){
                     $this->db->select('*')
                          ->from($this->table)
                          ->where(array('nummatricula' => $enroll_id, 'num_recibo' => $quote_id));
                          if($status){
                              $this->db->where('ESTADO',  $status);
                          }
        $query = $this->db->get();

        return $query->row();
    }

    public function insertQuote($insert_data){
        return $this->insert($this->table, $insert_data);
    }

    public function getQuotesCountByEnrollId($id){
        $query = $this->db->select(' count(*) AS q_count')
            ->from($this->table)
            ->where('nummatricula', $id)
            ->get();
        return $query->row();
    }


    public function getQuoteIds(){       
        $query = "SELECT 
                  re.num_recibo AS `doc_id`                 
                    FROM
                      recibos AS re;";
        
        return $this->selectCustom($query);
    }    

    //update item
    public function updateItem($data, $item_id = null){
        if(empty($data) || empty($item_id) || !is_numeric($item_id)){
            return false;
        }
        $where = array(
            'num_recibo' => $item_id,
            'ESTADO !=' => 1
        );
        return $this->update($this->table,$data, $where);
    }
    public function add_free_quote($data){
        if(empty($data)){
            return false;
        }
        $insert_data = array();

        $insert_data['n_factura'] = isset($data['n_factura']) ? $data['n_factura'] : 0;
        $insert_data['fecha_vto'] = isset($data['fecha_vto']) ? date('Y-m-d H:i:s', strtotime($data['fecha_vto'])) : date('Y-m-d H:i:s');
        $insert_data['estado'] = isset($data['estado']) ? $data['estado'] : 0;
        $insert_data['neto'] = isset($data['neto']) ? $data['neto'] : 0;
        $insert_data['fecha_fra'] = isset($data['fecha_fra']) ? date('Y-m-d H:i:s', strtotime($data['fecha_fra'])) : date('Y-m-d H:i:s');
        $insert_data['concepto'] = isset($data['concepto']) ? $data['concepto'] : null;
        $insert_data['idtipocliente'] = isset($data['idtipocliente']) ? $data['idtipocliente'] : 1;
        $insert_data['id_fp'] = isset($data['id_fp']) ? $data['id_fp'] : 0;
        $insert_data['idcliente'] = isset($data['idcliente']) ? $data['idcliente'] : null;
        $insert_data['nummatricula'] = isset($data['nummatricula']) ? $data['nummatricula'] : null;
        $insert_data['porcentaje_impuesto'] = isset($data['porcentaje_impuesto']) ? $data['porcentaje_impuesto'] : 0;
        $insert_data['impuesto'] = isset($data['impuesto']) ? $data['impuesto'] : 0;
        $insert_data['importe'] = isset($data['importe']) ? $data['importe'] : 0;
        $insert_data['referencia'] = isset($data['referencia']) ? $data['referencia'] : null;


        return $this->db->insert($this->table, $insert_data);
    }
    
    public function add_free_quote_Batch($insert_data){
        $count_rows = $this->db->insert_batch($this->table, $insert_data);
        $first_id = $first_id = $this->db->insert_id();
        return (object)array('count_rows' => $count_rows, 'first_id' => $first_id);
    }
    public function edit_free_quote($data, $quote_id = null){
        if(empty($data) || empty($quote_id)){
            return false;
        }
        return $this->db->update($this->table, $data, array('NUM_RECIBO'=>$quote_id));
    }
    //delete item
    public function delete_item($item_id = null){
        if(empty($item_id) || !is_numeric($item_id)){
            return false;
        }
        $where = array(
            'num_recibo' => $item_id
        );
        return $this->delete($this->table,$where);
    }
    public function deleteItem($where){       
        return $this->delete($this->table,$where);
    }
    //delete item
    public function check_linked_invoice($item_ids = null){
        if(empty($item_ids)){
            return false;
        }
        $str_ids = implode(',', $item_ids);
        $str_ids = rtrim($str_ids, ',');       
        
        $query = "SELECT IF(n_factura >0,1,0) as num FROM recibos WHERE NUM_RECIBO IN (".$str_ids.");";
        return $this->selectCustom($query);
    }

    public function updateQuotes($quote_id, $enroll_id, $update_data){
        return $this->update($this->table, $update_data, array('num_recibo' => $quote_id, 'nummatricula' => (string)$enroll_id));
    }
    public function get_quotes_by_invoiceId($INVOICE_ID, $quote_id = null){

        if (empty($INVOICE_ID)) {
            return false;
        }

        $query = "SELECT 
                      re.referencia AS `reference`,
                      re.n_factura AS `invoice_id`,
                      re.num_recibo AS `quote_id`,
                      re.concepto AS `description`,
                      re.fecha_vto AS `due_date`,
                      re.id_fp AS `payment_method`,
                      ROUND(re.importe, 3) AS `amount`,
                      re.`ESTADO` AS `state`,
                      re.`neto` AS `total_amount`
                    FROM
                      recibos AS re 
                    WHERE re.n_factura = '".$INVOICE_ID."'";

        if($quote_id){
            $query .= " AND re.num_recibo='".$quote_id."'";
        }

        $query .= " ORDER BY 4,2;";


        return $this->selectCustom($query);
    }

    public function delete_by_invoice_id($invoice_id = null){
        if(empty($invoice_id)){
            return false;
        }
        $query = "DELETE FROM recibos WHERE n_factura = '".$invoice_id."'";
        return $this->db->query($query);
    }
    
    public function unlink_by_invoice_id($invoice_id = null){
        if(empty($invoice_id)){
            return false;
        }
        $query = "UPDATE recibos SET n_factura = NULL WHERE n_factura =  '".$invoice_id."'";
        return $this->db->query($query);
    }

    public function getQuotesDataPrint($QUOTE_ID, $student_id = null){
        $id_is_array = false;
        if(empty($QUOTE_ID)){
            return NULL;
        }
        if(is_array($QUOTE_ID)){
            $id_is_array = true;
        }

        $this->db->select("
                  re.num_recibo AS quote_id,
                  re.referencia AS `reference`,
                  re.n_factura AS `invoice_id`,
                  re.concepto AS `description`,
                  re.fecha_vto AS `due_date`,
                  re.id_fp AS `payment_method`,
                  ROUND(re.importe, 3) AS `amount`,
                  re.`ESTADO` AS `state`,
                  re.`neto` AS `total_amount`,
            
                  IF(re.`IdTipoCliente` =1,
                    (SELECT IF(cnbrbco IS NULL OR cnbrbco = '',CONCAT(snombre,' ',sapellidos),cnbrbco) FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT cnomcli FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_name,
            
                  IF(re.`IdTipoCliente` =1,
                    (SELECT IF(dnititular IS NULL OR dnititular = '',cdnicif,dnititular) FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT cdnicif FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_fiscalcode,
                
                  IF(re.`IdTipoCliente` =1,
                    (SELECT cdomicilio FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT cdomicilio FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_address,
            
                  IF(re.`IdTipoCliente` =1,
                    (SELECT cptlcli FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT cptlcli FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_postalcode,
                    
                  IF(re.`IdTipoCliente` =1,
                    (SELECT cpobcli FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT cpobcli FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_city,
            
                  IF(re.`IdTipoCliente` =1,
                    (SELECT ccodprov FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT ccodprov FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_province,
                    
                  IF(re.`IdTipoCliente` =1,
                    (SELECT CONCAT(ctfo1cli,' ',ctfo2cli,' ',movil) FROM alumnos WHERE ccodcli = re.idcliente),
                    (SELECT CONCAT(ctfo1cli,' ',ctfo2cli,' ',movil) FROM clientes WHERE ccodcli = re.idcliente)
                    ) AS customer_phones ");
                    
        $this->db->from('recibos AS re');
        if($student_id){
            $this->db->where('re.idcliente', $student_id);
        }
        if($id_is_array) {
            $this->db->where_in('re.num_recibo', $QUOTE_ID);
        }else{
            $this->db->where('re.num_recibo', $QUOTE_ID);
        }
        $query = $this->db->get();
        if($id_is_array) {
            return $query->result();
        }else{
            return $query->row();
        }
    }

    public function getQuotesByCashId($cash_id){
        $sql = "SELECT `id`,`description`,`amount`,`customer`,`payment_method`,
                `quote_type`
                
                FROM
                
                (SELECT 
                   DISTINCT re.num_recibo AS id,  IF(re.concepto IS NULL,' cobro alumno',re.concepto) AS `description`,  re.importe AS `amount`,
                   IF(re.idtipocliente=1,CONCAT(sapellidos,', ',al.snombre),cl.cnomcli) AS customer, re.`ID_FP` AS `payment_method`, rech.`timeorder`,
                  '1' AS `quote_type`
                FROM recibos AS re LEFT JOIN estadorecibo AS er ON re.estado = er.idestado
                 LEFT JOIN alumnos AS al ON re.idcliente = al.ccodcli
                 LEFT JOIN clientes AS cl ON re.idcliente = cl.ccodcli
                 LEFT JOIN formaspago AS fp ON re.id_fp = fp.codigo
                 LEFT JOIN recibos_historico AS rech ON re.num_recibo = rech.num_recibo
                LEFT JOIN cajas AS ca ON re.`IdCaja` = ca.`IdCaja`
                 WHERE re.num_recibo IN 
                   (SELECT num_recibo FROM recibos_historico 
                      WHERE fecha = ca.`Fecha`)
                 AND (re.id_fp = 0 OR re.id_fp = 1 OR re.id_fp = 3 )
                 AND (re.idcaja = '".$cash_id."')
                 AND er.idestado=1
                
                UNION
                
                SELECT  
                  ing.idingreso AS id,
                  ing.`Descripcion` AS `description`,
                  ing.`Importe` AS `amount`,
                  '' AS customer,
                  '0' AS `payment_method`,
                  ing.`timeorder`,
                  '2' AS `quote_type`
                
                 FROM ingresos AS ing 
                 WHERE ing.idcaja = '".$cash_id."'
                
                UNION
                
                SELECT  
                  gts.idgasto AS id,
                  gts.`Descripcion` AS `description`,
                  gts.`Importe` AS `amount`,
                  '' AS customer,
                  '0' AS `payment_method`,
                  gts.`timeorder`,
                  '3' AS `quote_type`
                
                 FROM gastos AS gts
                 WHERE gts.idcaja = '".$cash_id."'
                
                 
                ) AS t1
                ORDER BY t1.timeorder
                 
                ;";
        
        return $this->selectCustom($sql);

    }
    public function updateNumFactura ($quote_id){
        $sql = "UPDATE  recibos
        SET  `N_FACTURA` = (SELECT numfactura + 1 FROM variables2)
        WHERE `NUM_RECIBO` =". $quote_id.";";
        return $this->updateCustom($sql);
    }
}
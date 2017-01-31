<?php

class FacturalModel extends MagaModel {


    public function __construct() {
        parent::__construct();
        $this->table = "factural";
    }
    public function get_services($INVOICE_ID){
        $id_is_array = false;
        if (empty($INVOICE_ID)) {
            return false;
        }
        if(is_array($INVOICE_ID)){
            $id_is_array = true;
        }

        $this->db->select("
                    num AS id,
                    referencia AS `reference`,
                    descripcion AS `description`,
                    precio AS `price_by_unit`,
                    unidades AS `units`,
                    importe AS `total_amount`,
                    impuesto AS `percent_vat`,n_factura AS invoice_id");
        $this->db->from($this->table);
        if($id_is_array){
            $this->db->where_in('n_factura', $INVOICE_ID);
        }else{
            $this->db->where('n_factura', $INVOICE_ID);
        }
        $this->db->order_by(3);
        $query = $this->db->get();
        return $query->result();

    }

    public function get_service_by_id($service_id = null){

        if (empty($service_id)) {
            return false;
        }

        $query = "SELECT 
                    num AS id,
                    n_factura AS `invoice_id`,
                    referencia AS `reference`,
                    descripcion AS `description`,
                    precio AS `price_by_unit`,
                    unidades AS `units`,
                    importe AS `total_amount`,
                    impuesto AS `percent_vat`
                    FROM factural
                    WHERE num = '".$service_id."'
                    ORDER BY 3
                    ;";


        return $this->db->query($query)->row();
    }

    public function deleteItem($where){
        return $this->db->delete($this->table, $where);
    }

    public function insertItem($INVOICE_ID, $REFERENCE, $DESCRIPTION, $PRICE, $UNITS, $VAT, $TOTAL_AMOUNT){
        $query =  "INSERT INTO factural
                    (`n_factura`,`referencia`,`descripcion`,`precio`,`unidades`,`impuesto`,`importe`,`idcentro`)
                    VALUES (
                    '". $INVOICE_ID ."','". $REFERENCE ."','". $DESCRIPTION ."','". $PRICE ."','". $UNITS ."','". $VAT ."','". $TOTAL_AMOUNT ."','0'
                    );";
        return $this->db->query($query);
    }

    public function updateItem($data, $where){
        return $this->update($this->table, $data, $where);
    }

    public function insertInvoiceDetal($quote_id){
        $query = " INSERT INTO `factural`
                  (
                  `N_FACTURA`,
                  `Descripcion`,
                  `precio`,
                  `Unidades`,
                  `importe`,
                  `IdDivisa`,
                  `NumMatricula`,
                  `Impuesto`)

              SELECT 
              (SELECT numfactura+1 FROM variables2),
              re.concepto,
              re.`neto`,
              '1',
              re.importe,
              '1',
              re.`NumMatricula`,
              re.`impuesto`
              FROM recibos AS re
              WHERE re.`NUM_RECIBO` = ".$quote_id." ;" ;
        return $this->db->query($query);

    }
}
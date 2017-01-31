<?php

class CajasModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "cajas";
    }

    public function getTotalCount($user_id = null) {
        $this->db->from($this->table);
        if($user_id){
            $this->db->where('id_user', $user_id);
        }
        return $this->db->count_all_results();
    }


    public function getDailyCashListAjax($start, $length, $draw, $search, $order, $columns){
        $where = '';


        $this->db->select(" 
                  SQL_CALC_FOUND_ROWS null AS rows,
                  ca.`IdCaja` AS `cash_id`, 
                DATE(ca.`Fecha`) AS cash_date,
                ca.`Nombre` AS `cash_name`,
                ca.`IdEstado` AS `cash_state`,
                ca.`SaldoInicial` AS `opening_balance`,
                ca.`SaldoFinal` AS `end_balance`,
                us.`Nombre` AS agent", false);
        $this->db->from($this->table.' AS ca');
        $this->db->join('usuarios AS us', 'ca.id_user = us.id', 'left');
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('ca.Nombre', $search['value']);
            $this->db->or_like('ca.Fecha', $search['value']);
            $this->db->or_like('ca.IdCaja', $search['value']);
            $this->db->or_like('ca.SaldoInicial', $search['value']);
            $this->db->or_like('ca.SaldoFinal', $search['value']);
            $this->db->or_like('us.Nombre', $search['value']);
        }
        if(!empty($where)){
           $this->db->where($where);
        }

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = "ca.IdCaja";
                    break;
                case 2:
                    $column = "ca.Fecha";
                    break;
                case 3:
                    $column = "ca.Nombre";
                    break;
                case 4:
                    $column = "ca.IdEstado";
                    break;
                case 5:
                    $column = "ca.SaldoInicial";
                    break;
                case 6:
                    $column = "ca.SaldoFinal";
                    break;
                case 7:
                    $column = "us.Nombre";
                    break;
                case 8:
                default:
                    $column = 1;
                    $column_dir = 'DESC';
            }
            $this->db->order_by($column, $column_dir);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }
    public function getDailyCashByDate($date){
        $this->db->select('IdCaja as cash_id');
        $this->db->where('Fecha', $date);
        $this->db->where('IdEstado', '0');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function getLastEndBalance(){
        $this->db->select('saldofinal as last_end_balance');
        $this->db->from($this->table);
        $this->db->order_by('idcaja');
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->row();
    }
    public function getLastEndBalancebyId($cash_id){
        $this->db->select('saldofinal as last_end_balance');
        $this->db->where('IdCaja', $cash_id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->row();
    }

    public function insertItem($insert_data){
        $this->db->insert($this->table, $insert_data);
        return $this->db->insert_id();
    }
    public function insertIngresos($insert_data){
        $this->db->insert('ingresos', $insert_data);
        return $this->db->insert_id();
    }
    public function insertGastos($insert_data){
        $this->db->insert('gastos', $insert_data);
        return $this->db->insert_id();
    }

    public function updateItem($update_data, $cash_id){
        $this->db->where('IdCaja', $cash_id);
        $this->db->update($this->table, $update_data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function updateIngresos($update_data, $id){
        $this->db->where('IdIngreso', $id);
        $this->db->update('ingresos', $update_data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
        
    }
    public function updateGastos($update_data, $id){
        $this->db->where('IdGasto', $id);
        $this->db->update('gastos', $update_data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function deleteItem($cash_id){
        if($this->db->delete($this->table, array('IdCaja' => $cash_id))) {
            $result = 1;
            $this->db->delete('ingresos', array('IdCaja' => $cash_id));
            $this->db->delete('gastos', array('idcaja' => $cash_id));
            $this->db->where('idcaja', $cash_id);
            $this->db->update('recibos', array('idcaja' => Null));
        }else{
            $result = 0;
        }
        return $result;
    }
    public function deleteIngresos($id){
        $result = $this->db->delete('ingresos', array('idingreso' => $id));
        return $result;
    }
    public function deleteGastos($id){
        $result = $this->db->delete('gastos', array('idgasto' => $id));
        return $result;
    }
    public function closeCurrentCash($id){
        $this->db->where('IdCaja', $id);
        $this->db->update($this->table, array('IdEstado'=>'1'));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function  getCurrentBalance($cash_id){
        $sql = "SELECT SUM(`amount`) as amount

                FROM
                (SELECT 
                   re.importe AS `amount`
                
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
                 AND (re.idcaja = $cash_id)
                 AND er.idestado=1
                
                UNION
                
                SELECT  
                  ing.`Importe` AS `amount`
                
                 FROM ingresos AS ing 
                 WHERE ing.idcaja = $cash_id
                
                UNION
                
                SELECT  
                  0-gts.`Importe` AS `amount`
                
                 FROM gastos AS gts
                 WHERE gts.idcaja = $cash_id
                
                ) AS t1;
                ";
        return $this->runQuery($sql);
    }
}
<?php
/**
 */
class ClientesCouponModel extends MagaModel {


    /**
     * @var int
     */
    public $id;
    
    /**
     * @var string
     */
    public $title;
    
    /**
     * @var double
     */
    public $discount;
    /**
     * @var double
     */
    public $percent_off;
    /**
     * @var string
     */
    public $code;
    
    /**
     * @var string
     */
    public $from;
    
    /**
     * @var string
     */
    public $to;
    
    /**
     * @var int
     */
    public $enabled;
    
    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;

    
    public function __construct() {
        parent::__construct();
        $this->table = "clientes_coupons"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    public function getByKey($key = null) {

        if (!$key) {
            return null;
        }
        $query = "
            SELECT * FROM clientes_akaud AS ca WHERE `key` = '$key';
            ";
        $res = $this->_db->query($query);

        return $res->result();
    }

    public function getByIdCliente($idcliente = null) {

        if (!$idcliente) {
            return null;
        }
        $query = "
            SELECT * FROM clientes_akaud AS ca WHERE `idcliente` = '$idcliente';
            ";
        $res = $this->_db->query($query);

        return $res->result();
    }

    public function getAll($where = null) {
        $this->_db->select("$this->table.*, clientes_akaud.cnomcli as customer_name, clientes_akaud.email as customer_email, clientes_akaud.CTFO1CLI as customer_phone");
        $this->_db->from($this->table);
        $this->_db->join('clientes_akaud', 'clientes_akaud.ccodcli = '.$this->table.'.idcliente', 'left');
        if($where){
            $this->_db->where($where);
        }
        $res = $this->_db->get();
        return $res->result();
    }

    public function addEditCustomer($data = null, $type = 'add') {

        if(empty($data) 
            && $type != 'add'
            && $type != 'edit'){
            return false;
        }

        if($type == 'edit' && !isset($data['db_table_id'])){
            return false;
        }
        
        $add_edit_data = $this->make_customer($data, $type);
        if(empty($add_edit_data)){
            return false;
        }

        $reg_price = 0;
        if (isset($add_edit_data['reg_price'])) {
            $reg_price = $add_edit_data['reg_price'];
            unset($add_edit_data['reg_price']);
        }
        if($type == 'add'){
            $this->_db->insert($this->table, $add_edit_data);
            $user_id_action = $this->_db->insert_id();
//            if($reg_price){               
            
//                $this->load->model('InvoiceModel');
//                $objInvoice = new InvoiceModel();
//                $details = array(
//                    'title' => $this->lang->line('payment_for_reg_memb_type_desc'). $this->lang->line($add_edit_data['membership_type']) . ' ('.$this->lang->line($add_edit_data['membership_interval']).')',
//                    'description' => $this->lang->line('payment_for_reg_on_site_desc'). $this->lang->line($add_edit_data['membership_type']) . ' ('.$this->lang->line($add_edit_data['membership_interval']).')',
//                    'qty' => 1,
//                    'price' => $reg_price,
//                    'membership_plan' => $add_edit_data['membership_plan'],
//                    'purpose' => $objInvoice::PURPOSE_REGISTRATION
//                );
//                $invoice_id = $this->InvoiceModel->createInvoice($user_id_action, $details);
////					redirect(base_url('paymentsystem/invoice/'.$invoice_id));
//                return $invoice_id;
//            }
            return $user_id_action;
        }else if($type == 'edit'){
            $this->_db->where('id', $data['db_table_id']);
            return $this->_db->update($this->table, $add_edit_data);
        }
    }

    private function make_customer($data = null, $type = 'add'){
        
        if(empty($data)){
            return false;
        }
        $result = array();

        if(isset($data['plan'])){
            $plan = $data['plan'];
        }else{
            $plan = 1;
        }
        if(isset($data['membership_interval'])){
            $membership_interval = $data['membership_interval'];
        }else{
            $membership_interval = 'monthly';
        }

        $plan_options = InvoiceModel::get_plan_options($plan, $membership_interval);

        $membership_plan = $plan_options['membership_plan'];
        $membership_type = $plan_options['membership_type'];
        $reg_price = $plan_options['price'];
//        $plan = $plan_options['plan'];

        if($type == 'add'){
            $result = array(
                'idcliente' => isset($data['idcliente']) ? $data['idcliente'] : null,
                'start_date' => isset($data['start_date']) ? date("Y-m-d", strtotime($data['start_date'])) : null,
                'end_date' => isset($data['end_date']) ? date("Y-m-d", strtotime($data['end_date'])) : null,
                'DBHost_IPserver' => isset($data['DBHost_IPserver']) ? $data['DBHost_IPserver'] : null,
                'DBHost_port' => isset($data['DBHost_port']) ? $data['DBHost_port'] : null,
                'DBHost_user' => isset($data['DBHost_user']) ? $data['DBHost_user'] : null,
                'DBHost_pwd' => isset($data['DBHost_pwd']) ? $data['DBHost_pwd'] : null,
                'DBHost_db' => isset($data['DBHost_db']) ? $data['DBHost_db'] : null,
                'key' => isset($data['key']) ? $data['key'] : null,
                'plan' => isset($data['plan']) ? $data['plan'] : null,
                'concurrent_users' => !empty($data['concurrent_users']) ? $data['concurrent_users'] : 1,
                'trial_expire' => !empty($data['trial_expire']) ? $data['trial_expire'] : date('Y-m-d', strtotime("+14 days")),
                'module_campus_teachers_active' => !empty($data['module_campus_teachers_active']) ? $data['module_campus_teachers_active'] : 0,
                'module_campus_teachers_max_users' => !empty($data['module_campus_teachers_max_users']) ? $data['module_campus_teachers_max_users'] : 0,
                'module_campus_teachers_expire' => !empty($data['module_campus_teachers_expire']) ? $data['module_campus_teachers_expire'] : null,
                'module_campus_students_active' => !empty($data['module_campus_students_active']) ? $data['module_campus_students_active'] : 0,
                'module_campus_students_max_users' => !empty($data['module_campus_students_max_users']) ? $data['module_campus_students_max_users'] : 0,
                'module_campus_students_expire' => !empty($data['module_campus_students_expire']) ? $data['module_campus_students_expire'] : null,
                'module_campus_companies_active' => !empty($data['module_campus_companies_active']) ? $data['module_campus_companies_active'] : 0,
                'module_campus_companies_max_users' => !empty($data['module_campus_companies_max_users']) ? $data['module_campus_companies_max_users'] : 0,
                'module_campus_companies_expire' => !empty($data['module_campus_companies_expire']) ? $data['module_campus_companies_expire'] : null,
                'emails_limit_daily' => !empty($data['emails_limit_daily']) ? $data['emails_limit_daily'] : 10,
                'emails_limit_monthly' => !empty($data['emails_limit_monthly']) ? $data['emails_limit_monthly'] : 300,
                'space_limit' => !empty($data['space_limit']) ? $data['space_limit'] : 209715200,
                'records_limit' => !empty($data['records_limit']) ? $data['records_limit'] : 5000,
                'active' => !empty($data['active']) ? $data['active'] : 0,
                'paid' => !empty($data['paid']) ? $data['paid'] : 0,
                'membership_plan' => $membership_plan,
                'membership_type' => $membership_type,
                'membership_interval' => !empty($data['membership_interval']) ? $data['membership_interval'] : 'monthly',
            );
        }elseif($type == 'edit'){
            if(isset($data['idcliente'])){
                $result['idcliente'] = $data['idcliente'];
            }
            if(isset($data['start_date'])){
                $result['start_date'] = date("Y-m-d", strtotime($data['start_date']));
            }
            if(isset($data['end_date'])){
                $result['end_date'] = date("Y-m-d", strtotime($data['end_date']));
            }
            if(isset($data['DBHost_IPserver'])){
                $result['DBHost_IPserver'] = $data['DBHost_IPserver'];
            }
            if(isset($data['DBHost_port'])){
                $result['DBHost_port'] = $data['DBHost_port'];
            }
            if(isset($data['DBHost_user'])){
                $result['DBHost_user'] = $data['DBHost_user'];
            }
            if(isset($data['DBHost_pwd'])){
                $result['DBHost_pwd'] = $data['DBHost_pwd'];
            }
            if(isset($data['DBHost_db'])){
                $result['DBHost_db'] = $data['DBHost_db'];
            }
            if(isset($data['key'])){
                $result['key'] = $data['key'];
            }
            if(isset($data['paid'])){
                $result['paid'] = $data['paid'];
            }
            if(isset($data['plan'])){
                $result['plan'] = $data['plan'];                
                $result['membership_interval'] = isset($data['membership_interval']) ? $data['membership_interval'] : 'monthly';
                $result['membership_plan'] = $membership_plan;
                $result['membership_type'] = $membership_type;
            }
            if(isset($data['concurrent_users'])){
                $result['concurrent_users'] = $data['concurrent_users'];
            }

            $result['trial_expire'] = !empty($data['trial_expire']) ? $data['trial_expire'] : date('Y-m-d', strtotime("+14 days"));

            if(isset($data['module_campus_teachers_active'])){
                $result['module_campus_teachers_active'] = $data['module_campus_teachers_active'];
            }
            if(isset($data['module_campus_teachers_max_users'])){
                $result['module_campus_teachers_max_users'] = $data['module_campus_teachers_max_users'];
            }
            if(isset($data['module_campus_teachers_expire'])){
                $result['module_campus_teachers_expire'] = $data['module_campus_teachers_expire'];
            }
            if(isset($data['module_campus_students_active'])){
                $result['module_campus_students_active'] = $data['module_campus_students_active'];
            }
            if(isset($data['module_campus_students_max_users'])){
                $result['module_campus_students_max_users'] = $data['module_campus_students_max_users'];
            }
            if(isset($data['module_campus_students_expire'])){
                $result['module_campus_students_expire'] = $data['module_campus_students_expire'];
            }
            if(isset($data['module_campus_companies_active'])){
                $result['module_campus_companies_active'] = $data['module_campus_companies_active'];
            }
            if(isset($data['module_campus_companies_max_users'])){
                $result['module_campus_companies_max_users'] = $data['module_campus_companies_max_users'];
            }
            if(isset($data['module_campus_companies_expire'])){
                $result['module_campus_companies_expire'] = $data['module_campus_companies_expire'];
            }
            if(isset($data['emails_limit_daily'])){
                $result['emails_limit_daily'] = $data['emails_limit_daily'];
            }
            if(isset($data['emails_limit_monthly'])){
                $result['emails_limit_monthly'] = $data['emails_limit_monthly'];
            }
            if(isset($data['space_limit'])){
                $result['space_limit'] = $data['space_limit'];
            }
            if(isset($data['records_limit'])){
                $result['records_limit'] = $data['records_limit'];
            }
            if(isset($data['active'])){
                $result['active'] = $data['active'];
            }                
        }

        $result['reg_price'] = $reg_price;
        
        return $result;
    }
    
    public function deleteItem($where = null){
        if(empty($where)){
            return false;
        }      
        return $this->_db->delete($this->table, $where);
    }
    public function updateItem($data = array(), $where = null){
        if(empty($data) || empty($where)){
            return false;
        }      
        return $this->_db->update($this->table, $data, $where);
    }
    
    public function downgrade_plan_free($free_plan_data){
        if(empty($free_plan_data)){
            return false;
        }
        $this->_db->where('plan !=', 1);
        $this->_db->where('paid =', 0);
        $this->_db->where('(DATEDIFF(trial_expire, now()) <= 0 OR trial_expire IS NULL)');        
     
        return $this->_db->update($this->table, $free_plan_data);
    }
}
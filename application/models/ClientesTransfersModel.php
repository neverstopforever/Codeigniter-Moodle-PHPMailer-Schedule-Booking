<?php
/**
 *@property CouponModel $CouponModel
 *@property ClientesAkaudModel $ClientesAkaudModel
 */
class ClientesTransfersModel extends MagaModel {
    /**
     * Price in cents
     */
    const REGISTRATION_PRICE = 100;
    const REGISTRATION_PRICE_FREE = 0;
    const MEMBERSHIP_PLAN_FREE = 'FREE';
    const MEMBERSHIP_TYPE_FREE = 'FREE';

    const REGISTRATION_PRICE_STARTER = 1200;
    const MEMBERSHIP_PLAN_STARETR = 'S1';
    const REGISTRATION_PRICE_STARETR_YEARLY = 12000; //???
    const MEMBERSHIP_PLAN_STARETR_YEARLY= 'S2';
    const MEMBERSHIP_TYPE_STARETR = 'Starter';

    const REGISTRATION_PRICE_BASIC = 2900;
    const MEMBERSHIP_PLAN_BASIC = 'B1';
    const REGISTRATION_PRICE_BASIC_YEARLY = 29000; //???
    const MEMBERSHIP_PLAN_BASIC_YEARLY = 'B2';
    const MEMBERSHIP_TYPE_BASIC = 'Basic';


    const REGISTRATION_PRICE_ADVANCED = 4900;
    const MEMBERSHIP_PLAN_ADVANCED = 'A1';
    const REGISTRATION_PRICE_ADVANCED_YEARLY = 49000; //???
    const MEMBERSHIP_PLAN_ADVANCED_YEARLY = 'A2';
    const MEMBERSHIP_TYPE_ADVANCED = 'Advanced';

    const REGISTRATION_PRICE_CORPORATE = 6900;
    const MEMBERSHIP_PLAN_CORPORATE = 'C1';
    const REGISTRATION_PRICE_CORPORATE_YEARLY = 69000; //???
    const MEMBERSHIP_PLAN_CORPORATE_YEARLY = 'C2';
    const MEMBERSHIP_TYPE_CORPORATE = 'Corporate';

    const PURPOSE_REGISTRATION = 1;
    const PURPOSE_UPGRADE_MEMBERSHIP = 2;

    //paypal constants
    const REGISTRATION_PRICE_STARTER_PAYPAL = 1200;
    const MEMBERSHIP_PLAN_STARTER_PAYPAL = "P-61J95127AA5458455YTKRQMY"; //??? live site sandbox
    const REGISTRATION_PRICE_STARTER_PAYPAL_YEARLY = 12000;
    const MEMBERSHIP_PLAN_STARTER_PAYPAL_YEARLY = "P-61J95127AA5458455YTKRQMY"; //??? live site sandbox

    const REGISTRATION_PRICE_BASIC_PAYPAL = 2900;
    const MEMBERSHIP_PLAN_BASIC_PAYPAL = "P-2H426529RR359060TYTJZYTA"; //??? live site sandbox
    const REGISTRATION_PRICE_BASIC_PAYPAL_YEARLY = 29000;
    const MEMBERSHIP_PLAN_BASIC_PAYPAL_YEARLY  = "P-2H426529RR359060TYTJZYTA"; //??? live site sandbox

    const REGISTRATION_PRICE_ADVANCED_PAYPAL = 4900;
    const MEMBERSHIP_PLAN_ADVANCED_PAYPAL = "P-61J95127AA5458455YTKRQMY"; //??? live site sandbox
    const REGISTRATION_PRICE_ADVANCED_PAYPAL_YEARLY  = 49000;
    const MEMBERSHIP_PLAN_ADVANCED_PAYPAL_YEARLY  = "P-61J95127AA5458455YTKRQMY"; //??? live site sandbox

    const REGISTRATION_PRICE_CORPORATE_PAYPAL = 6900;
    const MEMBERSHIP_PLAN_CORPORATE_PAYPAL = "P-2H426529RR359060TYTJZYTA"; //??? live site sandbox
    const REGISTRATION_PRICE_CORPORATE_PAYPAL_YEARLY  = 69000;
    const MEMBERSHIP_PLAN_CORPORATE_PAYPAL_YEARLY  = "P-2H426529RR359060TYTJZYTA"; //??? live site sandbox

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $client_id;

    /**
     * @var int
     */
    public $coupon_id;

    /**
     * @var array
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $qty;

    /**
     * Price in cents
     * @var int
     */
    public $price;

    /**
     * @var boolean
     */
    public $paid;

    /**
     * @var boolean
     */
    public $membership_plan;

    /**
     * @var int
     */
    public $purpose;

    /**
     * @var int
     */
    public $created_at;

    /**
     * @var int
     */
    public $updated_at;

    public $before_create = array( 'beforeCreate' );
    public $before_update = array( 'beforeUpdate' );
    

    public function __construct(){
        parent::__construct();

        $this->table = "clientes_transfers"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);

        $this->load->model('ClientesAkaudModel');
        $this->load->model('CouponModel');
    }


    public function beforeCreate()
    {
        $this->paid = false;
    }

    public function beforeUpdate()
    {
        $this->updated_at = time();
    }

    public function getOwner()
    {
        if (!$this->owner_id) {
            return false;
        }
        $user = $this->ClientesAkaudModel->getAll(array('id'=>$this->owner_id));
        
        return isset($user[0])? $user[0] : false;
    }

    public function getCoupon($coupon_id = null)
    {
        if (!$coupon_id) {
            return false;
        }

        return $this->CouponModel->findById($coupon_id);
    }

    /**
     * Create an invoice
     *
     * createInvoice('user-id', array(
     *     'title' => 'Title',
     *     'description' => 'Description',
     *     'qty' => 1,
     *     'price' => 100000, // in cents
     *     'purpose' => Invoices::PURPOSE_REGISTRATION
     * ));
     *
     * @param string $userId
     * @param array[] $details is valid: title, description, qty, price
     * @return bool|Invoices
     */
    public function createInvoice($userId, $details)
    {
        $data_array = array(
            'owner_id' =>$userId,
            'title' =>$details['title'],
            'description' =>$details['description'],
            'qty' =>$details['qty'],
            'price' =>$details['price'],
            'purpose' =>$details['purpose']
        );
        if(isset($details['membership_plan'])){
            $data_array['membership_plan'] = $details['membership_plan'];
        }
        $data_array['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data_array);
        return $this->db->insert_id();
    }
    
    public static function get_plan_options($plan = 1, $membership_interval = "monthly"){
        
        $membership_plan = self::MEMBERSHIP_PLAN_FREE;
        $membership_type = self::MEMBERSHIP_TYPE_FREE;
        $reg_price = self::REGISTRATION_PRICE_FREE;
        $yearly = false;
        if($membership_interval == 'yearly'){
            $yearly = true;
        }
        switch ($plan){
            case 2:
                $reg_price = self::REGISTRATION_PRICE_STARTER;
                $membership_plan = self::MEMBERSHIP_PLAN_STARETR;
                if ($yearly) {
                    $reg_price = self::REGISTRATION_PRICE_STARETR_YEARLY;
                    $membership_plan = self::MEMBERSHIP_PLAN_STARETR_YEARLY;
                }
                $membership_type = self::MEMBERSHIP_TYPE_STARETR;
                break;
            case 3:
                $reg_price = self::REGISTRATION_PRICE_BASIC;
                $membership_plan = self::MEMBERSHIP_PLAN_BASIC;
                if ($yearly) {
                    $reg_price = self::REGISTRATION_PRICE_BASIC_YEARLY;
                    $membership_plan = self::MEMBERSHIP_PLAN_BASIC_YEARLY;
                }
                $membership_type = self::MEMBERSHIP_TYPE_BASIC;
                break;
            case 4:
                $reg_price = self::REGISTRATION_PRICE_ADVANCED;
                $membership_plan = self::MEMBERSHIP_PLAN_ADVANCED;
                if ($yearly) {
                    $reg_price = self::REGISTRATION_PRICE_ADVANCED_YEARLY;
                    $membership_plan = self::MEMBERSHIP_PLAN_ADVANCED_YEARLY;
                }
                $membership_type = self::MEMBERSHIP_TYPE_ADVANCED;
                break;
            case 5:
                $reg_price = self::REGISTRATION_PRICE_CORPORATE;
                $membership_plan = self::MEMBERSHIP_PLAN_CORPORATE;
                if ($yearly) {
                    $reg_price = self::REGISTRATION_PRICE_CORPORATE_YEARLY;
                    $membership_plan = self::MEMBERSHIP_PLAN_CORPORATE_YEARLY;
                }
                $membership_type = self::MEMBERSHIP_TYPE_CORPORATE;
                break;
        }

        $plan_options = array(
            'plan' => $plan,
            'price' => $reg_price,
            'membership_plan' => $membership_plan,
            'membership_type' => $membership_type,
            'membership_interval' => $membership_interval
        );
        return $plan_options;
    }
    
    public static function get_plan($membership_plan = "FREE") {
        $plan = 1; //FREE
        if(!empty($membership_plan)){
            switch ($membership_plan){
                case self::MEMBERSHIP_PLAN_STARETR: //Starter monthly
                    $plan = 2;
                    break;
                case self::MEMBERSHIP_PLAN_STARETR_YEARLY: //Starter yearly
                    $plan = 2;
                    break;
                case self::MEMBERSHIP_PLAN_BASIC: //Basic monthly
                    $plan = 3;
                    break;
                case self::MEMBERSHIP_PLAN_BASIC_YEARLY: //Basic yearly
                    $plan = 3;
                    break;
                case self::MEMBERSHIP_PLAN_ADVANCED: //Advanced monthly
                    $plan = 4;
                    break;
                case self::MEMBERSHIP_PLAN_ADVANCED_YEARLY: //Advanced yearly
                    $plan = 4;
                    break;
                case self::MEMBERSHIP_PLAN_CORPORATE: //Corporate monthly
                    $plan = 5;
                    break;
                case self::MEMBERSHIP_PLAN_CORPORATE_YEARLY: //Corporate yearly
                    $plan = 5;
                    break;
            }

        }
        return $plan;
    }
    
    public function get_all(){
        return $this->findAll();
    }


    public function updateItem($data, $where){
        return $this->update($this->table, $data, $where);
    }

    public function insertItem($data){
        return $this->insert($this->table, $data);
    }

    public function deleteItem($where){        
        return $this->delete($this->table, $where);
    }
    
    public function get_owner_items($owner_id = null, $paid = null){
        if(!$owner_id){
            return null;
        }
        $this->db->select(
            $this->table.'.*, 
            clientes_coupons.code as coupon_code,  
            clientes_coupons.discount as coupon_discount,
            clientes_coupons.percent_off as coupon_percent_off,
            clientes_coupons.title as coupon_title
            ');
        $this->db->from($this->table);
        $this->db->join('clientes_used_coupons', $this->table.'.coupon_id = clientes_used_coupons.coupon_id AND '. $this->table.'.owner_id = clientes_used_coupons.owner_id', 'left');
        $this->db->join('clientes_coupons', 'clientes_used_coupons.coupon_id = clientes_coupons.id', 'left');
        $where = array();
        if($owner_id){
          $where[$this->table.'.owner_id'] = $owner_id;
        }

        if($paid !== null){
            $where[$this->table.'paid'] = $paid;
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        return $this->db->get()->result();
    }

    public function check_no_paid_items($owner_id){
        if(!$owner_id){
            return null;
        }
        $this->db->from($this->table);
        $where['owner_id'] = $owner_id;
        $where['paid'] = 0;
        $this->db->where($where);
        
        $query = $this->db->get();
        $rowcount = $query->num_rows();

        if($rowcount > 0){
            return true;
        }
        return false;
    }
    
    public function getItemsByTags($tags, $owner_id = null){

        $where = '';

        $selected_invoice_id = isset($tags['selected_invoice_id']) ? $tags['selected_invoice_id']: null;
        $selected_state = isset($tags['selected_state']) ? $tags['selected_state']: null;
        $selected_date = isset($tags['selected_date']) ? $tags['selected_date']: null;

        if(!empty($selected_invoice_id) && is_array($selected_invoice_id)){
            $selected_invoice_ids = implode(',', $selected_invoice_id);
            $selected_invoice_ids = rtrim($selected_invoice_ids, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " i.id IN (".$selected_invoice_ids.")";
        }


        if(!empty($selected_state) && is_array($selected_state)){
            $paid_values = implode(',', $selected_state);
            $paid_values = rtrim($paid_values, ',');
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " i.paid IN (".$paid_values.")";
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
                $where .= " DATE(i.created_at) BETWEEN '".$from."' AND '".$to."' ";
            }
        }

        $query = "SELECT i.*, co.code as coupon_code,  
            co.discount as coupon_discount,
            co.percent_off as coupon_percent_off,
            co.title as coupon_title 
            
                FROM
                  clientes_invoices AS i 
                  LEFT JOIN clientes_used_coupons as uc ON i.coupon_id = uc.coupon_id AND i.owner_id = uc.owner_id 
                  LEFT JOIN clientes_coupons as co ON uc.coupon_id = co.id
                  ";

        if($owner_id !== null){
            if(empty($where)){
                $where .= " WHERE ";
            }else{
                $where .= " AND ";
            }
            $where .= " i.owner_id ='".$owner_id."'";
        }

        if(!empty($where)){
            $query .= $where;
        }

        $query .= " ORDER BY 1 DESC;";

        return $this->selectCustom($query);

    }
}
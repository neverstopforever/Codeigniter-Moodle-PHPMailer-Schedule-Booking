<?php

class CouponModel extends MagaModel
{
    public function __construct(){
        parent::__construct();
        $this->table = "clientes_coupons"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * Discount
     * @var int
     */
    public $discount;
    
    /**
     * Discount in percent
     * @var int
     */
    public $percent_off;

    /**
     * Coupon code
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
     * @var string
     */
    public $duration;

    /**
     * @var int
     */
    public $duration_in_months;

    /**
     * @var int
     */
    public $max_redemptions;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var boolean
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

    public $before_create = array( 'beforeCreate' );
//    public $before_update = array( 'beforeUpdate' );
    public $before_save = array( 'beforeSave' );

    public function beforeCreate()
    {
        $this->code = $this->generateCoupon();
    }

    public function beforeSave()
    {
        if (!is_int($this->from)) {
            $this->from = strtotime($this->from);
        }

        if (!is_int($this->to)) {
            $this->to = strtotime($this->to);
        }

        $this->enabled = isset($_POST['enabled']);
    }


    public function generateCoupon()
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $res = '';

        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        return $res;
    }

    public function getCoupon($couponCode){
        $sql = "SELECT * FROM `clientes_coupons` WHERE `enabled`=1 AND `code`='{$couponCode}' AND `from` <= NOW() AND `to` >= NOW() ORDER BY `created_at` ASC LIMIT 1";
        $result = $this->db->query($sql);
        return $result->row();
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
}
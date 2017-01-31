<?php


class UsedCouponsModel extends MagaModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "clientes_used_coupons"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
    }

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $coupon_id;

    /**
     * @var int
     */
    public $owner_id;

    /**
     * @var int
     */
    public $created_at;

    public $before_create = array( 'beforeCreate' );

    public function beforeCreate()
    {
//        $this->created_at = time();
    }

    /**
     * @param int $ownerId
     * @param int $couponId
     * @return bool
     */
    public function used($ownerId, $couponId)
    {
        $sql = "SELECT count(*) as used_count FROM `clientes_used_coupons` WHERE `owner_id` = {$ownerId} AND `coupon_id` = {$couponId}";       
        $result = $this->db->query($sql);
        $used_count_result = $result->row();
        $count = $used_count_result->used_count;
        return $count > 0;
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
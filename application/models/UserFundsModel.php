<?php

class UserFundsModel extends MagaModel
{
    public function __construct(){
        parent::__construct();
        $this->table = "clientes_user_funds"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->db = $this->load->database($this->_db_name, true);
        
        $this->load->model('ClientesAkaudModel');
    }

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $owner_id;

    /**
     * Funds in cents
     * @var int
     */
    public $amount;

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

    public function beforeCreate()
    {
        $profile = $this->ci->session->userdata('auth-identity');

        $this->owner_id = $profile['user_id'];

        $this->amount = floatval($this->amount);
    }

    public function beforeUpdate()
    {
        $this->updated_at = time();

        $this->amount = floatval($this->amount);
    }

    public function getOwner()
    {
        if (!$this->owner_id) {
            return false;
        }

        $user = $this->ClientesAkaudModel->getAll(array('id'=>$this->owner_id));
        return isset($user[0])? $user[0] : false;
    }
}
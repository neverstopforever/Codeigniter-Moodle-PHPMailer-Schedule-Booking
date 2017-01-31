<?php

class ErpEmailModel extends MagaModel {

    public $id;
    public $from_userid;
    public $id_campaign;
    public $email_recipie;
    public $Subject;
    public $Body;
    public $date;
    public $sucess;
    public $error_msg;
    public $from_usertype;

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails";
    }
    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function  getAll(){
        return $this->selectAll($this->table);
    }


    public function addEmail($data = null) {

        if(empty($data) || !isset($data['from_userid']) || empty($data['from_userid'])
            || !isset($data['id_campaign']) || empty($data['id_campaign'])
            || !isset($data['email_recipie']) || empty($data['email_recipie'])
            || !isset($data['Subject']) || empty($data['Subject'])
            || !isset($data['date']) || empty($data['date'])
        ){

            return false;
        }

        return $this->insert($this->table, $data);

    }

    public function insertEmailData($data){
        return $this->insert($this->table, $data);
    }

    public function getEmailsCountDay($user_id = null){
        $query = $this->db->select("COUNT(*) AS count_daily, (SELECT COUNT(*) FROM erp_emails  WHERE sucess='1' AND MONTH(date) = MONTH(CURDATE())) AS count_monthly, ")
                          ->select("(SELECT COUNT(*) FROM erp_emails  WHERE  sucess='0' AND MONTH(date) = MONTH(CURDATE())) AS count_monthly_not_sent, ")
                          ->select("(SELECT COUNT(*) FROM erp_emails  WHERE  sucess='0' AND DATE(date) = CURDATE()) AS count_daily_not_sent ")
                          ->from($this->table)
                         // ->where('from_userid' ,$user_id)
                          ->where('sucess', '1')
                          ->where('DATE(date) = CURDATE()')
                          ->get();

        return $query->row();
    }

    public function getEmailsByPeriod($start_date, $end_date){
        $query = $this->db->select("DISTINCT DATE(er_em.date) AS date, (SELECT COUNT(*) FROM $this->table WHERE sucess=1 AND DATE(date) = DATE(er_em.date) ) AS distance ")
                          ->select(", (SELECT COUNT(*) FROM $this->table WHERE sucess=0 AND DATE(date) = DATE(er_em.date) ) AS not_sent ")
                          ->from($this->table.' AS er_em')
                          //->join($this->table.' AS j_er_em', ' DATE(j_er_em.date) = DATE(er_em.date)','inner')
                          ->where("DATE(er_em.date) >= DATE('".$start_date."') AND DATE(er_em.date) <= DATE('".$end_date."') ")
                          ->get();

        return $query->result();
    }

    public function getNotSentEmails($user_id){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('from_userid', $user_id)
                          ->where('sucess', '0')
                          ->get();

        return $query->result();
    }

}
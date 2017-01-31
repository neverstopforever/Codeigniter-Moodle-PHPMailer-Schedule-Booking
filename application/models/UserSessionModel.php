<?php

class UserSessionModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "user_session";
    }

    public function userLastActivity($user_id = null, $is_online = 1, $update_insert = true){

        if(empty($user_id)){
            return false;
        }
        $ip_address = getUserIP();
        $data = array(
            'ip_address' => $ip_address,
            'timestamp' => time(),
            'is_online' => $is_online
        );
        if($update_insert){ //update the activity
            $where = array('user_id'=>$user_id);
            return $this->update($this->table, $data, $where);
        }elseif($update_insert == false){ //insert the new activity
           $data['user_id'] = $user_id;
           return $this->insert($this->table, $data);
        }
        return false;
    }

    public function getActivity($user_id = null){
        if(!$user_id){
            return null;
        }
        $data = array(
            'user_id' => $user_id
        );

        return $this->selectAllWhere($this->table, $data);
    }

    public function checkOnlineUser($user_id = null){
        if(!$user_id){
            return false;
        }
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('is_online', 1);
        $this->db->where('`user_session`.`timestamp` >',time() - 300);
        $this->db->get();
//        $str =$this->db->last_query();
//        printr($str);die;
        return $this->db->affected_rows();
    }
}
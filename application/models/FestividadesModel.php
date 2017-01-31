<?php

class FestividadesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "festividades";
    }

   public function getHolidaysBydate($date_where_in){
       if(empty($date_where_in)){
           return false;
       }
       $query = $this->db->select('*')
                         ->from($this->table)
                         ->where_in('DATE_FORMAT(Fecha,"%Y-%m-%d")', $date_where_in)
                         ->get();

       return $query->result();
   }



}
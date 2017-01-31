<?php

class ErpEventoModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_eventos";
    }

    public function getLastItems($limit = 5) {

        $query = 'SELECT * FROM `erp_eventos`
                        ORDER BY `event_date` DESC';

        $query .=  ' LIMIT '.$limit.';';

        return $this->selectCustom($query);
    }

    public function getItems($events_type = 'public',  $limit = null, $show_more = 1) {

        $query = 'SELECT * FROM `erp_eventos`';

        if($events_type == 'internal'){
            $query .= " WHERE `public`!='1'";
        }else if($events_type == 'public'){
            $query .= " WHERE `public`='1'";
        }

        $query .= ' ORDER BY `event_date` DESC ';

        if($limit){
            $query .= " LIMIT ".$limit;
            if($show_more > 1){
                $offset = $show_more * $limit - $limit;
                $query .= " OFFSET ".$offset.";";
            }else{
                $query .= ";";
            }
        }else{
            $query .= ";";
        }

        return $this->selectCustom($query);
    }

    public function getItemById($id = null) {

        if(!$id){
            return null;
        }
        $query = "SELECT * FROM `erp_eventos` WHERE `id`='".$id."';";

        return $this->selectCustom($query);
    }

    public function insertItem($data = null) {

        if( !isset($data['public'])
            || !isset($data['title'])
            || !isset($data['content'])
            || !isset($data['event_date'])
        ){
            return false;
        }

        $event_date = $data['event_date'];
        $event_date = date("Y-m-d H:i:s", strtotime($event_date));
        $title = $data['title'];
        $content = $data['content'];
        $public = $data['public'];
        $query = "
            INSERT INTO `erp_eventos`
                ( `event_date`,`title`, `content`, `public`)
              VALUES ('$event_date', '$title', '$content', '$public');
        ";

        return $this->insertCustom($query);
    }


    public function getCountRecentEvents(){

        $query = "SELECT COUNT(*) AS recent_events
                       FROM erp_eventos
                       WHERE YEAR(event_date) = YEAR(CURDATE())
                             AND MONTH(event_date) = MONTH(CURDATE());";

        return $this->selectCustom($query);
    }
}
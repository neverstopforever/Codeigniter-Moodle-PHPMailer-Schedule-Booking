<?php

class MensajeModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "mensajes";
    }


    public function getInbox($teacher_id, $limit = null, $show_more = 1) {

        $query = "SELECT
                        CASE
                        me.fromtype
                        WHEN '0'
                        THEN IF((SELECT COUNT(*) FROM usuarios WHERE id = me.fromid AND nombre IS NOT NULL) =0,'Staff',(SELECT nombre FROM usuarios WHERE id = me.fromid))
                        WHEN '1'
                        THEN (SELECT nombre FROM profesor WHERE indice = me.fromid)
                        WHEN '2'
                        THEN (SELECT cnomcli FROM alumnos WHERE ccodcli = me.fromid)
                        END AS `from_user_name`,

                        CASE
                        me.fromtype
                        WHEN '0'
                        THEN (SELECT foto FROM usuarios WHERE id = me.fromid)
                        WHEN '1'
                        THEN (SELECT foto FROM profesor WHERE indice = me.fromid)
                        WHEN '2'
                        THEN (SELECT foto FROM alumnos WHERE ccodcli = me.fromid)
                        END AS `from_user_photo`,

                        me.`subject`,
                        me.`body`,
                        me.`maildate`,
                        me.`Read`,
                        me.`id`,
                        CASE
                        me.fromtype
                        WHEN '0'
                        THEN 'school'
                        WHEN '1'
                        THEN 'teacher'
                        WHEN '2'
                        THEN 'student'
                        END AS roletype
                        FROM
                        mensajes AS me
                        WHERE me.`ToType` = '1'
                        AND me.`ToId` = '".$teacher_id."'
                        ORDER BY me.`maildate` DESC
                        ";

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

    public function getOutbox($teacher_id, $limit = null, $show_more = 1) {

        $query = "SELECT
                        CASE
                        me.totype
                        WHEN '0'
                        THEN IF((SELECT COUNT(*) FROM usuarios WHERE id = me.toid AND nombre IS NOT NULL) =0,'Staff',(SELECT nombre FROM usuarios WHERE id = me.toid))
                        WHEN '1'
                        THEN (SELECT nombre FROM profesor WHERE indice = me.toid)
                        WHEN '2'
                        THEN (SELECT cnomcli FROM alumnos WHERE ccodcli = me.toid)
                        END AS `to_user_name`,

                        CASE
                        me.totype
                        WHEN '0'
                        THEN (SELECT foto FROM usuarios WHERE id = me.toid)
                        WHEN '1'
                        THEN (SELECT foto FROM profesor WHERE indice = me.toid)
                        WHEN '2'
                        THEN (SELECT foto FROM alumnos WHERE ccodcli = me.toid)
                        END AS `to_user_photo`,

                        me.`subject`,
                        me.`body`,
                        me.`maildate`,
                        me.`Read`,
                        me.`id`,
                        CASE
                        me.totype
                        WHEN '0'
                        THEN 'school'
                        WHEN '1'
                        THEN 'teacher'
                        WHEN '2'
                        THEN 'student'
                        END AS roletype
                        FROM
                        mensajes AS me
                        WHERE me.`fromType` = '1'
                        AND me.`fromId` = '".$teacher_id."'
                        ORDER BY me.`maildate` DESC
                        ";
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


    public function getNumMessages($teacher_id){

        $query = "SELECT COUNT(*) AS num_messages
                   FROM mensajes
                   WHERE `totype` = '1' AND `toid` = '".$teacher_id."';";

        return $this->selectCustom($query);
    }
     public function getNewMessages($user_id, $user_role){
         $query = $this->db->select('count(*) AS num')
                           ->from($this->table)
                           ->where(array('`totype`' => $user_role, '`toid`' => $user_id, 'read' => '0'))
                           ->get();

         return $query->row();
     }

    public function insert_msg($from_id, $data = array()){

        if(!isset($from_id)
            || !isset($data['to'])
            || !isset($data['totype'])
            || !isset($data['subject'])
            || !isset($data['message'])
        ){
            return false;
        }
        $fromType = 1;

        $toId = $data['to'];
        $toType = $data['totype'];
        $subject = $data['subject'];
        $body = $data['message'];
        $maildate = date('Y-m-d H:i:s', time());
        $read = 0;
        $query = "
            INSERT INTO `mensajes`
                ( `FromId`,`FromType`, `ToId`, `ToType`, `Subject`, `Body`, `Maildate`, `Read`)
              VALUES ('$from_id', '$fromType', '$toId', '$toType','$subject', '$body', '$maildate', '$read');
        ";

        return $this->insertCustom($query);
    }

    public function insert_student_msg($from_id, $data = array()){
        if(!isset($from_id)
            || !isset($data['to'])
            || !isset($data['totype'])
            || !isset($data['subject'])
            || !isset($data['message'])
        ){
            return false;
        }
        $fromType = 2;

        $toId = $data['to'];
        $toType = $data['totype'];
        $subject = $data['subject'];
        $body = $data['message'];
        $maildate = date('Y-m-d H:i:s', time());
        $read = 0;
        $query = "
            INSERT INTO `mensajes`
                ( `FromId`,`FromType`, `ToId`, `ToType`, `Subject`, `Body`, `Maildate`, `Read`)
              VALUES ('$from_id', '$fromType', '$toId', '$toType','$subject', '$body', '$maildate', '$read');
        ";

        return $this->insertCustom($query);
    }

    public function insertMsgBatch($insert_data){
        $query = $this->db->insert_batch($this->table, $insert_data);
        return $query;
    }
    
    public function getStudentInbox($student_id, $limit = null, $show_more = 1){
        $query = "SELECT
                    CASE
                    me.fromtype
                    WHEN '0'
                    THEN IF((SELECT COUNT(*) FROM usuarios WHERE id = me.fromid AND nombre IS NOT NULL) =0,'Staff',(SELECT nombre FROM usuarios WHERE id = me.fromid))
                    WHEN '1'
                    THEN (SELECT nombre FROM profesor WHERE indice = me.fromid)
                    WHEN '2'
                    THEN (SELECT cnomcli FROM alumnos WHERE ccodcli = me.fromid)
                    END AS `from_user_name`,

                    CASE
                    me.fromtype
                    WHEN '0'
                    THEN (SELECT foto FROM usuarios WHERE id = me.fromid)
                    WHEN '1'
                    THEN (SELECT foto FROM profesor WHERE indice = me.fromid)
                    WHEN '2'
                    THEN (SELECT foto FROM alumnos WHERE ccodcli = me.fromid)
                    END AS `from_user_photo`,

                    me.`subject`,
                    me.`body`,
                    me.`maildate`,
                    me.`Read`,
                    me.`id`,
                    CASE
                    me.fromtype
                    WHEN '0'
                    THEN 'school'
                    WHEN '1'
                    THEN 'teacher'
                    WHEN '2'
                    THEN 'student'
                    END AS roletype
                    FROM
                    mensajes AS me
                    WHERE me.`ToType` = '2'
                    AND me.`ToId` = '".$student_id."'
                    ORDER BY me.`maildate` DESC
                    ";
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

    public function getStudentOutbox($student_id, $limit = null, $show_more = 1){
        $query = "SELECT

                    CASE
                    me.totype
                    WHEN '0'
                    THEN IF((SELECT COUNT(*) FROM usuarios WHERE id = me.toid AND nombre IS NOT NULL) =0,'Staff',(SELECT nombre FROM usuarios WHERE id = me.toid))
                    WHEN '1'
                    THEN (SELECT nombre FROM profesor WHERE indice = me.toid)
                    WHEN '2'
                    THEN (SELECT cnomcli FROM alumnos WHERE ccodcli = me.toid)
                    END AS `to_user_name`,

                    CASE
                    me.totype
                    WHEN '0'
                    THEN (SELECT foto FROM usuarios WHERE id = me.toid)
                    WHEN '1'
                    THEN (SELECT foto FROM profesor WHERE indice = me.toid)
                    WHEN '2'
                    THEN (SELECT foto FROM alumnos WHERE ccodcli = me.toid)
                    END AS `to_user_photo`,

                    me.`subject`,
                    me.`body`,
                    me.`maildate`,
                    me.`Read`,
                    me.`id`,
                    CASE
                    me.totype
                    WHEN '0'
                    THEN 'school'
                    WHEN '1'
                    THEN 'teacher'
                    WHEN '2'
                    THEN 'student'
                    END AS roletype
                    FROM
                    mensajes AS me
                    WHERE me.`fromType` = '2'
                    AND me.`fromId` = '".$student_id."'
                    ORDER BY me.`maildate` DESC
                    ";
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

    public function getUserMessagesList($user_id = null){
        if(!$user_id){
            return array();
        }
        $query = $this->db->select('
                              me.id,
                              me.`Maildate` AS Fecha,
                              usr.`Nombre` AS Remitente,
                              me.`Subject` AS Asunto,
                              ')
                          ->from($this->table.' AS me')
                          ->join('usuarios AS usr', 'usr.Id = me.FromId', 'left')
                          ->where('me.toid', $user_id)
                          ->get();
        return $query->result();
    }

    public function getUserInbox($user_id = null){
        if(!$user_id){
            return array();
        }
        $query = "SELECT
                      me.`id`,
                      me.`Maildate`,
                      me.`fromtype`,
                      CASE
                        me.`fromtype`
                        WHEN '0'
                          THEN (SELECT `foto` FROM usuarios WHERE id = me.fromid)
                        WHEN '1'
                          THEN (SELECT `photo_link` FROM profesor WHERE indice = me.fromid)
                        WHEN '2'
                          THEN (SELECT `photo_link` FROM alumnos WHERE ccodcli = me.fromid)
                      END AS foto,
                      
                      CASE
                        me.`fromtype`
                        WHEN '0'
                          THEN 'blob'
                        WHEN '1'
                          THEN 'link'
                        WHEN '2'
                          THEN 'link'
                      END AS foto_desc,
                      
                      CASE
                        me.`fromtype`
                        WHEN '0'
                          THEN (SELECT nombre FROM usuarios WHERE id = me.fromid)
                        WHEN '1'
                          THEN (SELECT CONCAT(sapellidos, ', ', snombre) FROM profesor WHERE indice = me.fromid)
                        WHEN '2'
                          THEN (SELECT CONCAT(sapellidos, ', ', snombre) FROM alumnos WHERE ccodcli = me.fromid)
                      END AS Destinatario,

                      me.`Read` AS unread,
                      me.`Body` AS body,
                      me.`Subject` AS Asunto
                    FROM
                      mensajes AS me
                    WHERE me.`ToType` = '0'
                    AND me.`ToId` = '".$user_id."'
                    ORDER BY 2 DESC
                    ";
        return $this->selectCustom($query);
        /*$query = $this->db->select('
                              me.id,
                              me.`Maildate` AS Fecha,
                              usr.`USUARIO` AS Destinatario,
                              me.`Subject` AS Asunto,
                              me.`Read` AS unread,
                              me.`Body` AS body'
                             )
            ->from($this->table.' AS me')
            ->join('usuarios AS usr', 'usr.Id = me.FromId', 'left')
            ->where(array('me.toid' =>  $user_id, 'me.ToType' => '0'))
            ->where('me.`Read`', '0')
            ->order_by('me.Maildate', 'DESC')
            ->get();
        return $query->result();*/
    }

    public function getUserOutbox($user_id = null){
        if(!$user_id){
            return array();
        }
        $query = "SELECT
                      me.`id`,
                      me.`Maildate`,

                      CASE
                        me.`totype`
                        WHEN '0'
                          THEN (SELECT nombre FROM usuarios WHERE id = me.toid)
                        WHEN '1'
                          THEN (SELECT CONCAT(sapellidos, ', ', snombre) FROM profesor WHERE indice = me.toid)
                        WHEN '2'
                          THEN (SELECT CONCAT(sapellidos, ', ', snombre) FROM alumnos WHERE ccodcli = me.toid)
                      END AS Destinatario,

                      me.`Read` AS unread,
                      me.`Body` AS body,
                      me.`Subject` AS Asunto
                    FROM
                      mensajes AS me
                    WHERE me.`fromType` = '0'
                    AND me.`fromId` = '".$user_id."'
                    ORDER BY 2 DESC ";
        return $this->selectCustom($query);
    }

    public function insertUsersMessage($insert_data){
        return $this->insert($this->table, $insert_data);
    }

    public function deleteMessage($id){
        return $this->delete($this->table, array('id' => $id));
    }

    public function updateRead($messageId, $toId, $totype, $read){
        $this->db->where(array('id' => $messageId, 'toid' => $toId,  'totype' =>  $totype));
       return $this->db->update($this->table, array('Read' => $read));
    }
}
<?php

class UserMessageModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "usuarios_mensajes";
    }

    public function getInbox($USUARIO = null) {

        if(!$USUARIO){
            return null;
        }

        $query="SELECT
			um.id,
		  um.`Maildate` AS Fecha,
		  usd.`USUARIO` AS Destinatario,
		  um.`Subject` AS Asunto,
		  um.`Read` AS unread,
		  um.`Body` AS body
		 FROM
		  usuarios_mensajes AS um
		  LEFT JOIN usuarios AS usr
		    ON um.`ToId` = usr.`Id`
		  LEFT JOIN usuarios AS usd
		    ON um.`ToId` = usd.`Id`
		WHERE um.`ToId` = '".$USUARIO."'
		ORDER BY  um.`Maildate` DESC
		;";

        return $this->selectCustom($query);
    }

    public function getSent($USUARIO = null) {

        if(!$USUARIO){
            return null;
        }

        $query="SELECT
		  um.id,
		  um.`Maildate` AS Fecha,
		  usd.`Nombre` AS Destinatario,
		  um.`Subject` AS Asunto,
		  um.`Body` AS body
		FROM
		  usuarios_mensajes AS um
		  LEFT JOIN usuarios AS usr
		    ON um.`FromId` = usr.`Id`
		  LEFT JOIN usuarios AS usd
		    ON um.`ToId` = usd.`Id`
		WHERE 	um.`FromId` = '".$USUARIO."'
		ORDER BY  um.`Maildate` DESC
		;";

        return $this->selectCustom($query);
    }

    public function getNotificationCount($USUARIO = null) {

        if(!$USUARIO){
            return null;
        }

        $query="
			SELECT
			  Count(*) as num
			FROM
			  usuarios_mensajes AS um
			  LEFT JOIN usuarios AS usr
			    ON um.`FromId` = usr.`Id`
			  LEFT JOIN usuarios AS usd
			    ON um.`ToId` = usd.`Id`
			WHERE usd.`USUARIO` = '".$USUARIO."'
			  AND um.`Read` = '0'
  		";

        return $this->selectCustom($query);
    }

    public function getMessagesList($USUARIO = null) {

        if(!$USUARIO){
            return null;
        }

        $query = "
			SELECT
			  um.id,
			  um.`Maildate` AS Fecha,
			  usr.`Nombre` AS Remitente,
			  um.`Subject` AS Asunto,
			  usr.foto
			FROM
			  usuarios_mensajes AS um
			  LEFT JOIN usuarios AS usr
			    ON um.`FromId` = usr.`Id`
			  LEFT JOIN usuarios AS usd
			    ON um.`ToId` = usd.`Id`
			WHERE usd.`USUARIO` =  '".$USUARIO."'
			AND um.`Read` = '0'
		;";

        return $this->selectCustom($query);
    }

	public function getAllUsers($user_id){
		$query = "SELECT t1.id, t1.role , t1.name  FROM
				  (
					SELECT
					  id AS id,
					  nombre AS `name`,
					  '0' AS role
					FROM usuarios
						WHERE usuarios.Id != '".$user_id."'
					UNION
					SELECT indice AS id,
						   CONCAT(sapellidos, ', ', snombre) AS `name`,
						   '1' AS role
					FROM profesor
					UNION
					SELECT ccodcli AS id,
						   CONCAT(sapellidos, ', ', snombre) AS `name`,
						   '2' AS role
					FROM alumnos
				  ) AS t1

				ORDER BY 3,2
				";
		return $this->selectCustom($query);
	}
}
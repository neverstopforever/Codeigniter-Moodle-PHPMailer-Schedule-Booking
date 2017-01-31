<?php

class PresupuestotModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuestot";
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getContent($id = null) {
        if(!$id){
            return null;
        }
        $query ="
            SELECT *,CAST(presupuestot.Nacimiento AS DATE) As Nacimiento, `campañas`.Descripcion AS company_desc,presupuestot.custom_fields AS custom_fields, presupuestot.prioridad AS prospect_priority, presupuestot.score FROM presupuestot
                LEFT JOIN `campañas` ON `campañas`.`IdCampaña` = `presupuestot`.`Campaña`                
                LEFT JOIN medios ON medios.IdMedio = presupuestot.medio 
                LEFT JOIN clientes ON clientes.CCODCLI = presupuestot.facturara
                WHERE presupuestot.NumPresupuesto = '" . $id . "';";

        return  $this->selectCustom($query);
    }

    public function getSeguimiento($id = null) {

        if (!$id) {
            return null;
        }

        $query = "
            SELECT
            ps.id,
            ps.fecha AS `date`,
            ps.titulo AS `subject`,
            ps.comentarios AS comments,
            u.`Nombre`
            FROM
            presupuesto_segui AS ps
            LEFT JOIN usuarios AS u
            ON ps.`usuario` = u.`usuario`

            WHERE ps.`numpresupuesto` = '$id'

            ORDER BY 2 DESC
            ;
            ";

        return $this->selectCustom($query);
    }

    public function get_prospects_data(){
        $query = "SELECT
                      pt.numpresupuesto AS prospect_id,
                      IF(pt.sApellidos != '', CONCAT(pt.sApellidos, ', ', pt.`sNombre`), pt.`sNombre`) AS `contact_name`,
                      cli.cnomcom as `company_name`,
                      pt.prioridad AS prospect_priority,
                      pt.telefono AS `phone`,
                      pt.movil AS `mobile`,
                      pt.email,
                      pt.leido,
                      es.`valor` AS prospect_state,
                      hex(es.`color`) AS state_color,
                      pt.score  AS prospect_score,
                      us.`Nombre` AS `prospect_user`,
                      me.`Descripcion` AS `source`,
                      ca.`Descripcion` AS `campaign`,
                      pt.fechapresupuesto AS `date_creation`,
                      pt.`FechaUltima` AS `last_upadte`,
                      (SELECT `fecha` FROM presupuesto_segui ORDER BY 1 DESC LIMIT 1) AS `last_followup`,
                      IF(pt.`Matricula`>0,' yes' ,'No' ) AS enrolled
                    FROM  presupuestot AS pt
                      LEFT JOIN medios AS me  ON pt.medio = me.idmedio
                      LEFT JOIN estado_solicitud AS es  ON pt.estado = es.id
                      LEFT JOIN usuarios AS us  ON pt.`id_user` = us.`Id`
                      LEFT JOIN `campañas` AS ca  ON pt.`Campaña` = ca.`IdCampaña`
                      LEFT JOIN clientes AS cli ON pt.`facturara` = cli.`CCODCLI`
                      ORDER BY pt.fechapresupuesto DESC ";
        return $this->selectCustom($query);
    }
    public function get_prospects_data_ajax($start, $length, $draw, $search, $order, $columns, $filter_tags){
        $where = '';
        if(!empty($filter_tags->selected_source) && is_array($filter_tags->selected_source)){
            //$where = ' WHERE ';
            $ids_st = '';
            foreach($filter_tags->selected_source as $key=>$source){
                $ids_st .= "'".$source."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "me.`idmedio` IN (".$ids_st_.")";
        }

        if(!empty($filter_tags->selected_campaign) && is_array($filter_tags->selected_campaign)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->selected_campaign as $key=>$campaign){
                $ids_st .= "'".$campaign."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "ca.`IdCampaña` IN (".$ids_st_.")";
        }

        if(!empty($filter_tags->selected_state) && is_array($filter_tags->selected_state)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->selected_state as $key=>$course){
                $ids_st .= "'".$course."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "es.id IN (".$ids_st_.")";
        }

        if(!empty($filter_tags->selected_stars) && is_array($filter_tags->selected_stars)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->selected_stars as $key=>$stars){
                $ids_st .= "'".$stars."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "pt.prioridad IN (".$ids_st_.")";
        }

        if(!empty($filter_tags->selected_score) && is_array($filter_tags->selected_score)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->selected_score as $key=>$score){
                $ids_st .= "'".$score."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "pt.score IN (".$ids_st_.")";
        }

        if(!empty($filter_tags->selected_names) && is_array($filter_tags->selected_names)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }

            foreach($filter_tags->selected_names as $key=>$name){
                $or = $key == 0 ? '( ' : ' OR ';
                $where .= " ".$or." CONCAT(pt.sapellidos,', ',pt.`sNombre`) LIKE '%".$name."%'";
            }
            $where .= ' )';

        }

        if(!empty($filter_tags->tag_ids) && is_array($filter_tags->tag_ids)){
            if(empty($where)) {
                //$where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($filter_tags->tag_ids as $key=>$tags){
                $ids_st .= "'".$tags."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "ptags.id_tag IN (".$ids_st_.")";
        }

        $this->db->select("SQL_CALC_FOUND_ROWS null AS rows, pt.numpresupuesto AS prospect_id,
                      IF(pt.sApellidos != '', CONCAT(pt.sApellidos, ', ', pt.`sNombre`), pt.`sNombre`) AS `contact_name`,
                      cli.cnomcom as `company_name`,
                      pt.prioridad AS prospect_priority,
                      pt.telefono AS `phone`,
                      pt.movil AS `mobile`,
                      pt.email,
                      pt.leido,
                      es.`valor` AS prospect_state,
                      hex(es.`color`) AS state_color,
                      pt.score  AS prospect_score,
                      us.`Nombre` AS `prospect_user`,
                      me.`Descripcion` AS `source`,
                      ca.`Descripcion` AS `campaign`,
                      pt.fechapresupuesto AS `date_creation`,
                      pt.`FechaUltima` AS `last_upadte`,
                      group_concat(ptags.id_tag separator ',') AS tag_ids,
                      (SELECT `fecha` FROM presupuesto_segui ORDER BY 1 DESC LIMIT 1) AS `last_followup`,
                      IF(pt.`Matricula`>0,' yes' ,'No' ) AS enrolled", false);
        $this->db->from($this->table.' AS pt ');
        $this->db->join('medios AS me', 'pt.medio = me.idmedio', 'left');
        $this->db->join('estado_solicitud AS es', 'pt.estado = es.id', 'left');
        $this->db->join('usuarios AS us', 'pt.id_user = us.Id', 'left');
        $this->db->join('`campañas` AS ca', $this->db->escape('Campaña').' = `ca`.`IdCampaña`', 'left');
        $this->db->join('clientes AS cli', 'pt.facturara = cli.CCODCLI', 'left');
        $this->db->join('presupuesto_tags AS ptags', 'ptags.numpresupuesto = pt.numpresupuesto', 'left');
        $this->db->distinct();
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like('pt.sApellidos', $search['value']);
            $this->db->or_like('pt.sNombre', $search['value']);
            $this->db->or_like('cli.cnomcom', $search['value']);
            $this->db->or_like('pt.prioridad', $search['value']);
            $this->db->or_like('pt.telefono', $search['value']);
            $this->db->or_like('pt.movil', $search['value']);
            $this->db->or_like('pt.leido', $search['value']);
            $this->db->or_like('us.Nombre', $search['value']);
            $this->db->or_like('pt.fechapresupuesto', $search['value']);
            $this->db->or_like('pt.FechaUltima', $search['value']);
            $this->db->or_like('me.Descripcion', $search['value']);
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->group_by('pt.numpresupuesto');
        $this->db->order_by('pt.fechapresupuesto', 'DESC');

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $count_rows = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        return (object)array('rows' => $count_rows, 'items' => $query->result());
    }

    public function getProspectsByTags($selected_source = null, $selected_campaign = null, $selected_state = null, $selected_stars = null, $selected_score = null, $selected_names = null){
        $where = '';
        if(!empty($selected_source) && is_array($selected_source)){
            $where = ' WHERE ';
            $ids_st = '';
            foreach($selected_source as $key=>$source){
                $ids_st .= "'".$source."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "me.`idmedio` IN (".$ids_st_.")";
        }

        if(!empty($selected_campaign) && is_array($selected_campaign)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($selected_campaign as $key=>$campaign){
                $ids_st .= "'".$campaign."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "ca.`IdCampaña` IN (".$ids_st_.")";
        }

        if(!empty($selected_state) && is_array($selected_state)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($selected_state as $key=>$course){
                $ids_st .= "'".$course."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "es.id IN (".$ids_st_.")";
        }

        if(!empty($selected_stars) && is_array($selected_stars)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($selected_stars as $key=>$stars){
                $ids_st .= "'".$stars."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "pt.prioridad IN (".$ids_st_.")";
        }

        if(!empty($selected_score) && is_array($selected_score)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }
            $ids_st = '';
            foreach($selected_score as $key=>$score){
                $ids_st .= "'".$score."',";
            }
            $ids_st_ = trim($ids_st, ',');
            $where .= "pt.score IN (".$ids_st_.")";
        }

        if(!empty($selected_names) && is_array($selected_names)){
            if(empty($where)) {
                $where = ' WHERE ';
            }else{
                $where .= ' AND ';
            }

            foreach($selected_names as $key=>$name){
                $or = $key == 0 ? '' : ' OR ';
                $where .= " ".$or." CONCAT(pt.sapellidos,', ',pt.`Nombre`) LIKE '%".$name."%'";
            }

        }

        $query = "SELECT
                      pt.numpresupuesto AS prospect_id,
                      CONCAT(pt.sapellidos,', ',pt.`Nombre`) AS `contact_name`,
                      cli.cnomcom as `company_name`,
                      pt.prioridad AS prospect_priority,
                      pt.telefono AS `phone`,
                      pt.movil AS `mobile`,
                      pt.email,
                      pt.leido,
                      es.`valor` AS prospect_state,
                      hex(es.`color`) AS state_color,
                      pt.score  AS prospect_score,
                      us.`Nombre` AS `prospect_user`,
                      me.`Descripcion` AS `source`,
                      ca.`Descripcion` AS `campaign`,
                      pt.fechapresupuesto AS `date_creation`,
                      pt.`FechaUltima` AS `last_upadte`,
                      (SELECT `fecha` FROM presupuesto_segui ORDER BY 1 DESC LIMIT 1) AS `last_followup`,
                      IF(pt.`Matricula`>0,' yes' ,'No' ) AS enrolled
                    FROM  presupuestot AS pt
                      LEFT JOIN medios AS me  ON pt.medio = me.idmedio
                      LEFT JOIN estado_solicitud AS es  ON pt.estado = es.id
                      LEFT JOIN usuarios AS us  ON pt.`id_user` = us.`Id`
                      LEFT JOIN `campañas` AS ca  ON pt.`Campaña` = ca.`IdCampaña`
                      LEFT JOIN clientes AS cli ON pt.`facturara` = cli.`CCODCLI`
                      $where
                      ORDER BY pt.fechapresupuesto DESC ";
        return $this->selectCustom($query);
    }

    public function get_prospects_top_bar(){
        $query = "SELECT * FROM
                    (SELECT DISTINCT   COUNT(DISTINCT pt.numpresupuesto) AS `prospects_last_month`
                    FROM  presupuestot AS pt
                    WHERE pt.NumPresupuesto IS NOT NULL
                    AND YEAR(pt.`FechaPresupuesto`) = YEAR(CURDATE())
                    AND MONTH(pt.`FechaPresupuesto`) = MONTH(CURDATE())
                    )  AS `prospects_last_month`
                    ,
                    (SELECT DISTINCT  COUNT(DISTINCT pt.numpresupuesto) AS `total_prospects`
                    FROM  presupuestot AS pt
                    WHERE pt.NumPresupuesto IS NOT NULL
                    ) AS `total_prospects`
                    ,
                    (SELECT ROUND(((SUM(IF(pt.matricula = 0, 0, 1)) )*100)/(COUNT(DISTINCT pt.numpresupuesto)),0) AS `conversion_rate`
                    FROM  presupuestot AS pt
                    WHERE pt.NumPresupuesto IS NOT NULL
                    )  AS `conversion_rate`
                    ,
                  (SELECT COUNT(*) AS `contacts` FROM contactos ) AS contacts";
        return $this->selectCustom($query);
    }

    public function get_states(){
        $query = $this->db->select('hex(color) AS color,valor,id')
                            ->from('estado_solicitud')
                            ->order_by('valor')
                            ->get()
                            ->result();

        return $query;
    }

    public function addLeadsRecords($formData = false) {

        if ($formData) {
            $data_presupuestot = array(
                "NumPresupuesto" => isset($formData["NumPresupuesto"]) ? trim($formData["NumPresupuesto"]): null,
                "Nombre" => (isset($formData["sApellidos"]) && isset($formData["Nombre"])) ? $formData["sApellidos"] . " " . $formData["Nombre"]: null,
                "sNombre" => isset($formData["Nombre"]) ? $formData["Nombre"]: null,
                "sApellidos" => isset($formData["sApellidos"]) ? $formData["sApellidos"]: null,
                "FechaPresupuesto" => date("Y-m-d H:i:s"),
                "FechaUltima" => date("Y-m-d H:i:s"),
                "IdAlumno" => "",
                "IdCentro" => "0",
                "leido" => "1",
                "facturara" => "0",
                "perfil" => "1",
                "idusuario" => isset($this->session->userdata("userData")[0]->Id) ? $this->session->userdata("userData")[0]->Id: null,
                "idestado" => "0",
                'email' => isset($formData['email']) ? $formData['email'] : null,
                'domicilio' => isset($formData['domicilio']) ? $formData['domicilio'] : null,
                'Poblacion' => isset($formData['Poblacion']) ? $formData['Poblacion'] : null,
                'Provincia' => isset($formData['Provincia']) ? $formData['Provincia'] : null,
                'Telefono' => isset($formData['Telefono']) ? $formData['Telefono'] : null,
                'Movil' => isset($formData['Movil']) ? $formData['Movil'] : null

            );
            if($this->db->insert($this->table, $data_presupuestot)){
                return true;
            }
        }
        return false;
    }

    public function addLeadsRecordsByContact($leadId = null, $contact_id = null, $descripcion = null) {

        if(empty($leadId) || !is_numeric($leadId) || empty($contact_id) || !is_numeric($contact_id)){
            return false;
        }
        if(!empty($descripcion)){
            $desc = ', `Descripcion`';
            $descripcion = ",'".$descripcion."'";
        }else{
            $desc = ' ';
            $descripcion = " ";
        }


        $query = "INSERT presupuestot (
                  `sNombre`, `sApellidos`, `email`, `domicilio`,
                  `Poblacion`, `Provincia`, `pais`, `Nacimiento`,
                  `CPTLCLI`, `Movil`, `iban`, `idsexo`,
                  `CDNICIF`, `Nombre`, `Skype`, `Telefono`,
                  `Telefono2`, `perfil`,
                  `NumPresupuesto`, `FechaPresupuesto`,`FechaUltima`,`Estado`,
                  `IdAlumno`,`IdCentro`,`leido`,`facturara`,
                  `idusuario`,`prioridad`,`bookmark`,`idestado`".$desc."
                )
                  SELECT
                    `sNombre`, `sApellidos`, `email`, `domicilio`,
                    `Poblacion`, `Provincia`, `pais`, `FNacimiento`,
                    `Distrito`, `Movil`, `iban`, `idsexo`,
                    `CDNICIF`,  `Nombre`, `Skype`, `Telefono1`,
                    `Telefono2`, '1',
                    $leadId, CURDATE(), CURDATE(), '0',
                    id, '0', '1', '0',
                    null, '0', '0', '0'".$descripcion."

                  FROM
                    contactos
                  WHERE id  = $contact_id;
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }
    
    public function getList(){

        $query = "SELECT 
                      pt.numpresupuesto AS ID,
                      DATE_FORMAT(pt.fechapresupuesto,'%Y-%m-%d') AS `Date`,
                      pt.bookmark AS `Bookmark`,
                      CONCAT(pt.sapellidos,', ',pt.`Nombre`) AS `Name`,
                    
                      CASE
                        pt.prioridad 
                        WHEN 0 
                        THEN 'normal' 
                        WHEN 1 
                        THEN 'High' 
                        WHEN 2 
                        THEN 'Very High' 
                      END AS Priority,
                    
                      pt.pais AS `Country`,
                      pt.telefono AS `Phone`,
                      pt.movil AS `Mobile`,
                      medios.descripcion AS `Source`,
                    
                      CONCAT(MID(es.valor,1,15),' ..') AS `State`,
                    
                      pt.leido,
                      HEX(es.color) AS state_color,
                      
                      CASE
                        pt.prioridad 
                        WHEN 0 
                        THEN 'FFFFFF' 
                        WHEN 1 
                        THEN '26A69A' 
                        WHEN 2 
                        THEN 'ED6B75' 
                      END AS priority_color                     
                      
                    
                    FROM
                      presupuestot AS pt 
                      LEFT JOIN medios 
                        ON pt.medio = medios.idmedio 
                      LEFT JOIN estado_solicitud AS es
                        ON pt.estado = es.id
                    ORDER BY 1 DESC  
                    ;";
        return $this->selectCustom($query);
    }

    public function addExistingUser($leadId = false, $userId = false, $profileId = false) {
        
        if ($profileId == 1) {
            $query = "INSERT presupuestot (
                                `sNombre`, `sApellidos`, `email`, `domicilio`,
                                `Poblacion`, `Provincia`, `pais`, `Nacimiento`,
                                `CPTLCLI`, `Movil`, `iban`, `idsexo`,
                                `CDNICIF`, `Nombre`, `Skype`, `Telefono`,
                                `Telefono2`, `perfil`, 
                                `NumPresupuesto`, `FechaPresupuesto`,`FechaUltima`,`Estado`,
                                `IdAlumno`,`IdCentro`,`leido`,`facturara`,
                                `idusuario`,`prioridad`,`bookmark`,`idestado`
                                )
                                SELECT 
                                  `sNombre`, `sApellidos`, `email`, `domicilio`,
                                  `Poblacion`, `Provincia`, `pais`, `FNacimiento`,
                                  `Distrito`, `Movil`, `iban`, `idsexo`,
                                  `CDNICIF`,  `Nombre`, `Skype`, `Telefono1`,
                                  `Telefono2`, '1',
                                  $leadId, CURDATE(), CURDATE(), '0',
                                  id, '0', '1', '0',
                                  $userId, '0', '0', '0'

                                FROM
                                  contactos
                                  WHERE id  = $userId
                                ";
        } else {
            $query = "INSERT presupuestot (
                                `sNombre`, `sApellidos`, `email`, `domicilio`,
                                `Poblacion`, `Provincia`, `pais`, `Nacimiento`,
                                `CPTLCLI`, `Movil`, `iban`, `idsexo`,
                                `CDNICIF`, `Nombre`, `Skype`, `Telefono`,
                                `Telefono2`, `perfil`, 
                                `NumPresupuesto`, `FechaPresupuesto`,`FechaUltima`,`Estado`,
                                `IdAlumno`,`IdCentro`,`leido`,`facturara`,
                                `idusuario`,`prioridad`,`bookmark`,`idestado`
                                )
                                SELECT 
                                  `sNombre`, `sApellidos`, `email`, `cdomicilio`,
                                  `cpobcli`,`ccodprov`,`cnaccli`,`Nacimiento`,
                                  `cptlcli`,`Movil`,`iban`,`idsexo`,
                                  `CDNICIF`,`cnomcli`,`SkypeAlumno`,`ctfo1cli`,
                                  `ctfo1cli`, '2',
                                  $leadId, CURDATE(), CURDATE(), '0',
                                  id, '0', '1', '0',
                                  $userId, '0', '0', '0'

                                FROM
                                  alumnos
                                  WHERE ccodcli  = $userId
                                ";
            
        }
        return $this->db->query($query);
    }

    public function updateItem($data, $NumPresupuesto){
        
        if(empty($data) || empty($NumPresupuesto)){
            return false;
        }

        $data = array(
            'medio' => $data['medio'],
            'Campaña' => $data['Campaña'],
            'score' => $data['score'],
            'prioridad' => $data['prioridad'],
        );

        $this->db->where('NumPresupuesto', $NumPresupuesto);
        return $this->db->update($this->table, $data);        
    }

    public function unassignExistMedios($NumPresupuesto = null){
        
        if(empty($NumPresupuesto)){
            return false;
        }

        $data = array(
            'medio' => null
        );

        $this->db->where('NumPresupuesto', $NumPresupuesto);
        return $this->db->update($this->table, $data);        
    }

    public function unassignExistCampana($NumPresupuesto = null){
        
        if(empty($NumPresupuesto)){
            return false;
        }

        $data = array(
            'Campaña' => null
        );

        $this->db->where('NumPresupuesto', $NumPresupuesto);
        return $this->db->update($this->table, $data);        
    }



    public function makeInsertData($post_data){
        $data_presupuestot = array(
            "NumPresupuesto" => isset($post_data["NumPresupuesto"]) ? trim($post_data["NumPresupuesto"]): null,
            "Nombre" => (isset($post_data["sapellidos"]) && isset($post_data["snombre"])) ? $post_data["sapellidos"] . " " . $post_data["snombre"]: null,
            "sNombre" => isset($post_data["snombre"]) ? $post_data["snombre"]: null,
            "sApellidos" => isset($post_data["sapellidos"]) ? $post_data["sapellidos"]: null,
            "FechaPresupuesto" => date("Y-m-d H:i:s"),
            "FechaUltima" => date("Y-m-d H:i:s"),
            "IdAlumno" => "",
            "IdCentro" => "0",
            "leido" => "1",
            "facturara" => "0",
            "perfil" => "1",
            "idusuario" => $this->session->userdata("userData")[0]->Id,
            "idestado" => "0",
        );
        return $data_presupuestot;
    }

    public function insertPresupestot($data = array()){

        if(empty($data)){
            return false;
        }

        return $this->db->insert($this->table, $data);
    }

    public function getProspectById($prospect_id){
        $query = $this->db->select("
                      NumPresupuesto AS prospect_id,
                      CONCAT(sapellidos,', ',`Nombre`) AS `contact_name`, email, IdAlumno, perfil, Matricula AS enrolled")
                          ->from($this->table)
                          ->where('NumPresupuesto',$prospect_id)
                          ->get();
        return $query->row();
    }


    public function get_prospects($tags = array()){
        $this->db->select($this->table.'.numpresupuesto as id, CONCAT("pr_", '.$this->table.'.numpresupuesto) as _id, sApellidos AS `surname`, sNombre AS `first_name`, email, score  AS `prospect_score`')
            ->from($this->table);
        $this->db->join('presupuesto_tags AS ptags', 'ptags.numpresupuesto = '.$this->table.'.numpresupuesto', 'left');

        if(!empty($tags)){
            $selected_surname = isset($tags['selected_surname']) ? $tags['selected_surname']: null;
            $selected_first_name = isset($tags['selected_first_name']) ? $tags['selected_first_name']: null;
            $selected_email = isset($tags['selected_email']) ? $tags['selected_email']: null;
            $selected_tag_ids = isset($tags['selected_prospects_tag_ids']) ? $tags['selected_prospects_tag_ids']: null;


            $like_exit = false;
//
            if(!empty($selected_surname)){
                foreach ($selected_surname as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like($this->table.'.sapellidos', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like($this->table.'.sapellidos', $value);
                        }
                    }
                }
            }
//
            if(!empty($selected_first_name)){
                foreach ($selected_first_name as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like($this->table.'.snombre', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like($this->table.'.snombre', $value);
                        }
                    }
                }
            }
//
            if(!empty($selected_email)){
                foreach ($selected_email as $k=>$value){
                    if (!empty($value)) {
                        if(!$like_exit){
                            $this->db->like($this->table.'.email', $value);
                            $like_exit = true;
                        }else{
                            $this->db->or_like($this->table.'.email', $value);
                        }
                    }
                }
            }

            if(!empty($selected_tag_ids) && is_array($selected_tag_ids)){
                $ids_st = '';
                foreach($selected_tag_ids as $key=>$tags_loc){
                    $ids_st .= "'".$tags_loc."',";
                }
                $ids_st_ = trim($ids_st, ',');
                $this->db->where("ptags.id_tag IN (".$ids_st_.")");
            }

            $selected_source = isset($tags['selected_prospects_source']) ? $tags['selected_prospects_source']: null;
            if(!empty($selected_source) && is_array($selected_source)){
                $ids_st = '';
                foreach($selected_source as $key=>$source){
                    $ids_st .= "'".$source."',";
                }
                $ids_st_ = trim($ids_st, ',');
                $this->db->where($this->table.".medio IN (".$ids_st_.")");
            }

            $selected_campaign = isset($tags['selected_prospects_campaign']) ? $tags['selected_prospects_campaign']: null;
            if(!empty($selected_campaign) && is_array($selected_campaign)){
                $ids_st = '';
                foreach($selected_campaign as $key=>$campaign){
                    $ids_st .= "'".$campaign."',";
                }
                $ids_st_ = trim($ids_st, ',');
//                $where .= "ca.`IdCampaña` IN (".$ids_st_.")";
                $this->db->where($this->table.".Campaña IN (".$ids_st_.")");
            }

            $selected_state = isset($tags['selected_prospects_state']) ? $tags['selected_prospects_state']: null;
            if(!empty($selected_state) && is_array($selected_state)){         
                $ids_st = '';
                foreach($selected_state as $key=>$course){
                    $ids_st .= "'".$course."',";
                }
                $ids_st_ = trim($ids_st, ',');
//                $where .= "pt.estado IN (".$ids_st_.")";
                $this->db->where($this->table.".estado IN (".$ids_st_.")");
            }

            $selected_stars = isset($tags['selected_prospects_stars']) ? $tags['selected_prospects_stars']: null;
            if(!empty($selected_stars) && is_array($selected_stars)){
                $ids_st = '';
                foreach($selected_stars as $key=>$stars){
                    $ids_st .= "'".$stars."',";
                }
                $ids_st_ = trim($ids_st, ',');
//                $where .= "pt.prioridad IN (".$ids_st_.")";
                $this->db->where($this->table.".prioridad IN (".$ids_st_.")");
            }

            $selected_score = isset($tags['selected_prospects_score']) ? $tags['selected_prospects_score']: null;
            if(!empty($selected_score) && is_array($selected_score)){             
                $ids_st = '';
                foreach($selected_score as $key=>$score){
                    $ids_st .= "'".$score."',";
                }
                $ids_st_ = trim($ids_st, ',');
//                $where .= "pt.score IN (".$ids_st_.")";
                $this->db->where($this->table.".score IN (".$ids_st_.")");
            }            
        }
        $this->db->distinct();
        $query = $this->db->get();

        return $query->result_object();
    }

    public function getProspectsIdFields(){

        $this->db->select('numpresupuesto as id, CONCAT("pr_", numpresupuesto) as _id, sApellidos AS `surname`, sNombre AS `first_name`, email')
            ->from($this->table);
        $query = $this->db->get();

        return $query->result_object();

    }


    public function getProspectsByEmailForRecipient($email = null) {

        if(empty($email)){
            return false;
        }

        $this->db->select('numpresupuesto as id, CONCAT("pr_", numpresupuesto) as _id, sApellidos AS `surname`, sNombre AS `first_name`, email')
            ->from($this->table);
        $this->db->where($this->table.'.email', $email);
        $this->db->distinct();
        $query = $this->db->get();
//        $str = $this->db->last_query();
//        print_r($str);die;
        return $query->result_object();

    }

    public function getExtraFields($select_str, $where = array()){
        $this->db->select($select_str);
        $this->db->from($this->table);
        $this->db->join('contactos', 'contactos.id = presupuestot.IdAlumno');
        $this->db->where($where);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function enrollProspect($enroll_id, $prospect_id){
        return $this->update(
            $this->table,
            array("matricula" => $enroll_id),
            array("numpresupuesto" => $prospect_id)
        );
    }

    public function copyProspectToStudent($prospect_id, $student_id){
        $query = "INSERT alumnos ( ccodcli, `sNombre`, `sApellidos`, `email`, `cdomicilio`,
                                        `cpobcli`,`ccodprov`,`cnaccli`,`Nacimiento`,
                                          `cptlcli`,`Movil`,`iban`,`idsexo`,
                                          `CDNICIF`,`cnomcli`,`SkypeAlumno`,`ctfo1cli`
                                       
                                        )
                                        SELECT 
                                          '".$student_id."', `sNombre`, `sApellidos`, `email`, `domicilio`,
                                        `Poblacion`, `Provincia`, `pais`, `Nacimiento`,
                                        `CPTLCLI`, `Movil`, `iban`, `idsexo`,
                                        `CDNICIF`, `Nombre`, `Skype`, `Telefono`
                                        FROM
                                          presupuestot
                                          WHERE NumPresupuesto  = '".$prospect_id."'
                                        ;";

        return $this->db->query($query);
    }

    public function getRequestedCourses( $client_id ){
        $sql = "SELECT 
          pl.id,
          pl.codigocurso AS ref,
          pl.descripcion AS `description`,
          pl.horas AS `hours`,
          pl.precio AS `price`
        FROM
          presupuesto_solicitud AS pl 
          LEFT JOIN `modalidad tipologia` AS mt 
            ON pl.tipo = mt.id 
        WHERE pl.NumPresupuesto ='".$client_id."'";

        return  $this->selectCustom($sql);
    }

    public function getCoursesForAdd(){

        $sql = "SELECT codigo as id, curso as course, horas as hours 
                FROM curso 
                WHERE tipo = 0 AND (estado = 0 OR estado = NULL) ORDER BY 2";
        return  $this->selectCustom($sql);
    }
    public function getCoursesForAddWhereIn($courses_id){
        $and_where = '';
        if($courses_id){
            $and_where = "AND cu.codigo NOT IN ".$courses_id;
        }

        $sql = "SELECT DISTINCT cu.codigo, cu.codigo as id, cu.curso as course, cu.horas as hours 
                FROM curso as cu
                inner JOIN gruposl as gl
                ON gl.codigocurso = cu.codigo
                WHERE cu.tipo = 0 AND (cu.estado = 0 OR cu.estado = NULL) ".$and_where." ORDER BY 2";
        return  $this->selectCustom($sql);
    }

    public function getProspectsByContacts($contact_id){

        $sql = "SELECT 
  pt.numpresupuesto AS prospect_id,
  DATE(pt.`FechaPresupuesto`) AS Prospect_date,
  (SELECT GROUP_CONCAT(presupuesto_tags.`id_tag` SEPARATOR ',') FROM presupuesto_tags WHERE presupuesto_tags.`numpresupuesto` = pt.`NumPresupuesto` ) AS tag_ids 
  
FROM
  presupuestot AS pt 
WHERE pt.perfil = 1 
  AND pt.`IdAlumno` = $contact_id
ORDER BY 1 DESC ;";
        return  $this->selectCustom($sql);
    }

}
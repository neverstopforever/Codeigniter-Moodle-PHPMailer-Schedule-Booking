<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/18/15
 * Time: 11:34 PM
 */
class ContactosModel extends CI_Model
{
    public $fields = array(
       'IdAlumno',
       'Nombre',
       'Domicilio',
       'Poblacion',
       'Provincia',
       'Distrito',
       'Telefono1',
       'Telefono2',
       'Fax',
       'NIF',
       'Email',
       'Viene_POR_IdAlumno',
       'IdComercial',
       'Observaciones',
       'FNacimiento',
       'Skype',
       'FirstUpdate',
       'LastUpdate',
       'Seguimiento',
       'IdTipo',
       'movil',
       'pais',
       'facturara',
       'IdEmpresa',
       'sNombre',
       'sApellidos',
       'idsexo',
       'cdnicif',
       'iban',
       'cc1',
       'cc2',
       'cc3',
       'cc4',
    );
    public function __construct()
    {
        parent::__construct();
        $this->table = 'contactos';
    }

    public function getTotalCount() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_contactos()
    {
        return $this->db->get('contactos')->result_array();
    }
    public function get_single_contactos($id)
    {
        $this->db->where(array('Id'=>$id));
        return $this->db->get('contactos')->result_array();
    }
    public function update($id, $data)
    {
        $this->db->where("Id", $id);
        return $this->db->update("contactos", $data);
    }

    public function insert($data)
    {
        return $this->db->insert("contactos", $data);
    }

    public function delete($id)
    {
        $query = "SELECT COUNT(IF(id IN (SELECT idalumno FROM presupuestot WHERE perfil=1),1,0)) AS
        found_relations
        FROM contactos
        WHERE id = $id";

        @$result = $this->db->query($query)->result_array()[0]['found_relations'];

        if (intval($result) > 0) {
            $this->db->where('Id', $id);
            return $this->db->delete('contactos');
        }

        return false;
    }


    public function filter($value, $operator, $column_name)
    {
        $query = "SELECT * FROM contactos WHERE $column_name $operator $value";
        return $this->db->query($query)->result_array();
    }

    public function group_by($column_name)
    {
        $this->db->from('contactos');
        $this->db->group_by($column_name);
        return $this->db->get()->result_array();
    }

    public function selectContact($id = null)
    {
        if(!$id){
            return null;
        }

        $query = "
        SELECT Id,
        Snombre,
        Sapellidos,
        Domicilio,
        Poblacion,
        Provincia,
        Distrito,
        Telefono1,
        Telefono2,
        Movil,
        Pais,
        email,
        nif,
        fnacimiento,
        skype,
        Idsexo,
        iban,
        Cc1,
        Cc2,
        Cc3,
        Cc4,
        Facturara,
        seguimiento,
        custom_fields
        FROM contactos WHERE Id =".$id;

        $r = $this->db->query($query);
        return $r->result();
    }

    public function getContactosByAjax($start, $length, $draw, $search, $order, $columns = '') {

        $this->db->select('id, CONCAT("co_", id) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);


        $like_exit = false;
        if (isset($search['value']) && !empty($search['value'])) {
            $this->db->like($this->table.'.sapellidos', $search['value']);
            $this->db->or_like($this->table.'.snombre', $search['value']);
            $this->db->or_like($this->table.'.email', $search['value']);
            $like_exit = true;
        }

        foreach ($columns as $k=>$item){
            if($k != 0){
                if(!empty($item['search']['value'])){
                    $values = explode(',',$item['search']['value']);
                    foreach($values as $value){
                        $value = trim($value);
                        switch ($k){
                            case 1:
                                if(!$like_exit){
                                    $this->db->like($this->table.'.sapellidos', $value);
                                    $like_exit = true;
                                }else{
                                    $this->db->or_like($this->table.'.sapellidos', $value);
                                }
                                break;
                            case 2:
                                if(!$like_exit){
                                    $this->db->like($this->table.'.snombre', $value);
                                    $like_exit = true;
                                }else{
                                    $this->db->or_like($this->table.'.snombre', $value);
                                }
                                break;
                            case 3:
                                if(!$like_exit){
                                    $this->db->like($this->table.'.email', $value);
                                    $like_exit = true;
                                }else{
                                    $this->db->or_like($this->table.'.email', $value);
                                }
                                break;
                            default:
                        }
                    }

                } 
            }
        }

//        if(isset($columns[0]['search']['value']) && is_numeric($columns[0]['search']['value'])){
//            $this->db->where('erp_emails_campaign.id_folder', $columns[0]['search']['value']);
//        }

        $this->db->distinct();

        if (isset($order) && !empty($order)) {
            $column= $order[0]['column'];
            $column_dir= $order[0]['dir'];
            switch ($column) {
                case 1:
                    $column = $this->table.".id";
                    break;
                case 2:
                    $column = $this->table.".sapellidos";
                    break;
                case 3:
                    $column = $this->table.".snombre";
                    break;
                default:
                    $column = $this->table.".email";
            }
            $this->db->order_by($column, $column_dir);
        }

        $query = $this->db->get('', $length, $start);
//        $str = $this->db->last_query();
//        print_r($str);
        return $query->result_object();

    }
    
    public function get_contacts($tags = array()){
        $this->db->select('id, CONCAT("co_", id) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);
        
        if(!empty($tags)){
            $selected_surname = isset($tags['selected_surname']) ? $tags['selected_surname']: null;
            $selected_first_name = isset($tags['selected_first_name']) ? $tags['selected_first_name']: null;
            $selected_email = isset($tags['selected_email']) ? $tags['selected_email']: null;

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
        }
        
        $query = $this->db->get();
        return $query->result_object();
    }

    public function getContactsIdFields(){
        
        $this->db->select('id, CONCAT("co_", id) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);
        $query = $this->db->get();

        return $query->result_object();

    }

    public function getContactosByEmailForRecipient($email = null) {

        if(empty($email)){
            return false;
        }

        $this->db->select('id, CONCAT("co_", id) as _id, sapellidos AS `surname`, snombre AS `first_name`, email')
            ->from($this->table);
        $this->db->where($this->table.'.email', $email);
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_object();

    }

    public function getByEmail($email = null) {

        if(empty($email)){
            return false;
        }

        $this->db->select('*')
            ->from($this->table);
        $this->db->where($this->table.'.email', $email);
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_object();

    }

    public function addItem($email = null) {

        if(empty($email)){
            return false;
        }

        $this->db->select('*')
            ->from($this->table);
        $this->db->where($this->table.'.email', $email);
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_object();

    }

    public function addRecord($formData = false) {

        if(!$formData){
            return false;
        }

        $contact_data = array(
            "Nombre" => (isset($formData["sApellidos"]) && isset($formData["Nombre"])) ? $formData["sApellidos"] . " " . $formData["Nombre"]: null,
            'sNombre' => isset($formData['Nombre']) ? $formData['Nombre'] : null,
            'Email' => isset($formData['Email']) ? $formData['Email'] : null,
            'sApellidos' => isset($formData['sApellidos']) ? $formData['sApellidos'] : null,
            'Domicilio' => isset($formData['Domicilio']) ? $formData['Domicilio'] : null,
            'Distrito' => isset($formData['Distrito']) ? $formData['Distrito'] : null, //???
            'Poblacion' => isset($formData['Poblacion']) ? $formData['Poblacion'] : null,
            'Provincia' => isset($formData['Provincia']) ? $formData['Provincia'] : null,
            'Telefono1' => isset($formData['Telefono1']) ? $formData['Telefono1'] : null,
            'movil' => isset($formData['movil']) ? $formData['movil'] : null
        );

         $this->db->insert($this->table, $contact_data);
        return $this->db->insert_id();
    }

    public function updateRecord($formData = false, $id = null) {

        if(!$formData || empty($id) || !is_numeric($id)){
            return false;
        }

        $contact_data = array();
        if(isset($formData["sApellidos"]) && isset($formData["Nombre"])){
            $contact_data['Nombre'] = $formData["sApellidos"] . " " . $formData["Nombre"];
        }
        if(isset($formData['Email'])){
            $contact_data['Email'] = $formData['Email'];
        }
        if(isset($formData['Nombre'])){
            $contact_data['sNombre'] = $formData['Nombre'];
        }
        if(isset($formData['sApellidos'])){
            $contact_data['sApellidos'] = $formData['sApellidos'];
        }
        if(isset($formData['Domicilio'])){
            $contact_data['Domicilio'] = $formData['Domicilio'];
        }
        if(isset($formData['Distrito'])){
            $contact_data['Distrito'] = $formData['Distrito'];
        }
        if(isset($formData['problacion'])){
            $contact_data['Poblacion'] = $formData['problacion'];
        }
        if(isset($formData['Provincia'])){
            $contact_data['Provincia'] = $formData['Provincia'];
        }
        if(isset($formData['Telefono1'])){
            $contact_data['Telefono1'] = $formData['Telefono1'];
        }
        if(isset($formData['movil'])){
            $contact_data['movil'] = $formData['movil'];
        }

        $this->db->where(array('Id'=>$id));
        return $this->db->update($this->table, $contact_data);
    }

    public function getList(){

        $this->db->select(" id, CONCAT(sapellidos,', ',snombre) AS `Name`,
                      TRIM(CONCAT(telefono1,' ',telefono2,' ',movil)) AS `Phones`,
                      email")
            ->from($this->table ." as co");
        $this->db->order_by(2);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAll($selectParams = '', $where = array()) {
        
        if ($selectParams != '') {
            $this->db->select($selectParams);
        }
        $this->db->from($this->table);
        if(!empty($where)){
            $this->db->where($where);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function updateItemById($data, $id){
        $this->db->where(array('Id'=>$id));        
        return $this->db->update($this->table, $data);
    }

    public function makeInsertData($post_data){

        $snambre = isset($post_data['snombre']) ? $post_data['snombre'] : null;
        $sapellidos = isset($post_data['sapellidos']) ? $post_data['sapellidos'] : null;

        $insert_data = array();
        foreach ($this->fields as $field){
            if(isset($post_data[$field]) || isset($post_data[strtolower($field)])){
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'
                    || $field == 'FNacimiento'){
                    $insert_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[strtolower($field)]));
                }else{
                    if($field == "sNombre"){
                        $insert_data[$field] = $snambre;
                    }else if($field == "sApellidos"){
                        $insert_data[$field] = $sapellidos;
                    }else if($field == "Nombre"){
                        $insert_data[$field] = $snambre." ".$sapellidos;
                    }else{
                        $insert_data[$field] = $post_data[strtolower($field)];
                    }
                }
            }else{
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'
                    || $field == 'FNacimiento'){
                    $insert_data[$field] = date('Y-m-d H:i:s');
                }else{
                    if($field == "Nombre"){
                        if($snambre || $sapellidos){
                            $insert_data[$field] = trim($snambre." ".$sapellidos);
                        }else{
                            $insert_data[$field] = null;
                        }
                    }else{
                        $insert_data[$field] = null;
                    }
                }
            }
        }
        return $insert_data;
    }

    public function makeUpdateData($post_data){

        if(isset($post_data['snombre'])){
            $snambre = $post_data['snombre'];
        }
        if(isset($post_data['sapellidos'])){
            $sapellidos = $post_data['sapellidos'];
        }
        $update_data = array();
        foreach ($this->fields as $field){

            if(isset($post_data[$field]) || isset($post_data[strtolower($field)]) ){
                if($field == 'FirstUpdate'
                    || $field == 'LastUpdate'
                    || $field == 'FNacimiento'){
                    $update_data[$field] = date('Y-m-d H:i:s', strtotime($post_data[strtolower($field)]));
                }else{
                    $update_data[$field] = $post_data[strtolower($field)];
                }
            }else{
                if($field == "nombre"){
                    if(isset($snambre) && isset($sapellidos)){
                        $update_data[$field] = trim($snambre." ".$sapellidos);
                    }else if(isset($snambre) && !isset($sapellidos)){
                        $update_data[$field] = trim($snambre);
                    }else if(!isset($snambre) && isset($sapellidos)){
                        $update_data[$field] = trim($sapellidos);
                    }
                }
            }
        }
        return $update_data;
    }
    
    

    public function insertItem($data = array()){

        if(empty($data)){
            return false;
        }
        $this->db->insert($this->table, $data);
        
        return $this->db->insert_id();
    }

    public function getContactosCustom(){
        $query = "SELECT
                  distinct co.id,
                  concat(co.sapellidos,', ',co.snombre) `name`,
                  trim(concat(co.telefono1,' ',co.telefono2,' ',co.movil)) AS `phones`,
                  co.email as email,
                  al.email as student_email
                FROM
                  contactos AS co
                  left join alumnos as al
                  on al.Email =co.email
                ORDER BY co.FirstUpdate DESC; ";

        return $this->db->query($query)->result();
    }
    public function convertContactToStudent($email){
        $query = "INSERT INTO alumnos (
                  `ccodcli`,`sNombre`,`sApellidos`,`cnomcli`,`cDomicilio`,
                  `CPOBCLI`,`CCODPROV`,`ctfo1cli`,`ctfo2cli`,
                  `movil`,`Email`,`CPTLCLI`,`CNACCLI`,
                  `cdnicif`,`Nacimiento`,`centidad`,`cagencia`,
                  `CCTRLBCO`,`CCUENTA`,`facturara`,`autoriza_apd`,
                  `FirstUpdate`)
                  SELECT
                    (SELECT numalumno+1 FROM variables2),
                    co.`sNombre`,co.`sApellidos`,CONCAT(co.`sNombre`,' ',co.`sApellidos`),co.`Domicilio`,
                    co.`Poblacion`,co.`Provincia`,co.`Telefono1`,co.`Telefono2`,
                    co.`movil`,co.`Email`,co.`Distrito`,co.`pais`,
                    co.`cdnicif`,co.`FNacimiento`,co.`cc1`,co.`cc2`,
                    co.`cc3`,co.`cc4`,co.`facturara`,co.`autoriza_apd`,
                    co.`FirstUpdate`
                  FROM contactos AS co
                  WHERE co.email = '".$email."'
                        AND co.`Email` NOT IN
                            (SELECT email FROM alumnos)
                ;";
         $this->db->query($query);
        return $this->db->affected_rows();
    }
}
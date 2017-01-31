<?php

class PresupuestoSolicitudModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuesto_solicitud";
    }

    public function addItem($formData = null) {

        if(empty($formData)){
            return null;
        }
        $data = array(
            'NumPresupuesto' => isset($formData["NumPresupuesto"]) ? trim($formData["NumPresupuesto"]): null,
            'codigocurso'=> isset($formData['codigocurso']) ? $formData['codigocurso'] : null,
            'Descripcion'=> isset($formData['Descripcion']) ? $formData['Descripcion'] : null
        );
        if($this->insert($this->table, $data)){
            return true;
        }
    }

    public function addCourses($client_id, $cid)
    {

        if (empty($client_id) || empty($cid)) {
            return false;
        }
        $sql = "INSERT INTO presupuesto_solicitud 
                  (NumPresupuesto, CodigoCurso, Descripcion, Horas, Precio, dto, neto)
                    SELECT $client_id ,codigo,curso,horas,precio,0,precio 
                     FROM curso WHERE codigo IN ($cid)";

        return $this->db->query($sql);
    }

    public function deleteItem($id)
    {
        if (empty($id)) {
            return false;
        }
        $sql = "DELETE FROM presupuesto_solicitud WHERE id='$id'";

        return $this->db->query($sql);
    }
    public function getCoursesOffered($id, $exist_ids){
         $this->db->select('id, codigocurso AS ref, Descripcion AS description, Horas AS hours, precio AS price, TIPO')
            ->from($this->table)
            ->where('NumPresupuesto', $id);
            if(!empty($exist_ids)) {
                $this->db->where_not_in('codigocurso', $exist_ids);
            }
        $query = $this->db->get();

        return $query->result();
    }

    public function getCoursesByids($client_id, $ids){
        if(empty($ids)){
            return null;
        }
        $query = $this->db->select('NumPresupuesto,codigocurso,Descripcion, Horas, precio, TIPO,
                                    IdDivisa, dto, neto, IdAreaAcademica, IdCiclo, idcurso')
                          ->from($this->table)
                          ->where('NumPresupuesto', $client_id)
                          ->where_in('id', $ids)
                          ->get();

        return $query->result();
    }

    public function getCoursesById($id, $client_id){
        if(empty($id)){
            return null;
        }
        $query = $this->db->select('NumPresupuesto,codigocurso,Descripcion, Horas, precio, TIPO,
                                    IdDivisa, dto, neto, IdAreaAcademica, IdCiclo, idcurso')
                          ->from($this->table)
                          ->where('NumPresupuesto', $client_id)
                          ->where('id', $id)
                          ->get();

        return $query->row();
    }

    public function getExistOfferedCourses($client_id, $id){
        $this->db->select('*');
        $this->db->from($this->table.' AS ps');
        $this->db->join('presupuestol AS pl', 'pl.NumPresupuesto = ps.NumPresupuesto AND ps.codigocurso = pl.codigocurso', 'inner');
        $this->db->where('ps.NumPresupuesto', $client_id);
        $this->db->where('ps.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

}
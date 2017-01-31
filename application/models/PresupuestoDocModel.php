<?php

class PresupuestoDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuesto_doc";
    }

    public function getDocuments($teacher_id) {
        $query = $this->db->select("id, 
                            idpresupuesto, 
                            fecha, 
                            IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
                            doclink, 
                            documento,
                            IF(visible IS NULL OR visible = 0,'NO','SI') AS visible,
                            IF(docblob IS NULL OR docblob = '',0,1) AS docblob
                            ")
                           ->from($this->table)
                           ->where('idpresupuesto', $teacher_id)
                           ->get();

        return $query->result();
    }

    public function deleteDocuments($document_id){
        return $this->delete($this->table, array('id' => $document_id));
    }

    public function deleteDocumentByIdClientId($documentId, $client_id){
        if(empty($documentId) || empty($client_id)){
            return false;
        }
        $this->db->where('id', $documentId);
        $this->db->where('idpresupuesto', $client_id);
        return $this->db->delete($this->table);
    }
    
}
<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/25/15
 * Time: 12:39 AM
 */
class LeadDocumentModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_documents($idcliente)
    {
        $query="SELECT
                id,
                fecha,
                IF(nombre IS NULL OR nombre = '','Document',nombre) AS nombre,
                doclink,
                IF(visible IS NULL OR visible = 0,'NO','SI') AS visible,
                IF(docblob IS NULL OR docblob = '',0,1) AS docblob,
                documento
                FROM
                presupuesto_doc
                WHERE idpresupuesto = $idcliente";

        return $this->db->query($query)->result_array();
    }

    public function delete_documentos($documentId)
    {
        $query="DELETE
                FROM
                presupuesto_doc
                WHERE id = $documentId";

        return $this->db->query($query);
    }

    public function insert_document($idpresupuesto,$fecha,$nombre,$doclink,$visible=0)
    {
        $query="INSERT INTO presupuesto_doc(fecha,nombre,doclink,visible,idpresupuesto) VALUES (CURDATE(),'".$nombre."','".$doclink."',$visible,$idpresupuesto)";

        return $this->db->query($query);
    }
    

}
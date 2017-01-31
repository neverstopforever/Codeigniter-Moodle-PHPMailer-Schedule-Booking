<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/28/15
 * Time: 1:03 PM
 */
class DocumentTemplateModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_templates_list()
    {
        $query = "SELECT
                  id,
                  Nombre
                  FROM
                  lst_plantillas";

        $result=$this->db->query($query);

        return $result->result_array();
    }

    public function get_single_document($id)
    {
        $query = "SELECT
                  id,
                  Nombre,
                  documento,
                  DocAsociado
                  FROM
                  lst_plantillas where id=$id";

        $result=$this->db->query($query);

        return $result->result_array();
    }
}
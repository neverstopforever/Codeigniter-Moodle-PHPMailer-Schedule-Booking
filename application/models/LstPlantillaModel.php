<?php

class LstPlantillaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "lst_plantillas";
    }

    public function getDocumentos($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT lp.id,lp.DocAsociado FROM lst_plantillas AS lp
					LEFT JOIN lst_plantillas_cat AS lc
					ON lp.`id_cat` = lc.`id`
					where lp.`id_cat`=$id ORDER BY lp.DocAsociado;";

        return $this->selectCustom($query);
    }

    public function getDocumentoData($id = null) {

        if (!$id) {
            return null;
        }
        $query = "SELECT id,Nombre,DocAsociado,webDocumento from lst_plantillas where id=" . $id;

        return $this->selectCustom($query);
    }

    public function getById($id){
        if (!$id) {
            return null;
        }
        $query = "SELECT * FROM lst_plantillas WHERE id = '" . $id . "'";

        return $this->selectCustom($query);
    }

    public function getByCatId($cat_id){
        $query = $this->db->select('*')
                 ->from($this->table)
                 ->where('id_cat', $cat_id)
                 ->get();

        return $query->result();
    }
}
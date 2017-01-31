<?php

class LstPlantillasCatModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "lst_plantillas_cat";
    }

    public function getPlantillasCat() {

        $query = "SELECT id, nombre FROM lst_plantillas_cat WHERE id IN (1,7) ORDER BY 2";

        return $this->selectCustom($query);
    }


    public function getPlantillasCatById($cat_id = null) {

        if (!$cat_id) {
            return null;
        }
        $query = "SELECT id,nombre from lst_plantillas_cat WHERE id = '".$cat_id."' ";

        return $this->selectCustom($query);
    }

    public function getPlantillasCatByNumbre($numbre = null) {

        if (!$numbre) {
            return null;
        }
        $query = "SELECT id,nombre from lst_plantillas_cat WHERE nombre = '".$numbre."' ";

        return $this->selectCustom($query);
    }
}
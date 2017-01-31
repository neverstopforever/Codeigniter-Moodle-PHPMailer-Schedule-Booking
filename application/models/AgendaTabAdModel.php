<?php

class AgendaTabAdModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "agenda_tab_ad";
    }

    public function getByIndice($indice = null) {
        if(!$indice){
            return null;
        }
        $sql = "SELECT * FROM `agenda_tab_ad` WHERE `Indice` =  '".$indice."'";

        return $this->selectCustom($sql);
    }

    public function get_col_info() {
        return $this->db->list_fields($this->table);
    }

    public function update_or_insert($matricula, $campos, $ncampos = null, $indice, $accion) {

        $count_campos = count($campos);

        if($accion == "update"){

            $sql="UPDATE agenda_tab_ad SET Matricula='".$matricula."'";
            for($i=0; $i < $count_campos; $i++){
                $sql .=",`". $ncampos[$i]."`='".$campos[$i]."'";
            }
            $sql.=" WHERE indice = ".$indice;
            return $this->custom_sql($sql);

        }else if($accion == "insert"){

            $sql="INSERT INTO agenda_tab_ad ";
            $sql .=" VALUES (".$matricula.",".$indice;
            for($i=0;$i < $count_campos; $i++){
                $sql .=",'".$campos[$i]."'";
            }
            $sql.=")";
            return $this->custom_sql($sql);
        }

        return false;
    }


}
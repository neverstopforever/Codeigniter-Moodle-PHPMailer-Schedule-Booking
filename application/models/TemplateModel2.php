<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of templateModel
 *
 * @author Basit Ullah
 */
class TemplateModel2 extends MagaModel {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->table = "lst_plantillas";
        $this->tableName = "lst_plantillas";
        $this->CattableName = "lst_plantillas_cat";
        $this->GrouptableName = "lst_gruposparams";
        $this->CounsltastableName = "lst_consultas";
    }

    public function getAllTemplates($categoryId = false, $limit = 10, $show_more = 1) {
        if ($categoryId > 0) {
            $this->db->where("id_cat", $categoryId);
        }
        $this->db->select("$this->tableName.id, $this->tableName.Nombre, $this->tableName.Descripcion, $this->tableName.DocAsociado, "
            . "$this->tableName.idgrupop, $this->tableName.id_cat, $this->tableName.macro, $this->CattableName.nombre AS cat_name, $this->GrouptableName.Grupo,$this->tableName.temp_filename");
        $this->db->join($this->CattableName, $this->tableName . ".id_cat = " . $this->CattableName . ".id");
        $this->db->join($this->GrouptableName, $this->tableName . ".idgrupop = " . $this->GrouptableName . ".id");

        if($show_more > 1){
            $offset = $show_more * $limit - $limit;
            $this->db->limit($limit, $offset);
        }else{
            $this->db->limit($limit);
        }

        $query = $this->db->get($this->tableName);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getAllCategories() {
        $query = $this->db->get($this->CattableName);
        $categoryArray = array();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $categoryArray;
        }
    }

    public function addTemplate($formData = false, $content = false, $fileName = false) {
        if ($formData) {

            $documento = "";
            $DocAsociado = "";
            $MDB = "";
            $macros = "";
            if ($formData["templateId"] > 0) {
                $templateDetail = $this->getTemplateById($formData["templateId"]);
//                $documento = isset($templateDetail->documento) ? $templateDetail->documento : "";
//                $DocAsociado = isset($templateDetail->DocAsociado) ? $templateDetail->DocAsociado : "";
                $MDB = isset($templateDetail->MDB) ? $templateDetail->MDB : "";
            }
            if ((isset($formData["filename"]) && $formData["filename"] != "") && (isset($formData["data"]) && $formData["data"])) {
                $documento = $formData["data"];
                $DocAsociado = str_replace(" ", "-", $formData["filename"]);
            }
            if( (isset($formData["macro"]) && $formData["macro"] != "") && (isset($formData["macrosField"]) && $formData["macrosField"] != "") ) {
                $macros = $formData["macro"]."([".$formData["macrosField"]."])";
            }
            mysql_connect($this->db->hostname, $this->db->username, $this->db->password);
            mysql_select_db($this->db->database);
            $query = "INSERT INTO `lst_plantillas` "
                . "(Nombre, DocAsociado, MDB, id_cat, Descripcion, documento, macro) "
                . "VALUES "
                . "('" . $formData["Nombre"] . "', "
                . "'" . $DocAsociado . "', "
                . "'" . $MDB . "', "
                . "'" . $formData["id_cat"] . "', "
                . "'" . $formData["Descripcion"] . "', "
                . "'" . $documento . "', "
                . "'" . $macros . "' "
                . ")";
            $results = mysql_query($query) or die(mysql_error());
            $insert_id = mysql_insert_id();
            return $insert_id;
        } else {
            return 0;
        }
    }

    public function addTemplateWithAws($formData = false, $content = false, $fileName = false) {
        if ($formData) {
            $documento = "";
            $DocAsociado = "";
            $MDB = "";
            $macros = "";
            if ($formData["templateId"] > 0) {
                $templateDetail = $this->getTemplateById($formData["templateId"]);
//                $documento = isset($templateDetail->documento) ? $templateDetail->documento : "";
//                $DocAsociado = isset($templateDetail->DocAsociado) ? $templateDetail->DocAsociado : "";
                $MDB = isset($templateDetail->MDB) ? $templateDetail->MDB : "";
            }
            if ((isset($formData["filename"]) && $formData["filename"] != "") && (isset($formData["data"]) && $formData["data"])) {
                $documento = $formData["data"];
                $DocAsociado = str_replace(" ", "-", $formData["filename"]);
            }
            if( (isset($formData["macro"]) && $formData["macro"] != "") && (isset($formData["macrosField"]) && $formData["macrosField"] != "") ) {
                $macros = $formData["macro"]."([".$formData["macrosField"]."])";
            }
            $data_lst_plantillas = array(
                'Nombre' => $formData["Nombre"],
                'DocAsociado' => $DocAsociado,
                'MDB' => $MDB,
                'id_cat' => $formData["id_cat"],
                'Descripcion' => $formData["Descripcion"],
                'temp_filename' => $formData["temp_filename"],
                'documento' => $documento,
                'macro' => $macros,
                'aws_link' => isset($formData["aws_link"]) ? $formData["aws_link"] : null
            );

            return $this->insert($this->tableName, $data_lst_plantillas);
        } else {
            return 0;
        }
    }

    public function getTemplateById($templateId = false) {
        $this->db->select("*, LENGTH(documento) AS fileSize");
        $this->db->where("id", $templateId);
        $query = $this->db->get($this->tableName);
        $templateArray = array();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $templateArray;
        }
    }

    public function editTemplate($formData = false, $content = false, $fileName = false) {
        if ($formData) {
            $documento = "";
            $DocAsociado = "";
            $MDB = "";
            $macros = "";
            if (isset($formData["templateId"]) && $formData["templateId"] > 0) {
//                $templateDetail = $this->getTemplateById($formData["templateId"]);
//                $documento = isset($templateDetail->documento) ? $templateDetail->documento : "";
//                $DocAsociado = isset($templateDetail->DocAsociado) ? $templateDetail->DocAsociado : "";
//                $MDB = isset($templateDetail->MDB) ? $templateDetail->MDB : "";
            }
            if( (isset($formData["macro"]) && $formData["macro"] != "") && (isset($formData["macrosField"]) && $formData["macrosField"] != "") ) {
                $macros = $formData["macro"]."([".$formData["macrosField"]."])";
            }
            if ((isset($formData["filename"]) && $formData["filename"] != "") && (isset($formData["data"]) && $formData["data"])) {
                $documento = $formData["data"];
                $DocAsociado = str_replace(" ", "-", $formData["filename"]);

                $data_lst_plantillas = array(
                    'Nombre' => $formData["Nombre"],
                    'DocAsociado' => $DocAsociado,
                    'MDB' => $MDB,
                    'id_cat' => $formData["id_cat"],
                    'Descripcion' => $formData["Descripcion"],
                    'temp_filename' => $formData["temp_filename"],
                    'documento' => $documento,
                    'macro' => $macros,
                    'aws_link' => isset($formData["aws_link"]) ? $formData["aws_link"] : null
                );
            } else {
                $data_lst_plantillas = array(
                    "Nombre" => $formData["Nombre"],
                    "Descripcion" => $formData["Descripcion"],
                    'temp_filename' => $formData["temp_filename"],
                    "macro" => $macros
                );
            }

            return $this->update($this->tableName, $data_lst_plantillas, array('id'=>$formData["template_id"]));

        }
        return 0;
    }

    public function deleteTemplate($templateId) {
        if(!$templateId){
            return false;
        }
        return $this->delete($this->tableName, array('id'=>$templateId));
    }

    public function getMacrosByCatId($catId) {
        $query = $this->db->query("SELECT CONCAT(REPLACE(t1.valor,'$$$',' '),' ') AS query 
                                    FROM (SELECT valor FROM lst_consultas WHERE id_cat = '".$catId."') AS t1
                                    LIMIT 1
                                    ;");
        if($query->num_rows() > 0) {
            $macroQuery = $query->row();
            if(isset($macroQuery->query) && $macroQuery->query != "") {
                $realQuery = str_replace("LIMIT 0", " ", $macroQuery->query);
                $Mquery = $this->db->query($realQuery);
                if($Mquery->num_rows() > 0) {
                    return $Mquery->list_fields();
                }
            }
        }
    }

    public function getOptionsByCatId($catId) {
        $shortcoderesult = false;
        $this->db->select("valor AS sql_query");
        $this->db->where("id_cat", $catId);
        $this->db->limit('1');
        $query = $this->db->get($this->CounsltastableName);
        $shortcodequery  = $query->result_array();
        if(!empty($shortcodequery)) {
            $shortcodequery = str_replace("$$$", "", $shortcodequery[0]['sql_query']);
            $result = $this->db->query($shortcodequery . " limit 1");
            $shortcoderesult = $result->result_array();
        }
        return $shortcoderesult;
    }
}

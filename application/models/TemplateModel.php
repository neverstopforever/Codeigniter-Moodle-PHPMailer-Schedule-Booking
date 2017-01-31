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
class TemplateModel extends MagaModel {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->table = "erp_templates";
        $this->tableName = "erp_templates";
        $this->CattableName = "lst_plantillas_cat";
        $this->GrouptableName = "lst_gruposparams";
		$this->CounsltastableName = "lst_consultas";
    }

    public function getAllTemplates($categoryId = false, $limit = 10, $show_more = 1) {
        if ($categoryId > 0) {
            $this->db->where("id_cat", $categoryId);
        }
        $this->db->select("$this->tableName.id, $this->tableName.Nombre, $this->tableName.Descripcion,  "
                . "$this->tableName.idgrupop, $this->tableName.id_cat,  $this->CattableName.nombre AS cat_name, $this->GrouptableName.Grupo,");
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
    public function getAllUsersTemplates($id = null) {

        if (!$id) {
            return null;
        }

        $query = "SELECT lp.id,lp.nombre, lp.descripcion FROM erp_templates AS lp
					LEFT JOIN lst_plantillas_cat AS lc
					ON lp.`id_cat` = lc.`id`
					where lp.`id_cat`=$id ORDER BY lp.nombre;";

        return $this->selectCustom($query);
    }

    public function addTemplateToBase($formData = false, $content = false) {
        if ($formData) {
            $data_lst_plantillas = array(
                'nombre' => $formData["nombre"],
                'id_cat' => $formData["id_cat"],
                'descripcion' => $formData["description"],
                'content'=>$content
            );

            return $this->insert($this->tableName, $data_lst_plantillas);
        } else {
            return 0;
        }
    }

    public function getTemplateById($templateId = false) {
        $this->db->select("*");
        $this->db->where("id", $templateId);
        $query = $this->db->get($this->tableName);
        $templateArray = array();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $templateArray;
        }
    }

    public function editTemplate($formData = false, $content = false) {
        if ($formData) {
            $data_lst_plantillas = array(
                "nombre" => $formData["nombre"],
                "descripcion" => $formData["description"],
                "content" =>$content
            );

            return $this->update($this->tableName, $data_lst_plantillas, array('id'=>$formData["templateId"]));
			
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

    public function getTemplateByIdAndCatId($templateId = false, $cat_id = false) {
        $this->db->select("*");
        $this->db->where("id", $templateId);
        $this->db->where("id_cat", $cat_id);
        $query = $this->db->get($this->tableName);
        $templateArray = array();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $templateArray;
        }
    }
}

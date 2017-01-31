<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanyModel
 *
 * @author Basit Ullah
 */
class CompanyModel extends MagaModel {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->table = "campañas";
    }

    public function getCompantBtId($companyId = false) {
        $query = $this->db->query("SELECT cli.* FROM
                                clientes AS cli 
                                LEFT JOIN clientes_tab_ad 
                                  ON cli.ccodcli = clientes_tab_ad.ccodcli  
                                WHERE cli.ccodcli = '" . $companyId . "'
                                ORDER BY 1
                                ");
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
//            echo "<pre>";
//            print_r($result);
            return $result;
        }
    }
    
    public function getCompantByIdFields($companyId = false) {
        $query = $this->db->query("SELECT cli.* FROM
                                clientes AS cli 
                                LEFT JOIN clientes_tab_ad 
                                  ON cli.ccodcli = clientes_tab_ad.ccodcli  
                                WHERE cli.ccodcli = '" . $companyId . "'
                                ORDER BY 1
                                ");
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $query->list_fields();
        }
    }
    
    public function getLeadById($companyId = false) {
        $query = $this->db->query("SELECT *,CAST(presupuestot.Nacimiento AS DATE) As Nacimiento from presupuestot
LEFT JOIN campañas ON campañas.IdCampaña = presupuestot.Campaña
LEFT JOIN medios ON medios.IdMedio = presupuestot.medio WHERE presupuestot.NumPresupuesto = '$companyId'
                                ");
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
    }
    public function getLeadByIdFields($companyId = false) {
        $query = $this->db->query("SELECT *,CAST(presupuestot.Nacimiento AS DATE) As Nacimiento from presupuestot
LEFT JOIN campañas ON campañas.IdCampaña = presupuestot.Campaña
LEFT JOIN medios ON medios.IdMedio = presupuestot.medio WHERE presupuestot.NumPresupuesto = '$companyId'
                                ");
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $query->list_fields();
        }
    }

    public function getCampaign() {
        $query = 'SELECT ca.IdCampaña AS id, ca.Descripcion AS description FROM campañas AS ca ORDER BY 2';
        return $this->selectCustom($query);
    }
    public function getAllCampaigns() {
        $query = 'SELECT ca.IdCampaña AS id, ca.Descripcion AS text FROM campañas AS ca ORDER BY 2';
        return $this->selectCustom($query);
    }

    public function getNotExistCampaigns($client_id){
        if(!$client_id){
            return null;
        }
        $query = "SELECT
                      idcampaña AS `campaign_id`,
                      descripcion AS `campaign`
                    
                    FROM campañas
                    
                    WHERE idcampaña NOT IN
                          (
                            SELECT campaña FROM presupuestot WHERE numpresupuesto = $client_id
                                                                   AND campaña IS NOT NULL
                          )
                    
                    ;";
        return  $this->selectCustom($query);
    }

}

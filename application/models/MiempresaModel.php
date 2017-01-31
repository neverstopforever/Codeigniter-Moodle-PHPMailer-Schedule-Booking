<?php

class MiempresaModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "miempresa";
    }

   public function getCompany(){
       $query = $this->db->select('nombrefiscal AS fiscal_name,
                        nombrecomercial AS commercial_name,
                        domicilio AS address,
                        poblacion AS city,
                        provincia AS province,
                        distrito AS postal_code,
                        telefono AS phone,
                        pais AS country,
                        titular AS incumbent,
                        iban AS bank_iban,
                        email,
                        sufijo AS bank_sufix')
                ->from($this->table)
                ->get();

       return $query->row();
   }
    public function getCompanyCommercialName(){
        $query = $this->db->select('nombrecomercial AS commercial_name')
            ->from($this->table)
            ->get();

        return $query->row();
    }

   public function get_fiscal_data(){
       $query = $this->db->select('
       `nombrefiscal` AS `fiscal_name`, 
       `domicilio` AS `address`, 
       `poblacion` AS `city`, 
       `provincia` AS `province`, 
       `distrito` AS `postal_code`, 
       `telefono` AS `phone`, 
       `pais` AS `country`, 
       nif AS fiscal_code')
                ->from($this->table)
                ->get();

       return $query->row();
   }

    public function updateCompany($update_data){
        return $this->db->update($this->table, $update_data);
    }

}
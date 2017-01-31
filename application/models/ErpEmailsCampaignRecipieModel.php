<?php

class ErpEmailsCampaignRecipieModel extends MagaModel {

    public $id;
    public $id_campaign;
    public $email_recipie;

    public function __construct() {
        parent::__construct();
        $this->table = "erp_emails_campaign_recipies";
    }

    public function addItem($data = null) {

        if(empty($data) || !isset($data['id_campaign']) || empty($data['id_campaign'])
            || !isset($data['email_recipie']) || empty($data['email_recipie'])
        ){
            return false;
        }

        return $this->insert($this->table, $data);

    }

    public function getByCompaignId($id_compaign = null) {

        if(empty($id_compaign) || !is_numeric($id_compaign)
        ){
            return false;
        }

        return $this->selectAllWhere($this->table, array('id_campaign'=>$id_compaign));

    }

    public function updateByCampaignId($id_compaign = null, $data = null) {

        if(empty($id_compaign) || !is_numeric($id_compaign)
            || empty($data)
            || !isset($data['email_recipie']) || empty($data['email_recipie'])
        ){
            return false;
        }
        return $this->update($this->table, $data, array('id_campaign'=>$id_compaign));
    }

    public function deleteByCampaignId($id_compaign) {

        if(empty($id_compaign) || !is_numeric($id_compaign)){
            return false;
        }
        return $this->delete($this->table, array('id_campaign'=>$id_compaign));
    }
}
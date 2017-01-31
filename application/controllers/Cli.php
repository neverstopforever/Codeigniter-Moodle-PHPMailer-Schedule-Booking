<?php

/**
 * Class Cli
 * @property ClientesAkaudModel $ClientesAkaudModel
 */
class Cli extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!is_cli()){
            log_message('error','not cli request');
            exit;
        }
    }


    public function downgrade_plan_free(){

        $file_path = FCPATH.'app/plan_fields.json';
        $fields = array();
        $update_data = array();
        if(file_exists($file_path)) {
            $plan_json_fields = file_get_contents($file_path);
            $fields = json_decode($plan_json_fields);
        }
        if(!empty($fields)){
            foreach ($fields as $k=>$field){
                if($field->plan == 1){
                    $update_data = (array)$field;
                    break;
                }
            }
        }

        if(!empty($update_data)){
            $update_data['paid'] = 0;
            $this->load->model('ClientesAkaudModel');
            $updated = $this->ClientesAkaudModel->downgrade_plan_free($update_data);
            if($updated){
                $this->load->model('Variables2Model');
                $this->Variables2Model->deleteLogo();
                log_message('error', $this->lang->line('downgrade_to_free_plan')); //success
            }else{
                log_message('error', $this->lang->line('db_err_msg'));
            }
        }else{
            log_message('error','Something whent wrong with plan_fields.json file free plan');
        }
    }
}

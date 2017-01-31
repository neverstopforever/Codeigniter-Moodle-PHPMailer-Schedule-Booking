<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prospects extends Base_api {

    public function __construct() {
        parent::__construct();        
        $this->load->model('PresupuestotModel');
        $this->load->model('Variables2Model');
        $this->load->library('form_validation');
    }

    public function index_get() {

        $prospects = $this->PresupuestotModel->get_prospects_data();

        $prospect_id = $this->get('prospect_id');

        // If the id parameter doesn't exist return all the contacts
        if ($prospect_id === NULL)
        {
            // Check if the contacts data store contains contacts (in case the database result returns NULL)
            if ($prospects)
            {
                // Set the response and exit
                $this->response($prospects, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => $this->lang->line('api_prospects_no_prospects')
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular contact.
        $prospect_id = (int) $prospect_id;

        // Validate the id.
        if ($prospect_id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }



        // Get the contact from the array, using the id as key for retreival.
        // Usually a model is to be used for this.
        $prospect = NULL;

        if (!empty($prospects))
        {
            foreach ($prospects as $key => $value)
            {
                if (isset($value->prospect_id) && (int)$value->prospect_id === $prospect_id)
                {
                    $prospect = $value;
                    break;
                }
            }
        }


        if (!empty($prospect))
        {
            $this->set_response($prospect, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => $this->lang->line('api_prospects_not_found')
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


    public function add_blank_lead_post() {
        $response['status'] = false;
        $response['message'] = null;

        $post_data = $this->post();

        if(empty($post_data)){
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_NOT_FOUND;
            $this->response($response, $http_code);
        }

        $this->config->set_item('language', $this->data['lang']);
        $this->form_validation->set_rules("Nombre", $this->lang->line('leads_first_name'),"trim|required");
        $this->form_validation->set_rules("sApellidos", $this->lang->line('leads_surname'),"trim|required");
        if ($this->form_validation->run() == false) {
            $response['message'] = $this->form_validation->error_array();
            $http_code = REST_Controller::HTTP_NOT_FOUND;
        } else {
            $leadId = $this->Variables2Model->updateNumpresupuesto();
            $leadId = trim($leadId);

            $response['new_prospect_id'] = null;
            $insert_data = $this->makeBlankInsertData($post_data);
            $insert_data['NumPresupuesto'] = $leadId;
            $added = $this->PresupuestotModel->addLeadsRecords($insert_data);
            if($added){
                $response['new_prospect_id'] = $leadId;
                $response['status'] = true;
                $response['message'] = $this->lang->line('api_prospects_added_success');
                $http_code = REST_Controller::HTTP_OK;
            }else{
                $response['message'] = $this->lang->line('db_err_msg');
                $http_code = REST_Controller::HTTP_NOT_FOUND;
            }
        }

        //Set the response and exit.
        $this->response($response, $http_code);
    }


    public function add_from_existing_post() {
        $response['status'] = false;
        $response['message'] = null;

        $post_data = $this->post();

        if(empty($post_data)){
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_NOT_FOUND;
            $this->response($response, $http_code);
        }

        $this->config->set_item('language', $this->data['lang']);
        $this->form_validation->set_rules("user_id", $this->lang->line('user_id'),"trim|required|is_natural_no_zero");
        $this->form_validation->set_rules("profile_id", $this->lang->line('profile_id'),"trim|required|is_natural_no_zero");
        if ($this->form_validation->run() == false) {
            $response['message'] = $this->form_validation->error_array();
            $http_code = REST_Controller::HTTP_NOT_FOUND;
        } else {
            $leadId = $this->Variables2Model->updateNumpresupuesto();
            $leadId = trim($leadId);
            $response['new_prospect_id'] = null;
            $user_id = $this->post('user_id');
            $profile_id = $this->post('profile_id');
            $added = $this->PresupuestotModel->addExistingUser($leadId, $user_id, $profile_id);
            if($added){
                $response['new_prospect_id'] = $leadId;
                $response['status'] = true;
                $response['message'] = $this->lang->line('api_prospects_added_success');
                $http_code = REST_Controller::HTTP_OK;
            }else{
                $response['message'] = $this->lang->line('db_err_msg');
                $http_code = REST_Controller::HTTP_NOT_FOUND;
            }
        }

        //Set the response and exit.
        $this->response($response, $http_code);
    }

    private function makeBlankInsertData($post_data){
        $response = array(
            'Nombre' => isset($post_data['Nombre']) ? $post_data['Nombre'] : null,
            'sApellidos' => isset($post_data['sApellidos']) ? $post_data['sApellidos'] : null
        );
        return $response;
    }
    
 }

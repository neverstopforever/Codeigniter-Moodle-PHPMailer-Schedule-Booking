<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactos extends Base_api
{
    public function __construct()
    {
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
//        $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
//        $this->methods['index_post']['limit'] = 500; // 500 requests per hour per user/key
//        $this->methods['contact_post']['limit'] = 100; // 100 requests per hour per user/key
//        $this->methods['contact_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('ContactosModel');
        $this->load->model('ErpConsultaModel');
        $this->load->model('ClientModel');
        $this->load->library('form_validation');
    }

    public function index_get() {

        $data['page']='Data Records';
        $contacts = $this->ContactosModel->getList();
        
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the contacts
        if ($id === NULL)
        {
            // Check if the contacts data store contains contacts (in case the database result returns NULL)
            if ($contacts)
            {
                // Set the response and exit
                $this->response($contacts, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => $this->lang->line('api_contacts_no_contacts')
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular contact.
        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }



        // Get the contact from the array, using the id as key for retreival.
        // Usually a model is to be used for this.
        $contact = NULL;

        if (!empty($contacts))
        {
            foreach ($contacts as $key => $value)
            {
                if (isset($value->id) && (int)$value->id === $id)
                {
                    $contact = $value;
                    break;
                }
            }
        }


        if (!empty($contact))
        {
            $this->set_response($contact, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => $this->lang->line('api_contacts_not_found')
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_post()
    {

        $post_data = $this->post();

        if(!empty($post_data)){

            $this->set_response($post_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'status' => FALSE,
                'message' => $this->lang->line('api_contacts_not_found')
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function add_post()
    {
        $response['status'] = false;
        $response['message'] = null;

        $this->config->set_item('language', $this->data['lang']);
        $config = array(
            array(
                'field' => 'email',
                'label' => $this->lang->line('email'),
                'rules' => 'trim|valid_email'
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $response['here'] = 1;
            $response['message'] = $this->form_validation->error_array();
            $http_code = REST_Controller::HTTP_NOT_FOUND;
        } else {
            $post_data = $this->post();
//            $response['here'] = 2;
//            $response['post_data'] = $post_data;
//            $this->response($response, REST_Controller::HTTP_OK);

            $newID = $this->magaModel->maxID('contactos', 'Id');
            $newID = $newID[0]->Id + 1;


            $insert_data = $this->makeInsertData($post_data);
            $insert_data['Id'] = $newID;
            $response['new_content_id'] = $this->magaModel->insert('contactos',$insert_data);
            if($response['new_content_id']){
                $response['status'] = true;
                $response['message'] = $this->lang->line('api_contacts_added_success');
                $http_code = REST_Controller::HTTP_OK;
            }else{
                $response['message'] = $this->lang->line('db_err_msg');
                $http_code = REST_Controller::HTTP_NOT_FOUND;
            }
        }
        //Set the response and exit.
        $this->response($response, $http_code);
    }

    public function edit_post()
    {
        $response['status'] = false;
        $response['message'] = null;

        $id = $this->post('Id');
        if(empty($id) || !is_numeric($id)){
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_NOT_FOUND;
            //Set the response and exit.
            $this->response($response, $http_code);
        }

        $post_data = $this->post();
        $update_data = $this->makeInsertData($post_data);

        $response['status'] = $this->magaModel->update('contactos', $update_data, array('Id' => $id));
        if($response['status']){
            $response['message'] = $this->lang->line('api_contacts_updated_success');
            $http_code = REST_Controller::HTTP_OK;
        }else{
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_NOT_FOUND;
        }
        //Set the response and exit.
        $this->response($response, $http_code);
    }
    
    public function delete_delete($contact_id = null)
    {
        $response['status'] = false;
        $response['message'] = null;
        
        if(empty($contact_id) || !is_numeric($contact_id)){
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_NOT_FOUND;
            //Set the response and exit.
            $this->response($response, $http_code);
        }
        $response['status'] = $this->ContactosModel->delete($contact_id);
        if($response['status']){
            $response['message'] = $this->lang->line('api_contacts_deleted_success');
            $http_code = REST_Controller::HTTP_OK;
        }else{
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_NOT_FOUND;
        }
        //Set the response and exit.
        $this->response($response, $http_code);
    }    

    private function makeInsertData($post_data){
        $response = array(
            'Snombre' => isset($post_data['Snombre']) ? $post_data['Snombre'] : null,
            'Sapellidos' => isset($post_data['Sapellidos']) ? $post_data['Sapellidos'] : null,
            'Domicilio' => isset($post_data['Domicilio']) ? $post_data['Domicilio'] : null,
            'Poblacion' => isset($post_data['Poblacion']) ? $post_data['Poblacion'] : null,
            'Provincia' => isset($post_data['Provincia']) ? $post_data['Provincia'] : null,
            'Distrito' => isset($post_data['Distrito']) ? $post_data['Distrito'] : null,
            'Telefono1' => isset($post_data['Telefono1']) ? $post_data['Telefono1'] : null,
            'Telefono2' => isset($post_data['Telefono2']) ? $post_data['Telefono2'] : null,
            'Movil' => isset($post_data['Movil']) ? $post_data['Movil'] : null,
            'Pais' => isset($post_data['Pais']) ? $post_data['Pais'] : null,
            'email' => isset($post_data['email']) ? $post_data['email'] : null,
            'nif' => isset($post_data['nif']) ? $post_data['nif'] : null,
            'fnacimiento' => isset($post_data['fnacimiento']) ? $post_data['fnacimiento'] : null,
            'skype' => isset($post_data['skype']) ? $post_data['skype'] : null,
            'Idsexo' => isset($post_data['Idsexo']) ? $post_data['Idsexo'] : 1,
            'iban' => isset($post_data['iban']) ? $post_data['iban'] : null,
            'Cc1' => isset($post_data['Cc1']) ? $post_data['Cc1'] : null,
            'Cc2' => isset($post_data['Cc2']) ? $post_data['Cc2'] : null,
            'Cc3' => isset($post_data['Cc3']) ? $post_data['Cc3'] : null,
            'Cc4' => isset($post_data['Cc4']) ? $post_data['Cc4'] : null,
//            'facturara' => isset($post_data['company_changed_id']) ? $post_data['company_changed_id'] : 0,
            'seguimiento' => isset($post_data['seguimiento']) ? $post_data['seguimiento'] : '',
        );
        if(isset($post_data['facturara'])){
            $response['facturara'] = $post_data['facturara'];
        }elseif(isset($post_data['company_changed_id'])){
            $response['facturara'] = $post_data['company_changed_id'];
        }else{
            $response['facturara'] = 0;
        }
//        var_dump($post_data, $response);die;
        return $response;
    }
}

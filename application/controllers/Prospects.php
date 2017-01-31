<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;

class Prospects extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->_identity['loggedIn'])) {
            redirect('/auth/login/', 'refresh');
        }

        $this->load->library('form_validation');
        $this->layouts->add_includes('js', 'app/js/leads/main.js');
    }

    public function index() {
        $this->load->model('ErpTagsModel');
        $this->layouts->add_includes('css', 'assets/global/plugins/select2/select2.css');
        $this->layouts->add_includes('js', 'assets/global/plugins/select2/select2.js');
        $this->layouts->add_includes('js', 'app/js/prospects/index.js');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->lang->load('quicktips', $this->data['lang']);
//        $details = $this->magaModel->selectAll('clientes');
        $ckeyslang = $this->my_language->load('column_key');
        $this->data['page'] = 'leads';
        $this->load->model("UsuarioModel");
        $this->data['users'] = $this->UsuarioModel->get_users();
        $countries = $this->db->get('estado_solicitud');
        $this->data['state'] = $countries->result();
        $this->data['dataKeys'] = $ckeyslang;

        $this->load->model('PresupuestotModel');
        $this->data['state'] = $this->PresupuestotModel->get_states();
        $this->data['top_bar_data'] = $this->PresupuestotModel->get_prospects_top_bar();
        $this->data['prospects_data'] = $this->PresupuestotModel->get_prospects_data();
        $this->data['content'] = $this->PresupuestotModel->getList();
        //Filtring data
        $this->load->model('MedioModel');
        $this->data['names'] = array();
        $this->data['source'] = $this->MedioModel->getSourceForFilter();

        $this->load->model('CompanyModel');
        $this->data['campaign'] = $this->CompanyModel->getAllCampaigns();
        $this->data['score'] = array();
        foreach($this->data['state'] as $state){
            $this->data['state_data'][] = array('id' => $state->id, 'text' => $state->valor, 'color' => $state->color);
        }
        $this->data['stars_data'] = [
            array('id' => 0, 'text' => $this->lang->line("priority_normal")),
            array('id' => 1, 'text' => $this->lang->line("priority_high")),
            array('id' => 2, 'text' => $this->lang->line("priority_veryhigh")),
        ];
        if(!empty($this->data['prospects_data'])){
            foreach($this->data['prospects_data'] as $prospect){
                if(!empty($prospect->contact_name)) {
                    $this->data['names'][] = array('id' => $prospect->prospect_id, 'text' => $prospect->contact_name);
                }
                if(!empty($prospect->prospect_score)) {
                    $this->data['score'][] = array('id' => $prospect->prospect_score, 'text' => $prospect->prospect_score);
                }
            }
        }
        $this->data['tags'] =  $this->ErpTagsModel->getTags();
        $tags_group_by_tag_id = array();
        $tags_for_filter = array();
        if(!empty($this->data['tags'])) {
            foreach ($this->data['tags'] as $tags){
                $tags_group_by_tag_id[$tags->id] = $tags;
                $tags_for_filter[] = array('id' => $tags->id, 'text' => $tags->tag_name,
                    'back_color' => $tags->hex_backcolor, 'text_color' => $tags->hex_forecolor);
            }
        }
        $this->data['tags_group_by_tag_id'] = $tags_group_by_tag_id;
        $this->data['tags_for_filter'] = $tags_for_filter;

        $this->layouts->view('prospects/indexView', $this->data);
    }

    public function getProspectsData(){
        $this->load->model('PresupuestotModel');
        $start =$this->input->post('start',  true);
        $length =$this->input->post('length', true);
        $draw = $this->input->post('draw', true);
        $search =$this->input->post('search', true);
        $order = $this->input->post('order', true);
        $columns = $this->input->post('columns', true);

        $filter_tags = (object)array(
            'selected_source' => $this->input->post('selected_source', true),
            'selected_state' => $this->input->post('selected_state', true),
            'selected_campaign' => $this->input->post('selected_campaign', true),
            'selected_score' => $this->input->post('selected_score', true),
            'selected_stars' => $this->input->post('selected_stars', true),
            'selected_names' => $this->input->post('selected_names', true),
            'tag_ids' => $this->input->post('tag_ids', true),
        );


        $column = $order[0]['column'];

        $total_prospects = $this->PresupuestotModel->getTotalCount();
        $prospects_data = $this->PresupuestotModel->get_prospects_data_ajax($start, $length, $draw, $search, $order, $columns, $filter_tags);
        $recordsTotal = (int)$prospects_data->rows;
        $response = array(
            "start"=>$start,
            "length"=>$length,
            "search"=>$search,
            "order"=>$order,
            "column"=>$column,
            "draw"=>$draw,
            "recordsFiltered"=>$recordsTotal,
            "recordsTotal"=>$recordsTotal,
            "data"=>$prospects_data->items,
            "table_total_rows"=> $total_prospects
        );
        echo json_encode($response); exit;
    }

    /*public function add() {

        $this->layouts->add_includes('js', 'app/js/leads_view/add_leads.js');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->data["flashMsg"] = "";
        if ($this->session->flashdata('editMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('editMsg');
        } else if ($this->session->flashdata('addMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addMsg');
        } else if ($this->session->flashdata('deleteMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('deleteMsg');
        } else if ($this->session->flashdata('addErrorMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addErrorMsg');
        }
        $this->data['clienteId'] = $this->session->userdata("userData")[0]->Id;
        $this->load->model("LeadsModel");
        $estado_data = $this->LeadsModel->getEstadoData();
        $this->data['estado_data'] = $estado_data;

        $medios_data = $this->LeadsModel->getMediosData();
        $this->data['medios_data'] = $medios_data;


        $this->data['formData']= $this->input->post(NULL, true);

        if(!empty($this->data['formData'])){
            $this->form_validation->set_rules('Nombre', $this->lang->line('leads_first_name'), 'trim|required');
            $this->form_validation->set_rules('sApellidos', $this->lang->line('leads_surname'), 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

            if($this->form_validation->run()){
                $result = $this->LeadsModel->addLeadsRecords($this->data['formData']);
                if ($result) {
                    $this->session->set_flashdata('success', 'The lead successfully added.');
                    $numPresupuesto = trim($this->data['formData']['NumPresupuesto']);
                    redirect("leads/edit/$numPresupuesto");
                } else {
                    $this->session->set_flashdata('errors', array('There is an error while adding lead!'));
                }
            }else{
                $this->data['form_error'] = true;
            }
        }


        $this->layouts->view("prospects/addView", $this->data);
    }*/

    public function add() {
        $this->load->model('LeadsModel');
        $this->load->model('ContactosModel');
        $this->layouts->add_includes('js', 'app/js/leads_view/add_leads.js');
        $this->lang->load('clientes_form', $this->data['lang']);
        $this->data["flashMsg"] = "";
        if ($this->session->flashdata('editMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('editMsg');
        } else if ($this->session->flashdata('addMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addMsg');
        } else if ($this->session->flashdata('deleteMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('deleteMsg');
        } else if ($this->session->flashdata('addErrorMsg')) {
            $this->data["flashMsg"] = $this->session->flashdata('addErrorMsg');
        }
        $this->data['clienteId'] = $this->session->userdata("userData")[0]->Id;

        $estado_data = $this->LeadsModel->getEstadoData();
        $this->data['estado_data'] = $estado_data;

        $medios_data = $this->LeadsModel->getMediosData();
        $this->data['medios_data'] = $medios_data;


        $this->data['formData']= $this->input->post(NULL, true);

        if(!empty($this->data['formData'])){
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('Nombre', $this->lang->line('leads_first_name'), 'trim|required');
            $this->form_validation->set_rules('sApellidos', $this->lang->line('leads_surname'), 'trim|required');
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|is_unique[presupuestot.email]|is_unique[alumnos.email]|is_unique[contactos.email]');
            $this->form_validation->set_error_delimiters('<div class="text-danger err">', '</div>');

            if($this->form_validation->run()){
                $numPresupuesto = $this->getLeadIncrementedId();
                if($numPresupuesto > 0) {
                    $this->data['formData']['NumPresupuesto'] = $numPresupuesto;
                    $this->data['formData']['Email'] = $this->data['formData']['email'];
                    $result_id = $this->ContactosModel->addRecord($this->data['formData']);
                    if($result_id) {
                        $this->data['formData']['IdAlumno'] = $result_id;

                        $result = $this->LeadsModel->addLeadsRecords($this->data['formData']);
                        if ($result) {
                            $this->load->model('SftConfigEgoiModel');
                            $result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
                            $EgoiList = $this->getEgoiList($result_e_goi->apikey);
                            $params = array(
                                'apikey' => $result_e_goi->apikey,
                                'listID' => $EgoiList[0]['listnum'],
                                'email' => $this->data['formData']['email'],
                                'cellphone' => '',
                                'telephone' => '',
                                'fax' => '',
                                'first_name' => $this->data['formData']['Nombre'],
                                'last_name' => $this->data['formData']['sApellidos'],
                                'birth_date' => '',
                                'status' => '1',
                                'lang' => 'es',
                            );

                            $result_addSubscriber = $this->addSubscriber($params);
                            $this->session->set_flashdata('success', 'The lead successfully added.');
                            $numPresupuesto = trim($this->data['formData']['NumPresupuesto']);
                            $prospect_data = $this->LeadsModel->getProspectDataById($numPresupuesto);
                            $replace_data = array(
                                'FIRSTNAME' => $prospect_data->first_name,
                                'SURNAME' => $prospect_data->last_name,
                                'FULLNAME' => $prospect_data->full_name,
                                //'PHONE1' => $prospect_data->,
                                'MOBILE' => $prospect_data->mobile,
                                'EMAIL1' => $prospect_data->email,
                                //'COURSE_NAME' => $course_data->course_name,
                                'START_DATE' => date('"F j, Y'),
                                'END_DATE' => date('"F j, Y'),
                            );

                            $this->load->model('ErpEmailsAutomatedModel');
                            $template = $this->ErpEmailsAutomatedModel->getByTemplateId('18', array('notify_student' => 1));
                            if (!empty($template) && !empty($prospect_data->email)) {
                                $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                $email_body = replaceTemplateBody($template->Body, $replace_data);
                                $this->send_automated_email($prospect_data->email, $email_subject, $email_body, $template->from_email);
                            }
                            redirect("leads/edit/$numPresupuesto");

                        } else {
                            $this->session->set_flashdata('errors', array('There is an error while adding lead!'));
                        }
                    }else{
                        $this->session->set_flashdata('errors', array('There is an error while adding lead!'));
                    }
                }else{
                    $this->session->set_flashdata('errors', array('There is an error while adding lead!'));
                }
            }else{
                $this->data['form_error'] = true;
            }
        }


        $this->layouts->view("prospects/addView", $this->data);
    }

    private function getEgoiList($apikey){
        if(!empty($apikey)) {
            $params = array(
                'apikey' => $apikey
            );

// using Soap with SoapClient
            $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
            $result = $client->getLists($params);
            return $result;
        }
    }

    private function addSubscriber($params){
        // using Soap with SoapClient
        $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
        $result = $client->addSubscriber($params);
        return $result;
    }

    private function send_automated_email($email, $subject, $body, $from_email){
        $this->load->model('ErpEmailModel');
        $this->load->model('UsuarioModel');
        $user_id = $this->session->userdata('userData')[0]->Id;
        $cisess = $this->session->userdata('_cisess');
        $membership_type = $cisess['membership_type'];
        $smtp_data = $this->UsuarioModel->getSmtpSettings($user_id);
        $data_recipient = array(
            'from_userid' => $user_id,
            'from_usertype' => '0',
            'id_campaign' => '',
            'email_recipie' => $email,
            'Subject' => $subject,
            'Body' => $body,
            'date' => date('Y-m-d H:i:s'),
        );
        if($membership_type != 'FREE' && $smtp_data->mail_provider == 1){
            if($smtp_data->auth_method == 0){
                $smtpSecure = 'ssl';
            }elseif($smtp_data->auth_method == 1){
                $smtpSecure = 'ssl';
            }elseif($smtp_data->auth_method == 2){
                $smtpSecure = 'tls';
            }

            $mail = new PHPMailer();

            $mail->IsSMTP();                                      // set mailer to use SMTP
            $mail->Host = $smtp_data->hostname;  // specify main and backup server
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Port =  $smtp_data->port;
            $mail->SMTPSecure =  $smtpSecure;
            $mail->Username = $smtp_data->user;  // SMTP username
            $mail->Password = $smtp_data->pwd; // SMTP password

            $mail->From =  $smtp_data->user;
            $mail->FromName = '';
            $mail->AddAddress($email);
            $mail->WordWrap = 1000;                                 // set word wrap to 50 characters
            $mail->IsHTML(true);
            // set email format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->AltBody = "";
            if(!$mail->Send()) {
                $response['errors'] = $this->lang->line('enrollments_no_send_email');
            }else {
                $response['success'] = $this->lang->line('enrollments_send_email_success');
                $response['errors'] = false;
                $data_recipient['sucess'] = '1';
                $data_recipient['error_msg'] = ''; ;
            }
            $this->ErpEmailModel->insertEmailData($data_recipient);
        }
        else {
            $emails_limit_daily = $this->_db_details->emails_limit_daily;
            $emails_limit_monthly = $this->_db_details->emails_limit_monthly;
            $count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);

            if ($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly) {
                $amazon = $this->config->item('amazon');
                $email_from = $this->config->item('email');

                $client = SesClient::factory(array(
                    'version' => 'latest',
                    'region' => $amazon['email_region'],
                    'credentials' => array(
                        'key' => $amazon['AWSAccessKeyId'],
                        'secret' => $amazon['AWSSecretKey'],
                    ),
                ));

                $request = array();
                $request['Source'] = $from_email . ' <' . $email_from['from'] . '>';
                $request['Destination']['ToAddresses'] = array($email);
                $request['Message']['Subject']['Data'] = $subject;
                $request['Message']['Subject']['Charset'] = "UTF-8";
                $request['Message']['Body']['Html']['Data'] = $body;
                $request['Message']['Body']['Charset'] = "UTF-8";
                try {
                    $result = $client->sendEmail($request);
                    $messageId = $result->get('MessageId');
                    //echo("Email sent! Message ID: $messageId"."\n");
                    if ($messageId) {
                        $response['success'] = $this->lang->line('enrollments_send_email_success');
                        $response['errors'] = false;
                        $data_recipient['sucess'] = '1';
                        $data_recipient['error_msg'] = ''; //$e->getMessage(),
                    } else {
                        $response['errors'] = $this->lang->line('enrollments_no_send_email');
                    }

                } catch (Exception $e) {
                    //echo("The email was not sent. Error message: ");
                    //$response['errors'] = $e->getMessage()."\n";
                    $response['errors'] = $this->lang->line('enrollments_no_send_email');
                    $data_recipient['sucess'] = '0';
                    $data_recipient['error_msg'] = $e->getMessage();
                }
                $added_email_id = $this->ErpEmailModel->insertEmailData($data_recipient);
            } else {
                $response['errors'] = $this->lang->line('emails_limit_daily_msg');
            }
        }
        return $response;
    }

    public function edit($id) {
        $this->layouts->add_includes('js', 'app/js/leads/edit.js');
        $lang = $this->session->userdata('lang');
        $this->data['lang'] = $lang;
        $this->lang->load('clientes_form', $lang);
        $this->data['page'] = 'Data Records';
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';

        $this->load->model('ErpConsultaModel');
        $sql = $this->ErpConsultaModel->getField($field, 'lst_sol_sol');
        $lsquery = str_replace("@", $id, $lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->data['lst_sol_sol'] = $this->magaModel->selectCustom($lsquery);
        $sql2 = $this->ErpConsultaModel->getField($field, 'sel_cursos');
        $this->data['sel_cursos'] = $this->magaModel->selectCustom($lang == 'english' ? $sql2[0]->sql_en : $sql2[0]->sql_es);
        $countries = $this->db->get('estado_solicitud');
        $this->data['countries'] = $countries->result();

        $this->load->model('PresupuestotModel');
        $this->data['content'] = $this->PresupuestotModel->getContent($id);

        $this->load->model('CompanyModel');
        $this->data['campaign'] = $this->CompanyModel->getCampaign();

        $this->data['personal_fields'] = $this->magaModel->get_where('presupuestos_tab_ad', array('NumPresupuesto' => $id));
        $this->data['documentos'] = $this->documentos($id);
        $this->data['Seguimiento'] = $this->Seguimiento($id);
        $this->data['clienteId'] = $id;
        $this->data['historicAccount'] = $this->historicAccount($id);
        $this->data['HistoricFees'] = $this->HistoricFees($id);
        $this->data['Filiales'] = $this->Filiales($id);
        $this->data['clientes_tab_ad'] = $this->clientes_tab_ad($id);
        $this->data['Adicionales'] = $this->Adicionales($id);
        $this->data['formaspago'] = $this->magaModel->selectAll('formaspago');
        $this->data['medios'] = $this->magaModel->selectAll('medios');
        $this->data['plantillas_cat'] = $this->plantillas_cat();
        $sql = $this->ErpConsultaModel->getField($field, 'lst_empresas');
        $this->data['clientes'] = $this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
        $this->load->model('AlumnoModel');
        $this->data['alumnos'] = $this->AlumnoModel->getAlumnos();

        $ckeyslang = $this->my_language->load('column_key');
        $this->data['dataKeys'] = $ckeyslang;
        $this->data['leadId'] = $id;
        $this->load->model('LstPlantillasCatModel');
        $plantillas_cat = $this->LstPlantillasCatModel->getPlantillasCatByNumbre(strtolower($this->data['controller_name']));
        $this->data['id_cat'] = isset($plantillas_cat[0]->id) ? $plantillas_cat[0]->id : "7";
        $this->data['document_cat'] = $this->get_documentos($this->data['id_cat']);


        $this->layouts->view('leads/editView', $this->data);
    }

    public function filterBytags(){
        if($this->input->is_ajax_request()){
            $selected_source = $this->input->post('selected_source', true);
            $selected_state = $this->input->post('selected_state', true);
            $selected_campaign = $this->input->post('selected_campaign', true);
            $selected_score = $this->input->post('selected_score', true);
            $selected_stars = $this->input->post('selected_stars', true);
            $selected_names = $this->input->post('selected_names', true);

            $this->load->model('PresupuestotModel');
            $prospects = $this->PresupuestotModel->getProspectsByTags($selected_source, $selected_campaign, $selected_state, $selected_stars, $selected_score, $selected_names);
            echo json_encode(array('data' => $prospects));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function get_documentos($id) {
        $this->load->model('LstPlantillaModel');
        return $this->LstPlantillaModel->getDocumentos($id);
        //return json_encode($DocAsociado);
    }

    public function updateinfo_post() {
        $data['alumnos'] = $this->magaModel->updatedata($_POST);
        redirect(base_url('leads/edit/' . $_POST['id'] . '#personalized_fields'));
    }

    public function leads() {
        $lang = $this->session->userdata('lang');
        $data['page'] = 'Data Records';
        // $ckeyslang = $this->my_language->load('contactos_form');
        //$data['dataKeys'] =$ckeyslang;
        $field = $lang == 'english' ? 'sql_en' : 'sql_es';
        //$sql = $this->ErpConsultaModel->getField($field, 'lst_solicitudes');

        $this->load->model('PresupuestotModel');
        $prospects_data = $this->PresupuestotModel->get_prospects_data();
//        echo '<pre />';var_dump($prospects_data);die;
        if(!empty($prospects_data)){
            foreach($prospects_data as $prospect){
                $contact_name = $prospect->contact_name;
                if(strlen($contact_name)>20){
                    $contact_name = substr($prospect->contact_name, 0,20).' ...';
                }
                $full_name = strlen($prospect->contact_name .' From Company'. $prospect->company_name) > 25 ? substr($prospect->contact_name .' From Company'. $prospect->company_name, 0,25).' ...': $prospect->contact_name .' From Company'. $prospect->company_name ;
                $bookmark = '<span class="span_bookmark"><i class="fa fa-star'. ($prospect->prospect_priority == 2 ? '' : '-o') .' bookmark" data-status="true"></i><i class="fa fa-star'. ($prospect->prospect_priority >= 1 ? '' : '-o') .' bookmark" data-status="true"></i><i class="fa fa-star'. ($prospect->prospect_priority >= 0 ? '' : '-o') .'  bookmark" data-status="true"></i></span>';
                $dechex = '#'.$prospect->state_color;
                    $data['content'][] = array(
                    /* dataTable column*/  'user_data' => utf8_encode('<div>
                                                                 <span class="contact_name'. ($prospect->leido == '1' ? " unRead" : "") .'" company_name="'. $prospect->company_name .'"  contact_name="'. $prospect->contact_name .'"><a href="'.base_url().'leads/edit/'.$prospect->prospect_id.'">'. $contact_name  .'</a></span>
                                                                 <span class="company_name'. ($prospect->leido == '1' ? " unRead" : "") .'" company_name="'. $prospect->company_name .'"  contact_name="'. $prospect->contact_name .'">'. $prospect->company_name .'</span>
                                                                 <span class="contact_phone">'. $prospect->phone. ($prospect->mobile ? ' / '.$prospect->mobile : '') .'</span>
                                                                 <span class="contact_email"><a herf="">'.$prospect->email.' </a></span>'.$bookmark.'
                                                                 <span class="contact_score">'.$prospect->prospect_score.'</span>'.
                                                            '</div>'),
                    /* dataTable column*/  'option_data' => utf8_encode('<div class="tx_info">
                                                                <span class="prospect_state"><button class="btn btn-sm" style="background-color:'.$dechex.'">'. $prospect->prospect_state .'</button></span>
                                                                <span class="assign_to">'.$this->lang->line('prospects_assigned_to').': <strong>'.$prospect->prospect_user.'</strong></span>
                                                                <span>'.$this->lang->line('prospects_source').': <strong>'.$prospect->source.'</strong></span>
                                                                <span>'.$this->lang->line('prospects_campaign').': <strong>'. ($prospect->campaign ? $prospect->campaign : 0) .' % Off</strong></span>
                                                              </div>'),
                    /* dataTable column*/   'date_data' => utf8_encode('<div >
                                                                <span>'.$this->lang->line('prospects_date_creation').':<strong> '. date("Y/m/d", strtotime($prospect->date_creation)).'</strong>
                                                                </span><span>'.$this->lang->line('prospects_last_update').': <strong>'. date("Y/m/d", strtotime($prospect->last_upadte))  .'</strong></span>
                                                                <span>'.$this->lang->line('prospects_last_follow_up').': <strong>'. date("Y/m/d", strtotime($prospect->last_followup)) .'</strong></span>
                                                                <span>'.$this->lang->line('prospects_enrolled').': <strong>'. $prospect->enrolled .'</strong></span>
                                                           </div>'),
                                            'ID' => $prospect->prospect_id,
                    /* dataTable column*/   'options' => utf8_encode('<div><div class="btn-group">
                                                                  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> <span class="caret"></span></button>
                                                                  <ul class="dropdown-menu dropdown-menu-right">
                                                                    <li class="follow_up" user_id="'. $prospect->prospect_id .'"><a class=""    href="#">'. $this->lang->line('clientes_addSeguimiento') .'</a></li>
                                                                  </ul>
                                                            </div></div>')

                    );
            }
        }
        echo json_encode($data);     /*  Data for prospects list  DataTable    */
        exit;
    }

    public function cliente_delete($id) {
        $data['status'] = $this->magaModel->deleteClientes($id);
        $this->curl->simple_get(base_url() . 'awsrest/bucketDelete/customer-' . $id);
        echo json_encode($data);
    }

    public function updateBookmark() {
        $data['status'] = $this->magaModel->update('presupuestot', array('bookmark' => $this->input->post('bookmark')), array('NumPresupuesto' => $this->input->post('id')));
        echo json_encode($data);
    }

    public function markAsRead_patch($id) {
        $data['status'] = $this->magaModel->update('presupuestot', array('leido' => 0), array('NumPresupuesto' => $id));
        echo json_encode($data);
    }

    public function create_post() {

        $this->load->model('ContactosModel');
        $data['status'] = $this->ContactosModel->insert($this->input->post());
        echo json_encode($data);
    }

    public function clientes_tab_ad($id) {
        $this->load->model('AreasAcademicaModel');
        return $this->AreasAcademicaModel->getClientesTabAd();
    }

    public function Adicionales($id) {
        $this->load->model('AreasAcademicaModel');
        return $this->AreasAcademicaModel->getAdicionales($id);
    }

    public function Adicionales_add_post($id) {
        $this->load->model('AreasAcademicaModel');
        $areaacademica = $this->input->post('areaacademica');
        $fecha = $this->input->post('fecha');
        $comments = $this->input->post('comments');
        $details = $this->AreasAcademicaModel->adicionalesAdd($id, $areaacademica, $comments, $fecha);
        print_r($details);
    }

    public function Adicionales_update_post($id) {
        $areaacademica = $this->input->post('areaacademica');
        $fecha = $this->input->post('fecha');
        $comments = $this->input->post('comments');
        $this->load->model('AreasAcademicaModel');
        $details = $this->AreasAcademicaModel->adicionalesUpdate($id, $areaacademica, $comments, $fecha);
        print_r($details);
    }

    public function index_delete($id) {

        $this->load->model('ContactosModel');
        $data['status'] = $this->ContactosModel->delete($id);
        echo json_encode($data);
    }

    public function filter() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules("column_name", 'ColumnName', "required");
        $this->form_validation->set_rules("operator", 'Operator', "required");
        $this->form_validation->set_rules("value", 'Value', "required");
        $data = array();
        if ($this->form_validation->run() ? FALSE : TRUE) {
            $data['status'] = false;
            $data['error'] = validation_errors();
        } else {
            $value = $this->input->get('value');
            $operator = $this->input->get('operator');
            $column_name = $this->input->get('column_name');
            $data['status'] = True;
            $data['lang'] = $this->lang->language;

            $this->load->model('ContactosModel');
            $data['content'] = $this->ContactosModel->filter($value, $operator, $column_name);
        }
        echo json_encode($data);
    }

    public function group() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules("column_name", 'ColumnName', "required");
        $data = array();
        if ($this->form_validation->run() ? FALSE : TRUE) {
            $data['status'] = false;
            $data['error'] = validation_errors();
        } else {
            $column_name = $this->input->get('column_name');
            $data['status'] = True;
            $data['lang'] = $this->lang->language;

            $this->load->model('ContactosModel');
            $data['content'] = $this->ContactosModel->group_by($column_name);
        }
        echo json_encode($data);
    }

    //alumnos
    public function alumnos() {
        $id = $this->input->post('id');
        $details = $this->magaModel->selectAll('alumnos');
        return $details;
    }

    public function documentos($id) {
        if ($this->input->post()) {
            $this->documentos_post($id);
        }
        $this->load->model('ClientesDocModel');
        return $this->ClientesDocModel->getDocumentos($id);
    }

    public function Seguimiento($id) {
        $userData = $this->session->userdata('userData');
        $usuario = $userData[0]->USUARIO;

        $this->load->model('PresupuestotModel');
        return $this->PresupuestotModel->getSeguimiento($id);
    }

    public function add_follow_up() {
        $result['error_msg'] = null;
        $result['result'] = null;
        if ($this->input->post()) {
            $insert_data = array();
            $details = '';
            $error_msg = '';
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'required');
            if ($this->form_validation->run()) {
                $data = (array)$this->input->post();
                //$data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d', time());
                $insert_data['titulo'] = isset($data['title']) ? $data['title'] : '';
                $insert_data['comentarios'] = isset($data['comment']) ? $data['comment'] : '';
                $insert_data['fecha'] = isset($data['date']) ? $data['date'] : date('Y-m-d', time());
                $insert_data['usuario'] = $this->data['userData'][0]->USUARIO;
                $insert_data['numpresupuesto'] = $data['user_id'];
                $details = $this->magaModel->insert('presupuesto_segui', $insert_data);

            }else {
                $error_msg =  $this->form_validation->error_array();
            }
            $result['error_msg'] = $error_msg;
            $result['result'] = $details;
        }else{

        }
        echo json_encode($result);
        exit;
    }

    public function Seguimiento_edit($id) {
        $details = array();
        if ($this->input->post()) {
            $lang = $this->session->userdata('lang');
            $userData=$this->session->userdata('userData');
            $data = (array) $this->input->post();
            foreach($data as $key=>$list){
                if($key==='fecha'){
                    if($lang == "english"){
                        $data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                    }else{
                        $data[$key]= DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                    }
                }
            }
            $data['usuario'] = $userData[0]->USUARIO;
            $details = $this->magaModel->update('presupuesto_segui',$data,array('id'=>$id));
        }
        print_r($details);
        exit;
    }

    public function seguimiento_delete($id) {
        $detail = $this->magaModel->delete('presupuesto_segui',array('id'=>$id));
        print_r($detail);
    }

    public function historicAccount($id) {
        $this->load->model('ReciboModel');
        return $this->ReciboModel->getHistoricAccount($id);
    }

    public function HistoricFees($id) {
        $this->load->model('MatriculatModel');
        return $this->MatriculatModel->getHistoricFees($id);
    }

    public function Filiales($id) {
        $this->load->model('ClientModel');
        return $this->ClientModel->getFiliales($id);
    }

    public function Filiales_post($id) {
        $linkFrom = $this->input->post('linkFrom');
        $linkTo = $this->input->post('linkTo');
        $details = $this->magaModel->update('clientes', array('ccodcli_matriz' => $linkFrom), array('ccodcli' => $linkTo));
        echo $details;
    }

    public function empleados($id) {
        $details = array();
        if ($this->input->post()) {
            $linkFrom = $this->input->post('linkFrom');
            $details = $this->magaModel->update('alumnos', array('FacturarA' => $id), array('ccodcli' => $linkFrom));
        }
        print_r($details);
        exit;
    }

    public function Filiales_delete($id) {
        $details = $this->magaModel->update('clientes', array('ccodcli_matriz' => ''), array('ccodcli' => $id));
        echo $details;
    }

    public function empleados_delete($id) {
        $details = $this->magaModel->update('alumnos', array('FacturarA' => '0'), array('Id' => $id));
        echo $details;
    }

    public function datos_comerciales($id) {
        $details = array();
        if ($this->input->post()) {
            $lang = $this->session->userdata('lang');
            $data = (array) $this->input->post();
            foreach ($data as $key => $list) {
                if ($key === 'Nacimiento') {
                    if ($lang == "english") {
                        $data[$key] = DateTime::createFromFormat('m/d/Y', $list)->format('Y-m-d');
                    } else {
                        $data[$key] = DateTime::createFromFormat('d/m/Y', $list)->format('Y-m-d');
                    }
                }
            }
            $details = $this->magaModel->update('presupuestot', $data, array('NumPresupuesto' => $id));
        }
        print_r($details);
        exit;
    }

	public function datos_fcturation($id){
        $query = '';
        if ($this->input->post()) {
            $query = $this->db->query("UPDATE `presupuestot` SET `medio` = '".$this->input->post('medio')."', `Campaña` = '".$this->input->post('Campaña')."', `Descripcion` = '".$this->input-post('Descripcion')."' WHERE `NumPresupuesto` = '$id'");
        }
        print_r($query);
        exit;
    }

    public function course_add($id){
        $result = array();
        if ($this->input->post()) {

            if(null!=$this->input->post('ids')){
                $ids = $this->input->post('ids');
                $cid = "";
                foreach($ids as $list){
                    $cid .="'$list'".',';
                }
                $cid = rtrim($cid,',');
                $result = $this->db->query("INSERT INTO presupuesto_solicitud (NumPresupuesto, CodigoCurso, Descripcion, Horas, Precio, dto, neto)
			SELECT $id,codigo,curso,horas,precio,0,precio FROM curso WHERE codigo IN ($cid)");
            }
        }
        print_r($result);
        exit;
    }

    public function deletecourse_delete($id){
    	$data = $this->db->query("DELETE FROM presupuesto_solicitud WHERE id='$id'");
        print_r($data);
    }

    public function datos_comerciales_add_post($id) {
        $details = $this->magaModel->insert('clientes', $this->input->post());
        print_r($details);
    }

    public function bulk_operation() {

        if ($this->input->post()) {
            $ids = $this->input->post('ids', true);
            $tasks = $this->input->post('tasks', true);
            $value = $this->input->post('value', true);
            $update_data = array();
            $result = false;
            switch ($tasks) {
                case 'assign_user':
                    if(!empty($ids) && is_array($ids)){

                        foreach($ids as $id){
                            $value = $value == '0' || !$id ? null : $value;
                            $update_data[] = array('NumPresupuesto' => $id, 'id_user' => $value);
                        }
                    }
                break;
                case 'modify_score':
                    if(!empty($ids) && is_array($ids) && ($value >= 0 && $value <= 100)){

                        foreach($ids as $id){
                            $update_data[] = array('NumPresupuesto' => $id, 'score' => $value);
                        }
                    }
                break;
                case 'prioridad':
                    if(!empty($ids) && is_array($ids) ){

                        foreach($ids as $id){
                            $update_data[] = array('NumPresupuesto' => $id, 'prioridad' => $value);
                        }
                    }
                break;
                case 'estado':
                    if(!empty($ids) && is_array($ids) ){

                        foreach($ids as $id){
                            $update_data[] = array('NumPresupuesto' => $id, 'estado' => $value);
                        }
                    }
                break;
                case 'leido':
                    if(!empty($ids) && is_array($ids) ){

                        foreach($ids as $id){
                            $update_data[] = array('NumPresupuesto' => $id, 'leido' => $value);
                        }
                    }
                break;
                case 'delete_prospect':
                    if(!empty($ids) && is_array($ids) ){
                        $this->db->where_in('NumPresupuesto', $ids);

                        if($this->db->delete('presupuestot')){
                            $result = true;
                        };
                    }
                break;
            }

            if(!empty($update_data)) {
                if ($this->db->update_batch('presupuestot', $update_data, 'NumPresupuesto')) {
                    $result = true;
                    foreach($ids as $id) {
                        $result_e[] = $this->syncUpdateEgoi($id);
                    }
                };
            }
            echo json_encode(array('result' => $result));
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    private function syncUpdateEgoi($client_id){
        $this->load->model('ZapEgoiMappingModel');
        $this->load->model('PresupuestotModel');
        $mappedFields = $this->ZapEgoiMappingModel->getMappedFiledsByTable('1');
        $result_egoi = array();
        $this->load->model('SftConfigEgoiModel');
        $result_e_goi = $this->SftConfigEgoiModel->getEgoiData();
        if (!empty($result_e_goi)) {
            $EgoiList = $this->getEgoiList($result_e_goi->apikey);
            $params = array(
                'apikey' => $result_e_goi->apikey,
                'listID' => $EgoiList[0]['listnum'],
                //'subscriber' => $updated_data['email'],
                'validate_phone' => 0,
                'lang' => 'es',
            );
            //vardump($result_egoi);exit;
        }
        if(!empty($mappedFields)){
            $select_str = 'presupuestot.email,';
            foreach($mappedFields as $field){
                $select_str .= $field->table_name.'.'.$field->field_name.',';
            }
            $select_str = trim($select_str,',');
            if(!empty($select_str)) {
                $updated_data = $this->PresupuestotModel->getExtraFields($select_str, array('NumPresupuesto' => $client_id));
                if (!empty($updated_data)) {
                    foreach ($mappedFields as $fields_) {
                        $params['extra_' . $fields_->egoi_list] = $updated_data[$fields_->field_name];
                    }
                }
            }

            if(!empty($params)) {
                $params['subscriber'] = $updated_data['email'];
                //vardump($params);exit;
                $result_egoi = $this->editSubscriber($params);
            }
        }
        return  $result_egoi;
    }

    private function editSubscriber($params){
        // using Soap with SoapClient
        $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
        $result = $client->editSubscriber($params);
        return $result;
    }
    public function detail_medios_link($id) {
        $details = array();
        if ($this->input->post()) {
            $linkFrom = $this->input->post('linkFrom');
            $details = $this->magaModel->update('presupuestot', array('medio' => $id), array('NumPresupuesto' => $linkFrom));

        }
        print_r($details);
        exit;
    }

    public function documentos_post($id) {
        $this->load->model('LstPlantillaModel');
        $details =  $this->LstPlantillaModel->getDocumentos($id);
        $docAsociado = [];
        if (!empty($details)) {
            $docAsociado[] = ['id' => '0', 'name' => 'select'];
            foreach ($details as $row) {
                $DocAsociado[] = ['id' => $row->id, 'name' => $row->DocAsociado];
            }
        }
        echo json_encode($DocAsociado);
        exit;
    }

    public function documentodata($id) {
        $webDocumento = '';
        if ($this->input->post()) {
            $clienteId = $this->input->post('clienteId');
            $this->load->model('LstPlantillaModel');
            $webDocumentoDetail = $this->LstPlantillaModel->getDocumentoData($id);

            /* $lang = $this->session->userdata('lang');
              $ckeyslang = $this->my_language->load('column_key');
              $data['dataKeys'] =$ckeyslang;
              $field = $lang == 'english' ? 'sql_en' : 'sql_es';
              $query = "SELECT ".$field." FROM erp_consultas WHERE ref = 'lst_empresas'";
              $sql = $this->magaModel->selectCustom($query);
              print_r($sql);die; */
            //$data['content']=$this->magaModel->selectCustom($lang == 'english' ? $sql[0]->sql_en : $sql[0]->sql_es);
            $clientres = $this->magaModel->get_details_leads($clienteId);
            $clientarray = json_decode(json_encode($clientres), true);
            $webDocumento = $webDocumentoDetail[0]->webDocumento;
            foreach ($clientarray[0] as $index => $row) {
                $webDocumento = str_replace('[' . $index . ']', $row, $webDocumento);
            }
        }
        echo $webDocumento;
        exit;

    }

    public function plantillas_cat() {
        $this->load->model('LstPlantillasCatModel');
        $details = $this->LstPlantillasCatModel->getPlantillasCat();
        $plantillas_cat = [];
        $plantillas_cat[''] = 'Select';
        if (!empty($details)) {
            foreach ($details as $row) {
                $plantillas_cat[$row->id] = $row->nombre;
            }
        }
        return $plantillas_cat;
    }

    public function rules() {
        $response['success'] = false;
        $response['prospects_data'] = false;
        $response['errors'] = array();
        if ($this->input->is_ajax_request()) {
            $rule = $this->input->post('rule', true);
            if($rule){
                $this->load->model('PresupuestoRuleModel');
                $sql_arr = $this->PresupuestoRuleModel->getCsql();
                foreach($sql_arr as $csql_obj){
                    if(isset($csql_obj->csql) && !empty($csql_obj->csql)){
                        $this->db->query($csql_obj->csql);
                        $response['success'] = $this->lang->line('queries_done');
                    }
                }
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }            
        }

        if($response['success']){
            $this->load->model('PresupuestotModel');
            $response['prospects_data'] = $this->PresupuestotModel->get_prospects_data();
        }
        echo json_encode($response);
        exit;
    }


    public function getIncreasedValue() {
        $leadsCheck = $this->input->post("leadsCheck");
        if ($leadsCheck) {
            if ($leadsCheck == "newAdd") {
                $this->load->model("LeadsModel");
                $leadId = $this->LeadsModel->updateVariable();
                echo trim($leadId);
            }
        }
    }

    public function getLeadIncrementedId() {
        $this->load->model("LeadsModel");
        $leadId = $this->LeadsModel->updateVariable();
        return trim($leadId);
    }



    public function getCopyUsers() {
        $this->load->model("LeadsModel");
        $this->data["users"] = $this->LeadsModel->getCopyUsers();
        $html = $this->load->view("leads/getCopyUsers", $this->data, true);
        echo $html;
        exit;
    }

    public function getCopyUsersArray() {
        $formData = $this->input->post();
        $this->load->model("LeadsModel");
        $users = $this->LeadsModel->getCopyUsers($formData);
        $items = array();
        foreach ($users as $user) {
            array_push($items, $user);
        }
        $result["rows"] = $items;

        echo json_encode($result);
    }

    public function addExistUser($userId = false, $profileId = false) {
        $leadId = $this->getLeadIncrementedId();
//        echo $leadId; exit;
        if ($leadId > 0 && $userId > 0) {
            $this->load->model("LeadsModel");
            $result = $this->LeadsModel->addExistingUser($leadId, $userId, $profileId);
            if ($result > 0) {
                redirect(base_url() . "leads/edit/" . $result);
            } else {
                $this->session->set_flashdata('addMsg', 'There is an error while add user!');
                redirect(base_url() . "leads/add/");
            }
        }
    }

    public function deleteLead($leadId = false, $profileId = false) {
        if ($leadId > 0) {
            $this->load->model("LeadsModel");
            $result = $this->LeadsModel->deleteLead($leadId, $profileId);
            redirect(base_url() . "leads");
        }
    }

    public function send_email_prospects(){
        if($this->input->is_ajax_request()) {
            $this->load->model('ErpEmailModel');
            $this->load->model('ProfesorModel');
            $prospects_info = $this->input->post('prospects_info', true);
            $response['success'] = false;
            $response['errors'] = false;
            $user_id = $this->session->userdata('userData')[0]->Id;
            $emails_limit_daily = $this->_db_details->emails_limit_daily;
            $emails_limit_monthly = $this->_db_details->emails_limit_monthly;
            foreach($prospects_info as $prospect){
                $id = isset($prospect['id']) ? $prospect['id'] : null;
                $email = isset($prospect['email']) ? $prospect['email'] : null;

                $this->load->model('PresupuestotModel');
                $prospectr_data = $this->PresupuestotModel->getProspectById($id);
                if(!empty($prospectr_data) && !filter_var($prospectr_data->email, FILTER_VALIDATE_EMAIL) === false){
                    $count_emails_day = $this->ErpEmailModel->getEmailsCountDay($user_id);

                    if($emails_limit_daily > $count_emails_day->count_daily && $emails_limit_monthly > $count_emails_day->count_monthly ) {

                        $message = ' <p>Hi ' . $prospectr_data->contact_name . ', </p> <br>  <p>Welcome to Akaud!</p> <p>Regards</p><br>  <p>Akaud Team</p>';
                        $company = $this->ProfesorModel->get_company_name();
                        $amazon = $this->config->item('amazon');
                        $email_from = $this->config->item('email');

                        $client = SesClient::factory(array(
                            'version' => 'latest',
                            'region' => $amazon['email_region'],
                            'credentials' => array(
                                'key' => $amazon['AWSAccessKeyId'],
                                'secret' => $amazon['AWSSecretKey'],
                            ),
                        ));

                        $request = array();
                        $request['Source'] = $email_from['from'];
                        $request['Destination']['ToAddresses'] = array($prospectr_data->email);
                        $request['Message']['Subject']['Data'] = "Notification for " . $company[0]->company_name . ' - Remember Password';
                        $request['Message']['Subject']['Charset'] = "UTF-8";
                        $request['Message']['Body']['Html']['Data'] = $message;
                        $request['Message']['Subject']['Charset'] = "UTF-8";

                        $insert_data = array(
                            'from_userid' => $user_id,
                            'id_campaign' => '',
                            'email_recipie' => $prospectr_data->email,
                            'Subject' => "Notification for " . $company[0]->company_name . ' - Remember Password',
                            'Body' => $message,
                            'date' => date("Y-m-d H:i:s"),
                        );

                        try {
                            $result = $client->sendEmail($request);
                            $messageId = $result->get('MessageId');
                            //echo("Email sent! Message ID: $messageId"."\n");
                            if($messageId) {
                                $response['success'][] = sprintf($this->lang->line('campaigns_send_email_success'), $email);
                                $insert_data['sucess'] = '1';
                                $insert_data['error_msg'] = null;
                            }else{
                                $response['errors'][] = sprintf($this->lang->line('campaigns_no_send_test_email'), $email);
                                $insert_data['sucess'] = '0';
                                $insert_data['error_msg'] = sprintf($this->lang->line('campaigns_no_send_test_email'), $email);
                            }

                            $this->ErpEmailModel->insertEmailData($insert_data);
                        } catch (Exception $e) {
                            //echo("The email was not sent. Error message: ");
                            //$response['errors'] = $e->getMessage()."\n";
                            $insert_data['sucess'] = '0';
                            $insert_data['error_msg'] = $e->getMessage();
                            $response['errors'][] = $this->lang->line('campaigns_no_send_test_email') .$email. " ".$e->getMessage();
                            $this->ErpEmailModel->insertEmailData($insert_data);
                        }
                    }else{
                        $response['errors'][] = $email. " ". $this->lang->line('emails_limit_daily_msg');
                    }
                }else{
                    $text =  isset($prospectr_data->contact_name) ? $prospectr_data->contact_name : '';
                    $response['errors'][] = sprintf($this->lang->line('invalid_email'), $text);
                }
            }

            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }

    public function getProspects(){
        $prospects_data = false;
        if ($this->input->is_ajax_request()) {
            $this->load->model('PresupuestotModel');
            $prospects_data = $this->PresupuestotModel->get_prospects_data();
        }
        echo json_encode(array('data'=>$prospects_data));
        exit;
    }

    // Enroll prospects

    public function enroll($id = null){
        $courses = '';
        $count_courses = '';
        $offered_courses_list  = '';
        $this->load->model('PresupuestolModel');
        $this->data['offered_courses'] = $this->PresupuestolModel->getCourses($id);
        if(!$id || empty($this->data['offered_courses'])){
            redirect('prospects');
        }
        $count_courses = count($this->data['offered_courses']);
        $courses .= "(";
        foreach ($this->data['offered_courses'] as $offered_course) {
            if ($offered_course == end($this->data['offered_courses'])) {
                $courses .= "'" . $offered_course->ref . "')";
                $offered_courses_list .= $offered_course->description;
            } else {
                $courses .= "'" . $offered_course->ref . "',";
                $offered_courses_list .= $offered_course->description. ", ";
            }
        }

        $this->load->model('PresupuestotModel');
        $this->load->model('GruposlModel');
        $this->layouts->add_includes('css', 'assets/global/css/steps.css');
        $this->layouts->add_includes('js', 'app/js/prospects/enroll/index.js');
        $prospect_data = $this->PresupuestotModel->getProspectById($id);
        $this->data['prospect_data'] = $prospect_data;
        $this->data['offered_courses_list'] = $offered_courses_list;
        $this->data['groups'] = array();
        $groups = $this->GruposlModel->getGroupsForEnroll($courses);
        if(!empty($groups)){
            foreach($groups as $group){
                if($group->count_rows == $count_courses){
                    $this->data['groups'][] = $group;
                }
            }
        }
        $this->data['prospect_id'] = $id;
        $this->layouts->view("prospects/enroll/indexView", $this->data);
     
    }

    public function checkingOfferedCourse(){
        if($this->input->post()){
            $courses = '';
            $this->load->model('PresupuestolModel');
            $this->load->model('GruposlModel');
            $result = false;
            $error = '';
            $user_id = $this->input->post('user_id', true);
            $offered_courses = $this->PresupuestolModel->getCourses($user_id);
            if(!empty($offered_courses)) {
                $count_courses = count($offered_courses);
                $courses .= "(";
                foreach ($offered_courses as $offered_course) {
                    if ($offered_course == end($offered_courses)) {
                        $courses .= "'" . $offered_course->ref . "')";
                    } else {
                        $courses .= "'" . $offered_course->ref . "',";
                    }
                }
                $groups = $this->GruposlModel->getGroupsForEnroll($courses);
            }
            $courses_groups = array();
            if(!empty($groups)){
                foreach($groups as $group){
                    if($group->count_rows == $count_courses){
                        $courses_groups[] = $group;
                    }
                }
            }
            if(!empty($offered_courses) && count($offered_courses) >= 1 && !empty($courses_groups) ){
                $result = true;
            }else{
                if(empty($offered_courses)){
                    $error =  $this->lang->line('prospects_not_possible_enroll_2');
                }elseif(empty($courses_groups)){
                    $error =  $this->lang->line('prospects_not_possible_enroll_3');
                }
//                elseif(count($offered_courses) > 1){
//                    $error =  $this->lang->line('prospects_not_possible_enroll_1');
//                }
            }
            echo json_encode(array('result' => $result, 'error' => $error));
            exit;
        }
    }

    public function addEnroll(){
        if($this->input->is_ajax_request()){
            $this->load->model('PresupuestotModel');
            $this->load->model('Variables2Model');
            $this->load->model('AlumnoModel');
            $this->load->model('GrupoModel');
            $this->load->model('GruposlModel');
            $this->load->model('MatriculatModel');
            $this->load->model('MatriculalModel');
            $this->load->model('TarifasLModel');
            $this->load->model('ReciboModel');
            $this->load->model('AgendaModel');
            $this->load->model('AgendaModel');
            $this->load->model('CourseModel');
            $this->load->model('AgendaGrupoModel');

            $prospect_id = $this->input->post('prospect_id', true);
            $group_id = $this->input->post('group_id', true);
            $slected_courses = $this->input->post('courses', true);
            $start_date = $this->input->post('start_date', true);
            $end_date = $this->input->post('end_date', true);
            $selected_fees = $this->input->post('selected_fees', true);
            $rate_id = $this->input->post('rate_id', true);
            $categories = $this->GrupoModel->getCategories($group_id);
            $categories = isset($categories[0]) ? $categories[0] : (object)array('category_id' => null, 'category_name' => null, 'start_date' => null, 'end_date' => null);
            $errors = array();
            $result = false;
            $prospect_data = $this->PresupuestotModel->getProspectById($prospect_id);

            if(!empty($prospect_data) && !$prospect_data->enrolled > '0'){
                if($prospect_data->perfil == '1'){
                    if($this->Variables2Model->updateNumStudent()) {
                        $id = $this->Variables2Model->getNumStudent();
                        $post_data['id'] = $id[0]->numalumno;
                        if ($id[0]->numalumno > 0) {
                            $student_id = $id[0]->numalumno;
                            $this->PresupuestotModel->copyProspectToStudent($prospect_id, $student_id);
                        }
                    }
                }
                if($prospect_data->perfil == '2' || isset($student_id)) {
                    if ($this->Variables2Model->updateEnrollId()) { // 1 query
                        $enroll_data = $this->Variables2Model->getEnrollId(); //2 query
                        $enroll_id = $enroll_data->enroll_id;
                        $student_id = (isset($student_id) && $prospect_data->perfil == '1') ? $student_id : $prospect_data->IdAlumno;
                        $student_data = $this->AlumnoModel->get_student_by_id($student_id);
                        $start_date = $this->checkDate($start_date) ? $start_date : $categories->start_date;
                        $end_date = $this->checkDate($end_date) ? $end_date : $categories->end_date;
//                        if(!empty($slected_courses)){
//                            $courses_id=array();
//                            foreach($slected_courses as $slected_course){
//                                $courses_id[] = $slected_course['ref'];
//                            }
//                            $group_data = isset($slected_course['ref']) ? $this->GruposlModel->getGroupsForEnroll($slected_courses, $group_id) : null;
//
//                        }
                        $startEndDate = $this->AgendaGrupoModel->getStartEndDate($group_id);
                        if(!empty($startEndDate)){
                            if($startEndDate->start_date && $startEndDate->start_date <= $start_date && $start_date < $end_date){
                                $start_date = $start_date;
                            }else{
                                $start_date = $startEndDate->start_date;
                            }

                            if($startEndDate->end_date && $startEndDate->end_date >= $end_date && $end_date > $start_date){
                                $end_date = $end_date;
                            }else{
                                $end_date = $startEndDate->end_date;
                            }
                        }
                        $category_id = $categories->category_id;
                        if (!empty($student_data)) {
                            if ($this->MatriculatModel->insertEnroll($enroll_id, $student_id, $category_id, $start_date, $end_date)) { // 3 query
                                //$courses_ids_str = '';
                                foreach ($slected_courses as $slected_course) {
                                    $course_id = isset($slected_course['ref']) ? $slected_course['ref'] : null;
                                    if ($course_id) {
                                        $this->MatriculalModel->insertEnrollCourses($enroll_id, $group_id, $course_id); //4 query
                                        $courses_ids_str = '"' . $course_id . '"';
                                        $this->AgendaModel->insertEnroll($student_id, $group_id, $enroll_id, $courses_ids_str, $start_date, $end_date);
                                    }
                                }
                                // }
                                /*if (!empty($courses_ids_str)) {
                                    $courses_ids_str = trim($courses_ids_str, ',');
                                    $this->AgendaModel->insertEnroll($student_id, $group_id, $enroll_id, $courses_ids_str, $start_date, $end_date);
                                }*/
                                $this->MatriculatModel->insertEvalNotas($group_id, $enroll_id); //5 query
                                $this->MatriculatModel->insertEvalNotasParams($group_id, $enroll_id); // 6 query
                                $course_data = $this->CourseModel->getCoursesByEnroll($enroll_id);
                                $course_data = $course_data[0];
                                if (!empty($selected_fees) && is_array($selected_fees)) {
                                    foreach ($selected_fees as $fee) {
                                        $fee_data = $this->TarifasLModel->getFees($rate_id, $fee);
                                        if (!empty($fee_data) && isset($fee_data[0])) {
                                            $insert_data = (object)array(
                                                'start_date' => $start_date,
                                                'end_date' => $end_date,
                                                'subject' => $fee_data[0]->subject,
                                                'enroll_id' => $enroll_id,
                                                'amount' => $fee_data[0]->amount,
                                                'percentage_fees' => $fee_data[0]->fees,
                                                'total_fees' => $fee_data[0]->total_fees,
                                                'total_amount' => $fee_data[0]->total_amount,
                                                'group_id' => $group_id,
                                                'student_id' => $student_id,
                                                'payment_date'=>$fee_data[0]->payment_date
                                            );
                                            $this->ReciboModel->insertFees($insert_data); // 7 query
                                        }
                                    }
                                }
                                $this->PresupuestotModel->enrollProspect($enroll_id, $prospect_id);

                                $replace_data = array(
                                    'FIRSTNAME' => $student_data->student_first_name,
                                    'SURNAME' => $student_data->student_last_name,
                                    'FULLNAME' => $student_data->student_name,
                                    'PHONE1' => $student_data->student_phone,
                                    'MOBILE' => $student_data->student_mobile,
                                    'EMAIL1' => $student_data->student_email,
                                    'COURSE_NAME' => $course_data->course_name,
                                    'START_DATE' => date('"F j, Y', strtotime($start_date)),
                                    'END_DATE' => date('"F j, Y', strtotime($end_date)),
                                );

                                $this->load->model('ErpEmailsAutomatedModel');
                                $template = $this->ErpEmailsAutomatedModel->getByTemplateId('1', array('notify_student' => 1));
//                                if (!empty($template) && !empty($student_data->student_email)) {
//                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
//                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
//                                    $this->send_automated_email($student_data->student_email, $email_subject, $email_body, $template->from_email);
//                                }
                                if(!empty($template) && (!empty($student_data->student_email) ||  !empty($student_data->tut1_email1) || !empty($student_data->tut2_email2))){
                                    $email_subject = replaceTemplateBody($template->Subject, $replace_data);
                                    $email_body = replaceTemplateBody($template->Body, $replace_data);
                                    if (!empty($template) && !empty($student_data->student_email)) {
                                        $this->send_automated_email($student_data->student_email, $email_subject, $email_body, $template->from_email);
                                    }
                                    if (!empty($template) && !empty($student_data->tut1_email1)) {
                                        $this->send_automated_email($student_data->tut1_email1, $email_subject, $email_body, $template->from_email);
                                    }
                                    if (!empty($template) && !empty($student_data->tut2_email1)) {
                                        $this->send_automated_email($student_data->tut2_email1, $email_subject, $email_body, $template->from_email);
                                    }
                                }
                                $result = true;

                            } else {
                                $errors[] = $prospect_data->contact_name . '  does not enrolled';
                            }

                        }
                    }
                }

            }
            echo json_encode(array('result' => $result, 'errors' => $errors));
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }
    public function checkEmail()
    {
        $result = array();
        $error_msg = '';
        if ($this->input->is_ajax_request()) {
            $this->config->set_item('language', $this->data['lang']);
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|is_unique[presupuestot.email]|is_unique[alumnos.email]|is_unique[contactos.email]');
            if (!$this->form_validation->run()) {
                $error_msg =  $this->form_validation->error_array();
            }
            $result['error_msg'] = $error_msg;
          echo json_encode($result);
        }
    }

    private function checkDate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
        {
            return true;
        }else{
            return false;
        }
    }
    public function getStartEndDate(){
        $result = array();
        $this->load->model('AgendaGrupoModel');
        if ($this->input->is_ajax_request()) {
            $group_id = $this->input->post('group_id', true);
            if($group_id) {
                $result = $this->AgendaGrupoModel->getStartEndDate($group_id);
            }
            echo json_encode($result);
        } else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }

    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
/**
 * @author  Miasnik Davtyan
 *
 * @property layouts $layouts
 * @property session $session
 * @property magaModel $magaModel
 * @property ContactosModel $ContactosModel
 * @property ClientModel $ClientModel
 * @property AlumnoModel $AlumnoModel
 * @property ErpConsultaModel $ErpConsultaModel
 * @property AreasAcademicaModel $AreasAcademicaModel
 * @property ClientesDocModel $ClientesDocModel
 * @property ClientesSeguiModel $ClientesSeguiModel
 * @property ReciboModel $ReciboModel
 * @property MatriculatModel $MatriculatModel
 * @property LstPlantillaModel $LstPlantillaModel
 * @property LstPlantillasCatModel $LstPlantillasCatModel
 * @property ApiPortalesModel $ApiPortalesModel
 * @property LeadsModel $LeadsModel
 * @property TemplateModel $TemplateModel
 * @property UserMessageModel $UserMessageModel
 * @property DocumentTemplateModel $DocumentTemplateModel
 * @property UsuarioModel $UsuarioModel
 * @property PresupuestotModel $PresupuestotModel
 * @property CompanyModel $CompanyModel
 * @property PresupuestoRuleModel $PresupuestoRuleModel
 * @property LstInformesSecModel $LstInformesSecModel
 * @property LstInformeModel $LstInformeModel
 * @property UserAdminModel $UserAdminModel
 * @property DocumentModel $DocumentModel
 * @property LstConsultaModel $LstConsultaModel
 * @property EventModel $EventModel
 * @property InboxModel $InboxModel
 * @property TaskModel $TaskModel
 * @property MatriculalModel $MatriculalModel
 * @property GruposlModel $GruposlModel
 * @property AgendaModel $AgendaModel
 * @property AgendaGrupoModel $AgendaGrupoModel
 * @property Variables2Model $Variables2Model
 * @property ProfesorModel $ProfesorModel
 * @property InformationSchemaTablesModel $InformationSchemaTablesModel
 * @property AgendaTabAdModel $AgendaTabAdModel
 * @property ErpEventoModel $ErpEventoModel
 * @property MensajeModel $MensajeModel
 * @property UserSessionModel $UserSessionModel
 * @property ErpEmailsTemplatesFolderModel $ErpEmailsTemplatesFolderModel
 * @property ErpEmailsTemplateModel $ErpEmailsTemplateModel
 * @property ResourceModel $ResourceModel
 * @property ErpEmailsCampaignModel $ErpEmailsCampaignModel
 * @property ErpEmailsCampaignFolderModel $ErpEmailsCampaignFolderModel
 * @property ErpEmailsSegmentModel $ErpEmailsSegmentModel
 * @property ErpEmailModel $ErpEmailModel
 * @property ErpEmailsCampaignRecipieModel $ErpEmailsCampaignRecipieModel
 * @property ClientesPortalesModel $ClientesPortalesModel
 * @property ContactosTabAdModel $ContactosTabAdModel
 * @property PresupuestosTabAdModel $PresupuestosTabAdModel
 * @property CursoModel $CursoModel
 * @property MedioModel $MedioModel
 * @property FestividadeModel $FestividadeModel
 * @property ClientesPlansRelationModel $ClientesPlansRelationModel
 * @property ClientesPlansNameModel $ClientesPlansNameModel
 * @property ClientesPlansOptionModel $ClientesPlansOptionModel
 * @property GrupoModel $GrupoModel
 * @property ResourceTemplateModel $ResourceTemplateModel
 * @property ScResourceTemplateModel $ScResourceTemplateModel
 * @property ResourceGroupModel $ResourceGroupModel
 * @property CourseModel $CourseModel
 * @property ScResourceGroupItemsModel $ScResourceGroupItemsModel
 * @property ScResourceGroupPlanningModel $ScResourceGroupPlanningModel
 * @property ScResourcePostGroupModel $ScResourcePostGroupModel
 * @property CursosModel $CursosModel
 * @property GruposTabAdModel $GruposTabAdModel
 * @property CursoTabAdModel $CursoTabAdModel
 * @property CursoDocModel $CursoDocModel
 * @property CursoArticulosModel $CursoArticulosModel
 * @property ArticulosModel $ArticulosModel
 * @property CursoRecursosModel $CursoRecursosModel
 * @property MaterialApoyoModel $MaterialApoyoModel
 * @property LstInformesGruposModel $LstInformesGruposModel
 * @property LstInformesCursoModel $LstInformesCursoModel
 * @property AulasModel $AulasModel
 * @property PresupuestoSolicitudModel $PresupuestoSolicitudModel
 * @property PresupuestoDocModel $PresupuestoDocModel
 * @property ErpEmailsAutomatedModel $ErpEmailsAutomatedModel
 * @property ScResourcePostIndividualModel $ScResourcePostIndividualModel
 * @property ErpMappingOptionModel $ErpMappingOptionModel
 * @property ErpMappingAliasModel $ErpMappingAliasModel
 * @property ClientesTabAdModel $ClientesTabAdModel
 * @property AlumnoTabAdModel $AlumnoTabAdModel
 * @property ProfesoresTabAdModel $ProfesoresTabAdModel
 * @property AvisosNotaModel $AvisosNotaModel
 * @property RecibosHistoricoModel $RecibosHistoricoModel
 * @property ErpFileSizesModel $ErpFileSizesModel
 * @property ClientesAkaudModel $ClientesAkaudModel
 * @property FacturaModel $FacturaModel
 * @property FacturalModel $FacturalModel
 * @property ImpuestoModel $ImpuestoModel
 * @property MiempresaModel $MiempresaModel
 * @property PresupuestolModel $PresupuestolModel
 * @property InvoiceModel $InvoiceModel
 * @property SftConfigEgoiModel $SftConfigEgoiModel
 * @property ZapEgoiAliasesModel $ZapEgoiAliasesModel
 * @property ZapEgoiMappingModel $ZapEgoiMappingModel
 * @property ErpTagsModel $ErpTagsModel
 * @property CajasModel $CajasModel
 */
class MY_Controller extends CI_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $layout = 'default';

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;



    /**
     * Constructor function
     */
    public function __construct()
    {
        parent::__construct();

        $this->data['logged_as'] = $this->session->userdata('logged_as');
        if(!empty($this->data['logged_as'])){ //redirect situations
            switch ($this->data['logged_as']){
                case 'admin':
                    redirect('cpanel', 'refresh');
                    break;
                case 'campus':
                    redirect('campus', 'refresh');
                    break;
            }
        }
        $this->data['_base_url'] = base_url();
        $this->data['menu_json_name'] = 'menu';
        $this->data['_plan_option_allow'] = false;

        $this->data['controller_name'] = $this->router->fetch_class();
        $this->data['action_name'] = $this->router->fetch_method();

        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-toastr/toastr.min.css');
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-toastr/toastr.min.js');

        if($this->data['controller_name'] != 'auth' && $this->data['controller_name'] != 'cpanel'){
            $this->layouts->add_includes('js', 'app/js/main.js');
        }
//        $this->layouts->add_includes('js', 'assets/global/scripts/app.min.js');
        $this->layouts->add_includes('js', 'assets/pages/scripts/ui-toastr.min.js');
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $this->data['lang'] = $this->session->userdata('lang');
        if(empty($this->data['lang'])){
            $this->session->set_userdata('lang', 'spanish');
            $this->data['lang'] = 'spanish';
        }
        $this->data['datepicker_format'] = "Y-m-d";
        $this->data['lang_class'] = 'lang_en';
        $this->lang->load('footer', $this->data['lang']);
        if($this->data['lang'] == "spanish"){
            $this->data['datepicker_format'] = "d-m-Y";
            $this->data['lang_class'] = 'lang_sp';
        }

        $this->data['userData'] = $this->session->userdata('userData');
        $this->data['color'] = $this->session->userdata('color') == '' ? 'dark_blue' : $this->session->userdata('color');
        $this->data['layoutFormat'] = $this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['remaining_days'] = $this->session->userdata('remaining_days');
        $this->data['trial_expire'] = $this->session->userdata('trial_expire');
        $this->data['page'] = $this->data['controller_name'];
        $this->lang->load('site', $this->data['lang']);
        $this->layouts->set_title($this->lang->line('site_title') . $this->layouts->title_separator);

        if($this->session->has_userdata("_cisess")){
            $this->_db_details = (object)$this->session->userdata("_cisess");
        }elseif($this->input->cookie('_cisess', TRUE)){
            $_cisess = $this->input->cookie('_cisess', TRUE);
//            $this->_db_details = json_decode(base64_decode($_cisess));
            $key = base64_decode($_cisess);
            $this->load->model('ClientesAkaudModel');
            $res = $this->ClientesAkaudModel->getByKey($key);
            $db_details = isset($res[0]) ? (array)$res[0] : null;
            $this->session->set_userdata('_cisess', $db_details);
            $this->_db_details = !empty($db_details) ? (object)$db_details : null;
        }


        $offline = $this->input->get('offline', true);
        if(!empty($this->_db_details) && (empty($offline) || $offline != "no")){
            $db_new_config = array(
                'dsn'	=> '',
                'hostname' => $this->_db_details->DBHost_IPserver,
                'username' => $this->_db_details->DBHost_user,
                'password' => $this->_db_details->DBHost_pwd,
                'database' => $this->_db_details->DBHost_db,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
            $this->db = $this->load->database($db_new_config, true);
        }


        $plan_options = $this->session->userdata('_plan_options');
        if(!empty($plan_options)){
            foreach($plan_options as $plan_option){
                $option_value = str_replace("/", "", $plan_option->option_value);
                if (strtolower(trim($option_value)) == strtolower($this->data['controller_name'])){
                    $this->data['_plan_option_allow'] = true;
                    break;
                }
            }
        }
        if(!$this->input->is_ajax_request()
            && $this->data['controller_name'] != 'auth'
            && $this->data['controller_name'] != 'user'
            && $this->data['action_name'] != 'account'){
            if (!$this->data['_plan_option_allow'] && !$this->is_super_admin()) {
                $this->session->set_userdata('plan_option_errors', array("<p>".current_url()."</p>".$this->lang->line('plan_option_suggest')));
                redirect('/subscription-plans');
            }
        }

        //for checking twice login
        if(ENVIRONMENT == "production"){
            if($this->data['controller_name'] == 'auth' && $this->data['action_name'] == 'logout'){
                $this->load->model('UserSessionModel');
                if(isset($this->data['userData'])
                    && is_array($this->data['userData'])
                    && isset($this->data['userData'][0])
                    && isset($this->data['userData'][0]->Id)) {
                    $user_id = $this->data['userData'][0]->Id;
                    $this->UserSessionModel->userLastActivity($user_id, 0, true);
                }
            }
        }
        $this->data['variables2'] = null;

        if(!$this->input->is_ajax_request()){

            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }

            if(isset($db_new_config)){
                $this->data['notificationCount'] = $this->_notificationCount();
                $this->data['undoneTasksCount'] = $this->_undoneTasksCount();
                setcookie('notificationCount',$this->_notificationCount());
                setcookie('undoneTasksCount', $this->_undoneTasksCount());
//            $this->data['messageslist'] = $this->_messageslist();
                $this->data['profileFoto'] = $this->_profileFoto();
//        $this->data['profileFoto'] = $this->_alertMessage();
                $this->data['checkUserStatus'] = $this->_checkUserStatus();
                if(!$this->data['checkUserStatus']){
                    redirect('lockedProfile', 'refresh');
                }
            }else{
                $this->data['notificationCount'] = 0;
                $this->data['undoneTasksCount'] = 0;
//                $this->data['messageslist'] = null;
                $this->data['profileFoto'] = null;
                $this->data['checkUserStatus'] = null;
            }
        }

    }

    private function _notificationCount(){
        $message_count = array();
        if(is_array($this->data['userData']) && isset($this->data['userData'][0]->Id)){
            $this->load->model('MensajeModel');
            $message_count = $this->MensajeModel->getNewMessages($this->data['userData'][0]->Id, '0');
        }
        return isset($message_count->num) ? $message_count->num : 0;
    }

    private function _undoneTasksCount(){
        if(is_array($this->data['userData']) && isset($this->data['userData'][0]->Id)){
            $USUARIO = $this->data['userData'][0]->Id;
            $this->load->model('AvisosNotaModel');
            $undoneTasksCount = $this->AvisosNotaModel->getUndoneTasksCount($USUARIO);
        }        
        return (isset($undoneTasksCount[0]) && isset($undoneTasksCount[0]->num)) ? $undoneTasksCount[0]->num : 0;
    }
    private function _messageslist(){
        $user_id = (is_array($this->data['userData']) && isset($this->data['userData'][0]->Id)) ? $this->data['userData'][0]->Id : null;
        $this->load->model('MensajeModel');
        return $this->MensajeModel->getUserMessagesList($user_id);
    }

    private function _profileFoto() {
        $data['USUARIO'] = null;
        $data['imageUrl'] = null;
        if(is_array($this->data['userData']) && isset($this->data['userData'][0]->USUARIO)){
            $data['USUARIO'] = $this->data['userData'][0]->USUARIO;
            $data['user_name'] = $this->data['userData'][0]->Nombre;
            $this->load->model('UsuarioModel');
            $details = $this->UsuarioModel->getProfileFoto($data['USUARIO'], $this->_db_details->DBHost_db);
            if(isset($details[0]->foto) && !empty($details[0]->foto)){
                $data['imageUrl'] = 'data:image/jpeg;base64,'.base64_encode($details[0]->foto);
            }elseif(isset($details[0]->photo_link)){
                $data['imageUrl'] = $details[0]->photo_link;
            }
        }
        return $data;
    }

    /*protected function _check_db($protocol,$host,$user,$password,$database,$port = NULL)
    {
        // prep the DSN string
        $dsn = "{$protocol}://{$user}:{$password}@{$host}/{$database}";
        if($port !== NULL)
        {
            $dsn .="?port={$port}";
        }

        // Load the database and dbutil
        $this->load->database($dsn);
        $this->load->dbutil();

        // check the connection details
        $check = $this->dbutil->database_exists($database);

        // close the database
        $this->db->close();

        // return our status
        return $check;
    }*/

//    public function _alertMessage() {
//
//        $data['alertMessage'] = array();
//        $_cisess = $this->session->userdata('_cisess');
//        if(!$_cisess){
//            $_cisess_hash = $this->input->cookie('_cisess', TRUE);
//            if($_cisess_hash){
//                $_cisess = (array)json_decode(base64_decode($_cisess_hash));
//            }
//        }
//
//        if(isset($_cisess['idcliente'])){
//            $id_cliente = $_cisess['idcliente'];
//            $data['alertMessage'] = $this->ClientesAvisosModel->getAlertMessage($id_cliente);
//        }
//        echo json_encode($data);
//        exit;
//
//    }

    private function _checkUserStatus(){
            $result = true;
            $user_details = (is_array($this->data['userData']) && isset($this->data['userData'][0])) ? (object)$this->data['userData'][0] : null;
            if (!empty($user_details)) {
                $this->load->model('UsuarioModel');
                $user_data = $this->UsuarioModel->get_users(array('Id' => $user_details->Id));
                if (!empty($user_data) && isset($user_data[0]->status)) {
                    $status = $user_data[0]->status;
                    if ($status != '1') {
                        $this->session->unset_userdata('loggedIn');
                        $this->session->unset_userdata('userData');
                        $this->session->unset_userdata('lang');
                        $this->session->unset_userdata('color');
                        $this->session->unset_userdata('layoutFormat');
                        $this->session->unset_userdata('postWriter');
                        $this->session->unset_userdata('userLockedData');
                        $this->session->set_userdata('userLockedData', $user_data[0]);
                        $result = false;
                    }
                }
            }
            return $result;

    }

    protected function is_super_admin(){
        $superadmin_data = $this->config->item('superadmin');
       if($this->session->userdata('super_admin_secretKey') == $superadmin_data->secretKey){
            return true;
       }else{
           return false;
       }
    }

    protected function is_owner(){
        $userData = $this->session->userdata('userData');
        if(isset($userData[0]->owner) && $userData[0]->owner == '1'){
            return true;
        }else{
            return false;
        }
    }

}

/**
 * @author  Miasnik Davtyan
 *
 * @property layouts $layouts
 * @property session $session
 * @property magaModel $magaModel
 * @property ContactosModel $ContactosModel
 * @property ClientModel $ClientModel
 * @property AlumnoModel $AlumnoModel
 * @property ErpConsultaModel $ErpConsultaModel
 * @property AreasAcademicaModel $AreasAcademicaModel
 * @property ClientesDocModel $ClientesDocModel
 * @property ClientesSeguiModel $ClientesSeguiModel
 * @property ReciboModel $ReciboModel
 * @property MatriculatModel $MatriculatModel
 * @property LstPlantillaModel $LstPlantillaModel
 * @property LstPlantillasCatModel $LstPlantillasCatModel
 * @property ApiPortalesModel $ApiPortalesModel
 * @property LeadsModel $LeadsModel
 * @property TemplateModel $TemplateModel
 * @property UserMessageModel $UserMessageModel
 * @property DocumentTemplateModel $DocumentTemplateModel
 * @property UsuarioModel $UsuarioModel
 * @property PresupuestotModel $PresupuestotModel
 * @property CompanyModel $CompanyModel
 * @property PresupuestoRuleModel $PresupuestoRuleModel
 * @property LstInformesSecModel $LstInformesSecModel
 * @property LstInformeModel $LstInformeModel
 * @property UserAdminModel $UserAdminModel
 * @property DocumentModel $DocumentModel
 * @property LstConsultaModel $LstConsultaModel
 * @property EventModel $EventModel
 * @property InboxModel $InboxModel
 * @property TaskModel $TaskModel
 * @property MatriculalModel $MatriculalModel
 * @property GruposlModel $GruposlModel
 * @property AgendaModel $AgendaModel
 * @property AgendaGrupoModel $AgendaGrupoModel
 * @property Variables2Model $Variables2Model
 * @property ProfesorModel $ProfesorModel
 * @property InformationSchemaTablesModel $InformationSchemaTablesModel
 * @property AgendaTabAdModel $AgendaTabAdModel
 * @property ErpEventoModel $ErpEventoModel
 * @property MensajeModel $MensajeModel
 * @property UserSessionModel $UserSessionModel
 * @property ErpEmailsTemplatesFolderModel $ErpEmailsTemplatesFolderModel
 * @property ErpEmailsTemplateModel $ErpEmailsTemplateModel
 * @property ResourceModel $ResourceModel
 * @property ErpEmailsCampaignModel $ErpEmailsCampaignModel
 * @property ErpEmailsCampaignFolderModel $ErpEmailsCampaignFolderModel
 * @property ErpEmailsSegmentModel $ErpEmailsSegmentModel
 * @property ErpEmailModel $ErpEmailModel
 * @property ErpEmailsCampaignRecipieModel $ErpEmailsCampaignRecipieModel
 * @property ClientesPortalesModel $ClientesPortalesModel
 * @property ContactosTabAdModel $ContactosTabAdModel
 * @property PresupuestosTabAdModel $PresupuestosTabAdModel
 * @property CursoModel $CursoModel
 * @property MedioModel $MedioModel
 * @property FestividadeModel $FestividadeModel
 * @property ClientesPlansRelationModel $ClientesPlansRelationModel
 * @property ClientesPlansNameModel $ClientesPlansNameModel
 * @property ClientesPlansOptionModel $ClientesPlansOptionModel
 * @property GrupoModel $GrupoModel
 * @property ResourceTemplateModel $ResourceTemplateModel
 * @property ScResourceTemplateModel $ScResourceTemplateModel
 * @property ResourceGroupModel $ResourceGroupModel
 * @property CourseModel $CourseModel
 * @property ScResourceGroupItemsModel $ScResourceGroupItemsModel
 * @property ScResourceGroupPlanningModel $ScResourceGroupPlanningModel
 * @property ScResourcePostGroupModel $ScResourcePostGroupModel
 * @property CursosModel $CursosModel
 * @property GruposTabAdModel $GruposTabAdModel
 * @property CursoTabAdModel $CursoTabAdModel
 * @property CursoDocModel $CursoDocModel
 * @property CursoArticulosModel $CursoArticulosModel
 * @property ArticulosModel $ArticulosModel
 * @property CursoRecursosModel $CursoRecursosModel
 * @property MaterialApoyoModel $MaterialApoyoModel
 * @property LstInformesGruposModel $LstInformesGruposModel
 * @property LstInformesCursoModel $LstInformesCursoModel
 * @property AulasModel $AulasModel
 * @property PresupuestoSolicitudModel $PresupuestoSolicitudModel
 * @property PresupuestoDocModel $PresupuestoDocModel
 * @property ErpEmailsAutomatedModel $ErpEmailsAutomatedModel
 * @property ScResourcePostIndividualModel $ScResourcePostIndividualModel
 * @property ErpMappingOptionModel $ErpMappingOptionModel
 * @property ErpMappingAliasModel $ErpMappingAliasModel
 * @property ClientesTabAdModel $ClientesTabAdModel
 * @property AlumnoTabAdModel $AlumnoTabAdModel
 * @property ProfesoresTabAdModel $ProfesoresTabAdModel
 * @property AvisosNotaModel $AvisosNotaModel
 * @property RecibosHistoricoModel $RecibosHistoricoModel
 * @property ErpFileSizesModel $ErpFileSizesModel
 * @property EvalNotasModel $EvalNotasModel
 * @property EvalNotasParamsModel $EvalNotasParamsModel
 * @property FacturaModel $FacturaModel
 */
class MY_Campus_Controller extends CI_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $layout = 'campus';

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;



    /**
     * Constructor function
     */
    public function __construct()
    {
        parent::__construct();

        $this->data['logged_as'] = $this->session->userdata('logged_as');
        if(!empty($this->data['logged_as'])){ //redirect situations
            switch ($this->data['logged_as']){
                case 'lms':
                    redirect('/', 'refresh');
                    break;
                case 'admin':
                    redirect('cpanel', 'refresh');
                    break;
            }
        }
        $this->data['_base_url'] = base_url();
        $this->data['menu_json_name'] = 'menu';
        $this->data['_plan_option_allow'] = false;

        $this->data['controller_name'] = $this->router->fetch_class();
        $this->data['action_name'] = $this->router->fetch_method();

        if($this->data['controller_name'] != 'auth'){
            $this->layouts->add_includes('js', 'app/js/campus/main.js');
        }
        $this->data['campus_user_role'] = $this->session->userdata('user_role');
        $this->data['campus_user'] = (array)$this->session->userdata('campus_user');

        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-toastr/toastr.min.css');
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-toastr/toastr.min.js');
//        $this->layouts->add_includes('js', 'assets/global/scripts/app.min.js');
        $this->layouts->add_includes('js', 'assets/pages/scripts/ui-toastr.min.js');
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $this->data['lang'] = $this->session->userdata('lang');
        if(empty($this->data['lang'])){
            $this->session->set_userdata('lang', 'spanish');
            $this->data['lang'] = 'spanish';
        }
        $this->data['datepicker_format'] = "Y-m-d";
        $this->data['lang_class'] = 'lang_en';
        $this->lang->load('footer', $this->data['lang']);
        if($this->data['lang'] == "spanish"){
            $this->data['datepicker_format'] = "d-m-Y";
            $this->data['lang_class'] = 'lang_sp';
        }

        $this->data['userData'] = $this->session->userdata('userData');
        $this->data['color'] = $this->session->userdata('color') == '' ? 'dark_blue' : $this->session->userdata('color');
        $this->data['layoutFormat'] = $this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['page'] = $this->router->fetch_class();
        $this->lang->load('site', $this->data['lang']);
        $this->layouts->set_title($this->lang->line('site_title') . $this->layouts->title_separator);

        if($this->session->has_userdata("_cisess")){
            $this->_db_details = (object)$this->session->userdata("_cisess");
        }elseif($this->input->cookie('_cisess', TRUE)){
            $_cisess = $this->input->cookie('_cisess', TRUE);
//            $this->_db_details = json_decode(base64_decode($_cisess));
            $key = base64_decode($_cisess);
            $this->load->model('ClientesAkaudModel');
            $res = $this->ClientesAkaudModel->getByKey($key);
            $db_details = isset($res[0]) ? (array)$res[0] : null;
            $this->session->set_userdata('_cisess', $db_details);
            $this->_db_details = !empty($db_details) ? (object)$db_details : null;
        }


        $offline = $this->input->get('offline', true);
        if(!empty($this->_db_details) && (empty($offline) || $offline != "no")){
            $db_new_config = array(
                'dsn'	=> '',
                'hostname' => $this->_db_details->DBHost_IPserver,
                'username' => $this->_db_details->DBHost_user,
                'password' => $this->_db_details->DBHost_pwd,
                'database' => $this->_db_details->DBHost_db,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
            $this->db = $this->load->database($db_new_config, true);

        }

//        //for checking twice login
//        if(ENVIRONMENT == "production"){
//            if($this->data['controller_name'] == 'auth' && $this->data['action_name'] == 'logout'){
//                $this->load->model('UserSessionModel');
//                if(isset($this->data['userData'][0]) && isset($this->data['userData'][0]->Id)) {
//                    $user_id = $this->data['userData'][0]->Id;
//                    $this->UserSessionModel->userLastActivity($user_id, 0, true);
//                }
//            }
//        }
        $this->data['variables2'] = null;
        if(!$this->input->is_ajax_request()){
            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }

            if(isset($db_new_config)){
                $this->data['campus_header_data'] = $this->_campusProfileFoto();
            }else{
                $campus_header_data['message_count'] = 0;
                $campus_header_data['userId'] = $this->session->userdata('userId');
                $campus_header_data['username'] = $this->session->userdata('username');
                $campus_header_data['imageUrl'] = '';
                $this->data['campus_header_data'] = $campus_header_data;
            }
            if(isset($this->data['campus_header_data']['message_count'])) {
                setcookie('notificationCount', $this->data['campus_header_data']['message_count']);
            }
        }

    }

    private function _campusProfileFoto() {
        $this->load->model('MensajeModel');
        $campus_user = $this->session->userdata('campus_user');
        $userId = $this->session->userdata('userId');
        $username = $this->session->userdata('username');
        $user_role = $this->session->userdata('user_role');
        if($userId){
            $message_count = $this->MensajeModel->getNewMessages($userId, $user_role);
        }
        $data['message_count'] = isset($message_count->num) ? $message_count->num : 0;
        $data['userId'] = $userId;
        $data['username'] = $username;
        if($user_role == '1') {
            $this->load->model('ProfesorModel');
            $photo_url = $this->ProfesorModel->getTeacherPhotoLink($userId);
        }elseif($user_role == '2'){
            $this->load->model('AlumnoModel');
            $photo_url = $this->AlumnoModel->getStudentPhotoLink($userId);
        }else{
            $photo_url = null;
        }

        $data['imageUrl'] = isset($photo_url->photo_link) && !empty($photo_url->photo_link) ? $photo_url->photo_link : (!empty($campus_user->foto) ? 'data:image/jpeg;base64,'.base64_encode($campus_user->foto) : null);
        if(empty($data['imageUrl'])){
            $data['imageUrl'] = base_url().'assets/img/dummy-image.jpg';
        }
        return $data;
    }

//    protected function _check_db($protocol,$host,$user,$password,$database,$port = NULL)
//    {
//        // prep the DSN string
//        $dsn = "{$protocol}://{$user}:{$password}@{$host}/{$database}";
//        if($port !== NULL)
//        {
//            $dsn .="?port={$port}";
//        }
//
//        // Load the database and dbutil
//        $this->load->database($dsn);
//        $this->load->dbutil();
//
//        // check the connection details
//        $check = $this->dbutil->database_exists($database);
//
//        // close the database
//        $this->db->close();
//
//        // return our status
//        return $check;
//    }
}

/**
 * @author  Miasnik Davtyan
 *
 * @property layouts $layouts
 * @property session $session
 * @property WebformModel $WebformModel
 * @property ContactosModel $ContactosModel
 * @property LeadsModel $LeadsModel
 * @property PresupuestotModel $PresupuestotModel
 * @property PresupuestosTabAdModel $PresupuestosTabAdModel
 * @property ContactosTabAdModel $ContactosTabAdModel
 * @property PresupuestoSolicitudModel $PresupuestoSolicitudModel
 * @property WebformErrorlogModel $WebformErrorlogModel
 * @property ClientesPortaleModel $ClientesPortaleModel
 * @property ClientesPlansRelationModel $ClientesPlansRelationModel
 * @property InvoiceModel $InvoiceModel
 * @property ClientesAkaudModel $ClientesAkaudModel
 * @property MiempresaModel $MiempresaModel
 * @property ClientesMainModel $ClientesMainModel
 * @property Variables2Model $Variables2Model
 * @property ErpEmailsAutomatedModel $ErpEmailsAutomatedModel
 * @property AvisosNotaModel $AvisosNotaModel
 */
class Public_Controller extends CI_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $layout = 'default';

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;

    /**
     * Constructor function
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['_base_url'] = base_url();
        $this->data['menu_json_name'] = 'menu';

        $this->data['controller_name'] = $this->router->fetch_class();
        $this->data['action_name'] = $this->router->fetch_method();
        $url_str = $this->uri->uri_string();

        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-toastr/toastr.min.css');
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-toastr/toastr.min.js');
        if (strpos($url_str, 'campus') === false) {
            if($this->data['controller_name'] != 'auth'
                && $this->data['controller_name'] != 'cpanel'
                && $this->data['controller_name'] != 'lockedProfile'
                && $this->data['controller_name'] != 'forgotPassword'){
                $this->layouts->add_includes('js', 'app/js/main.js');
            }
        }else{
            $this->data['campus_user_role'] = $this->session->userdata('user_role');
            $this->layout = 'campus';
        }
//        $this->layouts->add_includes('js', 'assets/global/scripts/app.min.js');
        $this->layouts->add_includes('js', 'assets/pages/scripts/ui-toastr.min.js');
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $this->data['lang'] = $this->session->userdata('lang');



        if(empty($this->data['lang'])){
            $this->session->set_userdata('lang', 'spanish');
            $this->data['lang'] = 'spanish';

        }
        $this->data['lang_class'] = 'lang_en';
        $this->data['datepicker_format'] = "Y-m-d";
        if($this->data['lang'] == "spanish"){
            $this->data['datepicker_format'] = "d-m-Y";
            $this->data['lang_class'] = 'lang_sp';
        }
        $this->data['userData'] = $this->session->userdata('userData');
        if(isset($this->data['userData']) && is_array($this->data['userData'])
            && isset($this->data['userData'][0]->Id)){
            $this->data['undoneTasksCount'] = $this->_undoneTasksCount();
        }else{
            $this->data['undoneTasksCount'] = 0;
        }
        $this->data['color'] = $this->session->userdata('color') == '' ? 'default' : $this->session->userdata('color');
        $this->data['layoutFormat'] = $this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['page'] = $this->router->fetch_class();
        $this->lang->load('site', $this->data['lang']);
        $this->layouts->set_title($this->lang->line('site_title') . $this->layouts->title_separator);

        if($this->session->has_userdata("_cisess")){
            $this->_db_details = (object)$this->session->userdata("_cisess");
        }elseif($this->input->cookie('_cisess', TRUE)){
            $_cisess = $this->input->cookie('_cisess', TRUE);
//            $this->_db_details = json_decode(base64_decode($_cisess));
            $key = base64_decode($_cisess);
            $this->load->model('ClientesAkaudModel');
            $res = $this->ClientesAkaudModel->getByKey($key);
            $db_details = isset($res[0]) ? (array)$res[0] : null;
            $this->session->set_userdata('_cisess', $db_details);
            $this->_db_details = !empty($db_details) ? (object)$db_details : null;
        }


        $offline = $this->input->get('offline', true);
        if(!empty($this->_db_details) && (empty($offline) || $offline != "no")){
            $db_new_config = array(
                'dsn'	=> '',
                'hostname' => $this->_db_details->DBHost_IPserver,
                'username' => $this->_db_details->DBHost_user,
                'password' => $this->_db_details->DBHost_pwd,
                'database' => $this->_db_details->DBHost_db,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );

            //$test_connection = $this->_check_db('mysqli',$this->_db_details->DBHost_IPserver,$this->_db_details->DBHost_user,$this->_db_details->DBHost_pwd,$this->_db_details->DBHost_db,$port = NULL);
            //if($test_connection){
                $this->db = $this->load->database($db_new_config, true);
            //}else{
               // $this->data['db_connnection_error'] = $this->lang->line('db_connnection_error');
            //}

        }
        //for checking twice login
        if(ENVIRONMENT == "production"){
            if($this->data['controller_name'] == 'auth' && $this->data['action_name'] == 'logout'){
                $this->load->model('UserSessionModel');
                if(isset($this->data['userData'])
                    && is_array($this->data['userData'])
                    && isset($this->data['userData'][0])
                    && isset($this->data['userData'][0]->Id)) {
                    $user_id = $this->data['userData'][0]->Id;
                    $this->UserSessionModel->userLastActivity($user_id, 0, true);
                }
            }
        }
        $this->data['variables2'] = null;
        if(!$this->input->is_ajax_request()) {
            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }
        }
    }

    private function _undoneTasksCount(){
        if(is_array($this->data['userData']) && isset($this->data['userData'][0]->Id)){
            $USUARIO = $this->data['userData'][0]->Id;
            $this->load->model('AvisosNotaModel');
            $undoneTasksCount = $this->AvisosNotaModel->getUndoneTasksCount($USUARIO);
        }
        return (isset($undoneTasksCount[0]) && isset($undoneTasksCount[0]->num)) ? $undoneTasksCount[0]->num : 0;
    }

    protected function _check_db($protocol,$host,$user,$password,$database,$port = 3306)
    {


        // prep the DSN string
        $dsn = "{$protocol}://{$user}:{$password}@{$host}/{$database}";
        if($port !== NULL)
        {
            $dsn .="?port={$port}";
        }

        $test = @$this->load->database($dsn, TRUE);
        if($test->conn_id){
            return true;
        }else{
            return false;
        }

    }

}


/**
 * @author  Miasnik Davtyan
 *
 * @property layouts $layouts
 * @property session $session
 * @property ClientModel $ClientModel
 * @property ClientesPlansRelationModel $ClientesPlansRelationModel
 * @property ClientesPlansNameModel $ClientesPlansNameModel
 * @property ClientesPlansOptionModel $ClientesPlansOptionModel
 * @property ClientesAvisosModel $ClientesAvisosModel
 * @property ClientesAkaudModel $ClientesAkaudModel
 * @property ClientesMainModel $ClientesMainModel
 * @property GrupoClientModel $GrupoClientModel
 * @property InvoiceModel $InvoiceModel
 * @property ClientesImpuestoModel $ClientesImpuestoModel
 * @property CouponModel $CouponModel
 * @property UsedCouponsModel $UsedCouponsModel
 * @property ClientesTransfersModel $ClientesTransfersModel
 * @property ClientesAkaudFollowupModel $ClientesAkaudFollowupModel
 * @property ClientesLogModel $ClientesLogModel
 * @property Variables2Model $Variables2Model
 * @property AgilecrmTagsModel $AgilecrmTagsModel
 */
class Admin_Controller extends CI_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $layout = 'default';

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;



    /**
     * Constructor function
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['_base_url'] = base_url();
        $this->data['logged_as'] = $this->session->userdata('logged_as');
        if(!empty($this->data['logged_as'])){ //redirect situations
            switch ($this->data['logged_as']){
                case 'lms':
                    redirect('/', 'refresh');
                    break;
                case 'campus':
                    redirect('campus', 'refresh');
                    break;
            }
        }
        
        $this->data['menu_json_name'] = 'menu';
        $this->data['_plan_option_allow'] = false;

        $this->data['controller_name'] = $this->router->fetch_class();
        $this->data['action_name'] = $this->router->fetch_method();
        $url_str = $this->uri->uri_string();

        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-toastr/toastr.min.css');
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-toastr/toastr.min.js');
//        $this->layouts->add_includes('js', 'assets/global/scripts/app.min.js');
        $this->layouts->add_includes('js', 'assets/pages/scripts/ui-toastr.min.js');
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $this->data['lang'] = $this->session->userdata('lang');
        $this->data['datepicker_format'] = "Y-m-d";
        if($this->data['lang'] == "spanish"){
            $this->data['datepicker_format'] = "d-m-Y";
        }
        $this->data['userData'] = $this->session->userdata('userData');
        $this->data['color'] = $this->session->userdata('color') == '' ? 'default' : $this->session->userdata('color');
        $this->data['layoutFormat'] = $this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['page'] = $this->router->fetch_class();
        $this->lang->load('site', $this->data['lang']);
        $this->layouts->set_title($this->lang->line('site_title') . $this->layouts->title_separator);

        $this->data['variables2'] = null;
        if(!$this->input->is_ajax_request()) {
            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }
        }
    }

}

/**
 * @property magaModel $magaModel
 * @property my_language $my_language
 * @property ContactosModel $ContactosModel
 * @property ErpConsultaModel $ErpConsultaModel
 * @property ClientesAkaudModel $ClientesAkaudModel
 * @property ClientesPlansRelationModel $ClientesPlansRelationModel
 * @property UsuarioModel $UsuarioModel
 * @property Variables2Model $Variables2Model
 * @property PresupuestotModel $PresupuestotModel
 */
class Base_api extends REST_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $layout = 'default';

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;

    public function __construct()
    {
        parent::__construct();
        $this->data['_base_url'] = base_url();
        $this->data['menu_json_name'] = 'menu';
        $this->data['_plan_option_allow'] = false;

        $this->data['controller_name'] = $this->router->fetch_class();
        $this->data['action_name'] = $this->router->fetch_method();
        $this->data['uri'] = $this->uri->uri_string();
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $lang = $this->session->userdata('lang');
        $this->data['lang'] = !empty($lang) ? $lang : 'english' ;
        $this->data['datepicker_format'] = "Y-m-d";
        if($this->data['lang'] == "spanish"){
            $this->data['datepicker_format'] = "d-m-Y";
        }
        $this->data['userData'] = $this->session->userdata('userData');
        $this->data['color'] = $this->session->userdata('color') == '' ? 'default' : $this->session->userdata('color');
        $this->data['layoutFormat'] = $this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['page'] = $this->router->fetch_class();
        
        $this->lang->load('site', $this->data['lang']);
        $this->lang->load('rest_controller', $this->data['lang']);
        $this->lang->load('api', $this->data['lang']);
        
        $this->layouts->set_title($this->lang->line('site_title') . $this->layouts->title_separator);

        $api_key = null;
        $api_result = null;

        $headers = getallheaders();

        foreach ($headers as $name => $value) {
            if($name == 'X-API-KEY'){
                $api_key =  $value;
                break;
            }
        }

        $response['status'] = false;
        if(empty($api_key)){
            // Invalid api_key, set the response and exit.
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_BAD_REQUEST;
            $this->response($response, $http_code);
        }else{
            $this->rest->db->select('*')
                ->from('webservice_keys')
                ->where('key', $api_key);
            $query = $this->rest->db->get();
            $api_result = $query->row();
        }

        if(empty($api_result)){
            // Invalid api_key, set the response and exit.
            $response['message'] = $this->lang->line('db_err_msg');
            $http_code = REST_Controller::HTTP_BAD_REQUEST;
            $this->response($response, $http_code);
        }else{
            if (empty($this->_identity['loggedIn'])) {

                $this->load->model('ClientesAkaudModel');
                $this->load->model('ClientesPlansRelationModel');
                $this->load->model('UsuarioModel');
                $this->load->model('Variables2Model');

                $idcliente = isset($api_result->idcliente) ? $api_result->idcliente : null;
                $res = $this->ClientesAkaudModel->getByIdCliente($idcliente);

                if (isset($res[0])) {
                    if ($res[0]->active == 0) {
                        $response['message'] = $this->lang->line('key_code_inactive');
                        $http_code = REST_Controller::HTTP_UNAUTHORIZED;
                        $this->response($response, $http_code);
                    } else {
                        if ($res[0]->start_date > date('Y-m-d') || $res[0]->end_date < date('Y-m-d')) {                         
                            $response ['message'] = $this->lang->line('key_code_dates_msg');
                            $http_code = REST_Controller::HTTP_UNAUTHORIZED;
                            $this->response($response, $http_code);
                        } else {
                            $db_details = (array)$res[0];
                            $plan_options = $this->session->userdata('_plan_options');

                            if (empty($plan_options)) {
                                if (isset($db_details['plan'])) {
                                    $plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
                                }
                                $this->session->set_userdata('_plan_options', $plan_options);
                            }


//                            $db_details_json_base64_encode = base64_encode(json_encode($db_details));
//                            setcookie('_cisess', $db_details_json_base64_encode, time() + (86400 * 30), "/"); //30 days
                            $key_base64_encode = base64_encode($res[0]->key);
                            setcookie('_cisess', $key_base64_encode,time() + (86400 * 1), "/"); //1 day
                            $this->session->set_userdata('_cisess', $db_details);

                            $user_id = isset($api_result->user_id) ? $api_result->user_id : null;
                            $result = $this->UsuarioModel->getById($user_id);
                           // $start_end_time = $this->Variables2Model->getStartEndtime();

                            //$start_itme = substr($start_end_time->start_time, 0, -2).':'.substr($start_end_time->start_time, -2);
                            //$end_time = substr($start_end_time->end_time, 0, -2).':'.substr($start_end_time->end_time, -2);

                            if ($result) {
                                $this->load->model('UserSessionModel');
//				$user_id = $result[0]->Id;
//				$is_user_online = $this->UserSessionModel->checkOnlineUser($user_id);
//
//				if($is_user_online){
//					$response['twice_login'] = true;
//					$response['message'] = $this->lang->line('login2_logged_yet');
//					$http_code = REST_Controller::HTTP_OK;
//				}else{
                                if ($result[0]->active != '1') {
                                    $locked_data = array(
                                        'id' => $result[0]->Id,
                                        'user_name' => $result[0]->Nombre,
                                        'email' => $result[0]->email,
                                        'photo' => $result[0]->foto,
                                    );
                                    $this->session->set_userdata('userLockedData', $locked_data);
                                    $response['active'] = false;
                                    $http_code = REST_Controller::HTTP_LOCKED;
                                    $this->response($response, $http_code);
                                } else {
                                    $this->session->set_userdata('userData', $result);
                                    if (empty($this->data['lang'])) {
                                        $this->session->set_userdata('lang', $result[0]->lang);
                                    }
                                    $this->session->set_userdata('color', isset($result[0]->themeColor) ? $result[0]->themeColor: null);
                                    $this->session->set_userdata('layoutFormat', $result[0]->layoutFormat);
                                    $this->session->set_userdata('postWriter', $result[0]->post_writer);


                                    //$this->session->set_userdata('start_time', $start_itme);
                                    //$this->session->set_userdata('end_time', $end_time);

                                    $plan_options = null;
                                    if (isset($this->_db_details->plan)) {
                                        $plan_options = $this->ClientesPlansRelationModel->getOptions($this->_db_details->plan);
                                    }
                                    $this->session->set_userdata('_plan_options', $plan_options);
                                    $this->session->set_userdata('loggedIn', true);
//                                    $response['status'] = true;
//                                    $response['message'] = "OK";
//                                    $http_code = REST_Controller::HTTP_OK;
                                }
//				}

                            } else {
                                $response['message'] = $this->lang->line('login2_incorrect_details');
                                $http_code = REST_Controller::HTTP_NOT_FOUND;
                                $this->response($response, $http_code);
                            }
                        }
                    }
                } else {
                    $response['message'] = $this->lang->line('api_auth_invalid_key_code');
                    $http_code = REST_Controller::HTTP_UNAUTHORIZED;
                    $this->response($response, $http_code);
                }
            }
        }


        if($this->session->has_userdata("_cisess")){
            $this->_db_details = (object)$this->session->userdata("_cisess");
        }elseif($this->input->cookie('_cisess', TRUE)){
            $_cisess = $this->input->cookie('_cisess', TRUE);
//            $this->_db_details = json_decode(base64_decode($_cisess));
            $key = base64_decode($_cisess);
            $this->load->model('ClientesAkaudModel');
            $res = $this->ClientesAkaudModel->getByKey($key);
            $db_details = isset($res[0]) ? (array)$res[0] : null;
            $this->session->set_userdata('_cisess', $db_details);
            $this->_db_details = !empty($db_details) ? (object)$db_details : null;
        }


        $offline = $this->input->get('offline', true);
        if(!empty($this->_db_details) && (empty($offline) || $offline != "no")){
            $db_new_config = array(
                'dsn'	=> '',
                'hostname' => $this->_db_details->DBHost_IPserver,
                'username' => $this->_db_details->DBHost_user,
                'password' => $this->_db_details->DBHost_pwd,
                'database' => $this->_db_details->DBHost_db,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
            $this->db = $this->load->database($db_new_config, true);
        }

        $this->data['variables2'] = null;
        if(!$this->input->is_ajax_request()) {
            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }
        }
        $first_segment = $this->uri->segment(1);
        if ($first_segment !== 'campus' && $first_segment !== 'api') {
            $plan_options = $this->session->userdata('_plan_options');
            if(!empty($plan_options)){
                foreach($plan_options as $plan_option){
                    $option_value = str_replace("/", "", $plan_option->option_value);
                    if (strtolower(trim($option_value)) == strtolower($this->data['controller_name'])){
                        $this->data['_plan_option_allow'] = true;
                        break;
                    }
                }
            }
            if(!$this->input->is_ajax_request()
                && $this->data['controller_name'] != 'auth'
                && $this->data['controller_name'] != 'user'
                && $this->data['action_name'] != 'account'){
                if (!$this->data['_plan_option_allow'] && !$this->is_super_admin()) {
                    $this->session->set_userdata('plan_option_errors', array("<p>".current_url()."</p>".$this->lang->line('plan_option_suggest')));
                    redirect('/subscription-plans');
                }
            }
        }

//        if($this->data['controller_name'] == 'auth' && $this->data['action_name'] == 'logout'){
//            $this->load->model('UserSessionModel');
//            if(isset($this->data['userData'][0]) && isset($this->data['userData'][0]->Id)) {
//                $user_id = $this->data['userData'][0]->Id;
//                $this->UserSessionModel->userLastActivity($user_id, 0, true);
//            }
//        }
    
    }
}


/**
 * @author  Miasnik Davtyan
 *
 * @property layouts $layouts
 * @property session $session
 * @property WebformModel $WebformModel
 * @property ContactosModel $ContactosModel
 * @property LeadsModel $LeadsModel
 * @property PresupuestotModel $PresupuestotModel
 * @property PresupuestosTabAdModel $PresupuestosTabAdModel
 * @property ContactosTabAdModel $ContactosTabAdModel
 * @property PresupuestoSolicitudModel $PresupuestoSolicitudModel
 * @property WebformErrorlogModel $WebformErrorlogModel
 * @property ClientesPortaleModel $ClientesPortaleModel
 * @property ClientesPlansRelationModel $ClientesPlansRelationModel
 * @property UsuarioModel $UsuarioModel
 * @property ClientesAkaudModel $ClientesAkaudModel
 * @property Variables2Model $Variables2Model
 * @property UserAdminModel $UserAdminModel
 */
class Base_api_public extends REST_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $layout = 'default';

    /**
     * Information about the variables
     *
     * @var array
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;

    /**
     * Constructor function
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['_base_url'] = base_url();
        $this->data['menu_json_name'] = 'menu';

        $this->data['controller_name'] = $this->router->fetch_class();
        $this->data['action_name'] = $this->router->fetch_method();
        $url_str = $this->uri->uri_string();

        $this->layouts->add_includes('css', 'assets/global/plugins/bootstrap-toastr/toastr.min.css');
        $this->layouts->add_includes('js', 'assets/global/plugins/bootstrap-toastr/toastr.min.js');
        if (strpos($url_str, 'campus') === false) {
            if($this->data['controller_name'] != 'auth' && $this->data['controller_name'] != 'cpanel'){
                $this->layouts->add_includes('js', 'app/js/main.js');
            }
        }else{
            $this->data['campus_user_role'] = $this->session->userdata('user_role');
            $this->layout = 'campus';
        }
//        $this->layouts->add_includes('js', 'assets/global/scripts/app.min.js');
        $this->layouts->add_includes('js', 'assets/pages/scripts/ui-toastr.min.js');
        // Your own constructor code
        $this->_identity['loggedIn'] = $this->session->userdata('loggedIn');
        $this->data['lang'] = $this->session->userdata('lang');
        $this->data['datepicker_format'] = "Y-m-d";
        if($this->data['lang'] == "spanish"){
            $this->data['datepicker_format'] = "d-m-Y";
        }
        $this->data['userData'] = $this->session->userdata('userData');
        $this->data['color'] = $this->session->userdata('color') == '' ? 'default' : $this->session->userdata('color');
        $this->data['layoutFormat'] = $this->session->userdata('layoutFormat') == '' ? 'fluid' :$this->session->userdata('layoutFormat');
        $this->data['layoutClass'] = ($this->data['layoutFormat'] == 'fluid') ? 'container-fluid'  : 'container' ;
        $this->data['postWriter'] = $this->session->userdata("postWriter");
        $this->data['page'] = $this->router->fetch_class();
        $this->lang->load('site', $this->data['lang']);
        $this->lang->load('rest_controller', $this->data['lang']);
        $this->lang->load('api', $this->data['lang']);
        $this->layouts->set_title($this->lang->line('site_title') . $this->layouts->title_separator);

        if($this->session->has_userdata("_cisess")){
            $this->_db_details = (object)$this->session->userdata("_cisess");
        }elseif($this->input->cookie('_cisess', TRUE)){
            $_cisess = $this->input->cookie('_cisess', TRUE);
//            $this->_db_details = json_decode(base64_decode($_cisess));
            $key = base64_decode($_cisess);
            $this->load->model('ClientesAkaudModel');
            $res = $this->ClientesAkaudModel->getByKey($key);
            $db_details = isset($res[0]) ? (array)$res[0] : null;
            $this->session->set_userdata('_cisess', $db_details);
            $this->_db_details = !empty($db_details) ? (object)$db_details : null;
        }


        $offline = $this->input->get('offline', true);
        if(!empty($this->_db_details) && (empty($offline) || $offline != "no")){
            $db_new_config = array(
                'dsn'	=> '',
                'hostname' => $this->_db_details->DBHost_IPserver,
                'username' => $this->_db_details->DBHost_user,
                'password' => $this->_db_details->DBHost_pwd,
                'database' => $this->_db_details->DBHost_db,
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => (ENVIRONMENT !== 'production'),
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt' => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
            $this->db = $this->load->database($db_new_config, true);
        }

        $this->data['variables2'] = null;
        if(!$this->input->is_ajax_request()) {
            $variables2 = $this->db->get('variables2')->result();
            if(isset($variables2[0]) && !empty($variables2[0])){
                $this->data['variables2'] = $variables2[0];
            }
        }
    }

}


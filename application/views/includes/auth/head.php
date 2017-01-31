<meta charset="utf-8" />
<title><?php echo !empty($title_for_layout) ? $title_for_layout: 'Softaula CRM-ERP Online'; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<link rel="stylesheet" href="<?php echo base_url() ?>app/offline/themes/offline-theme-chrome.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>app/offline/themes/offline-language-<?php echo !empty($lang) ? $lang :'spanish'; ?>.css" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo base_url() ?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo base_url() ?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url() ?>assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/vendors/sweet/sweetalert.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="/favicon.ico" />
<script type="text/javascript">
    var language = JSON.parse('<?php print_r(json_encode(languageEncodeToUtf8($this->lang->language))); ?>'),
        lang = '<?php echo $this->session->userdata("lang") ?>';
</script>

<!--added by controller-->
<?php $this->load->view('layouts/partials/header'); ?>
<!--added by controller-->

<link href="<?php echo base_url() ?>app/css/style.css" rel="stylesheet" type="text/css" />
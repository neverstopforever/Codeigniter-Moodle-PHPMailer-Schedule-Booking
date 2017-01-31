<meta charset="utf-8" />
<title><?php echo !empty($title_for_layout) ? $title_for_layout: 'Softaula CRM-ERP Online'; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description" />
<meta content="" name="author" />

<link rel="stylesheet" href="<?php echo base_url() ?>app/offline/themes/offline-theme-chrome.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>app/offline/themes/offline-language-<?php echo !empty($lang) ? $lang :'spanish'; ?>.css" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url() ?>assets/global/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url() ?>assets/admin/pages/css/login.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url() ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" id="style_components" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
<!---->
<!--<link href="--><?php //echo base_url() ?><!--assets/global/css/components.min.css" id="" rel="stylesheet" type="text/css" />-->
<!--<link href="--><?php //echo base_url() ?><!--assets/global/css/components-rounded.min.css" id="" rel="stylesheet" type="text/css" />-->

<link href="<?php echo base_url() ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

<!--<link href="--><?php //echo base_url() ?><!--assets/global/css/components-md.css" id="" rel="stylesheet" type="text/css" />-->
<link href="<?php echo base_url() ?>assets/global/css/plugins-md.css" rel="stylesheet" type="text/css" />



<link href="<?php echo base_url() ?>assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css" />
<!-- END THEME STYLES -->
<link href="<?php echo base_url() ?>assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/main.css?<?=uniqid()?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/vendors/sweet/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/admin/pages/css/inbox.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- END:File Upload Plugin CSS files-->
<link rel="shortcut icon" href="/favicon.ico" />
<script type="text/javascript">
var language = JSON.parse('<?php print_r(json_encode(languageEncodeToUtf8($this->lang->language))); ?>'),
    lang = '<?php echo $this->session->userdata("lang") ?>';
</script>
<link href="<?php echo base_url(); ?>assets/js/wysihtml5/stylesheet.css" rel="stylesheet" type="text/css">

<!-- Dynamic styles -->
<link href="<?php echo base_url() ?>assets/admin/layout3/css/themes/<?php echo $color; ?>.css" rel="stylesheet" type="text/css" />
<!-- Dynamic styles -->

<!--added by controller-->
<?php $this->load->view('layouts/partials/header'); ?>
<!--added by controller-->

<link href="<?php echo base_url() ?>app/css/campus/style.css" rel="stylesheet" type="text/css" />
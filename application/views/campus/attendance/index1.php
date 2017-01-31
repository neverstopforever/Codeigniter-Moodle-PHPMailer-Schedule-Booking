<meta charset="utf-8" />
<title>Softaula CRM-ERP Online</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description" />
<meta content="" name="author" />

<link rel="stylesheet" href="<?php echo base_url() ?>app/offline/themes/offline-theme-chrome.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>app/offline/themes/offline-language-<?php echo !empty($lang) ? $lang :'spanish'; ?>.css" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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

<link href="<?php echo base_url() ?>assets/global/css/components.min.css" id="" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

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
<link href="<?php echo base_url() ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
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


<div class="page-container">
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
        <li class="active"><?php echo $this->lang->line('campus_attendance'); ?></li>
    </ul>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <div class="row">
                <div class="col-sm-9">
                    <input type="hidden" id="classdate" name="classdate" maxlength="10" value="<?php echo date($datepicker_format);?>" readonly="readonly">
                    <div class="btn-group btn-group-sm pull-right" role="group" aria-label="...">
                        <button type="button" class="btn btn-default" id="group_view"><i class="fa fa-th-large"></i></button>
                        <button type="button" class="btn btn-default" id="individual_view"><i class="fa fa-list-ul"></i></button>
                        <button type="button" class="btn btn-default"><i class="fa fa-align-justify"></i></button>
                    </div>

                    <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#demo">
                        simple collapsible
                    </button>

                    <div id="demo" class="collapse">aaaa test</div>

                </div>
                <div class="col-sm-3">
                    <div class="datepicker"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
</script>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url() ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src='<?php echo base_url() ?>assets/global/plugins/jquery.min.js'></script>
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<!--<script src="--><?php //echo base_url() ?><!--assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>-->
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/uniform/jquery.uniform.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url() ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/quick-sidebar.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweet/sweetalert.min.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/vendors/datatables.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src='<?php echo base_url() ?>assets/global/plugins/fullcalendar/lang-all.js'></script>
<script src="<?php echo base_url() ?>assets/admin/pages/scripts/calendar.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>app/js/app.js"></script>
<script type="text/javascript">
    QuickSidebar.init();
</script>
<!--   plugins 	 -->
<script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<!--  methods for manipulating the wizard and the validation -->
<script src="<?php echo base_url(); ?>assets/js/wizard.js"></script>

<script src="<?php echo base_url(); ?>assets/js/wysihtml5/wysihtml5-0.4.0pre.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wysihtml5/advanced.js"></script>
<?php $this->load->view("includes/partials/offlineView"); ?>

<!--added by controller-->
<?php $this->load->view('layouts/partials/footer'); ?>

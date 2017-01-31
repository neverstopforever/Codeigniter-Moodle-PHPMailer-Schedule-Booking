<div class="page-footer">
    <div class="footer">
        <div class="<?php echo $layoutClass ?>">
            <div class="row">
                <div class="col-xs-12 private_terms_section_min"><p><a class="terms_use"><?php echo $this->lang->line('footer_terms_use'); ?></a> <a class="private_police margin-left-20"><?php echo $this->lang->line('footer_private_policy'); ?></a></p></div>
                <div class="col-xs-6 copyrights_section"><p class="all_rights_reserved"><i class="fa fa-copyright" aria-hidden="true"></i> AKAUD 2016  <?php echo $this->lang->line('footer_reserved_rights'); ?></p></div>
                <div class="col-xs-6 private_terms_section"><p class="text-right"><a href="#" type="button" data-type="terms" class="terms_use terms_private"><?php echo $this->lang->line('footer_terms_use'); ?></a> <a href="#" data-type="private" class="private_police margin-left-20 terms_private"><?php echo $this->lang->line('footer_private_policy'); ?></a></p></div>
            </div>
        </div>
    </div>
</div>
<?php
$remaining_days = $this->session->userdata('remaining_days');
$remaining_days_show = $this->session->userdata('remaining_days_show');
//if($remaining_days != "0"){
$this->session->unset_userdata('remaining_days_show');
//}
?>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var _remaining_days = "<?php echo $remaining_days; ?>";
    var _remaining_days_show = "<?php echo $remaining_days_show; ?>";
    var _env = "<?php echo ENVIRONMENT; ?>";
</script>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url() ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src='<?php echo base_url() ?>assets/global/plugins/jquery.min.js'></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url() ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript">
    QuickSidebar.init();
</script>
<!--   plugins 	 -->
<script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<!--<script src="--><?php //echo base_url(); ?><!--assets/js/jquery.validate.min.js"></script>-->
<!--  methods for manipulating the wizard and the validation -->
<script src="<?php echo base_url(); ?>assets/js/wizard.js"></script>

<script src="<?php echo base_url(); ?>assets/js/wysihtml5/wysihtml5-0.4.0pre.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wysihtml5/advanced.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweet/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>app/js/app.js"></script>
<?php $this->load->view("includes/partials/offlineView"); ?>

<!--added by controller-->
<?php $this->load->view('layouts/partials/footer'); ?>
<!--added by controller-->

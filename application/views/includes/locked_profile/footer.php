
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
<!-- BEGIN CORE PLUGINS -->
<script async="" src="//www.google-analytics.com/analytics.js"></script><script src="<?php echo base_url() ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url() ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<!--<script src="--><?php //echo base_url() ?><!--assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!--<script src="--><?php //echo base_url(); ?><!--assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>-->

<!--<script src="--><?php //echo base_url(); ?><!--assets/pages/scripts/ui-toastr.min.js"></script>-->
<script src="<?php echo base_url() ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!--<script src="--><?php //echo base_url() ?><!--assets/pages/scripts/lock-2.min.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->


<script type="text/javascript" src="<?php echo base_url(); ?>app/js/app.js"></script>


<?php //$this->load->view("includes/partials/offlineView"); ?>

<!--added by controller-->
<?php $this->load->view('layouts/partials/footer'); ?>
<!--added by controller-->

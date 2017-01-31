<div class="footer">
	<div class="<?php echo $layoutClass ?>">
		<div class="row">
			<div class="col-xs-12 private_terms_section_min"><p><a class="terms_use"><?php echo $this->lang->line('footer_terms_use'); ?></a> <a class="private_police margin-left-20"><?php echo $this->lang->line('footer_private_policy'); ?></a></p></div>
			<div class="col-xs-6 copyrights_section"><p class="all_rights_reserved"><i class="fa fa-copyright" aria-hidden="true"></i> AKAUD 2016  <?php echo $this->lang->line('footer_reserved_rights'); ?></p></div>
			<div class="col-xs-6 private_terms_section"><p class="text-right"><a href="#" type="button" data-type="terms" class="terms_use terms_private"><?php echo $this->lang->line('footer_terms_use'); ?></a> <a href="#" data-type="private" class="private_police margin-left-20 terms_private"><?php echo $this->lang->line('footer_private_policy'); ?></a></p></div>
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
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-ui/ui/i18n/datepicker-es.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="<?php echo base_url() ?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url() ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/pages/scripts/index3.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

<!-- BEGIN CHECKBOX -->
<script src="<?php echo base_url() ?>assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<!-- END CHECKBOX -->

<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/d3/d3.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/nvd3/nv.d3.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweet/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/JSZip-2.5.0/jszip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/pdfmake-0.1.18/build/pdfmake.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/pdfmake-0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/DataTables-1.10.9/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/DataTables-1.10.9/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/AutoFill-2.0.0/js/dataTables.autoFill.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/AutoFill-2.0.0/js/autoFill.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Buttons-1.0.3/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Buttons-1.0.3/js/buttons.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Buttons-1.0.3/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Buttons-1.0.3/js/buttons.flash.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Buttons-1.0.3/js/buttons.html5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Buttons-1.0.3/js/buttons.print.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/ColReorder-1.2.0/js/dataTables.colReorder.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/FixedColumns-3.1.0/js/dataTables.fixedColumns.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/FixedHeader-3.0.0/js/dataTables.fixedHeader.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/KeyTable-2.0.0/js/dataTables.keyTable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Responsive-1.0.7/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/RowReorder-1.0.0/js/dataTables.rowReorder.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Scroller-1.3.0/js/dataTables.scroller.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/Select-1.0.1/js/dataTables.select.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables.plugins.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/bootstrap-datatables.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/vendors/datatables.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/rowgroup.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/tabletool.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/dropfile.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/md5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/mask.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>-->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>-->
<!--<script type="text/javascript" src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url() ?><!--assets/global/plugins/select2/select2.min.js"></script>-->
<script src="<?php echo base_url() ?>assets/admin/pages/scripts/todo.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src='<?php echo base_url() ?>assets/global/plugins/fullcalendar/lang-all.js'></script>
<script src="<?php echo base_url() ?>assets/admin/pages/scripts/calendar.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/timeago.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<script src='<?php echo base_url(); ?>assets/masonry.pkgd.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>app/js/app.js"></script>

<script type="text/javascript">
QuickSidebar.init();
$('.datepicker').datepicker({
	format: '<?php echo ($lang=="english")?"yyyy-mm-dd":"dd-mm-yyyy";?>'
});
$('.datepicker').prop('readonly','readonly');
$('.arrow').off().on('click',function(e){
	var dom = $(this).parents('li');
	if(dom.hasClass('opened')){
		dom.removeClass('opened');
	}else{
		dom.addClass('opened');
	}
	return false;
});
</script>
<!--   plugins 	 -->
<script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<!--<script src="--><?php //echo base_url(); ?><!--assets/js/jquery.validate.min.js"></script>-->
<!--  methods for manipulating the wizard and the validation -->
<script src="<?php echo base_url(); ?>assets/js/wizard.js"></script>

<script src="<?php echo base_url(); ?>assets/js/wysihtml5/wysihtml5-0.4.0pre.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wysihtml5/advanced.js"></script>
<?php $this->load->view("includes/partials/offlineView"); ?>

<!--added by controller-->
<?php $this->load->view('layouts/partials/footer'); ?>
<!--added by controller-->

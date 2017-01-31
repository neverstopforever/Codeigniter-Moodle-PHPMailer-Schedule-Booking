<?php $festives = json_encode($festivities);?>
<!-- BEGIN PAGE CONTAINER -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: '2016-09-12',
			navLinks: true, // can click day/week names to navigate views
			editable: true, // allow "more" link when too many events
			eventLimit: true, 
			events: '<?php echo $festives;?>'
		});
	});

</script>
<div class="page-container">
	<div class="table_loading"></div>	
	<div class="page-content"><!-- BEGIN PAGE CONTENT -->
		<div class="<?php echo $layoutClass ?>">
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home'); ?></a>
				</li>
				<li>
					<a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
				</li>
				<li class="active">
					<?php echo $this->lang->line('festivities_festivities');?>
				</li>
			</ul>
		</div>
		<div id="calendar"></div>
	</div><!-- END PAGE CONTENT -->
</div>

<style>
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
</style>
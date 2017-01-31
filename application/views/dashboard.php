<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
<?php include 'includes/head.php';?>
</head>
<body class="page-md">
<?php include 'includes/header.php';?>
<div class="page-container">
	<div class="page-head">
		<div class="<?php echo $layoutClass ?>">
			<div class="page-title">
				<h1><?php echo $this->lang->line('menu_information'); ?></h1>
			</div>
		</div>
	</div>
	<ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
		<li>
			<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
		</li>		
		<li class="active"><?php echo $this->lang->line('dashboard'); ?></li>
	</ul>
	<div class="page-content">
		<div class="<?php echo $layoutClass ?>">
			<div class="page-content-inner">
				<div class="row widget-row">
					<div class="col-md-3">
						<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
						<h4 class="widget-thumb-heading"><?php echo $this->lang->line('lead'); ?></h4>
						<div class="widget-thumb-wrap">
						<i class="widget-thumb-icon bg-green icon-bulb"></i>
						<div class="widget-thumb-body">
							<span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo $leadcount;?>"><?php echo $leadcount;?></span>
						</div>
						</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
						<h4 class="widget-thumb-heading"><?php echo $this->lang->line('enrollment'); ?></h4>
						<div class="widget-thumb-wrap">
						<i class="widget-thumb-icon bg-red icon-layers"></i>
						<div class="widget-thumb-body">
							<span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo $matriculatcount;?>"><?php echo $matriculatcount;?></span></div>
						</div>
						</div>
					</div>
				<div class="col-md-3">
					<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
					<h4 class="widget-thumb-heading"><?php echo $this->lang->line('course'); ?></h4>
					<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo $cursocount;?>"><?php echo $cursocount;?></span></div>
					</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
					<h4 class="widget-thumb-heading"><?php echo $this->lang->line('student'); ?></h4>
					<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php echo $alumnoscount;?>"><?php echo $alumnoscount;?></span></div>
					</div>
					</div>
				</div>
			</div>
<div class="row">
<div class="col-md-6 col-sm-6">
	<div class="portlet light tasks-widget ">
		<div class="portlet-title">
			<div class="caption"><i class="icon-share font-green-haze hide"></i>
				<span class="caption-subject font-green bold uppercase"><?php echo $this->lang->line('task'); ?></span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="task-content">
				<div class="scroller" style="height: 312px;" data-always-visible="1" data-rail-visible1="1">
					<ul class="task-list">
					<?php foreach($task as  $list):
					$list = (array) $list;?>
						<li>
						<div class="task-title">
						<span class="task-title-sp"><?php echo $list['title'];?></span>
						<span class="label label-sm label-success" style="background:<?php echo '#'.$list['labelcolor'];?>"><?php echo $list['labeltask'];?></span></div>
							<!-- <div class="task-config">
							<div class="task-config-btn btn-group"><a class="btn btn-sm default"
								href="javascript:;" data-toggle="dropdown" data-hover="dropdown"
								data-close-others="true"> <i class="fa fa-cog"></i> <i
								class="fa fa-angle-down"></i> </a>
							<ul class="dropdown-menu pull-right">
								<li><a href="javascript:;"> <i class="fa fa-check"></i> Complete </a>
								</li>
								<li><a href="javascript:;"> <i class="fa fa-pencil"></i> Edit </a></li>
								<li><a href="javascript:;"> <i class="fa fa-trash-o"></i> Cancel </a>
								</li>
							</ul>
							</div>
							</div> -->
						</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			<div class="task-footer">
				<div class="btn-arrow-link pull-right">
					<a href="<?php echo base_url().'tasks' ?>" title="Task" target="_blank"><?php echo $this->lang->line('seealltask'); ?></a> <i class="icon-arrow-right"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-6 col-sm-6">
	<div class="portlet light ">
		<div class="portlet-title">
			<div class="caption caption-md"><i class="icon-bar-chart font-green"></i>
				<span class="caption-subject font-green bold uppercase"><?php echo $this->lang->line('message'); ?></span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="scroller" style="height: 338px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
				<div class="general-item-list">
				<?php foreach($inbox as  $list):
				$list = (array) $list;?>
					<div class="item">
					<div class="item-head">
					<div class="item-details"> 
						<a href="" class="item-name primary-link"><?php echo $list['Asunto'];?></a>
						<span class="item-label"><?php echo $list['Fecha'];?></span></div>
					</div>
					<div class="item-body"><?php echo word_limiter($list['body'],15);?></div>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
	</div>
		<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
<?php include 'includes/footer.php';?>
<script src="<?php echo base_url();?>assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   //Demo.init(); // init demo(theme settings page)
  // QuickSidebar.init(); // init quick sidebar
   //Index.init(); // init index page
   //Tasks.initDashboardWidget(); // init tash dashboard widget
    //app.InformesInit();
    app.header.init();
    $("[data-counter='counterup']").counterUp({
        delay: 4,
        time: 1000
    });
});

    
</script>
</body>
</html>
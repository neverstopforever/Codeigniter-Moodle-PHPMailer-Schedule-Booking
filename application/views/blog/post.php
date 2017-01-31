<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
<?php include 'includes/head.php';?>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
</head>
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body class="page-md">
<?php include 'includes/header.php';?>
<div class="page-container">
	<div class="page-head">
		<div class="<?php echo $layoutClass ?>">
			<div class="page-title">
				<h1><?php echo $this->lang->line('menu_blog'); ?></h1>
			</div>
		</div>
	</div>
	<ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
		<li><a href="#">Home</a></li>
		<li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
	</ul>
	<div class="portlet light <?php echo $layoutClass ?>">
<div class="page-content-inner">
<div class="blog-page blog-content-2">
<div class="row">
<div class="col-lg-9">
	<div class="blog-single-content blog-container">
		<div class="blog-single-head">
			<h1 class="blog-single-head-title"><?php echo $post['post_title'];?></h1>
			<div class="blog-single-head-date">
				<i class="icon-calendar font-blue"></i>
				<a href="javascript:;"><?php echo $post['post_date'];?></a>
			</div>
		</div>
		<div class="blog-single-img"><?php if(!empty($post['post_image'])):?> 
			<img src="<?php echo base_url().'uploads/'.$post['post_image'];?>" /> <?php endif;?>
		</div>
		<div class="blog-single-desc"><?php echo $post['post_content'];?></div>
		<div class="mt10">
		<?php if(!empty($prev)):?>
		<div class="pull-right prev"><a title="<?php echo $prev['post_title'];?>" href="<?php echo base_url().'blog/'.$prev['slug']?>"><?php echo $prev['post_title'];?> &gt;&gt; </a></div>
		<?php endif;?>
		<?php if(!empty($nxt)):?>
		<div class="pull-left nxt"><a title="<?php echo $nxt['post_title'];?>" href="<?php echo base_url().'blog/'.$nxt['slug']?>">&lt;&lt; <?php echo $nxt['post_title'];?></a></div>
		<?php endif;?>
		</div>
	</div>
</div>
<div class="col-lg-3">
<div class="blog-single-sidebar blog-container">
<div class="blog-single-sidebar-recent">
<h3 class="blog-sidebar-title uppercase">Recent Posts</h3>
<ul>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="scroll-to-top"><i class="icon-arrow-up"></i></div>
<?php include 'includes/footer.php';?>
<script type="text/javascript">
jQuery(document).ready(function() {
	Metronic.init();
	Layout.init();
	app.header.init();
});
</script>
</body>
</html>

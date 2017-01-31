<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html
	lang="en" class="no-js">
<!--<![endif]-->
<head>
<?php include 'includes/head.php';?>
</head>
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body class="page-md">
<?php include 'includes/header.php';?>
<div class="page-container">
<!--<div class="page-head">-->
<!--	<div class="--><?php //echo $layoutClass ?><!--">-->
<!--		<div class="page-title">-->
<!--			<h1>--><?php //echo $this->lang->line('menu_blog'); ?><!--</h1>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->

<div class="table_loading"></div>
<?php include 'includes/helpTopBar.php'; ?>
<div class="blog-page page-content blog-content-1 <?php echo $layoutClass ?>">
	<ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
		<li>
			<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
		</li>
		<li>
			<a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
		</li>
		<li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
	</ul>
	<div class="real_blog">
	<?php foreach($posts as $list):
	$list = (array) $list;
	?>
		<div class="blog-post bordered blog-container blog_item">
			<?php if(!empty($list['post_image'])):?>
			<div class="blog-img-thumb"><a href="javascript:;">
				<img src="<?php echo base_url().'uploads/'.$list['post_image'];?>" class="post_thumbnail" /> </a>
			</div>
			<?php endif;?>
			<div class="blog-post-content">
				<h2 class="blog-title blog-post-title"><a href="<?php echo base_url().'blog/'.$list['slug'];?>"><?php echo $list['post_title'];?></a>
				</h2>
				<p class="blog-post-desc">
				<?php $fulltext = strip_tags($list['post_content']);
					echo word_limiter($fulltext,50,' [...] ');?>
				</p>
				<div class="blog-post-foot">
					<div class="blog-post-meta">
						<i class="icon-calendar font-blue"></i> 
						<span class="post_date"><?php echo $list['post_date'];?></span>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach;?>
	</div>
</div>
</div>
<div class="scroll-to-top"><i class="icon-arrow-up"></i></div>
<?php include 'includes/footer.php';?>
<script>
jQuery(document).ready(function() {
	Metronic.init();
	Layout.init();
	app.header.init();
	//app.blog.all();
	var $grid = $('.real_blog').imagesLoaded(function() {
		$grid.masonry({});
	});
});
</script>
</body>
</html>
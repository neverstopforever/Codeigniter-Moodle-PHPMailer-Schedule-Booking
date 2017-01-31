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


<div class="table_loading"></div>
	<div class="page-content">
		<div class="<?php echo $layoutClass ?>">
			<ul class=" page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
				</li>
				<li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
			</ul>
	<div class="portlet light blog_write_section">
		<form class="blog_write" enctype="multipart/form-data">
		<div class="form-group"><label><?php echo $this->lang->line('write_blog_post_title'); ?></label>
		<input type="text" class="form-control post_title" required /></div>
		<div class="form-group"><label><?php echo $this->lang->line('write_blog_content'); ?></label>
			<textarea rows="8" name="" class="form-control post_content wysihtml5" required></textarea>
		</div>
		<div class="form-group"><label><?php echo $this->lang->line('write_blog_post_thumbnail'); ?></label>
			<div class="fileinput fileinput-new" data-provides="fileinput" style="width:100%;">
			<div class="input-group input-large">
			<div class="form-control uneditable-input input-fixed input-medium"
				data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i>&nbsp;
			<span class="fileinput-filename"> </span></div>
			<span class="input-group-addon btn default btn-file"> <span
				class="fileinput-new"> <?php echo $this->lang->line('select_file'); ?>  </span> <span
				class="fileinput-exists"> <?php echo $this->lang->line('_change'); ?> </span> <input type="file" name="" class="post_thumbnail" >
			</span> <a href="javascript:;"
				class="input-group-addon btn red fileinput-exists"
				data-dismiss="fileinput">  <?php echo $this->lang->line('_remove'); ?></a></div>
			</div>
		</div>
		<div class="form-group text-right" >
		<button type="submit" class="btn btn-primary btn-circle post_save"><?php echo $this->lang->line('write_blog_save_post'); ?></button>
		</div>
		</form>
	</div>
</div>
	</div>
</div>
<div class="scroll-to-top"><i class="icon-arrow-up"></i></div>
<?php include 'includes/footer.php';?>
 <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
            <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script type="text/javascript">
var ComponentsEditors = function () {
	var handleWysihtml5 = function () {
		if (!jQuery().wysihtml5) {
			return;
		}
		if ($('.wysihtml5').size() > 0) {
			$('.wysihtml5').wysihtml5({
				"stylesheets": ["<?php echo base_url() ?>assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
			});
		}
	}
	return {
		init: function () {
			handleWysihtml5();
		}
	};
}();
jQuery(document).ready(function() {
	Metronic.init();
	Layout.init();
	app.header.init();
	app.blog.create();
	ComponentsEditors.init(); 
});
</script>
</body>
</html>

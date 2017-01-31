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
<body class="page-md ">
<?php include 'includes/header.php';?>
<div class="page-container">
<div class="page-content">
	<ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
		<li>
			<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
		</li>
		<li>
			<a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
		</li>
		<li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
	</ul>
<div class="table_loading"></div>
	<div class="portlet light blog_list_page <?php echo $layoutClass ?>">
	<table class="posts table  ">
	<thead>
		<tr>
		<th><?php echo $this->lang->line('title'); ?></th>
		<th style="width:100px;"><?php echo $this->lang->line('action'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($post as $list):?>
	<tr>
		<td><a href="<?php echo base_url().'blog/edit/'.$list->post_id;?>" data-id="<?php echo $list->post_id;?>">
			<?php echo $list->post_title;?>
			</a>
		</td>
		<td>
		<a href="javascript:;" data-id="<?php echo $list->post_id;?>" class="post_unlink">
			<i class="fa fa-trash"></i> <?php echo $this->lang->line('delete'); ?>
		</a>
		</td>
	</tr>
	<?php endforeach;?>
	</tbody>
	</table>
	</div>
	</div>
</div>
<div class="scroll-to-top"><i class="icon-arrow-up"></i></div>
<?php include 'includes/footer.php';?>

<div class="modal fade" id="bloglistModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo $this->lang->line('confirmDelete'); ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
				<button type="button" class="btn btn-danger delete_blog" ><?php echo $this->lang->line('delete');?></button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
jQuery(document).ready(function() {
	Metronic.init();
	Layout.init();
	app.header.init();
	app.blog.create();
});
var table = $('.posts').DataTable({
	"sDom": "<''><'row margin-bottom-10'<'col-sm-5 col-xs-12 text-xs-center blog_list_search'f><'col-sm-7 text-right text-xs-center col-xs-12'B>><'ze_wrapper't><'row units_section margin-top-10 '<'col-xs-6'l><'col-xs-6'p>>",
	buttons: [
		//'copy', 'csv', 'pdf', 'excel', 'print'
		{
			extend: 'collection',
			text: '<i class="fa fa-cog"></i>  ' + language.classroom_export_options + '  <i class="fa fa-angle-down"></i>',
			className: 'dt_buttons_drop btn-circle margin-bottom-0 ',

			buttons: [
				{
					extend:    'copyHtml5',
					text:      '<i class="fa fa-files-o"></i> Copy',
					titleAttr: 'Copy'
				},
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i> Excel',
					titleAttr: 'Excel'
				},
				{
					extend:    'csvHtml5',
					text:      '<i class="fa fa-file-text-o"></i> CSV',
					titleAttr: 'CSV'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i> PDF',
					titleAttr: 'PDF'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-print"></i> Print',
					titleAttr: 'PDF'
				}
			],
			fade: true
		}
	],
	"language": {
		"url": base_url + "app/lang/" + lang + '.json'
	},

	"bLengthChange": true,
	"iDisplayLength": 50,
	"bAutoWidth": false,
	"sPaginationType": "simple_numbers",
	"bFilter": true,
	fnInitComplete: function () {
//		$('.post_unlink').off().on('click', function (e) {
//
//			yesDelete = confirm(language.confirmDelete);
//			if(yesDelete){
//				var id = $(this).attr('data-id');
//				$.ajax({
//					url: base_url + 'blog/delete/' + id,
//					method: 'DELETE',
//					success: function (response) {
//					if (response) {
//						location.reload();
//					}
//					}
//				});
//			}
//		});



	}
});
$("body").delegate('.post_unlink', 'click', function(e){
	e.preventDefault();
	$('#bloglistModal').modal();
	var id = $(this).attr('data-id');
	$('#bloglistModal .delete_blog').attr('data-id', id);
	$('.posts tr').removeClass('selected');
	$(this).parents('tr').addClass('selected');

});
$("body").delegate('#bloglistModal .delete_blog', 'click', function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');

	$.ajax({
					url: base_url + 'blog/delete/' + id,
				method: 'DELETE',
					success: function (response) {
					if (response) {
						$('#bloglistModal').modal('toggle');
						table
							.row( $('tr.selected') )
							.remove()
							.draw();
					}}
				});



});



$('.posts').data('table', table);
</script>



</body>
</html>

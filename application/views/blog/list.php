<div class="page-container">
	<div class="page-content">
		<div class="table_loading"></div>
		<div class="<?php echo $layoutClass ?> ">
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
				</li>
				<li>
					<a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
				</li>
				<li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
			</ul>

			<div class="portlet light blog_list_page ">
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
</div>


<script type="text/javascript">

</script>

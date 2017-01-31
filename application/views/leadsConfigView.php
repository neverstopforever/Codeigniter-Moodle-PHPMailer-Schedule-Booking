<div class="page-container">
	<div class="page-content">
		<div class="table_loading"></div>
		<div class="<?php echo $layoutClass ?>">
	<ul class=" page-breadcrumb breadcrumb">
		<li>
			<a href="<?php echo $_base_url; ?>"><?=$this->lang->line('menu_Home')?></a>
		</li>
		<li>
			<a href="<?php echo $_base_url; ?>advancedSettings"><?=$this->lang->line('menu_advanced_settings')?></a>
		</li>
		<li class="active"><?php echo $this->lang->line('menu_leads_config'); ?></li>
	</ul>



			<div class="portlet">

				<div class="text-right ">
					<button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
				</div>
				<div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
					<div class=" note note-info quick_tips_content">
						<h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
						<p><?php echo $this->lang->line('leads_config_quick_tips_text'); ?>
							<strong><a href="<?php echo $this->lang->line('leads_config_quick_tips_link'); ?>"><?php echo $this->lang->line('leads_config_quick_tips_link_text'); ?></a></strong>
						</p>
					</div>
				</div>
				<div class="pull-left margin-left-15">
					<h2 class="margin-top-0"><?php echo $this->lang->line('leads_add_your_apikeys'); ?></h2>
					<button class="btn btn-success create_new_apikey"><?php echo $this->lang->line('leads_new_apikey'); ?></button>
				</div>
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-5">

						<div class="margin-top-30 source_list">
							<?php
							if (!empty($source_state)) {

								foreach ($source_state as $k => $item) { ?>
										<div class="control-group">

											<input type="checkbox"
												   id="source_<?php echo $item->id;?>"
												   name="source[<?php echo $item->id;?>]"
													<?php if($item->active == 1){echo 'checked';}?>
												   class="make-switch customize_source"
												   data-sourceId="<?php echo $item->id;?>"
												   data-sourceActive="<?php echo $item->active;?>"
												   data-source="<?php echo $item->title;?>"
												   data-apikey="<?php echo $item->apikey;?>"
												   data-size="small" />
											<a href="javascript:;" class="margin-left-20 view_media" data-media_id="<?php echo $item->id;?>" for="source[<?php echo $item->id;?>]"><?php echo $item->title; ?></a>
										</div>
								<?php }
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Create a new connection modal -->
<div class="modal fade" id="createNewApikeyModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"> <?php echo $this->lang->line("leads_create_new_apikey"); ?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<lable><?php echo $this->lang->line('title'); ?>:</lable>
					<input type="text" class="form-control" name="title" />
				</div>
				<div class="form-group">
					<lable><?php echo $this->lang->line('source'); ?>:</lable>
					<select class="form-control" name="select_source">

					</select>
				</div>
				<div class="form-group">
					<lable><?php echo $this->lang->line('leads_type_of_source'); ?>:</lable>
					<select class="form-control" name="select_type_of_source">

					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
				<button type="button" class="btn btn-success create_apikey" ><?php echo $this->lang->line('sign_up_create');?></button>
			</div>
		</div>
	</div>
</div>

<!-- Create a new connection modal End-->

<!-- View Media modal -->
<div class="modal fade" id="editSourceModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"> <?php echo $this->lang->line("leads_edit_apikey"); ?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<lable><?php echo $this->lang->line('title'); ?>:</lable>
					<input type="text" class="form-control" name="title" />
				</div>
				<div class="form-group">
					<lable><?php echo $this->lang->line('source'); ?>:</lable>
					<select class="form-control" name="select_source">

					</select>
				</div>
				<div class="form-group">
					<lable><?php echo $this->lang->line('leads_type_of_source'); ?>:</lable>
					<select class="form-control" name="select_type_of_source">

					</select>
				</div>
				<div class="form-group">
					<lable><?php echo $this->lang->line('leads_apikey'); ?>:</lable>

					<textarea  class="form-control apikey" style="height: 133px;" disabled >

					</textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
				<button type="button" class="btn btn-success update_source" ><?php echo $this->lang->line('update');?></button>
				<button type="button" class="btn btn-danger delete_source pull-left" ><?php echo $this->lang->line('delete');?></button>
			</div>
		</div>
	</div>
</div>
<!-- View Media modal End-->

<div class="modal fade" id="deleteSourceModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo $this->lang->line('confirmDelete'); ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
				<button type="button" class="btn btn-danger delete_source" ><?php echo $this->lang->line('delete');?></button>
			</div>
		</div>
	</div>
</div>
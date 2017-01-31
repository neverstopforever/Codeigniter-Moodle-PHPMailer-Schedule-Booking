<div class="page-container system_settings">
   <div class="table_loading"></div>
    <div class="page-content tags">
        <div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
            </li>
            <li>
                <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
            </li>
            <li class="active">
                <?php echo $this->lang->line('advanced_settings_tags'); ?>
            </li>
            </ul>

            <div class="portlet light ">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('tags_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('tags_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('tags_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <div id="tags_table_empty" class=" no_data_table">

                </div>
                <div id="TagsTable">

                </div>

            </div>
            

        </div>
    </div>
</div>

<div class="modal fade" id="DleteTagModal" role="dialog">
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
                <button type="button" class="btn btn-danger delete_tag"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEditTagsModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('tags_add_tag'); ?></h4>
            </div>
            <div class="modal-body ">
                <form class="form-horizontal" name="add_edit_tags_form" role="form">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>
                                <?php echo $this->lang->line(
                                    'tags_tag_name'
                                ); ?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required
                                   name="tag_name"/>
                            <span class="title_error" style="color:red; display: none;"><?php echo $this->lang->line('required'); ?></span>
                        </div>
                    </div>
                    <div class="form-group color_form_group">
                        <div class="col-sm-3">
                            <label>
                                <?php echo $this->lang->line(
                                    'tags_back_color'
                                ); ?>
                            </label>
                        </div>
                        <div class="col-sm-9">
<!--                            <input type="text" class="" required name="hax_backcolor" '/>-->
                            <input  type="text" class=" " id="result_backcolor"    name="hax_backcolor"  value="" />

                            <input  type="text" class=" "  id="flatClearable" name=""  />
<!--                            <i class="fa fa-angle-right"></i>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>
                                <?php echo $this->lang->line(
                                    'tags_text_color'
                                ); ?>
                            </label>
                        </div>
                        <div class="col-sm-9">
<!--                            <input type="text" class="form-control" required name="hax_forecolor" '/>-->
                            <input  type="text" class=" " id="result_forecolor"    name="hax_forecolor"  value="" />

                            <input  type="text" class=" "  id="forecolor_spc" name=""  />
                        </div>
                    </div>

                </form>
            </div>


            <div class="modal-footer ">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <button  class="btn blue add_edit_tag"><?php echo $this->lang->line('classroom_save'); ?></button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="clearfix"></div>
<script>
    var _tags = <?php echo json_encode($tags); ?>;
</script>
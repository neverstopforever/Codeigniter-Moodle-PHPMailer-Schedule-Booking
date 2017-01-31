<div class="page-container system_settings custom_field_page">
   <div class="table_loading"></div>
    <div class="page-content tags">
        <div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
            <li>
            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
            </li>
            <li>
            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?> </a>
            </li>
            <li class="active">
                <?php echo $this->lang->line('advanced_settings_custom_fields'); ?>
            </li>
            </ul>

            <div class="portlet light ">
            <div class="overf_hidden_min"> <a href="<?php echo base_url('advancedSettings/add_custom_fields'); ?>" class="btn pull-right btn-primary add_custom_btn btn-circle "> <i class="fa fa-plus"></i> <?php echo $this->lang->line('advanced_settings_custom_fields'); ?></a></div>
                <div id="CustemfieldTable_empty" class="no_data_table">

                </div>
                <div id="CustemfieldTable">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<script>
    var _tags = <?php echo json_encode($tags); ?>
</script>

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
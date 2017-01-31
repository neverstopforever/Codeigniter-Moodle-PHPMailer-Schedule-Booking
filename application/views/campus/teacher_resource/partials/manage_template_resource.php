<div class=" tampl_add_res_edit margin-top-10 margin-bottom-20">
    <div>
    <div class="col-xs-12" >
        <h2 id="select_template_title"></h2>
        <p><?php echo $this->lang->line('teacher_resource_t_check_resource'); ?></p>
    </div>
    <div class="margin-bottom-20 col-xs-12 margin-top-20">
        <button type="button" class="btn btn-primary btn-circle get_resource_list_template"> <i class="fa fa-plus"> </i> <?php echo $this->lang->line('teacher_resource_t_add_resources'); ?></button>
    </div>
        </div>

</div>

<table class="template_resources table " cellspacing="0" width="100%">
    <thead>
    <tr>
        <td><?php echo $this->lang->line('teacher_resource_t_title'); ?></td>
        <td width="80"><?php echo $this->lang->line('teacher_resource_t_actions'); ?></td>
    </tr>
    </thead>
    <tbody id="template_table_body_resource" class="dbtable_hover_theme">

    </tbody>
</table>


<div id="template_list_resource_panel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title"><?php echo $this->lang->line('teacher_resource_t_select_resource'); ?></h4>
            </div>
            <div class="modal-body">

                <table class="main_resources table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <td></td>
                            <td><?php echo $this->lang->line('teacher_resource_t_title'); ?></td>
                        </tr>
                        </thead>
                        <tbody id="main_table_body_resource">
                        <?php if(!empty($resources)){?>
                            <?php foreach($resources as $k=>$resource){
                                $checkbox_checked = '';
                                if(!empty($resource_ids)){
                                    foreach($resource_ids as $resource_id){
                                        if($resource->id == $resource_id){
                                            $checkbox_checked = 'checked="checked"';
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <tr class="main_template_<?php echo $resource->id;?>">
                                    <td class="select-checkbox">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="cb_resources[]"  id="cb_resources_<?php echo $resource->id;?>" value="<?php echo $resource->id;?>" class="checkboxes" <?php echo $checkbox_checked; ?>>
                                            <label for="cb_resources_<?php echo $resource->id;?>"><span></span><span class="check"></span><span class="box"></span></label>
                                        </div>

                                    </td>
                                    <td class="r_title"><?php echo $resource->title;?></td>
                                </tr>
                            <?php }
                        }else{?>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary resource_template_save" data-template_id="<?php echo $template_id;?>"><?php echo $this->lang->line('_done'); ?></button>
            </div>
        </div>
    </div>
</div>
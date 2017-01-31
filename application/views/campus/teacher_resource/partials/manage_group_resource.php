<div class="group_add_res_edit row margin-top-10 margin-bottom-20">
    <div>
        <div class="col-xs-12">
            <h3 id="select_group_title"></h3>
            <h4 id="selected_course_title"></h4>
            <p><?php echo $this->lang->line('teacher_resource_g_mr_group');?></p>
        </div>
        <div class=" margin-top-20 col-xs-12 group_get_import">
            <button type="button" class="btn btn-primary btn-circle  get_resouce_list"> <i class="fa fa-plus"> </i> <?php echo $this->lang->line('teacher_resource_g_add_resources');?></button>
            <button type="button" class="btn btn-primary btn-circle import_template"> <i class="fa fa-download"></i> <?php echo $this->lang->line('teacher_resource_g_import_template');?></button>
        </div>
    </div>
</div>
<div id="group_resources" class="student_documents_table">

</div>

<script>
    var resources = []
    var resource_ids = [];
    var templates = [];
    var resource_group_id = null;
    var group_id = null;
    <?php if(!empty($templates)){ ?>
    var templates = <?php echo json_encode($templates); ?>;
    <?php }?>
    <?php if(!empty($resources)){ ?>
    var resources = <?php echo json_encode($resources); ?>;
    <?php }?>
    <?php if($resource_group_id){ ?>
    var resource_group_id = <?php echo $resource_group_id; ?>;
    <?php }?>
    <?php if($group_id){ ?>
    var group_id = <?php echo $group_id; ?>;
    <?php }?>
    <?php if(!empty($resource_ids)){ ?>
    var resource_ids =<?php echo json_encode($resource_ids);?>;
    <?php }?>
    var template_ids = null;
</script>



<div class="page-container">

        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_crm'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $_base_url; ?>email_templates" ><?php echo $this->lang->line('menu_email_templates'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('add'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                <div class="mt-element-step">
                    <div class="row step-line">
                        <div class="col-sm-3 mt-step-col first active " id="template_step_1">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('setup');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('email_templates_step_title_1');?></div>
                        </div>
                        <div class="col-sm-3 mt-step-col" id="template_step_2">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('style');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('email_templates_step_title_2');?></div>
                        </div>
                        <div class="col-sm-3 mt-step-col" id="template_step_3">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('compose');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('email_templates_step_title_3');?></div>
                        </div>
                        <div class="col-sm-3 mt-step-col last" id="template_step_4">
                            <div class="mt-step-number bg-white">4</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('finish');?></div>
                            <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('email_templates_step_title_5');?></div>
                        </div>
                    </div>
                </div>
                
                <div class="margin-top-20" id="step_body">

                </div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
</div>

<div class="modal fade" id="add_folder_modal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('email_templates_new_folder'); ?></h4>
            </div>
            <form action="" method="POST" id="new_folder_form">
                <div class="modal-body">
                    <?php echo $this->lang->line('email_templates_folder_name'); ?>
                    <input type="text" id="new_folder_name" name="new_folder_name" class="form-control" placeholder="Folder Name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button type="submit" class="btn blue"><?php echo $this->lang->line('email_templates_create_folder'); ?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


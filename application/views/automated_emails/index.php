<div class="page-container automated_templates">


        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass; ?>">
                <ul class=" page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('menu_automated_emails'); ?>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-xs-12 email_templates_table_block">

                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20 margin-bottom-10">
                            <div class=" note note-info quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('automated_emails_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('automated_emails_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('automated_emails_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>


                        <div class="no_automated_emails" style="display: none;"></div>
                        <table class="table display dbtable_hover_theme" id="automated_emails" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('automated_emails_template_name'); ?></th>
                                    <th><?php echo $this->lang->line('automated_emails_profile'); ?></th>
                                    <th width="150px"><?php echo $this->lang->line('automated_emails_enable_disable'); ?></th>
<!--                                <th>--><?php //echo $this->lang->line('automated_emails_edit_template'); ?><!--</th>-->
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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


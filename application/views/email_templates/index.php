<div class="page-container">
  
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_crm'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_email_templates'); ?>
                </li>
            </ul>
            <div class="row margin-bottom-20">
                <div class="col-xs-12 email_templates_header">
                    <?php echo $this->lang->line('email_templates_email_templates');?> <span>(<?php echo $all_templates_count; ?>)</span>

                </div>

            </div>

            <div class="row">
                <div class="col-md-3 ">
                    <div class="template_folders overf_hidden">
                    <div class="template_folders_in">

                    <p class="uppercase"><?php echo $this->lang->line('email_templates_folders');?></p>
                        <div class="campaign_folder_item_inner">
                            <div class="template_folder_item"  data-folder_id="all">
                                <a href="#" class="template_folder" id="all">
                                    <span class="template_folder_title">
                                        <?php echo $this->lang->line('all'); ?>
                                    </span>
                                    <span id="all_templates_count" class="number theme_background"><?php echo $all_templates_count; ?></span>
                                </a>
                            </div>
                        </div>
                    <?php
                    if(!empty($folders)){
                        foreach($folders as $folder){ ?>
                        <div class="campaign_folder_item_inner">
                            <div class="template_folder_item" data-folder_id="<?php echo $folder->id_folder; ?>">
                                <a href="#" class="template_folder" id="<?php echo $folder->id_folder; ?>">

<!--                                    <span class="number" id="ftc_--><?php //echo $folder->id_folder; ?><!--">--><?php //echo $folder->templates_count; ?><!--</span>-->
                                <span class="template_folder_title"><?php echo $folder->title; ?></span>
                                <span class="number theme_background" id="ftc_<?php echo $folder->id_folder; ?>"><?php echo $folder->templates_count; ?></span>
                                </a>
                            </div>

                            <div class="btn-group pull-right" >
                                <a type="button" class=" dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" data-campaign_id="" data-campaign_state="">
                                    <li class="send_email_display" ><a href="#" id="edit_folder"  data-folder_id="<?php echo $folder->id_folder; ?>"  title="<?php echo $this->lang->line('edit');?>" class="edit_campaign_item"><?php echo $this->lang->line('edit');?></a></li>
                                    <li class="send_email_display" ><a href="#" id="delete_folder" data-folder_id="<?php echo $folder->id_folder; ?>"  title="<?php echo $this->lang->line('delete');?>" class=""><?php echo $this->lang->line('delete');?></a></li>
                                </ul>
                            </div>
                        </div>
                       <?php  }
                    }
                    ?>
                    </div>
                        <botton class="btn  btn-primary btn-circle  margin-top-20 margin-bottom-10" id="add_folder">+ <?php echo $this->lang->line('email_templates_add_folder');?></botton>
                    </div>

                </div>
                <div class="col-md-9 email_templates_table_block">
                    <div class="text-right margin-bottom-10">
                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                    </div>
                    <div class="quick_tips_sidebar margin-top-20">
                        <div class=" note note-info quick_tips_content">
                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                            <p><?php echo $this->lang->line('email_template_quick_tips_text'); ?>
                                <strong><a href="<?php echo $this->lang->line('email_template_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('email_template_quick_tips_link_text'); ?></a></strong>
                            </p>
                        </div>
                    </div>
                    <div class="no_email_templates"></div>
                    <table class="table display dbtable_hover_theme" id="email_templates" cellspacing="0" width="100%">
                        <thead>
<!--                            <tr>-->
<!--                                <th>-->
<!--                                    <div class="md-checkbox">-->
<!--                                        <input type="checkbox" name="check_template_all" id="check_template_all" value="all" />-->
<!--                                        <label for="check_template_all">-->
<!--                                            <span></span>-->
<!--                                            <span class="check"></span>-->
<!--                                            <span class="box"></span>-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                </th>-->
<!--                                <th>--><?php //echo $this->lang->line('title'); ?><!--</th>-->
<!--                                <th>--><?php //echo $this->lang->line('subject'); ?><!--</th>-->
<!--                                <th>--><?php //echo $this->lang->line('folder'); ?><!--</th>-->
<!--                                <th>--><?php //echo $this->lang->line('action'); ?><!--</th>-->
<!--                            </tr>-->
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

<div class="modal fade" id="edit_folder_modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('email_templates_new_folder_name'); ?></h4>
            </div>
            <form action="" method="POST" id="edit_folder_form">
                <div class="modal-body">
                    <?php echo $this->lang->line('email_templates_folder_name'); ?>
                    <input type="text" id="new_folder_name" name="new_folder_name" class="form-control" placeholder="<?php echo $this->lang->line('email_templates_folder_name'); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button type="button" class="btn blue save_folder_name"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="delete_folder_modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>

            <div class="modal-body">
                <h4> <?php echo $this->lang->line('are_you_sure_delete'); ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <button type="button" class="btn btn-danger delete_folder"><?php echo $this->lang->line('delete'); ?></button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

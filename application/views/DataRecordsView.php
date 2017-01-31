        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container retables">


            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_Tables'); ?>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light">

                                <div class="text-right">
                                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                </div>
                                <div class="quick_tips_sidebar margin-top-20">
                                    <div class=" note note-info quick_tips_content">
                                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                        <p><?php echo $this->lang->line('Tables_quick_tips_text'); ?>
                                            <strong><a href="<?php echo $this->lang->line('Tables_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('Tables_quick_tips_link_text'); ?></a></strong>
                                        </p>
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <table class="table mainTable dbtable_hover_theme" id="sample_editable_1">
                                        <thead>
                                        <tr>
                                            <th>
                                            <?php echo $this->lang->line('tabPrefix_tables'); ?>
                                                <span class="pull-right">
                                                    <?php echo $this->lang->line('tables_action'); ?>
                                                </span>
                                            </th>
                                        </tr>

                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
        </div>
        <div class="specific_tableoverlay"></div>

        <div class="specific_table">

                <div class="close_me">&times;</div>

                <h3 class="tableName"></h3>
                <div class="add_new_rcd_section">
                    <div class="padding-top-10">
                        <button class="add_new_rcd btn pull-right btn-primary btn-circle"> <i class="fa fa-plus"></i> <?php echo $this->lang->line('tables_AddNewRecord'); ?> <i class="fa fa-angle-down pull-right"></i></button>
                    </div>
                    <div class="add_form" style="display:none;">
                        <form>

                        </form>
                    </div>
                </div>
                <div class="tables_data"></div>

        </div>
        <!-- Modal -->
        <!-- END PAGE CONTAINER -->
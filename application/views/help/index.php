        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('menu_Help'); ?>
                            </li>
                        </ul>
                        <div class="portlet light help_center">
                            <div class="row">
                                <div class="col-md-4 help_sections help_documentation_section">
                                    <div class="help_sections_title ">
                                        <div class="icon-wrapper pull-left">
                                            <i class="fa fa-file-text-o custom-icon"><span class="fix-editor">&nbsp;</span></i>
                                        </div>
                                        <h4 class="bold uppercase"><?php echo $this->lang->line('help_documentation'); ?></h4>
                                    </div>
                                    <p><?php echo $this->lang->line('help_documentation_text'); ?></p>
                                    <div class="help_section_footer margin-top-10">
                                        <a href="<?php echo $_base_url; ?>help/documentation" type="button" class="btn btn-default"><?php echo $this->lang->line('view_more'); ?></a>
                                    </div>
                                </div>
                                <div class="col-md-4 help_sections help_training_section">
                                    <div class="help_sections_title ">
                                        <div class="icon-wrapper pull-left">
                                            <i class="fa fa-graduation-cap custom-icon"><span class="fix-editor">&nbsp;</span></i>
                                        </div>
                                        <h4 class="bold uppercase"><?php echo $this->lang->line('help_training'); ?></h4>
                                    </div>
                                    <p><?php echo $this->lang->line('help_training_text'); ?></p>
                                    <div class="help_section_footer margin-top-10">
                                        <a href="<?php echo $_base_url; ?>help/training" type="button" class="btn btn-default"><?php echo $this->lang->line('view_more'); ?></a>
                                    </div>
                                </div>
                                <div class="col-md-4 help_sections help_releas_notes_section">
                                    <div class="help_sections_title ">
                                        <div class="icon-wrapper pull-left">
                                            <i class="fa fa-calendar custom-icon" aria-hidden="true" ><span class="fix-editor">&nbsp;</span></i>
                                        </div>
                                        <h4 class="bold uppercase"><?php echo $this->lang->line('help_releas_notes'); ?></h4>
                                    </div>
                                    <p><?php echo $this->lang->line('help_releas_notes_text'); ?></p>
                                    <div class="help_section_footer margin-top-10">
                                        <a href="<?php echo $_base_url; ?>help/releases" type="button" class="btn btn-default"><?php echo $this->lang->line('view_more'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row margin-bottom-40">
                                <div class="col-md-4 col-md-offset-2 help_sections help_community_forums_section">
                                    <div class="help_sections_title ">
                                        <div class="icon-wrapper pull-left">
                                            <i class="fa fa-comments-o custom-icon"><span class="fix-editor">&nbsp;</span></i>
                                        </div>
                                        <h4 class="bold uppercase"><?php echo $this->lang->line('help_community_forums'); ?></h4>
                                    </div>
                                    <p><?php echo $this->lang->line('help_community_forums_text'); ?></p>
                                    <div class="help_section_footer margin-top-10">
                                        <a href="<?php echo $_base_url; ?>help/forums"  type="button" class="btn btn-default"><?php echo $this->lang->line('coming_soon'); ?></a>
                                    </div>
                                </div>
                                <div class="col-md-4 help_sections help_developers_section">
                                    <div class="help_sections_title ">
                                        <div class="icon-wrapper pull-left">
                                            <i class="fa fa-wrench custom-icon"><span class="fix-editor">&nbsp;</span></i>
                                        </div>
                                        <h4 class="bold uppercase"><?php echo $this->lang->line('help_developers'); ?></h4>
                                    </div>
                                    <p><?php echo $this->lang->line('help_developers_text'); ?></p>
                                    <div class="help_section_footer margin-top-10">
                                        <a href="<?php echo $_base_url; ?>help/developers"  type="button" class="btn btn-default"><?php echo $this->lang->line('coming_soon'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
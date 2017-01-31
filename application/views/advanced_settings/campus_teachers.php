<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

    
    
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
                    <?php echo $this->lang->line('campus_teachers'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('campus_teachers_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('campus_teachers_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('campus_teachers_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <h2 class="margin-top-0"><?php echo $this->lang->line('campus_teachers_manage_teachers'); ?></h2>
                <h4><?php echo $this->lang->line('campus_teachers_manage_teachers_access_to_campus'); ?></h4>
                <p class="select_all_rows_p" style="display: none">
                    <?php echo $this->lang->line('select_all_message_text1'); ?>
                    <span class="count_this_page"></span> <span class="str_lower_tb_name"><?php echo strtolower($this->lang->line('teachers')); ?></span>
                    <?php echo ' '.$this->lang->line('select_all_message_text2'); ?>
                    <a href="#" class="select_all_table_rows"><?php echo $this->lang->line('select_all_message_text3').' <span class="count_all_pages"></span> <span class="str_lower_tb_name">'.strtolower($this->lang->line('teachers')).'</span> '. ($lang == 'spanish' ? '' : $this->lang->line('in').' <span class="tb_name">'.$this->lang->line('teacher').'</span>'); ?> ?</a>
                </p>
                <p class="unselect_all_rows_p" style="display: none">
                    <?php echo $this->lang->line('unselect_all_message_text1'); ?>
                    <span class="count_this_page"></span> <span class="str_lower_tb_name"><?php echo strtolower($this->lang->line('teachers')); ?></span>
                    <?php echo ' '.$this->lang->line('select_all_message_text2'); ?>
                    <a href="#" class="unselect_all_table_rows"><?php echo $this->lang->line('unselect_all_message_text3').' <span class="count_all_pages"></span> <span class="str_lower_tb_name">'.strtolower($this->lang->line('teachers')).'</span>'; ?>?</a>
                </p>
                <div class="no_campusTeachers" style="display: none;"></div>
                <table id="campusTeachers" class="table table-condensed dbtable_hover_theme">

                    <thead>

                    <tr>
                        <?php if (!empty($campus_teachers)) { ?>
                        <th>

                            <div class="md-checkbox">

                                <input type="checkbox" id="campusTeachers-select-all" class="md-check"/>

                                <label for="campusTeachers-select-all">

                                    <span></span>

                                    <span class="check"></span>

                                    <span class="box"></span>
                                </label>

                            </div>
                        </th>

                        <th>
                            <?php echo $this->lang->line('advanced_settings_photo');  ?></th>
                        <th>
                            <?php echo $this->lang->line('advanced_settings_user_name'); ?></th>
                        <th>
                       <?php echo $this->lang->line('advanced_settings_phone');  ?></th>
                        <th>
                            <?php echo $this->lang->line('advanced_settings_mobile'); ?></th>
                        <th><?php echo $this->lang->line('advanced_settings_status');  ?></th>
                        <th><?php echo $this->lang->line('advanced_settings_option'); ?>
                        </th>
                        <?php } else{ ?>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                            </th>
                        <?php } ?>
                    </tr>

                    </thead>

                    <tbody id="teachersTableContent">
                    <?php if (!empty($campus_teachers)) { ?>
                        <?php foreach ($campus_teachers as $teacher) { ?>
                            <tr teacher_id="<?php echo $teacher->id; ?>" status_active="<?php echo $teacher->status; ?>" teacher_email="<?php echo $teacher->email; ?>">
                                <td>
<!--                                    <input type="checkbox" class="form-control"/>-->

                                    <div class="md-checkbox" >

                                        <input type="checkbox" id="campusTeachers-select-<?php echo $teacher->id; ?>" class="md-check"/>

                                        <label for="campusTeachers-select-<?php echo $teacher->id; ?>">

                                            <span></span>

                                            <span class="check"></span>

                                            <span class="box"></span>
                                        </label>

                                    </div>



                                </td>
                                <td><img class="list_img_size" src="<?php echo $teacher->photo ? 'data:image/jpeg;base64,'.base64_encode($teacher->photo) : base_url().'assets/img/dummy-image.jpg'; ?>"></td>
                                <td>
                                    <?php echo $teacher->teacher_name; ?><br>
                                    <span class="light"><?php echo $teacher->email; ?></span>

                                </td>
                                <td><?php echo $teacher->phone; ?></td>
                                <td><?php echo $teacher->mobile; ?></td>
                                <td><?php if ($teacher->status == '1' && $teacher->Allowed == '1'){ ?>
                                    <button type="button" disabled="disabled" name="" teacher_id="<?php echo $teacher->id; ?>"
                                            status="<?php echo $teacher->Allowed; ?>"
                                            title="<?php echo $this->lang->line('advanced_settings_locked'); ?>"
                                            class="btn btn-sm btn-outline green active_state_btn state_btn"><?php echo $this->lang->line('advanced_settings_active'); ?></button>
                                    <span style="display: none">as_active</span>
                                </td>
                                <?php } else{ ?>
                                    <button type="button" disabled="disabled" name="" teacher_id="<?php echo $teacher->id; ?>"
                                            status="<?php echo $teacher->Allowed; ?>"
                                            title="<?php echo $this->lang->line('advanced_settings_active'); ?>"
                                            class="btn btn-sm btn-outline red not_active_state_btn state_btn"><?php echo $this->lang->line(
                                            'advanced_settings_locked'
                                        ); ?></button>
                                    <span  style="display: none">as_locked</span>
                                    </td>
                                            <?php } ?>
                                <td>

                                    <!-- Single button -->
                                    <div class="btn-group dropdown">
                                        <a type="button" class="dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-cog"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <?php $display = $teacher->status == '1' && $teacher->Allowed == '1' ? '' : 'display: none'; ?>
                                            <li class="send_email_display" style="<?php echo $display; ?>"><a class="send_email" teacher_id="<?php echo $teacher->id; ?>"  teacher_email="<?php echo $teacher->email; ?>" href="#"><?php echo $this->lang->line('campus_teachers_send_activa_email'); ?></a></li>
                                            <li class="lock_access" style="<?php echo $teacher->Allowed == '1' ? '' : 'display: none'; ?>"><a class="table_access_selected"  teacher_id="<?php echo $teacher->id; ?>" status="0" href="#"><?php echo $this->lang->line('campus_teachers_lock_access'); ?></a></li>
                                            <li class="unlock_access" style="<?php echo $teacher->Allowed == '1' ? 'display: none' : ''; ?>"><a class="table_access_selected"  teacher_id="<?php echo $teacher->id; ?>" status="1" href="#"><?php echo $this->lang->line('campus_teachers_unlock_access'); ?></a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


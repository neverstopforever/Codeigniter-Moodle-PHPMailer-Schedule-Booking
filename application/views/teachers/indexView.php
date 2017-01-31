<div class="page-container">

    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('teachers_index'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-center">
                                 <!--                                <input type="text" aria-controls="campusTeachers" class="form-control dt_search">-->
            <div class="no_teacher_table" style="display: none"></div>

                <div id="teachersTable">

                    <div class="text-right margin-bottom-20">
                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                    </div>
                    <div class="quick_tips_sidebar margin-top-20">
                        <div class=" note note-info text-left quick_tips_content">
                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                            <p><?php echo $this->lang->line('teachers_quick_tips_text'); ?>
                                <strong><a href="<?php echo $this->lang->line('teachers_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('teachers_quick_tips_link_text'); ?></a></strong>
                            </p>
                        </div>
                    </div>
                   <table id="Teachers" class="table dbtable_status_buttons dbtable table-condensed dbtable_hover_theme">
                    <thead>
                    <tr>
<!--                        <th>-->
<!--                             <input type="checkbox" id="campusTeachers-select-all" class="form-control icheck"/>-->
<!---->
<!--                        </th>-->
                        <th>
                            <?php echo $this->lang->line('advanced_settings_photo');  ?></th>
                        <th>
                            <?php echo $this->lang->line('advanced_settings_user_name'); ?></th>
                        <th>
                            <?php echo $this->lang->line('advanced_settings_phone');  ?></th>
                        <th>
                            <?php echo $this->lang->line('advanced_settings_mobile'); ?></th>
                        <th><?php echo $this->lang->line('advanced_settings_status');  ?></th>
                        <th><?php echo 'Option';//$this->lang->line('advanced_settings_status'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="teachersTableContent">
                    <?php if (!empty($teachers)) { ?>
                        <?php foreach ($teachers as $teacher) { ?>
                            <tr teacher_id="<?php echo $teacher->id; ?> ">
<!--                                <td>-->
<!---->
<!--                                        <input type="checkbox" class="form-control icheck"/>-->
<!---->
<!--                                </td>-->
                                <td><img class="list_img_size" src="<?php echo $teacher->photo ? 'data:image/jpeg;base64,'.base64_encode($teacher->photo) : base_url().'assets/img/dummy-image.jpg'; ?>"></td>
                                <td>
                                    <a href="<?php echo base_url().'teachers/edit/'.$teacher->id; ?>"><?php echo $teacher->teacher_name; ?></a><br>
                                    <span class="light"><?php echo $teacher->email; ?></span>

                                </td>
                                <td><?php echo $teacher->phone; ?></td>
                                <td><?php echo $teacher->cell; ?></td>
                                <td><?php if ($teacher->status == '1'){ ?>
                                    <button type="button" name="" teacher_id="<?php echo $teacher->id; ?>"
                                            status="<?php echo $teacher->status; ?>" disabled="disabled"
                                            class="btn btn-outline green"><?php echo $this->lang->line('_active'); ?></button>
                                </td>
                                <?php } else{ ?>
                                                 <button  disabled="disabled" type="button" name="" teacher_id="<?php echo $teacher->id; ?>" status="<?php echo $teacher->status; ?>"   class="btn btn-outline red"><?php echo $this->lang->line('_locked'); ?></button></td>
                                            <?php } ?>
                                <td>

                                    <!-- Single button -->

                                       <a href="#" class="delete_teacher" teacher_id="<?php echo $teacher->id; ?>"  > <i class="fa fa-trash"></i> <?php echo $this->lang->line('delete'); ?></a>

                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                </div>
                <div class="modal fade" id="deleteTeacherModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <p> <?php echo $this->lang->line('teacher_are_you_sure_delete'); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-danger deleteTeacher"><?php echo $this->lang->line('done'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

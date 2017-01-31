<div class="modal fade" id="groupEditCourseModal" role="dialog" xmlns="http://www.w3.org/1999/html">
    <div class="modal-dialog">
        <form method="post" id="group_edit_course_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"> <?php echo $this->lang->line('groups_edit_course'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <lable></lable><?php echo $this->lang->line('course_id'); ?> :</label>
                        <span><?php echo $course->courseid; ?></span>
                    </div>
                    <div class="form-group">
                        <lable></lable><?php echo $this->lang->line('course'); ?> :</label>
                        <span><?php echo $course->course_description; ?></span>
                    </div>
                    <div class="form-group">
                        <lable for="gr_edit_course_hours"><?php echo $this->lang->line('hours'); ?> :</lable>
                        <input type="text" id="gr_edit_course_hours" name="gr_edit_course_hours" class="form-control" value="<?php echo round($course->hours,2); ?>">
                    </div>
                    <div class="form-group">
                        <lable for="gr_edit_course_teacher"><?php echo $this->lang->line('teachers'); ?> :</lable>
                        <select name="gr_edit_course_teacher" id="gr_edit_course_teacher" class="form-control">
                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            <?php foreach($teachers as $teacher){
                                $selected_teacher = "";
                                if($teacher->teacher_id == $course->teacher_id){
                                    $selected_teacher = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $selected_teacher;?>><?php echo $teacher->teacher_name; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="gr_edit_course_classroom"><?php echo $this->lang->line('classroom'); ?> :</lable>
                        <select name="gr_edit_course_classroom" id="gr_edit_course_classroom" class="form-control">
                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            <?php foreach($classrooms as $classroom){
                                $selected_classroom = "";
                                if($classroom->classroom_id == $course->classroom_id){
                                    $selected_classroom = 'selected="selected"';
                                }
                                if(!empty($classroom->classroom_name)){
                                ?>
                                <option value="<?php echo $classroom->classroom_id; ?>" <?php echo $selected_classroom;?>><?php echo $classroom->classroom_name; ?></option>
                            <?php }
                            }?>
                        </select>
                    </div>
                    
                    <?php if($course->teacher_id){
                        echo ' <div class="form-group text-left add_second_teacher">';
                    }else{
                        echo ' <div class="form-group text-left add_second_teacher" style="display: none">';
                    } ?>
                            <label>
                                <?php echo $this->lang->line('groups_secondary_teacher'); ?>:
                            </label>
                            <select name="select_second_teacher_1" class="form-control margin-bottom-10 sel_teacher">
                                <option value="0"><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                                <?php if(!empty($teachers)){ ?>
                                    <?php foreach($teachers as $teacher){
                                        $selected_teacher1 = "";
                                        if($teacher->teacher_id == $course->second_teacher1){
                                            $selected_teacher1 = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $selected_teacher1;?>><?php echo $teacher->teacher_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <select name="select_second_teacher_2" class="form-control margin-bottom-10 sel_teacher">
                                <option value="0"><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                                <?php if(!empty($teachers)){ ?>
                                    <?php foreach($teachers as $teacher){
                                        $selected_teacher2 = "";
                                        if($teacher->teacher_id == $course->second_teacher2){
                                            $selected_teacher2 = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $selected_teacher2;?> ><?php echo $teacher->teacher_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <select name="select_second_teacher_3" class="form-control margin-bottom-10 sel_teacher">
                                <option value="0"><?php echo $this->lang->line('groups_select_teacher'); ?></option>
                                <?php if(!empty($teachers)){ ?>
                                    <?php foreach($teachers as $teacher){
                                        $selected_teacher3 = "";
                                        if($teacher->teacher_id == $course->second_teacher3){
                                            $selected_teacher3 = 'selected="selected"';
                                        }
                                        ?>
                                        <option value="<?php echo $teacher->teacher_id; ?>" <?php echo $selected_teacher3;?> ><?php echo $teacher->teacher_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                    <button type="button" class="btn blue edit_course"><?php echo $this->lang->line('update');?></button>
                </div>
            </div>
        </form>
    </div>
</div>
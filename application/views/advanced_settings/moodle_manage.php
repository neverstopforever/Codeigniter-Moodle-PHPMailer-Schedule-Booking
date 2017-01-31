<div class="page-container system_settings" xmlns="http://www.w3.org/1999/html">
  <div class="table_loading"></div>
  <div class="page-content">
    <div class="<?php echo $layoutClass ?>">
      <ul class= "page-breadcrumb breadcrumb">
        <li> <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a> </li>
        <li> <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a> </li>
        <li > <a href="<?php echo $_base_url; ?>advancedSettings/moodle"><?php echo $this->lang->line('moodle'); ?></a> </li>
        <li class="active"> <?php echo $this->lang->line('moodle_manage'); ?> </li>
      </ul>
      <div class="portlet light moodle_manage">
        <div class="portlet box sections " >
          <div class="portlet-body">
            <div class="tabbable-line">
              <ul class="nav nav-tabs ">
                <li class="active"> <a href="#tab_1" data-toggle="tab" aria-expanded="true"> <?php echo $this->lang->line('courses'); ?> </a> </li>
                <li class=""> <a href="#tab_2" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('teachers'); ?> </a> </li>
                <li class=""> <a href="#tab_3"  data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('students') ?> </a> </li>
                <li class=""> <a href="#tab_4"  data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('Enrollments') ?> </a> </li>
              </ul>
              <div class="tab-content">
                <div class="tools"> </div>
                <div class="tab-pane active" id="tab_1">
                  <div id="moodle_manage_course" class="manage_course_table"> </div>
                </div>
                <div class="tab-pane" id="tab_2">
                  <div id="moodle_manage_teachers" class="manage_teachers_table"> </div>
                </div>
                <div class="tab-pane" id="tab_3">
                  <div id="moodle_manage_students" class="manage_students_table"> </div>
                </div>
                <div class="tab-pane" id="tab_4">
                  <div class="row margin-bottom-20">
                    <div class="col-xs-6 moodle_manage_enrollment_back"><a href="<?php echo $_base_url; ?>advancedSettings/moodle" class="btn btn-default  btn-sm back_to_service_active_page"> <i class="fa fa-arrow-left margin-right-3" aria-hidden="true"></i> <?php echo $this->lang->line('back') ?> </a></div>
                    <div class="col-xs-3 select_group circle_select_div ">
                      <select class="form-control" id="groupsearch" name="" >
                        <option value=""><?php echo $this->lang->line('moodle_select_group'); ?></option>
                        <?php 
						if(!empty($groupData)){ 
							foreach($groupData as $groupVal){?>
                        <option value="<?php echo $groupVal->group_id;?>"><?php echo $groupVal->group_name;?></option>
                        <?php } 
						} 
						?>
                      </select>
                    </div>
                    <div class="col-xs-3 select_cours circle_select_div ">
                      <select class="form-control" id="coursesearch" name="">
                        <option value=""><?php echo $this->lang->line('moodle_select_cours'); ?></option>
                        <?php 
						if(!empty($coursesData)){ 
							foreach($coursesData as $courseVal){?>
                        <option value="<?php echo $courseVal->course_id;?>"><?php echo $courseVal->course_name;?></option>
                        <?php } 
						}
						?>
                      </select>
                    </div>
                  </div>
                  <div id="moodle_manage_enrollments" class="manage_enrollments_table"> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="link_to_cursos_modal" tabindex="-1" role="dialog" aria-labelledby="selCursosModalLabel"
     aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $this->lang->line('moodle_add_course'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label><?php echo $this->lang->line('course'); ?></label>
          <select class="form-control input-large" id="moodle_link_course_id">
            <option value="">Select Course</option>
            <?php if(!empty($moodlecourse)){
				  foreach($moodlecourse as $courseVal){ ?>
            <option value="<?php echo $courseVal['id'];?>"><?php echo mb_convert_encoding($courseVal['fullname'], "UTF-8");?></option>
            <?php }} ?>
          </select>
          <input type="hidden" name="course_id" value="" id="link_course_id">
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-12 margin-top-10">
          <div class="pull-right">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line(
                  'close'
              ); ?></button>
            <button class="btn btn-primary savecursos" onClick="moodle_course_link_into_lms()"><?php echo $this->lang->line('save'); ?></button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<div class="modal fade" id="creat_cursos_modal" tabindex="-1" role="dialog" aria-labelledby="selCursosModalLabel"
     aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $this->lang->line('moodle_create_new_course_inmoodle'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form">
          <div class="form-group">
            <label><?php echo $this->lang->line('moodle_course_name'); ?></label>
            <input type="text" class="form-control" placeholder="" value="" id="moodle_course_name">
            <input type="hidden" class="form-control" placeholder="" value="" id="lms_course_id">
          </div>
          <div class="form-group">
            <label><?php echo $this->lang->line('description'); ?> </label>
            <textarea type="text" class="form-control" placeholder="" id="moodle_course_description"></textarea>
          </div>
          <div class="form-group">
            <label><?php echo $this->lang->line('category'); ?></label>
            <select class="form-control input-large" id="moodle_category">
              <option value="">Select category</option>
              <?php if(!empty($moodlecategory)){
				  foreach($moodlecategory as $catVal){ ?>
              <option value="<?php echo $catVal['id'];?>"><?php echo mb_convert_encoding($catVal['name'], "UTF-8");?></option>
              <?php } }?>
            </select>
          </div>
          <div class="form-group">
            <label><?php echo $this->lang->line('moodle_course_format'); ?></label>
            <select class="form-control input-large" id="moodle_format" onChange="number_display();">
              <option value=""><?php echo $this->lang->line('moodle_select_course_format'); ?> </option>
              <option value="weeks"><?php echo $this->lang->line('moodle_weeks'); ?></option>
              <option value="topics"><?php echo $this->lang->line('moodle_topics'); ?></option>
              <option value="social"><?php echo $this->lang->line('moodle_social'); ?></option>
              <option value="scorm"><?php echo $this->lang->line('moodle_scorm'); ?></option>
            </select>
          </div>
          <div class="form-group" style="display:none;" id="topic_number">
            <label><?php echo $this->lang->line('moodle_number_of_weeks_topics'); ?></label>
            <input id="moodle_number" type="number" value="1" name="demo_vertical" class="form-control input-small">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="col-md-12 margin-top-10">
          <div class="pull-right">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            <button class="btn btn-primary savecursos" onClick="insert_course_in_moodle();"><?php echo $this->lang->line('moodle_create'); ?></button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<div class="modal fade" id="link_to_enroll_cursos_modal" tabindex="-1" role="dialog" aria-labelledby="selCursosModalLabel"
     aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $this->lang->line('moodle_add_course'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label><?php echo $this->lang->line('course'); ?></label>
          <select class="form-control input-large" id="enroll_moodle_link_course_id">
            <option value="">Select Course</option>
            <?php if(!empty($moodlecourse)){
				  foreach($moodlecourse as $courseVal){ ?>
            <option value="<?php echo $courseVal['id'];?>"><?php echo mb_convert_encoding($courseVal['fullname'], "UTF-8");?></option>
            <?php }} ?>
          </select>
          <input type="hidden" name="lms_student_id" value="" id="lms_student_id">
          <input type="hidden" name="lms_enroll_id" value="" id="lms_enroll_id">
          <input type="hidden" name="lms_enroll_course_id" value="" id="lms_enroll_course_id">
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-12 margin-top-10">
          <div class="pull-right">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line(
                  'close'
              ); ?></button>
            <button class="btn btn-primary savecursos" onClick="student_enroll_link_to_lms()"><?php echo $this->lang->line('save'); ?></button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<div class="modal fade" id="creat_enrollment_modal" tabindex="-1" role="dialog" aria-labelledby="selCursosModalLabel"
     aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $this->lang->line('moodle_create_new_enrollment_inmoodle'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form">
          <p><strong><?php echo $this->lang->line('moodle_student_name'); ?>:</strong></p>
          <p id="student_name"></p>
          <input type="hidden" name="enroll_student_id" value="" id="enroll_student_id">
          <br/>
          <p><strong><?php echo $this->lang->line('moodle_course'); ?>:</strong></p>
          <div class="form-group">
            <label><?php echo $this->lang->line('moodle_select_course_enroll_Moodle'); ?></label>
            <select class="form-control input-large" id="enroll_moodle_course_id">
              <option value="">Select Course</option>
              <?php if(!empty($moodlecourse)){
				  foreach($moodlecourse as $courseVal){ ?>
              <option value="<?php echo $courseVal['id'];?>"><?php echo mb_convert_encoding($courseVal['fullname'], "UTF-8");?></option>
              <?php } }?>
            </select>
          </div>
          <div class="form-group row">
            <div class="col-sm-6">
              <label><strong><?php echo $this->lang->line('start_date'); ?>:</strong></label>
              <input class="form-control form-control-inline input-small " size="16" type="date" value="" id="s_date">
            </div>
            <div class="col-sm-6">
              <label><strong><?php echo $this->lang->line('end_date'); ?>:</strong></label>
              <input class="form-control form-control-inline input-small " size="16" type="date" value="" id="e_date">
            </div>
          </div>
        </form>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <div class="col-md-12 margin-top-10">
          <div class="pull-right">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            <button class="btn btn-primary savecursos" onClick="student_enroll_in_moodle();"><?php echo $this->lang->line('moodle_create'); ?></button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_account'); ?></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
    </div>
    <!-- END PAGE HEAD -->
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li>
            <a href="javascript:;"><?= $this->lang->line('menu_Home') ?></a>
        </li>
        <li>
            <a href="javascript:;"><?= $this->lang->line('menu_academics') ?></a>
        </li>
        <li >
            <a href="<?php echo base_url('enrollments'); ?>">
                <?php echo $this->lang->line('menu_enrollments'); ?>
            </a>
        </li>
        <li class="active">
            <?php echo $this->lang->line('edit'); ?>
        </li>
    </ul>
    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-center">

                <div class="sections " >
                <div class="">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('students_section_personal_data'); ?> </a>
                                </li>
                                <li class="">
<!--                                    <a href="#tab_2" data-toggle="tab"-->
<!--                                       aria-expanded="false"> --><?php //echo $this->lang->line('students_section_billing'); ?><!--</a>-->
                                    <a href="#tab_2" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('courses'); ?></a>
                                </li>
                                <li class="">
                                    <a href="#tab_calendar" id="" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('calendar'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_3" id="documentsTab" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('students_section_documents').' ( <i class="documetns_count">'. (isset($documents[0]->doc_count) ? $documents[0]->doc_count : 0) .' </i> )' ; ?> </a>
                                </li>
                                <li class="">
                                        <a href="#tab_4" id="FollowUpTab" data-toggle="tab"
                                           aria-expanded="false"> <?php echo $this->lang->line('follow_up').' ( <i class="follow_up_count">'. (isset($follow_up_count) ? $follow_up_count : 0) .' </i> )'; ?> </a>
                                    </li>
                               <!-- <li class="">
                                    <a href="#tab_5"  data-toggle="tab"
                                       aria-expanded="false"> <?php /*echo $this->lang->line('students_section_availability'); */?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_6" data-toggle="tab"
                                       aria-expanded="false"> <?php /*echo $this->lang->line('students_section_reports'); */?> </a>
                                </li>-->
                            </ul>
                            <div class="tab-content">
                                <div class="tools">
                                </div>
                                <div class="tab-pane active student_sub_tab" id="tab_1">
                                    <div class="portlet box ">
                                        <div class="">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#portlet_tab1_1" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('_student'); ?> </a>
                                                </li>
                                                <li class="">
                                                    <a href="#portlet_tab1_2" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('students_first_tutor'); ?>  </a>
                                                </li>
                                                <li class="">
                                                    <a href="#portlet_tab1_3" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('students_second_tutor'); ?>  </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 text-center visible-xs visible-sm margin-bottom-20 margin-top-10">
                                            <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                        </div>
                                        <form name="studentDataForm" method="POST" class="form-horizontal students_tab_forms col-md-6" enctype="multipart/form-data">


                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="portlet_tab1_1">
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">
                                                                <label >
                                                                    <?php echo $this->lang->line('first_name'); ?>:
                                                                </label>
                                                                <input  type="text" class="form-control " value="<?php echo set_value('first_name', (isset($student->first_name) ? $student->first_name : '')); ?>"  name="first_name" readonly />
                                                                <?php echo form_error('first_name'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('sur_name'); ?>:
                                                                    </label>
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('sur_name', (isset($student->sur_name) ? $student->sur_name : '')); ?>"  name="sur_name" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('address'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control" value="<?php echo set_value('address', (isset($student->address) ? $student->address : '')); ?>" name="address" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('city'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control " value="<?php echo set_value('city',(isset($student->city) ? $student->city : '')); ?>"  name="city" readonly />
                                                            </div>
                                                        </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                    <label class=" ">
                                                                        <?php echo $this->lang->line('postal_code'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control " value="<?php echo set_value('postal_code', (isset($student->postal_code) ? $student->postal_code : '')); ?>" name="postal_code" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">
                                                                    <label>
                                                                        <?php echo $this->lang->line('province'); ?>:
                                                                    </label>
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('provincia', (isset($student->provincia) ? $student->provincia : '')); ?>" name="provincia" readonly />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('country'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control" value="<?php echo set_value('country', (isset($student->country) ? $student->country : '')); ?>" name="country" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('place_birth'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control " value="<?php echo set_value('place_birth', (isset($student->place_birth) ? $student->place_birth : '')); ?>"  name="place_birth" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('document'); ?>:
                                                                    </label>
                                                                <div class="col-xs-6 circle_select_div">
                                                                    <select name="doc_type" class="form-control" disabled="true" >
                                                                        <option value="0"  <?php echo (isset($student->doc_type) && $student->doc_type == '0') ? 'selected' : '' ?> ><?php echo $this->lang->line('dni'); ?></option>
                                                                        <option value="1" <?php echo (isset($student->doc_type) && $student->doc_type == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('nie'); ?></option>
                                                                        <option value="2" <?php echo (isset($student->doc_type) && $student->doc_type == '2') ? 'selected' : '' ?> ><?php echo $this->lang->line('passport'); ?></option>
                                                                        <option value="3" <?php echo (isset($student->doc_type) && $student->doc_type == '3') ? 'selected' : '' ?> ><?php echo $this->lang->line('cif'); ?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-6">
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('dni', (isset($student->dni) ? $student->dni : '')); ?>" name="dni" readonly />
                                                                </div>
                                                                </div>
                                                        </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">


                                                                    <label >
                                                                        <?php echo $this->lang->line('sex'); ?>:
                                                                    </label>
                                                            <div class="circle_select_div">


                                                                    <select name="sex" class="form-control" disabled="true" >
                                                                        <option value="1" <?php echo (isset($student->sex) &&  $student->sex == '1') ? 'selected' : ''; ?> ><?php echo $this->lang->line('male'); ?></option>
                                                                        <option value="2" <?php echo (isset($student->sex) &&  $student->sex == '2') ? 'selected' : ''; ?> ><?php echo $this->lang->line('female'); ?></option>
                                                                    </select>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('students_social_security'); ?>:
                                                                    </label>


                                                                    <input  type="text" class="form-control" value="<?php echo set_value('social_security', (isset($student->social_security) ? $student->social_security : '')); ?>" name="social_security" readonly />
                                                                </div>
                                                        </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                    <label >
                                                                        <?php echo $this->lang->line('birthday'); ?>:
                                                                    </label>


                                                                    <input  type="date" class="form-control" value="<?php echo set_value('birthday', (isset($student->birthday) ? $student->birthday : '')); ?>" name="birthday" readonly />


                                                                    <span><?php echo isset($student->years_old) ? $student->years_old.$this->lang->line('years_old') : ''; ?><span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('students_phones'); ?>:
                                                                    </label>

                                                                <div class="col-sm-6">
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('phone1', (isset($student->phone1) ? $student->phone1 : '')); ?>" name="phone1" readonly />
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($student->phone2) ? $student->phone2 : '')); ?>" name="phone2" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('mobile'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control" value="<?php echo set_value('mobile', (isset($student->mobile) ? $student->mobile : '')); ?>" name="mobile" readonly />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('email'); ?>
                                                                    </label>

                                                                    <input  type="email" class="form-control" value="<?php echo set_value('email1', (isset($student->email1) ? $student->email1 : '')); ?>" name="email1" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('email2'); ?>
                                                                    </label>


                                                                    <input  type="email" class="form-control" value="<?php echo set_value('email2', (isset($student->email2) ? $student->email2 : '')); ?>" name="email2" readonly />

                                                            </div>
                                                        </div>


                                                        <div class="col-md-12 text-left">


                                                                    <?php if(!empty($personalized_fields)) {?>
                                                                        <?php foreach($personalized_fields as $personalized){ ?>
                                                                            <div class="form-group">
                                                                                <div class=" text-left">
                                                                                    <h4 class="personalized"><?php echo $this->lang->line('personalized_fields'); ?></h4>
                                                                                    <br/>

                                                                                    <lable><?php echo  ucfirst(strtolower(str_replace('_', " ", $personalized->name))); ?>:</lable>
                                                                                </div>

                                                                                    <?php if($personalized->type != 'textarea'){ ?>
                                                                                        <?php if($personalized->name == 'area_academica' && isset($area_academica) && !empty($area_academica)){?>
                                                                                            <select class="form-control" name="area_academica" disabled="true" >
                                                                                                <?php foreach ($area_academica as $value) { ?>

                                                                                                    <option value="<?php echo $value->id; ?>"  <?php echo $value->id == $personalized->value ? 'selected' : ''; ?> ><?php echo $value->valor; ?></option>';
                                                                                                <?php }  ?>
                                                                                            </select>

                                                                                        <?php }else{ ?>

                                                                                            <input type="<?php echo $personalized->type; ?>" class="form-control " name="<?php echo $personalized->name; ?>"
                                                                                                   value="<?php echo $personalized->value; ?>" readonly >
                                                                                        <?php } ?>
                                                                                    <?php }else{ ?>
                                                                                        <textarea type="text" class="form-control " name="<?php echo $personalized->name; ?>" readonly >
                                                                                           <?php echo $personalized->value; ?>
                                                                                        </textarea>
                                                                                    <?php } ?>


                                                                            </div>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                        </div>
                                                </div>
                                                <div class="tab-pane " id="portlet_tab1_2">
                                                    <div class="col-md-12">
                                                        <div class="form-group circle_select_div text-left">

                                                            <label >
                                                                <?php echo $this->lang->line('relationship'); ?>:
                                                            </label>


                                                            <select class="form-control" name="tutor1_relationship" disabled="true" >
                                                                <option value="1" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('father'); ?></option>
                                                                <option value="2" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '2') ? 'selected' : '' ?>><?php echo $this->lang->line('mother'); ?></option>
                                                                <option value="3" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '3') ? 'selected' : '' ?>><?php echo $this->lang->line('grandFather_grandMother'); ?></option>
                                                                <option value="4" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '4') ? 'selected' : '' ?>><?php echo $this->lang->line('uncle'); ?></option>
                                                                <option value="5" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '5') ? 'selected' : '' ?>><?php echo $this->lang->line('brother_sister'); ?></option>
                                                                <option value="6" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '6') ? 'selected' : '' ?>><?php echo $this->lang->line('cousin'); ?></option>
                                                                <option value="7" <?php echo (isset($student->tutor1_relationship) && $student->tutor1_relationship == '7') ? 'selected' : '' ?>><?php echo $this->lang->line('other'); ?></option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('first_name'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control " value="<?php echo set_value('tutor1_firstname', (isset($student->tutor1_firstname) ? $student->tutor1_firstname : '')); ?>"  name="tutor1_firstname" readonly />
                                                                    <?php echo form_error('tutor1_firstname'); ?>
                                                              </div>
                                                              </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                            <label>
                                                                <?php echo $this->lang->line('students_surnames'); ?>:
                                                            </label>
                                                            <div class="col-sm-6">

                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor1_firstsurname', (isset($student->tutor1_firstsurname) ? $student->tutor1_firstsurname : '')); ?>"  name="tutor1_firstsurname" readonly />
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor1_lastsurname', (isset($student->tutor1_lastsurname) ? $student->tutor1_lastsurname : '')); ?>"  name="tutor1_lastsurname" readonly />
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label>
                                                                        <?php echo $this->lang->line('address'); ?>:
                                                                    </label>
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor1_address', (isset($student->tutor1_address) ? $student->tutor1_address : '')); ?>" name="tutor1_address" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('city'); ?>:
                                                                    </label>
                                                                    <input  type="text" class="form-control " value="<?php echo set_value('tutor1_city',(isset($student->tutor1_city) ? $student->tutor1_city : '')); ?>"  name="tutor1_city" readonly />
                                                                </div>
                                                            </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                    <label class=" ">
                                                                        <?php echo $this->lang->line('postal_code'); ?>:
                                                                    </label>
                                                                    <input  type="text" class="form-control " value="<?php echo set_value('tutor1_postal_code', (isset($student->tutor1_postal_code) ? $student->tutor1_postal_code : '')); ?>" name="tutor1_postal_code" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('province'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor1_provincia', (isset($student->tutor1_provincia) ? $student->tutor1_provincia : '')); ?>" name="tutor1_provincia" readonly />
                                                                </div >
                                                            </div>


                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('country'); ?>:
                                                                    </label>


                                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor1_country', (isset($student->tutor1_country) ? $student->tutor1_country : '')); ?>" name="tutor1_country" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('document'); ?>:
                                                                    </label>

                                                                <div class="col-sm-6">
                                                                    <select name="tutor1_doc_type" class="form-control" disabled="true"  >
                                                                        <option value="0" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '0') ? 'selected' : '' ?> ><?php echo $this->lang->line('dni'); ?></option>
                                                                        <option value="1" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('nie'); ?></option>
                                                                        <option value="2" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '2') ? 'selected' : '' ?> ><?php echo $this->lang->line('passport'); ?></option>
                                                                        <option value="3" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '3') ? 'selected' : '' ?> ><?php echo $this->lang->line('cif'); ?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor1_dni', (isset($student->tutor1_dni) ? $student->tutor1_dni : '')); ?>" name="tutor1_dni" readonly />
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('students_phones'); ?>:
                                                                    </label>

                                                                <div class="col-sm-6">
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor1_phone1', (isset($student->tutor1_phone1) ? $student->tutor1_phone1 : '')); ?>" name="tutor1_phone1" readonly />
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($student->tutor1_phone2) ? $student->tutor1_phone2 : '')); ?>" name="tutor1_phone2" readonly />
                                                                </div>
                                                                </div>
                                                            </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('mobile'); ?>:
                                                                    </label>

                                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor1_mobile', (isset($student->tutor1_mobile) ? $student->tutor1_mobile : '')); ?>" name="tutor1_mobile" readonly />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">
                                                                    <label >
                                                                        <?php echo $this->lang->line('email'); ?>
                                                                    </label>
                                                                    <input  type="email" class="form-control" value="<?php echo set_value('tutor1_email1', (isset($student->tutor1_email1) ? $student->tutor1_email1 : '')); ?>" name="tutor1_email1" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-left">

                                                                    <label >
                                                                        <?php echo $this->lang->line('email2'); ?>
                                                                    </label>

                                                                    <input  type="email" class="form-control" value="<?php echo set_value('tutor1_email2', (isset($student->tutor1_email2) ? $student->tutor1_email2 : '')); ?>" name="tutor1_email2" readonly />

                                                            </div>
                                                        </div>




                                                </div>
                                                <div class="tab-pane " id="portlet_tab1_3">
                                                    <div class="col-md-12">
                                                        <div class="form-group circle_select_div  text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('relationship'); ?>:
                                                        </label>


                                                        <select class="form-control" name="tutor2_relationship" disabled="true"  >
                                                            <option value="2" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '2') ? 'selected' : '' ?>><?php echo $this->lang->line('mother'); ?></option>
                                                            <option value="1" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('father'); ?></option>
                                                            <option value="3" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '3') ? 'selected' : '' ?>><?php echo $this->lang->line('grandFather_grandMother'); ?></option>
                                                            <option value="4" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '4') ? 'selected' : '' ?>><?php echo $this->lang->line('uncle'); ?></option>
                                                            <option value="5" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '5') ? 'selected' : '' ?>><?php echo $this->lang->line('brother_sister'); ?></option>
                                                            <option value="6" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '6') ? 'selected' : '' ?>><?php echo $this->lang->line('cousin'); ?></option>
                                                            <option value="7" <?php echo (isset($student->tutor2_relationship) && $student->tutor2_relationship == '7') ? 'selected' : '' ?>><?php echo $this->lang->line('other'); ?></option>
                                                        </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label >
                                                                    <?php echo $this->lang->line('first_name'); ?>:
                                                                </label>
                                                                <input  type="text" class="form-control " value="<?php echo set_value('tutor2_firstname', (isset($student->tutor2_firstname) ? $student->tutor2_firstname : '')); ?>"  name="tutor2_firstname" readonly />
                                                                <?php echo form_error('tutor2_firstname'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                                <label>
                                                                    <?php echo $this->lang->line('students_surnames'); ?>:
                                                                </label>
                                                            <div class="col-sm-6">

                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_firstsurname', (isset($student->tutor2_firstsurname) ? $student->tutor2_firstsurname : '')); ?>"  name="tutor2_firstsurname" readonly />
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_lastsurname', (isset($student->tutor2_lastsurname) ? $student->tutor2_lastsurname : '')); ?>"  name="tutor2_lastsurname" readonly />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label>
                                                                    <?php echo $this->lang->line('address'); ?>:
                                                                </label>
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_address', (isset($student->tutor2_address) ? $student->tutor2_address : '')); ?>" name="tutor2_address" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                                <label >
                                                                    <?php echo $this->lang->line('city'); ?>:
                                                                </label>
                                                                <input  type="text" class="form-control " value="<?php echo set_value('tutor2_city',(isset($student->tutor2_city) ? $student->tutor2_city : '')); ?>"  name="tutor2_city" readonly  />
                                                            </div>
                                                        </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label class=" ">
                                                                    <?php echo $this->lang->line('postal_code'); ?>:
                                                                </label>

                                                                <input  type="text" class="form-control " value="<?php echo set_value('tutor2_postal_code', (isset($student->tutor2_postal_code) ? $student->tutor2_postal_code : '')); ?>" name="tutor2_postal_code" readonly />

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label >
                                                                    <?php echo $this->lang->line('province'); ?>:
                                                                </label>
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_provincia', (isset($student->tutor2_provincia) ? $student->tutor2_provincia : '')); ?>" name="tutor2_provincia" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label>
                                                                    <?php echo $this->lang->line('country'); ?>:
                                                                </label>
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_country', (isset($student->tutor2_country) ? $student->tutor2_country : '')); ?>" name="tutor2_country" readonly  />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label >
                                                                    <?php echo $this->lang->line('document'); ?>:
                                                                </label>
                                                            <div class="col-sm-6 circle_select_div">
                                                                <select name="tutor2_doc_type" class="form-control" disabled="true" >
                                                                    <option value="0" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '0') ? 'selected' : '' ?> ><?php echo $this->lang->line('dni'); ?></option>
                                                                    <option value="1" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('nie'); ?></option>
                                                                    <option value="2" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '2') ? 'selected' : '' ?> ><?php echo $this->lang->line('passport'); ?></option>
                                                                    <option value="3" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '3') ? 'selected' : '' ?> ><?php echo $this->lang->line('cif'); ?></option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_dni', (isset($student->tutor2_dni) ? $student->tutor2_dni : '')); ?>" name="tutor2_dni" readonly />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                                <label >
                                                                    <?php echo $this->lang->line('students_phones'); ?>:
                                                                </label>

                                                            <div class="col-sm-6">
                                                                <input  type="text" class="form-control" value="<?php echo set_value('tutor2_phone1', (isset($student->tutor2_phone1) ? $student->tutor2_phone1 : '')); ?>" name="tutor2_phone1" readonly />
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($student->tutor2_phone2) ? $student->tutor2_phone2 : '')); ?>" name="tutor2_phone2" readonly />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('mobile'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_mobile', (isset($student->tutor2_mobile) ? $student->tutor2_mobile : '')); ?>" name="tutor2_mobile" readonly />
                                                    </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">
                                                                <label>
                                                                    <?php echo $this->lang->line('email'); ?>
                                                                </label>
                                                                <input  type="email" class="form-control" value="<?php echo set_value('tutor2_email1', (isset($student->tutor1_email1) ? $student->tutor2_email1 : '')); ?>" name="tutor2_email1" readonly />

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-left">

                                                                <label >
                                                                    <?php echo $this->lang->line('email2'); ?>
                                                                </label>

                                                                <input  type="email" class="form-control" value="<?php echo set_value('tutor2_email2', (isset($student->tutor2_email2) ? $student->tutor2_email2 : '')); ?>" name="tutor2_email2" readonly />

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-md-9 text-left">
                                                <!--<div class="back_save_group">
                                                    <input type="submit"  class="btn btn-sm btn-primary btn-circle  " value="<?php /*echo $this->lang->line('save'); */?>" />
                                                    <a href="<?php /*echo base_url('students'); */?>" class="btn-sm btn btn-circle btn-default-back back_teachers " ><?php /*echo $this->lang->line('back'); */?></a>
                                                </div>-->

                                            </div>
                                        </form>
                                        <div class="col-md-1"><a class="btn btn-success" href="<?php echo base_url().'students/edit/'.$student->id; ?>"><?php echo $this->lang->line('edit'); ?></a></div>
                                        <div class="col-md-5 text-center hidden-xs hidden-sm">
                                            <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                        </div>
                                    </div>


                                    </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="col-md-9" id="coursesTable"></div>
                                    <div class="col-md-3 text-center hidden-sm hidden-xs">
                                        <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                    </div>
                                </div>
                                <div class="tab-pane margin-top-20" id="tab_calendar">
                                    <div class="col-md-9" id="calendarData"></div>
                                    <div class="col-md-3 text-center hidden-sm hidden-xs">
                                        <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <div class="col-md-3 document_right_part text-center visible-sm visible-xs">
                                        <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                        <form action="/aws_s3/uploadDocuments/enrollment/<?php echo (isset($enroll_id) ? $enroll_id : null);?>" class="dropzone dropzone-file-area dz-clickable margin-bottom-15" method="POST" name="documents_import"
                                              id="documents_import1" >
                                            <div class="dz-default dz-message">
                                                <h4 class="sbold"><strong><?php echo $this->lang->line('document_drop_files'); ?></strong></h4>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-9">
                                        <div id="Documents" class="student_documents_table"></div>
                                    </div>
                                    <div class="col-md-3 document_right_part text-center hidden-sm hidden-xs">
                                        <img  width="80x" alt="student image" height="80px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >
                                            <form action="/aws_s3/uploadDocuments/enrollment/<?php echo (isset($enroll_id) ? $enroll_id : null);?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
                                                  id="documents_import" >
                                                <div class="dz-default dz-message">
                                                    <h4 class="sbold"><strong><?php echo $this->lang->line('document_drop_files'); ?></strong></h4>

                                                </div>
                                            </form>


                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_4">
                                    <div id="FollowUpTable" class="student_documents_table">
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_5">
                                    <div id="availability">
                                        <form name="studentAvailabilityForm">
                                            <div class="col-sm-3  visible-xs">
                                                <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                            </div>
                                        <div class="col-sm-9">
                                            <?php if(!empty($availability)){ ?>
                                                <?php foreach($availability as $key=>$value){ ?>
                                                    <div class="col-xs-6 text-left circle_select_div form-inline margin-bottom-10">
                                                        <?php  if(!isset($Morning)){?>
                                                            <h4 class="text-left margin-bottom-10"><?php echo $this->lang->line('morning'); ?></h4>
                                                            <?php $Morning = 'Morning'; ?>
                                                        <?php }  ?>

                                                        <!-- Split button -->

                                                            <select class="form-control <?php echo $key.'_start'; ?> morning_start" id="" name="<?php echo $key.'_moorning_start'; ?>" >
                                                                <?php if(!empty($availability_times)){ ?>
                                                                    <?php $selected = false; foreach($availability_times as $key_t=>$time){
                                                                            $convert_time_24_h = date("H:i", strtotime($availability[$key][$key.'_moorning_start']));
                                                                            if($convert_time_24_h == $time){
                                                                                $selected = true;
                                                                            }
                                                                            ?>
                                                                        <option value="<?php echo $key_t; ?>" <?php echo ($convert_time_24_h == $time ? 'selected' : ($key_t == '-1' && !$selected ? 'selected' : '') ); ?> ><?php echo $time; ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>

                                                                <span class="avail_to <?php echo $key.'_end'; ?> morning " style="<?php echo $availability[$key][$key.'_moorning_end'] == '00:00:00' ? 'display: none' : ''; ?>" > to </span>
                                                                <select class="form-control <?php echo $key.'_end'; ?> morning_end" id="" style="<?php echo $availability[$key][$key.'_moorning_end'] == '00:00:00' ? 'display: none' : ''; ?>" name="<?php echo $key.'_moorning_end'; ?>" >
                                                                    <?php if(!empty($availability_times)){ ?>
                                                                        <?php $selected = false; foreach($availability_times as $key_t=>$time){
                                                                            $convert_time_24_h = date("H:i", strtotime($availability[$key][$key.'_moorning_end']));
                                                                            if($convert_time_24_h == $time){
                                                                                $selected = true;
                                                                            }
                                                                            ?>
                                                                            <option value="<?php echo $key_t; ?>" <?php echo ($convert_time_24_h == $time ? 'selected' : '' ); ?> style="<?php echo !$selected ? 'display: none' : ''; ?>" ><?php echo $time; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>


                                                    </div>
                                                    <div class="col-xs-6 text-left circle_select_div form-inline margin-bottom-10">
                                                        <?php  if(!isset($Afternoon)){?>
                                                            <h4 class="text-left margin-bottom-10"><?php echo $this->lang->line('afternoon'); ?></h4>
                                                            <?php $Afternoon = 'Afternoon'; ?>
                                                        <?php }  ?>
                                                        <!-- Split button -->

                                                            <select class="form-control <?php echo $key.'_start'; ?> afternoon_start" id="" name="<?php echo $key.'_afternoon_start'; ?>" >
                                                                <?php if(!empty($availability_times)){ ?>
                                                                    <?php $selected = false; foreach($availability_times as $key_t=>$time){
                                                                        $convert_time_24_h = date("H:i", strtotime($availability[$key][$key.'_afternoon_start']));
                                                                        if($convert_time_24_h == $time){
                                                                            $selected = true;
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $key_t; ?>" <?php echo ($convert_time_24_h == $time ? 'selected' : (($key_t == '-1' &&  !$selected) ? 'selected' : '') ); ?> ><?php echo $time; ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>


                                                            <span class="avail_to <?php echo $key.'_end'; ?> afternoon" style="<?php echo $availability[$key][$key.'_afternoon_end'] == '00:00:00' ? 'display: none' : ''; ?>" > to </span>

                                                            <select class="form-control <?php echo $key.'_end'; ?> afternoon_end" id="" style="<?php echo $availability[$key][$key.'_afternoon_end'] == '00:00:00' ? 'display: none' : ''; ?>" name="<?php echo $key.'_afternoon_end'; ?>" >
                                                                <?php if(!empty($availability_times)){ ?>
                                                                    <?php $selected = false; foreach($availability_times as $key_t=>$time){
                                                                        $convert_time_24_h = date("H:i", strtotime($availability[$key][$key.'_afternoon_end']));
                                                                        if($convert_time_24_h == $time){
                                                                            $selected = true;
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $key_t; ?>"  <?php echo ($convert_time_24_h == $time ? 'selected' : ''); ?> style="<?php echo !$selected ? 'display: none' : ''; ?>" ><?php echo $time; ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>


                                                    </div>

                                                <?php } ?>
                                            <?php } ?>


                                            <div class="col-xs-12 text-left margin-top-30 back_save_group">
                                                <button type="button" class="btn btn-sm btn-primary btn-circle saveAvailability"><?php echo $this->lang->line('save'); ?></button>
                                                <input type="reset" class="btn-sm btn btn-circle btn-default-back btn-link" value="<?php echo $this->lang->line('reset'); ?>"/>
                                            </div>

                                        </div>
                                        <div class="col-sm-3  hidden-xs">
                                            <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane student_sub_tab" id="tab_6">

                                    <div id="reports" class="col-xs-12" >
                                        <div class="portlet box ">
                                            <div>
                                                <ul class="nav nav-tabs inner_nav">
                                                    <li class="active">
                                                        <a href="#portlet_tab6_1" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('enrollment'); ?> </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#portlet_tab6_2" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('accounting'); ?>  </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#portlet_tab6_3" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('my_reports'); ?>  </a>
                                                    </li>
                                                </ul>
                                                <div class=" margin-top-20 visible-xs visible-sm">
                                                    <img  width="150px" alt="student image" height="150px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >

                                                </div>
                                                <div class="pull-right hidden-xs hidden-sm">
                                                    <img  width="70px" alt="student image" height="70px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >
                                                </div>
                                            </div>







                                            <div class="portlet-body no-padding">
                                                <div class="tab-content no-padding">
                                                    <div class="tab-pane active" id="portlet_tab6_1">
                                                       <div id="ReportsEnrollmentsTable" class="student_documents_table" ></div>
                                                    </div>
                                                    <div class="tab-pane " id="portlet_tab6_2">
                                                        <div id="ReportsAccountingTable" class="student_documents_table"></div>
                                                    </div>
                                                    <div class="tab-pane " id="portlet_tab6_3">
                                                        <div class="reports_list form-line col-md-6 circle_select_div">
                                                            <select name="select_reports" class="form-control form-inline" >

                                                            </select>
                                                        </div>
                                                        <div id="MyReportsTable" class="student_documents_table col-md-12 no-padding">
                                                         </div>

                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                </div>
                            </div>

                    </div>
                </div>
                <div class="modal fade" id="addCoursesModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('classroom_add_courses'); ?></h4>
                            </div>
                            <div id="allCourses">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-success coursesSave"><?php echo $this->lang->line('classroom_save'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="followUpModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('students_add_follow_up'); ?></h4>
                            </div>
                            <div class="modal-body ">
                                <form class="form-horizontal" name="follow_up_data" role="form">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>
                                        <?php echo $this->lang->line(
                                            'title'
                                        ); ?>
                                    </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" required
                                           name="title"/>
                                    <span class="title_error" style="color:red; display: none;"><?php echo $this->lang->line('required'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>
                                        <?php echo $this->lang->line(
                                            'date'
                                        ); ?>
                                    </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control " required
                                           name="date"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>
                                        <?php echo $this->lang->line(
                                            'clientes_followup_usuario'
                                        ); ?>
                                    </label>
                                </div>
                                <div style="text-transform:uppercase" class="col-sm-9">
                                    <?php
                                    $userData = $this->session->userdata('userData');
                                    echo $usuario = $userData[0]->USUARIO;
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>
                                        <?php echo $this->lang->line(
                                            'comment'
                                        ); ?>
                                    </label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea class="form-control" required
                                              name="comment"></textarea>
                                </div>
                            </div>
                             </form>
                            </div>


                            <div class="modal-footer col-sm-12">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-success saveFollowUp"><?php echo $this->lang->line('classroom_save'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


                    <div class="modal fade" id="enrollDleteDocumentModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p><?php echo $this->lang->line('confirmDelete'); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                                    <button type="button" class="btn btn-danger modal_delete" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="modal fade" id="studentDleteFollowUpModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p><?php echo $this->lang->line('confirmDelete'); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                                    <button type="button" class="btn btn-danger delete_follow_up" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="addCoursesModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('classroom_add_courses'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <div id="allCourses">

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-circle btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-primary btn-circle coursesSave"><?php echo $this->lang->line('classroom_save'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('classroom_are_you_sure_delete_course'); ?></h4>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-success deleteCourseModal"><?php echo $this->lang->line('done'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="clearfix"></div>


            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script>
    global_studentId = false;
    <?php if(isset($student->id)) { ?>
        global_studentId = <?php echo  json_encode($student->id); ?>;
    <?php } ?>
    global_enrollId = false;
    <?php if(isset($enroll_id)) { ?>
    global_enrollId = <?php echo  json_encode($enroll_id); ?>;
    <?php } ?>

    var documents = <?php echo json_encode(array('data' => $documents)); ?>;
    var courses = <?php echo json_encode($courses); ?>;

</script>
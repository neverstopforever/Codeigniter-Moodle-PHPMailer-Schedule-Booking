<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">

    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>enrollments"> <?php echo $this->lang->line('menu_enrollments'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('edit'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-center">

                <div class="sections " >
                <div class="row">
                    <div class="col-md-3 margin-top-10 enrollments_edit_img ">
                        <div class="margin-bottom-20 text-left">
                            <a href="<?php echo $_base_url; ?>enrollments" class="btn-sm btn btn-circle btn-default-back "> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                        </div>
                        <div class="overf_hidden">
                            <img  width="100px" alt="student image" height="100px" src="<?php echo  isset($student->photo_link) ? $student->photo_link : base_url()."assets/img/dummy-image.jpg " ; ?> " >
                            <h4 class="pull-left margin-top-0 margin-left-10 "><strong><?php echo set_value('first_name', (isset($student->first_name) ? $student->first_name : '')); ?> <?php echo set_value('sur_name', (isset($student->sur_name) ? $student->sur_name : '')); ?></strong></h4>
                        </div>
                        <div class="margin-top-20 text-left personal_info_parent ">
                            <a class=" btn  btn-primary btn-circle  personal_info" href="<?php echo base_url().'students/edit/'.$student->id; ?>">
                                <?php echo $this->lang->line('enrollments_personal_info'); ?>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                        </div>
                        <div class="student_short_info text-left">
                            <?php if(!empty($student->email1)){ ?>
                                <p><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span> <?php echo   $student->email1  ?> </p>
                            <?php } ?>
                            <?php if(!empty($student->phone1) || isset($student->phone2)){ ?>
                                <p><span><i class="fa fa-phone" aria-hidden="true"></i></span> <?php echo $student->phone1; ?> <?php echo $student->phone1; ?></p>
                            <?php } ?>
                            <?php if(!empty($student->mobile)){ ?>
                                <p><span><i class="fa fa-mobile" aria-hidden="true"></i></span> <?php echo $student->mobile; ?></p>
                            <?php } ?>
                            <?php if(!empty($student->country)){ ?>
                                <p><span><i class="fa fa-map-marker" aria-hidden="true"></i></span> <?php echo $student->country; ?></p>
                            <?php } ?>
                        </div>
                        <p class="text-left enrollm_tags"><?php echo $this->lang->line('enrollments_tags'); ?></p>
                        <table id="tags_bg" class="table  tag_table ">
                            <tbody>
                            <tr class="success">
                                <td class="text-left">
                                    <a href="javascript:;" class="enroll_tags">  </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-left">
                            <button class="btn  btn-primary btn-circle enrollment_print_template">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                <?php echo $this->lang->line('enrollments_print'); ?></button>
                        </div>


                    </div>
                    <div class="col-md-9">
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
                            <li class="">
                                    <a href="#tab_quotes" id="QuotesTab" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('quotes_quotes').' ( <i class="quotes_count">'. (isset($quotes_count) ? $quotes_count : 0) .' </i>  )'; ?> </a>
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
                                <div class="portlet box">
                                    <form name="studentDataForm" method="POST" class="students_tab_forms enrollments_personal_data margin-top-10" enctype="multipart/form-data">
                                      <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4>
                                                    <?php echo $this->lang->line('_student'); ?>
                                                </h4>

                                                <div class="form-group text-left">
                                                        <label >
                                                            <?php echo $this->lang->line('first_name'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control " value="<?php echo set_value('first_name', (isset($student->first_name) ? $student->first_name : '')); ?>"  name="first_name" readonly />
                                                        <?php echo form_error('first_name'); ?>
                                                    </div>
                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('sur_name'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('sur_name', (isset($student->sur_name) ? $student->sur_name : '')); ?>"  name="sur_name" readonly />

                                                </div>
                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('address'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control" value="<?php echo set_value('address', (isset($student->address) ? $student->address : '')); ?>" name="address" readonly />

                                                </div>
                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('city'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control " value="<?php echo set_value('city',(isset($student->city) ? $student->city : '')); ?>"  name="city" readonly />
                                                </div>
                                                <div class="form-group text-left">
                                                    <label class=" ">
                                                        <?php echo $this->lang->line('postal_code'); ?>:
                                                    </label>
                                                    <input  type="text" class="form-control " value="<?php echo set_value('postal_code', (isset($student->postal_code) ? $student->postal_code : '')); ?>" name="postal_code" readonly />
                                                </div>
                                                <div class="form-group text-left">
                                                        <label>
                                                            <?php echo $this->lang->line('province'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('provincia', (isset($student->provincia) ? $student->provincia : '')); ?>" name="provincia" readonly />
                                                </div>
                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('country'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control" value="<?php echo set_value('country', (isset($student->country) ? $student->country : '')); ?>" name="country" readonly />

                                                </div>
                                                <div class="form-group text-left">
                                                    <label >
                                                        <?php echo $this->lang->line('place_birth'); ?>:
                                                    </label>
                                                    <input  type="text" class="form-control " value="<?php echo set_value('place_birth', (isset($student->place_birth) ? $student->place_birth : '')); ?>"  name="place_birth" readonly />
                                                </div>
                                                <div class="form-group text-left two_input_row overf_hidden">

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
                                                <div class="form-group text-left">



                                                    <div class="circle_select_div margin-top-10 margin-bottom-20">

                                                        <label class="sex_dropdown_label">
                                                            <?php echo $this->lang->line('sex'); ?>:
                                                        </label>
                                                            <select name="sex" class="form-control sex_dropdown" disabled="true" >
                                                                <option value="1" <?php echo (isset($student->sex) &&  $student->sex == '1') ? 'selected' : ''; ?> ><?php echo $this->lang->line('male'); ?></option>
                                                                <option value="2" <?php echo (isset($student->sex) &&  $student->sex == '2') ? 'selected' : ''; ?> ><?php echo $this->lang->line('female'); ?></option>
                                                            </select>
                                                        </div>

                                                </div>
                                                <div class="form-group text-left">
                                                    <label >
                                                        <?php echo $this->lang->line('students_social_security'); ?>:
                                                    </label>
                                                    <input  type="text" class="form-control" value="<?php echo set_value('social_security', (isset($student->social_security) ? $student->social_security : '')); ?>" name="social_security" readonly />
                                                </div>
                                                <div class="form-group text-left">
                                                    <label >
                                                        <?php echo $this->lang->line('birthday'); ?>:
                                                    </label>


                                                    <input  type="date" class="form-control" value="<?php echo set_value('birthday', (isset($student->birthday) ? $student->birthday : '')); ?>" name="birthday" readonly />


                                                    <span><?php echo isset($student->years_old) ? $student->years_old.$this->lang->line('years_old') : ''; ?><span>

                                                </div>
                                                <div class="form-group text-left two_input_row overf_hidden">

                                                        <label>
                                                            <?php echo $this->lang->line('students_phones'); ?>:
                                                        </label>

                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('phone1', (isset($student->phone1) ? $student->phone1 : '')); ?>" name="phone1" readonly />
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($student->phone2) ? $student->phone2 : '')); ?>" name="phone2" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group text-left">

                                                            <label >
                                                                <?php echo $this->lang->line('mobile'); ?>:
                                                            </label>

                                                            <input  type="text" class="form-control" value="<?php echo set_value('mobile', (isset($student->mobile) ? $student->mobile : '')); ?>" name="mobile" readonly />

                                                    </div>
                                                <div class="form-group text-left">
                                                    <label >
                                                        <?php echo $this->lang->line('email'); ?>
                                                    </label>
                                                    <input  type="email" class="form-control" value="<?php echo set_value('email1', (isset($student->email1) ? $student->email1 : '')); ?>" name="email1" readonly />

                                                </div>
                                                <div class="form-group text-left">
                                                    <label >
                                                        <?php echo $this->lang->line('email2'); ?>
                                                    </label>
                                                    <input  type="email" class="form-control" value="<?php echo set_value('email2', (isset($student->email2) ? $student->email2 : '')); ?>" name="email2" readonly />

                                                </div>
                                                <div class=" text-left">
<!--                                                                <h4 class="personalized">--><?php //echo $this->lang->line('personalized_fields'); ?><!--</h4>-->
                                                        <h4 class="personalized text-uppercase"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                                            <?php if(!empty($personalized_fields)) {?>
                                                                <?php foreach($personalized_fields as $personalized){ ?>
                                                                    <div class="form-group">
                                                                        <div class=" text-left">
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

                                                <?php

                                             if(isset($student->custom_fields)){
                                             $custom = explode(',',$student->custom_fields);
                                                }else{
                                                $custom = array();
                                                }
                                                 if(!empty($customfields_fields)) { $i=0; ?>
                                <?php foreach($customfields_fields as $customfields){  ?>
                                <div class="col-md-12 text-left">
                                <div class="form-group text-left circle_select_div">

                                <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1){ ?>

                                    <lable class="text-capitalize"><?php echo $customfields['field_name']; ?>:</lable>
                                    <textarea type="text" class="form-control " name="custom_fields[]" <?php if($customfields['required']== 1){echo 'required';}  if($customfields['disabled']== 1){echo 'disabled';} ?>><?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?></textarea>
                                <?php $i++;} elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                    <lable class="text-capitalize "><?php echo  $customfields['field_name']; ?>:</lable>
                                    <input type="text" <?php if($customfields['required']== 1){echo 'required';}
                                    if($customfields['disabled']== 1){
                                        echo 'disabled';
                                    } ?>  class="form-control" name="custom_fields[]" value="<?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?>">
                                <?php $i++;}

                                elseif($customfields['field_type'] =='select' && $customfields['active']== 1){ ?>
                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                    <select class="form-control" name="custom_fields[]">
                                        <?php
                                        $options = explode(',',$customfields['options']);
                                        foreach ($options as $value) {?>
                                            <option value="<?php echo $value;?>" <?php if(!empty($custom[$i]) && $custom[$i] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                                        <?php }?>
                                    </select>
                                <?php $i++;}
                          elseif($customfields['field_type'] =='datepicker' && $customfields['active']== 1){ ?>
                                    <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                    <input type="text" <?php if($customfields['required']== 1){echo 'required';}
                                    if($customfields['disabled']== 1){
                                        echo 'disabled';
                                    } ?>  class="form-control datepicker" name="custom_fields[]" value="<?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?>">
                                <?php $i++;}
                                 elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                    <input type="checkbox" <?php if($customfields['required']== 1){echo 'required';}
                                    if($customfields['disabled']== 1){
                                        echo 'disabled';
                                    } ?>   name="custom_fields[]" <?php if(!empty($custom[$i])){ echo "checked"; }else{ }?> value="yes">&nbsp;&nbsp;&nbsp;<?php echo  $customfields['field_name']; ?>
                                <?php $i++;}
                                else{

                                 }?>
                                </div>
                                </div>
                                 <?php
                                 }
                             }?>
                      </div>
                                            <div class="col-md-4" >
                                               <h4> <?php echo $this->lang->line('students_first_tutor'); ?></h4>


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


                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('first_name'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control " value="<?php echo set_value('tutor1_firstname', (isset($student->tutor1_firstname) ? $student->tutor1_firstname : '')); ?>"  name="tutor1_firstname" readonly />
                                                        <?php echo form_error('tutor1_firstname'); ?>
                                                  </div>


                                                <div class="form-group text-left two_input_row overf_hidden">

                                                    <label>
                                                        <?php echo $this->lang->line('students_surnames'); ?>:
                                                    </label>
                                                    <div class="col-xs-6">

                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_firstsurname', (isset($student->tutor1_firstsurname) ? $student->tutor1_firstsurname : '')); ?>"  name="tutor1_firstsurname" readonly />
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_lastsurname', (isset($student->tutor1_lastsurname) ? $student->tutor1_lastsurname : '')); ?>"  name="tutor1_lastsurname" readonly />
                                                    </div>
                                                </div>

                                                <div class="form-group text-left ">

                                                        <label>
                                                            <?php echo $this->lang->line('address'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_address', (isset($student->tutor1_address) ? $student->tutor1_address : '')); ?>" name="tutor1_address" readonly />

                                                </div>

                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('city'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control " value="<?php echo set_value('tutor1_city',(isset($student->tutor1_city) ? $student->tutor1_city : '')); ?>"  name="tutor1_city" readonly />
                                                </div>


                                                <div class="form-group text-left">
                                                            <label class=" ">
                                                                <?php echo $this->lang->line('postal_code'); ?>:
                                                            </label>
                                                            <input  type="text" class="form-control " value="<?php echo set_value('tutor1_postal_code', (isset($student->tutor1_postal_code) ? $student->tutor1_postal_code : '')); ?>" name="tutor1_postal_code" readonly />

                                                </div>


                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('province'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_provincia', (isset($student->tutor1_provincia) ? $student->tutor1_provincia : '')); ?>" name="tutor1_provincia" readonly />
                                                </div >


                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('country'); ?>:
                                                        </label>


                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_country', (isset($student->tutor1_country) ? $student->tutor1_country : '')); ?>" name="tutor1_country" readonly />

                                                </div>


                                                <div class="form-group two_input_row overf_hidden text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('document'); ?>:
                                                        </label>

                                                    <div class="col-xs-6 circle_select_div">
                                                        <select name="tutor1_doc_type" class="form-control" disabled="true"  >
                                                            <option value="0" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '0') ? 'selected' : '' ?> ><?php echo $this->lang->line('dni'); ?></option>
                                                            <option value="1" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('nie'); ?></option>
                                                            <option value="2" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '2') ? 'selected' : '' ?> ><?php echo $this->lang->line('passport'); ?></option>
                                                            <option value="3" <?php echo (isset($student->tutor1_doc_type) && $student->tutor1_doc_type == '3') ? 'selected' : '' ?> ><?php echo $this->lang->line('cif'); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_dni', (isset($student->tutor1_dni) ? $student->tutor1_dni : '')); ?>" name="tutor1_dni" readonly />
                                                    </div>

                                                </div>


                                                <div class="form-group text-left two_input_row overf_hidden">

                                                        <label >
                                                            <?php echo $this->lang->line('students_phones'); ?>:
                                                        </label>

                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor1_phone1', (isset($student->tutor1_phone1) ? $student->tutor1_phone1 : '')); ?>" name="tutor1_phone1" readonly />
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($student->tutor1_phone2) ? $student->tutor1_phone2 : '')); ?>" name="tutor1_phone2" readonly />
                                                    </div>
                                                </div>


                                                <div class="form-group text-left">

                                                            <label >
                                                                <?php echo $this->lang->line('mobile'); ?>:
                                                            </label>

                                                            <input  type="text" class="form-control" value="<?php echo set_value('tutor1_mobile', (isset($student->tutor1_mobile) ? $student->tutor1_mobile : '')); ?>" name="tutor1_mobile" readonly />

                                                </div>


                                                <div class="form-group text-left">
                                                        <label >
                                                            <?php echo $this->lang->line('email'); ?>
                                                        </label>
                                                        <input  type="email" class="form-control" value="<?php echo set_value('tutor1_email1', (isset($student->tutor1_email1) ? $student->tutor1_email1 : '')); ?>" name="tutor1_email1" readonly />
                                                </div>

                                                <div class="form-group text-left">

                                                        <label >
                                                            <?php echo $this->lang->line('email2'); ?>
                                                        </label>

                                                        <input  type="email" class="form-control" value="<?php echo set_value('tutor1_email2', (isset($student->tutor1_email2) ? $student->tutor1_email2 : '')); ?>" name="tutor1_email2" readonly />

                                                </div>

                                            </div>
                                            <div class="col-md-4" >
                                                <h4><?php echo $this->lang->line('students_second_tutor'); ?></h4>


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

                                                <div class="form-group text-left">
                                                        <label >
                                                            <?php echo $this->lang->line('first_name'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control " value="<?php echo set_value('tutor2_firstname', (isset($student->tutor2_firstname) ? $student->tutor2_firstname : '')); ?>"  name="tutor2_firstname" readonly />
                                                        <?php echo form_error('tutor2_firstname'); ?>
                                                </div>


                                                <div class="form-group text-left two_input_row overf_hidden">

                                                        <label>
                                                            <?php echo $this->lang->line('students_surnames'); ?>:
                                                        </label>
                                                    <div class="col-xs-6">

                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_firstsurname', (isset($student->tutor2_firstsurname) ? $student->tutor2_firstsurname : '')); ?>"  name="tutor2_firstsurname" readonly />
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_lastsurname', (isset($student->tutor2_lastsurname) ? $student->tutor2_lastsurname : '')); ?>"  name="tutor2_lastsurname" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group text-left">
                                                        <label>
                                                            <?php echo $this->lang->line('address'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_address', (isset($student->tutor2_address) ? $student->tutor2_address : '')); ?>" name="tutor2_address" readonly />
                                                </div>
                                                <div class="form-group text-left">
                                                        <label >
                                                            <?php echo $this->lang->line('city'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control " value="<?php echo set_value('tutor2_city',(isset($student->tutor2_city) ? $student->tutor2_city : '')); ?>"  name="tutor2_city" readonly  />
                                                </div>

                                                <div class="form-group text-left">
                                                        <label class=" ">
                                                            <?php echo $this->lang->line('postal_code'); ?>:
                                                        </label>

                                                        <input  type="text" class="form-control " value="<?php echo set_value('tutor2_postal_code', (isset($student->tutor2_postal_code) ? $student->tutor2_postal_code : '')); ?>" name="tutor2_postal_code" readonly />

                                                </div>


                                                <div class="form-group text-left">
                                                        <label >
                                                            <?php echo $this->lang->line('province'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_provincia', (isset($student->tutor2_provincia) ? $student->tutor2_provincia : '')); ?>" name="tutor2_provincia" readonly />
                                                </div>
                                                <div class="form-group text-left">
                                                        <label>
                                                            <?php echo $this->lang->line('country'); ?>:
                                                        </label>
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_country', (isset($student->tutor2_country) ? $student->tutor2_country : '')); ?>" name="tutor2_country" readonly  />
                                                </div>

                                                <div class="form-group text-left two_input_row overf_hidden">
                                                        <label >
                                                            <?php echo $this->lang->line('document'); ?>:
                                                        </label>
                                                    <div class="col-xs-6 circle_select_div">
                                                        <select name="tutor2_doc_type" class="form-control" disabled="true" >
                                                            <option value="0" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '0') ? 'selected' : '' ?> ><?php echo $this->lang->line('dni'); ?></option>
                                                            <option value="1" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '1') ? 'selected' : '' ?> ><?php echo $this->lang->line('nie'); ?></option>
                                                            <option value="2" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '2') ? 'selected' : '' ?> ><?php echo $this->lang->line('passport'); ?></option>
                                                            <option value="3" <?php echo (isset($student->tutor2_doc_type) && $student->tutor2_doc_type == '3') ? 'selected' : '' ?> ><?php echo $this->lang->line('cif'); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_dni', (isset($student->tutor2_dni) ? $student->tutor2_dni : '')); ?>" name="tutor2_dni" readonly />
                                                    </div>
                                                </div>


                                                <div class="form-group text-left two_input_row overf_hidden">

                                                        <label >
                                                            <?php echo $this->lang->line('students_phones'); ?>:
                                                        </label>

                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('tutor2_phone1', (isset($student->tutor2_phone1) ? $student->tutor2_phone1 : '')); ?>" name="tutor2_phone1" readonly />
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input  type="text" class="form-control" value="<?php echo set_value('phone2', (isset($student->tutor2_phone2) ? $student->tutor2_phone2 : '')); ?>" name="tutor2_phone2" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group text-left">

                                                    <label >
                                                        <?php echo $this->lang->line('mobile'); ?>:
                                                    </label>

                                                    <input  type="text" class="form-control" value="<?php echo set_value('tutor2_mobile', (isset($student->tutor2_mobile) ? $student->tutor2_mobile : '')); ?>" name="tutor2_mobile" readonly />
                                                </div>

                                                <div class="form-group text-left">
                                                        <label>
                                                            <?php echo $this->lang->line('email'); ?>
                                                        </label>
                                                        <input  type="email" class="form-control" value="<?php echo set_value('tutor2_email1', (isset($student->tutor1_email1) ? $student->tutor2_email1 : '')); ?>" name="tutor2_email1" readonly />

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


                                </div>


                                </div>
                            <div class="tab-pane" id="tab_2">

                                <div  class="no_coursesTable" style="display: none;"></div>
                                <div id="coursesTable"></div>
                            </div>
                            <div class="tab-pane " id="tab_calendar">
                                <div class="portlet box ">
                                    <div class="">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_calendar_1" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('enrollments_calendar_view'); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_calendar_2" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('enrollments_list_view'); ?>  </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_calendar_1" >
                                                <div  id="calendarData" class="margin-top-10 portlet light portlet-fit  calendar fc fc-ltr fc-unthemed"></div>
                                            </div>
                                            <div class="tab-pane " id="tab_calendar_2" >

                                                <div class="no_EventListTable" style="display: none;"></div>
                                                <div id="EventListTable"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div  class="no_Documents" style="display: none;"></div>
                                <div id="Documents" class="student_documents_table"></div>
                            </div>
                            <div class="tab-pane" id="tab_4">

                                <div class="no_FollowUpTable" style="display: none;">
                                </div>
                                <div id="FollowUpTable" class="student_documents_table">
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_quotes">
                                <?php if($active_tab) {?>
                                <div>
                                    <a href="<?php echo $referrer_url; ?>" class=" btn btn-circle btn-default-back  back_system_settigs pull-left margin-bottom-20"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                         <?php echo $this->lang->line('back'); ?> <?php echo $this->lang->line('menu_manage_invoices'); ?>
                                    </a>
                                </div>
                                <?php } ?>

                                <div class="no_quotesTable" style="display: none;">

                                </div>
                                <div id="quotesTable" class="student_documents_table">

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
                                <div class="col-sm-7">
                                    <input type="text" class="form-control follow_up_datepicker" required
                                           name="date"/>
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" class="btn btn-primary setToDay"><?php echo $this->lang->line('quotes_to_day'); ?></a>
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
                                <button  class="btn blue saveFollowUp"><?php echo $this->lang->line('classroom_save'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="modal fade" id="documentenrollment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('teachers_upload_document'); ?></h4>
                            </div>
                            <!--                            <form id="DocumentUp" method="POST" enctype="multipart/form-data">-->
                            <div class="modal-body">
                                <form action="/aws_s3/uploadDocuments/enrollment/<?php echo (isset($enroll_id) ? $enroll_id : null);?>" class="dropzone dropzone-file-area dz-clickable " method="POST" name="documents_import"
                                      id="documents_import" >
                                    <div class="dz-default dz-message">
                                        <h4 class="sbold"><strong><?php echo $this->lang->line('document_drop_files'); ?></strong></h4>

                                    </div>
                                </form>

                            </div>

                            <!--                            </form>-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <!--                                <button type="submit" class="btn btn-primary">--><?php //echo $this->lang->line('upload'); ?><!--</button>-->
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="modal fade" id="enrollDleteDocumentModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"> <?php echo $this->lang->line('please_confirm'); ?></h4>
                                </div>
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
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"> <?php echo $this->lang->line('please_confirm'); ?></h4>
                                </div>
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
                                <button type="button" class="btn  btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-primary  coursesSave"><?php echo $this->lang->line('classroom_save'); ?></button>
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
                                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <p> <?php echo $this->lang->line('classroom_are_you_sure_delete_course'); ?>                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-danger deleteCourseModal"><?php echo $this->lang->line('done'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="deleteTagModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
                            </div>
                            <div class="modal-body">
                                <p> <?php echo $this->lang->line('are_you_sure_delete'); ?>                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn btn-danger deleteTagModal"><?php echo $this->lang->line('done'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="CashQoutesModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('quotes_cash_quote'); ?></h4>
                            </div>

                            <div class="modal-body">
                                <div class="form-group row ">
                                    <lable class="col-md-4 control-label"><?php echo $this->lang->line('quotes_id_quote'); ?>:</lable>
                                    <div class="col-md-8 quote_id"></div>
                                </div>

                                <div class="form-group row">
                                    <lable class="col-md-4 control-label" ><?php echo $this->lang->line("quotes_payment_type"); ?>: </lable>
                                    <div class="col-md-6">
                                        <select name="payment_type" class="form-control payment_type_select">
                                            <option value="0"><?php echo $this->lang->line('quotes_cash'); ?> </option>
                                            <option value="1"><?php echo $this->lang->line('quotes_credit_card'); ?> </option>
                                            <option value="2"><?php echo $this->lang->line('quotes_direct_debit'); ?></option>
                                            <option value="3"><?php echo $this->lang->line('quotes_transfer'); ?></option>
                                            <option value="4"><?php echo $this->lang->line('quotes_check'); ?> </option>
                                            <option value="5"><?php echo $this->lang->line('quotes_financed'); ?></option>
                                            <option value="6"><?php echo $this->lang->line('quotes_online_payment'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <lable class="col-md-4 control-label" ><?php echo $this->lang->line("quotes_state"); ?>: </lable>
                                    <div class="col-md-8"><strong><?php echo $this->lang->line("quotes_due");//$receipt->state;?></strong></div>
                                </div>
                                <div class="form-group row">
                                    <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_appointment_date"); ?>: </lable>
                                    <div class="col-md-8 appointment_date"></div>
                                </div>
                                <div class="form-group row">
                                    <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_amount_due"); ?>: </lable>
                                    <div class="col-md-8 amount_due"></div>
                                </div>
                                <div class="form-group row">
                                    <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_customer_type"); ?>: </lable>
                                    <div class="col-md-8 customer_type"><strong><?php echo $this->lang->line("student"); ?></strong></div>
                                </div>
                                <div class="form-group row">
                                    <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_invoiced"); ?>: </lable>
                                    <div class="col-md-8 invoiced"></div>
                                </div>
                                <div class="form-group row">
                                    <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_service"); ?>: </lable>
                                    <div class="col-md-8 service"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <lable for="history_date"><?php echo $this->lang->line("quotes_payment_date"); ?>: </lable>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control"  type="text" name="history_date" id="history_date" value="<?php echo date($datepicker_format);?>"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <a href="#" id="add_comment"><?php echo $this->lang->line('quotes_comments'); ?></a>
                                </div>
                                <div class="form-group" style="display: none;"  id="comments_section">
                                    <lable for="memo"><?php echo $this->lang->line("quotes_comments"); ?>: </lable>
                                    <textarea class="form-control" name="memo" id="memo"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn blue cashQuote"><?php echo $this->lang->line('quotes_cash_btn'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="bulk_actions" style="display:none;">
                    <div class="btn-group pull-right margin-left-10 quote_actions_section">
                        <div class="dropdown text-right quote_actions">
                            <a href="#" class="btn btn-primary btn-circle dropdown-toggle" data-toggle="dropdown"> <i
                                    class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line(
                                    "actions"
                                ) ?> <span class="margin-left-3px caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="delete_quote"><?php echo $this->lang->line(
                                            "quotes_delete_quotes"
                                        ); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal fade" id="CashQoutesPrintModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('quotes_cash_quote'); ?></h4>
                            </div>

                            <div class="modal-body">
                                <h3><?php echo $this->lang->line('quotes_are_you_want_print_or_email'); ?></h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button  class="btn blue cashQuotePrint"><?php echo $this->lang->line('print'); ?></button>
                                <button  class="btn btn-success cashQuotePrintAndEmail"><?php echo $this->lang->line('quotes_print_and_email'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="eventpanel" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"> <?php echo $this->lang->line('enrollemts_view_event');?> </h4>
                            </div>
                            <div class="modal-body">
                                <div class="event_title"></div>
                                <div class="event_date"></div>
                                <label><strong><?php echo $this->lang->line('groups_detail');?></strong></label>
                                <div class="event_detail"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
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
</div>
<!-- END PAGE CONTAINER -->


<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('templates');?></h4>
            </div>
            <div class="modal-body" align="center">
                <div class="select_template"></div>
                <div id="previewFrame" class="margin-top-20" ></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary print_template"><?php echo $this->lang->line('enrollments_print'); ?></button>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
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
    var active_tab = <?php echo isset($active_tab) ? json_encode($active_tab) : json_encode(array()); ?>;
    var _tags = <?php echo  json_encode($tags);?>;
    var _enroll_tags = <?php echo  json_encode($enroll_tags);?>;
    var _enroll_tag_ids = <?php echo  json_encode($enroll_tag_ids);?>;

</script>
        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_profile'); ?>
                </li>
            </ul>


            <div class="row">
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="col-sm-3">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                <img src="<?php echo !empty($profileFoto['imageUrl']) ? $profileFoto['imageUrl'] :  base_url()."assets/img/dummy-image.jpg"; ?>" class="img-responsive" alt="">
                            </div>
                            <!-- END SIDEBAR USERPIC -->
                            <!-- SIDEBAR USER TITLE -->
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">

                                </div>
                            </div>
                            <!-- END SIDEBAR USER TITLE -->
                            <!-- SIDEBAR BUTTONS -->
<!--                            <div class="profile-userbuttons">-->
<!--                                <a type="button" class="btn btn-primary btn-circle" href="--><?php //echo base_url() ?><!--messaging"> <i class="fa fa-envelope-o" aria-hidden="true"></i> --><?php //echo $this->lang->line('profile_messageButton') ?><!--</a>-->
<!--                            </div>-->
                            <!-- END SIDEBAR BUTTONS -->
                        </div>
                        <!-- END PORTLET MAIN -->
                        <!-- PORTLET MAIN -->
                        <!-- END PORTLET MAIN -->
                    </div>
                    <!-- END BEGIN PROFILE SIDEBAR -->
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content col-sm-9">


                            <div class="profile_view_section">
                                <div class="profile_view">
                                    <div class="pull-right">
                                        <?php if($is_owner || $id == $current_id){ ?>
                                            <button class="btn btn-primary btn-circle edit_info"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('profile_editInfobutton') ?></button>
                                        <?php } ?>
                                    </div>
                                    <h3><?php echo $this->lang->line('profile_editProfileInfoTitle') ?></h3>
                                    <div class="ze_wrapper">
                                        <table class="table dbtable_hover_theme table-advance margin-top-20">
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $this->lang->line('profile_usernamePlaceholder') ?></td>
                                                    <td class="user_name"></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->lang->line('profile_phonePlaceholder') ?></td>
                                                    <td class="phone"></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->lang->line('profile_emailPlaceholder') ?></td>
                                                    <td class="email"></td>
                                                </tr>
<!--                                                <tr>-->
<!--                                                    <td>--><?php //echo $this->lang->line('profile_groupPlaceholder') ?><!--</td>-->
<!--                                                    <td class="group"></td>-->
<!--                                                </tr>-->
                                                <tr>
                                                    <td><?php echo $this->lang->line('profile_AboutPlaceholder') ?></td>
                                                    <td class="about"></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->lang->line('active') ?></td>
                                                    <td class="">
                                                        <input type="checkbox" <?php echo ($is_owner && $id != $current_id ? '' : 'disabled'); ?> name="user_status" data-user_id="<?php echo $id; ?>" class="activated_checkbox user_status"  />

                                                        <span class="margin-left-40 is_owner"></span>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table dbtable_hover_theme table-advance margin-top-20">
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $this->lang->line('profile_allow_messaging_students') ?></td>
                                                    <td class="allow_messaging_students">
                                                        <input type="checkbox" <?php echo ($is_owner ? '' : 'disabled'); ?> name="messaging_students" data-user_id="<?php echo $id; ?>" class="messaging_students_checkbox"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->lang->line('profile_allow_messaging_teachers') ?></td>
                                                    <td class="allow_messaging_teachers">
                                                        <input type="checkbox" <?php echo ($is_owner ? '' : 'disabled'); ?> name="messaging_teachers" data-user_id="<?php echo $id; ?>" class="messaging_teachers_checkbox"  />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php if($is_owner || $id == $current_id){ ?>
                                <div class="portlet light edit_profile" style="display:none;">

                                    <div class="portlet-body">
                                        <div class=" edit_profile" >
                                            <div class="  portlet-title ">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <!-- <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span> -->
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab"><?php echo $this->lang->line('profile_tabPersonalInfo') ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab"><?php echo $this->lang->line('profile_tabchangeFoto') ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_3" data-toggle="tab"><?php echo $this->lang->line('profile_tabchangePassword') ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                <form role="form" action="#">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_usernamePlaceholder') ?></label>
                                                        <input type="text" placeholder="<?php echo $this->lang->line('profile_usernamePlaceholder') ?>" class="form-control user_name" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_phonePlaceholder') ?></label>
                                                        <input type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control phone" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_emailPlaceholder') ?></label>
                                                        <input type="email" placeholder="Design, Web etc." class="form-control email" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_AboutPlaceholder') ?></label>
                                                        <textarea class="form-control about" rows="3" placeholder=""></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="user_status" <?php echo ($is_owner && $id != $current_id ? '' : 'disabled'); ?> data-user_id="<?php echo $id; ?>" class="activated_checkbox user_status"  />
                                                    </div>
                                                    <div class="margiv-top-10 back_save_group">
                                                        <a href="javascript:;" class="btn btn-sm btn-primary btn-circle update_profile_info"><?php echo $this->lang->line('button_saveChanges') ?></a>
                                                        <a href="javascript:;" class="btn-sm btn btn-circle btn-default-back  cancle_update"><?php echo $this->lang->line('button_cancel') ?></a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE AVATAR TAB -->
                                            <div class="tab-pane" id="tab_1_2">
                                                <div class="profile-userpic pull-left" >
                                                    <i class="fa fa-remove photo_remove" title="<?php echo $this->lang->line('delete'); ?>" style="display: none;"></i>
                                                    <img src="<?php echo !empty($profileFoto['imageUrl']) ? $profileFoto['imageUrl'] :  base_url()."assets/img/dummy-image.jpg"; ?>" class="img-responsive" width="145px" height="140px" style="border-radius: 1% !important;" alt="">
                                                </div>

                                                <div class="upload_profile_img col-sm-12 margin-top-10">
                                                    <button type="button"  class="btn btn-primary btn-circle upload_photo">
                                                        <?php echo $this->lang->line('change_photo'); ?>
                                                    </button>
                                                    <form action="<?php echo base_url(); ?>aws_s3/updateUserProfilePhoto/user" style="display: none;" id="user_photo_dropzone" method="POST" class="dropzone dropzone-file-area dz-clickable">
                                                        <input type="file" name="photo[]" id="photo_input"  />
                                                    </form>
                                                </div>
<!--                                                <form action="--><?php //echo base_url() ?><!--user/profileFotoUpload" class="" id="my-awesome-dropzone">-->
<!--                                                    <div class="fallback">-->
<!--                                                        <div class="fileinput fileinput-new" data-provides="fileinput">-->
<!--                                                            <span class="btn btn-primary btn-circle btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input name="file" type="file" multiple /></span>-->
<!--                                                            <span class="fileinput-filename"></span>-->
<!--                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>-->
<!--                                                        </div>-->
<!---->
<!--                                                    </div>-->
<!--                                                </form>-->

                                            </div>
                                            <!-- END CHANGE AVATAR TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_3">
                                                <form action="#" class="changePassword">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_currentPasswordPlaceholder') ?></label>
                                                        <input type="password" class="form-control current_password" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_newPasswordPlaceholder') ?></label>
                                                        <input type="password" class="form-control new_password" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo $this->lang->line('profile_reNewPasswordPlaceholder') ?></label>
                                                        <input type="password" class="form-control password_again" />
                                                    </div>
                                                    <div class="margin-top-10 back_save_group">
                                                        <button type="submit" class="btn btn-sm btn-primary btn-circle "><?php echo $this->lang->line('button_saveChanges') ?></button>
                                                        <a href="javascript:;" class="btn-sm btn btn-circle btn-default-back cancle_update"><?php echo $this->lang->line('button_cancel') ?></a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>


        </div>
        </div>
        </div>

        <script>
            var _user_id = <?php echo json_encode($id); ?>;
        </script>
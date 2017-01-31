<div class="page-container">


    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li class="active"><?php echo $this->lang->line('profile_setting'); ?></li>
            </ul>
            <div class="page-content-inner">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <h2 class="caption-subject font-blue-madison bold uppercase"><?php echo $this->lang->line('profile_account'); ?></h2>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="profile-sidebar">
                            <div class="portlet light profile-sidebar-portlet text-center ">
                                <div class="profile-userpic">
                                    <i class="fa fa-remove photo_remove" title="<?php echo $this->lang->line('delete'); ?>" ></i>
                                    <img src="<?php echo @$campus_header_data['imageUrl'];?>" class="img-responsive"  alt="">
                                </div>

                                <div class="upload_profile_img">
                                    <button type="button"  class="btn btn-primary btn-circle upload_photo">
                                        <?php echo $this->lang->line('change_photo'); ?>
                                    </button>
                                    <form action="<?php echo base_url('campus/aws_s3/updateCampusProfilePhoto/profesor'); ?>" style="display: none;" id="user_photo_dropzone" method="POST" class="dropzone dropzone-file-area dz-clickable">
                                        <input type="file" name="photo[]" id="photo_input"  />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="profile-content-inner">
                            <div class="profile-content-header">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1_1"  data-toggle="tab"><?php echo $this->lang->line('personal_info'); ?></a></li>
                                    <li><a href="#tab_1_2" data-toggle="tab"><?php echo $this->lang->line('change_password'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                                    <div class="profile-content">

                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <!-- PERSONAL INFO TAB -->
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <form role="form" name="teachers_profile_form" >
                                                        <div class="form-group margin-top-20">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'first_name'
                                                                ); ?></label>
                                                            <input type="text" placeholder=""
                                                                   name="first_name" class="form-control"
                                                                   value="<?php echo $user['sNombre']; ?>"/></div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'last_name'
                                                                ); ?></label>
                                                            <input type="text" placeholder=""  name="last_name" class="form-control"
                                                                   value="<?php echo $user['sApellidos']; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'campus_email'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" name="email" class="form-control"
                                                                   value="<?php echo $user['Email']; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'campus_email'
                                                                ).' 2'; ?></label>
                                                            <input type="text" placeholder="" name="email_2" class="form-control"
                                                                   value="<?php echo $user['Email2']; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'mobile'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" name="mobile" class="form-control"
                                                                   value="<?php echo $user['movil']; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'address'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" name="address" class="form-control"
                                                                   value="<?php echo $user['Domicilio']; ?>"/>
                                                        </div>
                                                        <div class="margin-top-10 back_save_group">
                                                            <button
                                                               class="btn btn-primary btn-circle xs_btn_block save_teacher_form_data"> <?php echo $this->lang->line(
                                                                    'save changes'
                                                                ); ?> </button>
                                                            <button  class="btn btn-default btn-circle-default btn_to_back xs_btn_block"> <?php echo $this->lang->line(
                                                                    'cancel'
                                                                ); ?> </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tab_1_2">
                                                    <?php echo $this->session->flashdata('error'); ?>
                                                    <form action="<?php echo base_url().'campus/user/changepassword' ?>"
                                                          method="POST">
                                                        <div class="form-group margin-top-20">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'current_password'
                                                                ); ?></label>
                                                            <input type="password" name="old_password"
                                                                   class="form-control" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'new_password'
                                                                ); ?></label>
                                                            <input type="password" name="password" class="form-control"
                                                                   required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    're_type_password'
                                                                ); ?></label>
                                                            <input type="password" name="new_password" required
                                                                   class="form-control"/>
                                                        </div>
                                                        <div class="margin-top-10 back_save_group">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-circle xs_btn_block"><?php echo $this->lang->line(
                                                                    'change_password'
                                                                ); ?> </button>
                                                            <button  class="btn btn-default btn-circle-default btn_to_back xs_btn_block"> <?php echo $this->lang->line(
                                                                    'cancel'
                                                                ); ?></button>
                                                        </div>
                                                    </form>
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
    <div class="clearfix"></div>
</div>


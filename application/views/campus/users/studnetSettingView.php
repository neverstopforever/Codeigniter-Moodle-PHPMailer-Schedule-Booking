<div class="page-container">
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_information'); ?></h1>
            </div>
        </div>
    </div>
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li><a href="#"><?= $this->lang->line('menu_Home') ?></a><i class="fa fa-circle"></i></li>
        <li class="active"><?php echo $this->lang->line('dashboard'); ?></li>
    </ul>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-sidebar">
                            <div class="portlet light profile-sidebar-portlet ">
                                <div class="profile-userpic">
                                    <img src="" class="img-responsive" alt="">
                                </div>
                                <div class="profile-usermenu">
                                    <ul class="nav">
                                        <li>
                                            <a href="#"> <i class="icon-home"></i><?php echo $this->lang->line(
                                                    'overview'
                                                ); ?> </a>
                                        </li>
                                        <li class="active">
                                            <a href="#"> <i class="icon-settings"></i> <?php echo $this->lang->line(
                                                    'account_setting'
                                                ); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="profile-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md">
                                                <i class="icon-globe theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab_1_1"
                                                                      data-toggle="tab"><?php echo $this->lang->line(
                                                            'personal_info'
                                                        ); ?></a></li>
                                                <li><a href="#tab_1_2" data-toggle="tab"><?php echo $this->lang->line(
                                                            'change_password'
                                                        ); ?></a></li>

                                            </ul>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <!-- PERSONAL INFO TAB -->
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <form role="form" action="#">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'first_name'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" class="form-control"
                                                                   value="<?php echo $user->name; ?>"/></div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'last_name'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" class="form-control"
                                                                   value="<?php echo $user->name; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'campus_email'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" class="form-control"
                                                                   value="<?php echo $user->email; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'mobile'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" class="form-control"
                                                                   value="<?php echo $user->mobile; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $this->lang->line(
                                                                    'address'
                                                                ); ?></label>
                                                            <input type="text" placeholder="" class="form-control"
                                                                   value="<?php echo $user->address; ?>"/>
                                                        </div>
                                                        <div class="margiv-top-10">
                                                            <a href="javascript:;"
                                                               class="btn green"> <?php echo $this->lang->line(
                                                                    'save'
                                                                ); ?> </a>
                                                            <a href="javascript:;"
                                                               class="btn default"> <?php echo $this->lang->line(
                                                                    'cancel'
                                                                ); ?> </a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tab_1_2">
                                                    <?php echo $this->session->flashdata('error'); ?>
                                                    <form action="<?php echo base_url().'campus/user/changepassword' ?>"
                                                          method="POST">
                                                        <div class="form-group">
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
                                                        <div class="margin-top-10">
                                                            <button type="submit"
                                                                    class="btn green"><?php echo $this->lang->line(
                                                                    'change_password'
                                                                ); ?> </button>
                                                            <a href="javascript:;"
                                                               class="btn default"> <?php echo $this->lang->line(
                                                                    'cancel'
                                                                ); ?></a>
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
            <div class="clearfix"></div>
        </div>
    </div>
</div>
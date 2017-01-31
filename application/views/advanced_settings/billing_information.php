        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container system_settings">

           
            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class= "page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                        <li>
                            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                        </li>
                    <li class="active">
                        <?php echo $this->lang->line('user_billing_information'); ?>
                    </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light">

                        <div class="text-right margin-bottom-10">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                            <div class=" note note-info quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('billing_information_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('billing_information_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('billing_information_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane">
                            <div class="portlet box">
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#company_tab" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('company'); ?> </a>
                                        </li>
                                        <li class="">
                                            <a href="#subscribers_tab" data-toggle="tab" aria-expanded="false"> <?php echo $this->lang->line('billing_manage_suscriptions'); ?>  </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="company_tab" >
                                            <form class="form-horizontal col-md-6" name="company_form" method="post">

                                                <div class="col-md-12 text-left margin-top-10">
                                                    <div class="form-group">
                                                        <label classs="form-lable"><?php echo $this->lang->line('fiscal_name'); ?>:</label>
                                                        <input type="text" name="fiscal_name" class="form-control" value="<?php echo set_value('fiscal_name', $company->fiscal_name); ?>">
                                                        <div class="text-danger"><?php echo form_error('fiscal_name'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('commercial_name'); ?>:</label>
                                                        <input type="text" name="commercial_name" class="form-control" value="<?php echo set_value('commercial_name', $company->commercial_name); ?>">
                                                        <div class="text-danger"><?php echo form_error('commercial_name'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                        <label><?php echo $this->lang->line('address'); ?>:</label>
                                                        <input type="text" name="address" class="form-control" value="<?php echo set_value('address', $company->address); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                        <label><?php echo $this->lang->line('city'); ?>:</label>
                                                        <input type="text" name="city" class="form-control" value="<?php echo set_value('city', $company->city); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                        <label><?php echo $this->lang->line('province'); ?>:</label>
                                                        <input type="text" name="province" class="form-control" value="<?php echo set_value('province', $company->province); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                         <label><?php echo $this->lang->line('postal_code'); ?>:</label>
                                                         <input type="text" name="postal_code" class="form-control" value="<?php echo set_value('postal_code', $company->postal_code); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group">
                                                          <label><?php echo $this->lang->line('phone'); ?>:</label>
                                                          <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', $company->phone); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                        <label><?php echo $this->lang->line('country'); ?>:</label>
                                                        <input type="text" name="country" class="form-control" value="<?php echo set_value('country', $company->country); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                        <label><?php echo $this->lang->line('advanced_settings_incumbent'); ?>:</label>
                                                        <input type="text" name="incumbent" class="form-control" value="<?php echo set_value('incumbent', $company->incumbent); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group ">
                                                        <label><?php echo $this->lang->line('bank'); ?>:</label>
                                                        <input type="text" name="bank_iban" class="form-control" value="<?php echo set_value('bank_iban', $company->bank_iban); ?>">
                                                        <div class="text-danger"><?php echo form_error('bank_iban'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('advanced_settings_bank_sufix'); ?>:</label>
                                                        <input type="text" name="bank_sufix" class="form-control" value="<?php echo set_value('bank_sufix', $company->bank_sufix); ?>">
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="clearfix"></div>
                                            <?php if(($plan != '1' && $paid != '0') || ( $paid == '0' && empty($trial_expire) && $plan != '1') || ( $is_super_admin )){ ?>
                                                <div class="col-md-6 text-left">
                                                    <form action="/aws_s3/uploadImg/logo" class="logo_login2_picture col-md-12 dropzone dropzone-file-area dz-clickable" data-img_field="logo">

                                                            <div class="form-group ">
                                                            <div class="dz-default dz-message">
                                                                <h4 class="sbold">
                                                                    <strong><?php echo $this->lang->line('advanced_settings_drop_site_logo'); ?></strong>
                                                                </h4>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                            <div class="clearfix"></div>
                                            <div>

                                            </div>

                                            <div class=" text-left back_save_group">
                                                <a href="<?php echo base_url('advancedSettings'); ?>" class="btn-sm btn btn-circle btn-default-back back_system_settigs"><?php echo $this->lang->line('back'); ?></a>
                                                <button class="btn btn-sm btn-primary btn-circle save_company_data" ><?php echo $this->lang->line('save'); ?></button>
                                                <a href="<?php echo base_url('advancedSettings'); ?>" class="btn-sm btn btn-circle btn-default-back back_system_settigs_min"><?php echo $this->lang->line('back'); ?></a>
                                            </div>

                                            <div class="clearfix"></div>

                                        </div>
                                        <div class="tab-pane " id="subscribers_tab" >
                                        
                                        </div>
                                    </div>
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
        <!-- END PAGE CONTAINER -->



       <!-- <div class="col-xs-4">
            <form action="/aws_s3/uploadImg/logo" class="logo_login2_picture dropzone dropzone-file-area dz-clickable" data-img_field="logo">
                <div class="dz-default dz-message">
                    <h4 class="sbold"><?php /*echo $this->lang->line('advanced_settings_drop_site_logo'); */?></h4>
                </div>
            </form>
        </div>
        <div class="col-xs-4">
            <form action="/aws_s3/uploadImg/login2_picture" class="logo_login2_picture dropzone dropzone-file-area dz-clickable" data-img_field="login2_picture">
                <div class="dz-default dz-message">
                    <h4 class="sbold"><?php /*echo $this->lang->line('advanced_settings_drop_login2_image'); */?></h4>
                </div>
            </form>
        </div>-->

<script>
    var active_tab = "<?php echo $active_tab; ?>";
</script>
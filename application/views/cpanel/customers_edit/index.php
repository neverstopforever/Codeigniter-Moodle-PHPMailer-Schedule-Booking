<div class="page-container customer_accounts">

        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="/"><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_customers'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('cpanel_customer_accounts'); ?>
                    </li>
                </ul>
                <!-- BEGIN PAGE CONTENT INNER -->

                <div class="portlet light text-center">

                    <div class="sections " >
                        <div class="">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('cpanel_customer_general_data'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#followUpTab" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('follow_up'); ?></a>
                                </li>
                                <li class="">
                                    <a href="#tab_3" id="templates" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('templates'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_4" id="emails" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('cpanel_customer_emails'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#log_tab" id="log" data-toggle="tab"
                                       aria-expanded="false"> LOG </a>
                                </li>
                                <li class="">
                                    <a href="#accounts_tab" id="accounts" data-toggle="tab"
                                       aria-expanded="false"> <?php echo $this->lang->line('cpanel_accounts'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tags_tab" id="tags" data-toggle="tab"
                                       aria-expanded="false">Tags</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tools">
                                </div>
                                <div class="tab-pane active " id="tab_1">
                                    <div class="col-sm-6">
                                        <form method="post">
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'groups'
                                                ); ?>
                                            </label>
                                            <select name="idgrupo" id="idgrupo" class="form-control">
                                                <?php foreach ($groups as $group) {?>
                                                    <option value="<?php echo $group->IdGrupo; ?>"><?php echo $group->Grupo; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_commercial_name'
                                                ); ?>
                                            </label>
                                            <!--                        cnomcom-->
                                            <input type="text" class="form-control" id="commercial_name" name="commercial_name"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_fiscal_name'
                                                ); ?>
                                            </label>
                                            <!--                        cnomcli-->
                                            <input type="text" class="form-control" id="fiscal_name" name="fiscal_name"/>
                                        </div>
                                        <hr />

                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_country'
                                                ); ?>
                                            </label>
                                            <!--cnaccli-->
                                            <input type="text" class="form-control" id="country" name="country"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_address'
                                                ); ?>
                                            </label>
                                            <!--                        cdomicilio-->
                                            <input type="text" class="form-control" id="address" name="address"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_city'
                                                ); ?>
                                            </label>
                                            <!--                        cpobcli-->
                                            <input type="text" class="form-control" id="city" name="city"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_province'
                                                ); ?>
                                            </label>
                                            <!--                        cprovincia-->
                                            <input type="text" class="form-control" id="province" name="province"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_zip_code'
                                                ); ?>
                                            </label>
                                            <!--                        cptlcli-->
                                            <input type="text" class="form-control" id="zip_code" name="zip_code"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_fiscal_code'
                                                ); ?>
                                            </label>
                                            <!--cdnicif -->
                                            <input type="text" class="form-control" id="fiscal_code" name="fiscal_code"/>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label class="text-left" >
                                                <?php echo $this->lang->line(
                                                    'cpanel_phone1'
                                                ); ?>
                                            </label>
                                            <!--                        ctfo1cli-->
                                            <input type="text" class="form-control" id="phone1" name="phone1"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_phone2'
                                                ); ?>
                                            </label>
                                            <!--                        ctfo2cli-->
                                            <input type="text" class="form-control" id="phone2" name="phone2"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_contact'
                                                ); ?>
                                            </label>
                                            <!--                        ccontacto-->
                                            <input type="text" class="form-control" id="contact" name="contact"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_email'
                                                ); ?>
                                            </label>
                                            <!--                        email-->
                                            <input type="text" class="form-control" id="email" name="email"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_web'
                                                ); ?>
                                            </label>
                                            <!--                        web-->
                                            <input type="text" class="form-control" id="web" name="web"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_active'
                                                ); ?>
                                            </label>
                                            <!--                        activo-->
                                            <select name="state" id="state" class="form-control">
                                                <option value="0"><?php echo $this->lang->line('no');?></option>
                                                <option value="1"><?php echo $this->lang->line('yes');?></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_ipserver'
                                                ); ?>
                                            </label>
                                            <!--ipservidor-->
                                            <input type="text" class="form-control" id="ipserver" name="ipserver"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_login'
                                                ); ?>
                                            </label>
                                            <!--login-->
                                            <input type="text" class="form-control" id="login" name="login"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_password'
                                                ); ?>
                                            </label>
                                            <!--pwd-->
                                            <input type="password" class="form-control" id="password" name="password"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">
                                                <?php echo $this->lang->line(
                                                    'cpanel_confirm_password'
                                                ); ?>
                                            </label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"/>
                                        </div>
                                            <a  href="<?php echo base_url('cpanel/manage_customers') ?>"  class="btn btn-default" >

                                                <?php echo $this->lang->line('back'); ?>
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <?php echo $this->lang->line('save'); ?>
                                            </button>

                                       </form>
                                    </div>

                                </div>
                                <div class="tab-pane" id="followUpTab">

                                </div>
                                <div class="tab-pane" id="tab_3">

                                </div>
                                <div class="tab-pane" id="tab_4">

                                </div>
                                <div class="tab-pane" id="log_tab">

                                </div>
                                <div class="tab-pane" id="accounts_tab">
                                    <div class="col-sm-6">
                                        <form method="post" name="account_form">
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_customer_name'
                                                        ); ?>
                                                    </label>
                                                    <select name="idcliente" id="idcliente" class="form-control">
                                                        <option value="">--<?php echo $this->lang->line('cpanel_select_customer'); ?>--</option>
                                                        <?php foreach ($not_exist_customers as $not_exist_customer) {?>
                                                            <option value="<?php echo $not_exist_customer->idcliente; ?>"><?php echo $not_exist_customer->customer_name; ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_start_date'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control datepicker" id="start_date" name="start_date"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_end_date'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control datepicker" id="end_date" name="end_date"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_DBHost_IPserver'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="DBHost_IPserver" name="DBHost_IPserver"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_DBHost_port'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="DBHost_port" name="DBHost_port"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_DBHost_user'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="DBHost_user" name="DBHost_user"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_DBHost_pwd'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="DBHost_pwd" name="DBHost_pwd"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_DBHost_db'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="DBHost_db" name="DBHost_db"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_key'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="key" name="key"/>
                                                </div>
                                                <div class="form-group">
                                                    <?php if(!empty($plans)){ ?>
                                                        <lable  class="pull-left">
                                                            <?php echo $this->lang->line(
                                                                'cpanel_plan'
                                                            ); ?>
                                                        </lable>
                                                        <select class="form-control text-left" name="plan" id="plan">
                                                            <?php

                                                            foreach($plans as $plan){
                                                                $selected = '';
                                                                if($plan->id == $current_plan){
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                ?>
                                                                <option value="<?php echo $plan->id;?>"  <?php echo $selected;?>><?php echo $plan->description;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php }?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'membership_interval'
                                                        ); ?>
                                                    </label>
                                                    <select class="form-control" name="membership_interval" id="membership_interval">
                                                        <option value="monthly" selected="selected"><?php echo $this->lang->line('monthly');?></option>
                                                        <option value="yearly"><?php echo $this->lang->line('yearly');?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_concurrent_users'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="concurrent_users" name="concurrent_users"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_trial_expire'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control datepicker" id="trial_expire" name="trial_expire"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_module_campus_teachers_active'
                                                        ); ?>
                                                    </label>
                                                    <select name="module_campus_teachers_active" id="module_campus_teachers_active" class="form-control">
                                                        <option value="0"><?php echo $this->lang->line('no');?></option>
                                                        <option value="1"><?php echo $this->lang->line('yes');?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_module_campus_teachers_max_users'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="module_campus_teachers_max_users" name="module_campus_teachers_max_users"/>
                                                </div>
                                                <!--                    <div class="form-group">-->
                                                <!--                        <label>-->
                                                <!--                            --><?php //echo $this->lang->line(
                                                //                                'cpanel_module_campus_teachers_expire'
                                                //                            ); ?>
                                                <!--                        </label>-->
                                                <!--                        <input type="text" class="form-control datepicker" id="module_campus_teachers_expire" name="module_campus_teachers_expire"/>-->
                                                <!--                    </div>-->
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_module_campus_students_active'
                                                        ); ?>
                                                    </label>
                                                    <select name="module_campus_students_active" id="module_campus_students_active" class="form-control text-left">
                                                        <option value="0"><?php echo $this->lang->line('no');?></option>
                                                        <option value="1"><?php echo $this->lang->line('yes');?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_module_campus_students_max_users'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="module_campus_students_max_users" name="module_campus_students_max_users"/>
                                                </div>
                                                <!--                    <div class="form-group">-->
                                                <!--                        <label>-->
                                                <!--                            --><?php //echo $this->lang->line(
                                                //                                'cpanel_module_campus_students_expire'
                                                //                            ); ?>
                                                <!--                        </label>-->
                                                <!--                        <input type="text" class="form-control datepicker" id="module_campus_students_expire" name="module_campus_students_expire"/>-->
                                                <!--                    </div>-->
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_module_campus_companies_active'
                                                        ); ?>
                                                    </label>
                                                    <select name="module_campus_companies_active" id="module_campus_companies_active" class="form-control">
                                                        <option value="0"><?php echo $this->lang->line('no');?></option>
                                                        <option value="1"><?php echo $this->lang->line('yes');?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_module_campus_companies_max_users'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="module_campus_companies_max_users" name="module_campus_companies_max_users"/>
                                                </div>
                                                <!--                    <div class="form-group">-->
                                                <!--                        <label>-->
                                                <!--                            --><?php //echo $this->lang->line(
                                                //                                'cpanel_module_campus_companies_expire'
                                                //                            ); ?>
                                                <!--                        </label>-->
                                                <!--                        <input type="text" class="form-control datepicker" id="module_campus_companies_expire" name="module_campus_companies_expire"/>-->
                                                <!--                    </div>-->
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_emails_limit_daily'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="emails_limit_daily" name="emails_limit_daily"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_emails_limit_monthly'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="emails_limit_monthly" name="emails_limit_monthly"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_space_limit'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="space_limit" name="space_limit"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_records_limit'
                                                        ); ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="records_limit" name="records_limit"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left">
                                                        <?php echo $this->lang->line(
                                                            'cpanel_active'
                                                        ); ?>
                                                    </label>
                                                    <select name="active" id="active" class="form-control">
                                                        <option value="0"><?php echo $this->lang->line('no');?></option>
                                                        <option value="1"><?php echo $this->lang->line('yes');?></option>
                                                    </select>
                                                </div>

<!--                                                <button type="button" class="btn btn-default"-->
<!--                                                        data-dismiss="modal">-->
<!--                                                    --><?php //echo $this->lang->line('close'); ?>
<!--                                                </button>-->
                                                <button type="submit" class="btn btn-primary ">
                                                    <?php echo $this->lang->line('save'); ?>
                                                </button>

                                    </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tags_tab" >
                                    <hr>
                                    <div class="margin-top-20">
                                        <button class="btn btn-success add_tag pull-left" ><?php echo $this->lang->line('add'); ?></button>
                                        <div class="col-sm-4 pull-left add_tag_part" style="display: none;">
                                            <input type="text" class="form-control" name="tag" />
                                            <button  class="btn btn-success pull-left margin-top-10 save_tag"><?php echo $this->lang->line('save'); ?></button>
                                            <button  class="btn btn-default margin-top-10 pull-left cancel_add_tag"><?php echo $this->lang->line('cancel'); ?></button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div id="tags_list"></div>

                                </div>

                            </div>

                        </div>
                    </div>


                    <div class="clearfix"></div>


                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
</div>
<div class="modal fade" id="delete_tags_modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>

            <div class="modal-body">
                <h4> <?php echo $this->lang->line('are_you_sure_delete'); ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <button type="button" class="btn btn-danger delete_tags"><?php echo $this->lang->line('delete'); ?></button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!--<script type="text/javascript" src="https://akaud.agilecrm.com/stats/min/agile-min.js"></script>-->
<!--<script>-->
<!--    _agile.set_account("hg3nhnpjhtgh232k2rfb1k14ac","akaud");-->
<!--</script>-->
<script>
    var _customer = <?php echo isset($customer) ? json_encode($customer) : json_encode(array()); ?>;
    var _id = <?php echo json_encode($id); ?>;
</script>

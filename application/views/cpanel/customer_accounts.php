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
                <div class="portlet light">

                        <div id="customers_table" class="">

                        </div>

                    <div class="clearfix"></div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
</div>

<div class="modal fade" id="deleteCustomerModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_customer" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_customer" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel">
    <div class="modal-dialog" role="modal_customer">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('close'); ?>"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="customerModalLabel"> <?php echo $this->lang->line('cpanel_add_customer'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>
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
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_start_date'
                            ); ?>
                        </label>
                        <input type="text" class="form-control datepicker" id="start_date" name="start_date"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_end_date'
                            ); ?>
                        </label>
                        <input type="text" class="form-control datepicker" id="end_date" name="end_date"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_DBHost_IPserver'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="DBHost_IPserver" name="DBHost_IPserver"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_DBHost_port'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="DBHost_port" name="DBHost_port"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_DBHost_user'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="DBHost_user" name="DBHost_user"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_DBHost_pwd'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="DBHost_pwd" name="DBHost_pwd"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_DBHost_db'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="DBHost_db" name="DBHost_db"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_key'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="key" name="key"/>
                    </div>
                    <div class="form-group">
                        <?php if(!empty($plans)){ ?>
                                <lable for="plan">
                                    <?php echo $this->lang->line(
                                        'cpanel_plan'
                                    ); ?>
                                </lable>
                                <select class="form-control" name="plan" id="plan">
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
                        <label>
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
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_concurrent_users'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="concurrent_users" name="concurrent_users"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_trial_expire'
                            ); ?>
                        </label>
                        <input type="text" class="form-control datepicker" id="trial_expire" name="trial_expire"/>
                    </div>
                    <div class="form-group">
                        <label>
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
                        <label>
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
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_module_campus_students_active'
                            ); ?>
                        </label>
                        <select name="module_campus_students_active" id="module_campus_students_active" class="form-control">
                            <option value="0"><?php echo $this->lang->line('no');?></option>
                            <option value="1"><?php echo $this->lang->line('yes');?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
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
                        <label>
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
                        <label>
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
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_emails_limit_daily'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="emails_limit_daily" name="emails_limit_daily"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_emails_limit_monthly'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="emails_limit_monthly" name="emails_limit_monthly"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_space_limit'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="space_limit" name="space_limit"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_records_limit'
                            ); ?>
                        </label>
                        <input type="text" class="form-control" id="records_limit" name="records_limit"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_active'
                            ); ?>
                        </label>
                        <select name="active" id="active" class="form-control">
                            <option value="0"><?php echo $this->lang->line('no');?></option>
                            <option value="1"><?php echo $this->lang->line('yes');?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                        <?php echo $this->lang->line('close'); ?>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var _customers = <?php echo isset($customers) ? json_encode($customers) : json_encode(array()); ?>;
</script>

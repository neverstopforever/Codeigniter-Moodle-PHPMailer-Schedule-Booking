
    <form class="form-horizontal col-md-6" name="company_form" method="post">
        <div class="col-md-12 text-left margin-top-10">
            <div class="form-group circle_select_div">
                <label classs="form-lable"><?php echo $this->lang->line('advanced_settings_academic_year'); ?>:</label>

                <select class="form-control" name="academic_year_select">
                     <?php foreach($academic_year as $year){
                         $selected = $year->id == $general_settings->academic_year ? 'selected' : '';
                         ?>
                         <option value="<?php echo $year->id; ?>" <?php echo $selected; ?> ><?php echo $year->title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="row">
                <div class="col-md-6">
                <div class="form-group circle_select_div">
                    <label><?php echo $this->lang->line('advanced_settings_first_hour'); ?>:</label>
                     <select class="form-control select_hours" name="first_hour_select" >
                        <?php foreach($times as $key=>$time) {
                            $time_loc  = substr($general_settings->first_hour, 0,2).':'.substr($general_settings->first_hour, 2,4);
                            $selected =  $time_loc == $time ? 'selected' : '';
                            ?>
                            <option value="<?php echo $key; ?>"  <?php echo $selected; ?> > <?php echo $time; ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
                <div class="col-md-6">
                <div class="form-group circle_select_div">
                <div class="pull-left last_time">
                    <label><?php echo $this->lang->line('advanced_settings_last_hour'); ?>:</label>
                </div>

                    <select class="form-control circle_select_div select_hours" name="last_hour_select">
                        <?php foreach($times as $key=>$time) {
                            $time_loc  = substr($general_settings->last_hour, 0,2).':'.substr($general_settings->last_hour, 2,4);
                            $selected =  $time_loc == $time ? 'selected' : '';
                            ?>
                            <option value="<?php echo $key; ?>"  <?php echo $selected; ?> > <?php echo $time; ?> </option>
                        <?php } ?>
                    </select>
                </div>
                </div>
              </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group ">
                <label><?php echo $this->lang->line('advanced_settings_limit_hours_by_course'); ?>:</label>
                <input type="text" name="limite_horas" class="form-control" value="<?php echo set_value('limite_horas', $general_settings->limite_horas); ?>">
            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group ">
                <label><?php echo $this->lang->line('advanced_settings_absences_limit'); ?>:</label>
                <input type="text" name="absences_limit" class="form-control" value="<?php echo set_value('absences_limit', (int)$general_settings->absences_limit); ?>">
            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group circle_select_div">
                <label><?php echo $this->lang->line('advanced_settings_time_fractions'); ?>:</label>
                 <select class="form-control" name="time_fractions_select">
                    <?php foreach($time_fractions as $fraction) {
                        $selected = $fraction->id == $general_settings->time_fractions ? 'selected' : '';
                    ?>
                        <option value="<?php echo $fraction->id; ?>" <?php echo $selected; ?> ><?php echo $fraction->title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group circle_select_div">
                <label><?php echo $this->lang->line('advanced_settings_payment_method'); ?>:</label>
                 <select class="form-control" name="payment_methods_select">
                    <?php foreach($payment_methods as $methods) {
                        $selected = $methods->id == $general_settings->payment_method ? 'selected' : '';
                        ?>
                        <option value="<?php echo $methods->id; ?>" <?php echo $selected; ?> ><?php echo $this->lang->line($methods->title); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group circle_select_div">
                <label><?php echo $this->lang->line('advanced_settings_allow_group_multicourse'); ?>:</label>
                <?php $checked = $general_settings->allow_group_multicourse ? 'checked' : ''; ?>
                <input type="checkbox" name="allow_group_multicourse" class="group_multicourses_checkbox" <?php echo $checked; ?> />
            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group circle_select_div">
                <label><?php echo $this->lang->line('advanced_settings_allow_group_change_startdate'); ?>:</label>
                <?php $checked = $general_settings->allow_group_change_startdate ? 'checked' : ''; ?>
                <input type="checkbox" name="allow_group_change_startdate" class="group_change_startdate" <?php echo $checked; ?> />

            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group circle_select_div">
                <label><?php echo $this->lang->line('advanced_settings_allow_conflicts_in_calendars'); ?>:</label>
                <?php $checked = $general_settings->allow_conflicts_calendars ? 'checked' : ''; ?>
                <input type="checkbox" name="allow_conflicts_calendars" class="allow_conflicts_calendars" <?php echo $checked; ?> />

            </div>
        </div>
        <div class="col-md-12 text-left">
            <div class="form-group circle_select_div">
                <label><?php echo $this->lang->line('advanced_settings_allow_notification_show'); ?>:</label>
                <?php $checked = $general_settings->allow_notification_show ? 'checked' : ''; ?>
                <input type="checkbox" name="allow_notification_show" class="allow_notification_show" <?php echo $checked; ?> />

            </div>
        </div>

        <?php if($membership_type != 'FREE') {?>
        <div class="col-md-12 text-left">
            <div class="form-group">
                <label><?php echo $this->lang->line('advanced_settings_send_mail'); ?>:</label>
                <?php $checked = $general_settings->mail_provider ? 'checked' : ''; ?>
                <input type="checkbox" name="mail_provider" class="mail_provider" <?php echo $checked; ?> />
                <?php $style = $general_settings->mail_provider == '0' ? ' style="display: none;" ' : ''; ?>
                <button <?php echo $style?> class="btn btn-sm btn-primary btn-circle smpt_options margin-left-10"><i class="fa fa-cog" aria-hidden="true"></i>
                    <?php echo $this->lang->line('advanced_settings_SMPT_options'); ?></button>
            </div>
        </div>
        <?php } ?>

        <div class=" text-left back_save_group">
            <a href="<?php echo base_url('advancedSettings'); ?>" class="btn-sm btn btn-circle btn-default-back back_system_settigs "><?php echo $this->lang->line('back'); ?></a>
            <button class="btn btn-sm btn-primary btn-circle save_general_data"><?php echo $this->lang->line('save'); ?></button>
            <a href="<?php echo base_url('advancedSettings'); ?>" class="btn-sm btn btn-circle btn-default-back back_system_settigs_min "><?php echo $this->lang->line('back'); ?></a>
        </div>

    </form>

    <div class="modal fade" id="EditSmtpOptions" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('advanced_settings_SMPT_options'); ?></h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group text-left">
                            <div class="col-md-3">
                                <label >
                                    <?php echo $this->lang->line('advanced_settings_hostname'); ?>:
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="smtp_hostname" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-3">
                                <label >
                                    <?php echo $this->lang->line('username'); ?>:
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="smtp_username" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-3">
                                <label >
                                    <?php echo $this->lang->line('password'); ?>:
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" name="smtp_password" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-3">
                                <label >
                                    <?php echo $this->lang->line('advanced_settings_port'); ?>:
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" name="smtp_port" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-3">
                                <label >
                                    <?php echo $this->lang->line('advanced_settings_security'); ?>:
                                </label>
                            </div>
                            <div class="col-md-9 circle_select_div">
                                <select class="form-control" name="smtp_security">
                                    <option value="0"><?php echo $this->lang->line('advanced_settings_plain'); ?></option>
                                    <option value="1"><?php echo $this->lang->line('advanced_settings_SSL_TLS'); ?></option>
                                    <option value="2"><?php echo $this->lang->line('advanced_settings_STARTTLS'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-3">
                                <label >
                                    <?php echo $this->lang->line('advanced_settings_send_test_email'); ?>:
                                </label>
                            </div>
                            <div class="col-md-7">
                                <input type="email" name="test_mail" class="form-control"/>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn blue send_test_email" ><?php echo $this->lang->line('send');?></button>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel " data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                    <button type="button" class="btn blue save_smtp_options" ><?php echo $this->lang->line('save');?></button>
                </div>
                </form>
            </div>
        </div>
                                        
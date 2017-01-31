<div class="page-container plan_option_page">
        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class=" page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('cpanel_plan_options_menu'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                    <div class="row">
                        <?php if(!empty($plans)){ ?>
                        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 plans_select circle_select_div">
                            <label for="plan"><?php echo $this->lang->line('cpanel_plans'); ?></label>
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
                            <div class="margin-top-30 text-center">
                                <div class="md-checkbox">
                                    <input type="checkbox" name="select_all" id="select_all" value="1"/>
                                    <label for="select_all">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> <lable for="select_all"><?php echo $this->lang->line('all');?></lable>
                                    </label>
                                </div>
                                <button class="btn btn-success set_default_options margin-left-20"><?php echo $this->lang->line('cpanel_set_default'); ?></button>


                            </div>
                        </div>
                        <div class="col-xs-10 col-xs-offset-1">
                           <div id="plan_perrmissions"></div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>


</div>

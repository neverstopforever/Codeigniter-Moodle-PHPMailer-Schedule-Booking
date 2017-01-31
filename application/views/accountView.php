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
                            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_subscription_plan'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light">
                        <div class="pricing-content-1">
                            <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->

                            <div class="row">
                                <div class="col-xs-12 margin-bottom-40">
                                    <div class="portlet ">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject bold uppercase"><?php echo $this->lang->line('available_resources'); ?></span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="easy-pie-chart">
                                                        <a class="title" href="javascript:;">
                                                            <?php echo $this->lang->line('users'); ?>
                                                        </a>
                                                        <div class="number transactions" data-percent="<?php echo round($users_procent); ?>">
                                                            <span><?php echo round($users_procent); ?></span>%

                                                        </div>
                                                        <p class="in_number"><?php echo $users; ?> <?php echo $this->lang->line('users'); ?></p>
                                                        <p>Max <?php echo $this->lang->line('users'); ?> <?php echo '  '.$max_users; ?></p>
                                                    </div>
                                                </div>
                                                <div class="margin-bottom-10 visible-sm"> </div>
                                                <div class="col-md-4">
                                                    <div class="easy-pie-chart">
                                                        <a class="title" href="javascript:;">
                                                            <?php echo $this->lang->line('records'); ?>
                                                        </a>
                                                        <div class="number visits" data-percent="<?php echo round($records_procent); ?>">
                                                            <span><?php echo round($records_procent); ?></span>%
                                                        </div>
                                                        <p class="in_number"><?php echo $used_records.' '; ?> <?php echo $this->lang->line('records'); ?></p>
                                                        <p>Max <?php echo $records_limit.' '; ?> <?php echo $this->lang->line('records'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="margin-bottom-10 visible-sm"> </div>
                                                <div class="col-md-4">
                                                    <div class="easy-pie-chart">
                                                        <a class="title" href="javascript:;">
                                                           <?php echo $this->lang->line('file_storage'); ?>
                                                        </a>
                                                        <div class="number bounce" data-percent="<?php echo round($file_space_procent); ?>">
                                                            <span><?php echo round($file_space_procent); ?></span>%
                                                        </div>
                                                        <p class="in_number"><?php echo $total_file_space; ?></p>
                                                        <p>Max <?php echo $max_file_space; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row margin-bottom-40">
                                <!-- Pricing -->
                            <?php if(!empty($plan_data)) { ?>
                                <?php foreach($plan_data as $plan) { ?>
                                    <?php if($plan->id !=5){ ?>
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <div class="price-column-container border-active hover-effect <?php echo $user_plan == $plan->id ? 'pricing_active' : ''; ?>">
                                            <div class="price-table-head bg-blue">
                                                <h2 class="no-margin">  <?php echo $this->lang->line($plan->lang_line_h3_title); ?> </h2>

        <!--                                        --><?php //echo $this->lang->line($plan->tag_line); ?><!-- </span>-->
                                            </div>
                                            <div class="arrow-down border-top-blue"></div>
                                            <div class="price-table-pricing">
                                                <h3>
                                                    <span class="price-sign"><?php echo $this->lang->line($plan->h3_price_sign); ?></span> <?php echo $this->lang->line($plan->h3_price_money); ?>
                                                </h3>
                                                <p class="margin-bottom-0"><?php echo $this->lang->line($plan->h3_price_per_month); ?></p>
                                                <p class="margin-top-0"><?php echo $this->lang->line($plan->h4_price_per_month); ?></p>
                                                <?php if($user_plan == $plan->id ){ ?>
                                                    <div class="price-ribbon"><?php echo $this->lang->line('account_your_plan'); ?></div>
                                                <?php } ?>

                                            </div>
                                            <div class="price-table-content">
                                                    <?php if(!empty($plan->options)) { ?>
                                                        <?php foreach($plan->options as $option ) {  ?>
                                                        <div class="row mobile-padding">
                                                            <?php if($option->id == 0) {?>
                                                                <p><?php echo $this->lang->line($option->lang_line_title); ?></p>
                                                            <?php } else { ?>
                                                            <div class="col-xs-10 col-xs-offset-2 text-left mobile-padding">
                                                                <?php echo $this->lang->line($option->lang_line_title); ?>
                                                            </div>
                                                            <?php  }?>
                                                        </div>
                                                        <?php  } ?>
                                                    <?php  } ?>
                                            </div>
                                            <div class="arrow-down arrow-grey"></div>
                                            <div class="price-table-footer">
                                                <?php if($user_plan == $plan->id ){ ?>
<!--                                                    <p class="current_plan">--><?php //echo $this->lang->line('account_your_current_plan'); ?><!--</p>-->
                                                    <p><button type="button" disabled  class="btn btn-sm btn-outline default uppercase price-button hire_plan" data-plan_id="<?php echo $plan->id; ?>" ><?php echo $this->lang->line('account_priceSubmitApgdadeButton'); ?></button></p>
                                                <?php }elseif($plan->id == 1){?>
                                                    <p><button type="button" class="btn btn-sm btn-outline green uppercase price-button hire_plan" data-plan_id="<?php echo $plan->id; ?>" ><?php echo $this->lang->line('account_try_it'); ?></button></p>
                                                <?php } else{ ?>
                                                    <p><button type="button" class="btn btn-sm btn-outline green uppercase price-button hire_plan" data-plan_id="<?php echo $plan->id; ?>" ><?php echo $this->lang->line('account_priceSubmitApgdadeButton'); ?></button></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                                <!--//End Pricing -->
                            </div>
                            <!-- END INLINE NOTIFICATIONS PORTLET-->
                        </div>
                    </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
        </div>
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- END QUICK SIDEBAR -->

        <!-- END PAGE CONTENT -->

        <!-- END PAGE CONTAINER -->


        <?php
        if ($this->session->has_userdata('plan_option_errors')) { ?>
            <div class="modal fade" id="planOptionModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close plan_option_close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"><?php echo $this->lang->line('plan_option_title'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                <?php
                                $plan_option_errors = $this->session->userdata('plan_option_errors');
                                foreach ($plan_option_errors as $plan_option_error) {
                                    echo "<p>" . $plan_option_error . "</p>";
                                }
                                ?>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn default plan_option_close" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                            <button  class="btn blue plan_option_success"><?php echo $this->lang->line('okay'); ?></button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <?php
            $this->session->unset_userdata('plan_option_errors');
        } ?>
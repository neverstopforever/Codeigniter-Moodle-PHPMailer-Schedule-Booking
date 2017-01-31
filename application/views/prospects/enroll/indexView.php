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
                    <a href="javascript:;"><?php echo $this->lang->line('menu_crm'); ?></a>
                </li>
                <li class="">
                    <a href="<?php echo base_url('prospects'); ?>"><?php echo $this->lang->line('menu_prospects'); ?></a>
                </li>
                <li class="active">
                    <a href="javascript:;"><?php echo $this->lang->line('enroll'); ?></a>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light text-left  bordered">
                 <div class="mt-element-step text-left">
                    <div class="row step-line">

                        <div class="col-md-3 mt-step-col step_1_line first active">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('prospect')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                        <div class="col-md-3 mt-step-col step_2_line ">
                                  <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('group')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                        <div class="col-md-3 mt-step-col step_3_line">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('rate')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                        <div class="col-md-3 mt-step-col step_4_line last">
                            <div class="mt-step-number bg-white">4</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><?php echo strtoupper($this->lang->line('prospects_confirm')); ?></div>
                            <div class="mt-step-content font-grey-cascade"></div>
                        </div>
                    </div>
                 </div>

                 <div class="step_1">
                     <div class="margin-top-20 step_header">
                         <h2 class="text-center step_title"><?php echo $this->lang->line('prospects_data_of_prospect');?></h2>
                     </div>
                     <div class="row margin-top-20 step_content base_info_step">
                         <div class="col-xs-11 col-sm-8 col-sm-offset-2 ">
                            <div class="form-group text-left circle_select_div ">
<!--                                <h3>--><?php //echo $this->lang->line('prospects_data_of_prospect'); ?><!--:</h3>-->
                                <p><?php echo $this->lang->line('prospects_num_prospect'); ?>: <span class="margin-left-10"><strong><?php echo $prospect_data->prospect_id; ?></strong></span></p>
                                <p><?php echo $this->lang->line('name'); ?>: <span class="margin-left-10"><strong><?php echo $prospect_data->contact_name; ?></strong></span></p>
                                <p><?php echo $this->lang->line('course'); ?>: <span class="margin-left-10"><strong><?php echo $offered_courses_list; ?></strong></span></p>

                          </div>
                         </div>
                         <div class="col-xs-12 col-sm-8 col-sm-offset-2 ">
                             <div class="text-left back_save_group">
                                 <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                                 <button type="button" class="btn btn-primary btn-circle pull-right text-center step1_to_step2" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                 <div class="overf_hidden">
                                 </div>
                                     <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>

                             </div>
                             <div class="clearfix"></div>

                         </div>
                     </div>
              </div>


                 <div class="step_2" style="display: none">
                     <div class="margin-top-20 step_header">
<!--                         <h2 class="text-center step_title">--><?php //echo $this->lang->line('enrollments_refine');?><!--</h2>-->
                     </div>
                     <div class="row margin-top-20 step_content base_info_step">
                         <div class="col-xs-12 col-sm-6 col-sm-offset-3 ">

                             <div class="form-group text-left circle_select_div enrollments_select_group ">
                                 <!--                                 <lable>--><?php //echo $this->lang->line('group'); ?><!--:</lable>-->
                                 <select class="form-control margin-top-20" name="select_group">
                                     <option value=""><?php echo $this->lang->line('prospects_select_group'); ?></option>
                                     <?php if(!empty($groups)){ ?>
                                         <?php foreach($groups as $group) { ?>
                                             <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                         <?php } ?>
                                     <?php } ?>
                                 </select>
                                 <a href="#" class="filter_groups_icon" > <i class="fa fa-filter" aria-hidden="true"></i> </a>
                             </div>

                             <div class="form-group text-left">
                                <div class="clearfix"></div>
                                
                                <div class="clearfix"></div>
                                 <form class="form-horizontal margin-top-50">
                                <div class="form-group row ">
                                    <div class="col-sm-6" style="display: none">
                                        <lable><?php echo $this->lang->line('start_date'); ?>
                                        </lable>
                                        <input class="form-control" type="text" id="step2_start_date" name="start_date" />

                                    </div>
                                    <div class="col-sm-6" style="display: none">
                                        <lable><?php echo $this->lang->line('end_date'); ?>
                                        </lable>
                                         <input class="form-control" id="step2_end_date" type="text" name="end_date" />

                                    </div>
                                </div>
                                 </form>
                            </div>
<!--                             <div class="row margin-top-20 margin-right-10">-->
<!--                                 <button class="btn btn-default pull-left btn-circle step2_to_step1">--><?php //echo $this->lang->line('back'); ?><!--</button>-->
<!--                                 <button class="btn pull-right btn-success btn-circle step2_to_step3">--><?php //echo $this->lang->line('next'); ?><!--</button>-->
<!--                             </div>-->
                             <div class="text-left back_save_group">
                                 <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                                 <button type="button" class="btn btn-circle btn-default-back step2_to_step1 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                 <button type="button" class="btn btn-primary btn-circle pull-right text-center step2_to_step3" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                 <button type="button" class="btn btn-circle btn-default-back step2_to_step1 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                 <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                             </div>
                         </div>
                     </div>
                </div>
                <div class="step_3" style="display: none">
                    <div class="margin-top-20 step_header">
                        <h2 class="text-center step_title"><?php echo $this->lang->line('prospects_payment');?></h2>
                    </div>

                    <div class="row margin-top-20 ">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3 ">


                        <div class="form-group  text-left predefined_rate_part">
                            <div class=" text-left no-padding predefined_rate_select circle_select_div" >
                                <lable><?php echo $this->lang->line('prospects_predefined_rate'); ?>
                                <select class="form-control" name="select_rate">
                                </select>
                                </lable>
                            </div>
                        </div>
                            <div class="text-left  back_save_group">
                                <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                                <button type="button" class="btn btn-circle btn-default-back step3_to_step2 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                <button type="button" class="btn btn-primary btn-circle pull-right text-center step3_to_step4" data-next_step="2"><?php echo $this->lang->line('continue'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-circle btn-default-back step3_to_step2 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                                <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-20 ">
                        <div class="col-xs-12">
                            <div id="feesTable"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                </div>
                <div class="step_4" style="display: none">
                    <div class="margin-top-20 step_header">
                        <h2 class="text-center step_title"><?php echo $this->lang->line('prospects_confirm_action');?></h2>
                        <p class="text-center"><?php echo $this->lang->line('prospects_please_confirm_action'); ?></p>
                    </div>

                    <div class="row ">
                        <div class="text-center col-xs-12 back_save_group">
                            <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle btn-default-back back_system_settigs exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                            <button type="button" class="btn btn-circle btn-default-back step4_to_step3 back_system_settigs" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                            <button class="btn btn-primary btn-circle  confirm_action_btn"><?php echo $this->lang->line('prospects_confirm'); ?></button>

                            <button type="button" class="btn btn-circle btn-default-back step4_to_step3 back_system_settigs_min" ><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
                            <a type="button" href="<?php echo $_base_url; ?>prospects" class="btn btn-circle text-center btn-default-back back_system_settigs_min exit_steps"><?php echo $this->lang->line('exit'); ?></a>
                        </div>
                    </div>
                </div>

            </div>

              <div class="clearfix"></div>

                <div class="modal fade" id="FilterGroupsModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div id="FilterGroupsTable">

                                </div>
                            </div>
                            <div class="modal-footer">
<!--                                <button  class="btn blue select_groups_btn">--><?php //echo $this->lang->line('select'); ?><!--</button>-->
                                <button type="button" class="btn default btn-default-back" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="dataConfirmLabel"><?php echo $this->lang->line('please_confirm'); ?></h4>
                            </div>
                            <div class="modal-body">
                                 <p><?php echo $this->lang->line('are_you_sure_delete'); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                <button id="deleteConfirmOK"  class="btn red"><?php echo $this->lang->line('delete'); ?></button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script>
var _courses = <?php echo json_encode($offered_courses); ?>;
var _groups = <?php echo json_encode($groups); ?>;
var _prospect_id = <?php echo json_encode($prospect_id); ?>;


</script>
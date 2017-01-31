        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->

                <div class="table_loading"></div>
                <div class="page-content students">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class=" page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo $this->lang->line('menu_academics') ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('students'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->

<!--                            <div class="nodata" style="display:none; text-align:center;">-->
<!--                                <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px; min-height:80px;" href="--><?php //echo base_url() ?><!--"><i class="fa fa-plus"></i>--><?php //echo $this->lang->line('students_add_student'); ?><!--</a>-->
<!--                            </div>-->

                                    <div class="tabs_container" style="">
                                        <div class="card">
                                            <div class="tab temp" style="display:none;">
                                                <li role="presentation" class="tab_link" style="display:none;"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text"> </span> <i class="fa fa-trash link_trash"></i></a></li>
                                            </div>
                                            <ul class="nav nav-tabs" role="tablist">
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="content temp" style="display:none;">
                                                <div role="tabpanel" class="tab-pane" id="table1"></div>
                                            </div>
                                            <div class="top-bar statistic_counts">
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class=" active_students box_statistic text-center">
                                                            <i class="icon_active_students hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="icon_active_students visible-md-inline "></i>
                                                                <span><?php echo ((int)($top_bar_data[0]->active_students/1000)) > 0  ? ((int)($top_bar_data[0]->active_students/1000)).' K' :  $top_bar_data[0]->active_students; ?></span>
                                                                <p><?php echo $this->lang->line('students_acive_students'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class="ex_students box_statistic text-center">
                                                            <i class="icon_ex_students hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="icon_ex_students visible-md-inline"></i>
                                                                <span><?php echo ((int)($top_bar_data[0]->ex_students/1000)) > 0  ? ((int)($top_bar_data[0]->ex_students/1000)).' K' :  $top_bar_data[0]->ex_students; ?></span>
                                                                <p><?php echo $this->lang->line('students_ex_students'); ?></p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class="icon_prospect_last_month box_statistic text-center">
                                                            <i class="icon_prospect_last_month hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="icon_prospect_last_month visible-md-inline "></i>
                                                                <span><?php echo $top_bar_data[0]->last_month; ?></span>
                                                                <p><?php echo $this->lang->line('students_last_month'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class="total_students box_statistic text-center">
                                                            <i class="icon_total_students hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="icon_total_students visible-md-inline "></i>
                                                                <span>
                                                                    <?php
                                                                    $total_students_str = thousandsCurrencyFormat($top_bar_data[0]->total_students);
                                                                    echo $total_students_str;
                                                                    ?>
                                                                </span>
                                                                <p><?php echo $this->lang->line('students_total_students'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 visible-xs visible-sm margin-bottom-20">
                                                    <div class="filter_tags_iner dbtable_status_buttons ">
                                                        <div class="filter_tags">
                                                            <div class="state_filter_tags parent_tag" data-window="small" >
                                                                <h2><?php echo $this->lang->line('filter_by'); ?></h2>
                                                                <div class="form-group">
                                                                    <label class="control-label select_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                                                    <input id="state_select1" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_tag_label text-left"><?php echo $this->lang->line('students_tags');?>:</label>
                                                                    <input id="tag_select1" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">

                                                    <div class="tab-content">

                                                        <div class="text-right margin-bottom-10">
                                                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                                        </div>
                                                        <div class="quick_tips_sidebar margin-top-10">
                                                            <div class=" note note-info quick_tips_content">
                                                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                                                <p><?php echo $this->lang->line('students_quick_tips_text'); ?>
                                                                    <strong><a href="<?php echo $this->lang->line('students_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('students_quick_tips_link_text');  ?></a></strong>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div id="studentsTable">

                                                        </div>
                                                        <div id="students_table_empty" class="no_data_table">

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-3 hidden-xs hidden-sm">
                                                    <div class="filter_tags_iner dbtable_status_buttons ">
                                                        <div class="filter_tags">
                                                            <div class="state_filter_tags parent_tag" data-window="big" >
                                                                <h2><?php echo $this->lang->line('filter_by'); ?></h2>
                                                                <div class="form-group">
                                                                    <label class="control-label select_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                                                    <input id="state_select" type="hidden" class="tags" style="width: 100%" />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label select_tag_label text-left"><?php echo $this->lang->line('students_tags');?>:</label>
                                                                    <input id="tag_select" type="hidden" class="tags" style="width: 100%" />
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
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>

            <div class="state_filter_tags  " style="display: none">
                <div>
                    <p data-id="isactive"><button class="btn btn-sm btn-outline green tag_filter" ><?php echo $this->lang->line('_active'); ?></button></p>
                    <p data-id="locked"><button class="btn  btn-sm  btn-outline red tag_filter" ><?php echo $this->lang->line('not_active'); ?></button></p>
                </div>

            </div>

            <div id="DeleteStudentModal" class="modal fade" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
                        </div>
                        <form id="" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <p><?php echo $this->lang->line("students_confirm_delete"); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
                                <button type="submit" data-task="delete_student" class="btn btn-danger"><?php echo $this->lang->line("done"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<script>
    var tags_group_by_tag_id = <?php echo json_encode($tags_group_by_tag_id); ?>;
    var tags_for_filter = <?php echo json_encode($tags_for_filter); ?>;
</script>
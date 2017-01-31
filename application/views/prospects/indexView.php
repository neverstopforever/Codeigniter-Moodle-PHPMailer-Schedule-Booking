        <div class="page-container prostpects_page">
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
                            <li class="active">
                                <?php echo $this->lang->line('menu_prospects'); ?>
                            </li>
                        </ul>
                        <div>
                            <div class="nodata" style="display:none; text-align:center;">
                                <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px; min-height:80px;" href="<?php echo base_url() ?>/leads/add"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
                            </div>
                            <div class=" index_table">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                    </div>
                                </div>
                                <div>
                                    <div class="tabs_container">
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
                                                        <div class="last_month_prospect box_statistic text-center">
                                                            <i class="fa fa-user-plus fa-3x hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="fa fa-user fa-3x visible-md-inline "></i>
                                                                <span><?php echo $top_bar_data[0]->prospects_last_month; ?></span>
                                                                <p><?php echo $this->lang->line('prospects_last_month'); ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class="total_prospect box_statistic text-center">
                                                            <i class="fa fa-users fa-3x hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="fa fa-users fa-3x visible-md-inline "></i>
                                                                <span><?php echo $top_bar_data[0]->total_prospects; ?></span>
                                                                <p><?php echo $this->lang->line('prospects_total'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class="conversion_rate box_statistic text-center">
                                                            <i class="fa fa-bar-chart fa-3x hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="fa fa-bar-chartfa-3x visible-md-inline "></i>
                                                                <span><?php echo $top_bar_data[0]->conversion_rate.' %'; ?></span>
                                                                <p><?php echo $this->lang->line('prospects_conversion_rate'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                                        <div class="total_contacts box_statistic text-center">
                                                            <i class="fa fa-book fa-3x hidden-md"></i>
                                                            <div class="text-left">
                                                                <i class="fa fa-book fa-3x visible-md-inline "></i>
                                                                <span><?php echo $top_bar_data[0]->contacts; ?></span>
                                                                <p><?php echo $this->lang->line('prospects_total_contacts'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>

                                            <div class="row tab-content_prospect">



                                                <div class="col-md-3 visible-sm visible-xs margin-bottom-20">
                                                    <div class="prospect_filter_section1">
                                                        <div class="filter_tags1">
                                                            <div class="state_filter_tags parent_tag" data-window="small" style="">
                                                                <?php /*if(!empty($state)) { */?><!--
                                                            <?php /*foreach($state as $value) { */?>
                                                                    <p data-id="<?php /*echo $value->id; */?>"><button class="btn tag_filter" style="<?php /*echo 'background-color: #'.$value->color; */?>"><?php /*echo $value->valor; */?></button></p>
                                                            <?php /*} */?>
                                                        --><?php /*} */?>
                                                                <h2><?php echo $this->lang->line('prospects_filter_by'); ?></h2>
                                                                <div class="form-group">
                                                                    <label class="control-label select_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                                                    <input id="state_select1" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_name_label text-left"><?php echo $this->lang->line('name');?>:</label>
                                                                    <input id="name_select1" class="tags" type="hidden" style="width: 100%" />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label select_source_label text-left"><?php echo $this->lang->line('prospects_source');?>:</label>
                                                                    <input id="source_select1" class="tags" type="hidden" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_campaign_label text-left"><?php echo $this->lang->line('campaign');?>:</label>
                                                                    <input id="campaign_select1" class="tags" type="hidden" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_stars_label text-left"><?php echo $this->lang->line('prospects_with_star');?>:</label>
                                                                    <input id="stars_select1" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_score_label text-left"><?php echo $this->lang->line('prospects_with_score');?>:</label>
                                                                    <input id="score_select1" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_tag_label text-left"><?php echo $this->lang->line('prospects_tags');?>:</label>
                                                                    <input id="tag_select1" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="col-md-9">
                                                <div class="prospectsTable">
                                                        <div class="text-right">
                                                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                                        </div>
                                                        <div class="quick_tips_sidebar margin-top-20">
                                                            <div class=" note note-info quick_tips_content">
                                                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                                                <p><?php echo $this->lang->line('prospect_quick_tips_text'); ?> 
                                                                    <strong><a href="<?php echo $this->lang->line('prospect_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('prospect_quick_tips_link_text'); ?></a></strong>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <p class="select_all_rows_p" style="display: none">
                                                            <?php echo $this->lang->line('select_all_message_text1'); ?>
                                                            <span class="count_this_page"></span> <span class="str_lower_tb_name"><?php echo strtolower($this->lang->line('Prospects')); ?></span>
                                                            <?php echo ' '.$this->lang->line('select_all_message_text2'); ?>
                                                            <a href="#" class="select_all_table_rows"><?php echo $this->lang->line('select_all_message_text3').' <span class="count_all_pages"></span> <span class="str_lower_tb_name">'.strtolower($this->lang->line('Prospects')).'</span> '. ($lang == 'spanish' ? '' : $this->lang->line('in').' <span class="tb_name">'.$this->lang->line('Prospects').'</span>'); ?> ?</a>
                                                        </p>
                                                        <p class="unselect_all_rows_p" style="display: none">
                                                            <?php echo $this->lang->line('unselect_all_message_text1'); ?>
                                                            <span class="count_this_page"></span> <span class="str_lower_tb_name"><?php echo strtolower($this->lang->line('Prospects')); ?></span>
                                                            <?php echo ' '.$this->lang->line('select_all_message_text2'); ?>
                                                            <a href="#" class="unselect_all_table_rows"><?php echo $this->lang->line('unselect_all_message_text3').' <span class="count_all_pages"></span> <span class="str_lower_tb_name">'.strtolower($this->lang->line('Prospects')).'</span>'; ?>?</a>
                                                        </p>
                                                        <div id="prospectsTable_no" class="no_data_table">

                                                        </div>
                                                        <div id="prospectsTable" >

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-3 hidden-sm hidden-xs">
                                                    <div class="prospect_filter_section">
                                                        <div class="filter_tags">
                                                            <div class="state_filter_tags parent_tag" data-window="big" >
                                                                <?php /*if(!empty($state)) { */?><!--
                                                            <?php /*foreach($state as $value) { */?>
                                                                    <p data-id="<?php /*echo $value->id; */?>"><button class="btn tag_filter" style="<?php /*echo 'background-color: #'.$value->color; */?>"><?php /*echo $value->valor; */?></button></p>
                                                            <?php /*} */?>
                                                        --><?php /*} */?>

                                                                <h2><?php echo $this->lang->line('prospects_filter_by'); ?></h2>
                                                                <div class="form-group">
                                                                    <label class="control-label select_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                                                    <input id="state_select" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_name_label text-left"><?php echo $this->lang->line('name');?>:</label>
                                                                    <input id="name_select" class="tags" type="hidden" style="width: 100%" />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label select_source_label text-left"><?php echo $this->lang->line('prospects_source');?>:</label>
                                                                    <input id="source_select" class="tags" type="hidden" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_campaign_label text-left"><?php echo $this->lang->line('campaign');?>:</label>
                                                                    <input id="campaign_select" class="tags" type="hidden" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_stars_label text-left"><?php echo $this->lang->line('prospects_with_star');?>:</label>
                                                                    <input id="stars_select" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_score_label text-left"><?php echo $this->lang->line('prospects_with_score');?>:</label>
                                                                    <input id="score_select" type="hidden" class="tags" style="width: 100%" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label select_tag_label text-left"><?php echo $this->lang->line('prospects_tags');?>:</label>
                                                                    <input id="tag_select" type="hidden" class="tags" style="width: 100%" />
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
                    <!-- END PAGE CONTENT INNER -->
                </div>

            <div class="bulk_actions" style="display:none;">
                <div class="btn-group pull-right">
                <div  id="myDropdown" class="dropdown text-right prospect_actions" style="">
                    <button  class="btn btn-primary btn-circle dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line("prospects_action") ?> <span class="margin-left-3px caret"></span></button>
                    <ul class="dropdown-menu mobile_dropdown  dropdown-menu-right">
                        <li class="dropdown-submenu">
                            <a class="javascript:;"><?php echo $this->lang->line("leido"); ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <li><a href="#" class="action" data-task="leido" data-id="0"><?php echo $this->lang->line("leido_read"); ?></a></li>
                                <li><a href="#" class="action" data-task="leido" data-id="1"><?php echo $this->lang->line("leido_unread"); ?></a></li>
                            </ul>
                        </li>
                        <li class=" dropdown-submenu">
                            <a class="javascript:;"><?php echo $this->lang->line('priority'); ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <li><a href="#" class="action" data-task="prioridad" data-id="0"><?php echo $this->lang->line("priority_normal"); ?></a></li>
                                <li><a href="#" class="action" data-task="prioridad" data-id="1"><?php echo $this->lang->line("priority_high"); ?></a></li>
                                <li><a href="#" class="action" data-task="prioridad" data-id="2"><?php echo $this->lang->line("priority_veryhigh"); ?></a></li>
                            </ul>
                        </li>
                        <li class=" dropdown-submenu">
                            <a href="javascript:;"><?php echo $this->lang->line("state"); ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <?php
                                foreach ($state as $value) {
                                    ?>
                                    <li>
                                        <a href="#" data-id="<?php echo $value->id; ?>" data-task="estado" class="action" style="color:#<?php echo $value->color; ?>">
                                            <?php echo $value->valor; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="#" class="modify_score"><?php echo $this->lang->line("prospects_modify_score"); ?></a></li>
                        <li><a href="#" class="send_email_prospects"><?php echo $this->lang->line("prospects_send_email"); ?></a></li>
                        <li><a href="#" class="assign_user_modal"><?php echo $this->lang->line("prospects_assign_user"); ?></a></li>
                        <li><a href="#"  class="delete_prospect"><?php echo $this->lang->line("prospects_delete_prospect"); ?></a></li>
                    </ul>
                </div>
                    </div>
            </div>
            <div class="bulk_actions2" style="display:none;">
                <div class="btn-group rules_btn_group">
                        <a href="javascript:;" class="btn btn-primary btn-circle rules_btn">
                            <?php echo $this->lang->line("rules") ?> <span class="margin-left-3px"></span>
                        </a>
                </div>
            </div>



        <div class="modal fade" id="deleteLead" tabindex="-1" role="deleteLead" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('delete_lead'); ?></h4>
                    </div>
                    <div class="modal-body"><?php echo $this->lang->line('are_you_sure'); ?></div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                        <a type="button" href="#" class="btn green" id="delete_lead_modal"><?php echo $this->lang->line('delete_lead'); ?></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

            <div id="assignUserModal" class="modal fade" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> <?php echo $this->lang->line("prospects_assign_user"); ?> </h4>
                        </div>
                        <form id="AssignUser" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">

                                <lable><?php echo $this->lang->line("prospects_assign_user"); ?>: </lable>
                                <select name="assig_user" >
                                    <option value="0">--<?php echo $this->lang->line("prospects_select_user"); ?>--</option>
                                    <?php if(!empty($users)) { ?>
                                        <?php foreach($users as $user){ ?>
                                        <option value="<?php echo $user->id ?>"><?php echo $user->user_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="modal-footer">
                                <div class="count_prospects pull-left">
                                </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
                                <button type="submit" data-task="assign_user" class="btn btn-primary"><?php echo $this->lang->line("done"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="ModifyScoreModal" class="modal fade" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> <?php echo $this->lang->line("prospects_modify_score"); ?> </h4>
                        </div>
                        <form id="ModifyScore" method="POST" enctype="multipart/form-data">
                            <div class="row modal-body">
                                <div class="col-xs-6 text-right">
                                    <lable><?php echo $this->lang->line("prospects_new_score"); ?> </lable>
                                </div>
                                <div class="col-xs-6">
                                    <input class="form-control"  type="number" name="score" min="0" max="100"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="count_prospects pull-left">
                                </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                                <button type="submit" data-task="modify_score" class="btn btn-primary"><?php echo $this->lang->line("done"); ?> </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="DeleteProspectModal" class="modal fade" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> <?php echo $this->lang->line("prospects_delete_prospect"); ?></h4>
                        </div>
                        <form id="" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <h2><?php echo $this->lang->line("prospects_confirm_delete"); ?></h2>
                            </div>
                            <div class="modal-footer">
                                <div class="count_prospects pull-left">
                                </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
                                <button type="submit" data-task="delete_prospect" class="btn btn-danger"><?php echo $this->lang->line("done"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="FollowUpModal" class="modal fade" role="dialog">
            <div  class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('clientes_addSeguimiento'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>
                                <?php echo $this->lang->line('clientes_followup_titulo'); ?>
                            </label>
                            <input type="text" class="form-control" required name="title" />
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $this->lang->line('clientes_followup_fecha'); ?>
                            </label>
                            <input type="text" class="form-control datepicker" required name="date" />
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $this->lang->line('clientes_followup_usuario'); ?>
                            </label>
                            <div style="text-transform:uppercase">
                                <?php echo $this->data['userData'][0]->USUARIO;  ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $this->lang->line('clientes_followup_comentario'); ?>
                            </label>
                            <textarea class="form-control" required name="comment"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang->line('button_modalClose'); ?>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <?php echo $this->lang->line('save'); ?>
                        </button>
                    </div>
                </div>
            </div>
                </div>

            <div class="state_tmp" style="display: none">
              <?php foreach ($state as $value) {  ?>
                  <button class="btn btn-sm" data-id="<?php echo $value->id; ?>" style="background-color:#<?php echo $value->color; ?>"><?php echo $value->valor; ?></button>
                <?php } ?>
            </div>

<script>
//    var _prospects_data = <?php //echo json_encode($prospects_data); ?>//;
    var names_data = <?php echo json_encode($names); ?>;
    var state_data = <?php echo json_encode($state_data); ?>;
    var source = <?php echo json_encode($source); ?>;
    var campaign = <?php echo json_encode($campaign); ?>;
    var stars_data = <?php echo json_encode($stars_data); ?>;
    var score_data = <?php echo json_encode($score); ?>;
    var tags_group_by_tag_id = <?php echo json_encode($tags_group_by_tag_id); ?>;
    var tags_for_filter = <?php echo json_encode($tags_for_filter); ?>;

</script>
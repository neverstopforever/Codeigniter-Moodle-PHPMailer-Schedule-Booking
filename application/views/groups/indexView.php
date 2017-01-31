        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->

                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('menu_groups'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="row portlet light">
                            <div class="col-md-3 visible-xs visible-sm margin-bottom-20">
                                <div class="group_tags group_tags_min">
                                    <h3><?php echo $this->lang->line('groups_tags');?></h3>
                                    <span><?php echo $this->lang->line('groups_click_tag_filter');?></span>
                                    <div class="tag_buttons">
                                        <button class="btn btn-sm btn-outline yellow tag_btn awaiting_state_btn"><?php echo $this->lang->line('groups_awaiting');?></button>
                                        <button class="btn btn-sm btn-outline green tag_btn active_state_btn"><?php echo $this->lang->line('groups_active');?></button>
                                        <button class="btn btn-sm btn-outline default tag_btn"><?php echo $this->lang->line('groups_finished');?></button>
                                        <button class="btn btn-sm btn-outline red tag_btn"><?php echo $this->lang->line('groups_cancelled');?></button>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-9">
                                    <div class="groups_table_section">

                                        <div class="text-right margin-bottom-10">
                                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                        </div>
                                        <div class="quick_tips_sidebar margin-top-20">
                                            <div class=" note note-info quick_tips_content">
                                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                                <p><?php echo $this->lang->line('groups_quick_tips_text'); ?> 
                                                    <strong><a href="<?php echo $this->lang->line('groups_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('groups_quick_tips_link_text'); ?></a></strong>
                                                </p>
                                            </div>
                                        </div>

                                        <div id="groups_table_empty" class=" no_data_table">

                                        </div>
                                        <table id="groups" class="table display dbtable_hover_theme" cellspacing="0" >
                                        <thead>
                                        <tr>
<!--                                            <th></th>-->
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($groups) && !empty($groups)) {?>
                                            <?php foreach($groups as $group){ ?>
                                                <tr id="tr_<?php echo $group->idgroup; ?>">
<!--                                                    <td>-->
<!--                                                        <div class="md-checkbox">-->
<!--                                                            <input type="checkbox" name="check_group[]" id="id---><?php //echo $group->idgroup;?><!--" value="--><?php //echo $group->idgroup;?><!--" class="check_group">-->
<!---->
<!--                                                            <label for="id---><?php //echo $group->idgroup;?><!--"><span></span><span class="check"></span><span class="box"></span></label>-->
<!--                                                        </div>-->
<!---->
<!--                                                    </td>-->
                                                    <td>
                                                        <a href="<?php echo base_url().'groups/edit/'.$group->idgroup; ?>"><?php echo $group->group_name;?></a>
                                                        <p><?php echo $this->lang->line('groups_hours');?>: <strong><?php echo round($group->hours); ?></strong></p>

                                                    </td>
                                                    <td>

                                                        <p><?php echo $this->lang->line('groups_start_date');?>: <strong><?php echo ($group->start_date ? date($datepicker_format,strtotime($group->start_date)) : '');?></strong></p>
                                                        <p><?php echo $this->lang->line('groups_end_date');?>: <strong><?php echo ($group->end_date ? date($datepicker_format,strtotime($group->end_date)) : '');?></strong></p>
                                                        <p><?php echo $this->lang->line('groups_max_seats');?>: <strong><?php echo $group->max_seats;?></p>

                                                        <p><?php echo $this->lang->line('groups_available_seats');?>: <strong><?php echo $group->available_seats;?></strong></p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <?php
                                                            switch ($group->state){
                                                                case 0:
                                                                    echo '<button disabled class="btn btn-sm btn-outline yellow awaiting_state_btn state_btn">'.$this->lang->line('groups_awaiting').'</button>';
                                                                    break;
                                                                case 1:
                                                                    echo '<button disabled class="btn btn-sm btn-outline green  active_state_btn state_btn">'.$this->lang->line('groups_active').'</button>';
                                                                    break;
                                                                case 2:
                                                                    echo '<button disabled class="btn btn-sm btn-outline default state_btn">'.$this->lang->line('groups_finished').'</button>';
                                                                    break;
                                                                case 3:
                                                                    echo '<button disabled class="btn  btn-sm  btn-outline red state_btn">'.$this->lang->line('groups_cancelled').'</button>';
                                                                    break;
                                                                default:
                                                                    echo '<button disabled class="btn btn-sm btn-outline yellow awaiting_state_btn state_btn">'.$this->lang->line('groups_awaiting').'</button>';
                                                            }
                                                            ?>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group pull-right" >
                                                            <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-cog"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-right" id="ul_<?php echo $group->idgroup; ?>" data-id_group="<?php echo $group->idgroup; ?>" data-state="<?php echo $group->state; ?>">
                                                                <li class="group_change"><a href="#" data-toggle="tooltip" title="" class=""  data-confirm="<?php echo $this->lang->line('are_you_sure_delete');?>"><?php echo $this->lang->line('groups_delete_group');?></a></li>
                                                                <li class="group_change"><a href="#" data-toggle="tooltip" title="" class=""><?php echo $this->lang->line('groups_change_state');?></a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } ?>

                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                                <div class="col-md-3 hidden-xs hidden-sm">
                                    <div class="group_tags">
                                        <h3><?php echo $this->lang->line('groups_tags');?></h3>
                                        <span><?php echo $this->lang->line('groups_click_tag_filter');?></span>
                                        <div class="tag_buttons">
                                            <button class="btn btn-sm btn-outline yellow tag_btn awaiting_state_btn"><?php echo $this->lang->line('groups_awaiting');?></button>
                                            <button class="btn btn-sm btn-outline green tag_btn active_state_btn"><?php echo $this->lang->line('groups_active');?></button>
                                            <button class="btn btn-sm btn-outline default tag_btn"><?php echo $this->lang->line('groups_finished');?></button>
                                            <button class="btn btn-sm btn-outline red tag_btn"><?php echo $this->lang->line('groups_cancelled');?></button>
                                        </div>
                                    </div>
                                </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
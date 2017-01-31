<hr/>
<div class="row margin-top-20 campaigns_add  ">
    <div class="col-xs-12">
        <div class="row margin-bottom-20 selected_count_section">
            <div class="col-md-3 campaigns_header">
                <blockquote><?php echo $this->lang->line('campaigns_recipients');?>: <span><?php echo @$all_segments_count; ?></span></blockquote>
            </div>
            <div class="col-md-7 campaigns_header">
                <blockquote><p class=""><?php echo ucfirst($this->lang->line('campaigns_selected') ); ?> </p>
                  <p class="selected_parts_titles">  
                    <span class=""><?php echo $this->lang->line('contacts'); ?>: </span>
                    ( <span class="number" id="sc">0</span> )
                    <span class=""> <?php echo $this->lang->line('students'); ?>: </span>
                    ( <span class="number" id="ss">0</span> )
                    <span class=""> <?php echo $this->lang->line('teachers'); ?>: </span>
                    ( <span class="number" id="st">0</span> )
                    <span class=""> <?php echo $this->lang->line('Prospects'); ?>: </span>
                    ( <span class="number" id="sp">0</span> )
                    <span class=""> <?php echo $this->lang->line('Enrollments'); ?>: </span>
                    ( <span class="number" id="se">0</span> )
                  </p>
                </blockquote>
            </div>
            <div class="col-md-2 campaigns_header">
                <blockquote>
                    <span class=""><?php echo $this->lang->line('total'); ?>: </span>
                     <span class="number" id="checked_total">0</span>
                </blockquote>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 ">
                <p class="uppercase"><?php echo $this->lang->line('campaigns_segments');?></p>
                <div class="campaign_segments">
                    <?php
                    if(!empty($segments)){
                        foreach($segments as $sk=>$segment){
                                $active_tab = '';
                                if($sk == 0){
                                    $active_tab = 'active';
                                }
                            ?>
                            <div class="campaign_segment_item <?php echo $active_tab; ?>" data-segment_id="<?php echo $segment->id; ?>">
                                <a href="#" class="campaign_segment" id="<?php echo $segment->id; ?>">
                                <span class="campaign_segment_title"><?php echo $this->lang->line($segment->title); ?></span>
                                <span class="number theme_background" id="ftc_<?php echo $segment->id; ?>"><?php echo $segment->items_count; ?></span>
                                </a>
                            </div>
                        <?php  }
                    }
                    ?>
                </div>
                <hr />


                <div class="campaigns_filter_section parent_tag"  data-window="big">
                    <h2 class="uppercase"><?php echo $this->lang->line('filter_by'); ?></h2>
                    <input type="checkbox" style="display: none;" id="checked_or_all" name="checked_or_all"  />
                    <div class="filter_tags">
                        <div class="form-group">
                            <label class="control-label select_surname_label text-left"><?php echo $this->lang->line('sur_name');?>:</label>
                            <input id="surname_select" class="tags"  type="hidden" style="width: 100%" />
                        </div>
                        <div class="form-group">
                            <label class="control-label select_first_name_label text-left"><?php echo $this->lang->line('first_name');?>:</label>
                            <input id="first_name_select" class="tags"  type="hidden" style="width: 100%" />
                        </div>
                        <div class="form-group">
                            <label class="control-label select_email_label text-left"><?php echo $this->lang->line('email');?>:</label>
                            <input id="email_select" class="tags"  type="hidden" style="width: 100%" />
                        </div>
                        <div class="prospect_filter_tags" style="display: none;">
                            <div class="form-group">
                                <label class="control-label select_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                <input id="state_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>

                            <div class="form-group">
                                <label class="control-label select_source_label text-left"><?php echo $this->lang->line('prospects_source');?>:</label>
                                <input id="source_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>
                            <div class="form-group">
                                <label class="control-label select_campaign_label text-left"><?php echo $this->lang->line('campaign');?>:</label>
                                <input id="campaign_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>
                            <div class="form-group">
                                <label class="control-label select_stars_label text-left"><?php echo $this->lang->line('prospects_with_star');?>:</label>
                                <input id="stars_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>
                            <div class="form-group">
                                <label class="control-label select_score_label text-left"><?php echo $this->lang->line('prospects_with_score');?>:</label>
                                <input id="score_select" class="tags" type="hidden" style="width: 100%" />
                            </div>
                        </div>

                        <div class="enrollment_filter_tags" style="display: none;">
                            <div class="form-group">
                                <label class="control-label select_e_state_label text-left"><?php echo $this->lang->line('state');?>:</label>
                                <input id="e_state_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>

                            <div class="form-group">
                                <label class="control-label select_course_label text-left"><?php echo $this->lang->line('courses');?>:</label>
                                <input id="course_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>
                            <div class="form-group">
                                <label class="control-label select_group_label text-left"><?php echo $this->lang->line('groups');?>:</label>
                                <input id="group_select" class="tags"  type="hidden" style="width: 100%" />
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="col-md-9 campaigns_table_block">
                
                <div id="recipients_table"></div>
                <div class="no_recipients_table" style="display: none"></div>
            </div>
        </div>
    </div>
</div>

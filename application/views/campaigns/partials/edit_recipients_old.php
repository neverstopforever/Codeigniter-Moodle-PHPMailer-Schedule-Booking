<div class="row margin-top-20 campaigns_add  ">
    <div class="col-xs-12">
        <div class="row margin-bottom-20">
            <div class="col-xs-6 campaigns_header">
                <?php echo $this->lang->line('campaigns_recipients');?> <i>(<?php echo @$all_segments_count; ?>)</i>
<!--                <a id="delete_all_checked" class="btn btn-sm btn-default" href="/campaigns/delete_all_checked" title="--><?php //echo $this->lang->line('delete');?><!--" data-delete_all_checked="--><?php //echo $this->lang->line('are_you_sure_delete');?><!--" style="display: none;">--><?php //echo $this->lang->line('delete');?><!--</a>-->
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 ">
                <p class="uppercase"><?php echo $this->lang->line('campaigns_segments');?></p>
                <div class="campaign_segments">
                    <div class="campaign_segment_item active"  data-segment_id="all">
                        <a href="#" class="campaign_segment" id="all">
                            <span class="campaign_segment_title"><?php echo $this->lang->line('all'); ?> </span>
                            <span id="all_segments_count" class="number theme_background"><?php echo $all_segments_count; ?></span>
                        </a>
                    </div>
                    <?php
                    if(!empty($segments)){
                        foreach($segments as $segment){ ?>
                            <div class="campaign_segment_item" data-segment_id="<?php echo $segment->id; ?>">
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
                <p class="uppercase"><?php echo $this->lang->line('filter_by'); ?></p>
                <div class="campaigns_filter_section parent_tag"  data-window="big">
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
                    </div>
                </div>
            </div>
            <div class="col-md-9 campaigns_table_block">
                <table class="table display dbtable_hover_theme" id="recipients" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>
                            <div class="md-checkbox">
                                <input type="checkbox" name="check_recipients_all md-check" id="check_recipients_all" value="all" />
                                <label for="check_recipients_all">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                        </th>
                        <th><?php echo $this->lang->line('surename'); ?></th>
                        <th><?php echo $this->lang->line('first_name'); ?></th>
                        <th><?php echo $this->lang->line('email'); ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

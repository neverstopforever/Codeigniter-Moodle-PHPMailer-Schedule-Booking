<div id="editCouponModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cpanel_edit_coupon"); ?> </h4>
            </div>
            <form id="edit_coupon_form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="coupon_id" value="<?php echo $coupon->id;?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_coupon_id"); ?>: </lable>
                        <span><?php echo $coupon->id; ?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_title"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control" name="title" value="<?php echo $coupon->title;?>">
                    </div>
                    <?php

                    if($this->data['lang'] == "spanish"){
                        setlocale(LC_MONETARY, 'es_ES.utf8');
                    }else{
                        setlocale(LC_MONETARY, 'en_GB.utf8');
                    }
                    $discount = money_format('%!n', round($coupon->discount, 3));
                    $percent_off = money_format('%!n', round($coupon->percent_off, 3));

                    ?>
                    <div class="bs-example">
                        <div class="form-group">
                            <lable><?php echo $this->lang->line("cpanel_fixed_discount"); ?>: </lable>
                            <input type="text" class="form-control float_type" name="discount" value="<?php echo $discount;?>" data-action="edit">
                        </div>
                       
                        <div class="hr"><span><?php echo $this->lang->line("or"); ?></span></div>
                        
                        <div class="form-group">
                            <lable><?php echo $this->lang->line("cpanel_percent_off"); ?>: </lable>
                            <input type="text" class="form-control float_type" name="percent_off" value="<?php echo $percent_off;?>" data-action="edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_code"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control" name="code" value="<?php echo $coupon->code;?>">
                        <input type="hidden" class="form-control" name="old_code" value="<?php echo $coupon->code;?>">
                    </div>
<!--                    <div class="form-group">-->
<!--                        <lable>--><?php //echo $this->lang->line("cpanel_duration"); ?><!--<span style="color: red;">*</span>: </lable>-->
<!--                        <select name="duration" class="form-control" data-type="edit">-->
<!--                            <option value="once" --><?php //echo ($coupon->duration == "once") ? 'selected="selected"': ''; ?><!--><?php //echo $this->lang->line('cpanel_once'); ?><!--</option>-->
<!--                            <option value="forever" --><?php //echo ($coupon->duration == "forever") ? 'selected="selected"': ''; ?><!--><?php //echo $this->lang->line('cpanel_forever'); ?><!--</option>-->
<!--                            <option value="repeating" --><?php //echo ($coupon->duration == "repeating") ? 'selected="selected"': ''; ?><!--><?php //echo $this->lang->line('cpanel_repeating'); ?><!--</option>-->
<!--                        </select>-->
<!--                    </div>-->
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_duration"); ?><span style="color: red;">*</span>: </lable>
                        <span><?php echo $this->lang->line('cpanel_once'); ?></span>                    
                    </div>
<!--                    <div class="form-group dim" style="display: none;">-->
<!--                        <lable>--><?php //echo $this->lang->line("cpanel_duration_in_months"); ?><!--<span style="color: red;">*</span>: </lable>-->
<!--                        <input type="text" class="form-control" name="duration_in_months" value="--><?php //echo $coupon->duration_in_months;?><!--">-->
<!--                    </div>-->
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_from"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control datepicker" name="from" value="<?php echo date($datepicker_format, strtotime($coupon->from));?>">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_to"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control datepicker" name="to" value="<?php echo date($datepicker_format, strtotime($coupon->to));?>">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_enabled"); ?><span style="color: red;">*</span>: </lable>
                        <select name="enabled" class="form-control" data-type="edit">
                            <option value="1"<?php echo ($coupon->enabled == "1") ? 'selected="selected"': ''; ?>><?php echo $this->lang->line('yes'); ?></option>
                            <option value="2"<?php echo ($coupon->enabled == "0") ? 'selected="selected"': ''; ?>><?php echo $this->lang->line('no'); ?></option>
                        </select>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <lable>--><?php //echo $this->lang->line("cpanel_max_redemptions"); ?><!-- (--><?php //echo $this->lang->line("optional"); ?><!--): </lable>-->
<!--                        <input type="text" class="form-control" name="max_redemptions" value="--><?php //echo $coupon->max_redemptions;?><!--">-->
<!--                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("save"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>app/js/cpanel/manage_coupons/edit.js"></script> <!--TODO need to remove or something else

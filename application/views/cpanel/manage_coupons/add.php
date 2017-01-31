<div id="addCouponModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cpanel_add_coupon"); ?> </h4>
            </div>
            <form id="add_coupon_form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_title"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control" name="title" value="">
                    </div>
                    <?php

                    if($this->data['lang'] == "spanish"){
                        setlocale(LC_MONETARY, 'es_ES.utf8');
                    }else{
                        setlocale(LC_MONETARY, 'en_GB.utf8');
                    }

                    ?>
                    <div class="bs-example">
                        <div class="form-group">
                            <lable><?php echo $this->lang->line("cpanel_fixed_discount"); ?>: </lable>
                            <input type="text" class="form-control float_type" name="discount" value="0" data-action="add">
                        </div>
                        <div class="hr"><span><?php echo $this->lang->line("or"); ?></span></div>
                        <div class="form-group">
                            <lable><?php echo $this->lang->line("cpanel_percent_off"); ?>: </lable>
                            <input type="text" class="form-control float_type" name="percent_off" value="0" data-action="add">
                        </div>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_code"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control" name="code" value="">
                    </div>
<!--                    <div class="form-group">-->
<!--                        <lable>--><?php //echo $this->lang->line("cpanel_duration"); ?><!--<span style="color: red;">*</span>: </lable>-->
<!--                        <select name="duration" class="form-control" data-type="add">-->
<!--                            <option value="once">--><?php //echo $this->lang->line('cpanel_once'); ?><!--</option>-->
<!--                            <option value="forever">--><?php //echo $this->lang->line('cpanel_forever'); ?><!--</option>-->
<!--                            <option value="repeating">--><?php //echo $this->lang->line('cpanel_repeating'); ?><!--</option>-->
<!--                        </select>-->
<!--                    </div>-->
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_duration"); ?><span style="color: red;">*</span>: </lable>
                        <span><?php echo $this->lang->line('cpanel_once'); ?></span>
                    </div>
<!--                    <div class="form-group dim" style="display: none;">-->
<!--                        <lable>--><?php //echo $this->lang->line("cpanel_duration_in_months"); ?><!--<span style="color: red;">*</span>: </lable>-->
<!--                        <input type="text" class="form-control" name="duration_in_months" value="">-->
<!--                    </div>-->
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_from"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control datepicker" name="from" value="<?php echo date($datepicker_format);?>">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_to"); ?><span style="color: red;">*</span>: </lable>
                        <input type="text" class="form-control datepicker" name="to" value="<?php echo date($datepicker_format, strtotime('+30 days'));?>">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_enabled"); ?><span style="color: red;">*</span>: </lable>
                        <select name="enabled" class="form-control" data-type="add">
                            <option value="1"><?php echo $this->lang->line('yes'); ?></option>
                            <option value="2"><?php echo $this->lang->line('no'); ?></option>
                        </select>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <lable>--><?php //echo $this->lang->line("cpanel_max_redemptions"); ?><!-- (--><?php //echo $this->lang->line("optional"); ?><!--): </lable>-->
<!--                        <input type="text" class="form-control" name="max_redemptions" value="">-->
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
<script src="<?php echo base_url(); ?>app/js/cpanel/manage_coupons/add.js"></script> <!--TODO need to remove or something else

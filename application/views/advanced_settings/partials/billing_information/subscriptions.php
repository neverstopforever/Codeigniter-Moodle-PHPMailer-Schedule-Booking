
<div class="subscriber_current_data row">
    <div class="col-sm-6">
        <p><?php echo $this->lang->line('advanced_settings_current_subscription_type'); ?>:   <span><?php echo $subscription_type; ?></span></p>
<!--        --><?php //print_r($subscription_plan) ?>
        <p><?php echo $this->lang->line('advanced_settings_current_plan'); ?>:  <span><?php echo $this->lang->line($subscription_plan); ?></span></p>
    </div>
    <div class="col-sm-6 text-right">

        <a href="<?php echo $_base_url; ?>advancedSettings/cancel_subscription" class="btn btn-danger btn-circle "> <i class="fa fa-times" aria-hidden="true"></i>  <?php echo $this->lang->line('advanced_settings_cancell_subscription'); ?></a>

    </div>
</div>
<h3 class="text-center invoicesTable_name"><?php echo $this->lang->line('advanced_settings_your_invoices'); ?></h3>
<div class="tab-content_prospect">
    <div class="no_invoicesTable margin-top-20" style="display: none;"></div>
    <div id="invoicesTable" class="margin-top-20"></div>
</div>

<div class="modal fade" id="subscription_cancel_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('advanced_settings_cancel_subscription_plan'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn btn-primary delete_blog subscription_plan_confirm"  ><?php echo $this->lang->line('confirm');?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var _invoices = <?php echo isset($invoices) ? json_encode($invoices) : json_encode(array()); ?>;
    var  invoice_id_data = <?php echo isset($invoice_id_data) ? json_encode($invoice_id_data) : json_encode(array()); ?>;
    var  state_data = <?php echo isset($state_data) ? json_encode($state_data) : json_encode(array()); ?>;
    var  _plan_fields = <?php echo isset($plan_fields) ? json_encode($plan_fields) : json_encode(array()); ?>;
</script>
<script class="js_external" type="text/javascript" src="/app/js/advanced_settings/partials/billing_information/subscribers.js"></script>

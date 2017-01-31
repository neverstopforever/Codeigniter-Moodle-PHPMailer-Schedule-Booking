<div id="addTransferModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cpanel_add_transfer"); ?> </h4>
            </div>
            <form id="add_transfer_form"  method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_client_id"); ?>: </lable>
                        <select name="client_id" id="idcliente" class="form-control">
                            <option value="">--<?php echo $this->lang->line('cpanel_select_customer'); ?>--</option>
                            <?php foreach ($customers as $customer) {?>
                                <option value="<?php echo $customer->id; ?>"><?php echo $customer->fiscal_name; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_title"); ?>: </lable>
                        <input type="text" class="form-control" name="title" value="">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_description"); ?>: </lable>
                        <input type="text" class="form-control" name="description" value="">
                    </div>

                    <?php

                    if($this->data['lang'] == "spanish"){
                        setlocale(LC_MONETARY, 'es_ES.utf8');
                    }else{
                        setlocale(LC_MONETARY, 'en_GB.utf8');
                    }                   

                    ?>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_membership_plan"); ?>: </lable>
                        <select name="membership_plan" class="form-control" data-type="add">
                            <?php foreach ($plan_fields as $item){ ?>
                                <option value="<?php echo $item->membership_plan; ?>"><?php echo $item->membership_type . " (".$item->membership_interval.") "; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_qty"); ?>: </lable>
                        <input type="text" class="form-control calculate_transfer_price" name="qty" value="0" data-type="add">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_price"); ?>: </lable>
                        <input type="text" class="form-control calculate_transfer_price" name="price" value="0" data-type="add">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_purpose"); ?>: </lable>
                        <select name="purpose" class="form-control" data-type="add">
                            <option value="1"><?php echo $this->lang->line('cpanel_register'); ?></option>
                            <option value="2"><?php echo $this->lang->line('cpanel_upgrade'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_paid"); ?>: </lable>
                        <select name="paid" class="form-control" data-type="add">
                            <option value="0"><?php echo $this->lang->line('no'); ?></option>
                            <option value="1"><?php echo $this->lang->line('yes'); ?></option>
                        </select>
                        <div class="text-danger paid_alert" style="display: none">
                            <p><?php echo $this->lang->line('cpanel_confirm_change_paid'); ?> </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_vat"); ?>: </lable>
                        <select name="vat" class="form-control percent_vat" data-type="add">
                            <?php foreach ($vats as $vat){ ?>
                                <option value="<?php echo $vat->percent_vat; ?>"
                                        data-vat_id="<?php echo $vat->id; ?>"><?php echo $vat->vat_name; ?></option>
                            <?php }?>
                        </select>
                    </div>                    
                    <div class="form-group text-right margin-top-10 transfer_total_amount_section">
                        <lable><?php echo $this->lang->line("cpanel_total_amount"); ?>: </lable>
                        <span class="transfer_total_amount">0</span>
                    </div>                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("save"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#idcliente").select2({
        placeholder: "Select an option",
        allowClear: true
    });
</script>
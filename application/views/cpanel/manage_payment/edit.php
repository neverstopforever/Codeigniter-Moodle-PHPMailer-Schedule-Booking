<div id="editTransferModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cpanel_edit_transfer"); ?> </h4>
            </div>
            <form id="edit_transfer_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="transfer_id" value="<?php echo $transfer->id;?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_transfer_id"); ?>: </lable>
                        <span><?php echo $transfer->id; ?></span>
                    </div>

                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_client_id"); ?>: </lable>
                        <select name="client_id" class="form-control" data-type="edit">
                            <?php foreach ($customers as $customer){ ?>
                                <option value="<?php echo $customer->id; ?>"
                                    <?php echo ($customer->id == $transfer->client_id) ? 'selected="selected"': ''; ?>><?php echo $customer->fiscal_name; ?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_title"); ?>: </lable>
                        <input type="text" class="form-control" name="title" value="<?php echo $transfer->title;?>">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_description"); ?>: </lable>
                        <input type="text" class="form-control" name="description" value="<?php echo $transfer->description;?>">
                    </div>


                    <?php

                    if($this->data['lang'] == "spanish"){
                        setlocale(LC_MONETARY, 'es_ES.utf8');
                    }else{
                        setlocale(LC_MONETARY, 'en_GB.utf8');
                    }
                    $qty = money_format('%!n', round($transfer->qty, 3));
                    $price = money_format('%!n', round($transfer->price / 100, 3));
                    $vat = money_format('%!n', round($transfer->vat, 3));
                    $total_amount = ($transfer->qty * ($transfer->price / 100) * $transfer->vat) / 100 + (($transfer->price / 100) * $transfer->qty);
                    $total_amount = money_format('%!n', round($total_amount, 3));

                    ?>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_membership_plan"); ?>: </lable>
                        <select name="membership_plan" class="form-control" data-type="edit">
                            <?php foreach ($plan_fields as $item){ ?>
                                <option value="<?php echo $item->membership_plan; ?>"
                                    <?php echo ($item->membership_plan == $transfer->membership_plan) ? 'selected="selected"': ''; ?>><?php echo $item->membership_type . " (".$item->membership_interval.") "; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_qty"); ?>: </lable>
                        <input type="text" class="form-control calculate_transfer_price" name="qty" value="<?php echo $qty;?>" data-type="edit">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_price"); ?>: </lable>
                        <input type="text" class="form-control calculate_transfer_price" name="price" value="<?php echo $price;?>" data-type="edit">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_purpose"); ?>: </lable>
                        <select name="purpose" class="form-control" data-type="edit">
                            <option value="1"<?php echo ($transfer->purpose == "1") ? 'selected="selected"': ''; ?>><?php echo $this->lang->line('cpanel_register'); ?></option>
                            <option value="2"<?php echo ($transfer->purpose == "2") ? 'selected="selected"': ''; ?>><?php echo $this->lang->line('cpanel_upgrade'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_paid"); ?>: </lable>
                        <select name="paid" class="form-control" data-type="edit">
                            <option value="0"<?php echo ($transfer->paid == "0") ? 'selected="selected"': ''; ?>><?php echo $this->lang->line('no'); ?></option>
                            <option value="1"<?php echo ($transfer->paid == "1") ? 'selected="selected"': ''; ?>><?php echo $this->lang->line('yes'); ?></option>
                        </select>
                        <div class="text-danger paid_alert" style="display: none">
                            <p><?php echo $this->lang->line('cpanel_confirm_change_paid'); ?> </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("cpanel_vat"); ?>: </lable>
                        <select name="vat" class="form-control percent_vat" data-type="edit">
                            <?php foreach ($vats as $vat){ ?>
                                <option value="<?php echo $vat->percent_vat; ?>"
                                        data-vat_id="<?php echo $vat->id; ?>"
                                <?php echo ($vat->percent_vat == $transfer->vat) ? 'selected="selected"': ''; ?>><?php echo $vat->vat_name; ?></option>
                            <?php }?>
                        </select>
                    </div>                    
                    <div class="form-group text-right margin-top-10 transfer_total_amount_section">
                        <lable><?php echo $this->lang->line("cpanel_total_amount"); ?>: </lable>
                        <span class="transfer_total_amount"><?php echo $total_amount;?></span>
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

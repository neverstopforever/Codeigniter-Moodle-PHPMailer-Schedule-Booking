<div id="editServiceModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("mi_edit_invoice"); ?> </h4>
            </div>
            <form id="edit_service_form"  method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add" />
                <input type="hidden" name="service_id" value="<?php echo $service->id;?>" />
                <input type="hidden" name="invoice_id" value="<?php echo $service->invoice_id;?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_service_id"); ?>: </lable>
                        <span><?php echo $service->id; ?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_invoice_id"); ?>: </lable>
                        <span><?php echo $service->invoice_id; ?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_reference"); ?>: </lable>
                        <input type="text" class="form-control" name="reference" value="<?php echo $service->reference;?>">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_description"); ?>: </lable>
                        <input type="text" class="form-control" name="description" value="<?php echo $service->description;?>">
                    </div>
                    <?php

                    if($this->data['lang'] == "spanish"){
                        setlocale(LC_MONETARY, 'es_ES.utf8');
                    }else{
                        setlocale(LC_MONETARY, 'en_GB.utf8');
                    }
                    $units = money_format('%!n', round($service->units, 3));
                    $price_by_unit = money_format('%!n', round($service->price_by_unit, 3));
                    $service_total_amount = (($service->units * $service->price_by_unit) * $service->percent_vat) / 100 + ($service->price_by_unit * $service->units);
                    $service_total_amount = money_format('%!n', round($service_total_amount, 3));

                    ?>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_units"); ?>: </lable>
                        <input type="text" class="form-control calculate_service_price" name="units" value="<?php echo $units;?>" data-type="edit">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_price_by_unit"); ?>: </lable>
                        <input type="text" class="form-control calculate_service_price" name="price_by_unit" value="<?php echo $price_by_unit;?>" data-type="edit">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_vat"); ?>: </lable>
                        <select name="vat" class="form-control percent_vat" data-type="edit">
                            <?php foreach ($vats as $vat){ ?>
                                <option value="<?php echo $vat->percent_vat; ?>"
                                        data-vat_id="<?php echo $vat->id; ?>"
                                <?php echo ($vat->percent_vat == $service->percent_vat) ? 'selected="selected"': ''; ?>><?php echo $vat->vat_name; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_total_amount"); ?>: </lable>
                        <span class="service_total_amount"><?php echo $service_total_amount;?></span>
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
<script src="<?php echo base_url(); ?>app/js/manage_invoices/partials/edit/add_service.js"></script>
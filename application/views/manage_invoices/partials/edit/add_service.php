<div id="addServiceModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("mi_create_new_invoice"); ?> </h4>
            </div>
            <form id="add_service_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add" />
                <input type="hidden" name="invoice_id" value="<?php echo @$invoice_id;?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_invoice_id"); ?>: </lable>
                        <span><?php echo @$invoice_id; ?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_reference"); ?>: </lable>
                        <input type="text" class="form-control" name="reference">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_description"); ?>: </lable>
                        <input type="text" class="form-control" name="description">
                    </div>
                    <?php
                        if($this->data['lang'] == "spanish"){
                            setlocale(LC_MONETARY, 'es_ES.utf8');
                        }else{
                            setlocale(LC_MONETARY, 'en_GB.utf8');
                        }
                    ?>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_units"); ?>: </lable>
                        <input type="text" class="form-control calculate_service_price" name="units" data-type="add">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_price_by_unit"); ?>: </lable>
                        <input type="text" class="form-control calculate_service_price" name="price_by_unit" data-type="add">
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_vat"); ?>: </lable>
                        <select name="vat" class="form-control percent_vat" data-type="add">
                            <?php foreach ($vats as $vat){ ?>
                                <option value="<?php echo $vat->percent_vat; ?>" data-vat_id="<?php echo $vat->id; ?>" ><?php echo $vat->vat_name; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_total_amount"); ?>: </lable>
                        <span class="service_total_amount"></span>
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
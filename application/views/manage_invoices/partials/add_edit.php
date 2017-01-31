<div id="addEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("mi_create_new_invoice"); ?> </h4>
            </div>
            <form id="add_edit_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add" />
                <input type="hidden" name="invoice_id" value="<?php echo @$invoice_id;?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("mi_invoice_id"); ?>: </lable>
                        <span><?php echo @$invoice_id; ?></span>
                    </div>
                    <div class="form-group">
                        <lable for="doc_type"><?php echo $this->lang->line("mi_type_of_doc"); ?>: </lable>
                        <select name="doc_type" id="doc_type" class="form-control">
                            <option value="">--<?php echo $this->lang->line('select') ?>--</option>
                        <?php foreach ($doc_types as $doc_type_k=>$doc_type_item){ ?>
                            <option value="<?php echo $doc_type_k;?>"><?php echo $doc_type_item;?></option>
                       <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="role"><?php echo $this->lang->line("mi_student_company"); ?>: </lable>
                        <select name="role" id="role" class="form-control">
                            <option value="">--<?php echo $this->lang->line('select') ?>--</option>
                        <?php foreach ($roles as $role_k=>$role_item){ ?>
                            <option value="<?php echo $role_k;?>"><?php echo $role_item;?></option>
                       <?php }?>
                        </select>
                    </div>
                    <div class="form-group" id="select_name_multiple-datasets">
                        <lable for="select_name"><?php echo $this->lang->line("mi_select_name"); ?>: </lable>
                        <input type="text" class="typeahead form-control" name="select_name" id="select_name">
                        <input type="hidden" name="select_name_id" id="select_name_id">
                    </div>
                    <div class="form-group">
                        <lable for="date"><?php echo $this->lang->line("date"); ?>: </lable>
                        <input type="text" class="form-control" name="date" id="date">
                    </div>

                    <div class="form-group">
                        <lable for="payment_method"><?php echo $this->lang->line("mi_payment_method"); ?>: </lable>
                        <select name="payment_method" id="payment_method" class="form-control">
                            <option value="">--<?php echo $this->lang->line('select') ?>--</option>
                            <?php foreach ($payment_methods as $payment_method_k=>$payment_method_item){ ?>
                                <option value="<?php echo $payment_method_k;?>"><?php echo $payment_method_item;?></option>
                            <?php }?>
                        </select>
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
<script src="<?php echo base_url(); ?>app/js/manage_invoices/partials/add_edit.js"></script>
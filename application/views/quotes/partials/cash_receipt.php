<div id="cashReceiptModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("quotes_cash_receipt"); ?> </h4>
            </div>

            <form id="cash_receipt_form" class="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-body">
                <input type="hidden" name="doc_id" value="<?php echo $receipt->doc_id;?>" />

                    <div class="form-group row">
                        <lable class="col-md-4 control-label" ><?php echo $this->lang->line("quotes_payment_type"); ?>: </lable>
                        <div class="col-md-6">
                            <select name="payment_type" class="form-control payment_type_select">
                                <?php foreach($payment_type_data as $paymentMethod){

                                    $selected = '';
                                    ?>
                                    <option value="<?php echo $paymentMethod['id']; ?>" <?php echo $selected; ?> >
                                        <?php echo $paymentMethod['text']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                         </div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label" ><?php echo $this->lang->line("quotes_state"); ?>: </lable>
                        <div class="col-md-8"><strong><?php echo $this->lang->line("quotes_due");//$receipt->state;?></strong></div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_appointment_date"); ?>: </lable>
                        <div class="col-md-8"><strong><?php echo date($datepicker_format, strtotime($receipt->appointment_date));?></strong></div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_amount"); ?>: </lable>
                        <div class="col-md-8"><strong><?php echo $receipt->amount;?> </strong></div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_customer_name"); ?>: </lable>
                        <div class="col-md-8"><strong><?php echo $receipt->customer_name;?></strong></div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_customer_type"); ?>: </lable>
                        <div class="col-md-8"><strong><?php echo $this->lang->line( $receipt->customer_type); ?></strong></div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_invoiced"); ?>: </lable>
                        <div class="col-md-8"><strong>
                            <?php
                            if($receipt->invoiced == "not_invoiced"){
                                echo $this->lang->line("quotes_not_invoiced");
                            }else{
                                echo $receipt->invoiced;
                            }
                            ?>
                        </strong></div>
                    </div>
                    <div class="form-group row">
                        <lable class="col-md-4 control-label"><?php echo $this->lang->line("quotes_service"); ?>: </lable>
                        <div class="col-md-8"><strong><?php echo $receipt->service;?></strong></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                             <lable for="history_date"><?php echo $this->lang->line("quotes_payment_date"); ?>: </lable>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control"  type="text" name="history_date" id="history_date" value="<?php echo date($datepicker_format);?>"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <a href="#" id="add_comment"><?php echo $this->lang->line('quotes_comments'); ?></a>
                    </div>
                    <div class="form-group" style="display: none;" id="comments_section">
                        <lable for="memo"><?php echo $this->lang->line("quotes_comments"); ?>: </lable>
                        <textarea class="form-control" name="memo" id="memo"><?php echo $receipt->comments;?></textarea>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="submit" enroll_id="<?php echo $receipt->enroll_id; ?>"  doc_id="<?php echo $receipt->doc_id ?>" class="btn btn-primary"><?php echo $this->lang->line("quotes_cash_receipt_save"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>app/js/quotes/partials/cash_receipt.js"></script>
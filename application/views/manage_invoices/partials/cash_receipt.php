<div id="cashReceiptModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("quotes_cash_receipt"); ?> </h4>
            </div>
            <form id="cash_receipt_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="doc_id" value="<?php echo $receipt->doc_id;?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_payment_type"); ?>: </lable>
                        <span><?php echo $this->lang->line("quotes_cash");//$receipt->payment_type;?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_state"); ?>: </lable>
                        <span><?php echo $this->lang->line("quotes_due");//$receipt->state;?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_appointment_date"); ?>: </lable>
                        <span><?php echo date($datepicker_format, strtotime($receipt->appointment_date));?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_amount"); ?>: </lable>
                        <span><?php echo $receipt->amount;?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_customer_name"); ?>: </lable>
                        <span><?php echo $receipt->customer_name;?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_customer_type"); ?>: </lable>
                        <span><?php echo $this->lang->line( $receipt->customer_type); ?></span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_invoiced"); ?>: </lable>
                        <span>
                            <?php
                            if($receipt->invoiced == "not_invoiced"){
                                echo $this->lang->line("quotes_not_invoiced");
                            }else{
                                echo $receipt->invoiced;
                            }
                            ?>
                        </span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_service"); ?>: </lable>
                        <span><?php echo $receipt->service;?></span>
                    </div>
                    <div class="form-group">
                        <lable for="history_date"><?php //echo $this->lang->line("quotes_history_date"); ?>: </lable>
                        <input class="form-control"  type="text" name="history_date" id="history_date" value="<?php echo date($datepicker_format);?>"/>
                    </div>
                    <div class="form-group">
                        <a href="#" id="add_comment"><?php echo $this->lang->line('quotes_comments'); ?></a>
                    </div>
                    <div class="form-group" style="display: none;" id="comments_section">
                        <lable for="memo"><?php echo $this->lang->line("quotes_comments"); ?>: </lable>
                        <textarea class="form-control" name="memo" id="memo"><?php echo $receipt->comments;?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("quotes_cash_receipt_save"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>app/js/quotes/partials/cash_receipt.js"></script>
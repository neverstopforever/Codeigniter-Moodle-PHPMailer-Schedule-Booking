<div id="invoicedReceiptModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("quotes_view_receipt"); ?> </h4>
            </div>
<!--                <input type="hidden" name="doc_id" value="--><?php //echo $receipt->doc_id;?><!--" />-->
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_payment_type"); ?>: </lable>
                        <span>
                            <?php
                            $payment_type = '';
                            switch ($receipt->payment_type){
                                case "0":
                                    $payment_type = $this->lang->line('quotes_cash');
                                    break;
                                case "1":
                                    $payment_type = $this->lang->line('quotes_credit_card');
                                    break;
                                case "2":
                                    $payment_type = $this->lang->line('quotes_direct_debit');
                                    break;
                                case "3":
                                    $payment_type = $this->lang->line('quotes_transfer');
                                    break;
                                case "4":
                                    $payment_type = $this->lang->line('quotes_check');
                                    break;
                                case "5":
                                    $payment_type = $this->lang->line('quotes_financed');
                                    break;
                                case "6":
                                    $payment_type = $this->lang->line('quotes_online_payment');
                                    break;
                                default:
                                    $payment_type = '';
                            }
                            echo $payment_type;                            
                            ?>
                        </span>
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("quotes_state"); ?>: </lable>
                        <span>
                            <?php
                            $state = '';
                            switch ($receipt->state){
                                case "0":
                                    $state = $this->lang->line('quotes_due');
                                    break;
                                case "1":
                                    $state = $this->lang->line('quotes_cashed');
                                    break;
                                case "2":
                                    $state = $this->lang->line('quotes_return_receipt');
                                    break;
                                case "3":
                                    $state = $this->lang->line('quotes_detained');
                                    break;
                                default:
                                    $state = '';
                            }
                            echo $state;                            
                            ?>
                        </span>
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
                        <lable for="memo"><?php echo $this->lang->line("quotes_comments"); ?>: </lable>
                        <p><?php echo $receipt->comments;?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="button" class="btn btn-primary print_data"><?php echo $this->lang->line("to_print"); ?> </button>
                </div>
        </div>
    </div>
</div>
<!--<script src="--><?php //echo base_url(); ?><!--app/js/quotes/partials/edit_invoiced_receipt.js"></script>-->
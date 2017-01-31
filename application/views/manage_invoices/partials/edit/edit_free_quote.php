<div id="editFreeQuoteModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("quotes_edit_free_quotes"); ?> </h4>
            </div>
            <form id="edit_free_quote_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="quote_id" value="<?php echo $quote->NUM_RECIBO;?>" />
                <input type="hidden" name="student_id" value="<?php echo $quote->IdCliente;?>" />
                <input type="hidden" name="enroll_id" value="<?php echo $quote->NumMatricula;?>" />
                <input type="hidden" name="invoice_id" value="<?php echo $quote->N_FACTURA;?>" />
                <div class="modal-body">
                    <div class="form-group row no_edit">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line('quotes_number_of_quotes'); ?></lable>:
                        </div>
                        <div class="col-md-2">
                            <input type="number" min="0" class="number_of_quotes form-control"  name="number_of_quotes" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_service"); ?>: </lable>
                        </div>
                        <div class="col-md-6">

                            <input class="form-control"  type="text" name="edit_service"  value="<?php echo $quote->concepto; ?>"/>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_reference_of_quote"); ?>: </lable>
                        </div>
                        <div class="col-md-6">

                            <input class="form-control"  type="text" name="reference_of_quote"  value="<?php echo $quote->referencia; ?>"/>

                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_discount_to_apply"); ?>: </lable>
                        </div>
                        <?php
                        if(isset($quote->IMPORTE) && $quote->IMPORTE != 0){
                            $discount = (($quote->IMPORTE - $quote->neto)  * 100) / $quote->IMPORTE;
                            $discount = round($discount, 3);
                        }else{
                            $discount = 0;
                        }
                        ?>
                        <?php

                        if($this->data['lang'] == "spanish"){
                            setlocale(LC_MONETARY, 'es_ES.utf8');
                        }else{
                            setlocale(LC_MONETARY, 'en_GB.utf8');
                        }
                        $discount = money_format('%!n', $discount);
                        $amount = money_format('%!n', round($quote->IMPORTE, 3));
                        $total_amount = money_format('%!n', round($quote->neto, 3));

                        ?>
                        <div class="col-md-6">
                            <input class="form-control float_type" max="100" type="text" name="discount" value="<?php echo  $discount; ?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_amount"); ?>: </lable>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control float_type"  type="text" name="amount" value="<?php echo $amount; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 ">
                            <lable><strong><?php echo $this->lang->line("quotes_total"); ?>:</strong> </lable>
<!--                            <span class="total_amount">--><?php //echo $quote->neto; ?><!--</span>-->
                        </div>
                        <div class="col-md-6">
                            <span class="total_amount"><?php echo $total_amount; ?></span>
<!--                            <input class="form-control float_type"  type="text" name="total" id="total" value="--><?php //echo $quote->neto; ?><!--" />-->
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable for="payment_type"><?php echo $this->lang->line("quotes_payment_type"); ?>: </lable>
                        </div>
                        <div class="col-md-6">
                            <select name="payment_type" class="form-control">
                                <?php foreach ($payment_type as $k=>$val){?>
                                    <option value="<?php echo $k;?>" <?php if($k == $quote->ID_FP){echo 'selected="selected"';}?>><?php echo $val;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_appointment_date"); ?>: </lable>

                        </div>
                        <div class="col-md-6">
                            <input class="form-control"  type="text" name="appointment_date" value="<?php echo date($datepicker_format, strtotime($quote->FECHA_VTO));?>"/>
                            <div class="margin-top-10">
                                <a href="#" class="btn btn-primary setToDay" ><?php echo $this->lang->line('quotes_to_day'); ?></a>
                            </div>
                        </div>

                    </div>



                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line('quotes_interval_between_quotes'); ?></lable>:
                        </div>
                        <div class="col-md-6">
                            <select name="interval_between_quotes" class="form-control">
                                <option value="monthly"><?php echo $this->lang->line('quotes_monthly');  ?></option>
                                <option value="bimonthly"><?php echo $this->lang->line('quotes_bimonthly');  ?></option>
                                <option value="quarterly"><?php echo $this->lang->line('quotes_quarterly');  ?></option>
                                <option value="4_months"><?php echo $this->lang->line('quotes_4_months');  ?></option>
                                <option value="6_months"><?php echo $this->lang->line('quotes_6_months');  ?></option>
                                <option value="yearly"><?php echo $this->lang->line('quotes_yearly');  ?></option>
                            </select>
                            <span class="validation_error" style="display: none">This field is required</span>
                        </div>
                        <div class="col-md-2">

                        </div>
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
<script src="<?php echo base_url(); ?>app/js/manage_invoices/partials/edit/edit_free_quote.js"></script>
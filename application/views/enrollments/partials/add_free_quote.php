<div id="addFreeQuoteModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("quotes_add_free_quotes"); ?> </h4>
            </div>
            <form id="add_free_quote_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="student_id" value="<?php echo @$student_id;?>" />
                <input type="hidden" name="enroll_id" value="<?php echo @$enroll_id;?>" />
                <input type="hidden" name="quote_id" />
                <div class="modal-body">
                    <div class="form-group row  no_edit">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line('quotes_number_of_quotes'); ?></lable>:
                        </div>
                        <div class="col-md-2">
                            <input type="number" min="1" max="100" class="number_of_quotes form-control"  name="number_of_quotes"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_service"); ?>: </lable>
                        </div>
                        <div class="col-md-6">

                            <input class="form-control"  type="text" name="service" id="service" value=""/>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_reference_of_quote"); ?>: </lable>
                        </div>
                        <div class="col-md-6">

                            <input class="form-control"  type="text" name="reference_of_quote" id="reference_of_quote" value=""/>

                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo $this->lang->line("quotes_amount"); ?>: </lable>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" min="0"  type="number" name="amount" id="amount" value="0"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable><?php echo "% " .$this->lang->line("quotes_tax"); ?>: </lable>
                        </div>
                         <div class="col-md-6 ">
                            <input class="form-control" min="0" max="100" type="number" name="discount" id="discount" value="0" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4 ">
                            <lable><?php echo $this->lang->line("quotes_total"); ?>: </lable>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" min="0" disabled type="number" name="total" id="total" value="0" />
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <lable for="payment_type"><?php echo $this->lang->line("quotes_payment_type"); ?>: </lable>
                        </div>
                        <div class="col-md-6">
                            <select name="payment_type" id="payment_type" class="form-control">
                                <?php foreach ($payment_type as $k=>$val){?>
                                    <option value="<?php echo $k;?>"><?php echo $val;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                         <lable><?php echo $this->lang->line("quotes_appointment_date"); ?>: </lable>

                        </div>
                        <div class="col-md-6">
                            <input class="form-control"  type="text" name="appointment_date" id="appointment_date" value="<?php echo date($datepicker_format);?>"/>
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
                            <option value="1"><?php echo $this->lang->line('quotes_monthly');  ?></option>
                            <option value="2"><?php echo $this->lang->line('quotes_bimonthly');  ?></option>
                            <option value="3"><?php echo $this->lang->line('quotes_quarterly');  ?></option>
                            <option value="4"><?php echo $this->lang->line('quotes_4_months');  ?></option>
                            <option value="6"><?php echo $this->lang->line('quotes_6_months');  ?></option>
                            <option value="12"><?php echo $this->lang->line('quotes_yearly');  ?></option>
                        </select>
                        <span class="validation_error" style="display: none">This field is required</span>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="submit" class="btn btn-primary add_edit" add_edit=""><?php echo $this->lang->line("save"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>app/js/enrollments/partials/add_free_quote.js"></script>
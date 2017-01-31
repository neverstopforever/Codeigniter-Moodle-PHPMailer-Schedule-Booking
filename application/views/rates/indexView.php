        <div class="page-container">
                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo $this->lang->line('menu_administrative'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('menu_rates'); ?>
                            </li>
                        </ul>
                        <div class="portlet light ">

                            <div class="text-right">
                                <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                            </div>
                            <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                                <div class=" note note-info quick_tips_content">
                                    <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                    <p><?php echo $this->lang->line('rates_quick_tips_text'); ?>
                                        <strong><a href="<?php echo $this->lang->line('rates_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('rates_quick_tips_link_text'); ?></a></strong>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-sm-7 circle_select_div rate_select_option">
                               <label><?php echo $this->lang->line('rates_select_a_rate'); ?></label>

                                <select class="form-control" name="select_rates">
                                    <option value="">--<?php echo $this->lang->line('rates_select_rate'); ?>--</option>
                                    <?php if(!empty($rates)){ ?>
                                        <?php foreach($rates as  $rate){ ?>
                                            <option value="<?php echo $rate->id ?>"><?php echo $rate->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>

                                <div class="rate_actions " style="display: none">
                                    <button  class="btn btn-primary btn-circle editRate  btn-sm" title="edit" ><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></button>
                                    <button  class="btn btn-circle deleteRateFee btn-sm" data_type="rate" title="delete" ><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?></button>

                                </div>

                            </div>

                            <div class="col-sm-5 text-right addNewRate_section">
                                <a href="#" class="btn pull-right btn-primary btn-circle addNewRate" title="new" ><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('rate'); ?></a>
                            </div>
                            </div>
                                <div class="no_feesTable" style="display: none;">
    
                                </div>
                                <div id="feesTable" class="student_documents_table padding-top-20">

                                </div>

                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <!-- END PAGE CONTENT INNER -->
                    <div class="modal fade" id="addNewFeeModal" tabindex="-1" role="dialog"  aria-hidden="true">
<!--                        <form class="form_add_fee" name="form_add_fee">-->
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                        <h4 class="modal-title"><?php echo $this->lang->line('rates_edit_fee'); ?></h4>
                                    </div>

                                    <div class="modal-body" style="overflow: hidden">
                                        <div class="form-group row  no_edit">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_number_of_fees'); ?></lable>:
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="1" max="90" id="fees_number" class="number_of_fees form-control input-xsmall"  name="number_of_fees" />
                                                <span class="text-danger fees_number_error" style="display: none"> <?php echo $this->lang->line('rates_max_90'); ?>  </span>
                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('rates_field_is_required'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_subject_enr'); ?></lable>:
                                            </div>
                                            <div class="col-md-6">
                                                <input  type="text" class="fees_subject form-control"  name="fees_subject" />
                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('rates_field_is_required'); ?></span>
                                            </div>
                                            <div class="col-md-2">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_amount_enr'); ?></lable>:
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="100" class="fees_amount form-control input-xsmall"  name="fees_amount" />

                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('rates_field_is_required'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <lable><?php echo '% '.$this->lang->line('rates_fees_enr'); ?></lable>:
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="100" class="fees_tax form-control input-xsmall" name="fees_tax" />

                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('tax_field_is_required'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_total_fees_enr'); ?></lable>:
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="100" disabled  class="fees_amount_tax form-control input-xsmall"  name="fees_amount_tax" />

                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('amount_tax_field_is_required'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_total_amount'); ?></lable>:
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="100" disabled class="fees_total_amount form-control input-xsmall"  name="fees_total_amount" />

                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('total_amount_tax_field_is_required'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_payment_date'); ?></lable>:
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="payment_date_first form-control " value="" name="payment_date_first" />
                                                <span class="validation_error text-danger" style="display: none"><?php echo $this->lang->line('rates_field_is_required'); ?></span>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-primary setToDay" ><?php echo $this->lang->line('rates_to_day'); ?></a>
                                            </div>
                                        </div>
                                        <div class="form-group row no_edit">
                                            <div class="col-md-4">
                                                <lable><?php echo $this->lang->line('rates_interval_between_fees'); ?></lable>:
                                            </div>
                                            <div class="col-md-6">
                                                <select name="interval_between_fees" class="form-control">
                                                    <option value="1"><?php echo $this->lang->line('rates_monthly');  ?></option>
                                                    <option value="2"><?php echo $this->lang->line('rates_bimonthly');  ?></option>
                                                    <option value="3"><?php echo $this->lang->line('rates_quarterly');  ?></option>
                                                    <option value="4"><?php echo $this->lang->line('rates_4_months');  ?></option>
                                                    <option value="6"><?php echo $this->lang->line('rates_6_months');  ?></option>
                                                    <option value="12"><?php echo $this->lang->line('rates_yearly');  ?></option>
                                                </select>
                                                <span class="validation_error" style="display: none"><?php echo $this->lang->line('rates_field_is_required'); ?></span>
                                            </div>
                                            <div class="col-md-2">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                                        <input type="submit" class="btn btn-primary addFee no_edit" name="add_fee" value="<?php echo $this->lang->line('rates_create'); ?>" />
                                        <input type="button" class="btn btn-primary editFee " style="display: none" name="edit_fee" value="<?php echo $this->lang->line('save'); ?>" />
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
<!--                        </form>-->
                    </div>
                </div>


            </div>

<script>
    var _fees = <?php echo json_encode($fees); ?>;

</script>
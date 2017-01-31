<div class="page-container prostpects_page">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_administrative'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_quotes'); ?>
                </li>
            </ul>
           <div class="tabs_container">
                <div class="card">
                    <div class="row ">
                        <div class="col-md-3 visible-sm visible-xs margin-bottom-20">
                            <div class="quotes_filter_section1 parent_tag" data-window="small">
                                <div class="filter_tags1">
                                    <h2><?php echo $this->lang->line('filter_by'); ?></h2>
                                    <div class="form-group">
                                        <label class="control-label select_doc_id_label text-left"><?php echo $this->lang->line('quotes_receipt_id');?>:</label>
                                        <input id="doc_id_select1" class="tags" type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_customer_name_label text-left"><?php echo $this->lang->line('quotes_customer_name');?>:</label>
                                        <input id="customer_name_select1" class="tags" type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_state_label text-left"><?php echo $this->lang->line('quotes_state');?>:</label>
                                        <input id="state_select1" class="tags" type="hidden" style="width: 100%" />
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label select_payment_type_label text-left"><?php echo $this->lang->line('quotes_payment_type');?>:</label>
                                        <input id="payment_type_select1" class="tags" type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group overf_hidden">
                                        <label class="control-label select_appointment_date_label text-left"><?php echo $this->lang->line('quotes_appointment_date');?>:</label>
                                        <!--                                                                <input id="appointment_date_select1" class="tags" type="hidden" style="width: 100%" />-->
                                        <div id="appointment_date_select1" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="quotestable_section">
                                <div class="text-right">
                                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                </div>
                                <div class="quick_tips_sidebar margin-top-20">
                                    <div class=" note note-info quick_tips_content">
                                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                        <p><?php echo $this->lang->line('quotes_quick_tips_text'); ?>
                                            <strong><a href="<?php echo $this->lang->line('quotes_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('quotes_quick_tips_link_text'); ?></a></strong>
                                        </p>
                                    </div>
                                </div>
                                <div id="quotesTable_no" class="no_data_table">
                                </div>
                                <div id="quotesTable"></div>
                             </div>
                        </div>
                        <div class="col-md-3 hidden-sm hidden-xs">
                            <div class="quotes_filter_section parent_tag"  data-window="big">
                                <div class="filter_tags">
                                    <h2><?php echo $this->lang->line('filter_by'); ?></h2>
                                    <div class="form-group">
                                        <label class="control-label select_doc_id_label text-left"><?php echo $this->lang->line('quotes_receipt_id');?>:</label>
                                        <input id="doc_id_select"  class="tags"  type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_customer_name_label text-left"><?php echo $this->lang->line('quotes_customer_name');?>:</label>
                                        <input id="customer_name_select"  class="tags"  type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_state_label text-left"><?php echo $this->lang->line('quotes_state');?>:</label>
                                        <input id="state_select"  class="tags"  type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label select_payment_type_label text-left"><?php echo $this->lang->line('quotes_payment_type');?>:</label>
                                        <input id="payment_type_select" class="tags"  type="hidden" style="width: 100%" />
                                    </div>
                                    <div class="form-group overf_hidden">
                                        <label class="control-label select_appointment_date_label text-left"><?php echo $this->lang->line('quotes_appointment_date');?>:</label>
                                        <!--                                                                <input id="appointment_date_select" class="tags" type="hidden" style="width: 100%" />-->
                                        <div id="appointment_date_select" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <div class="bulk_actions text-right" style="display:none;">
    <div class="btn-group ">
        <div class="dropdown  quote_actions">
            <a href="#" class="btn btn-primary btn-circle dropdown-toggle" data-toggle="dropdown"> <i
                    class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line(
                    "actions"
                ) ?> <span class="margin-left-3px caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" class="delete_quote"><?php echo $this->lang->line(
                            "quotes_delete_quotes"
                        ); ?></a></li>
                <li><a href="#" class="print_quotes"><?php echo $this->lang->line(
                            "quotes_print_quotes"
                        ); ?></a></li>
            </ul>
        </div>
    </div>
</div>
    <div class="modal fade" id="cashReceiptPrintModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('quotes_cash_quote'); ?></h4>
                </div>

                <div class="modal-body">
                    <h3><?php echo $this->lang->line('quotes_are_you_want_print_or_email'); ?></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button  class="btn blue cashQuotePrint"><?php echo $this->lang->line('print'); ?></button>
                    <button  class="btn btn-success cashQuotePrintAndEmail"><?php echo $this->lang->line('quotes_print_and_email'); ?></button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="invoiceReceiptPrintModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('quotes_invoice_a_quote'); ?></h4>
                </div>

                <div class="modal-body">
                    <h3><?php echo $this->lang->line('quotes_are_you_want_print_or_email'); ?></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <button  class="btn blue invoiceQuotePrint"><?php echo $this->lang->line('print'); ?></button>
                    <button  class="btn btn-success invoiceQuotePrintAndEmail"><?php echo $this->lang->line('quotes_print_and_email'); ?></button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="invoiceQuoteModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('quotes_invoice_a_quote'); ?></h4>
                </div>

                <div class="modal-body">
                    <h3><?php echo $this->lang->line('quotes_want_you_invoice_selected_quotes'); ?></h3>
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-success invoice_quote_modal" data-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                    <button  class="btn btn-danger close_modal"><?php echo $this->lang->line('no'); ?></button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


<script>
    //var _receipts = <?php echo isset($receipts) ? json_encode($receipts) : json_encode(array()); ?>;
    var  doc_id_data = <?php echo isset($doc_id_data) ? json_encode($doc_id_data) : json_encode(array()); ?>;
    var  customer_name_data = <?php echo isset($customer_name_data) ? json_encode($customer_name_data) : json_encode(array()); ?>;
    var  state_data = <?php echo isset($state_data) ? json_encode($state_data) : json_encode(array()); ?>;
    var  payment_type_data = <?php echo isset($payment_type_data) ? json_encode($payment_type_data) : json_encode(array()); ?>;
</script>
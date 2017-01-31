<div class="page-container ">
    <div class="table_loading"></div>
        <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                        <!-- BEGIN PAGE CONTENT INNER -->
                    <ul class=" page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('menu_administrative'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_manage_invoices'); ?>
                        </li>
                    </ul>
                    <div class="tabs_container">
                                    <div class="card">
                                        <div class="row tab-content_prospect">
                                            <div class="col-md-3 visible-sm visible-xs margin-bottom-20">
                                                <div class="invoices_filter_section1 parent_tag" data-window="small">
                                                    <div class="filter_tags1">
                                                        <h2><?php echo $this->lang->line('filter_by'); ?></h2>
                                                        <div class="form-group">
                                                            <label class="control-label select_doc_id_label text-left"><?php echo $this->lang->line('mi_invoice_id');?>:</label>
                                                            <input id="invoice_id_select1" class="tags" type="hidden" style="width: 100%" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label select_customer_name_label text-left"><?php echo $this->lang->line('mi_customer_name');?>:</label>
                                                            <input id="customer_name_select1" class="tags" type="hidden" style="width: 100%" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label select_payment_type_label text-left"><?php echo $this->lang->line('mi_doc_type');?>:</label>
                                                            <input id="doc_type_select1" class="tags" type="hidden" style="width: 100%" />
                                                        </div>
                                                        <div class="form-group overf_hidden">
                                                            <label class="control-label select_appointment_date_label text-left"><?php echo $this->lang->line('date');?>:</label>
                                                            <!--<input id="appointment_date_select1" class="tags" type="hidden" style="width: 100%" />-->
                                                            <div id="date_select1" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                                <span></span> <b class="caret"></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 ">
                                                <div class="invoicesTable_section">
                                                    <div class="text-right">
                                                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                                                    </div>
                                                    <div class="quick_tips_sidebar margin-top-20">
                                                        <div class=" note note-info quick_tips_content">
                                                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                                            <p><?php echo $this->lang->line('manage_invoices_quick_tips_text'); ?> 
                                                                <strong><a href="<?php echo $this->lang->line('manage_invoices_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('manage_invoices_quick_tips_link_text'); ?></a></strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div  class="no_data_table" style="display: none"></div>
                                                    <div id="invoicesTable" ></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 hidden-sm hidden-xs">
                                                <div class="invoices_filter_section1 parent_tag" data-window="big">
                                                    <div class="filter_tags">
                                                        <h2><?php echo $this->lang->line('filter_by'); ?></h2>
                                                        <div class="form-group">
                                                            <label class="control-label select_doc_id_label text-left"><?php echo $this->lang->line('mi_invoice_id');?>:</label>
                                                            <input id="invoice_id_select" class="tags" type="hidden" style="width: 100%" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label select_customer_name_label text-left"><?php echo $this->lang->line('quotes_customer_name');?>:</label>
                                                            <input id="customer_name_select" class="tags" type="hidden" style="width: 100%" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label select_payment_type_label text-left"><?php echo $this->lang->line('mi_doc_type');?>:</label>
                                                            <input id="doc_type_select" class="tags" type="hidden" style="width: 100%" />
                                                        </div>
                                                        <div class="form-group overf_hidden">
                                                            <label class="control-label select_appointment_date_label text-left"><?php echo $this->lang->line('date');?>:</label>
                                                            <!--<input id="appointment_date_select1" class="tags" type="hidden" style="width: 100%" />-->
                                                            <div id="date_select" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
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
                    <div class="dropdown  invoices_actions">
                        <a href="#" class="btn btn-primary btn-circle dropdown-toggle" data-toggle="dropdown"> <i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line(
                                "actions"
                            ) ?> <span class="margin-left-3px caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" class="delete_invoices"><?php echo $this->lang->line(
                                        "mi_delete_invoices"
                                    ); ?></a></li>
                            <li><a href="#" class="print_invoices_multy_select"><?php echo  $this->lang->line('print').' '.$this->lang->line(
                                        "mi_invoices"
                                    ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

<script>
//    var _invoices = <?php //echo isset($invoices) ? json_encode($invoices) : json_encode(array()); ?>//;
    var  invoice_id_data = <?php echo isset($invoice_id_data) ? json_encode($invoice_id_data) : json_encode(array()); ?>;
    var  customer_name_data = <?php echo isset($customer_name_data) ? json_encode($customer_name_data) : json_encode(array()); ?>;
    var  doc_type_data = <?php echo isset($doc_type_data) ? json_encode($doc_type_data) : json_encode(array()); ?>;
    var _select_name_id;
</script>
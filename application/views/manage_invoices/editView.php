<div class="page-container">
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
                            <li>
                                <a href="<?php echo $_base_url; ?>manage_invoices"><?php echo $this->lang->line('menu_manage_invoices'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('edit'); ?>
                            </li>
                        </ul>
                        <div class="portlet light">
                            <div class="box sections">
                                    <div class="portlet-body">
                                        <div  id="invoice_section">
                                            <!--personal data-->
                                            <div class="col-sm-6 padding-bottom-60">
                                                <h3><?php echo $this->lang->line('mi_personal_data'); ?>:</h3>
                                                <ul class="list-unstyled">
                                                    <li> <?php echo $this->lang->line('mi_customer_name'); ?>: <span><?php echo $personal_data->customer_name; ?></span> </li>
                                                    <li> <?php echo $this->lang->line('mi_customer_cif'); ?>: <span><?php echo $personal_data->customer_cif; ?></span> </li>
                                                    <li> <?php echo $this->lang->line('mi_customer_address'); ?>: <span><?php echo $personal_data->customer_address; ?></span> </li>
                                                    <li> <?php echo $this->lang->line('mi_customer_city'); ?>: <span><?php echo $personal_data->customer_city; ?></span> </li>
                                                    <li> <?php echo $this->lang->line('mi_customer_phones'); ?>: <span><?php echo $personal_data->customer_phones; ?></span> </li>
                                                </ul>
                                                <div class="form-group back_save_group manage_invoices_edit_back">
                                                    <a href="<?php echo $_base_url; ?>manage_invoices" class="hidden-xs btn btn-circle btn-default-back  back_system_settigs pull-left"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h3><?php echo $this->lang->line('mi_details'); ?>:</h3>
                                                <ul class="list-unstyled">
                                                    <li><?php echo $this->lang->line('mi_invoice_date'); ?>: <span><?php echo date($datepicker_format, strtotime($details->invoice_date)); ?></span> </li>
                                                    <li> <?php echo $this->lang->line('mi_doc_type'); ?>:
                                                        <span><?php
                                                        if($details->doc_type == "F"){
                                                            echo $this->lang->line('mi_doc_type_invoice');
                                                        }else{
                                                            echo $this->lang->line('mi_doc_type_negative_invoice');
                                                        }
                                                        ?></span>
                                                    </li>
                                                    <li> <?php echo $this->lang->line('mi_state'); ?>:
                                                        <span><?php
                                                        if($details->state == "p"){
                                                            echo $this->lang->line('mi_remaining');
                                                        }elseif($details->state == "c"){
                                                            echo $this->lang->line('mi_cashed');
                                                        }elseif($details->state == "pc"){
                                                            echo $this->lang->line('mi_parcial_cashed');
                                                        }
                                                        ?></span>
                                                    </li>
                                                    <li>
                                                        <?php echo $this->lang->line('mi_amount'); ?>: <span><?php echo round($details->amount, 2); ?></span>
                                                    </li>

                                                </ul>
                                                <?php
                                                    if($details->state != "c"){ ?>
                                                        <form method="post" class="form-horizontal" id="edit_invoice_details">
                                                            <input type="hidden" name="old_enroll_id" value="<?php echo $details->enroll_id; ?>">
                                                        <div >
                                                            <lable class="control-label text-left" for="payment_method"><?php echo $this->lang->line("mi_payment_method"); ?>: </lable>
                                                            <div class="circle_select_div">
                                                                <select  name="payment_method" id="payment_method" class="form-control">
                                                                    <option value="">--<?php echo $this->lang->line('select') ?>--</option>
                                                                    <?php foreach ($payment_methods as $payment_method_k=>$payment_method_item){ ?>
                                                                        <option value="<?php echo $payment_method_k;?>" <?php if($payment_method_k == $details->payment_method){echo 'selected="selected"';}?>><?php echo $payment_method_item;?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php if($enrollments){ ?>
                                                        <div>
                                                            <lable class="control-label text-left" for="enroll_id"><?php echo $this->lang->line("mi_enroll_id"); ?> (<?php echo $this->lang->line('optional'); ?>): </lable>
                                                            <div class="circle_select_div">
                                                                <select name="enroll_id" id="enroll_id" class="form-control">
                                                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                                    <?php foreach ($enrollments as $enrollment_item){ ?>
                                                                        <option value="<?php echo $enrollment_item->enroll_id;?>" <?php if($enrollment_item->enroll_id == $details->enroll_id){echo 'selected="selected"';}?>><?php echo $enrollment_item->enroll_id;?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php }else{?>
                                                            <input type="hidden" name="enroll_id" value="">
                                                        <?php }?>
                                                            <div class="form-group back_save_group text-right">
                                                                <button type="submit" class="btn btn-primary btn-circle "> <i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $this->lang->line('save'); ?></button>
                                                                <button type="button" class=" btn btn-default tamplate_print  btn-default btn-circle" id="print_invoice"> <i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                                                                <a href="<?php echo $_base_url; ?>manage_invoices" class="visible-xs btn btn-circle btn-default-back  back_system_settigs pull-left"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>
                                                            </div>
                                                        </form>
                                                    <?php }else{ ?>

                                                        <div class="form-group">
                                                            <span><?php echo $this->lang->line('mi_payment_method'); ?></span>:
                                                            <?php
                                                                $payment_method = "";
                                                                switch ($details->payment_method){
                                                                    case "0":
                                                                        $payment_method = $this->lang->line('quotes_cash');
                                                                        break;
                                                                    case "1":
                                                                        $payment_method = $this->lang->line('quotes_credit_card');
                                                                        break;
                                                                    case "2":
                                                                        $payment_method = $this->lang->line('quotes_direct_debit');
                                                                        break;
                                                                    case "3":
                                                                        $payment_method = $this->lang->line('quotes_transfer');
                                                                        break;
                                                                    case "4":
                                                                        $payment_method = $this->lang->line('quotes_check');
                                                                        break;
                                                                    case "5":
                                                                        $payment_method = $this->lang->line('quotes_financed');
                                                                        break;
                                                                    case "6":
                                                                        $payment_method = $this->lang->line('quotes_online_payment');
                                                                        break;
                                                                }
                                                            echo $payment_method;
                                                            ?>
                                                        </div>
                                                <?php } ?>
                                                
                                            </div>
                                        </div>
                                        <div class="no_servicesTable" style="display: none;"></div>
                                        <div id="servicesTable"></div>
                                        <div class="no_quotesTable" style="display: none;"></div>
                                        <div id="quotesTable"><?php //printr($quotes);?></div>

                                    </div>

                                    <div class="clearfix"></div>

                            </div>
                            <!-- BEGIN QUICK SIDEBAR -->
                            <!-- END QUICK SIDEBAR -->
                        </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>

<script>
    var _personal_data = <?php echo isset($personal_data) ? json_encode($personal_data) : json_encode(array()); ?>;
    var _details_data = <?php echo isset($details) ? json_encode($details) : json_encode(array()); ?>;
    var _services = <?php echo isset($services) ? json_encode($services) : json_encode(array()); ?>;
    var _quotes = <?php echo isset($quotes) ? json_encode($quotes) : json_encode(array()); ?>;
    var  _invoice_id = <?php echo isset($invoice_id) ? $invoice_id : null; ?>;
</script>
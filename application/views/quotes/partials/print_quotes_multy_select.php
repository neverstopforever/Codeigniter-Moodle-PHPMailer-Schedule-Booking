<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <?php $this->load->view("includes/print/head"); ?>
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid">
<!-- BEGIN HEADER -->

<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">

            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">

                <div class="page-content-inner">
                    <?php foreach($quotes as $quote){ ?>
                        <div class="invoice">
                        <div class="row invoice-logo">
                            <div class="col-xs-6 invoice-logo-space" >
                                 <img src="<?php echo $logo; ?>" class="img-responsive" alt="" />
                                <h3><?php echo $this->lang->line('fiscal_data'); ?></h3>
                                <ul class="list-unstyled">
                                    <li> <?php echo $this->lang->line('fiscal_name'); ?>: <?php echo $fiscal_data->fiscal_name; ?> </li>
                                    <li> <?php echo $this->lang->line('address'); ?>: <?php echo $fiscal_data->address; ?> </li>
                                    <li> <?php echo $this->lang->line('city'); ?>: <?php echo $fiscal_data->city; ?> </li>
                                    <li> <?php echo $this->lang->line('province'); ?>: <?php echo $fiscal_data->province; ?> </li>
                                    <li> <?php echo $this->lang->line('postal_code'); ?>: <?php echo $fiscal_data->postal_code; ?> </li>
                                    <li> <?php echo $this->lang->line('phone'); ?>: <?php echo $fiscal_data->phone; ?> </li>
                                    <li> <?php echo $this->lang->line('country'); ?>: <?php echo $fiscal_data->country; ?> </li>
                                    <li> <?php echo $this->lang->line('fiscal_code'); ?>: <?php echo $fiscal_data->fiscal_code; ?> </li>
                                </ul>
                            </div>
                            <div class="col-xs-6" >
                                <p class="uppercase"> <?php echo $this->lang->line('quotes_receipt'); ?></p>
                                <p>#<?php echo $quote->quote_id ?></p>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-6" style="">
                                <h3><?php echo $this->lang->line('mi_personal_data'); ?>:</h3>
                                <ul class="list-unstyled">
                                    <li> <?php echo $this->lang->line('mi_customer_name'); ?>: <?php echo $quote->customer_name; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_cif'); ?>: <?php echo $quote->customer_postalcode; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_address'); ?>: <?php echo $quote->customer_address; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_city'); ?>: <?php echo $quote->customer_city; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_phones'); ?>: <?php echo $quote->customer_phones; ?> </li>
                                </ul>
                            </div>
                            <div class="col-xs-6" style="">
                                <h3><?php echo $this->lang->line('mi_details'); ?>:</h3>
                                <ul class="list-unstyled">
                                    <!--                                    <li>--><?php //echo $this->lang->line('quotes_appointment_date'); ?><!--: --><?php //echo date($datepicker_format, strtotime($receipt->appointment_date)); ?><!-- </li>-->
                                    <li> <?php echo $this->lang->line('mi_doc_type'); ?>:
                                        <?php
                                        if($quote->invoice_id){
                                            //echo $this->lang->line('mi_doc_type_invoice');
                                        }else{
                                            // echo $this->lang->line('mi_doc_type_negative_invoice');
                                        }
                                        ?>
                                    </li>
                                    <li> <?php echo $this->lang->line('mi_state'); ?>:
                                        <?php
                                        $state = '';
                                        switch ($quote->state){
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
                                    </li>
                                    <li>
                                        <?php echo $this->lang->line('mi_amount'); ?>: <?php echo round($quote->amount, 2); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->lang->line('mi_payment_method'); ?>:
                                        <?php
                                        $payment_method = "";
                                        switch ($quote->payment_method){
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
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <h3><?php echo $this->lang->line('mi_quotes'); ?>:</h3>
                                <table class="table table-striped table-hover" >
                                    <tbody>
                                    <tr class="table_head">
                                        <td ><?php echo $this->lang->line('mi_quote_id'); ?> </td>
                                        <td ><?php echo $this->lang->line('mi_reference'); ?> </td>
                                        <td > <?php echo $this->lang->line('date'); ?> </td>
                                        <td > <?php echo $this->lang->line('amount'); ?> </td>
                                        <td > <?php echo $this->lang->line('quotes_discount_to_apply'); ?> </td>
                                        <td > <?php echo $this->lang->line('mi_total_amount'); ?> </td>
                                        <td > <?php echo $this->lang->line('mi_payment_method'); ?> </td>
                                        <td > <?php echo $this->lang->line('mi_state'); ?> </td>
                                    </tr>
                                    <?php

                                    if($this->data['lang'] == "spanish"){
                                        setlocale(LC_MONETARY, 'es_ES.utf8');
                                    }else{
                                        setlocale(LC_MONETARY, 'en_GB.utf8');
                                    }

                                    $grand_total = 0;
                                    $sub_total_amount = 0;
                                    $total_discount = 0;

                                    if(isset($quote->amount) && $quote->amount != 0){
                                        $discount = $quote->total_amount != 0 ? ((($quote->amount - $quote->total_amount)  * 100) / $quote->total_amount) : 0;
                                        $discount = round($discount, 3);
                                    }else{
                                        $discount = 0;
                                    }
                                    $discount = money_format('%!n', round($discount, 3)) . "%";
                                    $sub_total_amount += $quote->amount;
                                    $grand_total += $quote->total_amount;

                                    $amount = money_format('%!n', round($quote->amount, 3));
                                    $total_amount = money_format('%!n', round($quote->total_amount, 3));
                                    //                                      ?>
                                    <tr>
                                        <td > <?php echo $quote->quote_id;?> </td>
                                        <td > <?php echo $quote->reference;?> </td>
                                        <td > <?php echo date($datepicker_format, strtotime($quote->due_date));?> </td>

                                        <td > <?php echo $amount;?> </td>
                                        <td > <?php echo $discount;?> </td>
                                        <td > <?php echo $total_amount;?> </td>
                                        <td > <?php
                                            $payment_method = '';
                                            switch ($quote->payment_method){
                                                case 0:
                                                    $payment_method = $this->lang->line('quotes_cash');
                                                    break;
                                                case 1:
                                                    $payment_method = $this->lang->line('quotes_credit_card');
                                                    break;
                                                case 2:
                                                    $payment_method = $this->lang->line('quotes_direct_debit');
                                                    break;
                                                case 3:
                                                    $payment_method = $this->lang->line('quotes_transfer');
                                                    break;
                                                case 4:
                                                    $payment_method = $this->lang->line('quotes_check');
                                                    break;
                                                case 5:
                                                    $payment_method = $this->lang->line('quotes_financed');
                                                    break;
                                                case 6:
                                                    $payment_method = $this->lang->line('quotes_online_payment');
                                                    break;
                                            }
                                            echo $payment_method;
                                            ?>
                                        </td>
                                        <td > <?php
                                            $state = '';
                                            switch ($quote->state){
                                                case 0:
                                                    $state = $this->lang->line('quotes_due');
                                                    break;
                                                case 1:
                                                    $state = $this->lang->line('quotes_cashed');
                                                    break;
                                                case 2:
                                                    $state = $this->lang->line('quotes_return_receipt');
                                                    break;
                                                case 3:
                                                    $state = $this->lang->line('quotes_detained');
                                                    break;
                                            }
                                            echo $state;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    if($grand_total != 0){
                                        $total_discount = ($sub_total_amount / $grand_total) * 100 - 100;
                                    }else{
                                        $total_discount = 0;
                                    }
                                    $total_discount = money_format('%!n', round($total_discount, 3));
                                    $sub_total_amount = money_format('%!n', round($sub_total_amount, 3));
                                    $grand_total = money_format('%!n', round($grand_total, 3));

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="well">

                                </div>
                            </div>
                            <div class="col-xs-8 invoice-block">
                                <ul class="list-unstyled amounts">
                                    <li>
                                        <strong><?php echo $this->lang->line('mi_sub_total_amount'); ?>:</strong> <?php echo $sub_total_amount;?> </li>
                                    <li>
                                        <strong><?php echo $this->lang->line('quotes_discount_to_apply'); ?>:</strong> <?php echo $total_discount . "%";?> </li>
                                    <li>
                                        <strong><?php echo $this->lang->line('mi_grand_total'); ?>:</strong> <?php echo $grand_total;?>  </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                        <div class="quotes_page"></div>
                    <?php } ?>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END PAGE CONTENT BODY -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<style>
    @media print {
        .quotes_page {page-break-after: always;}
    }
    .table-striped tr.table_head td{
        border-top: none;
        font-weight: 600;
    }
</style>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php $this->load->view("includes/print/footer"); ?>
<script>
    setTimeout(function () {
     window.print();
     window.close();
     }, 500);
</script>
</body>
</html>
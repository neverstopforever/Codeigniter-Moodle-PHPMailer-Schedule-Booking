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



                <!-- END PAGE TOOLBAR -->
            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">

                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <?php if(!empty($personal_datas)){ ?>
                        <?php foreach($personal_datas as $personal_data){ ?>
                            <div class="invoice">
                        <div class="row invoice-logo">
                            <div class="col-xs-6 invoice-logo-space">
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
                            <div class="col-xs-6">
                                <p class="uppercase"> <?php echo $this->lang->line('invoice'); ?>
                                    <span class="muted"> <?php echo $personal_data->invoice_id; ?> </span>
                                </p>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-6">
                                <h3><?php echo $this->lang->line('mi_personal_data'); ?>:</h3>
                                <ul class="list-unstyled">
                                    <li> <?php echo $this->lang->line('mi_customer_name'); ?>: <?php echo $personal_data->customer_name; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_cif'); ?>: <?php echo $personal_data->customer_cif; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_address'); ?>: <?php echo $personal_data->customer_address; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_city'); ?>: <?php echo $personal_data->customer_city; ?> </li>
                                    <li> <?php echo $this->lang->line('mi_customer_phones'); ?>: <?php echo $personal_data->customer_phones; ?> </li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <h3><?php echo $this->lang->line('mi_details'); ?>:</h3>
                                <ul class="list-unstyled">
                                    <li><?php echo $this->lang->line('mi_invoice_date'); ?>: <?php echo date($datepicker_format, strtotime($details_by_invoce_id[$personal_data->invoice_id]->invoice_date)); ?> </li>
                                    <li> <?php echo $this->lang->line('mi_doc_type'); ?>:
                                        <?php
                                        if($details_by_invoce_id[$personal_data->invoice_id]->doc_type == "F"){
                                            echo $this->lang->line('mi_doc_type_invoice');
                                        }else{
                                            echo $this->lang->line('mi_doc_type_negative_invoice');
                                        }
                                        ?>
                                    </li>
                                    <li> <?php echo $this->lang->line('mi_state'); ?>:
                                        <?php
                                        if($details_by_invoce_id[$personal_data->invoice_id]->state == "p"){
                                            echo $this->lang->line('mi_remaining');
                                        }elseif($details_by_invoce_id[$personal_data->invoice_id]->state == "c"){
                                            echo $this->lang->line('mi_cashed');
                                        }elseif($details_by_invoce_id[$personal_data->invoice_id]->state == "pc"){
                                            echo $this->lang->line('mi_parcial_cashed');
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php echo $this->lang->line('mi_amount'); ?>: <?php echo round($details_by_invoce_id[$personal_data->invoice_id]->amount, 2); ?>
                                    </li>
                                    <li> <?php
                                        if($details_by_invoce_id[$personal_data->invoice_id]->state != "c"){ ?>
                                                <?php echo $this->lang->line("mi_payment_method"); ?>:
                                                    <?php foreach ($payment_methods as $payment_method_k=>$payment_method_item){
                                                        if($payment_method_k == $details_by_invoce_id[$personal_data->invoice_id]->payment_method){
                                                            echo $payment_method_item;
                                                            break;
                                                        }
                                                        ?>
                                                    <?php }?>
                                        <?php }else{ ?>
                                                <?php echo $this->lang->line('mi_payment_method'); ?>:
                                                <?php
                                                $payment_method = "";
                                                switch ($details_by_invoce_id[$personal_data->invoice_id]->payment_method){
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
                                        <?php } ?>
                                        </li>
                                    <li>
                                        <?php
                                        if($details_by_invoce_id[$personal_data->invoice_id]->state != "c"){ ?>
                                        <?php if($enrollments){ ?>
                                            <?php echo $this->lang->line("mi_enroll_id"); ?> (<?php echo $this->lang->line('optional'); ?>):
                                            <?php foreach ($enrollments as $enrollment_item){
                                                if($enrollment_item->enroll_id == $details_by_invoce_id[$personal_data->invoice_id]->enroll_id){
                                                    echo $enrollment_item->enroll_name;
                                                }
                                                ?>
                                            <?php }?>
                                        <?php } ?>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="">
                            <div class="">
                                <h3><?php echo $this->lang->line('mi_services'); ?>:</h3>
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr class="table_head">
                                        <td><?php echo $this->lang->line('id'); ?> </td>
                                        <td><?php echo $this->lang->line('mi_reference'); ?> </td>
                                        <td> <?php echo $this->lang->line('mi_price_by_unit'); ?> </td>
                                        <td> <?php echo $this->lang->line('mi_units'); ?> </td>
                                        <td> <?php echo $this->lang->line('mi_vat'); ?> </td>
                                        <td> <?php echo $this->lang->line('mi_total_amount'); ?> </td>
                                    </tr>
                                    <?php

                                    if($this->data['lang'] == "spanish"){
                                        setlocale(LC_MONETARY, 'es_ES.utf8');
                                    }else{
                                        setlocale(LC_MONETARY, 'en_GB.utf8');
                                    }

                                    $grand_total = 0;
                                    $sub_total_amount = 0;
                                    $total_vat = 0;
                                    if(!empty($services_by_invoce_id[$personal_data->invoice_id]) && isset($services_by_invoce_id[$personal_data->invoice_id])) {
                                        foreach ($services_by_invoce_id[$personal_data->invoice_id] as $service) {
                                            $sub_total_amount += ($service->price_by_unit * $service->units);
                                            $service_total_amount = (($service->units * $service->price_by_unit) * $service->percent_vat) / 100 + ($service->price_by_unit * $service->units);
                                            $grand_total += $service_total_amount;

                                            $units = money_format('%!n', round($service->units, 3));
                                            $price_by_unit = money_format('%!n', round($service->price_by_unit, 3));
                                            $vat = money_format('%!n', round($service->percent_vat, 3)) . "%";

                                            $service_total_amount = money_format('%!n', round($service_total_amount, 3));


                                            ?>
                                            <tr>
                                                <td> <?php echo $service->id; ?> </td>
                                                <td> <?php echo $service->reference; ?> </td>
                                                <td> <?php echo $price_by_unit; ?> </td>
                                                <td> <?php echo $units; ?> </td>
                                                <td> <?php echo $vat; ?> </td>
                                                <td> <?php echo $service_total_amount; ?> </td>
                                            </tr>
                                        <?php }
                                    }
                                    if($sub_total_amount != 0){
                                        $total_vat = ($grand_total / $sub_total_amount) * 100 - 100;
                                    }else{
                                        $total_vat = 0;
                                    }
                                    $total_vat = money_format('%!n', round($total_vat, 3));
                                    $sub_total_amount = money_format('%!n', round($sub_total_amount, 3));
                                    $grand_total = money_format('%!n', round($grand_total, 3));

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
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
                                        <strong><?php echo $this->lang->line('mi_vat'); ?>:</strong> <?php echo $total_vat . "%";?> </li>
                                    <li>
                                        <strong><?php echo $this->lang->line('mi_grand_total'); ?>:</strong> <?php echo $grand_total;?>  </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                            <div class="invoice_page"></div>
                        <?php } ?>
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
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php $this->load->view("includes/print/footer"); ?>
<style>
    @media print {
        .invoice_page {page-break-after: always;}
    }
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    .table-striped tr.table_head td{
        border-top: none;
        font-weight: 600;
    }
</style>
<script>
    setTimeout(function () {
        window.print();
        window.close();
    }, 500);

//    window.close();
</script>
</body>
</html>
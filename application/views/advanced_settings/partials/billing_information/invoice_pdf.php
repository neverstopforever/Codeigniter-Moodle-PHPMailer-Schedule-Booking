<div class="page-container prostpects_page">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE CONTENT INNER -->
            <?php if (isset($invoice)){ ?>
                <?php if($this->data['lang'] == "spanish"){
                    setlocale(LC_MONETARY, 'es_ES.utf8');
                }else{
                    setlocale(LC_MONETARY, 'en_GB.utf8');
                }
                $qty_text = money_format('%!n', round($invoice->qty, 3));
                $price_text = money_format('%!n', round($invoice->price / 100, 3));
                $subtotal_text = money_format('%!n', round($invoice->price / 100 * $invoice->qty, 3));
                ?>

                <div class="portlet light">
                    <div class="invoice ">
                        <div class="invoice-content-2 ">
                            <div class="row invoice-head">
                                <div class="col-sm-6 margin-bottom-20">
                                    <img src="<?php echo @$customer_logo; ?>" />
                                </div>
                                <div class="col-sm-6 margin-bottom-20">
                                    <?php if (isset($success)){?>
                                        <div class="row" >
                                            <div class="col-xs-12 col-centered">
                                                <h4 class="text-right">
                                                    <?php echo $success; ?>
                                                </h4>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($errors)){?>
                                        <div class="row hidden-print">
                                            <div class="col-xs-12 col-centered">
                                                <h4 class="text-right">
                                                    <?php foreach($errors as $error) {
                                                        echo $error . "<br />";
                                                    }?>
                                                </h4>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="col-sm-7 col-xs-12">
                                    <div class="invoice-logo">
                                        <h2 ><?php echo $invoice->title; ?></h2>
                                    </div>
                                </div>
                                <div class="col-sm-5 col-xs-12">
                                    <div class="company-address">
                                        <span class="bold uppercase"> <?php echo $this->lang->line('paymentsystem_softaula_SLU');?></span>
                                        <br/> <?php echo $this->lang->line('paymentsystem_cif');?>
                                        <br/> <?php echo $this->lang->line('paymentsystem_CTarragona');?>
                                        <br/> <?php echo $this->lang->line('paymentsystem_08014_Barcelona');?>
                                        <br/>
                                        <span class="bold"><?php echo $this->lang->line('paymentsystem_T');?></span>  <?php echo $this->lang->line('paymentsystem_TEL');?>
                                        <br/>
                                        <span class="bold"><?php echo $this->lang->line('paymentsystem_E');?></span> <?php echo $this->lang->line('paymentsystem_email');?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            //printr($this->data['company']);die;?>
                            <div class="row invoice-cust-add">
                                <div class="col-xs-12 col-sm-3">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_customer');?></h2>
                                    <p class="invoice-desc"><?php echo isset($company->commercial_name) ? $company->commercial_name : null; ?><br>
                                        <?php echo isset($company->address) ? $company->address : null; ?> <br>
                                        <?php echo isset($company->phone) ? $company->phone : null; ?> <br>
                                        <?php echo isset($company->email) ? $company->email : null; ?> <br>
                                    </p>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_date');?></h2>
                                    <p class="invoice-desc">
                                        <?php
                                        if($invoice->updated_at){
                                            echo date($datepicker_format, strtotime($invoice->updated_at));
                                        }else{
                                            echo date($datepicker_format, strtotime($invoice->created_at));
                                        }

                                        ?> </p>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_invoice_id');?></h2>
                                    <p class="invoice-desc">
                                        <?php echo $payment_perfix->credit_card.'-'.$invoice->id; ?>
                                       </p>
                                </div>
                                <!--                                        <div class="col-xs-12 col-sm-6">-->
                                <!---->
                                <!--                                            <h2 class="invoice-title uppercase">--><?php //echo $this->lang->line('address');?><!--</h2>-->
                                <!--                                            <p class="invoice-desc inv-address">--><?php //echo $owner->customer_address; ?><!--</p>-->
                                <!--                                        </div>-->
                            </div>

                            <div class="row invoice-body">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="invoice-title uppercase"><?php echo $this->lang->line('description');?></th>
                                            <th class="invoice-title uppercase text-center"><?php echo $this->lang->line('paymentsystem_qty');?></th>
                                            <th class="invoice-title uppercase text-center"><?php echo $this->lang->line('paymentsystem_rate_price');?></th>
                                            <th class="invoice-title uppercase text-center"><?php echo $this->lang->line('paymentsystem_sub_total');?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>
                                                <h3><?php echo $invoice->title; ?></h3>
                                                <p> <?php echo $invoice->description; ?> </p>
                                            </td>
                                            <td class="text-center sbold"><?php echo $qty_text; ?></td>
                                            <td class="text-center sbold"><?php echo $price_text; ?></td>
                                            <td class="text-center sbold"><?php echo $subtotal_text; ?></td>
                                        </tr>
                                        <?php if($invoice->coupon_id && !empty($_coupon)) {
                                            $coupon_discount = 0;
                                            if($_coupon->discount){
                                                $coupon_discount = $_coupon->discount;
                                            }elseif($_coupon->percent_off){
                                                $coupon_discount = ($invoice->price / 100) * $_coupon->percent_off / 100;
                                            }
                                            $coupon_discount_text = money_format('%!n', round($coupon_discount, 3));
                                            ?>
                                            <tr>
                                                <td>
                                                    <h3><?php echo $this->lang->line('paymentsystem_coupon');?></h3>
                                                    <p><?php echo $_coupon->title; ?></p>
                                                </td>
                                                <td class="text-center sbold">1</td>
                                                <td class="text-center sbold">-<?php echo $coupon_discount_text; ?></td>
                                                <td class="text-center sbold">-<?php echo $coupon_discount_text; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <?php
                            //                                    $tax = ($invoice->price / 100 * $invoice->vat) / 100;
                            if (!$invoice->coupon_id) {
                                $sub_total = ($invoice->price / 100 * $invoice->qty);
                            }else{
                                $coupon_discount = 0;
                                if(!empty($_coupon)){
                                    if($_coupon->discount){
                                        $coupon_discount = $_coupon->discount;
                                    }elseif($_coupon->percent_off){
                                        $coupon_discount = ($invoice->price / 100) * $_coupon->percent_off / 100;
                                    }
                                }
                                $sub_total = (($invoice->price / 100 * $invoice->qty) - $coupon_discount);
                            }
                            $tax = ($sub_total * $invoice->vat) / 100;
                            $total = $sub_total + $tax;
                            ?>
                            <div class="row invoice-subtotal hidden-print">
                                <div class="col-xs-3">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_subtotal');?></h2>
                                    <p class="invoice-desc"><?php echo money_format('%!n', round($sub_total, 3)); ?></p>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_tax');?> (<?php echo $invoice->vat; ?>%)</h2>
                                    <p class="invoice-desc"><?php echo money_format('%!n', round($tax, 3)); ?></p>
                                </div>
                                <div class="col-xs-6">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_total');?></h2>
                                    <p class="invoice-desc grand-total"><?php echo money_format('%!n', round($total, 3)); ?></p>
                                </div>

                            </div>
                            <div class="row invoice-subtotal visible-print">
                                <div class="col-xs-6 text-right">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_subtotal');?></h2>
                                    <p class="invoice-desc"><?php echo money_format('%!n', round($sub_total, 3)); ?></p>
                                </div>
                                <div class="col-xs-3 text-right">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_tax');?> (<?php echo $invoice->vat; ?>%)</h2>
                                    <p class="invoice-desc"><?php echo money_format('%!n', round($tax, 3)); ?></p>
                                </div>
                                <div class="col-xs-3 text-right">
                                    <h2 class="invoice-title uppercase"><?php echo $this->lang->line('paymentsystem_total');?></h2>
                                    <p class="invoice-desc grand-total"><?php echo money_format('%!n', round($total, 3)); ?></p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            <?php } ?>
            <!-- END PAGE CONTENT INNER -->

        </div>
    </div>
</div>
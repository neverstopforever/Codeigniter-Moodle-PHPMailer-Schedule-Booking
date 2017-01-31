<div class="container  manage_page">
        <?php if (isset($invoice)) { ?>

        <?php if($this->session->has_userdata('success')){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            </div>
        <?php }?>
        <?php if($this->session->has_userdata('errors')){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-danger" role="alert">
                    <?php
                        $flash_errors = $this->session->flashdata('errors');
                        foreach($flash_errors as $flash_error) {
                            echo $flash_error . "<br />";
                        }
                    ?>
                </div>
            </div>
        <?php }?>
<!-- for Stripe-->
        <div style="display: none;" class="row" id="paymentErrors">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="paymentError" class="alert alert-danger" role="alert">

                </div>
            </div>
        </div>
        <div style="display: none;" class="row" id="paymentSuccesses">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="paymentSuccess" class="alert alert-success" role="alert">

                </div>
            </div>
        </div>
<!--        for Stripe/ -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="container_heading text-center">
                    <span>
                        <?php echo $invoice->title; ?>
                        <?php echo ($invoice->price - $discount) / 100 . " &pound;" ;?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
<!--                Stripe -->
                <?php if (isset($owner) && isset($owner->stripe_customer_id)) {?>
                <button class="btn btn-primary" id="stripePayment1">Pay with Card</button>
                <?php }else{?>
                <button class="btn btn-primary" id="stripePayment2">Pay with Card</button>
               <?php }?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
                <form action="/paymentsystem/paypal" method="post">
                    <input type="hidden" name="invoice_id" value="<?php echo $invoice->id;?>">
                    <button type="submit" class="btn btn-primary">Pay with PayPal</button>
                </form>
            </div>
        </div>
        <script>
            function paymentError(error) {
                var errors = $('#paymentErrors');
                var errorText = $('#paymentError');

                if (error === false) {
                    errors.hide();
                } else {
                    errors.show();
                    errorText.html(error);
                    paymentSuccess(false);
                }

            }

            function paymentSuccess(success) {
                var successes = $('#paymentSuccesses');
                var successText = $('#paymentSuccess');

                if (success === false) {
                    successes.hide();
                } else {
                    successText.html(success);
                    successes.show();
                    paymentError(false);
                }
            }
            function statusCodeCheck(statusCode) {
                switch (statusCode) {
                    case 201:
                        // paid
                        // redirect to company page
                        paymentSuccess('<a href="/paymentsystem/invoice/<?php echo $invoice->id; ?>" class="alert-link">Invoice</a> was paid successfully.');
                        break;
                    case 400:
                        // card declined
                        paymentError('The card has been declined.');
                        break;
                    case 402:
                        // card declined
                        paymentError('Not paid.');
                        break;
                    case 500:
                        // error, not paid
                        paymentError('Server error.');
                        break;
                }
            }
        </script>
        <script>
            var handler = StripeCheckout.configure({
                key: "<?php echo $stripe['publishableKey'];?>",
                image: '/public/images/payment-logo.jpg',
                color: 'black',
                token: function(token) {
                    $.ajax('/paymentsystem/stripe', {
                        type: 'POST',
                        data: {
                            stripe_token_id: token.id,
                            invoice_id: "<?php echo $invoice->id;?>",
                            email: token.email
                        },
                        complete: function(xhr) {
                            var statusCode = parseInt(xhr.status);
                            statusCodeCheck(statusCode);
                        }
                    });
                }
            });

            $('#stripePayment2').on('click', function(e) {
                    // Open Checkout with further options
                    handler.open({
                        name: "<?php echo $invoice->title;?>",
                        description: "<?php echo $invoice->description;?>",
                        amount: <?php echo $invoice->price - $discount;?>,
                currency: "<?php echo $stripe['currency'];?>"
            });
            e.preventDefault();
            });

            // Close Checkout on page navigation
            $(window).on('popstate', function() {
                handler.close();
            });
        </script>

        <?php if (isset($owner) && isset($owner->stripe_customer_id)) {?>
        <script>
            $('#stripePayment1').on('click', function(e) {
                $.ajax('/paymentsystem/stripe', {
                    type: 'POST',
                    data: {
                        stripe_customer_id: "<?php echo $owner->stripe_customer_id;?>",
                        membership_type:  "<?php echo $owner->membership_type;?>",
                        membership_interval: "<?php echo $owner->membership_interval;?>",
                        membership_plan: "<?php echo $owner->membership_plan;?>",
                        invoice_id: "<?php echo $invoice->id;?>"
                    },
                    complete: function(xhr) {
                        var statusCode = parseInt(xhr.status);
                        statusCodeCheck(statusCode);
                    }
                });
                e.preventDefault();
            });
        </script>

        <?php } ?>

        <?php } ?>
    </div>
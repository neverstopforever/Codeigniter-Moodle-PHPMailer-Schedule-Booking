<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

use PayPal\Api\Agreement;
use PayPal\Api\ShippingAddress;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

use Stripe\Stripe;
use Stripe\Error\Card as ErrorCard;
use Stripe\Customer;
use Stripe\Coupon as StripeCoupon;

use Aws\Ses\SesClient;

/**
 *@property InvoiceModel $InvoiceModel
 *@property CouponModel $CouponModel
 *@property UserFundsModel $UserFundsModel
 *@property UsedCouponsModel $UsedCouponsModel
 */
class Paymentsystem extends Public_Controller {


    public $layout = 'paymentsystem';
    public $data = array();

    private $payment;

    public function __construct() {
        parent::__construct();

//        $this->_identity = $this->session->userdata('auth-identity-2');

        $this->data['lang'] = $this->session->userdata('lang');
        if(empty($this->data['lang'])){
            $this->session->set_userdata('lang', 'spanish');
            $this->data['lang'] = 'spanish';
        }
        $this->lang->load('site', $this->data['lang']);
        $this->lang->load('footer', $this->data['lang']);
        $this->lang->load('stripe', $this->data['lang']);

        $this->load->model('InvoiceModel');
        $this->load->model('ClientesAkaudModel');
        $this->load->model('CouponModel');
        $this->load->model('UserFundsModel');
        $this->load->model('UsedCouponsModel');
        
        $this->payment = $this->config->item('payment');
        $this->data['stripe']['publishableKey'] = $this->payment['stripe']['publishableKey'];
        $this->data['stripe']['currency'] = $this->payment['stripe']['currency'];
        $this->lang->load('paymentsystem', $this->data['lang']);
        $this->layouts->add_includes('css', 'assets/pages/css/invoice-2.min.css');
    }

    public function index() {
        $invoiceId = $this->input->get('invoice_id');


        if ($invoiceId) {
            $invoice = $this->InvoiceModel->findById($invoiceId);

            $user = $this->ClientesAkaudModel->getAll(array('id'=>$invoice->owner_id));

            if($user){
                $this->data['owner'] = $user;
            }else{
                $this->data['owner'] = false;
            }
            $discount = 0;

            if ($invoice->coupon_id) {
                $coupon = $this->CouponModel->findById($invoice->coupon_id);
                if ($coupon) {
                    $discount = $invoice->price * $coupon->discount / 100;
                } else {
                    $this->data['error'][] = 'Coupon is not valid.';
                }
            }

            if ($invoice) {
                $this->data['invoice'] = $invoice;
                $this->data['discount'] = $discount;
            }
        }

        if (!$invoiceId || !$invoice) {
            $this->data['error'][] = 'No invoice found.';
        }

        $this->layouts->view('paymentsystem/index', $this->data);

    }


    /**
     * View invoice by id
     * @param string $id
     */
    public function invoice($id) {

        $this->layouts->add_includes('js', '//checkout.stripe.com/checkout.js', null, false);
        $this->layouts->add_includes('js', 'app/js/paymentsystem/invoice.js');

        $invoice = $this->InvoiceModel->findById($id);

        $discount = 0;

        if ($invoice) {
            
            if ($invoice->paid) {
                $this->data['success'] = $this->lang->line('paymentsystem_invoice_paid');

                /*
                $user = $this->ClientesAkaudModel->getAll(array('id'=>$invoice->owner_id));

                $user = isset($user[0]) ? $user[0] : false;

                //send email confirmation
                if($user && !$user->active){
//                    $user_id = $user->id;
//                    $to = $user->email;
//                    $verify_code = rundomString(32);
//                    $data_array = array(
//                        'verify_code' => $verify_code
//                    );
//                    $where = array(
//                        'id' => $user_id
//                    );
//
//                    $this->ClientesAkaudModel->update($data_array, $where);
//                    $this->data['verification_url'] = base_url('signup/email_verification/'.$verify_code);
//                    $this->data['user_name'] = $user->firstname . " ". $user->surname;
//                    $from = "Softaula";
//                    $subject = "Please confirm registration email.";
//                    $message = $this->load->view('signup/send_email_view', $this->data,TRUE);
//
//                    sendEmail($to,$from,$subject,$message);
//                    $this->session->set_flashdata('errors', array("Please confirm registration email."));
                }
                //send email confirmation
                */

            } else {
                if ($this->input->post()) {
                    $couponCode = $this->input->post('coupon_code', true);
                    if ($couponCode) {
                        $coupon = $this->CouponModel->getCoupon($couponCode);
                        if ($coupon) {
                            if($coupon->discount){
                                $discount = $coupon->discount;
                            }elseif($coupon->percent_off){
                                $discount = ($invoice->price / 100) * $coupon->percent_off / 100;
                            }

                            // if coupon is not used earlier
                            if (!$this->UsedCouponsModel->used($invoice->owner_id, $coupon->id)) {
                                $invoice->coupon_id = $coupon->id;
                                $invoice_update = $this->InvoiceModel->update('clientes_invoices',array('coupon_id'=>$coupon->id, 'updated_at'=>date('Y-m-d H:i:s')), array('id'=>$invoice->id));
                                if ($invoice_update) {
                                    $used_coupon_insert = $this->UsedCouponsModel->insert('clientes_used_coupons',array(
                                        'coupon_id'=>$coupon->id,
                                        'owner_id'=>$invoice->owner_id,
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ));
                                    if ($used_coupon_insert) {
                                        $this->data['success'] = $this->lang->line('paymentsystem_coupon_used_success');
                                    }
                                }
                            } else {
                                $this->data['errors'][] = $this->lang->line('paymentsystem_coupon_is_used');
                            }
                        } else {
                            $this->data['errors'][] = $this->lang->line('paymentsystem_coupon_is_not_valid');
                        }
                    }
                }
            }
            $this->data['invoice'] = $invoice;
            $this->data['discount'] = $discount;
            $this->data['_coupon'] = $this->InvoiceModel->getCoupon($invoice->coupon_id);

            $user = $this->ClientesAkaudModel->getAll(array('id'=>$invoice->owner_id));
            if(isset($user[0]) && !empty($user[0])){
                $user = $user[0];
            }else{
                $user = new ClientesAkaudModel();
            }
            $this->data['owner'] = $user;
            $this->load->model('MiempresaModel');
            $this->data['company'] = $this->MiempresaModel->getCompany();
        }
        $this->data['invice_id_perfix'] = $this->config->item('payment_perfix')->credit_card.'-'.$id;
        $this->data['payment_perfix'] = $this->config->item('payment_perfix');
        $this->layouts->view('paymentsystem/invoice', $this->data);
    }


    private function get_stripe_errors($e){

        if (method_exists($e, 'getJsonBody')){
            $body = $e->getJsonBody();
            $err = isset($body['error']) ? $body['error'] : null;
            $error['status'] = $e->getHttpStatus();
            $error['message'] = '<p>'.$this->lang->line('stripe_err_'.$error['status']).'</p>';
            if(isset($err['type'])){
                $error['message'] .= '<p>'.$this->lang->line('stripe_'.$err['type']).'</p>';
            }
            if(isset($err['code'])){
                $error['message'] .= '<p>'.$this->lang->line('stripe_'.$err['code']).'</p>';
            }
            if(isset($err['param'])){
                $error['message'] .= '<p>'.$this->lang->line('stripe_'.$err['param']).'</p>';
            }
        } else {
            $error['status'] = $e->getHttpStatus();
            $error['message'] =  $e->getMessage();
        }
        return $error;
    }


    /**
     * Complete Stripe checkout
     */
    public function stripe(){
        $token = $this->input->post('stripe_token_id');
        $invoiceId = $this->input->post('invoice_id');
        $email = $this->input->post('email');

        $invoice = $this->InvoiceModel->findById($invoiceId);
        
        $response['success'] = false;
        $response['errors'] = array();
        if ($invoice) {
            Stripe::setApiKey($this->payment['stripe']['secretKey']);
            // if coupon is used
            $discount = 0;
            $using_discount = false;
            $coupon_code = '';
            if ($invoice->coupon_id) {
                $coupon = $this->CouponModel->findById($invoice->coupon_id);
                if ($coupon) {
                    if($coupon->discount){
                        $discount = $coupon->discount;
                    }elseif($coupon->percent_off){
                        $discount = ($invoice->price / 100) * $coupon->percent_off / 100;
                    }
                    $coupon_code = $coupon->code;
                } else {
//                    $response['errors'][] = $this->lang->line('paymentsystem_coupon_is_not_valid');
//                    $this->data['error'][] = $this->lang->line('paymentsystem_coupon_is_not_valid');
                }
            }

            try {

                if ($coupon_code != '' && strlen($coupon_code) > 0) {
                    try {
                        $coupon_retrieve = StripeCoupon::retrieve($coupon_code); //check coupon exists
                        if ($coupon_retrieve !== NULL) {
                            $using_discount = true; //set to true our coupon exists or take the coupon id if you wanted to.
                        }
                        // if we got here, the coupon is valid
                    } catch (\Exception $e) {
                        // an exception was caught, so the code is invalid
                        $response['errors'][] = $this->get_stripe_errors($e);
                    }

                }


                $userId = $invoice->owner_id;
//                $userId = $this->_db_details->id; //TODO need check
                $user_invoice = $this->ClientesAkaudModel->getAll(array('id'=>$userId));
                $user_invoice = isset($user_invoice[0]) ? $user_invoice[0] : null;

//                if(!empty($user_invoice) && $user_invoice->membership_plan !== $invoice->membership_plan) {
                    if (!empty($user_invoice) && isset($user_invoice->stripe_customer_id) && !empty($user_invoice->stripe_customer_id)) {
                        try {
                            // Use Stripe's library to make requests...
                            $customer = Customer::retrieve($user_invoice->stripe_customer_id); // stored in your application
                            $customer->source = $token; // obtained with Checkout
                            $customer->save();

                            //for subscribe  start
                            try {
                                $sub_id = $customer->subscriptions->data[0]->id;
                                $subscription = $customer->subscriptions->retrieve($sub_id);
                                $subscription->plan = $invoice->membership_plan;
                                $subscription->tax_percent = $invoice->vat;
                                if($using_discount){
                                    $subscription->coupon = $coupon_retrieve;
                                }
                                $subscription->save();
                                $email_body['success'] = true;

                            } catch(\Stripe\Error\Card $e) {
                                // Since it's a decline, \Stripe\Error\Card will be caught
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\RateLimit $e) {
                                // Too many requests made to the API too quickly
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\InvalidRequest $e) {
                                // Invalid parameters were supplied to Stripe's API
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\Authentication $e) {
                                // Authentication with Stripe's API failed
                                // (maybe you changed API keys recently)
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\ApiConnection $e) {
                                // Network communication with Stripe failed
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\Base $e) {
                                // Display a very generic error to the user, and maybe send
                                // yourself an email
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (Exception $e) {
                                // Something else happened, completely unrelated to Stripe
                                $response['errors'][] = $this->get_stripe_errors($e);
                            }
                            //for subscribe end

                        } catch(\Stripe\Error\Card $e) {
                            // Since it's a decline, \Stripe\Error\Card will be caught
                            $response['errors'][] = $this->get_stripe_errors($e);
                        } catch (\Stripe\Error\RateLimit $e) {
                            // Too many requests made to the API too quickly
                            $response['errors'][] = $this->get_stripe_errors($e);
                        } catch (\Stripe\Error\InvalidRequest $e) {
                            // Invalid parameters were supplied to Stripe's API
                            $response['errors'][] = $this->get_stripe_errors($e);
                        } catch (\Stripe\Error\Authentication $e) {
                            // Authentication with Stripe's API failed
                            // (maybe you changed API keys recently)
                            $response['errors'][] = $this->get_stripe_errors($e);
                        } catch (\Stripe\Error\ApiConnection $e) {
                            // Network communication with Stripe failed
                            $response['errors'][] = $this->get_stripe_errors($e);
                        } catch (\Stripe\Error\Base $e) {
                            // Display a very generic error to the user, and maybe send
                            // yourself an email
                            $response['errors'][] = $this->get_stripe_errors($e);
                        } catch (Exception $e) {
                            // Something else happened, completely unrelated to Stripe
                            $response['errors'][] = $this->get_stripe_errors($e);
                        }
                    } else {
                        if($token){
                            $create_customer_data = array(
                                "source" => $token,
                                "plan" => $invoice->membership_plan,
                                "email" => $email,
                                "tax_percent" => $invoice->vat,
                                "coupon" => null,
                            );
                            if ($using_discount == true) {
                                $create_customer_data['coupon'] = $coupon_retrieve;                              
                            }

                            try{
                                $customer = Customer::create($create_customer_data);                               
                                $response['success'] = $this->lang->line('paymentsystem_invoice_paid_success');
                            } catch(\Stripe\Error\Card $e) {
                                // Since it's a decline, \Stripe\Error\Card will be caught
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\RateLimit $e) {
                                // Too many requests made to the API too quickly
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\InvalidRequest $e) {
                                // Invalid parameters were supplied to Stripe's API
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\Authentication $e) {
                                // Authentication with Stripe's API failed
                                // (maybe you changed API keys recently)
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\ApiConnection $e) {
                                // Network communication with Stripe failed
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (\Stripe\Error\Base $e) {
                                // Display a very generic error to the user, and maybe send
                                // yourself an email
                                $response['errors'][] = $this->get_stripe_errors($e);
                            } catch (Exception $e) {
                                // Something else happened, completely unrelated to Stripe
                                $response['errors'][] = $this->get_stripe_errors($e);
                            }
                        }
                    }
                    if (isset($customer)) {
                        // add to user's funds amount
                        $funds = $this->UserFundsModel->findOne(array('owner_id'=>$userId));

                        if (!$funds) {
                            $this->UserFundsModel->insert('clientes_user_funds',array('owner_id'=>$userId, 'amount'=>0, 'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')));
                            $funds = new \stdClass();
                            $funds->amount = 0;
                        }

//                    $funds->amount += $charge->amount + $discount;
                        if (!$invoice->coupon_id) {
                            $sub_total = ($invoice->price / 100 * $invoice->qty);
                        }else{
                            $sub_total = (($invoice->price / 100 * $invoice->qty) - $discount);
                        }
                        $tax = ($sub_total * $invoice->vat) / 100;
                        $total = $sub_total + $tax;
                        $funds->amount += $total * 100; //???
//                        $funds->amount += ($invoice->price - $discount) + $discount; //???

                        if ($this->UserFundsModel->update('clientes_user_funds',array('amount'=>$funds->amount, 'updated_at'=>date('Y-m-d H:i:s')), array('owner_id'=>$userId))) {
//                            $invoice->paid = true;
                            $objInvoice = new InvoiceModel();
                            if ($invoice->purpose == $objInvoice::PURPOSE_UPGRADE_MEMBERSHIP  || $invoice->purpose == $objInvoice::PURPOSE_REGISTRATION ) {


                                $membership_plan = $invoice->membership_plan;
//                                $membership_type = $objInvoice::MEMBERSHIP_TYPE_FREE;
                                $membership_interval = "monthly";

                                /*
                                $reg_price = $objInvoice::REGISTRATION_PRICE_FREE;

                                switch ($membership_plan){
                                    case $objInvoice::MEMBERSHIP_PLAN_STARETR: //Starter monthly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_STARTER;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_STARETR;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_STARETR_YEARLY: //Starter yearly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_STARETR_YEARLY;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_STARETR;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_BASIC: //Basic monthly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_BASIC;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_BASIC;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_BASIC_YEARLY: //Basic yearly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_BASIC_YEARLY;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_BASIC;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_ADVANCED: //Ultimate monthly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_ADVANCED;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_ADVANCED;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_ADVANCED_YEARLY: //Ultimate yearly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_ADVANCED_YEARLY;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_ADVANCED;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_CORPORATE: //Corporate monthly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_CORPORATE;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_CORPORATE;
                                        break;
                                    case $objInvoice::MEMBERSHIP_PLAN_CORPORATE_YEARLY: //Corporate yearly
                                        $reg_price = $objInvoice::REGISTRATION_PRICE_CORPORATE_YEARLY;
                                        $membership_type = $objInvoice::MEMBERSHIP_TYPE_CORPORATE;
                                        break;
                                }
                                */
//                                if ($funds->amount >= $reg_price) {
//                                    $funds->amount -= $reg_price;
//                                }
//                                if ($this->UserFundsModel->update('clientes_user_funds',array('amount'=>$funds->amount, 'updated_at'=>date('Y-m-d H:i:s')), array('owner_id'=>$userId))) {
//                                        $plan = get_plan($membership_plan); //TODO getting from plan_fields.json

                                        $file_path = FCPATH.'app/plan_fields.json';
                                        $fields = array();
                                        $update_data = array();
                                        if(file_exists($file_path)) {
                                            $plan_json_fields = file_get_contents($file_path);
                                            $fields = json_decode($plan_json_fields);
                                        }
                                        if(!empty($fields)){
                                            foreach ($fields as $k=>$field){
                                                if($field->membership_plan == $membership_plan
                                                    && $field->membership_interval == $membership_interval){
                                                    $update_data = (array)$field;
                                                    break;
                                                }
                                            }
                                        }
                                        if(!empty($update_data)){
                                            $update_data['paid'] = true;
                                            $update_data['stripe_customer_id'] = $customer->id;

                                            $user_update = $this->ClientesAkaudModel->updateItem($update_data, array('id'=>$userId));
                                            if($user_update){
                                                $this->load->model('ErpEmailsAutomatedModel');
                                                $this->ErpEmailsAutomatedModel->changeActivityAllOff();
                                                $res = $this->ClientesAkaudModel->findById($userId);
                                                $this->load->model('Variables2Model');
                                                if($update_data['plan'] == '1'){
                                                    $this->Variables2Model->deleteLogo();
                                                    $this->data['customer_logo'] = null;
                                                }else {
                                                    $logo = $this->Variables2Model->get_logo();
                                                    if (!empty($logo) && isset($logo->logo)) {
                                                        $this->data['customer_logo'] = $logo->logo;
                                                    } else {
                                                        $this->data['customer_logo'] = null;
                                                    }
                                                }

                                                $db_details = (array)$res;
                                                $plan_options = $this->session->userdata('_plan_options');

                                                if(isset($db_details['plan'])){
                                                    $this->load->model('ClientesPlansRelationModel');
                                                    $plan_options = $this->ClientesPlansRelationModel->getOptions($db_details['plan']);
                                                }
                                                $this->session->set_userdata('_plan_options', $plan_options);

//                                                $db_details_json_base64_encode = base64_encode(json_encode($db_details));
//                                                setcookie('_cisess', $db_details_json_base64_encode,time() + (86400 * 30), "/"); //30 days

                                                $key_base64_encode = isset($res->key) ? base64_encode($res->key) : null;
                                                setcookie('_cisess', $key_base64_encode,time() + (86400 * 1), "/"); //1 day
                                                
                                                $this->session->set_userdata('_cisess', $db_details);

                                                // save paid invoice
                                                $invoice_update = $this->InvoiceModel->update('clientes_invoices',array('paid'=>true, 'updated_at'=>date('Y-m-d H:i:s')), array('id'=>$invoiceId));

                                                if ($invoice_update) {

                                                    $this->data['invoice_url'] = base_url().'paymentsystem/invoice/'.$invoiceId;
                                                    //$amazon = $this->config->item('amazon');
                                                   // $email_from = $this->config->item('admin_info1');
                                                   $admin_info = $this->config->item('admin_info');
                                                    /*$client = SesClient::factory(array(
                                                       'version' => 'latest',
                                                       'region' => $amazon['email_region'],
                                                       'credentials' => array(
                                                           'key' => $amazon['AWSAccessKeyId'],
                                                           'secret' => $amazon['AWSSecretKey'],
                                                       ),
                                                   ));*/
//                                       
                                                    //send notification for admin - start
                                                    $message_admin = $this->load->view('paymentsystem/partials/send_admin_note', $this->data,TRUE);                                                   

                                                    $result_email = $this->sendRowEmail($invoiceId, $admin_info['email'], $message_admin);

                                                    /*$request_admin = array();
                                                    $request_admin['Source'] = $email_from['from'];
//                                                    $request_admin['Destination']['ToAddresses'] = array($admin_info['email']);
                                                    $request_admin['Destination']['ToAddresses'] = $this->config->item('admin_info2');
                                                    $request_admin['Message']['Subject']['Data'] = "Notification for new Payment";
                                                    $request_admin['Message']['Subject']['Charset'] = "UTF-8";
                                                    $request_admin['Message']['Body']['Html']['Data'] = $message_admin;
                                                    $request_admin['Message']['Subject']['Charset'] = "UTF-8";
              
                                                    try {
                                                        $result = $client->sendEmail($request_admin);
//                                                    $messageId = $result->get('MessageId');
                                                    } catch (Exception $e) {
                                                        //echo("The email was not sent. Error message: ");
                                                        //$response['errors'] = $e->getMessage()."\n";
//                                                    $response['errors'][] = $this->get_stripe_errors($e);
                                                    }*/
                                                    //send notification for admin - end
                                                    if(isset($res->idcliente)){
                                                        $this->load->model('ClientesMainModel');
                                                        $client_main = $this->ClientesMainModel->getAll("CCODCLI='".$res->idcliente."'");
                                                        
                                                        if(!empty($client_main) && isset($client_main[0])){
                                                            $client_main = $client_main[0];

                                                            //send notification for customer - start
                                                            $this->data['commercial_name'] = $client_main->commercial_name;
                                                            $this->data['customer_email'] = $client_main->email;
                                                            $message_customer = $this->load->view('paymentsystem/partials/send_customer_note', $this->data,TRUE);

                                                            $this->sendRowEmail($invoiceId, $this->data['customer_email'], $message_customer);
                                                            /* $request_customer = array();
                                                            $request_customer['Source'] = $email_from['from'];
                                                            $request_customer['Destination']['ToAddresses'] = array($this->data['customer_email']);
                                                            $request_customer['Message']['Subject']['Data'] = "Notification for new Payment";
                                                            $request_customer['Message']['Subject']['Charset'] = "UTF-8";
                                                            $request_customer['Message']['Body']['Html']['Data'] = $message_customer;
                                                            $request_customer['Message']['Subject']['Charset'] = "UTF-8";

                                                            try {
                                                                $result = $client->sendEmail($request_customer);
//                                                    $messageId = $result->get('MessageId');
                                                            } catch (Exception $e) {
                                                                //echo("The email was not sent. Error message: ");
                                                                //$response['errors'] = $e->getMessage()."\n";
//                                                    $response['errors'][] = $this->get_stripe_errors($e);
                                                            }*/
                                                            //send notification for customer - end 
                                                        }  
                                                    }

                                                    $response['success'] = $this->lang->line('paymentsystem_invoice_paid_success');
                                                    echo json_encode($response);
                                                    exit;
                                                }
                                            }
                                        }
//                                }
                                $response['errors'][] = array(
                                    'status' => 500,
                                    'message'=>$this->lang->line('paymentsystem_server_error')
                                );
                                echo json_encode($response);
                                exit;
                            }
                            // save paid invoice
                            $invoice_update = $this->InvoiceModel->update('clientes_invoices',array('paid'=>true, 'updated_at'=>date('Y-m-d H:i:s')), array('id'=>$invoiceId));
                            if ($invoice_update) {
                                $response['success'] = $this->lang->line('paymentsystem_invoice_paid_success');
                                echo json_encode($response);
                                exit;
                            }
                        }
                    }
//                }else{
//                    $response['errors'][] = array(
//                        'status' => 500,
//                        'message'=>$this->lang->line('paymentsystem_server_error')
//                    );
//                }
            } catch(\Stripe\Error\Card $e) {
                // Since it's a decline, \Stripe\Error\Card will be caught
                $response['errors'][] = $this->get_stripe_errors($e);
            } catch (\Stripe\Error\RateLimit $e) {
                // Too many requests made to the API too quickly
                $response['errors'][] = $this->get_stripe_errors($e);
            } catch (\Stripe\Error\InvalidRequest $e) {
                // Invalid parameters were supplied to Stripe's API
                $response['errors'][] = $this->get_stripe_errors($e);
            } catch (\Stripe\Error\Authentication $e) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                $response['errors'][] = $this->get_stripe_errors($e);
            } catch (\Stripe\Error\ApiConnection $e) {
                // Network communication with Stripe failed
                $response['errors'][] = $this->get_stripe_errors($e);
            } catch (\Stripe\Error\Base $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                $response['errors'][] = $this->get_stripe_errors($e);
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                $response['errors'][] = $this->get_stripe_errors($e);
            }            
        }else{
            $response['errors'][] = $this->lang->line('paymentsystem_not_paid');
        }
        echo json_encode($response);
        exit;
        
    }

    /**
     * Create PayPal payment
     */

    public function paypal() {
        $flash_errors = [];
        $flash_success = [];

        $invoiceId = $this->input->post('invoice_id');

        if ($invoiceId) {
            $invoiceObj = new InvoiceModel();
            $invoice = $this->InvoiceModel->findById($invoiceId);
            
            switch ($invoice->membership_plan){
                case $invoiceObj::MEMBERSHIP_PLAN_STARETR: //Starter monthly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_STARTER_PAYPAL;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_STARETR_YEARLY: //Starter yearly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_STARTER_PAYPAL_YEARLY;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_PRO: //Professional monthly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_PRO_PAYPAL;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_PRO_YEARLY: //Professional yearly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_PRO_PAYPAL_YEARLY;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_CORPORATE: //Corporate monthly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_CORPORATE_PAYPAL;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_CORPORATE_YEARLY: //Corporate yearly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_CORPORATE_PAYPAL_YEARLY;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_ULTIMATE: //Ultimate monthly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_ULTIMATE_PAYPAL;
                    break;
                case $invoiceObj::MEMBERSHIP_PLAN_ULTIMATE_YEARLY: //Ultimate yearly
                    $plan_id = $invoiceObj::MEMBERSHIP_PLAN_ULTIMATE_PAYPAL_YEARLY;
                    break;
            }

            if(!isset($plan_id)){
                $this->session->set_flashdata('errors', array("Something went wrong. Please try again later."));
                redirect('paymentsystem/invoice/'.$invoiceId);
            }
            $discount = 0;

            if ($invoice->coupon_id) {
                $coupon = $this->CouponModel->findById($invoice->coupon_id);
                if ($coupon) {
                    $discount = $invoice->price * $coupon->discount / 100;
                } else {
                    $flash_errors[] = $this->lang->line('paymentsystem_use_coupon');
                }
            }

            $apiContext = new ApiContext(
                new OAuthTokenCredential(
                    $this->payment['paypal']['clientId'],
                    $this->payment['paypal']['secret']
                )
            );

            try {

//            $plan = Plan::get($plan_id, $apiContext);

                $agreement = new Agreement();


                $plan = new Plan();
                $plan->setId($plan_id);

                $title = $invoice->title;
                $description = $invoice->description;
                $description .= " (" . $invoice->price / 100 . " EUR )";

                $agreement->setName($title)
                    ->setDescription($description)
                    ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", time()+60));
                // Add Plan ID
                // Please note that the plan Id should be only set in this case.
                $agreement->setPlan($plan);

                // Add Payer
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
                $agreement->setPayer($payer);

                // ### Create Agreement
                try {
                    // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
                    $agreement = $agreement->create($apiContext);
                    // ### Get redirect url
                    // The API response provides the url that you must redirect
                    // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
                    // method
                    $approvalUrl = $agreement->getApprovalLink();

                } catch (Exception $ex) {
                    $flash_errors[] = $this->lang->line('paymentsystem_payment_error');
                    $this->session->set_flashdata('errors', $flash_errors);
                    redirect('paymentsystem/invoice/'.$invoiceId);
                    exit(1);
                }

            } catch (Exception $ex) {
                $flash_errors[] = $this->lang->line('paymentsystem_payment_error');
                $this->session->set_flashdata('errors', $flash_errors);
                redirect('paymentsystem/invoice/'.$invoiceId);
                exit(1);
            }
            $this->session->set_flashdata('errors', $flash_errors);
            $this->session->set_userdata('invoiceId', $invoiceId);
            redirect($approvalUrl);
        }
    }

    /**
     * Complete PayPal checkout
     */

    public function paypalPayment() {
        $flash_errors = [];
        $flash_success = [];

        $success = $this->input->get('success');
        $token = $this->input->get('token');
        $invoiceId = $this->session->userdata('invoiceId');
        if ($success == 'true' && $invoiceId) {

            $invoice = $this->InvoiceModel->findById($invoiceId);

            if ($invoice) {
                $apiContext = new ApiContext(
                    new OAuthTokenCredential(
                        $this->payment['paypal']['clientId'],
                        $this->payment['paypal']['secret']
                    )
                );

                $agreement = new \PayPal\Api\Agreement();
                $hasErrors = false;
                try {
                    // ## Execute Agreement
                    // Execute the agreement by passing in the token
                    $agreement->execute($token, $apiContext);
                } catch (Exception $ex) {
                    $hasErrors = true;
                    $this->session->set_flashdata('errors', $ex->getMessage());
                    redirect('paymentsystem/invoice/'.$invoiceId);
                    exit(1);
                }

                $paypal_profile_id = $agreement->getId();

                if (!$hasErrors) {
                    // if coupon is used
                    $discount = 0;
                    if ($invoice->coupon_id) {
                        $coupon =  $this->CouponModel->findById($invoice->coupon_id);
                        if ($coupon) {
                            $discount = $invoice->price * $coupon->discount / 100;
                        } else {
                            $flash_errors[] = 'Coupon is not valid.';
                        }
                    }

                    // add to user's funds
                    $funds = $this->UserFundsModel->findOne(array('owner_id'=>$invoice->owner_id));

                    if (!$funds) {
                        $this->UserFundsModel->insert("clientes_user_funds", array('owner_id'=>$invoice->owner_id, 'amount'=>0, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')));
                        $funds = new \stdClass();
                        $funds->amount = 0;
                    }

                    $funds->amount = $invoice->price;

                    if ($this->UserFundsModel->update("clientes_user_funds",array('amount'=>$funds->amount, 'updated_at'=>date('Y-m-d H:i:s')), array('owner_id'=>$invoice->owner_id))) {
//                        $invoice->paid = true;
                        // if it's payment for registration
                        $objInvoice = new InvoiceModel();
                        if ($invoice->purpose == $objInvoice::PURPOSE_UPGRADE_MEMBERSHIP  || $invoice->purpose == $objInvoice::PURPOSE_REGISTRATION ) {

                            $membership_plan = $invoice->membership_plan;
                            $membership_type = $objInvoice::MEMBERSHIP_TYPE_FREE;
                            $membership_interval = "monthly";

                            $reg_price = $objInvoice::REGISTRATION_PRICE_FREE;
                            switch ($membership_plan){
                                case $objInvoice::MEMBERSHIP_PLAN_STARETR: //Starter monthly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_STARTER;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_STARETR;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_STARETR_YEARLY: //Starter yearly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_STARETR_YEARLY;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_STARETR;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_PRO: //Professional monthly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_PRO;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_PRO;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_PRO_YEARLY: //Professional yearly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_PRO_YEARLY;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_PRO;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_CORPORATE: //Corporate monthly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_CORPORATE;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_CORPORATE;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_CORPORATE_YEARLY: //Corporate yearly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_CORPORATE_YEARLY;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_CORPORATE;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_ULTIMATE: //Ultimate monthly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_ULTIMATE;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_ULTIMATE;
                                    break;
                                case $objInvoice::MEMBERSHIP_PLAN_ULTIMATE_YEARLY: //Ultimate yearly
                                    $reg_price = $objInvoice::REGISTRATION_PRICE_ULTIMATE_YEARLY;
                                    $membership_type = $objInvoice::MEMBERSHIP_TYPE_ULTIMATE;
                                    break;
                            }
//                            if ($funds->amount >= $reg_price) { // need check
//                                $funds->amount -= $reg_price;
//                            } else {
//                                //$flash_errors[] = 'Not enough funds for the registration payment.';
//                            }
                                // save user's funds
                                if ($this->UserFundsModel->update("clientes_user_funds", array('amount'=>$funds->amount, 'updated_at'=>date('Y-m-d H:i:s')), array('owner_id'=>$invoice->owner_id))) {
                                   
                                    $user_update = $user = $this->ClientesAkaudModel->update(array(
                                        'paid'=>true,
                                        'membership_type'=>$membership_type,
                                        'membership_interval'=>$membership_interval,
                                        'membership_plan'=>$membership_plan,
                                        'paypal_profile_id'=>$paypal_profile_id
                                    ),array('id'=>$invoice->owner_id));

                                    if ($user_update) {
//                                        $user_invoice = $this->ClientesAkaudModel->getAll(array('id'=>$invoice->owner_id));
//                                        $user_invoice = isset($user_invoice[0])? $user_invoice[0] : false;
                                        // save paid invoice
                                        $invoice_update = $this->InvoiceModel->update("clientes_invoices", array('paid'=>true, 'updated_at'=>date('Y-m-d H:i:s')), array('id'=>$invoiceId));

//                                        $this->data['verification_url'] = base_url('signup/email_verification/'.$verify_code);
//                                        $this->data['user_name'] = $user_invoice->firstname . " " . $user_invoice->surname;
//                                        $from = "Softaula";
//                                        $subject = "After payment";
//                                        $message = $this->load->view('signup/send_email_view', $this->data,TRUE);
//                                        $to = $user_invoice->email;
//
//                                        sendEmail($to,$from,$subject,$message);
                                        // save paid invoice
//                                        $invoice_update = $this->InvoiceModel->update(array('paid'=>true, 'updated_at'=>date('Y-m-d H:i:s')), array('id'=>$invoiceId));
                                        if (!$invoice_update) {
                                            $flash_errors[] = $this->lang->line('paymentsystem_cannot_save_invoice');
                                        }
                                        $flash_success = '<a href="/paymentsystem/invoice/'.$invoice->id.'" class="alert-link">'.$this->lang->line('paymentsystem_invoice_paid_success').'</a>';
                                    } else {
                                        $flash_errors[] = $this->lang->line('paymentsystem_cannot_save_fact');
                                    }
                                } else {
                                    $flash_errors[] = $this->lang->line('paymentsystem_cannot_save_funds');
                                }
                        } else {
                            if (!$invoice_update = $this->InvoiceModel->update("clientes_invoices",array('paid'=>true, 'updated_at'=>date('Y-m-d H:i:s')), array('id'=>$invoiceId))) {
                                $flash_errors[] = $this->lang->line('paymentsystem_cannot_save_invoice');
                            }
                            $flash_success = '<a href="/paymentsystem/invoice/'.$invoice->id.'" class="alert-link">'.$this->lang->line('paymentsystem_invoice_paid_success').'</a>';
                        }
                    } else {
                        $flash_errors[] = $this->lang->line('paymentsystem_cannot_save_funds');
                    }
                }

                if ($hasErrors) {
                    $flash_errors[] = $this->lang->line('paymentsystem_payment_error');
                }
            }
        } else {
            $flash_errors[] = $this->lang->line('paymentsystem_payment_is_canceled');
        }
        if(!empty($flash_errors)){
            $this->session->set_flashdata('errors', $flash_errors);
        }
        if(!empty($flash_success)){
            $this->session->set_flashdata('success', $flash_success);
        }

        redirect('paymentsystem/invoice/'.$invoiceId);
    }

    // This need for the future in admin section
    /*
    public function getAgreement($id = null){

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->payment['paypal']['clientId'],
                $this->payment['paypal']['secret']
            )
        );

        try {
            $agreement = \PayPal\Api\Agreement::get($id, $apiContext);
        } catch (Exception $ex) {
            echo '<pre>';var_dump($ex->getMessage());echo '</pre>';
            exit(1);
        }
        echo '<pre>';var_dump($agreement->agreement_details);echo '</pre>';
        echo '<pre>';var_dump($agreement->getPlan());echo '</pre>';
        echo '<pre>';var_dump($agreement->plan);echo '</pre>';
        echo '<pre>';var_dump($agreement->getLinks());echo '</pre>';
        echo '<pre>';var_dump($agreement->override_merchant_preferences);echo '</pre>';
    }

    public function createPlan(){

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->payment['paypal']['clientId'],
                $this->payment['paypal']['secret']
            )
        );

        // Create a new instance of Plan object
        $plan = new Plan();

// # Basic Information
// Fill up the basic information that is required for the plan
        $plan->setName('BASIC')
            ->setDescription('BASIC Template creation.')
            ->setType('INFINITE');

// # Payment definitions for this billing plan.
        $paymentDefinition = new PaymentDefinition();

// The possible values for such setters are mentioned in the setter method documentation.
// Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
// You should be able to see the acceptable values in the comments.
        $paymentDefinition->setName('BASIC definition')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles(0)
            ->setAmount(new Currency(array('value' => 9.95, 'currency' => 'GBP')));

        $merchantPreferences = new MerchantPreferences();
        $baseUrl = base_url();
// ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
// However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
// This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.

        $merchantPreferences->setReturnUrl($baseUrl."paymentsystem/paypalPayment?success=true")
            ->setCancelUrl($baseUrl. "paymentsystem/paypalPayment?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");
//            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'GBP')));


        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

// ### Create Plan
        try {
            $output = $plan->create($apiContext);
        } catch (Exception $ex) {
            echo '<pre />';var_dump($ex->getMessage());die;
            exit(1);
        }

        echo '<pre />';var_dump($output);die;
    }

    public function getPlan($plan_id){

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->payment['paypal']['clientId'],
                $this->payment['paypal']['secret']
            )
        );

        try {
            $plan = Plan::get($plan_id, $apiContext);
        } catch (Exception $ex) {
            echo '<pre />';var_dump($ex);die;
            exit(1);
        }
//        echo '<pre />';var_dump($plan);die;
        return $plan;

    }

    public function activatePlan($plan_id = null) {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->payment['paypal']['clientId'],
                $this->payment['paypal']['secret']
            )
        );

        if(!$plan_id){
            $plan_id = "P-3BM28471T63426505YR5KKCA";
        }
        $createdPlan  = $this->getPlan($plan_id);
        try {
            $patch = new Patch();

            $value = new PayPalModel('{
                   "state":"ACTIVE"
                 }');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $createdPlan->update($patchRequest, $apiContext);

            $plan = Plan::get($createdPlan->getId(), $apiContext);

        } catch (Exception $ex) {
            echo '<pre />';var_dump($ex);die;
            exit(1);
        }
        echo '<pre />';var_dump($plan);die;
    }
    public function listPlans(){
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->payment['paypal']['clientId'],
                $this->payment['paypal']['secret']
            )
        );

        try {
            // Get the list of all plans
            // You can modify different params to change the return list.
            // The explanation about each pagination information could be found here
            // at https://developer.paypal.com/webapps/developer/docs/api/#list-plans
            $params = array('page_size' => '20');
            $planList = Plan::all($params, $apiContext);
        } catch (Exception $ex) {
            echo '<pre />';var_dump($ex->getMessage());die;
            exit(1);
        }
        echo '<pre />';var_dump($planList->plans);die;
    }

    public function createAgreement(){

        $invoiceObj = new InvoiceModel();

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->payment['paypal']['clientId'],
                $this->payment['paypal']['secret']
            )
        );


        $plan_id = $invoiceObj::MEMBERSHIP_PLAN_BASIC_PAYPAL;

        try {

//            $plan = Plan::get($plan_id, $apiContext);

            $agreement = new Agreement();


            $plan = new Plan();
            $plan->setId($plan_id);

            $agreement->setName('TESTaa Sub')
                ->setDescription("TESTaa Subscription")
                ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", time()+60));
            // Add Plan ID
            // Please note that the plan Id should be only set in this case.
//            $plan = new Plan();
//            $plan->setId($invoiceObj::MEMBERSHIP_PLAN_PRO_PAYPAL);
            $agreement->setPlan($plan);

            // Add Payer
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);

            // ### Create Agreement
            try {
                // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
                $agreement = $agreement->create($apiContext);

                // ### Get redirect url
                // The API response provides the url that you must redirect
                // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
                // method
                $approvalUrl = $agreement->getApprovalLink();

            } catch (Exception $ex) {
                echo '<pre />';var_dump($ex->getMessage());die;
                exit(1);
            }

        } catch (Exception $ex) {
            echo '<pre />';var_dump($ex->getMessage());die;
            exit(1);
        }
        redirect($approvalUrl);

        echo '<pre />';var_dump($approvalUrl);die;
    }
    */

    public function upgrade_plan(){
        if($this->input->is_ajax_request()){
            $response['success'] = false;
            $response['errors'] = array();
            $response['invoice_id'] = null;
            $plan_id = $this->input->post('plan_id', true);
            $membership_interval = $this->input->post('membership_interval', true);
            $owner_id = isset($this->_db_details->id) ? $this->_db_details->id : null;
            if (!empty($owner_id)) {

                if(empty($plan_id)){
                    $plan_id = 1;
                }
                if(empty($membership_interval)){
                    $membership_interval = 'monthly';
                }

                $plan_options = InvoiceModel::get_plan_options($plan_id, $membership_interval);

                $membership_plan = $plan_options['membership_plan'];
                $membership_type = $plan_options['membership_type'];
                $reg_price = $plan_options['price'];

                $details = array(
                    'title' => $this->lang->line('payment_for_upg_memb_type_desc'). $this->lang->line($membership_type) . ' ('.$this->lang->line($membership_interval).')',
                    'description' => $this->lang->line('payment_for_upg_on_site_desc'). $this->lang->line($membership_type) . ' ('.$this->lang->line($membership_interval).')',
                    'qty' => 1,
                    'price' => $reg_price,
                    'membership_plan' => $membership_plan,
                    'purpose' => InvoiceModel::PURPOSE_UPGRADE_MEMBERSHIP
                );
                $response['success'] = true;
                $response['invoice_id'] = $this->InvoiceModel->createInvoice($owner_id, $details);
                
            }else{
                $response['errors'][] = $this->lang->line('db_err_msg');
            }
            echo json_encode($response);
            exit;
        }else{
            $this->layouts->view('error_404',$this->data, 'error_404');
        }
    }


    private  function sendRowEmail($invoice_id, $to, $message){

       // $message_customer = $this->load->view('paymentsystem/partials/send_customer_note', $this->data,TRUE);


// carriage return type (we use a PHP end of line constant)
        $eol = PHP_EOL;

// attachment name


// encode data (puts attachment in proper format)
        $this->lang->load('paymentsystem', $this->data['lang']);
        if(!isset($this->data['attachment'])) {
            $this->load->model('InvoiceModel');
            $invoice = $this->InvoiceModel->findById($invoice_id);
            $discount = 0;

            if ($invoice) {
                if ($invoice->paid) {
                    $this->data['success'] = $this->lang->line('paymentsystem_invoice_paid');
                }
                $this->data['invoice'] = $invoice;
                $this->data['discount'] = $discount;
                $this->data['_coupon'] = $this->InvoiceModel->getCoupon($invoice->coupon_id);

                $this->load->model('ClientesAkaudModel');
                $user = $this->ClientesAkaudModel->getAll(array('id' => $invoice->owner_id));
                if (isset($user[0]) && !empty($user[0])) {
                    $user = $user[0];
                } else {
                    $user = new ClientesAkaudModel();
                }
                $this->data['owner'] = $user;
                $this->load->model('MiempresaModel');
                $this->data['company'] = $this->MiempresaModel->getCompany();
            }
            $this->load->model('Variables2Model');
            $logo = $this->Variables2Model->get_logo();
            if (!empty($logo) && isset($logo->logo)) {
                $this->data['customer_logo'] = $logo->logo;
            } else {
                $this->data['customer_logo'] = null;
            }
            $filename = rand() . '.pdf';
            if (isset($invoice->title)) {
                $filename = str_replace(' ', '-', strtolower(trim($invoice->title))) . '.pdf';
            }
            $this->data['payment_perfix'] = $this->config->item('payment_perfix');
            $html = $this->load->view('advanced_settings/partials/billing_information/invoice_pdf', $this->data, TRUE);

            $mpdf = new mPDF('utf-8', 'A4', '', '', 0, 0, 0, 0, 0, 0);
            $mpdf->list_indent_first_level = 1;  // 1 or 0 - whether to indent the first level of a list

            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/global/plugins/font-awesome/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/global/plugins/bootstrap/css/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents('assets/global/plugins/uniform/css/uniform.default.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/global/css/components-rounded.css');
            $mpdf->WriteHTML($stylesheet, 1); //
            $stylesheet = file_get_contents('assets/global/css/plugins-md.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/admin/layout3/css/layout.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/admin/layout3/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/css/main.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet = file_get_contents('assets/admin/layout3/css/themes/light_blue.css');
            $mpdf->WriteHTML($stylesheet, 1); //
            $stylesheet = file_get_contents('assets/pages/css/invoice-2.min.css');
            $mpdf->WriteHTML($stylesheet, 1); //
            $stylesheet = file_get_contents('app/css/style.css');
            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

            $mpdf->WriteHTML($html, 2);
            $pdfdoc = $mpdf->Output("", "S");
            $attachment = chunk_split(base64_encode($pdfdoc));
            $this->data['attachment'] = $attachment;
            $this->data['filename'] = $filename;
        }else{
            $attachment = $this->data['attachment'];
            $filename = $this->data['filename'];
        }
        $email_from = $this->config->item('admin_info1');
        $from =  $email_from['from'];
        $from_ = 'admin@akaud.com';
        //$dest_email_id = "miasnikdavtyan@gmail.com";
        //$source_email_id = "noreply@akaud.com";

// main header
        $uid = md5(uniqid(time()));
        $header = '';
        $header .= "From: $from ".$eol;
        $header .= "Return-Path: ".$from_.$eol;
        $header .= "To: $to ".$eol;
        $header .= "Bcc: ".$from_.$eol;
        $header .= "Subject: Notification for new Payment ".$eol;
        $header .= "MIME-Version: 1.0 ".$eol;
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"".$eol.$eol;
        $header .= "This is a multi-part message in MIME format.".$eol;
        $header .= "--".$uid.$eol;
        $header .= "Content-type:text/html; charset=iso-8859-1".$eol;
        $header .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
        $header .= $message.$eol.$eol;
        $header .= "--".$uid.$eol;
        $header .= "Content-Type: application/x-pdf; name=\"".$filename."\"".$eol;
        // attachment file
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "Content-Disposition: attachment; filename=\"".$filename."\"".$eol.$eol;
        $header .= $attachment.$eol.$eol;
        $header .= "--".$uid."--";

        $amazon = $this->config->item('amazon');

        $admin_info = $this->config->item('admin_info');
        $client = SesClient::factory(array(
            'version' => 'latest',
            'region' => $amazon['email_region'],
            'credentials' => array(
                'key' => $amazon['AWSAccessKeyId'],
                'secret' => $amazon['AWSSecretKey'],
            ),
        ));

        try {
            $result = $client->sendRawEmail(array('RawMessage' => array('Data' => $header)));
                                                   $messageId = $result->get('MessageId');
            $response['result'] = $result;
        } catch (Exception $e) {
            //echo("The email was not sent. Error message: ");
            $response['errors'] = $e->getMessage()."\n";

//                                                    $response['errors'][] = $this->get_stripe_errors($e);
        }
        return $response;
    }



}
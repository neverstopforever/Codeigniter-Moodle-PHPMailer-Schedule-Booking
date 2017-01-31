<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body style="text-align: center;">
<h2><?php echo $this->lang->line('quotes_cashed_quote'); ?></h2>

     <table class="table table-striped" cellspacing="1" cellpadding="1" style=" margin: 0 auto;">
         <colgroup>
             <col width="15%">
             <col width="15%">
             <col width="15%">
             <col width="15%">
             <col width="15%">
             <col width="25%">
         </colgroup>
         <thead>
         <tr class='warning'>
             <th></th>
             <th></th>
         </tr>
         </thead>
         <tbody>
         <tr>
             <td><?php echo $this->lang->line('quotes_reference'); ?><td>
             <td><?php echo isset($quote->referencia) ? $quote->referencia : ''; ?><td>
         <tr>
         <tr>
             <td><?php echo $this->lang->line('quotes_service'); ?><td>
             <td><?php echo isset($quote->concepto) ? $quote->concepto : ''; ?><td>
         <tr>
         <tr>
             <td class="text-danger"><?php echo $this->lang->line('quotes_amount'); ?><td>
             <td><?php echo isset($quote->IMPORTE) ? round($quote->IMPORTE,2) : 0; ?><td>
         <tr>
         <tr>
             <td class="text-danger"><?php echo $this->lang->line('quotes_appointment_date'); ?><td>
             <td><?php echo isset($quote->FECHA_VTO ) ? date('Y-m-d',strtotime($quote->FECHA_VTO)) : date('Y-m-d') ; ?><td>
         <tr>
         <tr>
             <td class="text-danger"><?php echo $this->lang->line('quotes_invoiced'); ?><td>
             <td><?php echo isset($quote->N_FACTURA) && (is_null($quote->N_FACTURA) || $quote->N_FACTURA < 1) ? 'Not Invoiced' : $this->lang->line('quotes_invoiced') ; ?><td>
         <tr>
         <tr>
             <td class="text-danger"><?php echo $this->lang->line('quotes_payment_type'); ?><td>
             <td>
             <?php if(isset($quote->ID_FP)) {
                 switch ($quote->ID_FP) {
                     case "0":
                         $payment_type = $this->lang->line('quotes_cash');
                         break;
                     case "1":
                         $payment_type = $this->lang->line('quotes_credit_card');
                         break;
                     case "2":
                         $payment_type = $this->lang->line('quotes_direct_debit');
                         break;
                     case "3":
                         $payment_type = $this->lang->line('quotes_transfer');
                         break;
                     case "4":
                         $payment_type = $this->lang->line('quotes_check');
                         break;
                     case "5":
                         $payment_type = $this->lang->line('quotes_financed');
                         break;
                     case "6":
                         $payment_type = $this->lang->line('quotes_online_payment');
                         break;
                     default:
                         $payment_type = '';
                 }

                 echo $payment_type;
             }else{
                 echo '';
             }
             ?>
             <td>
         <tr>
         <tr>
             <td class="text-danger"><?php echo $this->lang->line('quotes_state'); ?><td>
             <td><?php echo $this->lang->line('quotes_cashed'); ?><td>
         <tr>
         </tbody>
     </table>


 </body>
<footer>
</footer>
</html>
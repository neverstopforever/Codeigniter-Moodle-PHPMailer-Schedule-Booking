<body style="font-family: Helvetica,arial,sans-serif; font-size: 14px; color:#222;">
   <header>
   <!--   <img src="--><?php //echo @$customer_logo; ?><!--" />-->


   </header>

<div style="color:#222;">
   <h3 style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text1'); ?> </h3>
   <p style="color:#222;"><?php echo $this->lang->line('cpanel_hi'); ?> <strong><?php echo $this->lang->line('cpanel_admin'); ?></strong></p>
   <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text2'); ?> </p>
   <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text3'); ?> </p>
   <?php if(isset($lang) && $lang == "spanish"){ ?>
      <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text3/1'); ?> </p>
      <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text3/2'); ?> </p>
   <?php } ?>
<!--   <p style="color:#222;">--><?php //echo $this->lang->line('cpanel_paid_transfer_email_message_text4'); ?><!-- <a href="--><?php //echo @$invoice_url; ?><!--" style="color: #5bbc2e;" target="_blank"> --><?php //echo $this->lang->line('paymentsystem_view_invoice'); ?><!--</a> </p>-->
   <!--<p>--><?php //echo $this->lang->line('cpanel_paid_transfer_email_message_text4'); ?><!--<a href="--><?php //echo $_base_url; ?><!--advancedSettings/billing_information?tab=subscribers_tab" style="color: #5bbc2e;" target="_blank"> --><?php //echo $this->lang->line('paymentsystem_view_invoice'); ?><!--</a> </p>-->
   <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text5'); ?> </p>
   <br/>
      <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text6'); ?> </p>
   <p style="color:#222;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text7'); ?> </p>
   <p style="color:#666666">
      <?php echo $this->lang->line('cpanel_paid_transfer_email_message_text8'); ?>
      <a href="www.akaud.com" target="_blank" ><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text9'); ?></a>
      <?php echo $this->lang->line('cpanel_paid_transfer_email_message_text10'); ?>
   </p>
   <p style="color:#666666; font-size: 12px">
      <?php echo $this->lang->line('cpanel_paid_transfer_email_message_text11'); ?>
      <a href="mailto:admin@akaud.com" target="_blank" style="color:#666666;"><?php echo $this->lang->line('cpanel_paid_transfer_email_message_text12'); ?></a>
      <?php echo $this->lang->line('cpanel_paid_transfer_email_message_text13'); ?>
   </p>

</div>
      <footer>


      </footer>
</body>

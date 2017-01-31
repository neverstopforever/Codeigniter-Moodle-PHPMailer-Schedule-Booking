<body style="font-family: Helvetica,arial,sans-serif; font-size: 14px; color:#222;">
    <header>    
    </header>
    <p style="color: #222;" ><?php echo $this->lang->line('activation_email_hi'); ?> <strong> <?php echo $user_name; ?></strong>   </p>
    <p style="color: #222;"><?php echo $this->lang->line('activation_email_text1') . ' ' .$company_name.' '. $this->lang->line('activation_email_text11') ; ?></p>
    <p style="color: #222;"><?php echo $this->lang->line('activation_email_text2'); ?></p>
    <p style="color: #222;"><a href="<?php echo $href; ?>">  <?php echo $this->lang->line('activation_email_text3'); ?></a></p>
    <p style="color: #222;"><?php echo $this->lang->line('activation_email_text4') .' ' . $keycode .' ' .$this->lang->line('activation_email_text5') ; ?> </p>
    <br/>
    <p style="color: #222;"><?php echo $this->lang->line('activation_email_text6'); ?></p>
    <p style="color: #222;"><?php echo $this->lang->line('activation_email_text7'); ?></p>
    <p style="color: #222;"><?php echo $company_name; ?></p>
    <footer>
    </footer>
</body>
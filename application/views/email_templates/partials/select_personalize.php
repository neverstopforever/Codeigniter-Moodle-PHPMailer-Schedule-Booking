<select class="form-control" name="personalize" id="personalize">
    <option value="[FIRSTNAME]"><?php echo $this->lang->line('email_templates_df_first_name');?></option>
    <option value="[SURNAME]"><?php echo $this->lang->line('email_templates_df_surname');?></option>
    <option value="[FULLNAME]"><?php echo $this->lang->line('email_templates_df_full_name');?></option>
    <option value="[PHONE1]"><?php echo $this->lang->line('email_templates_df_phone') . '1';?></option>
    <option value="[PHONE2]"><?php echo $this->lang->line('email_templates_df_phone') . '2';?></option>
    <option value="[MOBILE]"><?php echo $this->lang->line('email_templates_df_mobile');?></option>
    <option value="[EMAIL1]"><?php echo $this->lang->line('email_templates_df_email') . ' 1';?></option>
    <option value="[EMAIL2]"><?php echo $this->lang->line('email_templates_df_email') . ' 2';?></option>
    <option value="[USERNAME]"><?php echo $this->lang->line('email_templates_df_user_name');?></option>
</select>
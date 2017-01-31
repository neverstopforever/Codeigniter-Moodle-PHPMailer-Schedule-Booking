<div class="page-container campaigns_edit_sent_page">


        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class=" page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_crm'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $_base_url; ?>campaigns" ><?php echo $this->lang->line('menu_campaigns'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('edit'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                    <div class="clear"></div>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label  class="col-sm-3 "><strong><?php echo $this->lang->line('campaigns_name_campaign'); ?></strong> </label>
                            <div class="col-sm-9">
                                <?php echo $campaign->title; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 "><strong><?php echo $this->lang->line('campaigns_new_date_sending'); ?></strong> </label>
                            <div class="col-sm-9">
                                <?php echo date($datepicker_format, strtotime($campaign->date_sending)); ?>
                            </div>
                        </div>


                        <?php
                        $campaign_folder = '';
                        if (!empty($folders)) {
                            foreach ($folders as $folder) {
                                if ($folder->id_folder == $campaign->id_folder) {
                                    $campaign_folder = $folder->title;
                                    break;
                                }
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label  class="col-sm-3 "><strong><?php echo $this->lang->line('folder'); ?></strong> </label>
                            <div class="col-sm-9">
                                <?php echo $campaign_folder; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 "><strong><?php echo $this->lang->line('state'); ?></strong> </label>
                            <div class="col-sm-9">
                                <?php echo $this->lang->line('_sent'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 "><strong><?php echo $this->lang->line('subject'); ?></strong> </label>
                            <div class="col-sm-9">
                                <?php echo $campaign->Subject; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea name="campaign_body" id="campaign_body" rows="10" cols="80" class="form-control"><?php echo html_purify($campaign->Body); ?></textarea>
                        </div>
                        <div class="form-group back_save_group">
                            <a type="button" href="/campaigns" class="btn btn-circle btn-default-back  margin-right-10  campaigns_edit_sent_page_back"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back');?></a>
                        </div>
                        <div class="form-group margin-top-20">

                                <h3 class="margin-bottom-10"><?php echo $this->lang->line('campaigns_recipients');?></h3>
                            <div class="no_sent_recipients margin-top-20" style="display: none"></div>
                                <table id="sent_recipients" class="table dbtable_hover_theme display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('surname'); ?></th>
                                            <th><?php echo $this->lang->line('first_name'); ?></th>
                                            <th><?php echo $this->lang->line('email'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($sent_recipients) && !empty($sent_recipients)) {?>
                                        <?php foreach($sent_recipients as $sent_recipient){ ?>
                                            <tr>
                                                <td><?php echo $sent_recipient->surname;?></td>
                                                <td><?php echo $sent_recipient->first_name;?></td>
                                                <td><?php echo $sent_recipient->email;?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>

                                    <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>

</div>

<script>
    var  selected_recipients = <?php echo isset($selected_recipients) ? json_encode($selected_recipients) : json_encode(array()); ?>;
    var _campaign_id = <?php echo $campaign_id; ?>;

    var  surname_data = <?php echo isset($surname_data) ? json_encode($surname_data) : json_encode(array()); ?>;
    var  first_name_data = <?php echo isset($first_name_data) ? json_encode($first_name_data) : json_encode(array()); ?>;
    var  email_data = <?php echo isset($email_data) ? json_encode($email_data) : json_encode(array()); ?>;
</script>
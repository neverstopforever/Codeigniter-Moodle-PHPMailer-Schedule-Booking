<div class="page-container system_settings">
 <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
            </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
            <li class="active">
                <?php echo $this->lang->line('cancel_subscription'); ?>
            </li>
            </ul>
            <div class="portlet light">
                <div class="cancel_subscription col-sm-10 col-md-8">
                    <div class="cancel_subscription_header">
                        <h3><i class="fa fa-ban text-danger" aria-hidden="true"></i> <?php echo $this->lang->line('cancel_subscription_text1'); ?></h3>
                        <p><strong><?php echo $this->lang->line('cancel_subscription_text2'); ?></strong></p>
                    </div>
                    <p><?php echo $this->lang->line('cancel_subscription_text3'); ?></p>
                    <p><?php echo $this->lang->line('cancel_subscription_text4'); ?></p>
                    <p><?php echo $this->lang->line('cancel_subscription_text'); ?></p>
                    <button class="btn btn-danger btn-circle margin-top-20 cancel_delete_subscription_btn"> <i class="fa fa-times" aria-hidden="true"></i> <?php echo $this->lang->line('cancel_subscription_cancel_and_delete'); ?></button>

                </div>
            </div>

        </div>
 </div>
</div>
<div class="modal fade" id="subscription_cancel_delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('cancel_subscription_delete_modal_title_text'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('cancel_subscription_delete_modal_text1'); ?></p>
                <p><?php echo $this->lang->line('cancel_subscription_delete_modal_text2'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_blog subscription_plan_confirm"  ><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="page-lock">
    <div class="page-logo">
        <a href="<?php echo base_url() ?>"> <img src="<?php echo base_url() ?>assets/img/header_logo.png" alt="logo"/></a>
    </div>
    <div class="page-body">
        <div class="lock-head"> <?php echo $this->lang->line('locked_profile_account_locked'); ?> </div>
        <div class="lock-body">
            <div class="pull-left lock-avatar-block">
                <img class="lock-avatar" src="<?php echo $user->photo ? 'data:image/jpeg;base64,'.base64_encode($user->photo) : base_url().'assets/img/dummy-image.jpg'; ?>" alt="prfile photo">
            </div>
            <div class="lock-form pull-left">
                <h4><?php echo $user->name; ?></h4>
                <span class="email">
                    <?php echo $user->email; ?>
                </span>

            </div>
        </div>
        <div class="lock-bottom">
            <a href="#" data-toggle="modal" data-target="#locked_profile_modal"> <?php echo $this->lang->line('locked_profile_why_occurs_this'); ?></a>
        </div>
    </div>
<!--    <div class="page-footer-custom"> 2014 © Metronic. Admin Dashboard Template. </div>-->
</div>

<div class="modal fade" id="locked_profile_modal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header lock-head">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('locked_profile_why_occurs_this'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('locked_profile_modal_text1'); ?></p>
                <p><?php echo $this->lang->line('locked_profile_modal_text2'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




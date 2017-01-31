<div class="page-container">
    <!-- BEGIN PAGE HEAD -->

        
        <div class="page-content">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="<?php echo $layoutClass ?>">
                <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li >
                        <a href="<?php echo $_base_url; ?>cpanel/alerts" ><?php echo $this->lang->line('cpanel_alerts_menu'); ?></a>
                    </li>
                    <li class="active" >
                        <?php echo $this->lang->line('edit'); ?>
                    </li>
                </ul>
                <div class="portlet light overf_hidden">
                    <div class="portlet-body">
<!--                        <div class="col-md-12">-->
<!--                            <a href="--><?php //echo base_url() ?><!--cpanel/alerts" class="btn btn-success pull-right">&times;</a>-->
<!--                        </div>-->
                        <div class="wizard-container cpanel_alert_edit">
                            <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                <div class="wizard-header">
                                    <h3 class="margin-left-20">
                                        <?php echo $this->lang->line('cpanel_editTitle'); ?>
                                    </h3>
                                </div>
                                <?php $this->load->view('cpanel/partials/add_edit_alerts_form'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
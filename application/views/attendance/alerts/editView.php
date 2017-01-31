<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_clientes'); ?></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <div class="page-content">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="<?php echo $layoutClass ?>">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="col-md-12">
                            <a href="<?php echo base_url() ?>alerts" class="btn btn-success pull-right">&times;</a>
                        </div>
                        <div class="wizard-container">
                            <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                <div class="wizard-header">
                                    <h3>
                                        <?php echo $this->lang->line('alerts_editTitle'); ?>
                                    </h3>
                                </div>
                                <?php $this->load->view('alerts/partials/add_edit_form'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
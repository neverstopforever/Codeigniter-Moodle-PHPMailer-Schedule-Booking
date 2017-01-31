<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <!-- END PAGE HEAD -->
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li>
            <a href="/"><?php echo $this->lang->line('menu_Home'); ?></a>
        </li>
        <li class="">
            <a href="<?php echo base_url('clientes'); ?>"> <?php echo $this->lang->line('menu_clientes'); ?></a>
        </li>
        <li class="active">
            <?php echo isset($add_edit) ? $add_edit : ''; ?>
        </li>
    </ul>
    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content clientes">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="portlet box sections ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i> <?php echo $this->lang->line('clientes_description'); ?></div>
                    </div>
                    <div class="portlet-body">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_general" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('clientes_general'); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_informes" data-toggle="tab"
                                       aria-expanded="true"> <?php echo $this->lang->line('clientes_informes'); ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tools">
                                </div>

                                <div class="tab-pane active student_sub_tab" id="tab_general">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_commercial_data" data-toggle="tab"
                                                   aria-expanded="true"> <?php echo $this->lang->line(
                                                        'clientes_commercial_data'
                                                    ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_billing_data" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_billing_data'
                                                        ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_employees" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_employees'
                                                        ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_documents" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_documents'
                                                        ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_follow_up" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_follow_up'
                                                        ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_subsidiaries" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                        'clientes_subsidiaries'
                                                    ); ?> </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="portlet-body no-padding">
                                        <div class="tab-content no-padding">
                                            <div class="tab-pane active" id="tab_commercial_data">
                                                
                                            </div>
                                            <div class="tab-pane" id="tab_billing_data">
                                                
                                            </div>
                                            <div class="tab-pane" id="tab_employees">
                                                
                                            </div>
                                            <div class="tab-pane" id="tab_documents">
                                                
                                            </div>
                                            <div class="tab-pane" id="tab_follow_up">

                                            </div>
                                            <div class="tab-pane" id="tab_subsidiaries">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane student_sub_tab" id="tab_informes">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_historic_fees" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_historic_fees'
                                                        ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_historic_accounts" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_historic_account'
                                                        ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_templates" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                            'clientes_templates'
                                                        ); ?> </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body no-padding">
                                        <div class="tab-content no-padding">
                                            <div class="tab-pane active" id="tab_historic_fees">
                                                
                                            </div>
                                            <div class="tab-pane" id="tab_historic_accounts">
                                                
                                            </div>
                                            <div class="tab-pane" id="tab_templates">
                                                tab_templates
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>

                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
    <script>
        var _clientId = "<?php echo isset($clientId) ? $clientId: null; ?>";
    </script>
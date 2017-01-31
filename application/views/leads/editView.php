<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <!-- END PAGE HEAD -->

    <!-- BEGIN PAGE CONTENT -->
    <div class="table_loading"></div>
    <div class="page-content companies">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_crm'); ?></a>
                </li>
                <li class="">
                    <a href="<?php echo $_base_url; ?>prospects"> <?php echo $this->lang->line('menu_prospects'); ?></a>
                </li>
                <li class="active">
                    <?php echo isset($add_edit) ? $add_edit : ''; ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="portlet box sections ">
                    <div class="portlet-body">
                        <div class="tabbable-line">

                            <div class="tab-content">
                                <div class="tools">
                                </div>

                                <div class="tab-pane active student_sub_tab" id="tab_general">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_personal_data" data-toggle="tab"
                                                   aria-expanded="true"> <?php echo $this->lang->line(
                                                        'leads_personal_data'
                                                    ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_details" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                        'leads_details'
                                                    ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_documents" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                        'leads_documents'
                                                    ); ?> </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_follow_up" data-toggle="tab"
                                                   aria-expanded="false"> <?php echo $this->lang->line(
                                                        'leads_follow_up'
                                                    ); ?> </a>
                                            </li>
<!--                                            <li class="">-->
<!--                                                <a href="#tab_templates" data-toggle="tab"-->
<!--                                                   aria-expanded="false"> --><?php //echo $this->lang->line(
//                                                        'leads_templates'
//                                                    ); ?><!-- </a>-->
<!--                                            </li>-->
                                        </ul>
                                    </div>

                                    <div class="portlet-body no-padding">
                                        <div class="tab-content no-padding">
                                            <div class="tab-pane active" id="tab_personal_data">

                                            </div>
                                            <div class="tab-pane" id="tab_billing_data">

                                            </div>
                                            <div class="tab-pane" id="tab_details">

                                            </div>
                                            <div class="tab-pane" id="tab_documents">

                                            </div>
                                            <div class="tab-pane" id="tab_follow_up">

                                            </div>
<!--                                            <div class="tab-pane" id="tab_templates">-->
<!---->
<!--                                            </div>-->
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

    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $this->lang->line('templates');?></h4>
                </div>
                <div class="modal-body" align="center">
                    <div class="select_template"></div>
                    <div id="previewFrame" class="margin-top-20" ></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary print_template"><?php echo $this->lang->line('leads_print'); ?></button>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        var _clientId = "<?php echo isset($clientId) ? $clientId: null; ?>";
        var _prospect_data_ = <?php echo json_encode($prospect_data); ?>;
    </script>
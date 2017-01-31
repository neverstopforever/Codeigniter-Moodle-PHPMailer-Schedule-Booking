<div class="page-container">
    <!-- BEGIN PAGE HEAD -->

      

        <div class="table_loading"></div>
        <div class="page-content">
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('cpanel_alerts_menu'); ?>
                </li>
            </ul>
           
            <div class="<?php echo $layoutClass ?>">
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="portlet light">
                    <div class="nodata" style="display:none; text-align:center;">
                        <a class="btn btn-primary btn-lg add_rcd"  href="<?php echo base_url() ?>/cpanel/addAlert"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
                    </div>
                    <div class=" index_table">
                        <div class="col-md-12">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="tabs_container alerts_table" style="display:none;">
                                <div class="card">
                                    <div class="tab temp" style="display:none;">
                                        <li role="presentation" class="tab_link" style="display:none;"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text"> </span> <i class="fa fa-trash link_trash"></i></a></li>
                                    </div>
                                    <ul class="nav nav-tabs" role="tablist">
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="content temp" style="display:none;">
                                        <div role="tabpanel" class="tab-pane" id="table1"></div>
                                    </div>
                                    <div class="tab-content">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    

</div>
<div class="modal fade" id="delete_alert" tabindex="-1" role="delete_alert" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo $this->lang->line('alerts_delete'); ?></h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo $this->lang->line('are_you_sure'); ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark " data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                <a type="button" href="#" class="btn blue" id="delete_alert_modal"><?php echo $this->lang->line('alerts_delete'); ?></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--</body>-->
<!---->
<!--</html>-->

        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">



            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_tables'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light">
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn-group pull-right">
                                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                    Print </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                    Save as PDF </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                    Export to Excel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table mainTable table-striped table-hover table-bordered" id="sample_editable_1">
                                        <thead>
                                            <tr>
                                                <th>IdMedio</th>
                                                <th>Descripcion</th>
                                                <th>Entries</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN QUICK SIDEBAR -->
        <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
        </div>



                <form class="addMainTableForm">
            <div class="modal fade" id="addMainTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Tasks_addMainTableTitle') ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=" control-label">
                                   IdMedio
                                </label>
                                <div class="">
                                    <input type="text" class="form-control IdMedio">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                     Descripcion
                                </label>
                                <div class="">
                                    <input type="text" class="form-control Descripcion">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <?php echo $this->lang->line("button_modalClose") ?>
                            </button>
                            <button type="submit" class="btn btn-primary addtag">
                                Save Table  
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <!-- END PAGE CONTAINER -->

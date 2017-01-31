<div class="page-container login_superadmin">
        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="/"><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('cpanel_superadmin'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('cpanel_login_as_super_admin'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                    <form class="form-horizontal" method="post">
                     <div class="form-group">
                        <div class="col-sm-5">
                            <input id="select_client" class="form-control" />
                         </div>
                        <div class="col-sm-4">
                            <input class="form-control client_key" name="key_code" placeholder="key" />
                         </div>
                     </div>
                    <div class="form-group">
                        <div class="col-sm-5">

                         </div>
                        <div class="col-sm-4 text-right">
                                <button type="submit" class="btn btn-success margin-top-10"><?php echo $this->lang->line('cpanel_login'); ?></button>

                        </div>
                    </form>
                     </div>

                    <div class="clearfix"></div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
</div>


<script>
    var _clients_data = <?php echo isset($clients_data) ? json_encode($clients_data) : json_encode(array()); ?>//;
    var db_connnection_error = <?php echo isset($db_connnection_error) ? json_encode($db_connnection_error) : 0; ?>;
</script>

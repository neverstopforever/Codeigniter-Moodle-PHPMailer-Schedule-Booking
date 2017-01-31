
<div class="page-container customer_accounts">


        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="/"><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_customers'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('menu_manage_transfers'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                        <div id="ClientsTransfersTable">

                        </div>
                    <div class="clearfix"></div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>


</div>

<div class="modal fade" id="deleteCustomerModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_customer"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var _clients_transfers = <?php echo isset($clients_transfers) ? json_encode($clients_transfers) : json_encode(array()); ?>;
    var _plan_fields = <?php echo isset($plan_fields) ? json_encode($plan_fields) : json_encode(array()); ?>;
    var _customers = <?php echo isset($customers) ? json_encode($customers) : json_encode(array()); ?>;
</script>



<div class="page-container customer_accounts">


        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="/"><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_coupons'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('menu_manage_coupons'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                        <div id="couponsTable">

                        </div>
                    <div class="clearfix"></div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>


</div>

<div class="modal fade" id="deleteCouponModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_coupon"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var _coupons = <?php echo isset($coupons) ? json_encode($coupons) : json_encode(array()); ?>;
</script>

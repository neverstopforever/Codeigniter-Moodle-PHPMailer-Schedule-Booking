<div class="page-container">
    <!-- BEGIN PAGE HEAD -->


        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $_base_url; ?>help" ><?= $this->lang->line('menu_Help') ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('help_releases'); ?>
                    </li>
                </ul>
                <div class="portlet light help_releases">
    
                </div>
            </div>
        </div>
</div>
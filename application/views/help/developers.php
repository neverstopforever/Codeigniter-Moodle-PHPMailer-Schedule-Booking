<div class="page-container">
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
                        <?php echo $this->lang->line('help_developers'); ?>
                    </li>
                </ul>
                <div class="portlet light help_developers text-center">
                    <img src="<?php echo $_base_url; ?>assets/img/coming_soon.jpg" alt="coming_soon">
                </div>
            </div>
        </div>
</div>
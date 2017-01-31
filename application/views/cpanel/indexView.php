<div class="page-container">


        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">                
                    <li>
                        <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('cpanel_index_menu'); ?>
                    </li>
                </ul>
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="portlet light cpanel_first_page">
                    <div class="alert alert-success">
                        <h3 class="text-center margin-top-0"><?php echo $this->lang->line('cpanel_welcome_dashboard'); ?></h3>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>


</div>


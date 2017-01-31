<div class="page-container">
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_information'); ?></h1>
            </div>
        </div>
    </div>
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
        <li class="active"><?php echo $this->lang->line('dashboard'); ?></li>
    </ul>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-content-inner">
                <?php
                if($user_role == 1){ //teacher
                    $this->load->view("campus/partials/teacherView");
                }elseif($user_role == 2){ //student
                    $this->load->view("campus/partials/studentView");
                }?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
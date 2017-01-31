<!-- BEGIN HEADER -->
<div class="page-header wsmenucontainer clearfix">
    <div class="wsmenucontent overlapblackbg"></div>
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN LOGO -->
            <div class="page-logo ">
                <?php
                $site_logo = base_url().'assets/img/logo-akaud.png';
                if(!empty($variables2->logo)){
                    $site_logo = $variables2->logo;
                }
                ?>
                <a href="<?php echo base_url() ?>campus"><img src="<?php echo $site_logo; ?>" alt="logo" class="logo-default"></a>
            </div>

            <a href="javascript:;" class="menu-toggler"></a>

            <div class="top-menu top-menu_first  visible-xs visible-sm">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->

               
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->

                    <!-- END TODO DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user ">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="">
                            <span class="username username-hide-mobile"></span>
                        </a>
                        <?php
                        $campus_top_menu_json = 'campus_top_menu.json';
                        $topMenuJSON = file_get_contents(base_url().'app/'.$campus_top_menu_json);
                        $topMenus = json_decode($topMenuJSON);
                        // echo '<pre>';var_dump($topMenus);exit;
                        if(isset($campus_user_role) && isset($topMenus[0])){
                            if ($campus_user_role == 1) { //teacher
                                $top_menu_data = $topMenus[0]->teacher;
                            }elseif($campus_user_role == 2){ //student
                                $top_menu_data = $topMenus[0]->student ;
                            }
                        }

                        ?>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <?php if(isset($top_menu_data) && !empty($top_menu_data)) {?>
                                <?php foreach($top_menu_data as $top_menu){ ?>
                                    <li>
                                        <a href="<?php echo base_url().$top_menu->link; ?>">
                                            <i class="<?php echo $top_menu->icon; ?>"></i>
                                            <?php echo $this->lang->line($top_menu->langLine); ?>
                                        </a>
                                    </li>
                                <?php } ?>

                            <?php } ?>

                            <!--<li>
                                <a href="<?php /*echo base_url() */?>campus/profile-settings">
                                    <i class="icon-settings"></i>
                                    <?php /*echo $this->lang->line('profile_setting'); */?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php /*echo base_url() */?>campus/auth/logout/">
                                    <i class="icon-key"></i>
                                    <?php /*echo $this->lang->line('menu_logout'); */?>
                                </a>
                            </li>-->
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-extended quick-sidebar-toggler">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <a href="javascript:;" class="dropdown-toggle template_settings_icon">
                            <i class="fa fa-cogs"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="page-header-menu">

                <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                <?php
                $campus_menu_json = 'campus_menu.json';
                if(isset($campus_user_role)){
                    if ($campus_user_role == 1) { //teacher
                        $campus_menu_json = 'campus_teacher_menu.json';
                    }elseif($campus_user_role == 2){ //student
                        $campus_menu_json = 'campus_student_menu.json';
                    }
                }
                $menuJSON = file_get_contents(base_url().'app/'.$campus_menu_json);
                $menus = json_decode($menuJSON);
                ?>
                <nav class="hor-menu">
                    <ul class="nav navbar-nav">
                        <?php
                        foreach ($menus as $menu) {
                            if ($menu->subMenu != null){
                                if ($menu->megamenu == "megamenu"){
                                    ?>
                                    <li class="menu-dropdown mega-menu-dropdown active mega-menu-full <?php if ($page == $menu->menuItem) { ?> active <?php } ?>">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><?php echo (!empty($menu->langLine)) ? ($this->lang->line(                              $menu->langLine
                                        )) : $menu->menuItem; ?> <span class="arrow"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <?php $count = count($menu->subMenu); ?>
                                                    <?php foreach ($menu->subMenu as $key => $subMenu) {
                                                    echo ($key == 0 || $key % 5 == 0) ? '<div class="col-md-3"><ul class="mega-menu-submenu">' : "";
                                                    ?>
                                        <li>
                                            <a href="<?php echo base_url().$subMenu->link ?>">
                                                <?php echo (!empty($subMenu->icon)) ? '<i class="'.$subMenu->icon.'"></i>' : ""; ?>
                                                <?php echo !empty($subMenu->langLine) ? ($this->lang->line(
                                                    $subMenu->langLine
                                                )) : $subMenu->menuItem; ?></a>
                                        </li>
                                        <?php
                                        echo ($key % 5 == 4 || $key == ($count - 1)) ? "</ul></div>" : "";
                                        } ?>


                                        </li>
                                    </ul>
                                <?php }elseif ($menu->megamenu == "submenu"){
                                    ?>
                                    <li class="menu-dropdown classic-menu-dropdown  <?php if ($page == $menu->menuItem) { ?> active <?php } ?>">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true"><?php echo (!empty($menu->langLine)) ? ($this->lang->line(
                                            $menu->langLine
                                        )) : $menu->menuItem; ?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu pull-left">
                                        <?php foreach ($menu->subMenu as $subMenu) { ?>
                                            <li>
                                                <a href="<?php echo base_url().$subMenu->link ?>">
                                                    <?php echo (!empty($subMenu->icon)) ? '<i class="'.$subMenu->icon.'"></i>' : ""; ?>
                                                    <?php echo !empty($subMenu->langLine) ? ($this->lang->line(
                                                        $subMenu->langLine
                                                    )) : $subMenu->menuItem; ?></a>
                                            </li>
                                            <?php
                                        } ?>
                                    </ul>
                                <?php }
                            }else{ ?>
                                <li class="<?php if ($page == $menu->menuItem) { ?> active <?php } ?>">
                                <a href="<?php echo base_url().$menu->link ?>"><?php echo (!empty($menu->langLine)) ? ($this->lang->line(
                                        $menu->langLine
                                    )) : $menu->menuItem; ?></a>
                            <?php }
                            ?>

                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>




            <div class="top-menu  hidden-xs hidden-sm">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->

                
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->

                    <!-- END TODO DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user ">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="">
                            <span class="username username-hide-mobile"></span>
                        </a>
                        <?php
                        $campus_top_menu_json = 'campus_top_menu.json';
                        $topMenuJSON = file_get_contents(base_url().'app/'.$campus_top_menu_json);
                        $topMenus = json_decode($topMenuJSON);
                       // echo '<pre>';var_dump($topMenus);exit;
                        if(isset($campus_user_role) && isset($topMenus[0])){
                            if ($campus_user_role == 1) { //teacher
                                $top_menu_data = $topMenus[0]->teacher;
                            }elseif($campus_user_role == 2){ //student
                                $top_menu_data = $topMenus[0]->student ;
                            }
                        }

                        ?>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <?php if(isset($top_menu_data) && !empty($top_menu_data)) {?>
                                <?php foreach($top_menu_data as $top_menu){ ?>
                                    <li>
                                        <a href="<?php echo base_url().$top_menu->link; ?>">
                                            <i class="<?php echo $top_menu->icon; ?>"></i>
                                            <?php echo $this->lang->line($top_menu->langLine); ?>
                                        </a>
                                    </li>
                                <?php } ?>

                            <?php } ?>

                        <!--<li>
                                <a href="<?php /*echo base_url() */?>campus/profile-settings">
                                    <i class="icon-settings"></i>
                                    <?php /*echo $this->lang->line('profile_setting'); */?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php /*echo base_url() */?>campus/auth/logout/">
                                    <i class="icon-key"></i>
                                    <?php /*echo $this->lang->line('menu_logout'); */?>
                                </a>
                            </li>-->
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-extended quick-sidebar-toggler">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <a href="javascript:;" class="dropdown-toggle template_settings_icon">
                             <i class="fa fa-cogs"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->

    <!-- END MEGA MENU -->
</div>
</div>
<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->

<?php $remaining_days = $this->session->userdata('remaining_days');
$remaining_days_show = $this->session->userdata('remaining_days_show');?>

<?php if($remaining_days !== null){ ?>
    <div class="free_trial_note free_trial_note_min visible-sm visible-xs">
        <div id="free_trial_toast-container_min" class="toast-top-center" aria-live="polite" role="alert">
            <div class="toast toast-error">
                <?php if($remaining_days <= 0){ ?>
                    <div class="toast-message"><?php echo $this->lang->line('account_in_free_plan'); ?>  <a href="<?php echo base_url() ?>/subscription-plans" type="button" class="btn btn-sm btn-outline white "><?php echo $this->lang->line('account_upgrade_now'); ?></a></div>
                <?php }else{?>
                    <div class="toast-message"><?php echo $this->lang->line('remaining_days_to_trial'); ?> <strong> <?php echo $remaining_days; ?> </strong> <a href="<?php echo base_url() ?>/subscription-plans" type="button" class="btn btn-sm btn-outline white "><?php echo $this->lang->line('account_upgrade_now'); ?></a></div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>
<div class="page-quick-sidebar-wrapper">
    <div class="page-quick-sidebar">
        <div class="nav-justified">
            <h3 class="list-heading"><?php echo $this->lang->line('header_sidebarHeading'); ?></h3>
            <ul class="list-items borderless">
                <li>
                    <label class="control-label">
                        <?php echo $this->lang->line('header_languagePlaceholder'); ?>
                    </label>
                    <select class="form-control languageChange">
                        <option value="english" <?php if ($lang == 'english'){ ?>selected
                            <?php } ?>>English
                        </option>
                        }
                        <option value="spanish" <?php if ($lang == 'spanish'){ ?>selected
                            <?php } ?>>Spanish
                        </option>
                        }
                    </select>
                    <div class="waitplz" style="display:none;">
                        <?php echo $this->lang->line('header_pleaseWait') ?>
                    </div>
                </li>
                <li>
                    <label class="control-label">
                        <?php echo $this->lang->line('header_themeColorPlaceholder'); ?>
                    </label>
                    <select class="form-control themeColorChange">
                        <option value="dark_blue" <?php if ($color == 'dark_blue'){ ?>selected
                            <?php } ?>>Dark Blue(default)
                        </option>
                        <option value="light_blue" <?php if ($color == 'light_blue'){ ?>selected
                            <?php } ?>>Light Blue
                        </option>
                        <option value="yellow" <?php if ($color == 'yellow'){ ?>selected
                            <?php } ?>>Yellow
                        </option>
                        <option value="green" <?php if ($color == 'green'){ ?>selected
                            <?php } ?>>Green
                        </option>
                        <option value="dark_gray" <?php if ($color == 'dark_gray'){ ?>selected
                            <?php } ?>>Dark Gray
                        </option>
                        <option value="light_gray" <?php if ($color == 'light_gray'){ ?>selected
                            <?php } ?>>Light Gray
                        </option>
                        <option value="light_orange" <?php if ($color == 'light_orange'){ ?>selected
                            <?php } ?>>Light Orange
                        </option>
                        <option value="dark_orange" <?php if ($color == 'dark_orange'){ ?>selected
                            <?php } ?>>Dark Orange
                        </option>

                        <option value="fucsia" <?php if ($color == 'fucsia'){ ?>selected
                            <?php } ?>>Fucsia
                        </option>

                        <option value="pink" <?php if ($color == 'pink'){ ?>selected
                            <?php } ?>>Pink
                        </option>
                        <option value="brown" <?php if ($color == 'brown'){ ?>selected
                            <?php } ?>>Brown
                        </option>
                    </select>
                    <div class="waitplz" style="display:none;">
                        <?php echo $this->lang->line('header_pleaseWait') ?>
                    </div>
                </li>
                <li>
                    <label class="control-label">
                        <?php echo $this->lang->line('header_FormatPlaceholder'); ?>
                    </label>
                    <select class="form-control layoutFormatChange">
                        <option value="fluid" <?php if ($layoutFormat == 'fluid'){ ?>selected
                            <?php } ?>>Fluid
                        </option>
                        <option value="boxed" <?php if ($layoutFormat == 'boxed'){ ?>selected
                            <?php } ?>>Boxed
                        </option>
                    </select>
                    <div class="waitplz" style="display:none;">
                        <?php echo $this->lang->line('header_pleaseWait') ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR -->

<div class="page-header-top under_page-header-top">
    <div class="container flash_msg">
        <div class="row">
            <?php if ($this->session->has_userdata('success')) { ?>
                <div class="col-xs-12  col-centered vcenter ">

                    <div class="alert alert-success fade in" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($this->session->has_userdata('errors')) { ?>
                <div class="col-xs-12 col-centered vcenter ">
                    <div class="alert alert-danger fade in" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php
                        $flash_errors = $this->session->flashdata('errors');
                        foreach ($flash_errors as $flash_error) {
                            echo $flash_error . "<br />";
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if($remaining_days !== null){ ?>
    <div class="free_trial_note hidden-sm hidden-xs">
        <div id="free_trial_toast-container" class="toast-top-center" aria-live="polite" role="alert">
            <div class="toast toast-error">
                <?php if($remaining_days <= 0){ ?>
                    <div class="toast-message"><?php echo $this->lang->line('account_in_free_plan'); ?>  <a href="<?php echo base_url() ?>/subscription-plans" type="button" class="btn btn-sm btn-outline white "><?php echo $this->lang->line('account_upgrade_now'); ?></a></div>

                <?php }else{?>
                    <div class="toast-message"><?php echo $this->lang->line('remaining_days_to_trial'); ?> <strong> <?php echo $remaining_days; ?> </strong> <a href="<?php echo base_url() ?>/subscription-plans" type="button" class="btn btn-sm btn-outline white "><?php echo $this->lang->line('account_upgrade_now'); ?></a></div>

                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>


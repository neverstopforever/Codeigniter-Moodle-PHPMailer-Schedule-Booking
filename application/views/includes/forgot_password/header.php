<!-- BEGIN HEADER -->
<div class="page-header wsmenucontainer clearfix">
    <div class="wsmenucontent overlapblackbg"></div>
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <?php
                $site_logo = base_url().'assets/img/logo-akaud.png';
                if(!empty($variables2->logo)){
                    $site_logo = $variables2->logo;
                }
                ?>
                <a href="<?php echo base_url() ?>campus"><img src="<?php echo $site_logo; ?>" alt="logo" class="logo-default"></a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="">
                            <span class="username username-hide-mobile"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                                <a href="<?php echo base_url() ?>campus/user/setting">
                                    <i class="icon-settings"></i>
                                    <?php echo $this->lang->line('profile_setting'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() ?>campus/auth/logout/">
                                    <i class="icon-key"></i>
                                    <?php echo $this->lang->line('menu_logout'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-extended quick-sidebar-toggler">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-logout"></i>
                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="<?php echo $layoutClass ?>">
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            <?php
            $menuJSON = file_get_contents(base_url().'app/campus_menu.json');
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
                        <a href="<?php echo base_url(
                            ).$menu->link ?>"><?php echo (!empty($menu->langLine)) ? ($this->lang->line(
                                $menu->langLine
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
        </div>
    </div>
    </li>
    </ul>
    <?php }elseif ($menu->megamenu == "submenu"){
    ?>
    <li class="menu-dropdown classic-menu-dropdown <?php if ($page == $menu->menuItem) { ?> active <?php } ?>">
        <a href="<?php echo base_url().$menu->link ?>"><?php echo (!empty($menu->langLine)) ? ($this->lang->line(
                $menu->langLine
            )) : $menu->menuItem; ?> <span class="arrow"></span></a>
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
                        <option value="default" <?php if ($color == 'default'){ ?>selected
                            <?php } ?>>Default
                        </option>
                        <option value="blue-hoki" <?php if ($color == 'blue-hoki'){ ?>selected
                            <?php } ?>>Blue Hoki
                        </option>
                        <option value="yellow-orange" <?php if ($color == 'yellow-orange'){ ?>selected
                            <?php } ?>>Orange
                        </option>
                        <option value="yellow-crusta" <?php if ($color == 'yellow-crusta'){ ?>selected
                            <?php } ?>>Yellow Crusta
                        </option>
                        <option value="green-haze" <?php if ($color == 'green-haze'){ ?>selected
                            <?php } ?>>Green Haze
                        </option>
                        <option value="red-sunglo" <?php if ($color == 'red-sunglo'){ ?>selected
                            <?php } ?>>Red Sunglo
                        </option>
                        <option value="red-intense" <?php if ($color == 'red-intense'){ ?>selected
                            <?php } ?>>Red Intense
                        </option>
                        <option value="purple-plum" <?php if ($color == 'purple-plum'){ ?>selected
                            <?php } ?>>Purple Plum
                        </option>
                        <option value="purple-studio" <?php if ($color == 'purple-studio'){ ?>selected
                            <?php } ?>>Purple Studio
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

<div class="page-header-top">
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
<div class="page-container">
            <!-- BEGIN PAGE HEAD -->


                <div class="table_loading"></div>
                <div class="page-content">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo 'CRM' ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo $this->lang->line('menu_applicants'); ?></a>
                            </li>
                            <li class="">
                                <a href="<?php echo $_base_url; ?>companies"> <?php echo $this->lang->line('menu_companies'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('add'); ?>
                            </li>
                        </ul>
                        <div class="portlet light">
                            <div class="portlet-body">

                                <div class="portlet light">
                                    <h2 class="companies_add_steps_title"><?php echo $this->lang->line('companies_addSmallTitle'); ?></h2>
                                    <div class="mt-element-step">
                                        <div class="row step-line">
                                            <div class="col-sm-5 mt-step-col first active col-sm-offset-1" id="template_step_1">
                                                <div class="mt-step-number bg-white">1</div>
                                                <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('setup');?></div>
                                                <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('companies_datosComerciales');?></div>
                                            </div>
                                            <div class="col-sm-5 mt-step-col last" id="template_step_2">
                                                <div class="mt-step-number bg-white">2</div>
                                                <div class="mt-step-title uppercase font-grey-cascade"><?php echo $this->lang->line('finish');?></div>
                                                <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('companies_fcturation');?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="margin-top-20" id="step_body_companys">

                                    </div>
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contactos_linkpopup">
            <div class="close_me">
                <i class="fa fa-cross"></i>
            </div>
            <table class="companies table  table-striped table-hover table-bordered ">
            </table>
        </div>
        </div>
<script>
    var _clienteId = "<?php echo $clienteId ?>";
</script>
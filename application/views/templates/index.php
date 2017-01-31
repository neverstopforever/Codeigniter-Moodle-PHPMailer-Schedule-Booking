<div class="page-container">
    <div class="table_loading"></div>
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_plantillas'); ?>
                </li>
            </ul>
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-xs-6 filter_category circle_select_div">
                            <label for="cat_id"><?php echo $this->lang->line('template_filter_cat');?></label>
                            <select name="cat_id" id="cat_id" class="form-control">
                                <option value="all">--<?php echo $this->lang->line('all');?>--</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option <?php if (isset($searchCategory) && $searchCategory == $category['id']) { ?> selected="selected" <?php } ?> value="<?= $category['id'] ?>"><?= $category['nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-xs-6 text-right add_templates">
                            <a href="/templates/add" class="btn btn-primary btn-circle margin-top-20" id="add_template"><i class="fa fa-plus"></i> <?php echo $this->lang->line('template_add_template');?></a>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-xs-12">
                            <div id="templates" class="ze_wrapper">
                                <table class="templates_table dbtable_hover_theme dataTable ">
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->

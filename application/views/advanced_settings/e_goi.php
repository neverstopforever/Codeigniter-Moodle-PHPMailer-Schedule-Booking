<div class="page-container system_settings">
   <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
            </li>
            <li>
                <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
            </li>
            <li class="active">
                <?php echo $this->lang->line('e_goi'); ?>
            </li>
            </ul>
            <?php if(empty($e_goi)){ ?>
                <div class="portlet light e_goi service_not_active service_page">
                    <img src="<?php echo $_base_url; ?>app/images/e-goi_logo.png">
                    <div class="e_goi_text">
                        <p>
                            <?php echo $this->lang->line('e_goi_service_not_active_text1'); ?>
                        </p>
                        <p>
                            <?php echo $this->lang->line('e_goi_service_not_active_text2'); ?>
                        </p>
                        <p>
                            <?php echo $this->lang->line('e_goi_service_not_active_text3'); ?>
                        </p>
                        <p>
                            <?php echo $this->lang->line('e_goi_service_not_active_text4'); ?>
                        </p>
                        <div class="control-group ">
                            <button type="button" class="btn btn-primary btn-sm setup_egoi"><i class="fa fa-download" aria-hidden="true"></i> <?php echo $this->lang->line('e_goi_install'); ?></button>
                        </div>
                    </div>
                    <p class="margin-top-20"><?php echo $this->lang->line('e_goi_have_not_account').'  '; ?>  <a href="http://bo.e-goi.com/?action=registo&aff=42c070a79e"><?php echo $this->lang->line('e_goi_click_here'); ?></a></p>

                </div>
            <?php }else{ ?>
                <div class="portlet light e_goi service_active service_page">
                    <div class="text-right">
                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                    </div>
                    <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                        <div class=" note note-info text-left quick_tips_content">
                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                            <p><?php echo $this->lang->line('e-goi_quick_tips_text'); ?>
                                <strong><a href="<?php echo $this->lang->line('e-goi_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('e-goi_quick_tips_link_text'); ?></a></strong>
                            </p>
                        </div>
                    </div>
                    <img src="<?php echo $_base_url; ?>app/images/e-goi_logo.png">
                    <div class="e_goi_text">
                        <p>
                            <?php echo $this->lang->line('e_goi_service_active_text1'); ?>
                        </p>
                        <p>
                            <?php echo $this->lang->line('e_goi_service_active_text2'); ?>
                        </p>
                        <p>
                            <?php echo $this->lang->line('e_goi_service_active_text3'); ?>
                        </p>
                        <p>
                            <?php echo $this->lang->line('e_goi_service_active_text4'); ?>
                        </p>

                        <div class="control-group ">
                            <input <?php echo $e_goi && !empty($mapping_data) ? 'checked' : 'disabled'; ?> type="checkbox"   class="make-switch checkbox_switch" name="my-checkbox" data-on-color="success" data-size="small" />
                            <button type="button" class="btn btn-primary btn-sm setup_egoi"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $this->lang->line('setup'); ?> </button>
                        </div>
                        <p class="margin-top-20"><?php echo $this->lang->line('e_goi_have_not_account').'  '; ?>  <a href="http://bo.e-goi.com/?action=registo&aff=42c070a79e" target="_blank"><?php echo $this->lang->line('e_goi_click_here'); ?></a></p>

                    </div>
                </div>
            <?php } ?>

            <div class="portlet light e_goi service_setup hidden">
                <img src="<?php echo $_base_url; ?>app/images/e-goi_logo.png">
                <div class="e_goi_text">
                    <p><?php echo $this->lang->line('e_goi_service_setup_text1'); ?><br><?php echo $this->lang->line('e_goi_service_setup_text3'); ?></p>
                </div>
                <div class="col-sm-6 e_goi_form">
                    <form class="form" name="setup_egoi_form">
                        <div class="form-group ">
                            <label><?php echo $this->lang->line('username'); ?></label>
                            <input type="text" name="username" class="form-control input-sm input-medium" placeholder="" value="<?php echo isset($e_goi->login) ? $e_goi->login : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('password'); ?></label>
                            <input type="password" name="password" class="form-control input-sm input-medium" placeholder="" value="<?php echo isset($e_goi->pwd) ? $e_goi->pwd : ''; ?>" >
                        </div>
                        <hr>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('e_goi_service_setup_clave_key'); ?></label>
                            <div class="input-group">
                                <input type="text" name="api_key" class="form-control input-sm " placeholder="" value="<?php echo isset($e_goi->apikey) ? $e_goi->apikey : ''; ?>" >
                                <span class="input-group-btn">
                                    <button id="genpassword" class="btn btn-sm btn-success" type="button"><?php echo $this->lang->line('e_goi_valid'); ?></button>
                                </span>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('save'); ?></button>
                        <button type="button" class="btn btn-primary btn-sm mapping <?php echo empty($e_goi) ? ' hidden' : '' ; ?>"> <?php echo $this->lang->line('e_goi_mapping'); ?> </button>
                    </form>
                    <p class="text-success valid_success margin-top-20 hidden"> <?php echo $this->lang->line('e_goi_service_setup_text2'); ?> </p>
                    <p class="text-danger valid_not_success margin-top-20 hidden"> <?php echo $this->lang->line('e_goi_valid_not_success'); ?> </p>
                    <p class="margin-top-20"><?php echo $this->lang->line('e_goi_have_not_account').'  '; ?>  <a href="http://bo.e-goi.com/?action=registo&aff=42c070a79e"><?php echo $this->lang->line('e_goi_click_here'); ?></a></p>
                    <hr>
                    <button class="btn btn-default margin-top-10 back_to_service_active_page" ><?php echo $this->lang->line('back'); ?></button>
                </div>

            </div>

            <div class="portlet light e_goi service_setup_mapp mapping_page" style="display: none">
                <img src="<?php echo $_base_url; ?>app/images/e-goi_logo.png">
                <div class="e_goi_text">
<!--                    <p>--><?php //echo $this->lang->line('e_goi_service_setup_text1'); ?><!--<br>--><?php //echo $this->lang->line('e_goi_service_setup_text3'); ?><!--</p>-->
                </div>
                <div class=" e_goi_form">
                    <form class="col-sm-6 col-sm-offset-3 form" name="egoi_mapping_form">
                        <div class="form-group ">
                            <label><?php echo $this->lang->line('table'); ?></label>
                            <select class="form-control" name="table_name_select">
                                <option value=""><?php echo $this->lang->line('e_goi_select_table_name'); ?></option>
                                <?php foreach($tables as $kye=>$table){ ?>
                                    <option value="<?php echo $kye; ?>"><?php echo ucfirst($table); ?></option>
                                <?php } ?>
                            </select>
<!--                            <input type="text" name="username" class="form-control input-sm input-medium" placeholder="">-->
                        </div>
                        <div class="form-group local_fields_select" style="display: none">
                            <div class="col-sm-6 no-padding">
                                <label><?php echo $this->lang->line('e_goi_local_fields'); ?></label>
                                <select class="form-control" name="local_fields_select">

                                </select>
                            </div>
                            <!--                            <input type="text" name="username" class="form-control input-sm input-medium" placeholder="">-->
                        </div>
                        <div class="form-group egoi_fields_select" style="display: none">
                            <div class="col-sm-6 ">
                                <label><?php echo $this->lang->line('e_goi_extra_fields'); ?></label>
                                <select class="form-control" name="egoi_fields_select">
                                    <option value=""><?php echo $this->lang->line('e_goi_select_fields') ?></option>
                                    <?php foreach($exttra_fields as  $fields){ ?>
                                        <option value="<?php echo $fields['id']; ?>"><?php echo $fields['ref']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!--                            <input type="text" name="username" class="form-control input-sm input-medium" placeholder="">-->
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm margin-top-20"><?php echo $this->lang->line('save'); ?></button>

                    </form>
                    <div class="clearfix"></div>
                    <h3><?php echo $this->lang->line('e_goi_mapped_fields'); ?></h3>

                    <div id="exist_fields_table" class="margin-top-20">

                    </div>
                    <hr>
                    <button class="btn btn-default margin-top-10 back_to_setup_page" ><?php echo $this->lang->line('back'); ?></button>

                </div>


            </div>

        </div>
    </div>
</div>
<!--    Delete Confirmation start-->
<div class="modal fade" id="mappedFieldsDeleteModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("please_confirm"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger modal_delete" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>
<!--       Delete Confirmation end-->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line("please_confirm"); ?></h4>
            </div>
            <div class="modal-body">
                Are you sure you want to change this?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script>
    var _group_by_table = <?php echo json_encode($group_by_table); ?>;
    var _mapping_data = <?php echo json_encode($mapping_data); ?>;
</script>
 <div class="page-container template_add_page">
                  <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>templates"><?php echo $this->lang->line('menu_plantillas'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('add'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="portlet light">
                            <div class="nodata" style="display:none; text-align:center;">
                                <a class="btn btn-primary btn-lg add_rcd"  href="<?php echo base_url() ?>/clientes/add"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
                            </div>
                            <div class="table_loading"></div>
                            <div class=" index_table">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="tabs_container">
                                        <div class="card">
                                            <div class="col-md-12">

                                            </div>
                                            <div class="tab temp" style="display:none;">
                                                <li role="presentation" class="tab_link" style="display:none;"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text"> </span> <i class="fa fa-trash link_trash"></i></a></li>
                                            </div>
                                            <?php if (isset($flashMsg) && $flashMsg != "") { ?>
                                                <div class="tab temp" id="flashMsg" style="width: 100%; float: left; background-color: #e5efff;height: 40px; margin: 20px 0 0 0;">
                                                    <div class="col-md-12" style="float: left; padding: 11px 0 0 12px; color: green;">
                                                        <strong><?php echo $flashMsg; ?></strong>
                                                        <a style="float: right; margin-right: 10px; color: #f1353d;" href="javascript:void()" onclick="hideFlashMsg();"><strong>X</strong></a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <ul class="nav nav-tabs" role="tablist">
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="content temp" style="display:none;">
                                                <div role="tabpanel" class="tab-pane" id="table1"></div>
                                            </div>
                                            <div class="tab-content">
                                                <form id="template-form" class="col-md-12  col-lg-8 col-lg-offset-2" action="<?= base_url() ?>Templates/addConfirm" method="post" enctype="multipart/form-data">
                                                    <div class="col-md-12 text-left margin-top-10">
                                                        <div class="form-group circle_select_div">
                                                            <label classs="form-lable"><?php echo $this->lang->line('category'); ?></label>
                                                               <select required="" name="id_cat" class="form-control" id="id_cat">
                                                                    <option value=""><?php echo $this->lang->line('select_category'); ?></option>
                                                                    <?php foreach ($categories as $category) { ?>
                                                                        <option value="<?= $category['id'] ?>"><?= $category['nombre'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 ">
                                                        <div class="circle_select_div form-group" style="display: none;">
                                                            <label classs="form-lable"><?php echo $this->lang->line('documents'); ?></label>
                                                            <div id="documento">
                                                                <select name="templateId" class="form-control" >
                                                                    <option value=""></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                        <label classs="form-lable"><?php echo $this->lang->line('title'); ?></label>
                                                            <input type="text" placeholder="" id="field-5" class="form-control" name="Nombre" required="" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 ">
                                                        <div class="form-group">
                                                        <label classs="form-lable"><?php echo $this->lang->line('description'); ?></label>
                                                        <textarea placeholder="<?php echo $this->lang->line('description'); ?>" id="field-5" class="fxorm-control" style="width: 100%; height: 100px;" name="Descripcion"></textarea>
                                                  
                                                        </div>
                                                    </div>
													<input type="hidden" value="" id="temp_filename" name="temp_filename">
                                                    <?php
														require_once "editor/index.php";
													?>
													
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
 <form action="<?php echo base_url(); ?>aws_s3/uploadTemplateImg/templates" style="display: none;" id="template_photo_dropzone" method="POST" class="dropzone dropzone-file-area dz-clickable">
     <input type="file" name="photo[]" id="photo_input"  />
 </form>
 

<script type="text/javascript">
	var path      = '<?php echo base_url();?>editor/';
	var scrippath ="<?php echo base_url();?>editor/";
</script>
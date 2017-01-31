 <div class="page-container template_edit_page">
                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url; ?>templates"><?php echo $this->lang->line('menu_plantillas'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('edit'); ?>
                            </li>
                        </ul>
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="portlet light">
                            <div class="nodata" style="display:none; text-align:center;">
                                <a class="btn btn-primary btn-lg add_rcd" href="<?php echo base_url() ?>/clientes/add"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
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


                                            <ul class="nav nav-tabs" role="tablist">
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="content temp" style="display:none;">
                                                <div role="tabpanel" class="tab-pane" id="table1"></div>
                                            </div>
                                            <div class="tab-content">
                                                <form id="template-form"  class="col-md-12  col-lg-8 col-lg-offset-2" action="<?= base_url() ?>templates/editConfirm" method="post" enctype="multipart/form-data">
                                                    <div class="col-md-12" >
                                                    <div class="col-md-12 text-left margin-top-10">
                                                        <div class="form-group circle_select_div">
                                                            <label classs="form-lable"><?php echo $this->lang->line('category'); ?></label>
                                                                <select id="id_cat" name="id_cat" class="form-control" disabled="" >
                                                                    <option value=""><?php echo $this->lang->line('select_category'); ?></option>
                                                                    <?php foreach ($categories as $category) { ?>
                                                                        <option <?php if ($category['id'] == $template->id_cat) { ?> selected="selected" <?php } ?> value="<?= $category['id'] ?>"><?= $category['nombre'] ?></option>
                                                                    <?php } ?>
                                                                </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-left">
                                                        <div class="form-group circle_select_div">
                                                            <label class="form-lable"><?php echo $this->lang->line('documents'); ?></label>
                                                            <div id="documento">
                                                                <select name="templateId" class="form-control" disabled="">
                                                                    <?php foreach ($documents as $document) { ?>
                                                                        <option <?php if ($document->Nombre == $template->nombre) { ?> selected="" <?php } ?> value="<?= $document->id ?>"><?= $document->Nombre ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-left">
                                                        <div class=" form-group">
                                                            <label class="form-lable"><?php echo $this->lang->line('title'); ?></label>
                                                                <input type="text" placeholder="" id="field-5" class="form-control" name="Nombre" value="<?= $template->nombre ?>" required="" />
                                                        </div>
                                                    </div>
                                                        <?php if (isset($template->DocAsociado) &&  $template->DocAsociado!= "") {?>
                                                        <div class="col-md-12 text-left">
                                                    <div class="form-group" style="display: none;">
                                                        <label class="form-lable"><?php echo $this->lang->line('linked_document'); ?></label>

                                                            <input type="file" placeholder="" id="field-5" class="form-control" name="DocAsociado" value="<?= $template->DocAsociado ?>" />

                                                    </div>
                                                    </div>
                                                        <?php } ?>
                                                    <div class="col-md-12 text-left">
                                                    <div class="form-group" style="margin-top: 10px;">
                                                        <label class="form-lable"><?php echo $this->lang->line('description'); ?></label>

                                                            <textarea placeholder="<?php echo $this->lang->line('description'); ?>" id="field-5" class="form-control" style="width: 100%; height: 100px;"  name="Descripcion"><?= $template->descripcion ?></textarea>

                                                    </div>
                                                    </div>
													<input type="hidden" value="<?php echo $this->uri->segment(3);?>" id="template_id" name="template_id">
<!--													<input type="hidden" value="--><?php //echo $template->temp_filename;?><!--" id="temp_filename" name="temp_filename">-->
                                                    <?php
														require_once "editor/index.php";
													?>
                                                    <?php
                                                    $macroValue = "";
                                                    $macroField = "";
                                                    if (isset($template->macro) && !empty($template->macro)) {
                                                        $macro = explode("([", $template->macro);
                                                        $macroValue = isset($macro[0]) ? $macro[0] : "";
                                                        $macroField = isset($macro[1]) ? str_replace("])", "", $macro[1]) : "";
                                                    }
                                                    ?>
<!--                                                    <div class="col-md-12  form-Groupm" style="margin-top: 10px;">-->
<!--                                                        <div class="col-md-3">Macros</div>-->
<!--                                                        <div class="col-md-9">-->
<!--                                                            <input type="text" placeholder="Macro" id="field-5" class="form-control" name="macro" value="--><?//= $macroValue ?><!--" />-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-md-12  form-Groupm" style="margin-top: 10px;">-->
<!--                                                        <div class="col-md-3">&nbsp;</div>-->
<!--                                                        <div class="col-md-9" id="macrosField">-->
<!--                                                            <select name="macrosField" style="width: 100%; height: 34px;">-->
<!--                                                                --><?php //foreach ($macros as $macro) { ?>
<!--                                                                    <option --><?php //if ($macro == $macroField) { ?><!-- selected="" --><?php //} ?><!-- value="--><?//= $macro ?><!--">--><?//= $macro ?><!--</option>-->
<!--                                                                --><?php //} ?>
<!--                                                            </select>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                    </div>
                                                    <div class="col-md-8 pull-right text-left back_save_group">
                                                        <a href="<?= base_url() ?>Templates/" class="btn-sm btn btn-circle btn-default-back back_teachers xs_hide "> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>

                                                            <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#delete_template" ><?php echo $this->lang->line('delete'); ?></button>
						
                                                        <a href="<?= base_url() ?>Templates/" class="btn-sm btn btn-circle btn-default-back back_teachers xs_show "> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></a>


                                                        <input type="hidden" name="template_id" value="<?= $template->id ?>" />
                                                        </div>
                                                    </div>
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
<div id="delete_template" class="modal fade in" role="dialog";">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line('please_confirm'); ?></h4>
            </div>
            <form id="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                   <?php echo $this->lang->line('are_you_sure'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                    <a href="<?= base_url() ?>templates/delete/<?= $template->id ?>"  type="submit" data-task="delete_student" class="btn btn-primary" student_id="45"><?php echo $this->lang->line('delete'); ?></a>
                </div>
            </form>
        </div>
    </div>
</div>
 <form action="<?php echo base_url(); ?>aws_s3/uploadTemplateImg/templates" style="display: none;" id="template_photo_dropzone" method="POST" class="dropzone dropzone-file-area dz-clickable">
     <input type="file" name="photo[]" id="photo_input"  />
 </form>

  <script type="text/javascript">
      var path      = '<?php echo base_url();?>editor/';
      var scrippath ="<?php echo base_url();?>editor/";
      var template_content = <?php echo json_encode (array('template'=>$template->content)); ?>;
      var templateId = '<?php echo $templateId;?>';
  </script>
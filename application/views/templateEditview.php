        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1><?php echo $this->lang->line('menu_plantillas'); ?></h1>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
                <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                    <li>
                        <a href="#"><?=$this->lang->line('menu_Home')?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('menu_plantillas'); ?>
                    </li>
                </ul>
                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="portlet light">
                            <div class="nodata" style="display:none; text-align:center;">
                                <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px;min-height:80;" href="<?php echo base_url() ?>/clientes/add"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
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
                                            <div class="tab temp" style="display:none;">
                                                <li role="presentation" class="tab_link" style="display:none;"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text"> </span> <i class="fa fa-trash link_trash"></i></a></li>
                                            </div>
                                            <ul class="nav nav-tabs" role="tablist">
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="content temp" style="display:none;">
                                                <div role="tabpanel" class="tab-pane" id="table1"></div>
                                            </div>
                                            <div class="tab-content">
											<form id="template-form" action="" method="post">
												<div class="col-md-12 form-group">
													<div class="col-md-3">
													Categoria
														 </div>
													<div class="col-md-9">
													<?php echo form_dropdown('id_cat', $plantillas_cat,''); ?>
													</div>
												</div>
												
												<div class="col-md-12 form-group">
													<div class="col-md-3">
														Documentos</div>
													<div class="col-md-9">
													<?php echo form_dropdown('id', array(),''); ?>
													</div>
												</div>
												<div class="col-md-12 form-group">
													<div class="col-md-3">
													Option</div>
													<div class="col-md-9">
														<select name="template_option">
															<option value="1">New Create</option>
															<option value="2">Update</option>
														</select>
													</div>
												</div>
											
												<div class="col-md-12  form-Groupm">
													<div class="col-md-3">
													Nombre
														 </div>
													<div class="col-md-9">
														<input type="text" placeholder="" id="field-5" class="form-control" name="Nombre">
													</div>
												</div>
												<div class="col-md-12  form-Groupm">
													<br>
													<div class="col-md-3">
													Doc Asociado
														 </div>
													<div class="col-md-9">
														<input type="text" placeholder="" id="field-5" class="form-control" name="DocAsociado">
													</div>
												</div>
												<div class="col-md-12 form-group">
													<br>
												<div class="col-md-3">
														Documento</div>
												</div>
												<div class="col-md-12 form-group">
													<div id="wysihtml5-toolbar" style="display: none;">
													<select id="attribute">
														<option>Select</option>
														<option data-wysihtml5-command='insertHTML' data-wysihtml5-command-value='[idempresa]'>idempresa</option>
													</select>
													  <a data-wysihtml5-command="bold">bold</a>
													  <a data-wysihtml5-command="italic">italic</a>
													  <a data-wysihtml5-command="underline">italic</a>

													  <!-- Some wysihtml5 commands require extra parameters -->
													  
													 <a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='div' tabindex='-1'>Normal</a>
													<a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h1' tabindex='-1'>h1</a>
													<a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h2' tabindex='-1'>h2</a>
													<a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h3' tabindex='-1'>h3</a>
													<a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h4'>h4</a>
													<a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h5'>h5</a>
													<a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h6'>h6</a>
													
													<a  data-wysihtml5-command='insertUnorderedList' title='unordered' ><i class='glyphicon glyphicon-list'></i></a>
													<a  data-wysihtml5-command='insertOrderedList' title='ordered' ><i class='glyphicon glyphicon-th-list'></i></a>
													<a  data-wysihtml5-command='Outdent' title='outdent' ><i class='glyphicon glyphicon-indent-right'></i></a>
													<a  data-wysihtml5-command='Indent' title='indent' ><i class='glyphicon glyphicon-indent-left'></i></a>
																						
													

													  <!-- Some wysihtml5 commands like 'createLink' require extra paramaters specified by the user (eg. href) -->
													  <a data-wysihtml5-command="createLink">insert link</a>
													  <div data-wysihtml5-dialog="createLink" style="display: none;">
														<label>
														  Link:
														  <input data-wysihtml5-dialog-field="href" value="http://" class="text">
														</label>
														<a data-wysihtml5-dialog-action="save">OK</a> <a data-wysihtml5-dialog-action="cancel">Cancel</a>
													  </div>
														<a data-wysihtml5-action="change_view" href="javascript:;" unselectable="on">change</a>
													</div>
												
												
													<textarea id="wysihtml5-textarea" name="webDocumento" rows="8" cols="100" placeholder="Enter your text ..." autofocus></textarea>
												</div>
												<div class="col-md-12">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">
                                                            Update                                                        </button>
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
            </div>


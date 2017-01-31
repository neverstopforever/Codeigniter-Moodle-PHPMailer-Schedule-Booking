
<div class="page-container">



	<div class="page-content">
		<div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_main_reports'); ?></a>
                </li>

                <li class="active">
                    <?php echo $this->lang->line('menu_statistics'); ?>
                </li>
            </ul>
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">


                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20 margin-bottom-10">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('statistics_quick_tips_text'); ?>
                            <strong><a href="<?php echo $this->lang->line('statistics_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('statistics_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>


                <form class="form-horizontal">
                            <fieldset>
                                <!-- Select Basic -->
                                <div class="form-group-informes">
                                    <div class="col-sm-6 circle_select_div margin-bottom-10">
                                        <label class="control-label" for="categorias"><?php echo $this->lang->line('placeholders_sectionSelection'); ?></label>
                                        <select id="categorias" name="categorias" class="form-control">
                                            <option value="">- Seleccione una secci&oacute;n -</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 circle_select_div margin-bottom-10">
                                        <label class="control-label" for="categorias"><?php echo $this->lang->line('placeholders_reportSelection'); ?></label>
                                        <select id="informes" name="informes" class="form-control">
                                            <option value="">- Seleccione un Informe -</option>
                                            <!-- el contenido de este combo se carga por ajax al seleccionar alguna categoria del combo anterior -->
                                        </select>
                                    </div>
                                    <br />
                                    <div class="col-sm-12 search_button">
                                        <button type="button" class="btn btn-circle btn-primary btn-back  mostrar" id="mostrar" name="mostrar"> <?php echo $this->lang->line('button_Show'); ?></button>
                                    </div>
                                </div>
                            </fieldset>
                </form>
                <div class="table_loading"></div>
                        <div class=" index_table">
            <div class="col-md-12 ">
                <div class="tabs_container" style="display:none;">
                    <div class="card">
                        <div class="tab temp" style="display:none;">
                            <li role="presentation" class="tab_link"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text">Table 1 </span> <i class="fa fa-trash link_trash"></i></a></li>
                        </div>
                        <ul class="nav nav-tabs" role="tablist">
                        </ul>
                        <!-- Tab panes -->
                        <div class="content temp" style="display:none;">
                            <div role="tabpanel" class="tab-pane" id="table1"></div>
                        </div>
                        <div class="tab-content">
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
	
		<!-- BEGIN QUICK SIDEBAR -->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
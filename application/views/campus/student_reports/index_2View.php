<div class="page-container">
	<div class="page-content">
		<div class="<?php echo $layoutClass ?>">
            <ul class= "page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="javascript:;" ><?php echo $this->lang->line('option'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('my_report'); ?>
                </li>
            </ul>
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
                <div class="text-right pull-right quick_tip_wrapper margin-bottom-10">
                    <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                </div>
				<form class="form-horizontal">
                    <fieldset>
                        <!-- Select Basic -->
                        <div class="form-group-informes">
                            <div class="col-md-6">
                                <div class="circle_select_div">
                                    <label class="control-label inform_label" for="categorias"> <?php echo $this->lang->line('campus_student_repo_information') ?></label>
                                    <select id="categorias" name="categorias" class="form-control">
                                        <option value=""><?php echo $this->lang->line('campus_student_select_information'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="col-md-12 search_button">
                                <button type="button" style="display:none;" class="btn btn-default mostrar" id="mostrar" name="mostrar"> <?php echo $this->lang->line('button_Show'); ?></button>
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
                            <li role="presentation" class="tab_link"><a href="#table1" aria-controls="table1" role="tab" data-toggle="tab"><span class="link_text"> </span> <i class="fa fa-trash link_trash"></i></a></li>
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
        <div class="temp_filter" style="display:none;">
            <div style="display:none;">
                <div id="advancedSearchForm">
                    <div class="advancedSearchForm_wrapper" id="advancedSearchForm_wrapper">
                        <input type="hidden" name="table" value="">
<!--                        <div class="clearfix">-->
<!--                            <h5 class="pull-left"><span class="fui-search"></span> --><?php //echo $this->lang->line('dt_filter') ?><!--</h5>-->
<!--                        </div>-->
                        <hr>
                        <div class="panel-group margin-bottom-15" id="advancedSearch_accordion">
                            <!-- templ -->
                            <div class="filter_item" style="display: none;" id="newSearchItem_templ">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-parent="#advancedSearch_accordion" href="#as_collapse0">
                                            <b class="item"><?php echo $this->lang->line('dt_filterItem') ?> 1</b> <span class="pull-right"><?php echo $this->lang->line('dt_collapsExpand') ?></span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="as_collapse0" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="form-group clearfix margin-bottom-10">
                                            <div class="col-sm-6">
                                                <div class="mbl margin-bottom-0 circle_select_div">
                                                    <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                        <option value=""><?php echo $this->lang->line('dt_selectColumn') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mbl margin-bottom-0 circle_select_div">
                                                    <select name="operators[]" class="select-block selector dt_operator form-control aaa" placeholder="Selecciona Operador">
                                                        <option value=""><?php echo $this->lang->line('dt_selectOperator') ?></option>
                                                        <option value="="><?php echo $this->lang->line('dt_operatorEquil') ?></option>
                                                        <option value="!="><?php echo $this->lang->line('dt_operatorNotEquil') ?></option>
                                                        <option value="LIKE%"><?php echo $this->lang->line('dt_operatorLike') ?></option>
                                                        <option value="NOT LIKE%"><?php echo $this->lang->line('dt_operatorNotLike') ?></option>
                                                        <option value="<"><?php echo $this->lang->line('dt_operatorLessThen') ?> (&lt;)</option>
                                                        <option value=">"><?php echo $this->lang->line('dt_operatorGreaterThen') ?>(&gt;)</option>
                                                        <option value="<="><?php echo $this->lang->line('dt_operatorLessthenEquil') ?> (&lt;=)</option>
                                                        <option value=">="><?php echo $this->lang->line('dt_operatorgreaterThenEquil') ?> (&gt;=)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix margin-bottom-15">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control dt_value" id="inputEmail3" placeholder="<?php echo $this->lang->line('de_placeholderValue'); ?>" name="values[]">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix margin-bottom-0">
                                            <div class="col-sm-12">
                                                <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /templ -->
                            <div class="filter_item">
                                <div class="margin-bottom-20">
                                    <h4 class="panel-title">
                                        <a data-parent="#advancedSearch_accordion" href="#as_collapseOne">
                                            <b class="item"><?php echo $this->lang->line('dt_filterItem') ?> 1</b> <span class="pull-right  filter_col_exp"><?php echo $this->lang->line('dt_collapsExpand') ?></span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="as_collapseOne" class="panel-collapse collapse in">
                                     <div>
                                        <div class="form-group clearfix margin-bottom-10">
                                            <div class="col-sm-6">
                                                <div class="mbl margin-bottom-10 circle_select_div">
                                                    <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                        <option value=""><?php echo $this->lang->line('dt_selectColumn') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mbl margin-bottom-0 circle_select_div">
                                                    <select name="operators[]" class="select-block selector dt_operator form-control aaa" placeholder="Selecciona Operador">
                                                        <option value=""><?php echo $this->lang->line('dt_selectOperator') ?></option>
                                                        <option value="="><?php echo $this->lang->line('dt_operatorEquil') ?></option>
                                                        <option value="!="><?php echo $this->lang->line('dt_operatorNotEquil') ?></option>
                                                        <option value="LIKE%"><?php echo $this->lang->line('dt_operatorLike') ?></option>
                                                        <option value="NOT LIKE%"><?php echo $this->lang->line('dt_operatorNotLike') ?></option>
                                                        <option value="<"><?php echo $this->lang->line('dt_operatorLessThen') ?> (&lt;)</option>
                                                        <option value=">"><?php echo $this->lang->line('dt_operatorGreaterThen') ?>(&gt;)</option>
                                                        <option value="<="><?php echo $this->lang->line('dt_operatorLessthenEquil') ?> (&lt;=)</option>
                                                        <option value=">="><?php echo $this->lang->line('dt_operatorgreaterThenEquil') ?> (&gt;=)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix margin-bottom-15">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control dt_value" id="inputEmail3" placeholder="<?php echo $this->lang->line('de_placeholderValue') ?>" name="values[]">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix margin-bottom-0">
                                            <div class="col-sm-12">
                                                <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->
                        </div>
                        <div class="form-group clearfix" style="width:100%;">
                            <button type="button" class="btn btn-info btn-circle btn-embossed applyFilter"><?php echo $this->lang->line('dt_apply') ?></button>
                            <button type="button" class="btn btn-info btn-circle btn-embossed resetTable"><?php echo $this->lang->line('dt_undo') ?></button>
                            <a href="" class="addColumnLink pull-right" id="addSearchItem"><span class="fui-plus"></span> <?php echo $this->lang->line('dt_addItem') ?></a>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="temp_groupby" style="display:none;">
                <div style="display:none;">
                    <div id="advancedgroupForm">
                        <div class="advancedgroupForm_wrapper" id="advancedgroupForm_wrapper">
<!--                            <input type="hidden" name="table" value="">-->
<!--                            <div class="clearfix">-->
<!--                                <h5 class="pull-left"><span class="fui-group"></span> --><?php //echo $this->lang->line('dt_group') ?><!--</h5>-->
<!--                            </div>-->
<!--                            <hr>-->
                            <div class="panel-group margin-bottom-15" id="advancedgroup_accordion">
                                <!-- templ -->
                                <div class="agregate_item" style="display: none;" id="newgroupItem_templ">
                                    <div class="margin-bottom-20">
                                        <h4>
                                        <a data-parent="#advancedgroup_accordion" href="#as_collapse0">
                                            <b class="item"><?php echo $this->lang->line('dt_groupTitle') ?> </b> <span class="pull-right" style="display:none"><?php echo $this->lang->line('dt_collapsExpand'); ?></span>
                                        </a>
                                    </h4>
                                    </div>
                                    <div id="as_collapse0" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group clearfix margin-bottom-10">
                                                <h6><?php echo $this->lang->line('dt_selectColumn') ?></h6>
                                                <div class="col-sm-6">
                                                    <div class="mbl margin-bottom-10 circle_select_div">
                                                        <select name="columns[]" class="select-block selector  dt_column form-control" placeholder="Selecciona Columna">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mbl margin-bottom-0 circle_select_div">
                                                        <select class="select-block selector  dt_agregate form-control" placeholder="Selecciona Columna">
                                                            <option value="max"><?php echo $this->lang->line('dt_max') ?></option>
                                                            <option value="min"><?php echo $this->lang->line('dt_min') ?></option>
                                                            <option value="average"><?php echo $this->lang->line('dt_average') ?></option>
                                                            <option value="count"><?php echo $this->lang->line('dt_count') ?></option>
                                                            <option value="sum"><?php echo $this->lang->line('dt_sum') ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 result_aggregate"></div>
                                            <div class="form-group clearfix margin-bottom-10">
                                                <div class="col-sm-12">
                                                    <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /templ -->
                                <div class="agregate_item">
                                    <div class="margin-bottom-20">
                                        <h4 class="panel-title">
                                        <a data-parent="#advancedgroup_accordion" href="#as_collapse0">
                                            <b class="item"> <?php echo $this->lang->line('dt_groupby') ?> </b> <span class="pull-right" style="display:none"><?php echo $this->lang->line('dt_collapsExpand'); ?></span>
                                        </a>
                                    </h4>
                                    </div>
                                    <div id="as_collapse0" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group clearfix margin-bottom-10">
                                                <div class="col-sm-12">
                                                    <div class="mbl margin-bottom-0 circle_select_div">
                                                        <h6> <?php echo $this->lang->line('dt_chooseGroup') ?></h6>
                                                        <select name="columns[]" class="select-block selector  dt_column group_by_dt form-control" placeholder="Seleciona Columna">
                                                            <!-- <option value="">Choose column to Group</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 agr_items">
                                            </div>
                                            <div class="form-group clearfix margin-bottom-0">
                                                <div class="col-sm-12">
                                                    <a href="" class="addColumnLink pull-right" id="addagregateItem"><span class="fui-plus"></span> <?php echo $this->lang->line('dt_addAggregateCondition') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.panel -->
                            </div>
                            <div class="form-group clearfix">
                                <button type="button" class="btn btn-info btn-circle btn-embossed resetTable pull-right"><?php echo $this->lang->line('dt_undo') ?></button>
                                <button type="button" class="btn btn-info btn-circle btn-embossed groupColumn"><?php echo $this->lang->line('dt_apply') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
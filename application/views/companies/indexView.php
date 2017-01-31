<div class="page-container">
    <div class="table_loading"></div>
    <div class="page-content">
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
                <li class="active">
                    <?php echo $this->lang->line('menu_companies'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="portlet light">

                <div class="text-right">
                    <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                </div>
                <div class="quick_tips_sidebar margin-top-20">
                    <div class=" note note-info quick_tips_content">
                        <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                        <p><?php echo $this->lang->line('companies_quick_tips_text'); ?> 
                            <strong><a href="<?php echo $this->lang->line('companies_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('companies_quick_tips_link_text'); ?></a></strong>
                        </p>
                    </div>
                </div>

                <div class="nodata" style="display:none; text-align:center;">
<!--                    <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px;min-height:80px;" href="--><?php //echo base_url() ?><!--companies/add"><i class="fa fa-plus"></i>--><?php //echo $this->lang->line('companies_addRecord'); ?><!--</a>-->
                    <div class="text-center margin-top-30"><h3><?php echo $this->lang->line('looks_like_you_dont_have_any'); ?> <?php echo $this->lang->line('_company'); ?> </h3><a class="btn btn-primary btn-circle add_rcd margin-top-10" href="<?php echo base_url() ?>companies/add"><i class="fa fa-plus"></i> <?php echo $this->lang->line('companies_addRecord'); ?></a></div>

                </div>
                <div class="table_loading"></div>
                <div class=" index_table">
                    <div class="col-md-12">
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="tabs_container" style="display:none;">
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
                            <div class="clearfix">
                                <h5 class="pull-left"><span class="fui-search"></span> <?php echo $this->lang->line('dt_filter') ?></h5>
                            </div>
                            <hr>
                            <div class="panel-group margin-bottom-15" id="advancedSearch_accordion">
                                <!-- templ -->
                                <div class="panel panel-default filter_item" style="display: none;" id="newSearchItem_templ">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                            <a data-parent="#advancedSearch_accordion" href="#as_collapse0">
                                <b class="item"><?php echo $this->lang->line('dt_filterItem') ?> 1</b> <span class="pull-right"><?php echo $this->lang->line('dt_collapsExpand') ?></span>
                            </a>
                        </h4>
                                    </div>
                                    <div id="as_collapse0" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group clearfix margin-bottom-0">
                                                <div class="col-sm-6 margin-bottom-10">
                                                    <div class="mbl margin-bottom-0 circle_select_div">
                                                        <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                            <option value="">
                                                                <?php echo $this->lang->line('dt_selectColumn') ?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin-bottom-10">
                                                    <div class="mbl margin-bottom-0 circle_select_div">
                                                        <select name="operators[]" class="select-block selector dt_operator form-control aaa" placeholder="Selecciona Operador">
                                                            <option value="">
                                                                <?php echo $this->lang->line('dt_selectOperator') ?>
                                                            </option>
                                                            <option value="=">
                                                                <?php echo $this->lang->line('dt_operatorEquil') ?>
                                                            </option>
                                                            <option value="!=">
                                                                <?php echo $this->lang->line('dt_operatorNotEquil') ?>
                                                            </option>
                                                            <option value="LIKE%">
                                                                <?php echo $this->lang->line('dt_operatorLike') ?>
                                                            </option>
                                                            <option value="NOT LIKE%">
                                                                <?php echo $this->lang->line('dt_operatorNotLike') ?>
                                                            </option>
                                                            <option value="<">
                                                                <?php echo $this->lang->line('dt_operatorLessThen') ?> (&lt;)</option>
                                                            <option value=">">
                                                                <?php echo $this->lang->line('dt_operatorGreaterThen') ?>(&gt;)</option>
                                                            <option value="<=">
                                                                <?php echo $this->lang->line('dt_operatorLessthenEquil') ?> (&lt;=)</option>
                                                            <option value=">=">
                                                                <?php echo $this->lang->line('dt_operatorgreaterThenEquil') ?> (&gt;=)</option>
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
                                <div class="panel panel-default filter_item">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                            <a data-parent="#advancedSearch_accordion" href="#as_collapseOne">
                                <b class="item"><?php echo $this->lang->line('dt_filterItem') ?> 1</b> <span class="pull-right"><?php echo $this->lang->line('dt_collapsExpand') ?></span>
                            </a>
                        </h4>
                                    </div>
                                    <div id="as_collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group clearfix margin-bottom-0">
                                                <div class="col-sm-6 margin-bottom-10">
                                                    <div class="mbl margin-bottom-0 circle_select_div">
                                                        <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                            <option value="">
                                                                <?php echo $this->lang->line('dt_selectColumn') ?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 margin-bottom-10">
                                                    <div class="mbl margin-bottom-0 circle_select_div">
                                                        <select name="operators[]" class="select-block selector dt_operator form-control aaa" placeholder="Selecciona Operador">
                                                            <option value="">
                                                                <?php echo $this->lang->line('dt_selectOperator') ?>
                                                            </option>
                                                            <option value="=">
                                                                <?php echo $this->lang->line('dt_operatorEquil') ?>
                                                            </option>
                                                            <option value="!=">
                                                                <?php echo $this->lang->line('dt_operatorNotEquil') ?>
                                                            </option>
                                                            <option value="LIKE%">
                                                                <?php echo $this->lang->line('dt_operatorLike') ?>
                                                            </option>
                                                            <option value="NOT LIKE%">
                                                                <?php echo $this->lang->line('dt_operatorNotLike') ?>
                                                            </option>
                                                            <option value="<">
                                                                <?php echo $this->lang->line('dt_operatorLessThen') ?> (&lt;)</option>
                                                            <option value=">">
                                                                <?php echo $this->lang->line('dt_operatorGreaterThen') ?>(&gt;)</option>
                                                            <option value="<=">
                                                                <?php echo $this->lang->line('dt_operatorLessthenEquil') ?> (&lt;=)</option>
                                                            <option value=">=">
                                                                <?php echo $this->lang->line('dt_operatorgreaterThenEquil') ?> (&gt;=)</option>
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
                                <button type="button" class="btn btn-info btn-sm btn-circle btn-embossed applyFilter">
                                    <?php echo $this->lang->line('dt_apply') ?>
                                </button>
                                <button type="button" class="btn btn-info  btn-sm btn-circle btn-embossed resetTable">
                                    <?php echo $this->lang->line('dt_undo') ?>
                                </button>
                                <a href="" class="addColumnLink pull-right" id="addSearchItem"><span class="fui-plus"></span> <?php echo $this->lang->line('dt_addItem') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="temp_groupby" style="display:none;">
                    <div style="display:none;">
                        <div id="advancedgroupForm">
                            <div class="advancedgroupForm_wrapper" id="advancedgroupForm_wrapper">
                                <input type="hidden" name="table" value="">
                                <div class="clearfix">
                                    <h5 class="pull-left"><span class="fui-group"></span> <?php echo $this->lang->line('dt_group') ?></h5>
                                </div>
                                <hr>
                                <div class="panel-group margin-bottom-15" id="advancedgroup_accordion">
                                    <!-- templ -->
                                    <div class="panel panel-default agregate_item" style="display: none;" id="newgroupItem_templ">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                            <a data-parent="#advancedgroup_accordion" href="#as_collapse0">
                                <b class="item"><?php echo $this->lang->line('dt_groupTitle') ?> </b> <span class="pull-right" style="display:none"><?php echo $this->lang->line('dt_collapsExpand'); ?></span>
                            </a>
                        </h4>
                                        </div>
                                        <div id="as_collapse0" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <h6><?php echo $this->lang->line('dt_selectColumn') ?></h6>
                                                    <div class="col-sm-6 margin-bottom-10">
                                                        <div class="mbl margin-bottom-0 circle_select_div">
                                                            <select name="columns[]" class="select-block selector  dt_column form-control" placeholder="Selecciona Columna">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 margin-bottom-10">
                                                        <div class="mbl margin-bottom-0 circle_select_div">
                                                            <select class="select-block selector  dt_agregate form-control" placeholder="Selecciona Columna">
                                                                <option value="max">
                                                                    <?php echo $this->lang->line('dt_max') ?>
                                                                </option>
                                                                <option value="min">
                                                                    <?php echo $this->lang->line('dt_min') ?>
                                                                </option>
                                                                <option value="average">
                                                                    <?php echo $this->lang->line('dt_average') ?>
                                                                </option>
                                                                <option value="count">
                                                                    <?php echo $this->lang->line('dt_count') ?>
                                                                </option>
                                                                <option value="sum">
                                                                    <?php echo $this->lang->line('dt_sum') ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 result_aggregate"></div>
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <div class="col-sm-12">
                                                        <a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('dt_deleteItem') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /templ -->
                                    <div class="panel panel-default agregate_item">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                            <a data-parent="#advancedgroup_accordion" href="#as_collapse0">
                                <b class="item"> <?php echo $this->lang->line('dt_groupby') ?> </b> <span class="pull-right" style="display:none"><?php echo $this->lang->line('dt_collapsExpand'); ?></span>
                            </a>
                        </h4>
                                        </div>
                                        <div id="as_collapse0" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group clearfix margin-bottom-0">
                                                    <div class="col-sm-12 margin-bottom-10">
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
                                    <button type="button" class="btn btn-info btn-circle btn-sm btn-embossed resetTable pull-right">
                                        <?php echo $this->lang->line('dt_undo') ?>
                                    </button>
                                    <button type="button" class="btn btn-info btn-circle btn-sm btn-embossed groupColumn">
                                        <?php echo $this->lang->line('dt_apply') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--    Delete Confirmation start-->
            <div class="modal fade" id="ClientsDleteModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> <?php echo $this->lang->line("company_delete"); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php echo $this->lang->line('company_confirm_delete'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                            <button type="button" class="btn btn-danger modal_delete" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--       Delete Confirmation end-->
        </div>
    </div>
</div>


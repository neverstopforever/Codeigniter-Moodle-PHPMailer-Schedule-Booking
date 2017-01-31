        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1><?php echo $this->lang->line('menu_leads'); ?></h1>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
                <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                    <li>
                        <a href="javascript:;"><?= $this->lang->line('menu_Home') ?></a><i class="fa fa-circle"></i>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('menu_leads'); ?>
                    </li>
                </ul>
                <div class="table_loading"></div>
                <div class="page-content">
                    <div class="<?php echo $layoutClass ?>">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="portlet light">
                            <div class="nodata" style="display:none; text-align:center;">
                                <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px;min-height:80;" href="<?php echo base_url() ?>/LeadsView/add"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
                            </div>
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
                                                            <div class="col-sm-6">
                                                                <div class="mbl margin-bottom-0">
                                                                    <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                                        <option value="">
                                                                            <?php echo $this->lang->line('dt_selectColumn') ?>
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="mbl margin-bottom-0">
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
                                                            <div class="col-sm-6">
                                                                <div class="mbl margin-bottom-0">
                                                                    <select name="columns[]" class="select-block selector dt_column  form-control aaa" placeholder="Selecciona Columna">
                                                                        <option value="">
                                                                            <?php echo $this->lang->line('dt_selectColumn') ?>
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="mbl margin-bottom-0">
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
                                            <button type="button" class="btn btn-info btn-embossed applyFilter">
                                                <?php echo $this->lang->line('dt_apply') ?>
                                            </button>
                                            <button type="button" class="btn btn-info btn-embossed resetTable">
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
                                                                <div class="col-sm-6">
                                                                    <div class="mbl margin-bottom-0">
                                                                        <select name="columns[]" class="select-block selector  dt_column form-control" placeholder="Selecciona Columna">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mbl margin-bottom-0">
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
                                                                <div class="col-sm-12">
                                                                    <div class="mbl margin-bottom-0">
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
                                                <button type="button" class="btn btn-info btn-embossed resetTable pull-right">
                                                    <?php echo $this->lang->line('dt_undo') ?>
                                                </button>
                                                <button type="button" class="btn btn-info btn-embossed groupColumn">
                                                    <?php echo $this->lang->line('dt_apply') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <div class="modal fade" id="leads_actions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bulk_actions" style="display:none;">
                <div class="dropdown" style="position:relative">
                    <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("leads_bulkActions") ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="trigger"><?php echo $this->lang->line("leido"); ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <li><a href="#" class="action" data-task="leido" data-id="0"><?php echo $this->lang->line("leido_read"); ?></a></li>
                                <li><a href="#" class="action" data-task="leido" data-id="1"><?php echo $this->lang->line("leido_unread"); ?></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="trigger"><?php echo $this->lang->line("Priority"); ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <li><a href="#" class="action" data-task="prioridad" data-id="0"><?php echo $this->lang->line("Priority_normal"); ?></a></li>
                                <li><a href="#" class="action" data-task="prioridad" data-id="1"><?php echo $this->lang->line("Priority_High"); ?></a></li>
                                <li><a href="#" class="action" data-task="prioridad" data-id="2"><?php echo $this->lang->line("Priority_VeryHigh"); ?></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="trigger"><?php echo $this->lang->line("state"); ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <?php
                                foreach ($state as $value) {
                                    ?>
                                    <li>
                                        <a href="#" data-id="<?php echo $value->id; ?>" data-task="estado" class="action" style="color:#<?php echo $value->color; ?>">
                                            <?php echo $value->valor; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        <div class="modal fade" id="deleteLead" tabindex="-1" role="deleteLead" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('delete_lead'); ?></h4>
                    </div>
                    <div class="modal-body"><?php echo $this->lang->line('are_you_sure'); ?>?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                        <a type="button" href="#" class="btn green" id="delete_lead_modal"><?php echo $this->lang->line('delete_lead'); ?></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


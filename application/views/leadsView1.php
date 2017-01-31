<html>

    <head>
        <?php include('includes/head.php'); ?>
    </head>

    <body>
        <?php include 'includes/header.php'; ?>
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
                        <a href="#"><?= $this->lang->line('menu_Home') ?></a><i class="fa fa-circle"></i>
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
                                <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px;min-height:80;" href="<?php echo base_url() ?>/clientes/add"><i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?></a>
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
            <?php include 'includes/footer.php'; ?>
            <script type="text/javascript">
                app.clientesTable = [];
                app.clientesInit = function (responseData, data, isAgain, tabInfo, action) {

                    console.log(responseData);
                    var responseData = JSON.parse(responseData);
                    var dbcolumns = [],
                            dbdata = [],
                            forFilter = [],
                            newtab = true,
                            tableData = [];
                    forFilter = responseData.content;
                    if (!isAgain) {

                        //console.log(responseData);
                        var tab = app.tabs.create('', {}, 'tables');
                        forFilter = responseData.content;
                        forFilterKeys = responseData.dataKeys;
                    } else {
                        var tab = tabInfo;
                        forFilter = responseData;
                        newtab = false;
                        var tableData = app.clientesTable.filter(function (d) {
                            if (d.id == tabInfo.id) {
                                return true;
                            }
                        });
                        tableData = tableData[0];
                    }
                    console.log(tableData);
                    console.log(forFilter);
                    //console.log(responseData);
                    // var tab = app.tabs.create('', {}, 'tables');
                    // //console.log(responseData);
                    if (forFilter.length) {
                        dbcolumns.push({
                            data: null,
                            defaultContent: '',
                            className: 'contactos_Actions',
                            orderable: false,
                            title: language.actions,
                            editable: false,
                            render: function (current, e, full) {
//                                console.log(full.ID);
                                return '<a href="' + base_url + 'leads/edit/' + full.ID + '" class="contactos_btn btn-success "><i class="fa fa-edit"></i></a><a href="' + base_url + 'clientes/edit/' + full.id + '" class="contactos_btn btn-danger  delete_clientes"><i class="fa fa-trash"></i></a>';
                            }
                        });
                        $.each(forFilter, function (index, row) {
                            var keys = Object.keys(row),
                                    dbkeys = Object.keys(row)
                            newRow = {};
                            $.each(keys, function (i, k) {
                                newKey = k.replace(/ /g, '');
                                newRow[newKey] = row[dbkeys[i]];
                                if (index == 0) {
                                    dbcolumns.push({
                                        title: decode_utf8(k),
                                        data: newKey
                                    });
                                }
                            });
                            dbdata.push(newRow);
                        });
                    } else {
                        if (Object.size(tableData)) {
                            dbcolumns = tableData.dbcolumns;
                            dbdata = [];
                        }
                    }

                    var table = $('<table class="dbtable table table-striped table-bordered table-hover dataTable no-footer"></table>');
                    table.prop('id', tab.id + '_table');
                    $('.tabs_container').show();
                    $(tab.content).empty().append(table);
                    zeTable = $(tab.content).find('#' + tab.id + '_table').dataTable({
                        data: dbdata,
                        columns: dbcolumns,
                        "sDom": "<'table_feature_top' <'exports_option col-md-4 no-padding'<'col-md-12 no-padding'B>><'col-md-8 datatable_features'>><'row'<'col-md-4 col-xs-12'l><'col-md-4 col-xs-12'ri>><'ze_wrapper't><'row'<'col-md-6 col-xs-12'><'col-md-6 col-xs-12'p>>",
                        buttons: [
                            'copy', 'csv', 'pdf', 'excel', 'print'
                        ],
                        "language": {
                            "url": base_url + "app/lang/" + lang + '.json'
                        },
                        drawCallback: function (settings) {
                            $('.dbtable').find('tr').find('.delete_clientes').off().on('click', function (e) {
                                e.preventDefault();
                                var row = $(this).parents('tr'),
                                        table = $('.dbtable').data('table');
                                rowData = table.fnGetData(row);
                                yesDelete = confirm(language.confirmDelete);
                                if (yesDelete) {
                                    $.ajax({
                                        url: base_url + 'clientes/cliente/' + rowData.id,
                                        method: 'DELETE',
                                        success: function (response) {
                                            var response = JSON.parse(response);
                                            if (response.status) {
                                                location.reload();
                                                console.log(response);
                                            } else {
                                                sweetAlert(language.emotion_Success, language.clientes_cantDelete, 'error')
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    });
                    if (action == 'group' || tableData.grouped) {
                        app.tables.filter(function (d) {
                            if (d.id == tabInfo.id) {
                                d['grouped'] = true;
                                return true;
                            } else {
                                return true
                            }
                        });
                        var groupColumn = tableData.groupBy.column;
                        var groupIndex = 1;
                        $.each(tableData.dbcolumns, function (i, d) {
                            if (d.data == groupColumn) {
                                groupIndex = i;
                            }
                        });
                        //console.log(groupIndex);
                        zeTable.rowGrouping({
                            bExpandableGrouping: true,
                            iGroupingColumnIndex: groupIndex,
                            fnOnGrouped: function (groups) {
                                // //console.log(groups['shaft-centerline-plot']);
                            }
                        });
                    }

                    $(tab.content).data(tableData);
                    $('#' + tab.id).data('table', zeTable);
                    //console.log(tableData);
                    //<div class="col-md-8 no-padding"><input type="text" class="form-control dt_search" /></div><div class="col-md-2"><button class="btn btn-primary"><i class="fa fa-gear"></i> Filter</button></div><div class="col-md-2 no-padding"><button class="btn btn-primary"><i class="fa fa-gear"></i> Group By</button></div></div>
                    var tmp = $('<div><div class="col-md-5 no-padding searchby"></div><div class="col-md-3"><a class="btn btn-primary add_rcd" href="' + base_url + '/clientes/add"><i class="fa fa-plus"></i>' + language.clientes_addRecord + '</a></div><div class="col-md-2 filterby"></div><div class="col-md-2 no-padding groupby "></div></div></div>')
                    var searchby = $('<input type="text" class="form-control dt_search" />')
                    var filterby = $('<button class="btn btn-primary"><i class="fa fa-gear"></i> ' + language.dt_filter + '</button>')
                    var groupby = $('<button class="btn btn-primary"><i class="fa fa-gear"></i> ' + language.dt_group + '</button>')
                    searchby.data('id', tab.id);
                    searchby.keyup(function () {
                        var tabId = $(this).data('id');
                        var table = $('#' + tabId).data('table');
                        table.fnFilter($(this).val());
                    });

                    var filter_screen = $($('.temp_filter').html()).clone();
                    filterby.on('click', function (e) {
                        e.preventDefault();
                        groupby_screen.hide();
                        filter_screen.slideToggle();
                    });
                    $.each(dbcolumns, function (i, r) {
                        var option = $('<option value=""></option>');
                        option.prop('value', r.data);
                        option.html(r.title);
                        filter_screen.find('.dt_column').append(option);
                    });

                    //select dropdown
                    // filter_screen.find("select.selector").selectpicker({
                    //     style: 'btn-primary',
                    //     menuStyle: 'dropdown-inverse'
                    // });
                    if (!isAgain) {
                        var tableData = {
                            id: tab.id,
                            table: zeTable,
                            selectID: data.id,
                            task: data.task,
                            query: data.query,
                            data: dbdata,
                            tabName: $(tab.link).find('.link_text').html(),
                            filterBy: [],
                            groupBy: {
                                "column": '',
                                "aggregate": []
                            },
                            grouped: false,
                            dbcolumns: dbcolumns

                        }
                        app.clientesTable.push(tableData);
                        // localStorage.setItem('tables', JSON.stringify(app.tables));
                    }
                    //advanced search panels
                    filter_screen.find('.applyFilter').on('click', function (e) {
                        var panels = filter_screen.find('.filter_item:not(#newSearchItem_templ)');
                        var filterby = [];
                        $.each(panels, function (index, row) {
                            var obj = {};
                            obj['column'] = $(row).find('.dt_column').val();
                            obj['operator'] = $(row).find('.dt_operator').val();
                            obj['value'] = $(row).find('.dt_value').val();
                            if (obj.column != '') {
                                filterby.push(obj);
                            }
                        });
                        var tableData = app.clientesTable.filter(function (table, index) {
                            if (table.id == tab.id) {
                                table.filterBy = filterby;
                                return true;
                            }
                        });
                        if (!filterby.length) {
                            return false;
                        }
                        var filteredData = app.filterDtData(tableData[0].data, filterby);
                        app.clientesInit(JSON.stringify(filteredData), data, true, tab, 'filter');
                    });
                    filter_screen.find('#advancedSearch_accordion').on('click', '.panel-title > a', function (e) {

                        e.preventDefault();

                        $(this).closest('.panel-heading').next().find('.panel-body').slideToggle();

                    })



                    //hide advanced search
                    filter_screen.find('a#hideAdvancedSearch').click(function (e) {

                        e.preventDefault();

                        filter_screen.find('#advancedSearchForm_wrapper').slideUp();

                    })


                    filter_screen.find('a#addSearchItem').click(function (e) {

                        e.preventDefault();

                        newItem = filter_screen.find("#newSearchItem_templ").clone();

                        newItem.attr('id', '');
                        newItem.css('display', 'block');


                        newItem.find('.btn-group.select').each(function () {
                            $(this).remove();
                        });
                        // newItem.find('select.selector').selectpicker({
                        //     style: 'btn-primary',
                        //     menuStyle: 'dropdown-inverse'
                        // });
                        filter_screen.find("#advancedSearch_accordion").append(newItem);

                        filter_screen.find('#advancedSearch_accordion .panel:not(#newSearchItem_templ)').each(function (index) {

                            $(this).find('.item').html("Search item " + (index + 1));

                            $(this).find('.panel-title a').attr('href', '#as_collapse' + (index + 1));

                            $(this).find('.panel-collapse').attr('id', 'as_collapse' + (index + 1));

                            //$(this).find('.panel-collapse').removeClass('in');

                        });

                    })

                    //remove AS items

                    filter_screen.find('#advancedSearchForm').on('click', 'a.removeAsItem', function (e) {

                        e.preventDefault();

                        $(this).closest('.panel').remove();

                        filter_screen.find('#advancedSearch_accordion .panel:not(#newSearchItem_templ)').each(function (index) {

                            $(this).find('.item').html("Search item " + (index + 1));

                            $(this).find('.panel-title a').attr('href', '#as_collapse' + (index + 1));

                            $(this).find('.panel-collapse').attr('id', 'as_collapse' + (index + 1));

                            //$(this).find('.panel-collapse').removeClass('in');
                        });
                    });

                    // Group By
                    var groupby_screen = $($('.temp_groupby').html()).clone();
                    groupby.on('click', function (e) {
                        e.preventDefault();
                        filter_screen.hide();
                        groupby_screen.slideToggle();
                    });

                    if (action == 'filter') {
                        // filterby.click();
                    } else if (action == 'group') {
                        // groupby.click();
                    }

                    $.each(dbcolumns, function (i, r) {
                        var option = $('<option value=""></option>');
                        option.prop('value', r.data);
                        option.html(r.title);
                        groupby_screen.find('.dt_column').append(option);
                    });

                    groupby_screen.find('.groupColumn').on('click', function (e) {
                        var panels = groupby_screen.find('.agr_items .agregate_item:not(#newgroupItem_templ)');
                        var agregate_item = [];
                        var groupby = groupby_screen.find('.group_by_dt option:selected').val();
                        $.each(panels, function (index, row) {
                            var obj = {};
                            obj['column'] = $(row).find('.dt_column').val();
                            obj['operator'] = $(row).find('.dt_agregate').val();
                            obj['row'] = row;
                            if (obj.column != '') {
                                agregate_item.push(obj);
                            }
                        });
                        var tableData = app.clientesTable.filter(function (table, index) {
                            if (table.id == tab.id) {
                                table.groupBy['column'] = groupby;
                                table.groupBy['aggregate'] = agregate_item;
                                return true;
                            }
                        });
                        gdata = tableData[0].data;
                        var filteredData = app.groupDtData(gdata, agregate_item);
                        $.each(filteredData, function (index, row) {
                            if (isNaN(row.result)) {
                                $(row.row).find('.result_aggregate').html('La columna selecciona no contiene un valor numerico. Selecciona una columna que lo contenga.');
                            } else {
                                $(row.row).find('.result_aggregate').html('Resultados: ' + row.result);
                            }
                        });
                        app.clientesInit(JSON.stringify(gdata), data, true, tab, 'group');
                    });
                    groupby_screen.find('#advancedSearch_accordion').on('click', '.panel-title > a', function (e) {

                        e.preventDefault();

                        $(this).closest('.panel-heading').next().find('.panel-body').slideToggle();

                    })




                    groupby_screen.find('a#addagregateItem').click(function (e) {

                        e.preventDefault();

                        newItem = groupby_screen.find("#newgroupItem_templ").clone();

                        newItem.attr('id', '');
                        newItem.css('display', 'block');

                        newItem.find('.btn-group.select').each(function () {
                            $(this).remove();
                        });
                        // newItem.find('select.selector').selectpicker({
                        //     style: 'btn-primary',
                        //     menuStyle: 'dropdown-inverse'
                        // });
                        groupby_screen.find(".agr_items").append(newItem);

                    });

                    //remove AS items

                    groupby_screen.find('#advancedgroupForm').on('click', 'a.removeAsItem', function (e) {

                        e.preventDefault();

                        $(this).closest('.panel').remove();

                        groupby_screen.find('#advancedgroup_accordion .panel:not(#newgroupItem_templ)').each(function (index) {

                            $(this).find('.item').html("Search item " + (index + 1));

                            $(this).find('.panel-title a').attr('href', '#as_groupcollapse' + (index + 1));

                            $(this).find('.panel-collapse').attr('id', 'as_groupcollapse' + (index + 1));

                            //$(this).find('.panel-collapse').removeClass('in');

                        });
                    });

                    if (isAgain && action != 'reset') {
                        var tableData = app.clientesTable.filter(function (table, index) {
                            if (table.id == tab.id) {
                                return true;
                            }
                        });
                        $.each(tableData[0].filterBy, function (index, filter) {
                            if (index == 0) {
                                newItem = filter_screen.find("#advancedSearch_accordion .panel:not(#newSearchItem_templ)");
                            } else {
                                newItem = filter_screen.find("#newSearchItem_templ").clone();
                            }
                            newItem.attr('id', '');
                            newItem.css('display', 'block');
                            newItem.find('.dt_column').find('option[value="' + filter.column + '"]').attr('selected', true);
                            newItem.find('.dt_operator').find('option[value="' + filter.operator + '"]').attr('selected', true);
                            newItem.find('.dt_value').val(filter.value);

                            newItem.find('.btn-group.select').each(function () {
                                $(this).remove();
                            });
                            // newItem.find('select.selector').selectpicker({
                            //     style: 'btn-primary',
                            //     menuStyle: 'dropdown-inverse'
                            // });

                            filter_screen.find('#advancedSearch_accordion .panel:not(#newSearchItem_templ)').each(function (index) {

                                $(this).find('.item').html("Search item " + (index + 1));

                                $(this).find('.panel-title a').attr('href', '#as_collapse' + (index + 1));

                                $(this).find('.panel-collapse').attr('id', 'as_collapse' + (index + 1));

                                //$(this).find('.panel-collapse').removeClass('in');

                            });
                            if (index != 0) {
                                filter_screen.find("#advancedSearch_accordion").append(newItem);
                            }
                        });
                        $.each(tableData[0].groupBy.aggregate, function (index, aggregate) {
                            newItem = groupby_screen.find("#newgroupItem_templ").clone();

                            newItem.attr('id', '');
                            newItem.css('display', 'block');
                            newItem.find('.dt_column').find('option[value="' + aggregate.column + '"]').attr('selected', true);
                            newItem.find('.dt_agregate').find('option[value="' + aggregate.operator + '"]').attr('selected', true);
                            newItem.find('.btn-group.select').each(function () {
                                $(this).remove();
                            });
                            if (isNaN(aggregate.result)) {
                                newItem.find('.result_aggregate').html('La columna selecciona no contiene un valor numerico. Selecciona una columna que lo contenga.');
                            } else {
                                newItem.find('.result_aggregate').html('Result: ' + aggregate.result);
                            }
                            // newItem.find('select.selector').selectpicker({
                            //     style: 'btn-primary',
                            //     menuStyle: 'dropdown-inverse'
                            // });
                            groupby_screen.find(".agr_items").append(newItem);
                        });

                        groupby_screen.find(".group_by_dt").find('option[value="' + app.clientesTable[0].groupBy.column + '"]').attr('selected', true);
                    }

                    var tableData = app.clientesTable.filter(function (table, index) {
                        if (table.id == tab.id) {
                            return true;
                        }
                    });
                    filter_screen.find('.resetTable').on('click', function (e) {
                        app.clientesInit(JSON.stringify(app.clientesTable[0].data), data, true, tab, 'reset');
                    });
                    groupby_screen.find('.resetTable').on('click', function (e) {
                        app.clientesInit(JSON.stringify(app.clientesTable[0].data), data, true, tab, 'reset');
                    });
                    tmp.find('.searchby').append(searchby);
                    tmp.find('.filterby').append(filterby);
                    tmp.find('.groupby').append(groupby);
                    tmp.append(filter_screen);
                    tmp.append(groupby_screen);
                    $('.dbtable').data('table', zeTable);
                    setTimeout(function (e) {

                        $(tab.content).find('.datatable_features').append(tmp);

                        //custom search field

                    }, 1000);
                }
                app.loadajax(base_url + 'leads/leads', 'GET', {}, function (response, data) {
                    if (JSON.parse(response).content.length) {
                        app.clientesInit(response, data, false, '', '')

                    } else {
                        $('.nodata').show();
                    }
                });
            </script>
            <script>
                jQuery(document).ready(function () {
                    Metronic.init(); // init metronic core componets
                    Layout.init(); // init layout
                    app.tasks.tasksList();
                    app.header.init();
                    // Calendar.init();
                    Todo.init();
                });
            </script>
        </div>
    </body>

</html>

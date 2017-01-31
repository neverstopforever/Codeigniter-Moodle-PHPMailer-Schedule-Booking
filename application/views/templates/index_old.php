        <!-- BEGIN PAGE CONTAINER -->
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
            </div>
            <!-- END PAGE HEAD -->
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="#"><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_plantillas'); ?>
                </li>
            </ul>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet light">
                        <div class="nodata" style="display:none;text-align:center;">
                            <a class="btn btn-primary btn-lg add_rcd" style="min-width:300px;min-height:80;" href="<?php echo base_url() ?>/clientes/add">
                                <i class="fa fa-plus"></i><?php echo $this->lang->line('clientes_addRecord'); ?>
                            </a>
                        </div>
                        <div class="table_loading"></div>
                        <div class=" index_table">
                            <div class="col-md-12">
                                <div class="pull-right">
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="tabs_container" style="display:block;">
                                    <div class="card">
                                        <div class="tab temp" style="display:block;">
                                            <div class="" style="float: right;"><a href="<?= base_url() ?>templates/add" class="btn btn-primary add_rcd"><i class="fa fa-plus"></i>Add Template</a></div>
                                        </div>
                                        <form action="<?= base_url() ?>templates/search" method="post">
                                            <div class="tab temp" style="display:block;">
                                                <div class="" style="float: left;">
                                                    <select name="searchCategory" class="select-block selector dt_operator form-control aaa" style="float: left;">
                                                        <option value="all">All</option>
                                                        <?php foreach ($categories as $category) { ?>
                                                            <option <?php if (isset($searchCategory) && $searchCategory == $category->id) { ?> selected="" <?php } ?> value="<?= $category->id ?>"><?= $category->nombre ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="tab temp" style="display:block;">
                                                <div class="" style="float: left; margin-left: 10px;">
                                                    <button type="submit" class="btn btn-primary add_rcd"><i class="fa fa-gear"></i>Filter By Category</button>
                                                </div>
                                            </div>
                                        </form>
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

                                            <table class="easyui-datagrid" title="Teamplate Listing" style="width:100%; height: auto;"
                                                   data-options="singleSelect:true,collapsible:false">
                                                <thead>
                                                    <tr>
                                                        <th data-options="field:'id',width:'10%', align:'center'">Id</th>
                                                        <th data-options="field:'Nombre',width:'35%'">Title</th>
                                                        <!--<th data-options="field:'DocAsociado',width:'20%'">DocAsociado</th>-->
                                                        <th data-options="field:'cat_name',width:'35%'">Category Name</th>
                                                        <!--<th data-options="field:'action',width:'25%', align:'center'">Action</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (sizeof($templates) > 0) {
                                                        foreach ($templates as $tempalte) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $tempalte->id ?></td>
                                                                <td>
                                                                    <a title="click to edit Template" href="<?= base_url() ?>templates/edit/<?= $tempalte->id ?>"><?= $tempalte->Nombre ?></a>
                                                                </td>
                                                                <!--<td><?= $tempalte->DocAsociado ?></td>-->
                                                                <td><?= $tempalte->cat_name ?></td>
<!--                                                                <td>
                                                                    <a class="contactos_btn btn-success" href="<?= base_url() ?>templates/edit/<?= $tempalte->id ?>">
                                                                        <i class="fa fa-edit"></i> Edit
                                                                    </a>
                                                                    <a class="contactos_btn btn-danger  delete_clientes" href="<?= base_url() ?>templates/delete/<?= $tempalte->id ?>" onclick="return confirm('Are you sure you want to delete?');">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </a>
                                                                </td>-->
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
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

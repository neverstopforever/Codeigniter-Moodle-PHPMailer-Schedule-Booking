<style>
    .dataTables_wrapper {
        width: 100%;
        overflow: auto;
    }

    .wysihtml5-toolbar .dropdown-menu {
        z-index: 999999999 !important;
    }
</style>
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_clientes'); ?></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <div class="table_loading"></div>
        <div class="page-content">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="<?php echo $layoutClass ?>">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="col-md-12">
                            <a href="<?php echo base_url() ?>clientes" class="btn btn-success pull-right">&times;</a>
                        </div>
                        <div class="col-md-3">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="panel panel-success">
                                <div class="panel-heading">General</div>
                                <div class="panel-body no-padding-all">
                                    <ul class="sidebar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#datos-comerciales"
                                                                                  aria-controls="datos-comerciales"
                                                                                  role="tab"
                                                                                  data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_datosComerciales'
                                                ); ?></a></li>
                                        <li><a href="#fcturation" aria-controls="fcturation" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_fcturation'
                                                ); ?></a></li>
                                        <li><a href="#empleados" aria-controls="empleados" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_empleados'
                                                ); ?></a></li>
                                        <li><a href="#documentos" aria-controls="documentos" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_documentos'
                                                ); ?></a></li>
                                        <li><a href="#seguimiento" aria-controls="seguimiento" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_seguimiento'
                                                ); ?></a></li>
                                        <li><a href="#adicionales" aria-controls="adicionales" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_adicionales'
                                                ); ?></a></li>
                                        <li><a href="#filiales" aria-controls="filiales" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_filiales'
                                                ); ?></a></li>
                                        <li class="list-devider">Informes</li>
                                        <li><a href="#matriculas" aria-controls="matriculas" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_matriculas'
                                                ); ?></a></li>
                                        <li><a href="#contabilidad" aria-controls="contabilidad" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_contabilidad'
                                                ); ?></a></li>
                                        <li><a href="#plantillas" aria-controls="plantillas" role="tab"
                                               data-toggle="tab"><?php echo $this->lang->line(
                                                    'clientes_plantillas'
                                                ); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                    <form class="update_datos_comerciales_form">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_ccodcli'); ?>
                                                    <input type="text" class="form-control" name="ccodcli" disabled
                                                           value="<?php echo $content[0]->ccodcli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_FirstUpdate') ?>
                                                    <input type="text" class="form-control" readonly name="FirstUpdate"
                                                           value="<?php echo ($lang == "english") ? Date(
                                                               'm/d/Y',
                                                               strtotime($content[0]->FirstUpdate)
                                                           ) : Date('d/m/Y', strtotime($content[0]->FirstUpdate)); ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_LastUpdate') ?>
                                                    <input type="text" class="form-control datepicker" readonly
                                                           name="LastUpdate"
                                                           value="<?php echo ($lang == "english") ? Date(
                                                               'm/d/Y',
                                                               strtotime($content[0]->LastUpdate)
                                                           ) : Date('d/m/Y', strtotime($content[0]->LastUpdate)); ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cnomcli') ?>
                                                    <input type="text" class="form-control" name="cnomcli"
                                                           value="<?php echo $content[0]->cnomcli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cnomcom') ?>
                                                    <input type="text" class="form-control" name="cnomcom"
                                                           value="<?php echo $content[0]->cnomcom; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_Cpobcli') ?>
                                                    <input type="text" class="form-control" name="Cpobcli"
                                                           value="<?php echo $content[0]->Cpobcli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_Cdomicilio') ?>
                                                    <textarea type="text" class="form-control" name="Cdomicilio"
                                                              style="min-height:100px;"
                                                              value="<?php echo $content[0]->Cdomicilio; ?>"></textarea>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cprovincia') ?>
                                                    <input type="text" class="form-control" name="cprovincia"
                                                           value="<?php echo $content[0]->cprovincia; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cnaccli') ?>
                                                    <input type="text" class="form-control" name="cnaccli"
                                                           value="<?php echo $content[0]->cnaccli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cdnicif') ?>
                                                    <input type="text" class="form-control" name="cdnicif"
                                                           value="<?php echo $content[0]->cdnicif; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cobscli') ?>
                                                    <input type="text" class="form-control" name="cobscli"
                                                           value="<?php echo $content[0]->cobscli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_ctfo1cli') ?>
                                                    <input type="text" class="form-control" name="ctfo1cli"
                                                           value="<?php echo $content[0]->ctfo1cli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_Ctfo2cli') ?>
                                                    <input type="text" class="form-control" name="Ctfo2cli"
                                                           value="<?php echo $content[0]->Ctfo2cli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_SkypeEmpresa') ?>
                                                    <input type="text" class="form-control" name="SkypeEmpresa"
                                                           value="<?php echo $content[0]->SkypeEmpresa; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_movil') ?>
                                                    <input type="text" class="form-control" name="movil"
                                                           value="<?php echo $content[0]->movil; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cfaxcli') ?>
                                                    <input type="text" class="form-control" name="cfaxcli"
                                                           value="<?php echo $content[0]->cfaxcli; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_email') ?>
                                                    <input type="email" class="form-control" name="email"
                                                           value="<?php echo $content[0]->email; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_web') ?>
                                                    <input type="text" class="form-control" name="web"
                                                           value="<?php echo $content[0]->web; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_ccontacto') ?>
                                                    <input type="text" class="form-control" name="ccontacto"
                                                           value="<?php echo $content[0]->ccontacto; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cargo') ?>
                                                    <input type="text" class="form-control" name="cargo"
                                                           value="<?php echo $content[0]->cargo; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cobserva') ?>
                                                    <textarea type="text" class="form-control" name="cobserva"
                                                              style="min-height:200px"
                                                              value="<?php echo $content[0]->cobserva; ?>"></textarea>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <button class="btn btn-success " type="submit">
                                                    <?php echo $this->lang->line('clientes_updateBtn'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="fcturation">
                                    <form class="fcturation_form">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_idfp'); ?>
                                                    <select name="idfp" class="form-control">
                                                        <?php //  echo  content[0]->idfp;$  ?>
                                                        <?php
                                                        foreach ($formaspago as $paymontMethod) {
                                                            $selected = '';
                                                            if ($content[0]->idfp == $paymontMethod->Codigo) {
                                                                $selected = 'selected';
                                                            }
                                                            ?>
                                                            <option
                                                                value="<?php echo $paymontMethod->Codigo; ?>" <?php echo $selected; ?> >
                                                                <?php echo $paymontMethod->Descripcion; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_tarjetanum'); ?>
                                                    <input type="text" class="form-control" name="tarjetanum"
                                                           value="<?php echo $content[0]->tarjetanum; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_tarjetacadmes'); ?>
                                                    <input type="text" class="form-control expirecc"
                                                           name="tarjetacadmes"
                                                           value="<?php echo $content[0]->tarjetacadmes; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_tarjetacadano'); ?>
                                                    <input type="text" class="form-control year" name="tarjetacadano"
                                                           value="<?php echo $content[0]->tarjetacadano; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_irpf'); ?>
                                                    <input type="text" class="form-control" name="irpf"
                                                           value="<?php echo $content[0]->irpf; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_centidad'); ?>
                                                    <input type="text" class="form-control" name="centidad"
                                                           value="<?php echo $content[0]->centidad; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cagencia'); ?>
                                                    <input type="text" class="form-control" name="cagencia"
                                                           value="<?php echo $content[0]->cagencia; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_cctrlbco'); ?>
                                                    <input type="text" class="form-control" name="cctrlbco"
                                                           value="<?php echo $content[0]->cctrlbco; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_ccuenta'); ?>
                                                    <input type="text" class="form-control" name="ccuenta"
                                                           value="<?php echo $content[0]->ccuenta; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_iban'); ?>
                                                    <input type="text" class="form-control" name="iban"
                                                           placeholder="XX00 0000 0000 0000 0000 0000"
                                                           value="<?php echo $content[0]->iban; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" class="" name="Firmado_sepa" value="1" <?php
                                                    if ($content[0]->Firmado_sepa) {
                                                        echo 'checked';
                                                    }
                                                    ?> />
                                                    <?php echo $this->lang->line('form_Firmado_sepa'); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo $this->lang->line('form_banco'); ?>
                                                    <input type="text" class="form-control" name="banco"
                                                           value="<?php echo $content[0]->banco; ?>"/>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <button class="btn btn-success" type="submit">
                                                    <?php echo $this->lang->line('clientes_updateBtn'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="empleados">
                                    <table class="empleados_table table  table-striped table-hover table-bordered ">
                                        <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_id'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_actions'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_idalumno'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_nombre'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_domicilio'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_dni'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_Telefono'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_movil'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_empleados_email'); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($empleados as $empleado) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $empleado->Id; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger empleados_unlink">
                                                        <?php echo $this->lang->line('clientes_unlink'); ?>
                                                    </button>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->Idalumnbo; ?>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->cnomcli; ?>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->Cdomicilio; ?>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->CDNICIF; ?>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->ctfo1cli; ?>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->movil; ?>
                                                </td>
                                                <td>
                                                    <?php echo $empleado->email; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="documentos">
                                    <!--TODO area fo qasim START-->
                                    <div class="row">
                                        <!--                                                Filter Div-->
                                    </div>
                                    <div class="row">
                                        <ul class="nav_action_list">
                                            <li>
                                                <form method="post" enctype="multipart/form-data" id="upload_form"
                                                      action="<?php echo base_url() ?>awsrest">
                                                    <input type="file" style="display: none;" name="file_to_be_sent"
                                                           required="required" id="file_to_be_sent"/>
                                                    <input type="hidden" name="clientid"
                                                           value="<?php echo $clienteId; ?>"/>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="">
                                        <table class="documentos table">
                                            <thead>
                                            <tr>
                                                <td>
                                                    <?php echo $this->lang->line('actions'); ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->lang->line('clientes_document_name'); ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->lang->line('clientes_document_visible'); ?>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody id="table_body_documentos">
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--
                                    <!--TODO area fo qasim END-->
                                </div>
                                <div role="tabpanel" class="tab-pane" id="seguimiento">
                                    <div class="modal fade in" id="add_seguimiento" style="z-index:9999999999;"
                                         role="dialog" aria-labelledby="myModalLabel">
                                        <form>
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel"><?php echo $this->lang->line(
                                                                'clientes_addSeguimiento'
                                                            ); ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_titulo'
                                                                ); ?>
                                                            </label>
                                                            <input type="text" class="form-control" required
                                                                   name="titulo"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_fecha'
                                                                ); ?>
                                                            </label>
                                                            <input type="date" class="form-control " required
                                                                   name="fecha"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_usuario'
                                                                ); ?>
                                                            </label>
                                                            <div style="text-transform:uppercase">
                                                                <?php
                                                                $userData = $this->session->userdata('userData');
                                                                echo $usuario = $userData[0]->USUARIO;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_comentario'
                                                                ); ?>
                                                            </label>
                                                            <textarea class="form-control" required
                                                                      name="comentarios"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            <?php echo $this->lang->line('button_modalClose'); ?>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <?php echo $this->lang->line('button_saveChanges'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal fade in" id="edit_seguimiento" style="z-index:9999999999;"
                                         role="dialog" aria-labelledby="myModalLabel">
                                        <form>
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel"><?php echo $this->lang->line(
                                                                'clientes_editrecord'
                                                            ); ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_titulo'
                                                                ); ?>
                                                            </label>
                                                            <input type="text" class="form-control" required
                                                                   name="titulo"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_fecha'
                                                                ); ?>
                                                            </label>
                                                            <input type="text" class="form-control datepicker" required
                                                                   name="fecha"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_usuario'
                                                                ); ?>
                                                            </label>
                                                            <div style="text-transform:uppercase">
                                                                <?php
                                                                $userData = $this->session->userdata('userData');
                                                                echo $usuario = $userData[0]->USUARIO;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line(
                                                                    'clientes_followup_comentario'
                                                                ); ?>
                                                            </label>
                                                            <textarea class="form-control" required
                                                                      name="comentarios"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            <?php echo $this->lang->line('button_modalClose'); ?>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <?php echo $this->lang->line('button_saveChanges'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <table class="Seguimiento_table table  table-striped table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->lang->line('clientes_followup_id'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_followup_fecha'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_followup_titulo'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_followup_comentario'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_followup_actions'); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($Seguimiento as $SeguimientoItem) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $SeguimientoItem->id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $SeguimientoItem->fecha; ?>
                                                </td>
                                                <td>
                                                    <?php echo $SeguimientoItem->titulo; ?>
                                                </td>
                                                <td>
                                                    <?php echo $SeguimientoItem->comentarios; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success seguimiento_edit"
                                                            data-id="<?php echo $SeguimientoItem->id; ?>"><i
                                                            class="fa fa-edit "></i></button>
                                                    <button class="btn btn-danger seguimiento_delete"
                                                            data-id="<?php echo $SeguimientoItem->id; ?>"><i
                                                            class="fa fa-trash "></i></button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="adicionales">
                                    <!-- Modal -->
                                    <form id="add_adicionales">
                                        <?php if(!empty($Adicionales)) {?>
                                            <?php foreach($Adicionales as $Adicional){ ?>
                                                <div class="col-md-12 form-group">
                                                    <div class="col-md-3">

                                                        <?php echo  ucfirst(strtolower(str_replace('_', " ", $Adicional->name))); ?>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <?php if($Adicional->type != 'textarea'){ ?>
                                                            <?php if($Adicional->name == 'area_academica' && isset($area_academica) && !empty($area_academica)){?>
                                                                <select class="form-control" name="area_academica">
                                                                    <?php foreach ($area_academica as $value) { ?>

                                                                     <option value="<?php echo $value->id; ?>"  <?php echo $value->id == $Adicional->value ? 'selected' : ''; ?> ><?php echo $value->valor; ?></option>';
                                                                  <?php }  ?>
                                                                </select>

                                                            <?php }else{ ?>

                                                                <input type="<?php echo $Adicional->type; ?>" class="form-control " name="<?php echo $Adicional->name; ?>"
                                                                    value="<?php echo $Adicional->value; ?>" >
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                            <textarea type="text" class="form-control " name="<?php echo $Adicional->name; ?>">
                                                           <?php echo $Adicional->value; ?>
                                                        </textarea>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="pull-right">
                                                    <button class="btn btn-success">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="filiales">
                                    <table class="Filiales table  table-striped table-hover table-bordered ">
                                        <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->lang->line('clientes_filiales_comercial_action'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_filiales_comercial_id'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_filiales_fiscal_name'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_filiales_comercial_name'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_filiales_comercial_cif'); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($Filiales)) {
                                            foreach ($Filiales as $empleado) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <button class="btn btn-danger delete"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->id; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->NombreFiscal; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->NombreComercial; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->nif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="contabilidad">
                                    <table class="contabilidad table  table-striped table-hover table-bordered ">
                                        <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_matricula'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_factura'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_concepto'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_recibo'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_vto'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_cobro'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_adeudo'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_descripcion'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_fecha_cobro'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_facturado'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_remesado'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_contab_remesas'); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($historicAccount)) {
                                            foreach ($historicAccount as $empleado) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $empleado->NumMatricula; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->N_FACTURA; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->concepto; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->NUM_RECIBO; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->FECHA_VTO; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Cobro; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Adeudo; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Descripcion; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->FechaCobro; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Facturado; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Remesado; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Remesas; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="matriculas">
                                    <table class="HistoricFees table  table-striped table-hover table-bordered ">
                                        <thead>
                                        <tr>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_mat_matricula'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_mat_fecha'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_mat_alumno'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('clientes_informes_mat_estado'); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($HistoricFees)) {
                                            foreach ($HistoricFees as $empleado) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $empleado->Matricula; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->fecha; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->Alumno; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $empleado->EstadoMatrícula; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="plantillas">
                                    <form id="template-form" action="<?= base_url() ?>Templates/printTemplate"
                                          method="post">
                                        <div class="col-md-12 form-group" style="display: none;">
                                            <div class="col-md-3">
                                                Categoria
                                            </div>
                                            <div class="col-md-9">
                                                <?php echo form_dropdown('id_cat', $plantillas_cat, ''); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <div class="col-md-3">
                                                Documentos
                                            </div>
                                            <div class="col-md-9">
                                                <select name="templateId">
                                                    <option value="">Select Documento</option>
                                                    <?php foreach ($document_cat as $doc) { ?>
                                                        <option
                                                            value="<?= $doc->id ?>"><?= $doc->DocAsociado ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input type="hidden" name="lead_client_id" value="<?= $clientId ?>"/>
                                                <input type="hidden" name="id_cat" value="<?= $id_cat ?>"/>
                                                <input type="hidden" name="cat_type" value="clientes" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group" style="display: none;">
                                            <br>
                                            <div class="col-md-3">
                                                Documento
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group" style="display: none;">
                                            <div id="wysihtml5-toolbar" style="display: none;">
                                                <a data-wysihtml5-command="bold">bold</a>
                                                <a data-wysihtml5-command="italic">italic</a>
                                                <a data-wysihtml5-command="underline">italic</a>

                                                <!-- Some wysihtml5 commands require extra parameters -->

                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='div' tabindex='-1'>Normal</a>
                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='h1' tabindex='-1'>h1</a>
                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='h2' tabindex='-1'>h2</a>
                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='h3' tabindex='-1'>h3</a>
                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='h4'>h4</a>
                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='h5'>h5</a>
                                                <a data-wysihtml5-command='formatBlock'
                                                   data-wysihtml5-command-value='h6'>h6</a>

                                                <a data-wysihtml5-command='insertUnorderedList' title='unordered'><i
                                                        class='glyphicon glyphicon-list'></i></a>
                                                <a data-wysihtml5-command='insertOrderedList' title='ordered'><i
                                                        class='glyphicon glyphicon-th-list'></i></a>
                                                <a data-wysihtml5-command='Outdent' title='outdent'><i
                                                        class='glyphicon glyphicon-indent-right'></i></a>
                                                <a data-wysihtml5-command='Indent' title='indent'><i
                                                        class='glyphicon glyphicon-indent-left'></i></a>


                                                <!-- Some wysihtml5 commands like 'createLink' require extra paramaters specified by the user (eg. href) -->
                                                <a data-wysihtml5-command="createLink">insert link</a>
                                                <div data-wysihtml5-dialog="createLink" style="display: none;">
                                                    <label>
                                                        Link:
                                                        <input data-wysihtml5-dialog-field="href" value="http://"
                                                               class="text">
                                                    </label>
                                                    <a data-wysihtml5-dialog-action="save">OK</a> <a
                                                        data-wysihtml5-dialog-action="cancel">Cancel</a>
                                                </div>
                                                <a data-wysihtml5-action="change_view" href="javascript:;"
                                                   unselectable="on">change</a>
                                            </div>


                                            <textarea id="wysihtml5-textarea" name="webDocumento" rows="8" cols="100"
                                                      placeholder="Enter your text ..." autofocus></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <button type="submit" id="print44" class="btn btn-success">Print
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contactos_linkpopup">
        <div class="close_me_over">
            &times;
        </div>
        <table class="clientes table  table-striped table-hover table-bordered ">
        </table>
    </div>
    <div class="alumnos_linkpopup">
        <div class="close_me_over">
            &times;
        </div>
        <table class="alumnos table  table-striped table-hover table-bordered ">
        </table>
    </div>
    <div class=""></div>
    <div class="modal fade" id="documenUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload Document</h4>
                </div>
                <form id="DocumentUp" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="file_name">
                            <input placeholder="<?php echo $this->lang->line('fileTitle'); ?>" type="text" name="nombre"
                                   required class="filenombre"/>
                        </div>
                        <div class="file_up">
            <span class="btn btn-default btn-file">
                Browse <input required class="documentin" type="file" name="document[]"/>
            </span>

                        </div>
                        <div class="msgblock"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var _sizeof_adicionales = "<?php echo sizeof($Adicionales) ?>";
    var _clienteId = "<?php echo $clienteId ?>";
    var _tableContents = JSON.parse('<?php echo json_encode($clientes); ?>');
    var _clientesData_dataKeys = JSON.parse('<?php echo json_encode($dataKeys); ?>');
    var _alumnostableContents = JSON.parse('<?php echo json_encode($alumnos); ?>');
</script>


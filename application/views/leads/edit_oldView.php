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
                                    <a href="<?php echo base_url() ?>prospects" class="btn btn-success pull-right">&times;</a>
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="panel panel-success">
                                        <div class="panel-heading">General</div>
                                        <div class="panel-body no-padding-all">
                                            <ul class="sidebar_tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#datos-comerciales" aria-controls="Datos_Personales" role="tab" data-toggle="tab"><?php echo $this->lang->line('Datos_Personales'); ?></a></li>
                                                <li><a href="#details" aria-controls="fcturation" role="tab" data-toggle="tab"><?php echo $this->lang->line('details'); ?></a></li>
                                                <li><a href="#personalized_fields" aria-controls="empleados" role="tab" data-toggle="tab"><?php echo $this->lang->line('personalized_fields'); ?></a></li>
                                                <li><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab"><?php echo $this->lang->line('clientes_documentos'); ?></a></li>
                                                <li><a href="#follow_up" aria-controls="seguimiento" role="tab" data-toggle="tab"><?php echo $this->lang->line('follow_up'); ?></a></li>
                                                <li><a href="#plantillas" aria-controls="seguimiento" role="tab" data-toggle="tab"><?php echo $this->lang->line('template'); ?></a></li>
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
                                                            <input type="text" class="form-control" name="numpresupuesto" disabled value="<?php echo $content[0]->NumPresupuesto; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('first_name') ?>
                                                            <input type="text" class="form-control" readonly name="sNombre" value="<?php echo $content[0]->sNombre; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('sur_name') ?>
                                                            <input type="text" class="form-control" readonly name="sApellidos" value="<?php echo $content[0]->sApellidos; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('full_name') ?>
                                                            <input type="text" class="form-control" name="" value="<?php echo $content[0]->sNombre . ' ' . $content[0]->sApellidos; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('city') ?>
                                                            <input type="text" class="form-control" name="Poblacion" value="<?php echo $content[0]->Poblacion; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('province') ?>
                                                            <input type="text" class="form-control" name="Provincia" value="<?php echo $content[0]->Provincia; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('adress') ?>
                                                            <textarea type="text" class="form-control" name="domicilio" style="min-height:100px;">
                                                                <?php echo $content[0]->domicilio; ?>
                                                            </textarea>
                                                            <!--<input type="text" class="form-control" name="domicilio" value="<?php // echo  $content[0]->domicilio;     ?>" />-->
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('birthday') ?>
                                                            <input type="text" class="form-control datepicker" name="Nacimiento"  value="<?php echo ($lang == "english") ? Date('m/d/Y', strtotime($content[0]->Nacimiento)) : Date('d/m/Y', strtotime($content[0]->Nacimiento)); ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('country') ?>
                                                            <input type="text" class="form-control" name="pais" value="<?php echo $content[0]->pais; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('sex') ?>
                                                            <select name="idsexo">
                                                                <option value="1" <?php if ($content[0]->idsexo == 1) { ?>selected
                                                                        <?php } ?>>
                                                                            <?php echo $this->lang->line('male') ?>
                                                                </option>
                                                                <option value="2" <?php if ($content[0]->idsexo == 2) { ?>selected
                                                                        <?php } ?>>
                                                                            <?php echo $this->lang->line('female') ?>
                                                                </option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('phone1') ?>
                                                            <input type="text" class="form-control" name="Telefono" value="<?php echo $content[0]->Telefono; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('phone2') ?>
                                                            <input type="text" class="form-control" name="Telefono2" value="<?php echo $content[0]->Telefono2; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('mobile') ?>
                                                            <input type="text" class="form-control" name="Movil" value="<?php echo $content[0]->Movil; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('passport') ?>
                                                            <input type="text" class="form-control" name="CDNICIF" value="<?php echo $content[0]->CDNICIF; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('email1') ?>
                                                            <input type="text" class="form-control" name="email" value="<?php echo $content[0]->email; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('email2') ?>
                                                            <input type="text" class="form-control" name="email2" value="<?php echo $content[0]->email2; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('fax') ?>
                                                            <input type="email" class="form-control" name="Fax" value="<?php echo $content[0]->Fax; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('IBAN') ?>
                                                            <input type="text" class="form-control" name="iban" value="<?php echo $content[0]->iban; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('bank') ?>
                                                            <input type="text" class="form-control" name="cc1" value="<?php echo $content[0]->cc1; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="text" class="form-control" name="cc2" value="<?php echo $content[0]->cc2; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="text" class="form-control" name="cc3" value="<?php echo $content[0]->cc3; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="text" class="form-control" name="cc4" value="<?php echo $content[0]->cc4; ?>" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 company_select">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('comp_id') ?>
                                                            <input readonly type="text" class="form-control" name="facturara" value="<?php echo $content[0]->facturara; ?>" />
                                                        </label>
                                                    </div>
                                                    <a href="javascript:;" class="select_company contactos_btn btn-success "><i class="fa fa-edit"></i></a><span class="company_name"><?php echo isset($content[0]->CnomCli)?$content[0]->CnomCli:""; ?></span>
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
                                        <div role="tabpanel" class="tab-pane" id="details">
                                            <form class="fcturation_form">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo $this->lang->line('Middle_Catchment'); ?>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="medio" value="<?php echo $content[0]->IdMedio; ?>" readonly />
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-crosshairs IdMedio"></i>
                                                            </span>
                                                            <input id="mediodesc" type="text" class="form-control" readonly  value="<?php echo $content[0]->Descripcion; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo $this->lang->line('campaign'); ?>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="Campaña" value="<?php echo $content[0]->IdCampaña; ?>" readonly />
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-crosshairs campaign"></i>
                                                            </span>
<!--                                                            <input id="campdesc" type="text" class="form-control" readonly value="--><?php //echo $content[0]->Des; ?><!--" />-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <?php echo $this->lang->line('Descripcion'); ?>
                                                        <textarea class="form-control" name="Descripcion"><?php echo $content[0]->Descripcion; ?></textarea>
                                                    </div>
                                                </div>
                                            <div class="col-md-12">
                                                <h3>Detalle De La Solicitud</h3>
                                                <div class="lst_sol_sol">
                                                    <table class="lst_sol_solTable  table  table-striped table-hover table-bordered"></table>
                                                </div>
                                            </div>
                                        <div class="col-md-12 mt10">
                                                    <div class="col-md-12">
                                                        <div class="pull-right">
                                                            <button class="btn btn-success">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="personalized_fields">
                                            <form method="post" action="">
                                                <input type="hidden" value="<?php echo $content[0]->NumPresupuesto; ?>" name="id">
                                                <?php if(!empty($personal_fields)) {?>
                                                    <?php foreach($personal_fields as $fields){ ?>
                                                        <div class="col-md-12 form-group">
                                                            <div class="col-md-3">

                                                                <?php echo  ucfirst(strtolower(str_replace('_', " ", $fields->name))); ?>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <?php if($fields->type != 'textarea'){ ?>

                                                                        <input type="<?php echo $fields->type; ?>" class="form-control " name="<?php echo $fields->name; ?>"
                                                                               value="<?php echo $fields->value; ?>" >
                                                                <?php }else{ ?>
                                                                    <textarea type="text" class="form-control " name="<?php echo $fields->name; ?>">
                                                           <?php echo $fields->value; ?>
                                                        </textarea>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                                <div class="col-md-12">
                                                    <div class="pull-right">
                                                        <button class="btn btn-success " type="submit">
                                                            <?php echo $this->lang->line('clientes_updateBtn'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="documentos">
                                            <div id="myModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload Document</h4>
      </div>
      <form id="DocumentUp" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
      <div class="file_name">
            <input placeholder="<?php echo $this->lang->line('fileTitle'); ?>" type="text" name="nombre" required class="filenombre"/>
        </div>
        <div class="file_up">
            <span class="btn btn-default btn-file">
                Browse <input required class="documentin" type="file" name="document[]" />
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
                                            <div class="">
                                                <table class="documentos table   table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <?php echo $this->lang->line('actions'); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $this->lang->line('clientes_document_date'); ?>
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
                                        <div role="tabpanel" class="tab-pane" id="follow_up">
                                            <div class="modal fade in" id="add_seguimiento" style="z-index:9999999999;" role="dialog" aria-labelledby="myModalLabel">
                                                <form>
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('clientes_addSeguimiento'); ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('clientes_followup_titulo'); ?>
                                                                    </label>
                                                                    <input type="text" class="form-control" required name="titulo" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('clientes_followup_fecha'); ?>
                                                                    </label>
                                                                    <input type="date" class="form-control " required name="fecha" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('clientes_followup_usuario'); ?>
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
                                                                        <?php echo $this->lang->line('clientes_followup_comentario'); ?>
                                                                    </label>
                                                                    <textarea class="form-control" required name="comentarios"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">
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
                                            <div class="modal fade in" id="edit_seguimiento" style="z-index:9999999999;" role="dialog" aria-labelledby="myModalLabel">
                                                <form>
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('clientes_editrecord'); ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('clientes_followup_titulo'); ?>
                                                                    </label>
                                                                    <input type="text" class="form-control" required name="titulo" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('clientes_followup_fecha'); ?>
                                                                    </label>
                                                                    <input type="text" class="form-control datepicker" required name="fecha" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('clientes_followup_usuario'); ?>
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
                                                                        <?php echo $this->lang->line('clientes_followup_comentario'); ?>
                                                                    </label>
                                                                    <textarea class="form-control" required name="comentarios"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">
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
                                            <!-- Modal -->
                                            <form id="add_adicionales">
                                                <div class="col-md-12 form-group">
                                                    <div class="col-md-3">
                                                        <?php echo $this->lang->line('date_fatch'); ?>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control datepicker" name="FechaPresupuesto" value=" <?php echo sizeof($content) == 0 ? '' : date('Y-m-d', strtotime($content[0]->FechaPresupuesto)); ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <div class="col-md-3">
                                                        <?php echo $this->lang->line('country'); ?>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="areaacademica">
                                                            <?php
                                                            foreach ($countries as $c) {
                                                                $selected = sizeof($content) && $content[0]->idestado == $c->id ? 'selected' : '';
                                                                echo '<option value="' . $c->id . '"  ' . $selected . ' >' . $c->valor . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <div class="col-md-3">
                                                        <?php echo $this->lang->line('Priority'); ?>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="priority">
                                                            <option value="<?php echo $this->lang->line('Normal'); ?>">
                                                                <?php echo $this->lang->line('Normal'); ?>
                                                            </option>
                                                            <option value="<?php echo $this->lang->line('High'); ?>">
                                                                <?php echo $this->lang->line('High'); ?>
                                                            </option>
                                                            <option value="<?php echo $this->lang->line('Very_High'); ?>">
                                                                <?php echo $this->lang->line('Very_High'); ?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <div class="col-md-3">
                                                        <?php echo $this->lang->line('adicionales_comentarios'); ?>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control " name="comments">
                                                            <?php echo  isset($Adicionales[0]->comments) ? $Adicionales[0]->comments : ''; ?>
                                                        </textarea>
                                                    </div>
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
                                                                    <?php echo  ($lang=="english")?Date('m/d/Y',strtotime($SeguimientoItem->date)):Date('d/m/Y',strtotime($SeguimientoItem->date)); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $SeguimientoItem->subject; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $SeguimientoItem->comments; ?>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-success seguimiento_edit" data-id="<?php echo $SeguimientoItem->id; ?>"><i class="fa fa-edit "></i></button>
                                                                    <button class="btn btn-danger seguimiento_delete" data-id="<?php echo $SeguimientoItem->id; ?>"><i class="fa fa-trash "></i></button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="col-md-12 mt10">
                                                    <div class="col-md-12">
                                                        <div class="pull-right">
                                                            <button class="btn btn-success adicionales">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="plantillas">
                                            <form id="template-form" action="<?= base_url() ?>Templates/printTemplate" method="post">
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
                                                        Documentos</div>
                                                    <div class="col-md-9">
                                                        <select name="templateId">
                                                            <option value="">Select Documento</option>
                                                            <?php foreach ($document_cat as $doc) { ?>
                                                                <option value="<?= $doc->id ?>"><?= $doc->DocAsociado ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="hidden" name="lead_client_id" value="<?= $leadId ?>" />
                                                        <input type="hidden" name="id_cat" value="<?php echo $id_cat ?>" />
                                                        <input type="hidden" name="cat_type" value="leads" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group" style="display: none;">
                                                    <br>
                                                    <div class="col-md-3">
                                                        Documento</div>
                                                </div>
                                                <div class="col-md-12 form-group" style="display: none;">
                                                    <div id="wysihtml5-toolbar" style="display: none;">
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
                                                        <button type="submit" id="print444" class="btn btn-success">Print</button>
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
            <div class="Medios_linkpopup">
                <div class="close_me_over">
                    &times;
                </div>
                <table class="Medios table  table-striped table-hover table-bordered ">
                </table>
            </div>
            <div class="campaign_linkpopup">
                <div class="close_me_over">
                    &times;
                </div>
                <table class="campaignTable table  table-striped table-hover table-bordered ">
                </table>
            </div>
            <div class="sel_cursos_linkpopup">
                <div class="close_me_over">
                    &times;
                </div>
                <table class="sel_cursos table  table-striped table-hover table-bordered ">
                </table>
            <div class="col-md-12 mtb10">
					<div class="col-md-12">
					<div class="pull-left">
					<button class="btn btn-success selectall">Select All</button>
					</div>
					<div class="pull-right">
					<button class="btn btn-success savecursos">Save</button>
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
    var _mediosTableContents = JSON.parse('<?php echo json_encode($medios); ?>');
    var _campaignTableContents = JSON.parse('<?php echo json_encode($campaign); ?>');
    var _lst_sol_solContents = JSON.parse('<?php echo json_encode($lst_sol_sol); ?>');
    var _sel_cursosTableContents = JSON.parse('<?php echo json_encode($sel_cursos); ?>');
</script>

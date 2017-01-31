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
                <div class="page-content">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="<?php echo $layoutClass ?>">
                        <div class="portlet light">
                            <div class="portlet-body">
                                <div class="col-md-12">
                                    <a href="<?php echo base_url() ?>clientes" class="btn btn-success pull-right">&times;</a>
                                </div>
                                <div class="wizard-container">
                                    <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                        <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                            <?php if (isset($flashMsg) && $flashMsg != "") { ?>
                                                <div class="tab temp" id="flashMsg" style="width: 100%; float: left; background-color: #e5efff;height: 40px; margin: 20px 0 0 0;">
                                                    <div class="col-md-12" style="float: left; padding: 11px 0 0 12px; color: green;">
                                                        <strong><?php echo $flashMsg; ?></strong>
                                                        <a style="float: right; margin-right: 10px; color: #f1353d;" href="javascript:void()" onclick="hideFlashMsg();"><strong>X</strong></a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                                            <div class="wizard-header">
                                                <h3>
                                                    <?php echo $this->lang->line('leads_addSmallTitle'); ?>
                                                </h3>
                                            </div>
                                            <div class="leadsCheckDiv">
                                                <div>
                                                    <input type="radio" value="newAdd" name="leadsCheck" onclick="showRealtedForm('newAdd');" /> Add a blank lead
                                                </div>
                                                <div>
                                                    <input type="radio" value="currentUser" name="leadsCheck" onclick="showRealtedForm('currentUser');"  /> Add a Lead and copy data from existing user
                                                </div>
                                            </div>
                                            <div style="display: block; margin-top: 20px;" class="displayForm" id="currentUser"></div>
                                            <div style="display: none; margin-top: 20px;" class="displayForm" id="newAdd">
                                                <form class="clientes_add_form" action="<?= base_url() ?>LeadsView/addLeadsRecords" method="POST">
                                                    <ul>
                                                        <li><a data-toggle="tab"><?php echo $this->lang->line('leads_datosLeads'); ?></a></li>
                                                    </ul>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_ccodcli'); ?>
                                                                <input type="text" class="form-control" name="NumPresupuestoDis" id="numpresupuesto" disabled value="" />
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_bookmark') ?>
                                                                <select name="bookmark" class="form-control">
                                                                    <option value="0"><?php echo $this->lang->line('no');?></option>
                                                                    <option value="1"><?php echo $this->lang->line('yes');?></option>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_surname') ?>
                                                                <input type="text" class="form-control" name="sApellidos" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_name') ?>
                                                                <input type="text" class="form-control" name="Nombre" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_priority') ?>
                                                                <select name="prioridad" class="form-control">
                                                                    <option value="0"><?php echo $this->lang->line('Normal');?></option>
                                                                    <option value="1"><?php echo $this->lang->line('High'); ?></option>
                                                                    <option value="2"><?php echo $this->lang->line('Very_High'); ?></option>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_country') ?>
                                                                <input type="text" class="form-control" name="pais" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_phone') ?>
                                                                <input type="text" class="form-control" name="Telefono" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_mobile') ?>
                                                                <input type="text" class="form-control" name="Movil" value="" />
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_source') ?>
                                                                <select name="medio" class="form-control">
                                                                    <?php foreach($medios_data as $row){ ?>
                                                                        <option value="<?php echo $row['IdMedio'];?>"><?php echo $row['Descripcion'];?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_state') ?>
                                                                <select name="Estado" class="form-control">
                                                                    <?php foreach($estado_data as $row){ ?>
                                                                        <option value="<?php echo $row['id'];?>"><?php echo $row['valor'];?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 wizard-footer">
                                                        <div class="pull-right">
                                                            <input type="hidden" name="NumPresupuesto" id="NumPresupuestoHidden" value="0" />
                                                            <button class="btn btn-success " type="submit">
                                                                <?php echo $this->lang->line('clientes_addBtn'); ?>
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
            </div>
            <div class="contactos_linkpopup">
                <div class="close_me">
                    <i class="fa fa-cross"></i>
                </div>
                <table class="clientes table  table-striped table-hover table-bordered ">
                </table>
            </div>


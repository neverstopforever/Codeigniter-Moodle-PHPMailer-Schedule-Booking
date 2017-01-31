        <style>
        .dataTables_wrapper {
            width: 100%;
            overflow: auto;
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
                                        <form class="clientes_add_form">
                                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                                            <div class="wizard-header">
                                                <h3>
                                                   <?php echo $this->lang->line('clientes_addSmallTitle'); ?>
                                                </h3>
                                            </div>
                                            <ul>
                                                <li><a href="#datos-comerciales" data-toggle="tab"><?php echo $this->lang->line('clientes_datosComerciales'); ?></a></li>
                                                <li><a href="#fcturation" data-toggle="tab"><?php echo $this->lang->line('clientes_fcturation'); ?></a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane" id="datos-comerciales">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_ccodcli'); ?>
                                                                    <input type="text" class="form-control" name="ccodcli" readonly value="<?php echo $clienteId; ?>" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_FirstUpdate') ?>
                                                                    <input type="text" class="form-control" readonly name="FirstUpdate" value="<?php echo date(" Y/m/d "); ?>"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_LastUpdate') ?>
                                                                    <input type="text" class="form-control" readonly name="LastUpdate" value="<?php echo date(" Y/m/d "); ?>"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cnomcli') ?>
                                                                    <input type="text" class="form-control" name="cnomcli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cnomcom') ?>
                                                                    <input type="text" class="form-control" name="cnomcom" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_Cpobcli') ?>
                                                                    <input type="text" class="form-control" name="Cpobcli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_Cdomicilio') ?>
                                                                    <textarea type="text" class="form-control" name="Cdomicilio" style="min-height:20px;"></textarea>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cprovincia') ?>
                                                                    <input type="text" class="form-control" name="cprovincia" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cnaccli') ?>
                                                                    <input type="text" class="form-control" name="cnaccli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cdnicif') ?>
                                                                    <input type="text" class="form-control" name="cdnicif" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cobscli') ?>
                                                                    <input type="text" class="form-control" name="cobscli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_ctfo1cli') ?>
                                                                    <input type="text" class="form-control" name="ctfo1cli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_Ctfo2cli') ?>
                                                                    <input type="text" class="form-control" name="Ctfo2cli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_SkypeEmpresa') ?>
                                                                    <input type="text" class="form-control" name="SkypeEmpresa" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_movil') ?>
                                                                    <input type="text" class="form-control" name="movil" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cfaxcli') ?>
                                                                    <input type="text" class="form-control" name="cfaxcli" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_email') ?>
                                                                    <input type="email" class="form-control" name="email" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_web') ?>
                                                                    <input type="text" class="form-control" name="web" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_ccontacto') ?>
                                                                    <input type="text" class="form-control" name="ccontacto" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cargo') ?>
                                                                    <input type="text" class="form-control" name="cargo" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cobserva') ?>
                                                                    <textarea type="text" class="form-control" name="cobserva" style="min-height:200px"></textarea>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="fcturation">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_idfp'); ?>
                                                                    <select name="idfp" class="form-control">
                                                                        <?php //  echo  content[0]->idfp;$ ?>
                                                                            <?php foreach($formaspago as $paymontMethod){
                                                                            $selected = '';
                                                                             if($content[0]->idfp == $paymontMethod->Codigo){$selected = 'selected'; }
                                                                         ?>
                                                                                <option value="<?php echo $paymontMethod->Codigo; ?>" <?php echo $selected; ?> >
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
                                                                    <input type="text" class="form-control" name="tarjetanum" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_tarjetacadmes'); ?>
                                                                    <input type="text" class="form-control expirecc" name="tarjetacadmes" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_tarjetacadano'); ?>
                                                                    <input type="text" class="form-control year" name="tarjetacadano" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_irpf'); ?>
                                                                    <input type="text" class="form-control" name="irpf" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_centidad'); ?>
                                                                    <input type="text" class="form-control" name="centidad" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cagencia'); ?>
                                                                    <input type="text" class="form-control" name="cagencia" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_cctrlbco'); ?>
                                                                    <input type="text" class="form-control" name="cctrlbco" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_ccuenta'); ?>
                                                                    <input type="text" class="form-control" name="ccuenta" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_iban'); ?>
                                                                    <input type="text" class="form-control" name="iban" placeholder="XX00 0000 0000 0000 0000 0000" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" class="" name="Firmado_sepa" value="1" />
                                                                <?php echo $this->lang->line('form_Firmado_sepa'); ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_banco'); ?>
                                                                    <input type="text" class="form-control" name="banco" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-footer">
                                                <div class="pull-right">
                                                    <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='<?php echo $this->lang->line('clientes_next') ?>' />
                                                    <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='finish' value='<?php echo $this->lang->line('clientes_finish') ?>' />
                                                </div>
                                                <div class="pull-left">
                                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='<?php echo $this->lang->line('clientes_prev') ?>' />
                                                </div>
                                                <div class="clearfix"></div>
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
            <div class="close_me">
                <i class="fa fa-cross"></i>
            </div>
            <table class="clientes table  table-striped table-hover table-bordered ">
            </table>
        </div>
        </div>
<script>
    var _clienteId = "<?php echo $clienteId ?>";
</script>
<?php if(isset($content[0]) && !empty($content[0])) { ?>


    <div class="row">
    <form class="update_commercial_data_form" method="post">
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
                              style="min-height:100px;"><?php echo $content[0]->Cdomicilio; ?></textarea>
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
                              style="min-height:200px"><?php echo $content[0]->cobserva; ?></textarea>
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
<?php }?>

<?php if(!empty($adicionales)) {?>
    <div class="row margin-top-20">
    <form id="add_adicionales">
        <?php foreach($adicionales as $adicional){ ?>
            <div class="col-md-12 form-group">
                <div class="col-md-3">

                    <?php echo  ucfirst(strtolower(str_replace('_', " ", $adicional->name))); ?>
                </div>
                <div class="col-md-9">
                    <?php if($adicional->type != 'textarea'){ ?>
                        <?php if($adicional->name == 'area_academica' && isset($area_academica) && !empty($area_academica)){?>
                            <select class="form-control" name="area_academica">
                                <?php foreach ($area_academica as $value) { ?>

                                    <option value="<?php echo $value->id; ?>"  <?php echo $value->id == $adicional->value ? 'selected' : ''; ?> ><?php echo $value->valor; ?></option>';
                                <?php }  ?>
                            </select>

                        <?php }else{ ?>

                            <input type="<?php echo $adicional->type; ?>" class="form-control " name="<?php echo $adicional->name; ?>"
                                   value="<?php echo $adicional->value; ?>" >
                        <?php } ?>
                    <?php }else{ ?>
                        <textarea type="text" class="form-control " name="<?php echo $adicional->name; ?>">
                                                           <?php echo $adicional->value; ?>
                                                        </textarea>
                    <?php } ?>

                </div>
            </div>
        <?php } ?>

        <div class="col-md-12">
            <div class="col-md-12">
                <div class="pull-right">
                    <button class="btn btn-success"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
        </div>
    </form>
    </div>
<?php } ?>
<script>
    var _sizeof_adicionales = "<?php echo !empty($adicionales) ? sizeof($adicionales) : 0; ?>";
</script>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/commercial_data.js"></script>

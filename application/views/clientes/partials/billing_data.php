<?php if(isset($content[0]) && !empty($content[0])) { ?>
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
<?php } ?>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/billing_data.js"></script>

<?php if(isset($content[0]) && !empty($content[0])) { ?>
    <form class="fcturation_form col-md-5">
        <input type="hidden" name="cnomcli" id="cnomcli" value="<?php echo $content[0]->cnomcli; ?>">
        <input type="hidden" name="cnomcli_old" id="cnomcli_old" value="<?php echo $content[0]->cnomcli; ?>">
        <input type="hidden" name="email" id="email" value="<?php echo $content[0]->email; ?>">
        <input type="hidden" name="email_old" id="email_old" value="<?php echo $content[0]->email; ?>">
        <div class="col-md-12 margin-top-10">
            <div class="form-group circle_select_div">
                <label>
                    <?php echo $this->lang->line('form_idfp'); ?>
                    <select name="idfp" class="form-control form_control_auto_with">
                        <?php //  echo  content[0]->idfp;$  ?>
                        <?php
                        foreach ($formaspago as $paymontMethod) {
                            $selected = '';
                            if ($content[0]->idfp == $paymontMethod['Codigo']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option
                                value="<?php echo $paymontMethod['Codigo']; ?>" <?php echo $selected; ?> >
                                <?php echo $paymontMethod['Descripcion']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_tarjetanum'); ?>
                    <input type="text" class="form-control credit-card" placeholder="XXXX-XXXX-XXXX-XXXX" maxlength="19" name="tarjetanum"
                           value="<?php echo $content[0]->tarjetanum; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_tarjetacadmes'); ?>
                    <input type="text" class="form-control expirecc"
                           name="tarjetacadmes"
                           value="<?php echo $content[0]->tarjetacadmes; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_tarjetacadano'); ?>
                    <input type="text" class="form-control year" name="tarjetacadano"
                           value="<?php echo $content[0]->tarjetacadano; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_irpf'); ?>
                    <input type="text" class="form-control" name="irpf"
                           value="<?php echo $content[0]->irpf; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_centidad'); ?>
                    <input type="text" class="form-control" name="centidad"
                           value="<?php echo $content[0]->centidad; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cagencia'); ?>
                    <input type="text" class="form-control" name="cagencia"
                           value="<?php echo $content[0]->cagencia; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cctrlbco'); ?>
                    <input type="text" class="form-control" name="cctrlbco"
                           value="<?php echo $content[0]->cctrlbco; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
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

                    <div class="md-checkbox">

                        <input type="checkbox" id="billing_data_mondanto" class="md-check" name="Firmado_sepa" value="1" <?php
                        if ($content[0]->Firmado_sepa) {
                            echo 'checked';
                        }
                        ?> />

                        <label for="billing_data_mondanto">

                            <span></span>

                            <span class="check"></span>

                            <span class="box"></span>
                        </label>
                        <span class="billing_data_mondanto_text" >
                            <?php echo $this->lang->line('form_Firmado_sepa'); ?>
                        </span>
                    </div>
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
            <div class="back_save_group">
                <button class="btn btn-sm btn-primary btn-circle" type="submit">
                    <?php echo $this->lang->line('companies_updateBtn'); ?>
                </button>
                <a href="<?php echo base_url('companies'); ?>" class="btn-sm btn btn-circle btn-default-back back_teachers " ><?php echo $this->lang->line('back'); ?></a>
            </div>
        </div>
    </form>
<?php } ?>
<script src="<?php echo base_url(); ?>app/js/companies/partials/billing_data.js"></script>

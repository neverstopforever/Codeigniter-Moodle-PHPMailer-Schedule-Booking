<div class="row margin-top-20 step_content base_info_step">
    <div class=" col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 ">
        <form class="companies_add_form">
    
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_ccodcli'); ?>
            </label>
                <input type="text" class="form-control" name="ccodcli" readonly value="<?php echo $clienteId; ?>" />

        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_FirstUpdate') ?>
            </label>
                <input type="text" class="form-control" readonly name="FirstUpdate" value="<?php echo date($datepicker_format); ?>"/>

        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_LastUpdate') ?>
            </label>
                <input type="text" class="form-control" readonly name="LastUpdate" value="<?php echo date($datepicker_format); ?>"/>

        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cnomcli') ?>
            </label>
                <input type="text" class="form-control" name="cnomcli" id="cnomcli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cnomcom') ?>
            </label>
                <input type="text" class="form-control" name="cnomcom"  id="cnomcom" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_Cpobcli') ?>
            </label>
                <input type="text" class="form-control" name="Cpobcli" id="Cpobcli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_Cdomicilio') ?>
            </label>
                <textarea type="text" class="form-control" name="Cdomicilio"  id="Cdomicilio" style="min-height:20px;"></textarea>
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cprovincia') ?>
            </label>
                <input type="text" class="form-control" name="cprovincia" id="cprovincia" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cnaccli') ?>
            </label>
                <input type="text" class="form-control" name="cnaccli"  id="cnaccli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cdnicif') ?>
            </label>
                <input type="text" class="form-control" name="cdnicif" id="cdnicif" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cobscli') ?>
            </label>
                <input type="text" class="form-control" name="cobscli" id="cobscli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_ctfo1cli') ?>
            </label>
                <input type="text" class="form-control" name="ctfo1cli" id="ctfo1cli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_Ctfo2cli') ?>
            </label>
                <input type="text" class="form-control" name="Ctfo2cli" id="Ctfo2cli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_SkypeEmpresa') ?>
            </label>
                <input type="text" class="form-control" name="SkypeEmpresa" id="SkypeEmpresa" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_movil') ?>
            </label>
                <input type="text" class="form-control" name="movil" id="movil" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cfaxcli') ?>
            </label>
                <input type="text" class="form-control" name="cfaxcli" id="cfaxcli" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_email') ?>
            </label>
                <input type="text" class="form-control" name="email" id="email" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_web') ?>
            </label>
                <input type="text" class="form-control" name="web" id="web" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_ccontacto') ?>
            </label>
                <input type="text" class="form-control" name="ccontacto" id="ccontacto" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cargo') ?>
            </label>
                <input type="text" class="form-control" name="cargo" id="cargo" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_cobserva') ?>
            </label>
                <textarea type="text" class="form-control" name="cobserva" id="cobserva" style="min-height:200px"></textarea>
        </div>

   
            </form>

        <div class="col-md-12 text-left back_save_group">
            <button type="button" class="btn btn-circle btn-default-back exit_steps exit_steps_xs_hide"><?php echo $this->lang->line('exit'); ?></button>
            <button type="button" class="btn btn-primary btn-circle  continue_step" data-next_step="2"><?php echo $this->lang->line('companies_next'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-circle btn-default-back exit_steps exit_steps_xs_show"><?php echo $this->lang->line('exit'); ?></button>

        </div>
    </div>
</div>
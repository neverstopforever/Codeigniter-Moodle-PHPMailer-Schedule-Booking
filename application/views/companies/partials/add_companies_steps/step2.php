<div class="row margin-top-20 step_content base_info_step base_info_step2">
    <div class=" col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 ">
        <form class="companies_add_form">


        <div class="form-group circle_select_div">
            <label>
                <?php echo $this->lang->line('form_idfp'); ?>
                <select name="idfp" id="idfp" class="form-control">
                    <?php //  echo  content[0]->idfp;$ ?>
                    <?php foreach($formaspago as $paymontMethod){
                        $selected = '';
//                                                                             if($content[0]->idfp == $paymontMethod->Codigo){$selected = 'selected'; }
                        ?>
                        <option value="<?php echo $paymontMethod['Codigo']; ?>" <?php echo $selected; ?> >
                            <?php echo $paymontMethod['Descripcion']; ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_tarjetanum'); ?>
            </label>
                <input type="text" class="form-control" name="tarjetanum" id="tarjetanum" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_tarjetacadmes'); ?>
            </label>
                <input type="text" class="form-control expirecc" name="tarjetacadmes"  id="tarjetacadmes" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_tarjetacadano'); ?>
            </label>
                <input type="text" class="form-control year" name="tarjetacadano" id="tarjetacadano" />
        </div>

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_irpf'); ?>
            </label>
                <input type="text" class="form-control" name="irpf"  id="irpf" />
        </div>

    <div class="clearfix"></div>
    <div  class="col-md-12">
        <label>
            <?php echo $this->lang->line('leads_account_number') ?>
        </label>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <div class="form-group">
<!--                    <label>-->

                        <input type="text" class="form-control" name="centidad" id="centidad" />
<!--                    </label>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
<!--                    <label>-->

                        <input type="text" class="form-control" name="cagencia" id="cagencia" />
<!--                    </label>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
<!--                    <label>-->

                        <input type="text" class="form-control" name="cctrlbco"  id="cctrlbco" />
<!--                    </label>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>

                        <input type="text" class="form-control" name="ccuenta" id="ccuenta" />
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_iban'); ?>
                <input type="text" class="form-control" name="iban" id="iban" placeholder="XX00 0000 0000 0000 0000 0000" />
            </label>
        </div>

        <div class="form-group">



            <div class="md-checkbox">

                <input type="checkbox" class="" id="billing_data_mondanto" name="Firmado_sepa" value="1" />

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

        <div class="form-group">
            <label>
                <?php echo $this->lang->line('form_banco'); ?>
            </label>
                <input type="text" class="form-control" id="banco" name="banco" />

        </div>
    </div>

            </form>
        <div class="row exit_steps_xs_hide">
            <div class="col-xs-12 col-sm-4 back_save_group exit_back_step">
                <button type="button" class=" btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
            </div>
            <div class="col-xs-12 col-sm-4 back_save_group exit_back_step">
                <button type="button" class=" btn btn-circle btn-default-back back_step" data-prev_step="1"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
            </div>
            <div class="col-xs-12 col-sm-4 back_save_group">
                <button type="button" class="btn  btn-primary btn-circle  finish_steps" id="finish_steps"><?php echo $this->lang->line('companies_finish'); ?></button>
            </div>
        </div>
        <div class="row exit_steps_xs_show">
           
            <div class="col-xs-12 col-sm-4 back_save_group">
                <button type="button" class="btn  btn-primary btn-circle  finish_steps" id="finish_steps"><?php echo $this->lang->line('companies_finish'); ?></button>
            </div>
            <div class="col-xs-12 col-sm-4 back_save_group exit_back_step">
                <button type="button" class=" btn btn-circle btn-default-back back_step" data-prev_step="1"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back'); ?></button>
            </div>
            <div class="col-xs-12 col-sm-4 back_save_group exit_back_step">
                <button type="button" class=" btn btn-circle btn-default-back exit_steps"><?php echo $this->lang->line('exit'); ?></button>
            </div>
        </div>
        </div>
    </div>
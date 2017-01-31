<?php if(isset($content[0]) && !empty($content[0])) { ?>
<div class="row">


<form class="update_datos_comerciales_form col-md-5" id="update_datos_comerciales_form">
    <div class="col-md-12 margin-top-10">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('leads_id'); ?>
                <input type="text" class="form-control" name="numpresupuesto" disabled value="<?php echo $content[0]->NumPresupuesto; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('first_name') ?>
                <input type="text" class="form-control" readonly name="sNombre" value="<?php echo $content[0]->sNombre; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('sur_name') ?>
                <input type="text" class="form-control" readonly name="sApellidos" value="<?php echo $content[0]->sApellidos; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('full_name') ?>
                <input type="text" class="form-control" name="" value="<?php echo $content[0]->sNombre . ' ' . $content[0]->sApellidos; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('city') ?>
                <input type="text" class="form-control" name="Poblacion" value="<?php echo ($content[0]->Poblacion && $content[0]->Poblacion !='NULL' )? $content[0]->Poblacion : ''; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
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
                <?php echo $this->lang->line('address') ?>
                <textarea type="text" class="form-control margin-top-10" name="domicilio" style="min-height:100px;">
                    <?php echo $content[0]->domicilio; ?>
                </textarea>
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('birthday') ?>
                <input type="text" class="form-control birthday_datepicker" name="Nacimiento"  value="<?php if($content[0]->Nacimiento) { echo ($lang == "english") ? date('Y-m-d', strtotime($content[0]->Nacimiento)) : date('d-m-Y', strtotime($content[0]->Nacimiento)); } ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('country') ?>
                <input type="text" class="form-control" name="pais" value="<?php echo $content[0]->pais; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group circle_select_div ">
            <label>
                <?php echo $this->lang->line('sex') ?>
                <select name="idsexo"  class="form-control form_control_auto_with sex_dropdown" >
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
    <div class="col-md-12 margin-bottom-10">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('phone1') ?>
            </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Telefono" value="<?php echo ($content[0]->Telefono && $content[0]->Telefono !=="NULL") ? $content[0]->Telefono : ''; ?>" />
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Telefono2" value="<?php echo $content[0]->Telefono2; ?>" />
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('mobile') ?>
                <input type="text" class="form-control" name="Movil" value="<?php echo $content[0]->Movil; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('passport') ?>
                <input type="text" class="form-control" name="CDNICIF" value="<?php echo $content[0]->CDNICIF; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('email1') ?>
                <input type="text" class="form-control" name="email" value="<?php echo $content[0]->email; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
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
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('IBAN') ?>
                <input type="text" class="form-control" name="iban" value="<?php echo $content[0]->iban; ?>" />
            </label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>
                <?php echo $this->lang->line('bank') ?>
                <input type="text" class="form-control" name="cc1" value="<?php echo $content[0]->cc1; ?>" />
            </label>
        </div>
    </div>

    <div class="clearfix"></div>
    <div>
            <div  class="col-md-12">
                <label>
                    <?php echo $this->lang->line('leads_account_number') ?>
                </label>
            </div>
        <div  class="col-md-2">
            <div class="form-group">
                <label>
                    <input type="text" maxlength="2" class="form-control"  name="cc2" value="<?php echo $content[0]->cc2; ?>" />
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>
                    <input type="text"  maxlength="2" class="form-control"  name="cc3" value="<?php echo $content[0]->cc3; ?>" />
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>
                    <input type="text" maxlength="6" class="form-control"  name="cc4" value="<?php echo $content[0]->cc4; ?>" />
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-12 company_select">
         <input type="hidden" class="form-control" id="facturara" name="facturara" value="<?php echo $content[0]->facturara; ?>" />
         <h4><?php echo $this->lang->line('comp_id') ?></h4>
        <div class="form-group margin-top-0" id="companies-multiple-datasets">
            <input class="typeahead form-control" type="text" placeholder="<?php echo $this->lang->line('leads_select_company'); ?>" value="<?php echo isset($content[0]->CnomCli) ? $content[0]->CnomCli:""; ?>">
            <i class="fa fa-remove unassign_company_icon" title="Unassign" style="display: none"></i>
        </div>
    </div>
<!--    <div class="col-md-12 margin-top-20">-->
<!--        <div class="back_save_group">-->
<!--            <button class="btn btn-sm btn-primary btn-circle" type="submit">-->
<!--                --><?php //echo $this->lang->line('clientes_updateBtn'); ?>
<!--            </button>-->
<!--            <a href="--><?php //echo base_url('prospects'); ?><!--" class="btn-sm btn btn-circle btn-default-back back_teachers " >--><?php //echo $this->lang->line('back'); ?><!--</a>-->
<!--        </div>-->
<!--    </div>-->
<div>
</form>
    <div class="clearfix"></div>
    <form class="custom_fields_form " id="custom_fields_form">
        <h4 class="personalized text-center"><?php echo $this->lang->line('custom_fields'); ?></h4>
        <?php
        if(isset($content[0]->custom_fields)){
            $custom = $content[0]->custom_fields;
        }else{
            $custom = array();
        }
        ?>
        <?php if(!empty($customfields_fields)) { ?>

            <?php foreach($customfields_fields as $customfields){  ?>
                <?php $disabled = '';
                $show = 1;
                if($customfields['disabled'] == '1'){
                    $disabled = ' disabled ';
                }
                if($isOwner == 0 && $customfields['only_admin'] == 1 ){
                    $show = 0;
                }
                ?>
                <div class="form-group text-left circle_select_div">
                    <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1 && $show){ ?>

                        <lable><?php echo $customfields['field_name']; ?>:</lable>
                        <textarea <?php echo $disabled; ?>  type="text" class="form-control " name="<?php echo $customfields['id']; ?>" <?php if($customfields['required']== 1){echo 'required';}?>><?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?></textarea>
                    <?php } elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                        <input type="text" <?php if($customfields['required']== 1){echo 'required';} echo $disabled; ?>  class="form-control" name="<?php echo $customfields['id']; ?>" value="<?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?>">
                    <?php }

                    elseif($customfields['field_type'] =='select' && $customfields['active']== 1 && $show){ ?>
                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                        <select <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?> class="form-control" name="<?php echo $customfields['id']; ?>">
                            <option value=""> <?php echo $this->lang->line('events_select_option');?> </option>
                            <?php
                            $options = explode(',',$customfields['options']);
                            foreach ($options as $value) {?>
                                <option value="<?php echo $value;?>" <?php if(!empty($custom->$customfields['id']) && $custom->$customfields['id'] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    <?php }
                    elseif($customfields['field_type'] == 'datepicker' && $customfields['active']== 1 && $show){
                        $date='';
                        $datePost='';
                        if(isset($custom->$customfields['id']) && !empty($custom->$customfields['id'])){
                            if($lang == 'spanish'){
                                $date = date("d-m-Y", strtotime($custom->$customfields['id']));
                            }elseif ($lang = 'english'){
                                $date = date("Y-m-d", strtotime($custom->$customfields['id']));
                            }
                            $datePost = date("Y-m-d", strtotime($custom->$customfields['id']));
                        }
                        ?>

                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                        <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control datepicker_field" fild_id="<?php echo $customfields['id']; ?>" value="<?php echo $date; ?>">
                        <input type="hidden" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="hidden_date" fild_id="<?php echo $customfields['id']; ?>" id="hidden_date<?php echo $customfields['id']; ?>" name="<?php echo $customfields['id']; ?>" value="<?php echo $datePost; ?>">
                    <?php }
                    elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                        <div class="form-group">
                            <div class="md-checkbox">
                                <input type="checkbox" <?php echo $disabled; ?> id="custom_fields[<?php echo $customfields['id']; ?>]" name="<?php echo $customfields['id']; ?>" <?php if(!empty($custom->$customfields['id'])){ echo "checked"; }else{ }?> value="yes">
                                <label for="custom_fields[<?php echo $customfields['id']; ?>]">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    <?php echo  $customfields['field_name'];  ?>
                                </label>
                            </div>
                        </div>
                    <?php }
                    else{

                    }?>
                </div>
                <?php
            }
        }?>
        </form>
    </div>


<?php }?>

<div class="clearfix"></div>
<?php if(!empty($personal_fields)){?>
<div class="margin-top-20">
<form method="post" action="" id="personalized_fields_form" class="col-md-5">
    <input type="hidden" value="<?php echo isset($content[0]->NumPresupuesto) ? $content[0]->NumPresupuesto : null; ?>" name="id">
    <div class="col-md-12">
        <div class=" text-left">
            <br/>
        </div>
    </div>
    <?php if(!empty($personal_fields)) {?>
        <?php foreach($personal_fields as $fields){ ?>

            <div class="form-group ">

                <div class="col-md-12">
                    <label>
                    <?php echo  ucfirst(strtolower(str_replace('_', " ", $fields->name))); ?>

                    <?php if($fields->type != 'textarea'){ ?>

                        <input type="<?php echo $fields->type; ?>" class="form-control " name="<?php echo $fields->name; ?>"
                               value="<?php echo $fields->value; ?>" >
                    <?php }else{ ?>
                        <textarea type="text" class="form-control " name="<?php echo $fields->name; ?>">
                            <?php echo $fields->value; ?>
                        </textarea>
                    <?php } ?>
                    </label>

                </div>
            </div>
        <?php } ?>
    <?php } ?>


<!--    <div class="col-md-12">-->
<!--        <div class="back_save_group">-->
<!--            <button class="btn btn-sm btn-primary btn-circle" type="submit">-->
<!--                --><?php //echo $this->lang->line('clientes_updateBtn'); ?>
<!--            </button>-->
<!--            <a href="--><?php //echo base_url('prospects'); ?><!--" class="btn-sm btn btn-circle btn-default-back back_teachers " >--><?php //echo $this->lang->line('back'); ?><!--</a>-->
<!---->
<!--        </div>-->
<!--    </div>-->
</form>
    <div class="col-md-12 margin-top-20">
        <div class="back_save_group">
            <a href="<?php echo base_url('prospects'); ?>" class="btn-sm btn btn-circle btn-default-back back_teachers " ><?php echo $this->lang->line('back'); ?></a>
            <button id="update_personal_data" class="btn btn-sm btn-primary btn-circle" type="button">
                <?php echo $this->lang->line('clientes_updateBtn'); ?>
            </button>
            <button class="btn btn-primary btn-circle enroll_prospect"><?php echo $this->lang->line('enroll'); ?></button>
            <button class="btn btn-primary view_template btn-circle"><?php echo $this->lang->line('leads_print'); ?></button>

        </div>
    </div>
</div>
<?php }?>
<?php if($lang=='spanish'){ ?>
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
<?php } ?>

<script>
    var _companies = <?php echo isset($companies) ? json_encode($companies) : json_encode(array()); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/leads/partials/personal_data.js"></script>

<?php if(isset($content[0]) && !empty($content[0])) { ?>


    <div class="row">
    <form class="update_commercial_data_form col-md-5 margin-top-20" method="post">
<!--        <div class="col-md-12 margin-top-10">-->
<!--            <div class="form-group">-->
<!--                <label>-->
<!--                    --><?php //echo $this->lang->line('form_ccodcli'); ?>
<!--                    <input type="text" class="form-control" name="ccodcli" id="ccodcli" disabled-->
<!--                           value="--><?php //echo $content[0]->ccodcli; ?><!--"/>-->
<!--                </label>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_FirstUpdate') ?>
                    <input type="text" class="form-control" readonly name="FirstUpdate" id="FirstUpdate"
                           value="<?php echo ($lang == "english") ? Date(
                               'm/d/Y',
                               strtotime($content[0]->FirstUpdate)
                           ) : Date('d/m/Y', strtotime($content[0]->FirstUpdate)); ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
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
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cnomcli') ?>
                    <input type="text" class="form-control" name="cnomcli" id="cnomcli"
                           value="<?php echo $content[0]->cnomcli; ?>"/>
                    <input type="hidden" name="cnomcli_old" id="cnomcli_old" value="<?php echo $content[0]->cnomcli; ?>">
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cnomcom') ?>
                    <input type="text" class="form-control" name="cnomcom" id="cnomcom"
                           value="<?php echo $content[0]->cnomcom; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_Cpobcli') ?>
                    <input type="text" class="form-control" name="Cpobcli" id="Cpobcli"
                           value="<?php echo $content[0]->Cpobcli; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group comments_commercial">
                <label>
                    <?php echo $this->lang->line('form_Cdomicilio') ?>
                    <textarea type="text" class="form-control" name="Cdomicilio" id="Cdomicilio" style="min-height:100px;"><?php echo $content[0]->Cdomicilio; ?></textarea>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cprovincia') ?>
                    <input type="text" class="form-control" name="cprovincia" id="cprovincia"
                           value="<?php echo $content[0]->cprovincia; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cnaccli') ?>
                    <input type="text" class="form-control" name="cnaccli" id="cnaccli"
                           value="<?php echo $content[0]->cnaccli; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cdnicif') ?>
                    <input type="text" class="form-control" name="cdnicif" id="cdnicif"
                           value="<?php echo $content[0]->cdnicif; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cobscli') ?>
                    <input type="text" class="form-control" name="cobscli" id="cobscli"
                           value="<?php echo $content[0]->cobscli; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_ctfo1cli') ?>
                    <input type="text" class="form-control" name="ctfo1cli" id="ctfo1cli"
                           value="<?php echo $content[0]->ctfo1cli; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_Ctfo2cli') ?>
                    <input type="text" class="form-control" name="Ctfo2cli" id="Ctfo2cli"
                           value="<?php echo $content[0]->Ctfo2cli; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_SkypeEmpresa') ?>
                    <input type="text" class="form-control" name="SkypeEmpresa" id="SkypeEmpresa"
                           value="<?php echo $content[0]->SkypeEmpresa; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_movil') ?>
                    <input type="text" class="form-control" name="movil" id="movil"
                           value="<?php echo $content[0]->movil; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cfaxcli') ?>
                    <input type="text" class="form-control" name="cfaxcli" id="cfaxcli"
                           value="<?php echo $content[0]->cfaxcli; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_email') ?>
                    <input type="text" class="form-control" name="email" id="email"
                           value="<?php echo $content[0]->email; ?>"/>
                    <input type="hidden" name="email_old" id="email_old" value="<?php echo $content[0]->email; ?>">
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_web') ?>
                    <input type="text" class="form-control" name="web" id="web"
                           value="<?php echo $content[0]->web; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_ccontacto') ?>
                    <input type="text" class="form-control" name="ccontacto" id="ccontacto"
                           value="<?php echo $content[0]->ccontacto; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php echo $this->lang->line('form_cargo') ?>
                    <input type="text" class="form-control" name="cargo" id="cargo"
                           value="<?php echo $content[0]->cargo; ?>"/>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group comments_commercial">
                <label>
                    <?php echo $this->lang->line('form_cobserva') ?>
                    <textarea type="text" class="form-control" name="cobserva" id="cobserva" style="min-height:100px"><?php echo $content[0]->cobserva; ?></textarea>
                </label>
            </div>
        </div>
        <div class="col-md-12">
          <h4 class="personalized"><?php echo $this->lang->line('custom_fields'); ?></h4>
<!--        <h4 class="personalized">--><?php //echo $this->lang->line('personalized_fields'); ?><!--</h4>-->
                                                 <?php  
                                                 if(isset($content[0]->custom_fields)){
                                                 $custom = $content[0]->custom_fields;
                                                    }else{
                                                    $custom = array();
                                                    } 
                                                     if(!empty($customfields_fields)) { ?>

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
                                        <textarea <?php echo $disabled; ?>  type="text" class="form-control " name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if($customfields['required']== 1){echo 'required';}?>><?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?></textarea>
                                    <?php } elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <input type="text" <?php if($customfields['required']== 1){echo 'required';} echo $disabled; ?>  class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?>">
                                    <?php } 
                                   
                                    elseif($customfields['field_type'] =='select' && $customfields['active']== 1 && $show){ ?>
                                     <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <select <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?> class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]">
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
                                        <input type="hidden" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="hidden_date" fild_id="<?php echo $customfields['id']; ?>" id="hidden_date<?php echo $customfields['id']; ?>" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php echo $datePost; ?>">
                                    <?php } 
                                     elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                        <div class="form-group">
                                            <div class="md-checkbox">
                                        <input type="checkbox" <?php echo $disabled; ?> id="custom_fields[<?php echo $customfields['id']; ?>]" name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if(!empty($custom->$customfields['id'])){ echo "checked"; }else{ }?> value="yes">
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
        </div>
<!--        <div class="col-md-12">-->
<!--            <div class="pull-right">-->
<!--                <button class="btn btn-success " type="submit">-->
<!--                    --><?php //echo $this->lang->line('companies_updateBtn'); ?>
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
    </form>
    </div>
<?php }?>

<?php if(!empty($adicionales)) {?>
    <div class="row margin-top-20">
    <form id="add_adicionales" class="col-md-5">
        <div class="col-md-12">
            <div class=" text-left">

            </div>
        </div>
        <?php foreach($adicionales as $adicional){ ?>

            <div class="col-md-12">
                <div class="form-group comments_commercial">
                    <label>
                        <?php echo  ucfirst(strtolower(str_replace('_', " ", $adicional->name))); ?>

                            <?php if($adicional->type != 'textarea'){ ?>
                            <?php if($adicional->name == 'area_academica' && isset($area_academica) && !empty($area_academica)){?>
                                <select class="form-control" name="area_academica" id="area_academica"><?php foreach ($area_academica as $value) { ?>
                                        <option value="<?php echo $value->id; ?>"  <?php echo $value->id == $adicional->value ? 'selected' : ''; ?> >
                                            <?php echo $value->valor; ?></option>';<?php }  ?>
                                </select>

                            <?php }else{ ?>

                                <input type="<?php echo $adicional->type; ?>" class="form-control " name="<?php echo $adicional->name; ?>"
                                       value="<?php echo $adicional->value; ?>" >
                            <?php } ?>
                        <?php }else{ ?>
                            <textarea type="text" class="form-control " name="<?php echo $adicional->name; ?>"><?php echo $adicional->value; ?></textarea>
                        <?php } ?>
                    </label>
                </div>
            </div>
        <?php } ?>
      

<!--        <div class="col-md-12">-->
<!--            <div class="col-md-12">-->
<!--                <div class="pull-right">-->
<!--                    <button class="btn btn-success">--><?php //echo $this->lang->line('save'); ?><!--</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </form>
        <div class="col-md-12 margin-top-20">
            <div class="back_save_group col-md-12">
                <a href="<?php echo base_url('companies'); ?>" class="btn-sm btn btn-circle btn-default-back back_teachers xs_hide" ><?php echo $this->lang->line('back'); ?></a>

                <button id="update_commercial_data" class="btn btn-sm btn-primary btn-circle" type="button">
                    <?php echo $this->lang->line('clientes_updateBtn'); ?>
                </button>
                <a href="<?php echo base_url('companies'); ?>" class="btn-sm btn btn-circle btn-default-back back_teachers xs_show" ><?php echo $this->lang->line('back'); ?></a>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    var _sizeof_adicionales = "<?php echo !empty($adicionales) ? sizeof($adicionales) : 0; ?>";
</script>
<script src="<?php echo base_url(); ?>app/js/companies/partials/commercial_data.js"></script>

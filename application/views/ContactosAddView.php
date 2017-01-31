        <div class="page-container">


                 <div class="table_loading"></div>
                <div class="page-content">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo 'CRM' ?></a>
                            </li>
                            <li>
                                <a href="javascript:;"><?php echo $this->lang->line('menu_applicants'); ?></a>
                            </li>
                            <li >
                                <a href="<?php echo $_base_url; ?>contactos" ><?php echo $this->lang->line('menu_contactos'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('edit'); ?>
                            </li>
                        </ul>
                        <div class="portlet light">
                            <div class="portlet-body">
                             <div class="col-md-12">

                                </div>
                                <div class="wizard-container">
                                    <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                        <form class="clientes_add_form" method="post" >
                                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                                            <div class="wizard-header">
                                                <h3>
                                                <?php echo $this->lang->line('contactos_addTitle'); ?>
                                                </h3>
                                            </div>
                                            <ul>
                                                <li><a href="#datos-comerciales" data-toggle="tab"><?php echo $this->lang->line('clientes_datosComerciales'); ?></a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane col-md-5" id="datos-comerciales">
<!--                                                    <div class="col-md-12">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label>-->
<!--                                                                --><?php //echo $this->lang->line('Id'); ?>
<!--                                                                <input type="text" class="form-control" name="Id" readonly value="--><?php //echo $clienteId; ?><!--" />-->
<!--                                                            </label>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Snombre'); ?>
                                                                <input type="text" class="form-control" name="Snombre" />
                                                                <?php echo form_error('Snombre'); ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Sapellidos'); ?>
                                                                <input type="text" class="form-control" name="Sapellidos" />
                                                                <?php echo form_error('Sapellidos'); ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Domicilio'); ?>
                                                                <input type="text" class="form-control" name="Domicilio" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Poblacion'); ?>
                                                                <input type="text" class="form-control" name="Poblacion" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Provincia'); ?>
                                                                <input type="text" class="form-control" name="Provincia" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Distrito'); ?>
                                                                <input type="text" class="form-control" name="Distrito" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Telefono1'); ?>
                                                                <input type="text" class="form-control" name="Telefono1" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Telefono2'); ?>
                                                                <input type="text" class="form-control" name="Telefono2" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Movil'); ?>
                                                                <input type="text" class="form-control" name="Movil" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Pais'); ?>
                                                                <input type="text" class="form-control" name="Pais" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('email'); ?>
                                                                <input type="email" class="form-control" name="email" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('nif'); ?>
                                                                <input type="text" class="form-control" name="nif" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('fnacimiento'); ?>
                                                                <input type="text" class="form-control add_contactos_datepicker" name="fnacimiento" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('skype'); ?>
                                                                <input type="text" class="form-control" name="skype" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group circle_select_div">
                                                            <label>
                                                                <?php echo $this->lang->line('Idsexo'); ?>
                                                                <select name="Idsexo" class="form-control sex_dropdown">
                                                                    <option value="male"><?php echo $this->lang->line('contactos_male'); ?></option>
                                                                    <option value="frmale"><?php echo $this->lang->line('contactos_female'); ?></option>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('iban'); ?>
                                                                <input type="text" class="form-control" name="iban" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Cc1'); ?>
                                                                <input type="text" class="form-control" name="Cc1" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Cc2'); ?>
                                                                <input type="text" class="form-control" name="Cc2" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Cc3'); ?>
                                                                <input type="text" class="form-control" name="Cc3" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('Cc4'); ?>
                                                                <input type="text" class="form-control" name="Cc4" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 ">
                                                        <div class="form-group">
                                                            <div id="the-basics">
                                                                <label>
                                                                    <?php echo $this->lang->line('company'); ?>
                                                                    <input  type="text" class="form-control typeahead " placeholder="<?php echo $this->lang->line('choose_company'); ?>" value="" name="company_id"  />
                                                                    <i class="fa fa-remove unassign_company_icon" title="Unassign" style="display: none"></i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('seguimiento'); ?>
                                                                <input type="text" class="form-control" name="seguimiento" />
                                                            </label>
                                                        </div>
                                                    </div>
                                          <h4 class="personalized"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                                 <?php
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

                                                         <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1 && $show){ ?>
                                                             <div class="form-group text-left">
                                                                 <lable class="text-capitalize"><?php echo $customfields['field_name']; ?>:</lable>
                                                                 <textarea <?php echo $disabled; ?>  type="text" class="form-control " name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if($customfields['required']== 1){echo 'required';}?>> </textarea>
                                                                 <?php echo form_error("custom_fields[". $customfields['id']."]"); ?>
                                                             </div>
                                                         <?php } elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                                             <div class="form-group text-left">
                                                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]" value="">
                                                                 <?php echo form_error("custom_fields[". $customfields['id']."]"); ?>
                                                             </div>
                                                         <?php }

                                                         elseif($customfields['field_type'] =='select' && $customfields['active']== 1 && $show){ ?>
                                                             <div class="form-group text-left circle_select_div">
                                                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <select <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?> class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]">
                                                                     <option value=""> <?php echo $this->lang->line('events_select_option');?> </option>
                                                                     <?php
                                                                     $options = explode(',',$customfields['options']);
                                                                     foreach ($options as $value) {?>
                                                                         <option value="<?php echo $value;?>" ><?php echo $value;?></option>
                                                                     <?php }?>
                                                                 </select>
                                                                 <?php echo form_error("custom_fields[". $customfields['id']."]"); ?>
                                                             </div>
                                                         <?php }
                                                         elseif($customfields['field_type'] == 'datepicker' && $customfields['active']== 1 && $show){?>
                                                             <div class="form-group text-left circle_select_div" >
                                                                 <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                 <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control datepicker_field" fild_id="<?php echo $customfields['id']; ?>" value="">
                                                                 <input type="hidden" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="hidden_date" fild_id="<?php echo $customfields['id']; ?>" id="hidden_date<?php echo $customfields['id']; ?>" name="custom_fields[<?php echo $customfields['id']; ?>]" value="">
                                                                 <?php echo form_error("custom_fields[". $customfields['id']."]"); ?>
                                                             </div>
                                                         <?php }
                                                         elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                                             <div class="form-group">
                                                                 <div class="md-checkbox">
                                                                     <input type="checkbox" <?php echo $disabled; ?> id="custom_fields[<?php echo $customfields['id']; ?>]" name="custom_fields[<?php echo $customfields['id']; ?>]" value="yes">
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
                                                         <?php
                                                     }
                                                 }?>


                                                </div>
                                            </div>
                                            <div class="wizard-footer wizard-footer_contact_add back_save_group">

                                                <div class="pull-left margin-right-10">
<!--                                                    <button type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next'>-->
<!--                                                        --><?php //echo $this->lang->line('clientes_next') ?>
<!--                                                    </button>-->
                                                    <button type='submit' class='btn-finish btn-wd btn-finish btn btn-sm btn-primary btn-circle' name='finish'>
                                                        <?php echo $this->lang->line('clientes_finish') ?>
                                                    </button>
                                                </div>
                                                <a href="<?php echo base_url() ?>contactos" class="btn-sm btn btn-circle btn-default-back"><?php echo $this->lang->line('back'); ?></a>
<!--                                                <div class="pull-left">-->
<!--                                                    <button type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous'>-->
<!--                                                        --><?php //echo $this->lang->line('clientes_prev') ?>
<!--                                                    </button>-->
<!--                                                </div>-->
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
            <div class="close_me_over">
                &times;
            </div>
            <table class="clientes table  table-striped table-hover table-bordered ">
            </table>
        </div>
<script>
    var _clienteId = "<?php echo $clienteId ?>";
    var _tableContents = JSON.parse('<?php echo json_encode($clientes); ?>');
    var _clientesData_dataKeys = JSON.parse('<?php echo json_encode($dataKeys); ?>');
    var _company_data = JSON.parse('<?php echo json_encode($company_data); ?>');
    var _company_id = false;
</script>

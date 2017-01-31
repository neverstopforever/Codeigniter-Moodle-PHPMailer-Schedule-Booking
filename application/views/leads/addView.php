<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_leads'); ?></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <div class="table_loading"></div>
        <div class="page-content">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="<?php echo $layoutClass ?>">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="col-md-12">
                            <a href="<?php echo base_url() ?>prospects" class="btn btn-success pull-right">&times;</a>
                        </div>
                        <div class="wizard-container">
                            <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                    <div class="wizard-header">
                                        <h3>
                                            <?php echo $this->lang->line('leads_addSmallTitle'); ?>
                                        </h3>
                                    </div>
                                    <div class="mt-element-step">
                                        <div class="row step-thin">
                                            <div class="col-md-4 bg-grey mt-step-col done active" id="step_1">
                                                <div class="mt-step-number bg-white font-grey">1</div>
                                                <div class="mt-step-title uppercase font-grey-cascade">Step</div>
                                            </div>
                                            <div class="col-md-4 bg-grey mt-step-col" id="step_2">
                                                <div class="mt-step-number bg-white font-grey">2</div>
                                                <div class="mt-step-title uppercase font-grey-cascade">Step</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 text-center">
                                                <h3 class="">
                                                    <?php echo $this->lang->line('leads_select_one'); ?>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="row step-default">
                                            <div class="col-md-4 bg-grey mt-step-col btn"
                                                 onclick="showRealtedForm('newAdd');">
                                                <div class="mt-step-number"><i class="fa fa-pencil-square-o fa-2x"
                                                                               style="font-size:40px;"></i></div>
                                                <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('leads_create_a_blank_lead'); ?></div>
                                            </div>
                                            <div class="col-sm-1  mt-step-col">
                                                <div>or</div>
                                            </div>
                                            <div class="col-md-4 bg-grey mt-step-col btn active"
                                                 onclick="showRealtedForm('currentUser');">
                                                <div class="mt-step-number  "><i class="fa fa-home fa-files-o fa-2x "
                                                                                 style="font-size:40px; color:white"></i>
                                                </div>
                                                <div class="mt-step-content font-grey-cascade"><?php echo $this->lang->line('leads_select_from_existing'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: block; margin-top: 20px;" class="displayForm"
                                         id="currentUser"></div>
                                    <div <?php echo !isset($form_error) ? 'style="display: none; margin-top: 20px;"' : ''; ?>
                                        class="displayForm" id="newAdd">
                                        <form class="leads_add_form" action="<?= base_url() ?>leads/add" method="POST">
                                            <ul>
                                                <li><a data-toggle="tab"><?php echo $this->lang->line(
                                                            'leads_datosLeads'
                                                        ); ?></a></li>
                                            </ul>
                                            <input type="hidden" name="NumPresupuesto" id="numpresupuesto"
                                                   value="<?php echo set_value('NumPresupuestoDis'); ?>"/>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <?php echo $this->lang->line('leads_first_name') ?>
                                                        <input type="text" class="form-control" name="Nombre"
                                                               value="<?php echo set_value('Nombre'); ?>"/>
                                                    </label>
                                                    <?php echo form_error('Nombre'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <?php echo $this->lang->line('leads_surname') ?>
                                                        <input type="text" class="form-control" name="sApellidos"
                                                               value="<?php echo set_value('sApellidos'); ?>"/>
                                                    </label>
                                                    <?php echo form_error('sApellidos'); ?>
                                                </div>
                                            </div>

                                              <h4 class="personalized text-center"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                              <?php   
                                                 if(isset($student->custom_fields)){
                                                 $custom = explode(',',$student->custom_fields);
                                                    }else{
                                                    $custom = array();
                                                    } 
                                                     if(!empty($customfields_fields)) { $i=0; ?>
                                    <?php foreach($customfields_fields as $customfields){  ?>
                                    <div class="form-group text-left circle_select_div">

                                    <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1){ ?>

                                        <lable><?php echo $customfields['field_name']; ?>:</lable>
                                        <textarea type="text" class="form-control " name="custom_fields[]" <?php if($customfields['required']== 1){echo 'required';}  if($customfields['disabled']== 1){echo 'disabled';} ?>><?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?></textarea>
                                    <?php $i++;} elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <input type="text" <?php if($customfields['required']== 1){echo 'required';}  
                                        if($customfields['disabled']== 1){
                                            echo 'disabled';
                                        } ?>  class="form-control" name="custom_fields[]" value="<?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?>">
                                    <?php $i++;} 
                                    
                                    elseif($customfields['field_type'] =='select' && $customfields['active']== 1){ ?>
                                     <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <select <?php if($customfields['required']== 1){echo 'required';}  if($customfields['disabled']== 1){echo 'disabled';} ?>  class="form-control" name="custom_fields[]">
                                            <?php 
                                            $options = explode(',',$customfields['options']);
                                            foreach ($options as $value) {?>
                                                <option value="<?php echo $value;?>" <?php if(!empty($custom[$i]) && $custom[$i] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                                            <?php }?>
                                        </select>            
                                    <?php $i++;} 
                                     elseif($customfields['field_type'] =='datepicker' && $customfields['active']== 1){ ?>
                                        <lable><?php echo  $customfields['field_name']; ?>:</lable>
                                        <input type="text" <?php if($customfields['required']== 1){echo 'required';}  
                                        if($customfields['disabled']== 1){
                                            echo 'disabled';
                                        } ?>  class="form-control datepicker" name="custom_fields[]" value="<?php if(!empty($custom[$i])){ echo $custom[$i]; }else{ }?>">
                                    <?php $i++;}
                                    elseif($customfields['field_type'] =='checkbox' && $customfields['active']== 1){ ?>
                                        <input type="checkbox" <?php if($customfields['required']== 1){echo 'required';}  
                                        if($customfields['disabled']== 1){
                                            echo 'disabled';
                                        } ?>   name="custom_fields[]" <?php if(!empty($custom[$i])){ echo "checked"; }else{ }?> value="yes">&nbsp;&nbsp;&nbsp;<?php echo  $customfields['field_name']; ?>
                                    <?php $i++;} 
                                    else{ 
                                    
                                     }?>
                                    </div>
                                     <?php
                                     }
                                 }?>
                             <div class="col-md-12 wizard-footer">
                                                <div class="pull-right">
                                                    <input type="hidden" name="NumPresupuesto" id="NumPresupuestoHidden"
                                                           value="0"/>
                                                    <button class="btn btn-success " type="submit">
                                                        <?php echo $this->lang->line('leads_addBtn'); ?>
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
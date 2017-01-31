        <div class="page-container contactos_edit">

     
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
                                    <ul class="nav nav-tabs ">
                                        <li class="active">
                                            <a href="#tab_1" data-toggle="tab"
                                               aria-expanded="true"><?php echo $this->lang->line('personal_data'); ?> </a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_2" data-toggle="tab"
                                               aria-expanded="false"><?php echo $this->lang->line('history'); ?></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="">
                                                <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                                    <form class="clientes_add_form" method="POST">
                                                        <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                                                        <div class="wizard-header">
                                                            <h3>
                                                                <?php echo $this->lang->line('contactos_editTitle'); ?>
                                                            </h3>
                                                        </div>
                                                        <ul>
                                                            <li><a href="#datos-comerciales" data-toggle="tab"><?php echo $this->lang->line('clientes_personal_data'); ?></a></li>
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
                                                                            <input type="text" class="form-control" name="Snombre" value="<?php echo $content->Snombre; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Sapellidos'); ?>
                                                                            <input type="text" class="form-control" name="Sapellidos" value="<?php echo $content->Sapellidos; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Domicilio'); ?>
                                                                            <input type="text" class="form-control" name="Domicilio" value="<?php echo $content->Domicilio; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Poblacion'); ?>
                                                                            <input type="text" class="form-control" name="Poblacion" value="<?php echo $content->Poblacion; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Provincia'); ?>
                                                                            <input type="text" class="form-control" name="Provincia" value="<?php echo $content->Provincia; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Distrito'); ?>
                                                                            <input type="text" class="form-control" name="Distrito" value="<?php echo $content->Distrito; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Telefono1'); ?>
                                                                            <input type="text" class="form-control" name="Telefono1" value="<?php echo $content->Telefono1; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Telefono2'); ?>
                                                                            <input type="text" class="form-control" name="Telefono2" value="<?php echo $content->Telefono2; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Movil'); ?>
                                                                            <input type="text" class="form-control" name="Movil" value="<?php echo $content->Movil; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Pais'); ?>
                                                                            <input type="text" class="form-control" name="Pais" value="<?php echo $content->Pais; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('email'); ?>
                                                                            <input type="email" class="form-control" name="email" value="<?php echo $content->email; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('nif'); ?>
                                                                            <input type="text" class="form-control" name="nif" value="<?php echo $content->nif; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('fnacimiento'); ?>
                                                                            <input type="text"  class="form-control edit_contactos_datepicker" name="fnacimiento" value="<?php echo !empty($content->fnacimiento) && date('Y-m-d',strtotime($content->fnacimiento)) !== '-0001-11-30'  ?  date('Y-m-d',strtotime($content->fnacimiento)) : ''; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('skype'); ?>
                                                                            <input type="text" class="form-control" name="skype" value="<?php echo $content->skype; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group circle_select_div">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Idsexo'); ?>
                                                                            <select name="Idsexo" class="form-control form_control_auto_with sex_dropdown" />
                                                                            <option value="1" <?php echo $content->Idsexo == '1' ? 'selected' : '' ?>><?php echo $this->lang->line('contactos_male'); ?></option>
                                                                            <option value="2" <?php echo $content->Idsexo == '2' ? 'selected' : '' ?>><?php echo $this->lang->line('contactos_female'); ?></option>
                                                                            </select>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('iban'); ?>
                                                                            <input type="text" class="form-control" name="iban" value="<?php echo $content->iban; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Cc1'); ?>
                                                                            <input type="text" class="form-control" name="Cc1" value="<?php echo $content->Cc1; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Cc2'); ?>
                                                                            <input type="text" class="form-control" name="Cc2" value="<?php echo $content->Cc2; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Cc3'); ?>
                                                                            <input type="text" class="form-control" name="Cc3" value="<?php echo $content->Cc3; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('Cc4'); ?>
                                                                            <input type="text" class="form-control" name="Cc4" value="<?php echo $content->Cc4; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 ">
                                                                    <div class="form-group">
                                                                        <!--<div class="col-md-2">
                                                                <label>
                                                                    <?php /*echo  $dataKeys['Facturara']; */?>

                                                                </label>
                                                            </div>-->

                                                                        <div id="the-basics">
                                                                            <?php echo $this->lang->line('company'); ?>
                                                                            <input  type="text" class="form-control typeahead " placeholder="<?php echo $this->lang->line('choose_company'); ?>" value="<?php echo set_value('company_id', isset($company_name) ? $company_name : ''); ?>" name="company_id"  />
                                                                            <i class="fa fa-remove unassign_company_icon" title="Unassign" style="display: none"></i>
                                                                        </div>

                                                                    </div>
                                                                    <!--                                                        <a href="javascript:;" class="select_company contactos_btn btn-success "><i class="fa fa-edit"></i></a><span class="company_name"></span>-->
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>
                                                                            <?php echo $this->lang->line('seguimiento'); ?>
                                                                            <input type="text" class="form-control" name="seguimiento" value="<?php echo $content->seguimiento; ?>" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                    <h4 class="personalized"><?php echo $this->lang->line('custom_fields'); ?></h4>
                                                                <?php   
                                                 if(isset($content->custom_fields)){
                                                 $custom = $content->custom_fields;
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

                                                                        <?php if($customfields['field_type'] == 'textarea' && $customfields['active']== 1 && $show){ ?>
                                                                            <div class="form-group text-left">
                                                                                <lable class="text-capitalize"><?php echo $customfields['field_name']; ?>:</lable>
                                                                                <textarea <?php echo $disabled; ?>  type="text" class="form-control " name="custom_fields[<?php echo $customfields['id']; ?>]" <?php if($customfields['required']== 1){echo 'required';}?>><?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?></textarea>
                                                                            </div>
                                                                        <?php } elseif($customfields['field_type'] =='input' && $customfields['active']== 1){ ?>
                                                                            <div class="form-group text-left">
                                                                                <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                                <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php if(!empty($custom->$customfields['id'])){ echo $custom->$customfields['id']; }else{ }?>">
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
                                                                                        <option value="<?php echo $value;?>" <?php if(!empty($custom->$customfields['id']) && $custom->$customfields['id'] == $value){ echo "selected"; }else{ }?>><?php echo $value;?></option>
                                                                                    <?php }?>
                                                                                </select>
                                                                            </div>
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
                                                                            <div class="form-group text-left circle_select_div" >
                                                                                <lable class="text-capitalize"><?php echo  $customfields['field_name']; ?>:</lable>
                                                                                <input type="text" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="form-control datepicker_field" fild_id="<?php echo $customfields['id']; ?>" value="<?php echo $date; ?>">
                                                                                <input type="hidden" <?php if($customfields['required']== 1){echo ' required ';} echo $disabled; ?>  class="hidden_date" fild_id="<?php echo $customfields['id']; ?>" id="hidden_date<?php echo $customfields['id']; ?>" name="custom_fields[<?php echo $customfields['id']; ?>]" value="<?php echo $datePost; ?>">
                                                                            </div>
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
                                                                        <?php
                                                                    }
                                                                }?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="wizard-footer">
                                                            <div class="back_save_group text-left">
                                                                <!--                                                    <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='--><?php //echo $this->lang->line('clientes_next') ?><!--' />-->
                                                                <a href="<?php echo base_url() ?>contactos" class="btn-sm btn btn-circle btn-default-back xs_hide"><?php echo $this->lang->line('back'); ?></a>
                                                                <input type='submit' class='btn-finish btn btn-sm btn-primary btn-circle ' name='finish' value='<?php echo $this->lang->line('clientes_updateBtn') ?>' />
                                                                <a href="<?php echo base_url() ?>contactos" class="btn-sm btn btn-circle btn-default-back xs_show"><?php echo $this->lang->line('back'); ?></a>
                                                            </div>
                                                            <div class="pull-left">
                                                                <!--<input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='<?php echo $this->lang->line('clientes_prev') ?>' />-->
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane " id="tab_2">
                                            <h3><?php echo $this->lang->line('last_prospects')?></h3>
                                            <h4><?php echo $this->lang->line('last_prospects_description')?></h4>
                                            <?php if(!empty($prospects)){ ?>
                                            <div class="timeline">
                                                <?php $pr_year = '';?>
                                            <?php foreach($prospects as $prospect){ ?>
                                                    <?php if($prospect->prospect_id){?>
                                                        <?php $prospect_year = date('Y', strtotime($prospect->Prospect_date)); ?>
                                                        <?php if($pr_year != $prospect_year){ ?>
                                                        <h2> <?php echo $prospect_year ; ?></h2>
                                                            <?php  $pr_year = $prospect_year; }?>


                                                        <ul class="timeline-items">
                                                            <li class="timeline-item inverted">
                                                       <div>
                                                           <strong><a href="<?php echo base_url().'leads/edit/'.$prospect->prospect_id ?>"><?php echo $this->lang->line('prospect') .' #'.$prospect->prospect_id ; ?></a></strong>
                                                       </div>
                                                        <div class="dateCreation">
                                                           <?php echo $this->lang->line('date') .' '.date($format, strtotime($prospect->Prospect_date)) ; ?>
                                                       </div>
                                                       <div>
                                                           <?php $tags_html = ''; ?>
                                                           <?php if(isset($prospect->tag_ids)) {
                                                               $tag_ids_array = explode(',', $prospect->tag_ids);
                                                               foreach ($tag_ids_array as $key=>$tag_id){
                                                                   if($key <= 3){
                                                                       $tags_html .= '<div class="label label-default filter_by_tag " style="background-color: ' . $tags_group_by_tag_id[$tag_id]->hex_backcolor . '; color: ' . $tags_group_by_tag_id[$tag_id]->hex_forecolor . '; margin-right: 3px; padding: 2px 4px"  >' . $tags_group_by_tag_id[$tag_id]->tag_name . '</div>';
                                                                   }
                                                                   
                                                               }
                                                           }?>
                                                           <?php echo $tags_html; ?>
                                                       </div>
                                                            </li>
                                                        </ul>
                                                    <?php }?>

                                                <?php }?>
                                            </div>
                                            <?php }?>

                                        </div>
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
    var _company_id  = JSON.parse('<?php echo json_encode($content->Facturara); ?>');
</script>
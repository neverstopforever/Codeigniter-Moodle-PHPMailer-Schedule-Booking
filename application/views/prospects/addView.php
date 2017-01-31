<div class="page-container">
        <div class="table_loading"></div>
        <div class="page-content">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="<?php echo $layoutClass ?> ">
                <ul class=" page-breadcrumb breadcrumb">
                    <li>
                        <a href="/"><?= $this->lang->line('menu_Home') ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?='CRM' //$this->lang->line('menu_Home') ?></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>prospects"> <?php echo $this->lang->line('menu_prospects'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('add'); ?>
                    </li>
                </ul>
                <div class="portlet light sdd_action">
                    <div class="portlet-body">

                        <div class="wizard-container">
                            <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                    <div class="wizard-header">
                                        <h3>
                                            <?php echo $this->lang->line('leads_enroll_wizard'); ?>
                                        
                                        </h3>
                                    </div>
                                    <div class="mt-element-step">
                                                <h4>
                                                    <?php echo $this->lang->line('leads_select_one'); ?>
                                                </h4>
                                        <div class="step-default">
                                            <div class="col-md-4" >
                                                <div class="mt-step-col btn" id="step_1" onclick="showRealtedForm('newAdd');">
                                                    <div class="mt-step-number"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                                                    <p class="mt-step-content "><?php echo $this->lang->line('leads_create_a_blank_lead'); ?></p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mt-step-col btn" id="step_2"  onclick="showRealtedForm('currentUser');">
                                                    <div class="mt-step-number  "><i class="fa fa-home fa-files-o fa-2x "></i>
                                                    </div>
                                                    <p class="mt-step-content "><?php echo $this->lang->line('leads_select_from_existing'); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-step-col btn" id="step_3"  onclick="showRealtedForm('fromStudents');">
                                                    <div class="mt-step-number  "><i class="fa fa-home fa-files-o fa-2x "></i>
                                                    </div>
                                                    <p class="mt-step-content "><?php echo $this->lang->line('leads_select_from_existing_students'); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: block; margin-top: 20px;" class="displayForm"   id="currentUser"></div>
                                    <div style="display: block; margin-top: 20px;" class="displayForm"   id="fromStudents"></div>
                                    <div <?php echo !isset($form_error) ? 'style="display: none; margin-top: 20px;"' : ''; ?>
                                        class="displayForm" id="newAdd">
                                        <form class="leads_add_form" action="<?= base_url() ?>prospects/add" method="POST">
                                            <ul>
                                                <li><a data-toggle="tab"><?php echo $this->lang->line('leads_datosLeads'); ?></a></li>
                                            </ul>
                                            <input type="hidden" name="NumPresupuesto" id="numpresupuesto"
                                                   value="<?php echo set_value('NumPresupuestoDis'); ?>"/>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <?php echo $this->lang->line('leads_first_name') ?>
                                                        <input type="text" class="form-control" name="Nombre" maxlength="40"
                                                               value="<?php echo set_value('Nombre'); ?>"/>
                                                    </label>
                                                    <?php echo form_error('Nombre'); ?>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        <?php echo $this->lang->line('leads_surname') ?>
                                                        <input type="text" class="form-control" name="sApellidos" maxlength="40"
                                                               value="<?php echo set_value('sApellidos'); ?>"/>
                                                    </label>
                                                    <?php echo form_error('sApellidos'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <?php echo $this->lang->line('email') ?>
                                                        <input type="text" class="form-control" name="email"
                                                               value="<?php echo set_value('email'); ?>"/>
                                                        <span class="email_error text-danger"> <span>
                                                    </label>
                                                    <?php echo form_error('email'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 wizard-footer">
                                                <div class="back_save_group">
                                                    <input type="hidden" name="NumPresupuesto" id="NumPresupuestoHidden"
                                                           value="0"/>

                                                    <button class="btn btn-sm btn-primary btn-circle add_form_leads " type="submit">
                                                        <?php echo $this->lang->line('leads_addBtn'); ?>
                                                    </button>
                                                    <a href="<?php echo base_url() ?>prospects" class="btn-sm btn btn-circle btn-default-back"><?php echo $this->lang->line('back'); ?></a>
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
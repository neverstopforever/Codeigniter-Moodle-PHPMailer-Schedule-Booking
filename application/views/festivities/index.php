        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">


            <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('festivities_festivities');?>
                        </li>
                    </ul>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-right">
                                <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                            </div>
                            <div class="quick_tips_sidebar margin-top-20">
                                <div class=" note note-info quick_tips_content">
                                    <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                    <p><?php echo $this->lang->line('festivities_quick_tips_text'); ?>
                                        <strong><a href="<?php echo $this->lang->line('festivities_quick_tips_link'); ?>" target="_blank"> <?php echo $this->lang->line('festivities_quick_tips_link_text'); ?></a></strong>
                                    </p>
                                </div>
                            </div>
                            <div class="row margin-bottom-20">


<!--                                <div class="col-sm-4">-->
<!--                                    <h3 class="text-center festive_name" style="display: inline-block;">--><?php //echo $this->lang->line('festivities_festivities');?><!--</h3>-->
<!--                                </div>-->
<!--                                <div class="col-sm-4">-->
<!--                                    <lable for="reportrange">--><?php //echo $this->lang->line('festivities_search_date_range');?><!--</lable>-->
<!--                                    <input type="text" name="reportrange" id="reportrange" />-->
<!--                                </div>-->
<!--                                <div class="col-sm-8">-->
<!--                                    <button type="button" class="btn btn-primary pull-right" id="add_festivities">--><?php //echo $this->lang->line('add');?><!--</button>-->
<!--                                </div>-->
                            </div>
                            <div class="no_festivities" style="display: none;"></div>
                            <table id="festivities" class="table display dbtable_hover_theme" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('festivities_description'); ?></th>
                                    <th><?php echo $this->lang->line('festivities_date'); ?></th>
<!--                                    <th>--><?php //echo $this->lang->line('festivities_id_center'); ?><!--</th>-->
                                    <th><?php echo  $this->lang->line('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($festivities) && !empty($festivities)) {?>
                                    <?php foreach($festivities as $festivitie){ ?>
                                        <tr data-description="<?php echo $festivitie->Descripcion; ?>"
                                            data-id="<?php echo $festivitie->id; ?>"
                                            data-date="<?php echo date($datepicker_format,strtotime($festivitie->Fecha));?>"
                                            data-id_center="<?php echo $festivitie->IdCentro;?>">
                                            <td> <a href="<?php echo base_url();?>" class="edit_festivities"><?php echo $festivitie->Descripcion;?></a></td>
                                            <td><?php echo date($datepicker_format,strtotime($festivitie->Fecha));?></td>
<!--                                            <td>--><?php //echo $festivitie->IdCentro;?><!--</td>-->
                                            <td>
                                                <a href="<?php echo base_url();?>" class=" delete_festivities" data-delete_confirm="<?php echo $this->lang->line('are_you_sure_delete');?>"><i class="fa fa-trash"></i> <?php echo  $this->lang->line('delete'); ?></a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->

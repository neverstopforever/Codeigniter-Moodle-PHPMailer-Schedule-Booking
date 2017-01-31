        <div class="page-container">
             <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_form_online'); ?>
                        </li>
                    </ul>
                    <div class="portlet light ">

                        <div class="text-right">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20">
                            <div class=" note note-info quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('form_online_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('form_online_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('form_online_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>

                    <h2 class="form_online_header"><?php echo $this->lang->line('form_online_webforms'); ?></h2>
              
                        <div class="row col-md-6 col-md-offset-3 margin-bottom-20 circle_select_div">
                            <label for="source"><?php echo $this->lang->line('source'); ?>: </label>
                            <select name="source" id="source" class="form-control">
                                <option value="">--<?php echo $this->lang->line('form_online_select_source'); ?>--</option>
                                <?php if(!empty($sources)){
                                    foreach($sources as $source){ ?>
                                        <option value="<?php echo $source->apikey;?>"  data-idportal="<?php echo $source->idportal;?>"><?php echo $source->title;?></option>
                                    <?php }
                                }?>
                            </select>
                        </div>
                        <div class="row col-md-6 col-md-offset-3 margin-bottom-20 circle_select_div">
                            <label for="form_type"><?php echo $this->lang->line('_type'); ?>: </label>
                            <select name="form_type" id="form_type" class="form-control" disabled>
                                <option value="">--<?php echo $this->lang->line('form_online_select_type_form'); ?>--</option>
                            </select>
                        </div>
                        <div class="row col-md-6 col-md-offset-3">
                            <div id="generate_form"></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- END PAGE CONTENT -->


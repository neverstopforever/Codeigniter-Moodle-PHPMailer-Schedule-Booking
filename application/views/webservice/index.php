        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
            <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                <li>
                    <a href="/"><?=$this->lang->line('menu_Home')?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_form_online'); ?>
                </li>
            </ul>

            <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <div class="portlet light ">
                    <h2 class="uppercase"><?php echo $this->lang->line('form_online_webforms'); ?></h2>
                    <hr />
                        <div class="row col-md-6 col-md-offset-3 margin-bottom-20 ">
                            <label for="source"><?php echo $this->lang->line('source'); ?>: </label>
                            <select name="source" id="source" class="form-control">
                                <option value="">--<?php echo $this->lang->line('form_online_select_source'); ?>--</option>
                                <?php if(!empty($sources)){
                                    foreach($sources as $source){ ?>
                                        <option value="<?php echo $source->apikey;?>"><?php echo $source->title;?></option>
                                    <?php }
                                }?>
                            </select>
                        </div>
                        <div class="row col-md-6 col-md-offset-3 margin-bottom-20">
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


            <div class="<?php echo $layoutClass ?>" style="padding-top:20px;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue-madison">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $this->lang->line('help_blog') ?>
                            </div>
                            <div class="desc">
                                <?php echo $this->lang->line('help_blogMata') ?>
                            </div>
                        </div>
                        <a class="more" href="<?php echo base_url() ?>blog">
                         <?php echo $this->lang->line('help_blogLink') ?> <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat red-intense">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $this->lang->line('help_support') ?>
                                
                            </div>
                            <div class="desc">
                                <?php echo $this->lang->line('help_supportMeta') ?>
                                
                            </div>
                        </div>
                        <a class="more supportDesk" href="javascript:;">
                         <?php echo $this->lang->line('help_supportLink') ?> <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green-haze">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $this->lang->line('help_FAQs') ?>
                            </div>
                            <div class="desc">
                                <?php echo $this->lang->line('help_FAQsMeta') ?>
                                
                            </div>
                        </div>
                        <a class="more" href="<?php echo base_url() ?>user/faqs">
                        <?php echo $this->lang->line('help_FAQsLink') ?> <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat purple-plum">
                        <div class="visual">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $this->lang->line('help_contact') ?>
                            </div>
                            <div class="desc">
                                <?php echo $this->lang->line('help_contactMeta') ?>
                               
                            </div>
                        </div>
                        <a class="more" href="<?php echo base_url() ?>user/contact">
                         <?php echo $this->lang->line('help_contactLink') ?> <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </div>
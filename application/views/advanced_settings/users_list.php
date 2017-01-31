        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
           
          
          
            <!-- BEGIN PAGE CONTENT -->
            <div class="table_loading"></div>
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class=" page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('user_users'); ?>
                        </li>
                    </ul>
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="portlet users_list_section light text-center">

                        <div class="text-right margin-bottom-10">
                            <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                        </div>
                        <div class="quick_tips_sidebar margin-top-20 margin-bottom-20">
                            <div class=" note note-info text-left quick_tips_content">
                                <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                                <p><?php echo $this->lang->line('user_list_quick_tips_text'); ?>
                                    <strong><a href="<?php echo $this->lang->line('user_list_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('user_list_quick_tips_link_text'); ?></a></strong>
                                </p>
                            </div>
                        </div>

                        <h2><?php echo sprintf($this->lang->line('advanced_settings_users_list_title'), $concurrent_users); ?></h2>
                        <table id="usersTable" class="table dbtable_status_buttons  dbtable_hover_theme table-condensed">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('advanced_settings_photo'); ?></th>
                                <th><?php echo $this->lang->line('advanced_settings_user_name'); ?></th>
                                <th><?php echo $this->lang->line('advanced_settings_email'); ?></th>
                                <th><?php echo $this->lang->line('advanced_settings_status'); ?></th>
                            </tr>
                            </thead>
                            <tbody id="usersTableContent">
                            <?php if(!empty($users)) { ?>
                                <?php foreach($users as $user){ ?>
                                    <tr>
                                        <td><img class="list_img_size" src="<?php echo $user->photo ? 'data:image/jpeg;base64,'.base64_encode($user->photo) : base_url().'assets/img/dummy-image.jpg'; ?>" ></td>
                                        <td><a href="<?php echo base_url('user/profile/'.$user->id); ?>"><?php echo $user->user_name; ?></a></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php if($user->status == '1'){ ?>
                                                <button  disabled="disabled" type="button" name="change_status" user_id="<?php echo $user->id; ?>" status="<?php echo $user->status; ?>" class="btn btn-outline green"><?php echo $this->lang->line('advanced_settings_active'); ?></button></td>
                                            <?php  }else{ ?>
                                                 <button disabled="disabled" type="button" name="change_status" user_id="<?php echo $user->id; ?>" status="<?php echo $user->status; ?>"  class="btn btn-outline red"><?php echo $this->lang->line('advanced_settings_locked'); ?></button></td>
                                            <?php } ?>
<!--                                        <a href="#" target="_blank" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>-->

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

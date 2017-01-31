<div class="page-container">
     <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>"><?php echo $this->lang->line('menu_Home'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                </li>
                <li><a href="<?php echo $_base_url; ?>blog/list"><?php echo $this->lang->line('menu_blog'); ?></a></li>
                <li class="active"><?php echo $this->lang->line('edit'); ?></li>
            </ul>

    <div class="portlet light blog_edit ">

        <div class="col-sm-6 no-padding">
            <form method="POST" class="blog_edit_form"
                  action="<?php echo base_url() . 'blog/update/' . $post['post_id']; ?>" enctype="multipart/form-data">
                <div class="form-group"><label><?php echo $this->lang->line('title'); ?></label>
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>" required/>
                    <input type="text" name="post_title" class="form-control post_title" required
                           value="<?php echo $post['post_title']; ?>"/>
                </div>


                <div class="form-group"><label><?php echo $this->lang->line('events_content'); ?></label>
                    <textarea rows="8" name="post_content" class="form-control post_content wysihtml5"
                              required><?php echo $post['post_content']; ?></textarea>
                </div>
                <div class="form-group"><label><?php echo $this->lang->line('blog_post_thumbnail'); ?></label>

                    <div class="fallback">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
					<span class="btn btn-primary btn-circle btn-file"><span
                            class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input
                            type="file" name="post_image" class="post_thumbnail">
					</span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput"
                               style="float: none">&times;</a>
                        </div>

                    </div>

                    <!--			<input type="hidden" name="hidden_post_image" value="-->
                    <?php //echo $post['post_image']?><!--" />-->
                    <!--			<div class="fileinput fileinput-new" data-provides="fileinput" style="width:100%;">-->
                    <!--			<div class="input-group input-large">-->
                    <!--			<div class="form-control uneditable-input input-fixed input-medium"-->
                    <!--				data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i>&nbsp;-->
                    <!--			<span class="fileinput-filename"> </span></div>-->
                    <!--			<span class="input-group-addon btn default btn-file"> <span-->
                    <!--				class="fileinput-new"> -->
                    <?php //echo $this->lang->line('blog_select_file'); ?><!-- </span> <span-->
                    <!--				class="fileinput-exists"> -->
                    <?php //echo $this->lang->line('blog_change'); ?><!-- </span> <input type="file" name="post_image" class="post_thumbnail" >-->
                    <!--			</span> <a href="javascript:;"-->
                    <!--				class="input-group-addon btn red fileinput-exists"-->
                    <!--				data-dismiss="fileinput">-->
                    <?php //echo $this->lang->line('blog_remove'); ?><!--   </a></div>-->
                    <!--			</div>-->
                </div>
                <div class="form-group">
                    <button type="submit"
                            class="btn btn-primary btn-circle post_save"><?php echo $this->lang->line('blog_update_post'); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

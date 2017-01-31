<div class="page-container">

    <div class="table_loading"></div>
    <div class="portlet light <?php echo $layoutClass ?>">
        <ul class=" page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
            </li>
            <li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
        </ul>
        <form class="blog_write" enctype="multipart/form-data">
            <div class="form-group"><label>Post Title</label>
                <input type="text" class="form-control post_title" required/></div>
            <div class="form-group"><label>Post Content</label>
                <textarea rows="8" name="" class="form-control post_content wysihtml5" required></textarea>
            </div>
            <div class="form-group"><label>Post Thumbnail</label>
                <div class="fileinput fileinput-new" data-provides="fileinput" style="width:100%;">
                    <div class="input-group input-large">
                        <div class="form-control uneditable-input input-fixed input-medium"
                             data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename"> </span></div>
			<span class="input-group-addon btn default btn-file"> <span
                    class="fileinput-new"> Select file </span> <span
                    class="fileinput-exists"> Change </span> <input type="file" name="" class="post_thumbnail">
			</span> <a href="javascript:;"
                       class="input-group-addon btn red fileinput-exists"
                       data-dismiss="fileinput"> Remove </a></div>
                </div>
            </div>
            <div class="form-group" style="text-align: right;">
                <button type="submit" class="btn btn-primary post_save">Save Post</button>
            </div>
        </form>
    </div>
</div>

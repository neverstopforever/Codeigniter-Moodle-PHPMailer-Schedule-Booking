<div class="page-container ">
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_information'); ?></h1>
            </div>
        </div>
    </div>
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
        <li class="active"><?php echo $this->lang->line('resource'); ?></li>
    </ul>
    <div class="page-content ">
        <div class="<?php echo $layoutClass ?>">
            <div class="portlet light row">
                <div class="portlet-body">
                    <div class="col-md-3">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="panel panel-primary margin-top-20">
                                <div class="panel-heading"><?php echo $this->lang->line('resource');?></div>
                                <div class="panel-body no-padding-all">
                                    <ul class="sidebar_tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#resources" aria-controls="resources" role="tab"data-toggle="tab">
                                                <?php echo $this->lang->line('my_resources'); ?>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#template" aria-controls="template" role="tab"data-toggle="tab">
                                                <?php echo $this->lang->line('my_templates'); ?>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#group" aria-controls="group" role="tab"data-toggle="tab">
                                                <?php echo $this->lang->line('my_groups'); ?>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#student" aria-controls="student" role="tab"data-toggle="tab">
                                                <?php echo $this->lang->line('my_students'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                     <div class="col-md-9">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="resources">
    <div class="row">
        <div class="overf_hidden resources_header col-xs-12" >
            <h2 class="pull-left">Resources</h2>
            <input class="pull-right form-control" type="search" placeholder="Search criteria"/>
        </div>
        <div class="col-xs-8">
                <h4> <strong>Upload your resources</strong> </h4>
                <label class="margin-bottom-10">Upload all your files, videos, photos and docs and share with other</label>
                <form action="campus/aws_s3/resource_upload" class="dz-clickable"  name="documents_import" id="upload_resource">
                    <button type="button" class=" btn btn-primary dz-default dz-message">
                        <i class="fa fa-plus"></i> Add resources
                    </button>
                </form>
        </div>
        <div class="col-xs-4">
            <p class="text-danger free_res_text"><strong> 12% of resources free </strong></p>
        </div>
        <div class="col-xs-12 margin-top-20">
            <table class="resources table">
                <thead>
                    <tr>
                        <td>Type</td>
                        <td>Title</td>
                        <td>Visibility</td>
                        <td width="80">Action</td>
                    </tr>
                </thead>
                <tbody id="table_body_resource"></tbody>
            </table>
        </div>
    </div>
                                </div>
    <div role="tabpanel" class="tab-pane " id="template">
        <div id="manage_template">
        <h3>Create Yourself Template</h3>
        <p>Group all resources [picture, videos, docs, files]</p>
            <div class="form-group">
                <div class="col-md-4"  style="padding-left:0;">
                    <input type="text" id="template_title" class="form-control" data-required="1" name="title" placeholder="Template Name"> 
                </div>
                <button class="btn green add_template" type="submit">Create Template</button>
            </div>
        <div class="clearfix"></div>
        <table class="templates table">
            <thead>
                <tr>
                    <td>Title</td>
                    <td width="80">Action</td>
                </tr>
            </thead>
            <tbody id="table_body_resource"></tbody>
        </table>
        </div>
        <div id="manage_resource" style="display:none">
            <h2 id="select_template_title"></h2>
            <p>Check the resource from main list you would like to add into the template</p>
            <div><button type="submit" class="btn green get_resouce_list_template">Add Resources</button></div>
                          <table class="template_resources table">
                        <thead>
                            <tr>
                                <td>Title</td>
                                <td width="80">Action</td>
                            </tr>
                        </thead>
                        <tbody id="template_table_body_resource"></tbody>
                    </table>
                                        <div><button type="submit" class="btn green back_template">Back Template</button></div>
        </div>
    </div>
                                <div role="tabpanel" class="tab-pane " id="group">
                                    <div id="manage_group">
                                    <h3>Manage your groups</h3>
        <p>Import Resource for Template, manage resource and share with the group</p>
                                    <div class="col-md-12 no-padding">
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label>Curso:
                                    <select required id="CourseId" name="idactividad" class="form-control filter_events"/>
                                    <option value="">--Todos--</option>
                                    <?php foreach ($course as $list): ?>
                                        <option
                                            value="<?php echo $list->idactividad; ?>"><?php echo $list->actividad; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label>Grupo:
                                    <select required id="GroupId" name="Idgrupo" class="form-control filter_events"/>
                                    <option value="">--Todos--</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                                        <div class="form-group">
                <div class="col-md-4"  style="padding-left:0;">
                    <input type="text" id="group_title" class="form-control" required data-required="1" name="title" placeholder="Group Name"> 
                </div>
                <button class="btn green add_group" type="submit">Create Group</button>
                
            </div>
                         <div class="clearfix"></div>
        <table class="groups table">
            <thead>
                <tr>
                    <td>Group</td>
                    <td>Title</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                    <td width="80">Action</td>
                </tr>
            </thead>
            <tbody id="table_body_groups"></tbody>
        </table>
                    </div>
                                </div>
                                    <div id="group_resource" style="display:none;">
                                        <h2 id="select_group_title"></h2>
                                        <h3 id="selected_course_title"></h3>
                                        <p>Manage your Resource for the group</p>
                                        <div><button type="submit" class="btn green get_resouce_list">Add Resources</button> <button type="submit" class="btn green import_template">Import Template</button></div>
                                        <table class="group_resources table dbtable_hover_theme">
                        <thead>
                            <tr>
                                <td>Title</td>
                                <td width="80">Action</td>
                            </tr>
                        </thead>
                        <tbody id="group_table_body_resource"></tbody>
                    </table>
                                        <div><button type="submit" class="btn green back_group">Back Group</button></div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane " id="student">
                                    <h3>Manage your students</h3>
        <p>Manage resources for the particular students</p>
                                    <div class="col-md-12 no-padding">
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label>Curso:
                                    <select required id="sCourseId" class="form-control filter_events"/>
                                    <option value="">--Filter By Course--</option>
                                    <?php foreach ($course as $list): ?>
                                        <option
                                            value="<?php echo $list->idactividad; ?>"><?php echo $list->actividad; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label>Grupo:
                                    <select required id="sGroupId" class="form-control filter_events"/>
                                    <option value="">--Filter By Group--</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                                         <div><button  type="submit" class="btn green filter_students">Filter Students</button></div>
                                </div>
        <div id="list_student">
            <table class="student table">
            <thead>
                <tr>
                    <td width="80"></td>
                    <td>Name</td>
                    <td width="80">Action</td>
                </tr>
            </thead>
            <tbody id="table_body_student"></tbody>
        </table>
            
        </div>
                        </div>
                     </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="template_edit_panel" class="modal fade" tabindex="-1" data-width="480">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Template</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p>
                <input class="form-control" type="hidden" id="u_template_id"> 
                <input class="form-control" type="text" id="u_template_title"> 
            </p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
        <button type="button" class="btn green update_template">Update</button>
    </div>
</div>
<div id="list_resource_panel" class="modal fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select the resources for the group</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <table class="list_resources table">
                        <thead>
                            <tr>
                                <td></td>
                                <td>Title</td>
                            </tr>
                        </thead>
                        <tbody id="list_resources_table_body_resource"></tbody>
                    </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green resource_group_save">Done</button>
    </div>
</div>
<div id="template_list_resource_panel" class="modal fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select the resources for the template</h4>
    </div>
    <div class="modal-body">
        <div class="row">
           <table class="main_resources table">
                        <thead>
                            <tr>
                                <td></td>
                                <td>Title</td>
                            </tr>
                        </thead>
                        <tbody id="main_table_body_resource"></tbody>
                    </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green resource_template_save">Done</button>
    </div>
</div>
<div id="list_template_panel" class="modal fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select template for the group</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p>This will import all the resources associated to the template to the group</p>
            <table class="list_template table">
                        <thead>
                            <tr>
                                <td></td>
                                <td>Title</td>
                            </tr>
                        </thead>
                        <tbody id="list_resources_table_body_resource"></tbody>
                    </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green save_import_template">Done</button>
    </div>
</div>
<div id="post_panel" class="modal fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Post Comments</h4>
    </div>
    <div class="modal-body">
        <p id="post_group_title" style="margin-top:0;"></p>
        <textarea class="form-control c-square" placeholder="Comments" id="comment" name="comment" rows="2"></textarea>
        <div style="padding:15px 0;"><button type="submit" class="btn green post_comment">Post Comment</button></div>
        <div class="clearfix"></div>
        <div class="c-comment-list">
                   
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green">Done</button>
    </div>
</div>
    <div id="plan_group" class="modal fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Planning</h4>
    </div>
    <div class="modal-body">
        <p id="plan_select_group_title" style="margin-top:0;"></p>
        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label>Start Date :
                                    <input type="text" id="group_start_date" class="form-control datepicker" data-required="1" name="start_date" placeholder="Start Date"> 
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:0;">
                            <div class="form-group">
                                <label>End Date :
                                    <input type="text" id="group_end_date" class="form-control datepicker" data-required="1" name="end_date" placeholder="End Date"> 
                                </label>
                            </div>
                        </div>
        <textarea class="form-control c-square" placeholder="Comments" id="plan_comment" name="comments" rows="2"></textarea>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green save_plan">Save</button>
    </div>
</div>
<script type="text/javascript">
    var resource = <?php echo $json_resource?>;
    var template = <?php echo $json_template?>;
    var _group = <?php echo $group?>;
    var group = <?php echo $json_group?>;
</script>
<style>#ui-datepicker-div{z-index:9999 !important}</style>
    

<div class="tabbable-line">
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#tab_5_1" data-toggle="tab"
               aria-expanded="true"> <?php echo $this->lang->line('groups_books'); ?> </a>
        </li>
<!--        <li class="">-->
<!--            <a href="#tab_5_2" data-toggle="tab"-->
<!--               aria-expanded="false"> --><?php //echo $this->lang->line('groups_internal'); ?><!--</a>-->
<!--        </li>-->
        <li class="">
            <a href="#tab_5_3" data-toggle="tab"
               aria-expanded="false"> <?php echo $this->lang->line('groups_templates'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tools">
        </div>
        <div class="tab-pane active " id="tab_5_1">
            <div class="col-sm-4 no-padding pull-right show_books" style="display: none;">
                <div class=" no-padding" >
                    <div id="books-multiple-datasets" >
                        <input class="typeahead" type="text" placeholder="<?php echo $this->lang->line('groups_select_books'); ?>">
                    </div>
                </div>
                <div class="col-sm-12 text-left no-padding margin-top-10 back_save_group" >
                    <div class="pull-left margin-right-10"  >
                        <button class="btn btn-sm btn-primary btn-circle  addBookBtn"><?php echo $this->lang->line('add'); ?></button>
                    </div>
                    <div class=""  >
                        <button class="btn-sm btn btn-circle btn-default-back  hide_add_book"><?php echo $this->lang->line('cancel'); ?></button>
                    </div>

                </div>



            </div>
            <div id="ResourcesBooksTable" class="student_documents_table no_data_table" >

            </div>
         </div>

        <div class="tab-pane student_sub_tab" id="tab_5_2">

        </div>
        <div class="tab-pane student_sub_tab" id="tab_5_3">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <lable class="lable ">
                        <?php echo $this->lang->line('select_template'); ?>
                    </lable>
                    <div class="circle_select_div">
                        <select class="form-control " name="templateId" >
                            <option value="0"><?php echo $this->lang->line('select_template'); ?></option>

                                    <option  value="">test</option>

                        </select>
                    </div>

                    <input type="hidden" name="teacherId" value="">
                </div>
                <div class="col-sm-6">
                    <button id="" type="submit" class="btn btn-default tamplate_print  btn-default btn-circle"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="resourcesDeleteBookModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('groups_delete_book'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('groups_delete_event_msg'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_book" data-dismiss="modal"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="eventpanel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-head">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">


                <div class="event_date"></div>

                <label><?php echo $this->lang->line('groups_detail');?></label>
                <p class="event_detail"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var books = <?php echo json_encode($books); ?>;
    //var not_exists_books = <?php //echo json_encode($not_exists_books); ?>;


</script>

<script src="<?php echo base_url(); ?>app/js/groups/resources.js"></script>
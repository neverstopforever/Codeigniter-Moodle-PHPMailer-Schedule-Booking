
<div class="tabbable-line">
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#tab_7_1" data-toggle="tab"
               aria-expanded="true"> <?php echo $this->lang->line('students'); ?> </a>
        </li>
        <li class="">
            <a href="#tab_7_2" data-toggle="tab"
               aria-expanded="false"> <?php echo $this->lang->line('groups_accounting'); ?></a>
        </li>
        <li class="">
            <a href="#tab_7_3" data-toggle="tab"
               aria-expanded="false"> <?php echo $this->lang->line('groups_attendance'); ?></a>
        </li>
        <li class="">
            <a href="#tab_7_4" data-toggle="tab"
               aria-expanded="false"> <?php echo $this->lang->line('groups_my_reports'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tools">
        </div>
        <div class="tab-pane active " id="tab_7_1">
            <div id="groups_students_table_empty" class=" no_data_table">

            </div>
            <div id="GroupStudentsTable" class="student_documents_table" >

            </div>
         </div>

        <div class="tab-pane student_sub_tab" id="tab_7_2">
            <div id="groups_accounting_table_empty" class=" no_data_table">

            </div>
            <div id="GroupAccountingTable" class="student_documents_table" >

            </div>
        </div>
        <div class="tab-pane student_sub_tab" id="tab_7_3">
            <div id="groups_attendance_table_empty" class=" no_data_table">

            </div>
            <div id="GroupAttendanceTable" class="student_documents_table" >

            </div>
        </div>
        <div class="tab-pane student_sub_tab" id="tab_7_4">
            <div class="row">
                <div class="col-sm-5 margin-top-10 circle_select_div reports_list">
                    <select class="form-control" name="select_reports"></select>
                </div>
            </div>
            <div id="GroupMyReportsTable" class="student_documents_table" >

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="resourcesDeleteBookModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-head">
                <h4 class="modal-title"><?php echo $this->lang->line('groups_delete_book'); ?></h4>
            </div><div class="modal-body">
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
            <div class="modal-header">
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
    var students = <?php echo json_encode($students); ?>;
    var courses = <?php echo json_encode($courses); ?>;


</script>

<script src="<?php echo base_url(); ?>app/js/groups/reports.js"></script>
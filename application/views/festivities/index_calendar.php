        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
       

            <div class="table_loading"></div>
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="<?php echo $layoutClass ?>">
                    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
                        <li>
                            <a href="/"><?=$this->lang->line('menu_Home')?></a>
                        </li>
                        <li class="active">
                            <?php echo $this->lang->line('menu_form_online'); ?>
                        </li>
                    </ul>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="festivities_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT -->

        <script>
            var festivities = <?php echo isset($festivities) ? json_encode($festivities) : json_encode(array()) ?>;
        </script>

        <div class="modal modal-fade" id="event-modal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">
                            Event
                        </h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="event-index" value="">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="min-date" class="col-sm-4 control-label">Name</label>
                                <div class="col-sm-7">
                                    <input name="event-name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="min-date" class="col-sm-4 control-label">Location</label>
                                <div class="col-sm-7">
                                    <input name="event-location" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="min-date" class="col-sm-4 control-label">Dates</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-daterange" data-provide="datepicker">
                                        <input name="event-start-date" type="text" class="form-control" value="2012-04-05">
                                        <span class="input-group-addon">to</span>
                                        <input name="event-end-date" type="text" class="form-control" value="2012-04-19">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="save-event">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>


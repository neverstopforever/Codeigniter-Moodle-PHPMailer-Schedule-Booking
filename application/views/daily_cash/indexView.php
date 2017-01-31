<div class="page-container prostpects_page quotes">
    <div class="table_loading"></div>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_administrative'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('menu_daily_cash'); ?>
                </li>
            </ul>
           <div class="tabs_container">
                <div class="card dailyCashTable_section">
                    <div class="text-right">
                        <button type="button" id="quick_tips" class="btn btn-xs green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('show_quick_tips'); ?></span> <i class="fa fa-angle-down fa-angledown"></i></button>
                    </div>
                    <div class="quick_tips_sidebar margin-top-20">
                        <div class=" note note-info quick_tips_content">
                            <h2><?php echo $this->lang->line('quick_box_title'); ?></h2>
                            <p><?php echo $this->lang->line('daily_cash_quick_tips_text'); ?> 
                                <strong><a href="<?php echo $this->lang->line('daily_cash_quick_tips_link'); ?>" target="_blank"><?php echo $this->lang->line('daily_cash_quick_tips_link_text'); ?></a></strong>
                            </p>
                        </div>
                    </div>
                    <div class="row tab-content_prospect">
                        <div class="col-md-12">

                            <div id="dailyCashTable_no" class="no_data_table">

                            </div>
                           
                            <div id="dailyCashTable">

                            </div>
                            <div id="openCashSection" style="display: none"></div>

                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
<div id="addNewModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cash_new_daily_cash"); ?> </h4>
            </div>
            <form id="add_new_cash_form"  name="add_new_cash_form" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("date"); ?>: </lable>
                        <span><strong><?php echo date($datepicker_format); ?></strong></span>
                    </div>
                    <div class="form-group">
                        <lable for="doc_type"><?php echo $this->lang->line("title"); ?>: </lable>
                        <input type="text" name="title" class="form-control" />
                    </div>
                    <div class="form-group">
                        <lable for="role"><?php echo $this->lang->line("cash_started_balance"); ?>: </lable>
                        <input type="text" name="started_balance" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel"); ?> </button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("add"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editCashModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cash_edit_daily_cash"); ?> </h4>
            </div>
            <form id="edit_cash_form"  name="edit_cash_form" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <lable>ID: </lable>
                        <span class="cash_id"></span>
                        <input type="hidden" name="cash_id_hidden" />
                        <input type="hidden" name="cash_state_hidden" />
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("date"); ?>: </lable>
                        <span class="cash_date"></span>
                    </div>
                    <div class="form-group">
                        <lable for="doc_type"><?php echo $this->lang->line("title"); ?>: </lable>
                        <input type="text" name="title" class="form-control" />
                    </div>
                    <div class="form-group">
                        <lable for="role"><?php echo $this->lang->line("cash_started_balance"); ?>: </lable>
                        <input type="text" name="started_balance" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <lable for="role"><?php echo $this->lang->line("state"); ?>: </lable>
                        <input type="checkbox" name="state" id="state_checkbox" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel"); ?> </button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("edit"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="DeleteCashModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("cash_delete"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line("cash_confirm_delete"); ?></p>
            </div>
            <div class="modal-footer">
                <?php echo $this->lang->line('deletae_question'); ?>
                <button class="btn  btn-danger" data-dismiss="modal"><?php echo $this->lang->line("no"); ?></button>
                <button class="btn btn-success delete_cash_modal" data-task="delete_cash"><?php echo $this->lang->line("yes"); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="closeCashModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"> <?php echo $this->lang->line("cash_close"); ?> </h2>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line("cash_confirm_close"); ?></p>
            </div>
            <div class="modal-footer">
                <button class="btn  btn-danger" data-dismiss="modal"><?php echo $this->lang->line("no"); ?></button>
                <button class="btn btn-success close_cash_modal" data-task="delete_cash"><?php echo $this->lang->line("yes"); ?></button>
            </div>
        </div>
    </div>
</div>


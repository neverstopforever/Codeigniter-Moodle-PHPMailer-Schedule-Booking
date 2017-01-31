<?php
if($this->data['lang'] == "spanish"){
    setlocale(LC_MONETARY, 'es_ES.utf8');
}else{
    setlocale(LC_MONETARY, 'en_GB.utf8');
}
?>
<div >
    <div class="edit_daily_cash_section">
        <div class="text-center">
            <h2><?php echo $this->lang->line('cash_edit_daily_cash') ?></h2>
        </div>
        <div class="group">
           <p>ID:
            <strong><span class="cash_id"><?php echo $cash_id; ?></span></strong></p>
        </div>
        <div class="group">
            <p><?php echo $this->lang->line("title"); ?>:
            <strong><span class="title"><?php echo $cash_name; ?></span></strong></p>
        </div>
        <div class="group">
            <p><?php echo $this->lang->line("cash_started_balance"); ?>:
            <strong><span class="tistarted_balancetle"><?php echo money_format('%!n', round($started_balance, 3)); ?></span></strong></p>
        </div>
        <div class="group">
            <p><?php echo $this->lang->line("state"); ?>:
            <strong>
                <?php if($state == '0'){ ?>
                    <span class="label label-sm label-success"><?php echo $this->lang->line('cash_opened'); ?></span>
                <?php }elseif($state == '1'){ ?>
                    <span class="label label-sm label-default" style="color: white"><?php echo $this->lang->line('cash_closed'); ?></span>
                <?php } ?>
            </strong></p>
        </div>
        <div class="group">
            <p><?php echo $this->lang->line("cash_current_balance"); ?>:
                <strong><span class="current_balance"><?php echo money_format('%!n', round($current_balance->amount, 3)); ?></span></strong></p>
        </div>
        <div class="group">
            <?php if($state == '1' && isset($end_balance->last_end_balance)){ ?>
            <p><?php echo $this->lang->line("cash_end_balance"); ?>:
                <strong> <span class="end_balance"> <?php echo money_format('%!n', round($end_balance->last_end_balance, 3)); ?></span></strong>
            <?php } ?>
        </div>
    </div>
    
    <div id="openCashTable">
        
    </div>

<!--    <div class="group">-->
<!--        <lable>--><?php //echo $this->lang->line("date"); ?><!--: </lable>-->
<!--        <span class="cash_date"></span>-->
<!--    </div>-->
    
</div>


<div id="DeleteOpenCashModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("open_cash_delete"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line("open_cash_confirm_delete"); ?></p>
            </div>
            <div class="modal-footer">
                <?php echo $this->lang->line('open_cash_deletae_question'); ?>
                <button class="btn " data-dismiss="modal"><?php echo $this->lang->line("no"); ?></button>
                <button class="btn btn-danger  delete_open_cash_modal" data-task="delete_cash"><?php echo $this->lang->line("yes"); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="addIncomeExpense" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> </h4>
            </div>
            <form id="add_new_income_expense_form"name="add_new_income_expense_form" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                    <input type="hidden" name="quote_type" />
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="cash_id" />
                    </div>
                    <div class="form-group">
                        <lable for="doc_type"><?php echo $this->lang->line("description"); ?>: </lable>
                        <input type="text" name="description" class="form-control" />
                    </div>
                    <div class="form-group">
                        <lable for="role"><?php echo $this->lang->line("amount"); ?>: </lable>
                        <input type="text" name="amount" class="form-control"/>
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


<div id="editIncomeExpense" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("edit"); ?> </h4>
            </div>
            <form id="edit_income_expense"  name="edit_income_expense" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="quote_type" />
                    <input type="hidden" name="cash_id" />
                    <div class="form-group">
                        <lable>ID: </lable>
                        <span class="income_expense_id"></span>
                        <input type="hidden" name="income_expense_id_hidden" />
                    </div>
                    <div class="form-group">
                        <lable><?php echo $this->lang->line("description"); ?>: </lable>
                        <input type="text" name="description" class="form-control" />
                    </div>
                    <div class="form-group">
                        <lable for="role"><?php echo $this->lang->line("amount"); ?>: </lable>
                        <input type="text" name="amount" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel"); ?> </button>
                    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("cash_edit"); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    var _related_qoutes_data = <?php echo json_encode($related_qoutes_data); ?>;
    var _state = parseInt(<?php echo $state; ?>);
    var _cash_id = parseInt(<?php echo $cash_id; ?>);
</script>
<script src="<?php echo base_url(); ?>app/js/daily_cash/partials/open_cash.js"></script>


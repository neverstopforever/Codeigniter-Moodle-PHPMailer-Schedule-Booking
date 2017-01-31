<div id="addFromRatesModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $this->lang->line("quotes_add_from_rates"); ?> </h4>
            </div>
            <form id="add_from_rates_form" class="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                <input type="hidden" name="student_id" value="<?php echo @$student_id;?>" />
                <input type="hidden" name="enroll_id" value="<?php echo @$enroll_id;?>" />

                    <div class="form-group  no_edit">
                        <label><?php echo $this->lang->line('rates_select_a_rate'); ?></label>
                        <select class="form-control" name="select_rates">
                            <option value="">--<?php echo $this->lang->line('rates_select_rate'); ?>--</option>
                            <?php if(!empty($rates)){ ?>
                                <?php foreach($rates as  $rate){ ?>
                                    <option value="<?php echo $rate->id ?>"><?php echo $rate->name; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <hr/>
                    <div class="form-group ">
                        <div id="feesTable"></div>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?> </button>
                    <button type="submit" disabled="disabled" class="btn btn-primary add_from_rates_btn"><?php echo $this->lang->line("_insert"); ?> </button>
                </div>
        </div>
        </form>
    </div>
</div>
<!--<script src="--><?php //echo base_url(); ?><!--app/js/enrollments/partials/add_from_rates.js"></script>-->
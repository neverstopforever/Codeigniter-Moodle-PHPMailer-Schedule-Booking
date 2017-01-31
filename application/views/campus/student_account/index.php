<div class="page-container ">
    <div class="page-content">
        <div class="page-head">
            <div class="<?php echo $layoutClass ?>">
                <div class="page-title">
                    <h1><?php echo $this->lang->line('menu_information'); ?></h1>
                </div>
            </div>
        </div>
        <div class="<?php echo $layoutClass ?>">
            <ul class=" page-breadcrumb breadcrumb">
            <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
            <li class="active"><?php echo $this->lang->line('menu_account'); ?></li>
        </ul>
            <div class="manage_invoices_index">

                <div class="portlet  light">
                    <div class="portlet-body">
                        <div class="text-right quick_tip_wrapper">
                            <a href="http://blog.akaud.com" target="_blank" type="button" class="btn btn-xs quick_tip green-meadow "> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="button_text"><?php echo $this->lang->line('quick_tip');?></span> </a>
                        </div>
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab" aria-expanded="true"> <?php echo strtoupper($this->lang->line('student_invoices')); ?> </a>
                                </li>
                                <li class="">
                                    <a href="#tab_2" data-toggle="tab" aria-expanded="true"> <?php echo strtoupper($this->lang->line('student_quotes')); ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="invoices_table_no_data_table">

                                    </div>
                                    <div id="invoicesTable">

                                    </div>

                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="quotes_table_no_data_table">

                                    </div>
                                    <div id="quotesTable">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
        </div>
    </div>
</div>

<script>
    var _invoices = <?php echo json_encode($invoices); ?>;
    var _quotes = <?php echo json_encode($quotes); ?>;
</script>
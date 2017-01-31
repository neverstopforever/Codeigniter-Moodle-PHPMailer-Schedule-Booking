<div class="page-container">
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_information'); ?></h1>
            </div>
        </div>
    </div>
    <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
        <li><a href="#"><?= $this->lang->line('menu_Home') ?></a></li>
        <li class="active"><?php echo $this->lang->line('my_report'); ?></li>
    </ul>
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('campus_student_repo_information') ?>:
                                    <select id="LstinformesprefesorId" name="lstinformesprefesorId"
                                            class="form-control"/>
                                    <option>--<?php echo $this->lang->line('campus_student_select_information') ?>--</option>
                                    <?php foreach ($lst_inform_student as $list){ ?>
                                        <option
                                            value="<?php echo $list->id; ?>"><?php echo $list->title; ?></option>
                                    <?php } ?>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="tabledata">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var jData = [];
    var lstreporttableContents = [], lstprefesorTable, responseData, table;
</script>

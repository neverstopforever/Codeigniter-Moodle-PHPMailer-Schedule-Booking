<div class="page-container">
    <div class="page-head">
        <div class="<?php echo $layoutClass ?>">
            <div class="page-title">
                <h1><?php echo $this->lang->line('menu_information'); ?></h1>
            </div>
        </div>
    </div>

    <div class="page-content">
        <ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
            </li>
            <li>
                <a href="javascript:;"><?php echo $this->lang->line('option'); ?></a>
            </li>
            <li class="active"><?php echo $this->lang->line('my_document'); ?></li>
        </ul>
        <div class="<?php echo $layoutClass ?>">
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Informes:
                                    <select id="LstinformesprefesorId" name="lstinformesprefesorId"
                                            class="form-control"/>
                                    <option>--Seleccione Informe--</option>
                                    <?php foreach ($lstinformprofesr as $list): ?>
                                        <option value="<?php echo $list['id']; ?>"><?php echo $list['titulo']; ?></option>
                                    <?php endforeach; ?>
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

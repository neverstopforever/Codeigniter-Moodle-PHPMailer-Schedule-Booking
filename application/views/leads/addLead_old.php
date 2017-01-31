<html>

    <head>
        <?php $this->load->view("includes/head"); ?>
        <style>
            .dataTables_wrapper {
                width: 100%;
                overflow: auto;
            }
        </style>
        
    </head>

    <body>
        <?php
        $this->load->view("includes/header");
        ?>
        <div class="page-container">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <div class="<?php echo $layoutClass ?>">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1><?php echo $this->lang->line('menu_clientes'); ?></h1>
                    </div>
                    <!-- END PAGE TITLE -->
                </div>
                <div class="page-content">
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="<?php echo $layoutClass ?>">
                        <div class="portlet light">
                            <div class="portlet-body">
                                <div class="col-md-12">
                                    <a href="<?php echo base_url() ?>clientes" class="btn btn-success pull-right">&times;</a>
                                </div>
                                <div class="wizard-container">
                                    <div class="card wizard-card ct-wizard-orange" id="wizardProfile">
                                        <div role="tabpanel" class="tab-pane active" id="datos-comerciales">
                                            <?php if (isset($flashMsg) && $flashMsg != "") { ?>
                                                <div class="tab temp" id="flashMsg" style="width: 100%; float: left; background-color: #e5efff;height: 40px; margin: 20px 0 0 0;">
                                                    <div class="col-md-12" style="float: left; padding: 11px 0 0 12px; color: green;">
                                                        <strong><?php echo $flashMsg; ?></strong>
                                                        <a style="float: right; margin-right: 10px; color: #f1353d;" href="javascript:void()" onclick="hideFlashMsg();"><strong>X</strong></a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                                            <div class="wizard-header">
                                                <h3>
                                                    <?php echo $this->lang->line('clientes_addSmallTitle'); ?>
                                                </h3>
                                            </div>
                                            <div class="leadsCheckDiv">
                                                <div>
                                                    <input type="radio" value="newAdd" name="leadsCheck" onclick="showRealtedForm('newAdd');" /> Add a blank lead
                                                </div>
                                                <div>
                                                    <input type="radio" value="currentUser" name="leadsCheck" onclick="showRealtedForm('currentUser');"  /> Add a Lead and copy data from existing user
                                                </div>
                                            </div>
                                            <div style="display: block; margin-top: 20px;" class="displayForm" id="currentUser"></div>
                                            <div style="display: none; margin-top: 20px;" class="displayForm" id="newAdd">
                                                <form class="clientes_add_form" action="<?= base_url() ?>LeadsView/addLeadsRecords" method="POST">
                                                    <ul>
                                                        <li><a data-toggle="tab"><?php echo $this->lang->line('clientes_datosComerciales'); ?></a></li>
                                                    </ul>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('form_ccodcli'); ?>
                                                                <input type="text" class="form-control" name="NumPresupuestoDis" id="numpresupuesto" disabled value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('first_name') ?>
                                                                <input type="text" class="form-control" name="sNombre" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('sur_name') ?>
                                                                <input type="text" class="form-control" name="sApellidos" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('full_name') ?>
                                                                <input type="text" class="form-control" name="" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('city') ?>
                                                                <input type="text" class="form-control" name="Poblacion" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('province') ?>
                                                                <input type="text" class="form-control" name="Provincia" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('adress') ?>
                                                                <textarea type="text" class="form-control" name="domicilio" style="min-height:100px;"></textarea>
                                                                <!--<input type="text" class="form-control" name="domicilio" value="<?php // echo  $content[0]->domicilio;                     ?>" />-->
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('birthday') ?>
                                                                <input type="text" class="form-control datepicker" name="Nacimiento"  value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('country') ?>
                                                                <input type="text" class="form-control" name="pais" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('sex') ?>
                                                                <select name="idsexo">
                                                                    <option value="1">
                                                                        <?php echo $this->lang->line('male') ?>
                                                                    </option>
                                                                    <option value="2" >
                                                                        <?php echo $this->lang->line('female') ?>
                                                                    </option>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('phone1') ?>
                                                                <input type="text" class="form-control" name="Telefono" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('phone2') ?>
                                                                <input type="text" class="form-control" name="Telefono2" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('mobile') ?>
                                                                <input type="text" class="form-control" name="Movil" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('passport') ?>
                                                                <input type="text" class="form-control" name="CDNICIF" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('email1') ?>
                                                                <input type="email" class="form-control" name="email" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('email2') ?>
                                                                <input type="email" class="form-control" name="email2" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('fax') ?>
                                                                <input type="number" class="form-control" name="Fax" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('IBAN') ?>
                                                                <input type="text" class="form-control" name="iban" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('bank') ?>
                                                                <input type="text" class="form-control" name="cc1" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="text" class="form-control" name="cc2" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="text" class="form-control" name="cc3" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="text" class="form-control" name="cc4" value="" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 company_select" style="display: none;">
                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line('comp_id') ?>
                                                                <input readonly type="text" class="form-control" name="facturara" value="" />
                                                            </label>
                                                        </div>
                                                        <a href="javascript:;" class="select_company contactos_btn btn-success "><i class="fa fa-edit"></i></a><span class="company_name"></span>
                                                    </div>
                                                    <div class="col-md-12 wizard-footer">
                                                        <div class="pull-right">
                                                            <input type="hidden" name="NumPresupuesto" id="NumPresupuestoHidden" value="0" />
                                                            <button class="btn btn-success " type="submit">
                                                                <?php echo $this->lang->line('clientes_updateBtn'); ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contactos_linkpopup">
                <div class="close_me">
                    <i class="fa fa-cross"></i>
                </div>
                <table class="clientes table  table-striped table-hover table-bordered ">
                </table>
            </div>
            <div class=""></div>
            <?php
            $this->load->view("includes/footer");
            ?>
            <script type="text/javascript">
                function hideFlashMsg() {
                    $("#flashMsg").hide("slow");
                }
                function showRealtedForm(relatedId) {
                    $(".displayForm").hide();
                    if (relatedId == "newAdd") {
                        var formData = {
                            leadsCheck: relatedId
                        };
                        $.ajax({
                            url: base_url + 'LeadsView/getIncreasedValue',
                            method: 'post',
                            data: formData,
                            success: function (response) {
                                if (response) {
                                    $("#" + relatedId).show();
                                    $(".wizard-footer").show();
                                    $(".leadsCheckDiv").hide();
                                    $("#numpresupuesto").val(response);
                                    $("#NumPresupuestoHidden").val(response);
                                }
                            }
                        });
                    } else if (relatedId == "currentUser") {
                        $("#" + relatedId).show();
                        $("#" + relatedId).html("<img src='<?= base_url() ?>assets/img/loading.gif' style='width: 30px;' />");
                        var formData = {
                            leadsCheck: relatedId
                        };
                        $.ajax({
                            url: base_url + 'LeadsView/getCopyUsers',
                            method: 'post',
                            data: formData,
                            success: function (response) {
                                if (response) {
                                    $(".leadsCheckDiv").hide();
                                    $("#" + relatedId).html(response);
                                }
                            }
                        });
                    }
                }
                $(document).ready(function () {
                    $('.datepicker').datepicker({});
                    $('.select_company').on('click', function (r) {
                        $('.contactos_linkpopup').show();
                        var body = $("html, body");
                        body.stop().animate({
                            scrollTop: 0
                        }, '500', 'swing', function () {
                            // alert("Finished animating");
                        });
                        $('.contactos_linkpopup').find('table tr').find('.select').on('click', function (e) {
                            var row = $(this).parents('tr'),
                                    table = $('.contactos_linkpopup').find('table').data('table');
                            rowData = table.fnGetData(row);
                            console.log(rowData);
                            $('input[name="facturara"]').val(rowData.id);
                            $('.company_name').text(rowData["<?php echo $this->lang->line('colcompanyname'); ?>"]);
                            $('.contactos_linkpopup').hide();
                            body.stop().animate({
                                scrollTop: $('input[name="facturara"]').offset().top
                            }, '500', 'swing', function () {
                                // alert("Finished animating");
                            });
                        });
                    });
                });
            </script>
            <script type="text/javascript">
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
                app.header.init();
                var clienteId = <?php echo $clienteId; ?>;


                //            $('.clientes_add_form').on('submit', function (e) {
                //                e.preventDefault();
                //                var formData = $(this).serialize();
                //                $.ajax({
                //                    url: base_url + '/clientes/datos_comerciales_add/' + clienteId,
                //                    method: 'post',
                //                    data: formData,
                //                    success: function (response) {
                //                        if (response) {
                //                            window.location = base_url + 'clientes/';
                //                        }
                //                    }
                //                })
                //            });

            </script>
        </div>
    </body>

</html>

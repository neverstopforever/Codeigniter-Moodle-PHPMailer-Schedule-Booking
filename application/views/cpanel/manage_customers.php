<div class="page-container customer_accounts">

        <div class="table_loading"></div>
        <div class="page-content">
            <div class="<?php echo $layoutClass ?>">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="/"><?php echo $this->lang->line('menu_Home'); ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo $this->lang->line('menu_customers'); ?></a>
                    </li>
                    <li class="active">
                        <?php echo $this->lang->line('cpanel_customer_accounts'); ?>
                    </li>
                </ul>
                <div class="portlet light">
                        <div id="customers_table" class="">

                        </div>
                 <div class="clearfix"></div>
                </div>
                <!-- BEGIN PAGE CONTENT INNER -->
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
</div>

<div class="modal fade" id="deleteCustomerModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p><?php echo $this->lang->line('confirmDelete'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                <button type="button" class="btn btn-danger delete_customer"><?php echo $this->lang->line('delete');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_customer" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel">
    <div class="modal-dialog" role="modal_customer">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('close'); ?>"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="customerModalLabel"> <?php echo $this->lang->line('cpanel_add_customer'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'groups'
                            ); ?>
                        </label>
                        <select name="idgrupo" id="idgrupo" class="form-control">
                            <?php foreach ($groups as $group) {?>
                                <option value="<?php echo $group->IdGrupo; ?>"><?php echo $group->Grupo; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_commercial_name'
                            ); ?>
                        </label>
<!--                        cnomcom-->
                        <input type="text" class="form-control" id="commercial_name" name="commercial_name"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_fiscal_name'
                            ); ?>
                        </label>
<!--                        cnomcli-->
                        <input type="text" class="form-control" id="fiscal_name" name="fiscal_name"/>
                    </div>
                    <hr />

                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_country'
                            ); ?>
                        </label>
                        <!--cnaccli-->
                        <input type="text" class="form-control" id="country" name="country"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_address'
                            ); ?>
                        </label>
<!--                        cdomicilio-->
                        <input type="text" class="form-control" id="address" name="address"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_city'
                            ); ?>
                        </label>
                        <!--                        cpobcli-->
                        <input type="text" class="form-control" id="city" name="city"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_province'
                            ); ?>
                        </label>
<!--                        cprovincia-->
                        <input type="text" class="form-control" id="province" name="province"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_zip_code'
                            ); ?>
                        </label>
                        <!--                        cptlcli-->
                        <input type="text" class="form-control" id="zip_code" name="zip_code"/>
                    </div>

                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_fiscal_code'
                            ); ?>
                        </label>
                        <!--cdnicif -->
                        <input type="text" class="form-control" id="fiscal_code" name="fiscal_code"/>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_phone1'
                            ); ?>
                        </label>
<!--                        ctfo1cli-->
                        <input type="text" class="form-control" id="phone1" name="phone1"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_phone2'
                            ); ?>
                        </label>
<!--                        ctfo2cli-->
                        <input type="text" class="form-control" id="phone2" name="phone2"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_contact'
                            ); ?>
                        </label>
<!--                        ccontacto-->
                        <input type="text" class="form-control" id="contact" name="contact"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_email'
                            ); ?>
                        </label>
<!--                        email-->
                        <input type="text" class="form-control" id="email" name="email"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_web'
                            ); ?>
                        </label>
<!--                        web-->
                        <input type="text" class="form-control" id="web" name="web"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_active'
                            ); ?>
                        </label>
<!--                        activo-->
                        <select name="state" id="state" class="form-control">
                            <option value="0"><?php echo $this->lang->line('no');?></option>
                            <option value="1"><?php echo $this->lang->line('yes');?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_ipserver'
                            ); ?>
                        </label>
                        <!--ipservidor-->
                        <input type="text" class="form-control" id="ipserver" name="ipserver"/>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_login'
                            ); ?>
                        </label>
                        <!--login-->
                        <input type="text" class="form-control" id="login" name="login"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_password'
                            ); ?>
                        </label>
                        <!--pwd-->
                        <input type="password" class="form-control" id="password" name="password"/>
                    </div>
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line(
                                'cpanel_confirm_password'
                            ); ?>
                        </label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                        <?php echo $this->lang->line('close'); ?>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var _customers = <?php echo isset($customers) ? json_encode($customers) : json_encode(array()); ?>;
</script>

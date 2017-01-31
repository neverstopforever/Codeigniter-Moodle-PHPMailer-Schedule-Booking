<div class="back_save_group add_prospect_back">
    <a href="<?php echo base_url('prospects'); ?>" class="btn btn-circle btn-default-back"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back');?> </a>
</div>
<table id="tt" class="display table table-condensed dbtable_hover_theme dataTable no-footer" cellspacing="0" width="100%">
    <thead>
    <tr>

        <th><?php echo $this->lang->line('leads_id');?></th>
        <th><?php echo $this->lang->line('leads_profile_id');?></th>
        <th><?php echo $this->lang->line('leads_surname');?></th>
        <th><?php echo $this->lang->line('leads_name');?></th>
        <th><?php echo $this->lang->line('leads_email');?></th>
<!--        <th>--><?php //echo $this->lang->line('leads_profile');?><!--</th>-->
        <th><?php echo $this->lang->line('action');?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $k=>$user){ ?>

        <tr>
            <td><?php echo $user['id'];?></td>
            <td><?php echo $user['Profileid'];?></td>
            <td><?php echo $user['Apellidos'];?></td>
            <td><?php echo $user['Nombre'];?></td>
            <td><?php echo $user['Email'];?></td>
<!--            <td>--><?php //echo $user['Perfil'];?><!--</td>-->
            <td><a class="contactos_btn " href="<?php echo base_url();?>leads/addExistUser/<?php echo $user['id'];?>/<?php echo $user['Profileid'];?>"> <i class="fa fa-home fa-files-o fa-2x "></i> <?php echo $this->lang->line('select');?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tt').dataTable({
            "sDom": "<'table_feature_top'> <'row margin-bottom-10'  <'col-xs-6 datatable_search_input 'f> <'col-xs-6 text-right table_buttons'B>><'ze_wrapper't><'row margin-top-20 units_section'<'col-xs-6'l><'col-xs-6'p> >",
            //"sDom": "<'row'<'col-xs-12 col-sm-4 'f><'col-x-12 col-sm-8 btn-group text-right export_option 'B><'add_prospects_and_actions'>><'ze_wrapper margin-top-20 't><'row margin-top-20'<'col-xs-6 units 'l><'col-xs-6'p>>",
            buttons: [

                {
                    extend: 'collection',
                    text: '<i class="fa fa-cog"></i>  ' + language.classroom_export_options + '  <i class="fa fa-angle-down"></i>',
                    className: 'dt_buttons_drop btn-circle margin-bottom-0 ',

                    buttons: [
                        {
                            extend:    'copyHtml5',
                            text:      '<i class="fa fa-files-o"></i> Copy',
                            exportOptions: {
                                columns: [  0, 1, 2, 3, 4, 5 ]
                            },
                            title: language.prospects_list_of_wizard_profile,
                            titleAttr: 'Copy'
                        },
                        {
                            extend:    'excelHtml5',
                            text:      '<i class="fa fa-file-excel-o"></i> Excel',
                            exportOptions: {
                                columns: [  0, 1, 2, 3, 4, 5 ]
                            },
                            title: language.prospects_list_of_wizard_profile,
                            titleAttr: 'Excel'
                        },
                        {
                            extend:    'csvHtml5',
                            text:      '<i class="fa fa-file-text-o"></i> CSV',
                            exportOptions: {
                                columns: [  0, 1, 2, 3, 4, 5 ]
                            },
                            title: language.prospects_list_of_wizard_profile,
                            titleAttr: 'CSV'
                        },
                        {
                            extend:    'pdfHtml5',
                            text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                            exportOptions: {
                                columns: [  0, 1, 2, 3, 4, 5 ]
                            },
                            title: language.prospects_list_of_wizard_profile,
                            titleAttr: 'PDF'
                        },
                        {
                            extend:    'print',
                            text:      '<i class="fa fa-print"></i> Print',
                            exportOptions: {
                                columns: [  0, 1, 2, 3, 4, 5 ]
                            },
                            title: language.prospects_list_of_wizard_profile,
                            customize: function ( win ) {
                                $(win.document.body)
                                    .css( 'font-size', '10pt' )

                                $(win.document.body).find( 'h1' )
                                    .css( 'margin-bottom', '20px' );


                                $(win.document.body).find( 'table' )
                                    .css( 'font-size', 'inherit' );
                            },
                            titleAttr: 'Print'
                        }
                    ],
                    fade: true
                }
            ],

            "sPaginationType": "simple_numbers",

            'bAutoWidth': false,
            "language": {
                "url": base_url + "app/lang/" + lang + '.json'
            },
            "columnDefs": [{
                "targets": [0, 1],
                "visible": false
            }],
            select: true,
        });
    });

</script>


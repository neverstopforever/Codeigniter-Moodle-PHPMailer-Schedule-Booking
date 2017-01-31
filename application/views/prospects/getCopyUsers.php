<table id="tt" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th><?php echo $this->lang->line('leads_select');?></th>
        <th><?php echo $this->lang->line('leads_id');?></th>
        <th><?php echo $this->lang->line('leads_profile_id');?></th>
        <th><?php echo $this->lang->line('leads_surname');?></th>
        <th><?php echo $this->lang->line('leads_name');?></th>
        <th><?php echo $this->lang->line('leads_email');?></th>
        <th><?php echo $this->lang->line('leads_profile');?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $k=>$user){ ?>
        <tr>
            <td><a class="contactos_btn btn-success" href="<?php echo base_url();?>leads/addExistUser/<?php echo $user['id'];?>/<?php echo $user['Profileid'];?>"><?php echo $user['select'];?></a></td>
            <td><?php echo $user['id'];?></td>
            <td><?php echo $user['Profileid'];?></td>
            <td><?php echo $user['Apellidos'];?></td>
            <td><?php echo $user['Nombre'];?></td>
            <td><?php echo $user['Email'];?></td>
            <td><?php echo $user['Perfil'];?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tt').dataTable({
            "language": {
                "url": base_url + "app/lang/" + lang + '.json'
            }
        });
    });
</script>


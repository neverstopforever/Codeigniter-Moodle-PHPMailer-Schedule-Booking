<div id="historic_accounts_table" class="student_documents_table">

</div>

<script>
       var _historic_accounts = <?php echo isset($historic_accounts) ? json_encode($historic_accounts) : json_encode(array()); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/historic_accounts.js"></script>

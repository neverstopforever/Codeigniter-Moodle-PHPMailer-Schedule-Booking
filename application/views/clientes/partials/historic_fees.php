<div id="historic_fees_table" class="student_documents_table">

</div>

<script>
       var _historic_fees = <?php echo isset($historic_fees) ? json_encode($historic_fees) : json_encode(array()); ?>;
</script>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/historic_fees.js"></script>

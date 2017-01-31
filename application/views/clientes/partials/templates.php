<form id="template-form" action="<?php echo base_url() ?>templates/printTemplate"
      method="post">
    <div class="col-md-12 form-group">
        <div class="col-md-3">
            <?php echo $this->lang->line('clientes_documentos');?>
        </div>
        <div class="col-md-9">
            <select name="templateId">
                <option value=""><?php echo $this->lang->line('clientes_select_documents');?></option>
                <?php foreach ($document_cat as $doc) { ?>
                    <option
                        value="<?= $doc->id ?>"><?= $doc->DocAsociado ?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="lead_client_id" value="<?php echo $client_id; ?>"/>
            <input type="hidden" name="id_cat" value="<?php echo $id_cat; ?>"/>
            <input type="hidden" name="cat_type" value="clientes"/>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pull-right">
            <button type="submit" id="print44" class="btn btn-success">
                <?php echo $this->lang->line('print');?>
            </button>
        </div>
    </div>
</form>
<script src="<?php echo base_url(); ?>app/js/clientes/partials/historic_fees.js"></script>

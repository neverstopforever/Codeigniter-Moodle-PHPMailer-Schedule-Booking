<form id="template-form" action="<?php echo base_url() ?>templates/printTemplate"
      method="post">
    <div class="col-sm-6 circle_select_div margin-top-10">
        <lable class="lable text-left">
            <?php echo $this->lang->line('companies_documentos');?>
        </lable>

            <select class="form-control" name="templateId">
                <option value=""><?php echo $this->lang->line('companies_select_documents');?></option>
                <?php foreach ($document_cat as $doc) { ?>
                    <option
                        value="<?= $doc->id ?>"><?= $doc->DocAsociado ?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="lead_client_id" value="<?php echo $client_id; ?>"/>
            <input type="hidden" name="id_cat" value="<?php echo $id_cat; ?>"/>
            <input type="hidden" name="cat_type" value="clientes"/>

    </div>
    <div class="col-sm-6">

            <button type="submit" id="print44" class="btn btn-default tamplate_print  btn-default btn-circle">
                <i class="fa fa-print"></i>
                <?php echo $this->lang->line('print');?>
            </button>

    </div>
</form>
<script src="<?php echo base_url(); ?>app/js/companies/partials/templates.js"></script>

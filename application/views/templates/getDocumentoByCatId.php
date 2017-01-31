<select name="templateId" style="width: 100%; height: 34px;">
    <?php foreach ($documents as $document) { ?>
        <option value="<?= $document->id ?>"><?= $document->DocAsociado ?></option>
    <?php } ?>
</select>
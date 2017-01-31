<form method="POST" class="form-horizontal col-md-9" enctype="multipart/form-data">
    <div class="col-md-12">
        <div class="form-group text-left">
            <div class="col-md-3">
                <label >
                    <?php echo $this->lang->line('groups_reference'); ?>:
                </label>
            </div>
            <div class="col-md-3">
                <input  type="text" class="form-control " value="<?php echo set_value('reference', (isset($group->reference) ? $group->reference : '')); ?>"  name="reference"  />

            </div>
            <div class="col-md-2">
                <label >
                    <?php echo $this->lang->line('color'); ?>:
                </label>
            </div>
            <div class="col-md-4">
                <input  type="text" class="form-control " value="<?php echo set_value('color', (isset($group->color) ? $group->color : '')); ?>"  name="color"  />
            </div>
        </div>
        <div class="form-group text-left">
            <div class="col-md-3">
                <label >
                    <?php echo $this->lang->line('groups_name'); ?>:
                </label>
            </div>
            <div class="col-md-6">
                <input  type="text" class="form-control " value="<?php echo set_value('group_name', (isset($group->group_name) ? $group->group_name : '')); ?>"  name="group_name"  />

            </div>
        </div>
        <div class="form-group text-left">
            <div class="col-md-3">
                <label >
                    <?php echo $this->lang->line('groups_name'); ?>:
                </label>
            </div>
            <div class="col-md-6">
                <input  type="text" class="form-control " value="<?php echo set_value('group_name', (isset($group->group_name) ? $group->group_name : '')); ?>"  name="group_name"  />

            </div>
        </div>
    </div>
</form>
<div class="page-container template_edit_page">
                <div class="table_loading"></div>
				<div class="page-content">
<div class="<?php echo $layoutClass ?>">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $_base_url; ?>templates"><?php echo $this->lang->line('menu_plantillas'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo $this->lang->line('edit'); ?>
                            </li>
                        </ul>
						<div class="portlet light">
						<?php $filename = $this->uri->segment(3);?>
						<form id="template-form" class="col-md-9 pull-left" action="<?php echo  base_url()."Templates/pdfprint/".$filename.""?>" method="post" enctype="multipart/form-data">
							<div class="col-md-9">
							<label for="email">First Name:</label>
								<input type="text" class="form-control col-xs-4" name="firstname" placeholder="First Name">
							</div>
							<div class="col-md-9">
							<label for="pwd">Last Name:</label>
								<input type="text" class="form-control col-xs-4" name="lastname" placeholder="Last Name">
							</div>
							<div class="col-md-9">
							<label for="pwd">Email:</label>
								<input type="text" class="form-control col-xs-4" name="email" placeholder="Email Address">
							</div><br/>
							<div class="col-md-9">
								<button type="submit" class="btn btn-success">Submit</button>
							</div>
						</form>
						</div>
			</div>
		</div>
</div>
<link href="<?php echo base_url() ?>app/css/style.css" rel="stylesheet" type="text/css" />
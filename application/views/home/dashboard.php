<div class="page-container">


	<div class="page-content">
		<div class="<?php echo $layoutClass ?>">
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
				</li>
				<li class="active"><?php echo $this->lang->line('dashboard'); ?></li>
			</ul>
			<div class="">
				<div class=" statistic_counts ">
					<div class="col-xs-12 col-sm-6 col-md-3">
						<a href="<?php echo $_base_url; ?>prospects">
							<div class="lead_count box_statistic text-center">
								<i class="icon_lead hidden-md"></i>
								<div class="text-left">
										<i class="icon_lead visible-md-inline "></i>
										<span  data-counter="counterup" data-value="<?php echo $leadcount;?>"><?php echo $leadcount;?></span>
										<p><?php echo $this->lang->line('Prospects'); ?></p>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3">
						<a href="<?php echo $_base_url; ?>enrollments">
							<div class="enroll_count box_statistic text-center">
								<i class="icon_enrollments hidden-md"></i>
								<div class="text-left">
									<i class="icon_enrollments visible-md-inline "></i>
									<span  data-counter="counterup" data-value="<?php echo $matriculatcount;?>"><?php echo $matriculatcount;?></span>
									<p><?php echo $this->lang->line('enrollment'); ?></p>
								</div>
							</div>
						</a>
					</div>
				<div class="col-xs-12 col-sm-6 col-md-3">
					<a href="<?php echo $_base_url; ?>courses">
						<div class="cours_count box_statistic text-center">
	<!--						<i class=" fa-3x hidden-md"></i>-->
							<i class="icon_course hidden-md"></i>
							<div class="text-left">
								<i class="icon_course visible-md-inline "></i>
								<span data-counter="counterup" data-value="<?php echo $cursocount;?>"><?php echo $cursocount;?></span>
								<p><?php echo $this->lang->line('courses'); ?></p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3">
					<a href="<?php echo $_base_url; ?>students">
						<div class="students_count box_statistic text-center ">
	<!--							<i class="fa fa-graduation-cap fa-3x hidden-md"></i>-->
									<i class="icon_students hidden-md"></i>
								<div class="text-left">
									<i class="icon_students visible-md-inline "></i>
									<span  data-counter="counterup" data-value="<?php echo $alumnoscount;?>">

										<?php
										$alumnoscount = thousandsCurrencyFormat($alumnoscount);
										echo $alumnoscount;
										?>
									</span>
									<p><?php echo $this->lang->line('student'); ?></p>
							</div>
						</div>
					</a>
				</div>
			</div>
	<div class="row">
		<div class="col-md-8 messages_dashboard">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption caption-md">
						<span class="caption-subject  bold uppercase"><?php echo $this->lang->line('message'); ?></span>
					</div>
				</div>
				<div class="portlet-body">
					<?php if(isset($inbox) && !empty($inbox)){ ?>
						<div class="scroller"  data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
							<div class="general-item-list">
								<?php
								foreach($inbox as  $item){
									$photo_url = base_url().'assets/img/dummy-image.jpg';
									if(isset($item->foto_desc)){
										if($item->foto_desc == 'blob'){
											if(!empty($item->foto)){
												$photo_url = 'data:image/jpeg;base64,'.base64_encode($item->foto);
											}
										}else if($item->foto_desc == 'link'){
											if(!empty($item->foto)){
												$photo_url = $item->foto;
											}
										}
									}
									$Maildate = $item->Maildate;

									if(isToday($Maildate)){
										$Maildate = date('H:i', strtotime($Maildate));
									}else if(isYesterday($Maildate)){
										$Maildate = $this->lang->line('yesterday');
									}else{
										$Maildate = date($datepicker_format, strtotime($Maildate));
									}
									?>
									<div class="read_message " data-message_id="<?php echo $item->id; ?>">
										<div class="row">
											<div class="col-xs-12 col-sm-2 text-center text-xs-left">
												<img src="<?php echo $photo_url; ?>" class="user_img" alt="">
											</div>
											<div class="col-xs-12 col-sm-10 ts_info_text">
												<div class="pull-right date_time_dashboard ">
													<span><?php echo $Maildate; ?></span>
												</div>
												<div class=" title title_name"><?php echo $item->Destinatario; ?></div>
												<div class="role_type_mess_send">
													<?php if($item->fromtype == 1){?>
														<?php echo $this->lang->line('teacher'); ?>
													<?php } elseif($item->fromtype == 2){ ?>
														<?php echo $this->lang->line('Student'); ?>
													<?php } elseif($item->fromtype == 0){ ?>
														<?php echo $this->lang->line('user'); ?>
													<?php } ?>

												</div>
												<div class="dashboard_message_text message_body " data-full-message="1">
													<a href="<?php echo $_base_url; ?>/Messaging">
														<?php $string = strip_tags($item->body);
														if (strlen($string) > 200) {
															// truncate string
															$stringCut = substr($string, 0, 200);
															// make sure it ends in a word so assassinate doesn't become ass...
															$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
														}
														echo $string;
														?>
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php }	?>

							</div>
							<div class=" general-item-list_fotter text-center margin-bottom-20">
								<a href="<?php echo $_base_url; ?>Messaging" class="btn btn-primary uppercase btn-circle" title="Task" ><?php echo $this->lang->line('seeallmessages'); ?> </a>
							</div>
						</div>
					<?php }else{?>
						<h3 class="no_messages_note"><?php echo $this->lang->line('dashboard_no_messages'); ?> !</h3>
						<div class="text-center margin-top-50">
							<a href="<?php echo $_base_url; ?>Messaging" class="btn btn-primary uppercase btn-circle" title="Task" ><?php echo $this->lang->line('dashboard_add_first_message'); ?> </a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 task_dashboard">
			<div class="portlet light tasks-widget ">
				<div class="portlet-title">
					<div class="caption"><i class="icon-share font-green-haze hide"></i>
						<span class="caption-subject bold uppercase"><?php echo $this->lang->line('task'); ?></span>
					</div>
				</div>
			<div class="portlet-body">
				<?php if(isset($task) && !empty($task)){ ?>
				<div class="task-content">

					<div class="scroller" data-always-visible="1" data-rail-visible1="1">
						<ul class="task-list">
						<?php foreach($task as  $list):
						$list = (array) $list;?>
							<li>
							<div class="task-title">
							<span class="task-title-sp"><?php echo $list['title'];?></span>
								<button  disabled="disabled" style="border-color:<?php echo '#'.$list['labelcolor'];?>; color:<?php echo '#'.$list['labelcolor'];?>" class="btn btn-sm btn-outline  pull-right "><?php echo $list['labeltask'];?></button>
<!--							<span class="label label-sm label-success" style="background:--><?php //echo '#'.$list['labelcolor'];?><!--">--><?php //echo $list['labeltask'];?><!--</span></div>-->
							</li>
							<?php endforeach;?>
						</ul>
					</div>

				</div>
				<div class="task-footer text-center">
					<a href="<?php echo base_url().'tasks' ?>" class="btn btn-primary btn-circle uppercase  margin-bottom-20" title="Task" target="_blank"><?php echo $this->lang->line('seealltask'); ?></a>
				</div>
				<?php }else{?>
					<h3 class="no_task_note"><?php echo $this->lang->line('dashboard_no_tasks'); ?> !</h3>
					<div class="text-center margin-top-50">
						<a href="<?php echo base_url().'tasks' ?>" class="btn btn-primary uppercase btn-circle" title="Task" ><?php echo $this->lang->line('dashboard_add_first_task'); ?> </a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	</div>
	</div>
		<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>

<div class="modal fade" id="limitOfFileSpace"  role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><?php echo $this->lang->line('please_confirm'); ?></h4>
			</div>

			<div class="modal-body">
				<h4> </h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
				<a href="<?php echo base_url('subscription-plans'); ?>" class="btn btn-success "><?php echo $this->lang->line('chage_plan'); ?></a>
			</div>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script>
	var _limit_file_space = <?php echo json_encode($limit_file_space); ?>;
	var _all_file_space = <?php echo json_encode($file_space); ?>;
</script>
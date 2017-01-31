<div class="page-container">
<div class="page-head">
	<div class="<?php echo $layoutClass ?>">
		<div class="page-title">
			<h1><?php echo $this->lang->line('menu_blog'); ?></h1>
		</div>
	</div>
</div>
<ul class="<?php echo $layoutClass ?> page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo $_base_url; ?>" ><?php echo $this->lang->line('menu_Home'); ?></a>
	</li>
	<li>
		<a href="<?php echo $_base_url; ?>advancedSettings"><?php echo $this->lang->line('menu_advanced_settings'); ?></a>
	</li>
	<li class="active"><?php echo $this->lang->line('menu_blog'); ?></li>
</ul>
<div class="table_loading"></div>
<?php $this->load->view('includes/helpTopBar'); ?>
<div class="blog-page blog-content-1 <?php echo $layoutClass ?>">
	<div class="real_blog">
	<?php foreach($posts as $list):
	$list = (array) $list;
	?>
		<div class="blog-post bordered blog-container blog_item">
			<?php if(!empty($list['post_image'])):?>
			<div class="blog-img-thumb"><a href="javascript:;">
				<img src="<?php echo base_url().'uploads/'.$list['post_image'];?>" class="post_thumbnail" /> </a>
			</div>
			<?php endif;?>
			<div class="blog-post-content">
				<h2 class="blog-title blog-post-title"><a href="<?php echo base_url().'blog/'.$list['slug'];?>"><?php echo $list['post_title'];?></a>
				</h2>
				<p class="blog-post-desc">
				<?php $fulltext = strip_tags($list['post_content']);
					echo word_limiter($fulltext,50,' [...] ');?>
				</p>
				<div class="blog-post-foot">
					<div class="blog-post-meta">
						<i class="icon-calendar font-blue"></i> 
						<span class="post_date"><?php echo $list['post_date'];?></span>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach;?>
	</div>
</div>
</div>
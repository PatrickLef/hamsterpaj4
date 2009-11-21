<li class="entertain entertain_onlinespel <?php echo $options['counter']; ?>">
	<div class="info">
		<img src="" alt="Spel" />
		<span>Idag</span>
	</div>
	<div class="content">
		<h2><?php echo $item->get('title'); ?></h2>
		<img src="<?php echo $item->preview_image('medium'); ?>" alt="<?php echo $item->get('title'); ?>"/>
	</div>
</li>
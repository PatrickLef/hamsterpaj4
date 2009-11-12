<?php foreach($groups AS $group): ?>
<h2><?php echo $group['header']; ?></h2>
<ul class="entertain_preview_list">
	<?php foreach($group['items'] AS $item) : ?>
	
		<li>
			<a href="<?php echo $item->get('url'); ?>">	
					<strong><?php echo $item->get('title'); ?></strong><br />
			</a>
		</li>
	
	<?php endforeach; ?>
</ul>
<?php endforeach; ?>
<div class="clear"></div>
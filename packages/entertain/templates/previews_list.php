<ul class="entertain_preview_list">
	<?php foreach($items AS $item) : ?>
	
		<li>
			<a href="<?php echo $item->get('url'); ?>">
				<img src="<?php echo $item->preview_image('medium'); ?>" alt="<?php echo Entertain::get_category_label($item->category) . ': ' .$item->get('title'); ?>" />
				
					<strong><?php echo $item->get('title'); ?></strong><br />
					Taggar:
					<?php foreach($item->tags as $tag): ?>
						<a href="/<?php echo $item->category; ?>/taggar/<?php echo $tag->handle; ?>"><?php echo $tag->title; ?></a>
					<?php endforeach; ?>
					<br />
					Visningar:
					<?php echo Tools::cute_number($item->get('views')); ?>
			</a>
		</li>
	
	<?php endforeach; ?>
</ul>
<div class="clear"></div>
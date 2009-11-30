<ul class="entertain_preview">
	<?php if ( isset($show_ad) && $show_ad ): ?>
	<li style="height: 263px;">
	    <object width="468" height="263"><param name="movie" value="http://media.moltoman.com/player.swf?id=638&ref=hamsterpaj"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://media.moltoman.com/player.swf?id=638&ref=hamsterpaj" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="468" height="263"></embed></object>
	</li>
	<?php endif; ?>
	<?php foreach($items AS $item): ?>
		<li>
			<a href="<?php echo $item->get('url'); ?>">
				<img src="<?php echo $item->preview_image('medium'); ?>"  alt="<?php echo Entertain::get_category_label($item->category) . ': ' .$item->get('title'); ?>" />
				<h4><?php echo $item->get('title'); ?></h4>
				<span class="type"><?php echo $item->get('category_label'); ?></span>
			</a>
		</li>
	</a>
	<?php endforeach; ?>
</ul>
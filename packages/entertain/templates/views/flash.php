<?php $data = $item->get('data'); ?>

<?php if($item->get('category') == 'onlinespel'): ?>
<div class="entertain_missing_game">Saknar du ett spel? Efterfråga spelet <a href="/diskussionsforum/hamsterpaj/spel_och_film/saknar_du_spel_paa_hamsterpaj/sida_1.php#post_2399772"><strong>Här</strong></a> eller ladda upp det själv <a href="/entertain-admin/ny"><strong>Här.</strong></a></div>
<?php endif; ?>

<div class="entertain_view entertain_div" id="entertain_flash">
	<h1><?php echo entertain::get_category_label($item->category) . ': ' . $item->get('title'); ?></h1>
	<div class="share">
		<?php echo template('share', 'share.php', array('description' => $item->get('title') . ' är ett utav Hamsterpaj.net\'s abnsolut roligaste spel! Helt klart värt att testa!', 'title' => 'Hamsterpaj.net Spel - ' . $item->get('title'))); ?>
	</div>
	<div class="rating">
		<h2>Rösta här:</h2>
		<input name="star2" type="radio" class="star" id="star-1" title="Värdelös"/>
		<input name="star2" type="radio" class="star" id="star-2" title="Okej"/>
		<input name="star2" type="radio" class="star" id="star-3" checked="checked" title="Bra"/>
		<input name="star2" type="radio" class="star" id="star-4" title="Väldigt bra"/>
		<input name="star2" type="radio" class="star" id="star-5" title="Bäst"/>
	</div>
	<object class="entertain_flash_object entertain_flash_object_small">
		<param name="movie" value="http://static.hamsterpaj.net/entertain/flash/<?php echo $item->get('handle'); ?>.swf">
		<embed class="entertain_flash_object entertain_flash_object_small" src="http://static.hamsterpaj.net/entertain/flash/<?php echo $item->get('handle'); ?>.swf"></embed>
	</object>
	<div class="info">
		<div class="extrainfo">
			<dl>
				<dt>Visningar:</dt>
					<dd><?php echo $item->get('views'); ?></dd>
			</dl>
		</div>
		<div class="clear"></div>
		<?php if(count($item->tags) > 0): ?>
		<div class="tags">
			<h4>Taggar: </h4>
			<ul>
				<?php foreach($item->tags as $tag): ?>
					<li><a href="/<?php echo $item->category; ?>/taggar/<?php echo $tag->handle; ?>"><?php echo $tag->title; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
	</div>
	<input type="button" id="fullscreen_button" value="Visa i fullskärm" />
	<div class="clear"></div>
</div>

<div id="entertain_close_fullscreen_bar">
	<input type="button" id="fullscreen_button_close" value="Stäng helskärm" />
</div>
<h1><?php echo $category_label; ?></h1>
<div class="entertain_preview_container">
	<h2>Senaste</h2>
</div>
	<?php echo $latest->preview_full(); ?>


<div class="entertain_preview_container">
	<h2>Annat nytt</h2>
	<?php echo Entertain::previews($new_items); ?>
	<br class="clear" />
</div>

<div class="entertain_preview_container">
	<h2>Populärt</h2>
	<?php echo Entertain::previews($popular_items); ?>
	<br class="clear" />
</div>

<br class="clear" /><a href="/entertain/ny">Ladda upp nya objekt</a>
<br class="clear" />
<object width="468" height="263"><param name="movie" value="http://media.moltoman.com/player.swf?id=638&ref=hamsterpaj"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://media.moltoman.com/player.swf?id=638&ref=hamsterpaj" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="468" height="263"></embed></object>

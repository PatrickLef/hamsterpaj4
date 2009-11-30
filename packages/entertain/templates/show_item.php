<div class="entertain_item">
	<?php echo $item->render(); ?>
</div>

<?php if(isset($admin)): ?>
	<?php echo $admin; ?>
<?php endif; ?>

<?php echo Entertain::previews_small($matching_tag_items2); ?>

<div class="entertain_comments">
	<?php echo $comment_list->render(); ?>
</div>

<div class="entertain_related">
	<?php echo Entertain::previews($related); ?>
</div>

<object width="468" height="263"><param name="movie" value="http://media.moltoman.com/player.swf?id=638&ref=hamsterpaj"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://media.moltoman.com/player.swf?id=638&ref=hamsterpaj" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="468" height="263"></embed></object>

<?php echo $big_related->preview_full(); ?>
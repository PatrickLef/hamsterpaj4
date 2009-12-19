<h2>Här kan du välja vilka forumdelar du vill visa nya poster från i modulen till höger</h2>
<form method="POST" action="">
<ul>
<?php foreach($forums as $forum): ?>
	<li>
		<input type="checkbox" 
					 name="<?php echo $forum['id']; ?>" 
					 <?php echo $choosed_forums[$forum['id']] == true ? 'checked="checked"' : ''; ?>
					 name="forum_category_<?php echo $forum['handle']; ?>" 
					 id="forum_category_<?php echo $forum['id']; ?>" />
		<label for="forum_category_<?php echo $forum['id']; ?>"><?php echo $forum['title']; ?></label>
	</li>
<?php endforeach; ?>
</ul>
<input type="submit" value="Spara" name="submit_modules" />
</form>
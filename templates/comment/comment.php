<li id="<?php echo $type . '-' . $item_id . '-' . $id; ?>">
	<img class="user_avatar" src="<?php echo $user->avatar_thumb_url() ?>" />
	<div class="content">
		<h2 class="user"><a href=""><?php echo $user->username ?></a></h2>
		<p>
			<?php echo $text ?>
		</p>
		<span class="timestamp"><?php echo tools::date_readable($timestamp); ?></span><?php if($remove_privilegied): ?> | <a href="" class="remove">Radera kommentaren</a><?php endif; ?>
	</div>
</li>
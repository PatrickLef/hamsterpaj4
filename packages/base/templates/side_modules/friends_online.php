<a class="minimize" href="#">+</a><h5>Vänner online</h5><a class="move" href="#">=</a>

<?php if ( count($module->friends) ): ?>

<?php
    $friends = array();
    foreach ( $module->friends as $friend )
	$friends[] = sprintf('<a href="/traffa/profile.php?user_id=%d">%s</a>', $friend['user_id'], $friend['username']);
?>
<p class="online"><?php echo implode(', ', $friends); ?></p>

<p class="show_all"><a href="/traffa/friends.php">Visa alla vänner &raquo;</a></p>
<?php else: ?>
<p>Inga vänner online :( *klappa*</p>
<?php endif; ?>
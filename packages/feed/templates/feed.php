<?php $counter = new Counter('odd', 'even'); ?>
<ul class="feed">
<?php foreach($posts as $post): ?>
	<?php echo $post->render(array('counter' => $counter)); ?>
<?php endforeach; ?>
</ul>
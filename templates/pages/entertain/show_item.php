<h1><?php echo $item->get('title'); ?></h1>

<div class="entertain_item">
	<?php echo $item->render(); ?>
</div>

<?php if(isset($admin)): ?>
	<?php echo $admin; ?>
<?php endif; ?>

<div class="entertain_comments">
	<?php echo $comment_list->render(); ?>
</div>

<div class="entertain_related">
	<?php echo Entertain::previews($related); ?>
</div>
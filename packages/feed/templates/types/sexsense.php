<li class="sexsense <?php echo $options['counter']; ?>">
	<div class="info">
		<img src="" alt="Sex" />
		<span>Idag</span>
	</div>
	<div class="content">
		<h2><?php echo $data['title']; ?></h2>
		<p><?php echo mb_substr($data['question'], 0, 100, 'UTF8'); ?>...</p>
	</div>
</li>
<li class="hamsternytt <?php echo $options['counter']; ?>">
	<div class="info">
		<img src="" alt="Nytt" />
		<span>Idag</span>
	</div>
	<div class="content">
		<h2><?php echo $data['header']; ?></h2>
		<p><?php echo mb_substr($data['content'], 0, 100, 'UTF8'); ?>...</p>
	</div>
</li>
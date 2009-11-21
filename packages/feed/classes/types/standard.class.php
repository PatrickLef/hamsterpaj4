<?php
	class FeedPostStandard extends FeedPost
	{
		function render()
		{
			return template('feed', 'types/standard.php', array('data' => $this->data));
		}
	}
?>
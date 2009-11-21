<?php
	class FeedPostTest extends FeedPost
	{
		function render()
		{
			return template('feed', 'types/test.php', array('data' => $this->data));
		}
	}
?>
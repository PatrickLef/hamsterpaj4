<?php
	class FeedPostHamsternytt extends FeedPost
	{
		function __construct($post = NULL)
		{
			if($post != NULL)
			{
				$this->item_id = $post['id'];
				$this->timestamp = $post['timestamp'];
				$this->type = 'Hamsternytt';
				$this->data = $post;
				$this->keys = array('hamsternytt');
				$this->save();
			}
		}
		
		function render($options)
		{
			return template('feed', 'types/hamsternytt.php', array('data' => $this->data, 'options' => $options));
		}
	}
?>
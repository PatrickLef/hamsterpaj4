<?php
	class FeedPostSexSense extends FeedPost
	{
		function __construct($post = NULL)
		{
			if($post != NULL)
			{
				$this->item_id = $post['id'];
				$this->timestamp = $post['timestamp'];
				$this->type = 'SexSense';
				$this->data = $post;
				$this->keys = array('sex_sense','sex_sense_category_' . $post['category']);
				
				if($post['is_released'] != 1)
				{
					$this->removed = 1;
				}
				$this->save();
			}
		}
		
		function render($options)
		{
			return template('feed', 'types/sexsense.php', array('item' => $this->data, 'options' => $options));
		}
	}
?>
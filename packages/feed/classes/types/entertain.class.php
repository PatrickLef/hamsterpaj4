<?php
	class FeedPostEntertain extends FeedPost
	{
		function __construct($entertain = NULL)
		{
			if($entertain != NULL)
			{
				$this->item_id = $entertain->get('id');
				$this->timestamp = $entertain->get('released_at');
				$this->type = 'Entertain';
				$this->data = $entertain;
				$this->keys = array('entertain','entertain_category_' . $entertain->category);
				
				if($entertain->status != 'released')
				{
					$this->removed = 1;
				}
				$this->save();
			}
		}
		
		function render($options)
		{
			switch($this->data->category)
			{
				case 'onlinespel':
					return template('feed', 'types/entertain_onlinespel.php', array('item' => $this->data, 'options' => $options));
				break;
				
				case 'filmklipp':
						return template('feed', 'types/entertain_filmklipp.php', array('item' => $this->data, 'options' => $options));
				break;
				
				case 'roliga_bilder':
						return template('feed', 'types/entertain_roliga_bilder.php', array('item' => $this->data, 'options' => $options));
				break;
				
				case 'animerat':
						return template('feed', 'types/entertain_animerat.php', array('item' => $this->data, 'options' => $options));
				break;
			}
		}
	}
?>
<?php
	class FeedPostHamsternytt extends FeedPost
	{
		static function fetch($options = NULL)
		{
			global $_PDO;
			$query = 'SELECT * FROM entertain LIMIT 20';
			$stmt = $_PDO->prepare($query);
			$stmt->execute();
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$item = new FeedPostHamsternytt;
				$item->data = $row;
				$item->timestamp = $row['timestamp'];
				$item->title = 'hej';
				$items[] = $item;
			}
			return $items;
		}
		
		function render($options)
		{
			return template('feed', 'types/hamsternytt.php', array('data' => $this->data, 'options' => $options));
		}
	}
?>
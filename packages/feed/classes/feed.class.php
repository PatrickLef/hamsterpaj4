<?php
	/*
		$feed = new Feed('handle');
		$feed->fetch_posts():
		$feed->render();
	*/
	class Feed extends HP4
	{
		function __construct($handle)
		{
			global $_PDO;
			
			$query = 'SELECT f.*, GROUP_CONCAT(fk.handle) as key_handles, GROUP_CONCAT(fk.id) as key_ids FROM feeds as f LEFT OUTER JOIN feed_keys as fk ON fk.feed_id = f.id WHERE f.handle = :handle GROUP BY f.id LIMIT 1';
			$stmt = $_PDO->prepare($query);
			$stmt->bindValue(':handle', $handle, PDO::PARAM_STR);
			$stmt->setFetchMode( PDO::FETCH_INTO, $this);
			$stmt->execute();
			$stmt->fetch();
			
			$this->key_handles = explode(',', $this->key_handles);
			$this->key_ids = explode(',', $this->key_ids);
			$this->keys = array_combine($this->key_ids, $this->key_handles);
			unset($this->key_handles);
			unset($this->key_ids);
			
			// If no feed exists, create one
			if($this->id <= 0)
			{
				$this->set(array('handle' => $handle));
				$this->save();
			}
		}
		
		function save()
		{
			global $_PDO;
			
			if($this->id > 0)
			{
				$query = 'UPDATE feed SET clicks = :clicks WHERE id = :id LIMIT 1';
				
				$stmt = $_PDO->prepare($query);
				$stmt->bindValue(':views', $this->views);
				
				if(!$stmt->execute())
				{
					Tools::debug($stmt->errorInfo());
				}
			}
			else
			{
				$query = 'INSERT INTO feed (handle)';
				$query .= ' VALUES(:handle)';

				$stmt = $_PDO->prepare($query);
				$stmt->bindValue(':handle', $this->handle);
				$stmt->execute();
				$this->id = $_PDO->lastInsertId();
			}
		}
		
		function fetch_posts()
		{
			global $_PDO;
			
			$query  = 'SELECT fp.*, GROUP_CONCAT(fpk.handle) as key_handles, GROUP_CONCAT(fpk.id) as key_ids';
			$query .=	' FROM feed_posts as fp';
			$query .=	' RIGHT OUTER JOIN feed_post_keys as fpk ON fpk.post_id = fp.id';
			$query .=	' WHERE removed = 0 AND 1=2';
			foreach($this->keys as $key)
			{
				$query .= ' OR fpk.handle = "' . $key . '"';
			}
			$query .= ' GROUP BY fp.id ORDER BY fp.timestamp DESC LIMIT 50';
			$stmt = $_PDO->prepare($query);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				if(class_exists('FeedPost' . $row['type']))
				{
					$class = 'FeedPost' . $row['type'];
					$post = new $class();
				}
				else
				{
					Tools::debug('ERROR: Class FeedPost' . $row['type'] . ' does not exist!');
					$item = new FeedPostStandard();
				}
				
				foreach ($row as $key => $value)
				{
        	$post -> {$key} = $value;
        }

        $post->build();
				$this->posts[] = $post;
			}
		}
		
		function render()
		{
			return template('feed', 'feed.php', array('posts' => $this->posts));
		}
	}
?>
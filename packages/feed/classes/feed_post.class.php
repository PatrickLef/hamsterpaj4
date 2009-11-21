<?php
	/*
		$this->type: 		Is unique for different objects. Like EntertainVideo, HamsterNytt, ForumPost. Every type has one templates in templates/types/ and a class in classes/types/
		$this->item_id: Is the objects id. For example the ID in entertain database
		$this->data: 		The data from the object, PHPserialized.
	*/
	abstract class FeedPost
	{
		function build()
		{    
			$this->key_handles = explode(',', $this->key_handles); 
      $this->key_ids = explode(',', $this->key_ids);
			$this->keys = array_combine($this->key_ids, $this->key_handles);
			unset($this->key_handles);
			unset($this->key_ids);
			
			$this->data = unserialize($this->data);
		}
		
		function save()
		{
			global $_PDO;
			$query = 'SELECT * FROM feed_posts WHERE item_id = :item_id AND type = :type';
			$stmt = $_PDO->prepare($query);
			
			$stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
			$stmt->bindValue(':item_id', $this->item_id, PDO::PARAM_INT);
			$stmt->execute();
			
			if($stmt->rowCount() > 0)
			{
				// $this->update
			}
			else
			{
				$this->create();
			}
		}
			
		function create()
		{
			global $_PDO;
			$query = 'INSERT INTO feed_posts (type, item_id, timestamp, data, removed) VALUES (:type, :item_id, :timestamp, :data, :removed)';
			$stmt = $_PDO->prepare($query);
			
			$stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
			$stmt->bindValue(':item_id', $this->item_id, PDO::PARAM_INT);
			$stmt->bindValue(':timestamp', $this->timestamp, PDO::PARAM_INT);
			$stmt->bindValue(':data', serialize($this->data));
			$stmt->bindValue(':removed', (isset($this->removed) ? $this->removed : 0), PDO::PARAM_INT);
			$stmt->execute();
			$this->id = $_PDO->lastInsertId();
			
			foreach($this->keys AS $key)
			{
				$query = 'INSERT INTO feed_post_keys (post_id, handle) VALUES (:post_id, :handle)';
				$stmt = $_PDO->prepare($query);
				$stmt->bindValue(':post_id', $this->id, PDO::PARAM_INT);
				$stmt->bindValue(':handle', $key);
				$stmt->execute();
			}
		}
	}
?>
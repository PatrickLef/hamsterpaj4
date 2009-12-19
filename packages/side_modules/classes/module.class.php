<?php
	class Module extends HP4
	{
		public $is_sortable = true;
		public $is_closed = false;
		protected $visible = true;
		
		function execute($page)
		{
			return template('base', 'side_modules/' . $this->template . '.php', array('module' => $this, 'page' => $page));
		}
		
		function edit()
		{
			return false;
		}
		
		function save($user)
		{
			global $side_modules;
			foreach($side_modules as $key => $module)
			{
				if($module['class'] == get_class($this))
				{
					$handle = $key;
					break;
				}
			}

			global $_PDO;
			$query = 'SELECT id FROM side_modules WHERE handle = :handle AND user_id = :user_id LIMIT 1';

			$stmt = $_PDO->prepare($query);
			$stmt->bindValue(':user_id', $user->id); 
			$stmt->bindValue(':handle', $handle);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$id = $row['id'];
			}
		
			if(isset($id))
			{
				$query = 'UPDATE side_modules SET settings = :settings WHERE handle = :handle AND user_id = :user_id LIMIT 1';
	
				$stmt = $_PDO->prepare($query);
				$stmt->bindValue(':user_id', $user->id); 
				$stmt->bindValue(':settings', serialize($this->settings));
				$stmt->bindValue(':handle', $handle);
				$stmt->execute();
			}
			else
			{
				Tools::debug('running insert');
				$query = 'INSERT INTO side_modules (user_id, settings, handle) VALUES(:user_id, :settings, :handle)';
				$stmt = $_PDO->prepare($query);
				$stmt->bindValue(':user_id', $user->id); 
				$stmt->bindValue(':settings', serialize($this->settings));
				$stmt->bindValue(':handle', $handle);
				$stmt->execute();
			}
			
			$user->module_forum_posts_settings = serialize($this->settings);
		}
	}
?>
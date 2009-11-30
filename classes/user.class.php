<?php
	class User extends HP4
	{
		// Die die die
		public $last_action,
			$last_logon,
			$last_update = array(),
			$signature,
			$visitors,
			$username,
			$id,
			$ip,
			$last_ip,
			$last_username_change,
			$password,
			$quality_level,
			$quality_level_expire,
			$reg_ip,
			$DEPRECATED_userlevel,
			$contact1,
			$contact2,
			$gender,
			$image,
			$image_ban_expire,
			$created,
			$session_id,
			$groups,
			$photoblog_preferences,
			$module_states,
			$module_order,
			$firstname,
			$surname,
			$birthday,
			$notices,
			$cache,
			$visitors_with_image,
			$forum,
			$email,
			$preferences,
			$x_rt90,
			$y_rt90,
			$zip_code,
			$location,
			$privileges,
			$geo_location,
			$notifications = array(),
			$live_chat,
			$recent_updates,
			$friends_online;
		
		protected $unread_gb_entries;
		protected $unread_group_entries;
		protected $unread_photo_comments;
		
		public function online()
		{
			return ($this->last_action > time() - 600);
		}
		
		public function exists()
		{
			return ($this->id > 0);
		}
		
		public function from_session($session)
		{
			global $session_map;
			foreach($session_map AS $property => $path)
			{
				switch(count($path))
				{
					case 1:
						$this->set(array($property => $session[$path[0]]));
						break;
					case 2:
						$this->set(array($property => $session[$path[0]][$path[1]]));
						break;
					case 3:
						$this->set(array($property => $session[$path[0]][$path[1]][$path[2]]));
						break;
					case 4:
						$this->set(array($property => $session[$path[0]][$path[1]][$path[2]][$path[3]]));
						break;
					case 5:
						$this->set(array($property => $session[$path[0]][$path[1]][$path[2]][$path[3]][$path[4]]));
						break;
				}
			}
		}
		
		public function to_session()
		{
			global $session_map;
			
			$session = array();
			foreach($session_map AS $property => $path)
			{
				switch (count($path))
				{
					case 1:
						$session[$path[0]] = $this->get($property);
						break;
					case 2:
						$session[$path[0]][$path[1]] = $this->get($property);
						break;
					case 3:
						$session[$path[0]][$path[1]][$path[2]] = $this->get($property);
						break;
					case 4:
						$session[$path[0]][$path[1]][$path[2]][$path[3]] = $this->get($property);
						break;
					case 5:
						$session[$path[0]][$path[1]][$path[2]][$path[3]][$path[4]] = $this->get($property);
						break;
				}
			}
			return $session;
		}
		
		public function lastaction()
		{
			$this->lastaction = time();
			
			// If user, save to database
			if($this->exists() && rand(1, 5) == 2)
			{
				global $_PDO;
				
				$query = 'UPDATE login SET lastaction = UNIX_TIMESTAMP() WHERE id= :id';
				$stmt = $_PDO->prepare($query);
				$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
				
				if(!$stmt->execute())
				{
					Tools::Debug('Couldn\'t save lastaction');
				}
			}
		}
		
		public function get_last_update($section = null)
		{
		    if ( ! is_null($section) )
		    {
			if ( ! isset($this->last_update[$section]) )
			{
			    $this->last_update[$section] = 0;
			}
			return $this->last_update[$section];
		    }
		    
		    return $this->last_update;
		}
		
		public function set_last_update($section = null, $value = null)
		{
		    if ( ! is_null($section) && ! is_array($section) )
		    {
			$this->last_update[$section] = $value;
		    }
		    else
		    {
			$this->last_update = $section;
		    }
		}
		
		public static function fetch($search, $params = array())
		{
			global $_PDO;

			// Bug, only allows one entry
			$search['id'] = (isset($search['id']) && !is_array($search['id'])) ? array($search['id']) : array();
			$search['username'] = (isset($search['username']) && !is_array($search['username'])) ? array($search['username']) : array();
			
			Tools::pick_inplace($search['has_visited'], 0);
			Tools::pick_inplace($search['has_image'], false);
			
			Tools::pick_inplace($params['allow_multiple'], false);
			
			if(isset($search['id']))
			{
				$search['id'] = (is_array($search['id'])) ? $search['id'] : array($search['id']);
			}
			$search['limit'] = (isset($search['limit'])) ? $search['limit'] : 9999;
			
			$search['order-by'] = (isset($search['order-by'])) ? $search['order-by'] : 'l.id';
			$search['order-direction'] = (isset($search['order-direction'])) ? $search['order-direction'] : 'ASC';
			
			$query = 'SELECT l.id, l.username, l.password, l.lastlogon, l.quality_level, l.quality_level_expire';
			$query .= ', u.user_status, u.cell_phone';
			$query .= ', GROUP_CONCAT(p.privilegie) AS privilegies, GROUP_CONCAT(p.value) AS privilegie_values';
			
			$query .= ($search['has_visited'] > 0) ? ', uv.timestamp AS last_visit, uv.count AS visit_count' : null;
			
			$query .= ' FROM login AS l LEFT OUTER JOIN privilegies AS p ON l.id = p.user, userinfo AS u';

			$query .= ($search['has_visited'] > 0) ? ', user_visits AS uv' : null;

			$query .= ' WHERE u.userid = l.id';
			$query .= (count($search['username']) > 0) ? ' AND l.username IN ("' . implode('", "', $search['username']) . '")' : null;
			$query .= (count($search['id']) > 0) ? ' AND l.id IN ("' . implode('", "', $search['id']) . '")' : null;
			$query .= ($search['has_image'] == true) ? ' AND (u.image = 1 OR u.image = 2)' : null;
			$query .= ($search['has_visited'] > 0) ? ' AND l.id = uv.item_id AND uv.type = "profile_visit" AND uv.user_id = "' . $search['has_visited'] . '"' : null;

			$query .= ' GROUP BY l.id';
			$query .= ' ORDER BY ' . $search['order-by'] . ' ' . $search['order-direction'];
			$query .= ' LIMIT ' . $search['limit'];
			
			$users = array();
			foreach($_PDO->query($query) AS $row)
			{
				$user = new User();
				$user->id = $row['id'];
				$user->username = $row['username'];
				$user->password = $row['password'];
				$user->last_logon = $row['lastlogon'];
				$user->signature = $row['user_status'];
				$user->cell_phone = $row['cell_phone'];
				$user->last_visit = Tools::pick($row['last_visit'], null);
				$user->quality_level = $row['quality_level'];
				$user->quality_level_expire = $row['quality_level_expire'];

				// Explode privilegies and privilegie_values, add them to the object
				$privileges = explode(',', $row['privilegies']);
				$privilege_values = explode(',', $row['privilegie_values']);
				for($i = 0; $i < count($privileges); $i++)
				{
					$user->privileges[$privileges[$i]][] = $privilege_values[$i];
				}

				if($params['allow_multiple'] == true)
				{
					$users[] = $user;
				}
				else
				{
					return $user;
				}
			}
			
			return ($params['allow_multiple'] == true) ? $users : false;
		}
		
		/*
		    Modules
		*/
		
		public function set_module_order($order)
		{
		    if ( is_string($order) )
		    {
			$order = unserialize($order);
		    }
		    $this->module_order = $order;
		}
		
		public function get_module_order()
		{
		    if ( is_string($this->module_order) )
		    {
			$this->module_order = unserialize($this->module_order);
		    }
		    return $this->module_order;
		}
		
		public function set_module_states($states)
		{
		    if ( is_string($states) )
		    {
			$states = unserialize($states);
		    }
		    
		    $this->module_states = $states;
		}
		
		public function save_module_order($order)
		{
		    global $_PDO;
		    
		    if ( $this->exists() )
		    {
			$query = 'UPDATE preferences';
			$query .= ' SET module_order = "' . mysql_escape_string(serialize($order)) . '"';
			$query .= ' WHERE userid = ' . $this->get('id') . ' LIMIT 1';
			
			$_PDO->query($query);
		    }
		    $this->set(array('module_order' => $order));
		}
		
		public function save_module_state($module_name, $state)
		{
		    global $_PDO;
		    
		    $this->module_states[$module_name] = $state;
		    
		    if ( $this->exists() )
		    {
			$query = 'UPDATE preferences ';
			$query .= 'SET module_states = "' . mysql_escape_string(serialize($this->module_states)) . '"';
			$query .= 'WHERE userid = "' . $this->get('id') . '" LIMIT 1';
			
			$_PDO->query($query);
		    }
		}
		
		/*
		    Notices
		*/
		
		public function get_unread_photo_comments()
		{
			$this->update_notices();
			return $this->unread_photo_comments;
		}
		
		public function get_unread_gb_entries()
		{
			$this->update_notices();
			return $this->unread_gb_entries;
		}
		
		public function get_unread_group_entries()
		{
		    $this->update_notices();
		    return $this->unread_group_entries;
		}
		
		public function get_forum_subscriptions()
		{
		    $this->update_notices();
		    return $this->forum['subscriptions'];
		}
		
		public function get_forum_category_subscriptions()
		{
		    $this->update_notices();
		    return $this->forum['category_subscriptions'];
		}
		
		public function get_unread_forum_posts()
		{
		    $this->update_notices();   
		    return $this->forum['new_notices'];
		}
		
		public function get_forum_notices()
		{
		    $this->update_notices();
		    return $this->forum['notices'];
		}
		
		public function update_notices()
		{
		    if ( ! $this->exists() )
		    {
			return false;
		    }
		    
		    $force_update = $this->get_last_update('notices') < time() - 40;
		    
		    if ( ! isset($this->forum) || $force_update )
		    {
			// Forum
			$this->forum = Legacy::fetch_forum_notices($this);
		    }
		    
		    if ( ! isset($this->unread_group_entries) && ! $force_update)
		    {
			$this->unread_group_entries = $this->cache['unread_group_notices'];
		    }
		    elseif ( ! isset($this->groups_members, $this->cache, $this->groups_members) || $force_update )
		    {
			// Groups
			$entries = Legacy::fetch_group_notices($this);
			
			$this->cache = array_merge($this->cache, $entries['cache']);
			$this->groups_members = $entries['groups_members'];
			
			$this->unread_group_entries = $entries['cache']['unread_group_notices'];
		    }
		    
		    if ( ! isset($this->unread_gb_entries) || $force_update )
		    {
			// Guestbook
			$search = array('recipient' => $this->id, 'force_unread' => true, 'allow_private' => true, 'get_removed' => false);
			$this->unread_gb_entries = count(Guestbook::fetch($search));
		    }
		    
		    if ( ! isset($this->unread_photo_comments) || $force_update )
		    {
			// Events (photo comments atm)
			$this->unread_photo_comments = Legacy::fetch_unread_photo_comments($this);
		    }
		    
		    if ( $force_update )
		    {
			$this->set_last_update('notices', time());
		    }
		}
		
		/*
		    User status
		*/
		
		public function save_signature($status)
		{
		    global $_PDO;
		    
		    if ( $this->exists() )
		    {
			$query = 'UPDATE userinfo SET user_status = :status, user_status_update = ' . time() . '';
			$query .= ' WHERE userid = :user_id LIMIT 1';
			
			$statement = $_PDO->prepare($query);
			$statement->bindValue(':status', $status, PDO::PARAM_STR);
			$statement->bindValue(':user_id', $this->get('id'), PDO::PARAM_INT);
			$statement->execute();
		    }
		    $this->signature = $status;
		}
		
		/*
		    Friends
		*/
		
		public function get_friends_online($update = false)
		{
		    if ( $update && $this->get_last_update('friends') < time() - 60 )
		    {
			global $_PDO;
			
			$query = 'SELECT f.friend_id AS user_id, l.username, l.lastaction, l.lastrealaction, u.user_status';
			$query .= ' FROM friendslist AS f, login AS l, userinfo AS u';
			$query .= ' WHERE f.user_id = :user_id AND l.id = f.friend_id AND u.userid = l.id AND is_removed = 0 AND l.lastaction > :last_action';
			
			$statement = $_PDO->prepare($query);
			$statement->bindValue(':user_id', $this->get('id'), PDO::PARAM_INT);
			$statement->bindValue(':last_action', time() - 600, PDO::PARAM_INT);
			$statement->execute();
			$friends = array();
			
			foreach ( $statement->fetchAll(PDO::FETCH_ASSOC) as $friend )
			{
			    $friends[$friend['user_id']] = $friend;
			}
			/*$new_friends = array_diff_assoc($friends, $this->friends_online);
			
			if ( count($new_friends) )
			{
			    foreach ( $new_friends as $key => $friend )
			    {
				$new_friends[$key] = sprintf('<a href="/traffa/profile.php?user_id=%d">%s</a>', $friend['user_id'], $friend['username']);
			    }
			    $links = implode(', ', $new_friends);
			    
			    $this->add_recent_update(array(
				'text' => sprintf('%s har precis loggat in!', $links),
				'views' => 4
			    ));
			}*/
			
			$this->friends_online = $friends;
			$this->set_last_update('friends', time());
		    }
		    return $this->friends_online;
		}
		
		public function auth($password)
		{
			return (Secret::password_hash($password) == $this->password);
		}
		
		function get_profile_url()
		{
			return '/traffa/profile.php?id=' . $this->id;
		}
		
		function avatar_thumb_url()
		{
			if(file_exists('/mnt/images/images/users/thumb/' . $this->id . '.jpg'))
			{
				return 'http://images.hamsterpaj.net/images/users/thumb/' . $this->id . '.jpg';
			}
			else
			{
				return 'http://images.hamsterpaj.net/user_no_image.png';
			}
		}
		
		function get_age()
		{
			if(isset($this->birthday) && $this->birthday != '0000-00-00' && $this->birthday > 0)
			{
				return floor((date('Ymd') - str_replace('-', null, $this->birthday))/10000);
			}
			return false;
		}
		
		function get_visitors()
		{
			if($this->exists() && count($this->visitors) == 0)
			{
				global $_PDO;
				$query = 'SELECT l.username, l.id, uv.timestamp AS last_visit FROM login AS l, user_visits AS uv, userinfo as u WHERE l.id = uv.item_id AND u.userid = l.id AND uv.type = "profile_visit" AND uv.user_id = :user_id AND (u.image = 1 OR u.image = 2) GROUP BY l.id ORDER BY last_visit DESC LIMIT 8';
				$stmt = $_PDO->prepare($query);
				$stmt->bindValue(':user_id', $this->id);
				$stmt->execute();
				while($data = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$user = new User;
					$user->username = $data['username'];
					$user->id = $data['id'];
					$user->last_visit = $data['last_visit'];
					$this->visitors[] = $user;
				}
			}
			return $this->visitors;
		}
		
		function get_forum_categories()
		{
			$this->update_notices();
			return $this->forum['categories'];
		}
		
		function get_recent_update()
		{
			$this->recent_updates['queue'] = Tools::ensure_array($this->recent_updates['queue']);
			$this->recent_updates['threads'] = Tools::ensure_array($this->recent_updates['threads']);
		    
			$data = Cache::load('latest_forum_threads');
			$thread = array_pop($data);

			$id = $thread['id'];
			
			if ( $thread['timestamp'] > (time() - 300) && ! in_array($thread['id'], $this->recent_updates['threads']) )
			{
				$this->add_recent_update(
					array(
				   	'link' => $thread['url'],
				 		'text' => $thread['username'] . ' skapade precis tråden ' . $thread['title'],
				   	'views' => 2
					)
			  );
			    
			  $this->recent_updates['threads'][] = $thread['id'];
			}
		    
		   if ( count($this->recent_updates['queue']) )
		   {
					// Fetch latest
					$latest = array_shift($this->recent_updates['queue']);
					if ( --$latest['views'] > 0 )
					{
			  	  // Put it back for further use
			  	  array_unshift($this->recent_updates['queue'], $latest);
					}
					return $latest;
		   }
		   
		   return false;
	  }
		
		public function add_recent_update($options)
		{
		    array_push($this->recent_updates['queue'], $options);
		}
		
		function notificate($params, $type = 'default')
		{
		    $template = sprintf('framework/notifications/%s.php', $type);
		    $this->notifications[] = array(NULL, $template, $params);
		}
		
		function fetch_notifications()
		{
		    $notifications = Tools::pick($_SESSION['notifications'], array());
		    unset($_SESSION['notifications']);
		    return $notifications;
		}
		
		function privilegied($privilegie, $value = NULL)
		{
			if(isset($this->privileges['igotgodmode']))
			{
				return true;
			}
			
			if(isset($this->privileges[$privilegie]) && in_array(0, $this->privileges[$privilegie]))
			{
				return true;
			}
			
			if($value == NULL)
			{
				return isset($this->privileges[$privilegie]);
			}
			else
			{
				return (in_array($value, $this->privileges[$privilegie])) ? true : false;
			}
		}
		
		function profile_mini()
		{
			return template('user', 'user_profile_mini.php', array('user' => $this));
		}
	}
?>
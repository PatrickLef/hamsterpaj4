<?php
		
	function forum_posts_cmp($a, $b)
	{
	 	if ($a['last_post_timestamp'] == $b['last_post_timestamp'])
	 	{
			return 0;
		}
		return ($a['last_post_timestamp'] > $b['last_post_timestamp']) ? -1 : 1;
	}

	class SideModuleForumPosts extends Module
	{
		public $template = 'forum_posts';
		public $id = 'forum_posts';
		public $edit_template = 'forum_posts';
		
		function __construct($user)
		{
			$this->settings = unserialize($user->module_forum_posts_settings);

			if(!is_array($this->settings->choosed_forums))
			{
				$threads = Cache::load('latest_forum_posts');
			}
			else
			{
				$threads = array();
				// Load threads from category thread cache
				foreach($this->settings->choosed_forums as $id => $forum)
				{
					if($forum)
					{
						// add to threads
						if($new_threads = Cache::load('latest_forum_posts_' . $id))
						{
							foreach($new_threads as $new_thread)
							{
								array_push($threads, $new_thread);
							}
						}
					}
				}
				
				uasort($threads, 'forum_posts_cmp');
				$threads = array_splice($threads, 0,8);
			}
			
			$this->threads = $threads;
		}
		
		// Edit is loaded when the sidemodule edit page is loaded
		function edit($user)
		{
			global $_PDO;
			
			$query = 'SELECT * FROM public_forums';
			
			foreach($_PDO->query($query) AS $row)
			{
				$forums[] = $row;
			}
			
			if(isset($_POST['submit_modules']))
			{
				foreach($forums as $forum)
				{
					if(isset($_POST[$forum['id']]))
					{
						$this->settings->choosed_forums[$forum['id']] = true;
					}
					else
					{
						$this->settings->choosed_forums[$forum['id']] = false;
					}
				}
				$this->save($user);
				header('Location: ' . $_SERVER['REQUEST_URI']);
			}
			
			return template('base', 'side_modules/edit/' . $this->edit_template . '.php', array('forums' => $forums, 'choosed_forums' => $this->settings->choosed_forums));
		}
	}

?>
<?php	
	function forum_thread_cmp($a, $b)
	{
	 	if ($a['timestamp'] == $b['timestamp'])
	 	{
			return 0;
		}
		return ($a['timestamp'] > $b['timestamp']) ? -1 : 1;
	}
	
	class SideModuleForumThreads extends Module
	{
		public $template = 'forum_threads';
		public $id = 'forum_threads';
		public $edit_template = 'forum_threads';
		
		function __construct($user)
		{
			$this->settings = unserialize($user->module_forum_threads_settings);

			if(!is_array($this->settings->choosed_forums))
			{
				$threads = Cache::load('latest_forum_threads');
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
						if($new_threads = Cache::load('latest_forum_threads_' . $id))
						{
							foreach($new_threads as $new_thread)
							{
								array_push($threads, $new_thread);
							}
						}
					}
				}
				
				uasort($threads, 'forum_thread_cmp');
				$threads = array_splice($threads, 0,8);
			}
			
			$this->threads = $threads;
		}
		
		function recurse_forum_category($categories, $depth)
		{
			$output = '';
			
			if ( ! is_array($categories) )
			{
			    return '';
			}
			
			foreach($categories AS $category)
			{
				if($category['handle'] == 'hamsterpajs_artiklar' || $category['handle'] == 'forum_error')
				{
					continue;
				}
				$indent = '';
				for($i = 0; $i < $depth; $i++)
				{
					$indent .= str_repeat('&nbsp;', 4);
				}
				$category['title'] = (strlen($category['title']) > 21) ? substr($category['title'], 0, 19) . '...' : $category['title'];
				$style = ($depth == 0) ? ' style="font-weight: bold;"' : '';
				$output .= '<option value="' . $category['handle'] . '"' . $style . '>' . $indent . $category['title'] . '</option>' . "\n";
	
				$output .= $this->recurse_forum_category(Tools::pick($category['children'], null), $depth+1);
			}				
			return $output;
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
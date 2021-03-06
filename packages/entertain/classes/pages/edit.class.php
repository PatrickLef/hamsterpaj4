<?php
	class PageEntertainEdit extends Page
	{
		public static function url_hook($uri)
		{
			return (substr($uri, 0, 26) == '/entertain-admin/redigera/') ? 10 : 0;
		}
		
		function execute($uri)
		{
			$this->menu_active = 'entertain_admin';
			$uri_explode = explode('/', $uri);
			
			if($item = Entertain::fetch(array('handle' => $uri_explode[3])))
			{
				if(($item->get('uploaded_by') == $this->user->get('id') && $item->get('status') == 'preview') || $this->user->privilegied('entertain_admin'))
				{
					if(isset($_POST['action']) && $_POST['action'] == 'update')
					{
						// Check input status privilegies
						if(!$this->user->privilegied('entertain_admin') && $_POST['status'] == 'scheduled')
						{
							$this->content .= template('base', 'notifications/not_privilegied.php');
							return;
						}
						
						if(!$this->user->privilegied('entertain_admin') && $_POST['status'] == 'released')
						{
							$this->content .= template('base', 'notifications/not_privilegied.php');
							return;
						}
						
						if(!$this->user->privilegied('entertain_admin') && $_POST['status'] == 'removed')
						{
							$this->content .= template('base', 'notifications/not_privilegied.php');
							return;
						}
						
						$item->update_from_post($this->user);
						$item->save();
						
						if($_POST['status'] == 'preview')
						{
							$this->redirect = $item->get('preview_url');
						}
						else
						{
							$this->redirect = $item->get('url');
						}
					}
					
					// Search to look after objects with the same name
					$searchresult = Livesearch::search($item->get('title'));
					
					$dropdown = new HTMLDropdown();
					$dropdown->set(array('name' => 'category'));
					foreach(Entertain::categories() AS $category)
					{
						$dropdown->add_option(array('label' => $category['label'], 'value' => $category['handle']));
					}
					$dropdown->set(array('selected' => $item->get('category')));
					
					$privilegies['schedule'] = ($this->user->privilegied('entertain_admin') ? true : false);
					$privilegies['release'] = ($this->user->privilegied('entertain_admin') ? true : false);
					$privilegies['remove'] = ($this->user->privilegied('entertain_admin') ? true : false);
					
					// Put up a releasetime in schedule
					if(!isset($item->release))
					{
						$schedule = new Schedule('entertain');
						$item->release = $schedule->suggest();
					}
					
					$this->content .= template('livesearch', 'search.php', array('searchquery' => $item->get('title'), 'result' => $searchresult));
					$this->content .= template('entertain', 'admin/edit.php', array('item' => $item, 'dropdown' => $dropdown, 'privilegies' => $privilegies));
				}
				else
				{
					$this->content .= template('base', 'notifications/warning.php', array('header' => 'Du kan inte förhandsgranska objekt som redan är ställda i kö'));
					return;
				}
			}
			else
			{
				$error['header'] = 'Entertain-objektet finns inte!';
				$error['information'] = 'Objektet "' . $uri_explode[3] . '" finns inte i entertain-databasen.';
				$this->content .= template('base', 'notifications/not_found.php', $error);
			}
		}
	}
?>
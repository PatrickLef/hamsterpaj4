<?php
	class PageEntertainTagsList extends Page
	{
		public static function url_hook($uri)
		{
			global $_ENTERTAIN;
			$uri_explode = explode('/', $uri);
			
			if ( count($uri_explode) >= 3 )
			{
			    foreach($_ENTERTAIN['categories'] as $handle => $category)
			    {
				    if($uri_explode[1] == $handle && $uri_explode[2] == 'taggar')
				    {
					    return 15;
				    }
			    }
			}
			
			return 0;
		}
		
		function execute($uri)
		{
			$uri_explode = explode('/', $uri);
			
			if( Menu::exists($uri_explode[1] . '_' . $uri_explode[3]) )
			{
				$this->menu_active = $uri_explode[1] . '_' . $uri_explode[3];
			}
			else
			{
				$this->menu_active = $uri_explode[1];
			}
			
			if(!$tags = Tag::fetch(array('handle' => $uri_explode[3])))
			{
				$this->content .= 'Den här taggen finns inte';
				return;
			}
			
			
			foreach( $tags as $tag )
			{
				$tag_title = $tag->title;
				$items_id[] = $tag->item_id;
			}
			
			$category_label = Entertain::get_category_label($uri_explode[1]);
			$this->title = $category_label . ' - ' . $tag_title . ' på Hamsterpaj.net';
			
			// Search tip
			$this->content .= template('base', 'notifications/tip.php', array('text' => 'Vet du om att du kan söka efter underhållning i den blå-vita rutan där det står "Sök underhållning" till höger? -->'));
			
			// Get display settings
			$view = $_GET['view'];
			
			switch($_GET['order_by'])
			{
				case 'views':
					$order_by = 'views DESC';
				break;
				
				case 'date':
					$order_by = 'released_at DESC';
				break;
				
				case 'alphabetical':
					$order_by = 'title ASC';
				break;
				
				default:
					$order_by = 'views DESC';
			}
			
			switch($_GET['released_within'])
			{
				case 'one_day':
					$released_within = time() - 60*60*24;
				break;
				
				case 'one_week':
					$released_within = time() - 60*60*24*7;
				break;
				
				case 'one_month':
					$released_within = time() - 60*60*24*31;
				break;
				
				case 'one_year':
					$released_within = time() - 60*60*24*365;
				break;
					
				default:
				$released_within = NULL;
			}
			
			$items = Entertain::fetch(array('ids' => $items_id, 'allow_multiple' => true, 'status' => 'released', 'category' => $uri_explode[1], 'order_by' => $order_by, 'released_within' => $released_within));
			
			
			$this->content .= '<h1>' . $category_label . ' med taggen ' . $tag_title . '</h1>';
			$this->content .= template('entertain', 'list_menu.php', array('view' => $_GET['view'], 'order_by' => $_GET['order_by'], 'released_within' => $_GET['released_within']));
			switch($_GET['view'])
			{
				case 'list':
					$this->content .= Entertain::previews_list($items);
				break;
				
				case 'group':
					if(isset($_GET['order_by']))
					{
						$this->content .= Entertain::previews_grouped($items, $_GET['order_by']);
					}
					else
					{
						$this->content .= Entertain::previews_grouped($items, 'alphabetical');
					}
				break;
				
				default:
					$this->content .= Entertain::previews($items);
			}

		}
	}
?>
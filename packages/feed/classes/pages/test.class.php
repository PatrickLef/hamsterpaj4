<?php
	class PageFeedTest extends Page
	{
		public static function url_hook($uri)
		{
			return ($uri == '/test') ? 20 : 0;
		}
		
		function execute($uri)
		{
			
			global $_PDO;
			/*
			$query = 'SELECT * FROM hamsterblog';
			$stmt = $_PDO->prepare($query);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				new FeedPostHamsternytt($row);
			}
			*/
			/*$items = Entertain::fetch(array('status' => 'released', 'order_by' => 'released_at DESC', 'allow_multiple' => true));

			foreach($items as $item)
			{
				
				new FeedPostEntertain($item);
			}*/
			
			
			
			$feed = new Feed('frontpage');
			//Tools::Debug($feed);
			$feed->fetch_posts();
			
			//$this->content = Tools::Preint_r($feed);
			
			//$test = array('name' => 'Your mother sukkz', 'content' => 'Oh.. Why do you say that? :(');
			$this->content .= $feed->render();
		}
	}
?>
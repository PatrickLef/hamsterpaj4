<?php
	class page_mobile_blog_start extends page
	{
		function url_hook($uri)
		{
			return ($uri == '/mobilblogg') ? 10 : 0;
		}
		
		function execute()
		{
			$this->content = template('pages/social/mobile_blog/start.php');
			$this->content .= template('pages/social/mobile_blog/form.php');
			$this->content .= template('pages/social/mobile_blog/howto.php');
			
			$mobile_blogs = mobile_blog::fetch();
			
			$entries = array();
			foreach($mobile_blogs as $entry)
			{
				$entry->comment_list = new comment_list();
				$entry->comment_list->user = $this->user;
				$entry->comment_list->item_id = $entry->id;
				$entry->comment_list->type = 'mobile_blog';
				$entry->comment_list->fetch_comments();
				$entries[] = $entry;
			}
			
			$this->content .= template('pages/social/mobile_blog/list.php', array('entries' => $entries));
		}
	}
?>
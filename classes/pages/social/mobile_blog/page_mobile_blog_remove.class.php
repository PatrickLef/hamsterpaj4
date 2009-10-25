<?php
	class PageMobileBlogRemove extends Page
	{
		public static function url_hook($uri)
		{
			return ($uri == '/mobilblogg/radera') ? 10 : 0;
		}

		function execute()
		{
			if(!$this->user->exists() || !$this->user->privilegied('mobile_blog_remove'))
			{
				throw new Exception('Du m�ste vara inloggad f�r att anv�nda den h�r funktionen');
			}
			
			$entry = new MobileBlog;
			
			$entry->id = $_GET['id'];
			$entry->remove();
			$this->content = 'Om Daniella nu hade haft ett routingsystem s� hade vi kastat tillbaka dig till sidan du kom ifr�n, men Johan har inte kodat det �nnu. <a href="/mobilblogg/">G� tillbaka</a>';
		}
	}

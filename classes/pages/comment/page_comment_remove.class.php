<?php
	class page_comment_remove extends page
	{
		function url_hook($uri)
		{
			return ($uri == '/kommentar/radera') ? 10 : 0;
		}

		function execute()
		{
			if(!$this->user->privilegied('comments_admin', $_GET['type']))
			{
				throw new Exception('Du m�ste vara inloggad f�r att anv�nda den h�r funktionen');
			}
			
			$comment = new comment;
			
			$comment->id = $_GET['id'];
			$comment->remove();
			$this->raw_output = true;
		}
	}
?>
<?php
	class page_alphabet_on_time extends page
	{
		function url_hook($url)
		{
			return ($url == '/alfabetet-paa-tid') ? 10 : 0;
		}
		
		function execute()
		{
			$this->content = template('alphabet_on_time', 'alphabet_on_time.php');
		}
	}
?>
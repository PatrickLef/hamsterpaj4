<?php
	class PageEntertainDownload extends Page
	{
		public static function url_hook($uri)
		{
			global $_ENTERTAIN;
			foreach($_ENTERTAIN['categories'] as $handle => $category)
			{
				if(substr($uri, 1, strlen($handle)) == $handle && strlen($uri) > strlen($handle)+2 && substr($uri, -9) == 'ladda_ner')
				{
					return 20;
				}
			}
			return 0;
		}
		
		function execute($uri)
		{
			$uri_explode = explode('/', $uri);
			if(!$item = Entertain::fetch(array('handle' => $uri_explode[2])))
			{
				$this->content .= template('base', 'notifications/not_found.php', array('header' => 'Item not found', 'information' => 'The sought object could not be found'));
				return;
			}
			
			if($item->get('type') != 'file')
			{
				$this->content .= template('base', 'notifications/not_found.php', array('header' => 'Ej m�jligt att ladda ner', 'information' => 'Du kan endast ladda ner filer fr�n v�r nedladdningssektion.'));
				return;
			}
			
			if(!isset($_POST['truesubmit']))
			{
				$this->location = $item->get('url');
			}
			
			$data = $item->get('data');
			
			$file = PATH_STATIC . 'entertain/files/' . $data['filename'];
			if (file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: ' . $data['type']);
				header('Content-Disposition: attachment; filename=' . $data['filename']);
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
			}
			else
			{
				Tools::debug('No file found');
			}
		}
	}
?>
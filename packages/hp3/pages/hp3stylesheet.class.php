<?php

class PageHP3Stylesheet extends Page
{
    public $raw_output = true;
    
    public static function url_hook($uri)
    {
	return String::beginswith($uri, '/stylesheets/') ? 20 : 0;
    }
    
    public function execute($uri)
    {
	$filename = str_replace('/stylesheets/', '', $uri);
	$path = PATH_PACKAGES . 'hp3/css/' . $filename;
	
	if ( ! strstr($uri, '..') && file_exists($path) )
	{
	    header('content-type: text/css');
	    ECache::output($path);
	    die;
	}
	else
	{
	    header('HTTP/1.0 404 Not Found');
	    $this->content = '<html><head><title>Filen hittades inte!</title></head><body><h1>Filen ' . $filename . ' hittades inte!</h1></body></html>';
	}
    }
}

?>

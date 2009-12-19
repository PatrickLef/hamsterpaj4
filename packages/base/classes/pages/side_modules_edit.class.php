<?php

class PageSideModulesEdit extends Page
{
    public static function url_hook($uri)
    {
    	global $side_modules;
    	foreach($side_modules as $key => $module)
    	{
				if(String::beginswith($uri, '/sidmodul/' . $key))
				{
					return 20;
				}
			}
			return 0;
    }
    
    public function execute($uri)
    {
    	global $side_modules;
    	$module = substr($uri, 10);
    	
    	$module = new $side_modules[$module]['class']($this->user);
    	
    	if(!$this->user->exists())
    	{
    		$this->content = '<h2>Du måste vara inloggad för att komma åt den här sidan</h2>';
    		return false;
    	}
    	
    	if(!$this->content = $module->edit($this->user))
    	{
				$this->content = '<h2>Den här modulen går det inte att utföra några ändringar till, tyvärr.</h2>';
			}
    }
}
?>

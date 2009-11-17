<?php
	class HP4
	{
		public function set($args)
		{
			foreach($args as $var => $value)
			{
				$function = 'set_' . $var;
				if(is_callable(array($this, $function)))
				{
					$this->$function($value);
				}
				else
				{
					$this->$var = $value;
				}
			}
		}
	
		public function get($var)
		{	
			$function = 'get_' . $var;
			if( is_callable(array($this, $function)) )
			{
				$args = func_get_args();
				$args = array_slice($args, 1);
				
				return call_user_func_array(array($this, $function), $args);
			}
			else
			{
				return $this->$var;
			}
		}
	}
?>
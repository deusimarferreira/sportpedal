<?php 

	$cache_life = 520;

	function xml_loader($url, $handle)
	{
		global $cache_life;
		
		$fn = $handle . '.xml';
	
		if ( (!file_exists($fn)) or (filemtime($fn) < time() - $cache_life) )
			{
				if (!copy($url, $fn))
					die('File \'' . $fn . '\' cannot be written. Permission problem?');
			} else {
				if (!is_readable($fn))
					die('File \'' . $fn . '\' cannot be readed. Permission problem?');
			}
		return simplexml_load_file($fn);
	}

?>
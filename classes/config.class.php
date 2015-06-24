<?php
/**
*	Classe Config
*	Permet de récupérer les données de configuration
*	@author Fabien Selles
*	@copyright Parc National des Écrins
*	
*/

class config 
{
	static function get($value='',$array_value='')
	{
		global $config;
		if($array_value!=='')
			return ($value!='' && isset($config[$value][$array_value]))?$config[$value][$array_value]:'';
		else
			return ($value!='' && isset($config[$value]))?$config[$value]:'';
	}
}

class config_page 
{
	static function get($value='',$array_value='')
	{
		global $config_page;
		if($array_value!=='')
			return ($value!='' && isset($config_page[$value][$array_value]))?$config_page[$value][$array_value]:'';
		else
			return ($value!='' && isset($config_page[$value]))?$config_page[$value]:'';
	}
}
?>
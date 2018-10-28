<?php
/**
*	Classe traduction - Permet la traduction de texte selon la langue
*	@author Fabien Selles
*	@copyright Parc national des Écrins
*	
*/

class traduction
{
	private static $textes 		=	 	array();
	private static $langue 		= 		'';
	private static $langueISO 	= 		'';
	
	static function t($text='',$return = 0)
	{
		/* Chargement de la langue et des textes si non présents */
		traduction::set_langue();
		$texte_sent = 'Traduction a faire :'.$text;
		if(count(static::$textes) == 0)
			traduction::load();
		if (isset(static::$textes[$text]))
			$texte_sent = static::$textes[$text];
		if($return == 1)
			return $texte_sent;
		else
			echo $texte_sent;
	}
	
	
	static function load()
	{
		include('locale'.config::get('system_separateur').$_SESSION['langueISO'].'.php');
		static::$textes = $lang;
	}
	
	static function set_langue()
	{
		if(isset($_GET['langue']) && (isset($_SESSION['langue']) && $_GET['langue'] != $_SESSION['langue']))
		{
			if(in_array($_SESSION['langue'], config::get('langue_dispo')))
				$_SESSION['langue'] = $_GET['langue'];
			else
				$_SESSION['langue'] = config::get('langue_defaut');
		}
		elseif(!isset($_SESSION['langue']))
			$_SESSION['langue'] = config::get('langue_defaut');
			
			
		self::$langue 		= $_SESSION['langue'];
		self::$langueISO 	= array_search($_SESSION['langue'], config::get('langue_dispo'));
		$_SESSION['langueISO'] = self::$langueISO;
		traduction::load();
	}
	
	static function get_langue()
	{
		return self::$langue;
	}
	
	static function get_langue_iso()
	{
		return self::$langue;
	}
}

?>
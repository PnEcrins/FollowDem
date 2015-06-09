<?php
/**
*	Bootstrap - Paramètrage initiale des actions PHP objet - Erreur, autoload, route...etc
*	@author Fabien Selles
*	@date 2013-07-25
*	@copyright Parc national des Écrins
*	
*/

include_once('config.php');

/*Définition de la langue*/
traduction::set_langue();

/*Définition des locales*/
setlocale(LC_ALL,$_SESSION['langueISO'].'.'.config::get('encodage'));

/*Définition de l'encodage*/
header('Content-Type: text/html; charset='.config::get('encodage'));
ini_set('default_charset', config::get('encodage'));

$smarty = api::smarty();

/**	Initialisation Smarty*/
$smarty->debugging = config::get('smarty_debugging');
$smarty->caching = config::get('smarty_caching');
$smarty->cache_lifetime = config::get('smarty_cache_lifetime');


/** Controller et action par defaut*/
$controler = 'controler';
$action = 'last_trace';


/*Gestion exception et erreur*/
function erreur_handler($code, $msg, $file, $line)
{
    throw new Exception($msg, $code);
}
//set_error_handler('erreur_handler');


/* autoload des classe */
function __autoload($classe)
{
	global $config;
	
	$to_load = $config['rep_appli'].'classes'.$config['system_separateur'].strtolower($classe).'.class.php'; /*Version nom.class.php */
	if (is_readable($to_load)) 
	{
		/* Classes à la racine */
		include_once $to_load;
	}
	elseif(strncmp(strtolower($classe), 'smarty_internal_', 16)===0)
	{
		/* Classes Smarty */
		$classe = strtolower($classe);
		$to_load = $config['rep_appli'].'classes'.$config['system_separateur'].'Smarty'.$config['system_separateur'].'sysplugins'.$config['system_separateur'].$classe.'.php';	
		if (is_readable($to_load)) 
			include_once $to_load;
		else
			throw new Exception("Impossible de charger $to_load.");
	}
	else
	{
		/* Classes dans un sous répertoire classe */
		$to_load = $config['rep_appli'].'classes'.$config['system_separateur'].$classe.$config['system_separateur'].$classe.'.class.php';
		if (is_readable($to_load)) 
			include_once $to_load;
		else
			throw new Exception("Impossible de charger $to_load.");
	}
}




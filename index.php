<?php
/**
*	Controleur principal
*	Configuration de l'application et appel des controleurs
*	@author Fabien Selles
*	@copyright Parc National des Écrins
*/
try
{
	/* Initialisation de l'application */
	include_once('config/bootstrap.php');

	/*Récupération du controler et de l'action*/
	if(isset($_GET['controler']) && $_GET['controler']!='')
		$controler = trim(htmlentities($_GET['controler']));
	if(isset($_GET['action']) && $_GET['action']!='')
		$action = trim(htmlentities($_GET['action']));

	/* Appel du controleur */
	$controler = new $controler($action);
}
catch(Exception  $e)
{
	/* Gestion des exceptions et erreurs catchables selon le mode Debug */
	if (config::get('debug') == true)
	{
		echo '<pre>';
		echo 'Message :'.$e->getMessage();
		echo '<br />Code :'.$e->getCode();
		echo '<br />Fichier :'.$e->getFile();
		echo '<br />ligne :'.$e->getLine();
		echo '<br />Trace :'.$e->getTraceAsString();
		echo '</pre>';
	}
	else
	{
		/* ToDo : afficher un message lisible utilisateur */
		echo 'No debug';
	}
}
?>

<?php
try
{
	include_once('config/bootstrap.php');
	
	/*Récupération du controler et de l'action*/
	if(isset($_GET['controler']) && $_GET['controler']!='')
		$controler = trim(htmlentities($_GET['controler']));
	if(isset($_GET['action']) && $_GET['action']!='')
		$action = trim(htmlentities($_GET['action']));

	$controler = new $controler($action);
}
catch(Exception  $e)
{
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
		echo 'No debug';
	}
}
?>

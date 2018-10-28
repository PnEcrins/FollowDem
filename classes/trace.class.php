<?php

/**
*	Classe trace (logs) - logue toutes les actions (écriture/update/suppression) de la BDD
*	@author Fabien Selles
*	@copyright Parc National des Écrins
*	
*/

class trace
{
	public static function add($texte)
	{
		$db=db::get();
		$rqi = $db->prepare('INSERT INTO '.config::get('db_prefixe').'logs VALUES(?,?,?)');
		$rqi->execute(array('',date("Y-m-d h:m:i"),$texte));
		
		if (config::get('debug'))
			echo '<pre>TRACE :'.date("Y-m-d h:m:i").' : '.$texte.'</pre>';
	}

}
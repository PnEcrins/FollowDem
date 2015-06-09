<?php
/**
*	Classe DB - 
* 	Class DB pour la connexion à la DB par PDO avec singleton
*	@author Fabien Selles
*	@copyright Parc National des Écrins
*	
*/

class DB extends PDO
{
	/**
	* Instance de la classe PDO
	*
	* @var PDO
	* @access private
	*/
	private $PDOInstance = null;
	
	
	/**
	* Instance de la classe DB
	*
	* @var DB
	* @access private
	* @static
	*/
	private static $instance = null;
	
	/**
	* Constructeur
	*
	* @param void
	* @return void
	* @see PDO::__construct()
	* @access private
	*/
	
	/**
	* Crée et retourne l'objet DB
	*
	* @access public
	* @static
	* @param void
	* @return DB $instance
	*/
	public static function get()
	{
		if(is_null(static::$instance))
			static::$instance = new PDO(config::get('db_type').':dbname='.config::get('db_name').';host='.config::get('db_host').';charset='.config::get('db_encodage'),config::get('db_user'),config::get('db_password'));
		
		return static::$instance;
	}
	
}
<?php
/**
*	Classe propriete - Permet l'intéraction avec les données et le traitement des données
*	@author Fabien Selles
*	@date 2013-07-25
*	@copyright Parc national des Écrins
*	
*/


class objects_features
{

	protected 	$id_tracked_objects 			= 0;
	protected 	$nom_prop 			= '';
	protected 	$valeur_prop 		= '';
	
	public function __construct($id_tracked_objects=0,$nom_prop='')
	{
		
		if ($id_tracked_objects !== 0)
			$this->set_id_tracked_objects($id_tracked_objects);
		if	($nom_prop !== '')
			$this->nom_prop = $nom_prop;
			
		if ($this->get_id_tracked_objects()!==0 && $this->get_nom_prop()!='')
			$this->load();
	}
	
	public function set_id_tracked_objects($id_tracked_objects)
	{
		$this->id_tracked_objects = $id_tracked_objects;
	}
	public function set_nom_prop($nom_prop)
	{
		$this->nom_prop = trim($nom_prop);
	}
	public function set_valeur_prop($valeur_prop)
	{
		$this->valeur_prop = trim($valeur_prop);
	}

	
	public function get_id_tracked_objects()
	{
		return $this->id_tracked_objects;
	}
	public function get_nom_prop()
	{
		return $this->nom_prop;
	}
	public function get_valeur_prop()
	{
		return $this->valeur_prop;
	}

	/**
	* 	Sauvegarde une propriété
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	public function save()
	{
		if(!$this->exist($update=true))
			$this->insert();
	}
	
	
	/**
	* 	Charge une propriété
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	private function load()
	{
		$db=db::get();
		$rql = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = ? AND nom_prop=?');
		$rql->execute(array($this->get_id_tracked_objects(), $this->get_nom_prop()));
		if($result = $rql->fetchObject())
		{
			$this->set_id_tracked_objects($result->id_tracked_objects);
			$this->set_nom_prop($result->nom_prop);
			$this->set_valeur_prop($result->valeur_prop);
		}
	}
	
	/**
	* 	Vérifie si une propriété existe
	*	S'il existe possibilité d'Update, $update = true
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	private function exist($update=false)
	{
		$db=db::get();
		$rqe = $db->prepare('SELECT count(id_tracked_objects) as nb,nom_prop,valeur_prop FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = ? AND nom_prop= ?');
		$rqe->execute(array($this->get_id_tracked_objects(),$this->get_nom_prop()));
		$results = $rqe->fetchObject();
		if ($results===false || $results->nb == 0) 
			return false;
		elseif($update===true && $results->valeur_prop != $this->get_valeur_prop())
			$this->update();
			
		return true;
	}
	
	/**
	* 	Insert une propriété
	*
	* 	@access  private
	* 	@return  

	*/
	private function insert()
	{
		$db=db::get();
		$rqi = $db->prepare('INSERT INTO '.config::get('db_prefixe').'objects_features VALUES(?,?,?)');
		$rqi->execute(array($this->get_id_tracked_objects(),$this->get_nom_prop(),$this->get_valeur_prop()));

		trace::add("Ajout proprite id=".$this->get_id_tracked_objects().' - Nom :'.$this->get_nom_prop().'Valeur :'.$this->get_valeur_prop());
	}
	
	/**
	* 	Update une propriété
	*
	* 	@access  private
	* 	@return  
	*/
	private function update()
	{
		$db=db::get();
		$rqu = $db->prepare('UPDATE '.config::get('db_prefixe').'objects_features SET valeur_prop=? WHERE id_tracked_objects=? AND nom_prop=?');
		$rqu->execute(array($this->get_valeur_prop(),$this->get_id_tracked_objects(),$this->get_nom_prop()));
		
		trace::add("update objects_features id_tracked_objects=".$this->get_id_tracked_objects().'--'.$this->get_nom_prop().'--'.$this->get_valeur_prop());
	}
	/**
	* 	Delete une propriété
	*
	* 	@access  private
	* 	@return  
	*/
	private function delete()
	{
		$db=db::get();
		$rqd = $db->prepare('DELETE FROM '.config::get('db_prefixe').'objects_features WHERE id_tracked_objects=? AND nom_prop=?');
		$rqd->execute(array($this->get_id_tracked_objects(),$this->get_nom_prop()));
		
		trace::add("Suppression objects_features id=".$this->get_id_tracked_objects().'--'.$this->get_nom_prop().'--'.$this->get_valeur_prop());
		
	}
	
	
	/**
	* 	Charge toutes les objects_features ou les propriétés de l'objet si $id_objet retourne un tableau d'objets et de propriétés
	*
	* 	@access  static
	* 	@return  array
	* 	@param	id_tracked_objects, order
	*/
	
	public static function load_all($id_tracked_objects=0,$order='nom_prop')
	{
		$db=db::get();
		$tmp_objects_features = array();
		
		if($id_tracked_objects===0)
		{
			$rqs = $db->prepare('SELECT id_tracked_objects, nom_prop FROM '.config::get('db_prefixe').'objects_features ORDER BY '.$order);
			$rqs->execute();
		}
		else
		{

			$rqs = $db->prepare('SELECT id_tracked_objects, nom_prop FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = ?  ORDER BY '.$order);			
			$rqs->execute(array($id_tracked_objects));
		}
		while($result = $rqs->fetchObject())
			$tmp_objects_features[$result->nom_prop] = new objects_features($result->id_tracked_objects,$result->nom_prop);

		return $tmp_objects_features;
	}
}
?>
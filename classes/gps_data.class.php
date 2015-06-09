<?php
/**
*	Classe donnee - Permet l'interaction avec les données et le traitement des données
*	@author Fabien Selles
*	@date 2013-07-25
*	@copyright Parc national des Écrins
*	
*/
//@include_once tracked_objects.class.php
//extends tracked_objects

class gps_data
{

	protected 	$id		 				= 0;
	protected 	$id_tracked_objects 				= 0;
	protected 	$dateheure 				= null;
	protected 	$latitude 				= 0;
	protected 	$longitude 				= 0;
	protected 	$temperature 			= 0;
	protected 	$nb_satellites 			= 0;
	protected 	$altitude 				= 0;
	
	public function __construct($id=0)
	{
		if ($id !== 0)
		{
			$this->set_id($id);
			$this->load();
		}
	}
	
	public function set_id($id)
	{
		$this->id = $id;
	}
	public function set_id_tracked_objects($id_tracked_objects)
	{
		$this->id_tracked_objects = $id_tracked_objects;
	}
	public function set_dateheure($dateheure)
	{
		$this->dateheure = $dateheure;
	}
	public function set_latitude($latitude)
	{
		$this->latitude = trim(str_replace(',','.',$latitude));
	}
	public function set_longitude($longitude)
	{
		$this->longitude = trim(str_replace(',','.',$longitude));
	}
	public function set_temperature($temperature)
	{
		$this->temperature = trim($temperature);
	}
	public function set_nb_satellites($nb_satellites)
	{
		$this->nb_satellites = trim($nb_satellites);
	}
	public function set_altitude($altitude)
	{
		$this->altitude = trim($altitude);
	}

	public function get_id()
	{
		return $this->id;
	}
	public function get_id_tracked_objects()
	{
		return $this->id_tracked_objects;
	}
	public function get_dateheure()
	{
		$tz 	= new DateTimeZone(config::get('fuseau'));
		$date	= new DateTime($this->dateheure,$tz);
		return strftime(config::get('datesortie'), $date->getTimestamp());
	}
	private function get_dateheure_bdd()
	{
		return $this->dateheure;
	}

	public function get_valeur_prop()
	{
		return $this->valeur_prop;
	}
	public function get_latitude()
	{
		return str_replace(',','.',(float)$this->latitude);
	}
	public function get_longitude()
	{
		return str_replace(',','.',(float)$this->longitude);
	}
	public function get_temperature()
	{
		return $this->temperature;
	}
	public function get_nb_satellites()
	{
		return $this->nb_satellites;
	}
	public function get_altitude()
	{
		return $this->altitude;
	}

	/**
	* 	Sauvegarde une propriete
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
	* 	Charge une propriete
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	private function load()
	{
		$db=db::get();
		$rql = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'gps_data where id = ?');
		$rql->execute(array($this->get_id()));
		if($result = $rql->fetchObject())
		{
			$this->set_id($result->id);
			$this->set_id_tracked_objects($result->id_tracked_objects);
			$this->set_dateheure($result->dateheure);
			$this->set_latitude($result->latitude);
			$this->set_longitude($result->longitude);
			$this->set_temperature($result->temperature);
			$this->set_nb_satellites($result->nb_satellites);
			$this->set_altitude($result->altitude);
		}
	}
	
	/**
	* 	Vérifie si une donnee existe
	*	Pas d'update - Une propriété saisie est ignorée - La methode update est concervée par convension
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	private function exist($update=false)
	{
		$db=db::get();
		$rqe = $db->prepare('SELECT count(id) as nb,id_tracked_objects,dateheure FROM '.config::get('db_prefixe').'gps_data where id_tracked_objects = ? AND dateheure = ?');
		$rqe->execute(array($this->get_id_tracked_objects(), $this->get_dateheure_bdd()));
		
		$results = $rqe->fetchObject();
		if ($results===false || $results->nb == 0) 
			return false;
			
		return true;
	}
	
	/**
	* 	Insert une donnee
	*
	* 	@access  private
	* 	@return  

	*/
	private function insert()
	{
		$db=db::get();
		$rqi = $db->prepare('INSERT INTO '.config::get('db_prefixe').'gps_data VALUES(?,?,?,?,?,?,?,?)');
		$rqi->execute(array($this->get_id(),$this->get_id_tracked_objects(),$this->get_dateheure_bdd(),$this->get_latitude(),$this->get_longitude(),$this->get_temperature(),$this->get_nb_satellites(),$this->get_altitude()));
		if ($rqi->rowCount() === 0)
		{
			trace::add("ERREUR ajout gps_data id=".$this->get_id_tracked_objects().' - id_tracked_objects :'.$this->get_id_tracked_objects());
		}
		else
		{
			trace::add("Ajout gps_data id=".$this->get_id_tracked_objects().' - id_tracked_objects :'.$this->get_id_tracked_objects());
		}
	}
	
	/**
	* 	Update une donnee
	*	Concervée par convension - Normalement pas d'Update sur les données insérées.
	* 	@access  private
	* 	@return  
	*/
	private function update()
	{
		$db=db::get();
		$rqu = $db->prepare('UPDATE '.config::get('db_prefixe').'gps_data SET id_tracked_objects=?,dateheure=?,latitude=?,longitude=?,temperature=?,nb_satellite=?,altitude=? WHERE id=?');
		$rqu->execute(array($this->get_id_tracked_objects(),$this->get_dateheure_bdd(),$this->get_latitude(),$this->get_longitude(),$this->get_temperature(),$this->get_nb_satellites(),$this->get_altitude(),$this->get_id()));
		//$rqu->execute(array($this->get_id_tracked_objects(),$this->get_dateheure_bdd(),$this->get_latitude(),$this->get_longitude(),$this->get_temperature(),$this->get_nb_satellites(),$this->get_altitude(),$this->get_id()));
		if ($rqu->rowCount() === 0){
			trace::add("ERREUR update gps_data id=".$this->get_id().'--'.$this->get_id_tracked_objects());
		}
		else {		
			trace::add("update gps_data id=".$this->get_id().'--'.$this->get_id_tracked_objects());
		}
	}
	/**
	* 	Delete une propriete
	*
	* 	@access  private
	* 	@return  
	*/
	private function delete()
	{
		$db=db::get();
		$rqd = $db->prepare('DELETE FROM '.config::get('db_prefixe').'gps_data WHERE id=?');
		$rqd->execute(array($this->get_id_tracked_objects(),$this->get_nom_prop()));
		if ($rqd->rowCount() === 0){
			trace::add("ERREUR Suppression gps_data id=".$this->get_id().'--'.$this->get_id_tracked_objects());
		}
		else {
			trace::add("Suppression gps_data id=".$this->get_id().'--'.$this->get_id_tracked_objects());
		}
	}
	
	
	/**
	* 	Charge toutes les donnee de l'objet si $id_tracked_objects - Retourne un tableau d'objets propriétés
	*	Attention si $id_tracked_objects=0 - Chargement et requête peut-être long !
	* 	@access  static
	* 	@return  array
	* 	@param	id_tracked_objects, order
	*/
	
	static function load_all($id_tracked_objects=0,$order='nom_prop')
	{
		$db=db::get();
		$tmp_gps_data = array();
		
		if($id_tracked_objects===0)
		{
			$rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'gps_data ORDER BY '.$order);
			$rqs->execute();
		}
		else
		{
			$rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = ? ORDER BY '.$order);			
			$rqs->execute(array($id_tracked_objects));
		}
		while($result = $rqs->fetchObject())
			$tmp_gps_data[] = new objects_features($result->id);

		return $tmp_gps_data;
	}
	
	/**
	* 	Charge toutes les donnee entre 2 dates ou la dernières dates
	*	Attention si $id_tracked_objects=0 - Chargement et requête peut-être long !
	* 	@access  static
	* 	@return  array
	* 	@param	id_tracked_objects, date_deb, date_fin, last_donnee (dernières données seulement), order, $count_only(compte seulement si des données existent)
	*/
	
	static function load_all_by_date($id_tracked_objects=0,$date_deb=null,$date_fin=null,$last_gps_data=true,$count_only=false, $order='dateheure')
	{
		$db=db::get();
		$tmp_gps_data = array();
		
		$where = '';
		$prepare = array();
		$next = '';
		if($id_tracked_objects!==0)
		{
			$where.=' id_tracked_objects = ?';
			$prepare[]=$id_tracked_objects;
			$next = ' AND ';
		}
		
		if($last_gps_data === false)
		{
			if($date_deb!=null)
			{
				$where.=$next.'dateheure > ?';
				$prepare[]=$date_deb;
				$next = ' AND ';
			}
			if($date_fin!=null)
			{
				$where.=$next.'dateheure < ?';
				$prepare[]=$date_fin;
			}
		}
		else
		{
			$where.= $next.'dateheure IN (SELECT max(dateheure) FROM '.config::get('db_prefixe').'gps_data WHERE'.$where.' )';
			$prepare = array_merge($prepare,$prepare);
		}
		
		/*echo '<pre> SQL = SELECT id FROM '.config::get('db_prefixe').'gps_data where '.$where.' ORDER BY '.$order;
		echo print_r($prepare,true).'</pre>';*/
		
		if($count_only === true)
			$rqs = $db->prepare('SELECT count(id) as NB FROM '.config::get('db_prefixe').'gps_data where '.$where.' ORDER BY '.$order);
		else
			$rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'gps_data where '.$where.' ORDER BY '.$order);

		$rqs->execute($prepare);
		
		/*if($id_tracked_objects==0)
		{
			$rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'gps_data ORDER BY '.$order);
			$rqs->execute();
		}
		else
		{
			$rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'objects_features where id_tracked_objects = ? ORDER BY '.$order);			
			$rqs->execute(array($id_tracked_objects));
		}*/

		if($count_only === true)
		{
			$result = $rqs->fetchObject();
			if($result->NB > 0)
				return true;
			return false;
		}
		else
		{
			while($result = $rqs->fetchObject())
				$tmp_gps_data[] = new gps_data($result->id);
			
			//echo "<br />Nombre de donnée :".count($tmp_gps_data);
			if(count($tmp_gps_data) > 0)
				return $tmp_gps_data;
			else
				return false;
		}
	}
	
}
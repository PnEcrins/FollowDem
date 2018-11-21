<?php
/**
*	Classe Objet - Permet l'intéraction avec les données d'un objet traqué.
*	@author Fabien Selles
*	@date 2013-07-25
*	@copyright Parc National des Écrins
*	
*/


class tracked_objects 
{

	protected 	$nom 			= '';
	protected 	$id 			= '';
	protected 	$date_creation 	= NULL;
	protected 	$date_maj	 	= NULL;
	protected 	$active 		= 0;
	protected 	$objects_features 	= array();
	protected 	$gps_data 		= array();
	
	
	public function __construct($id=null,$load_all=true)
	{
		if ($id !== null)
		{
			$this->set_id($id);
			$this->load($load_all);
		}
		else
		{
			$this->set_date_creation(date('Y-m-d H:m:i',time()));
			$this->set_date_maj(date('Y-m-d H:m:i',time()));
			$this->active = 1;
		}
	}
	
	public function set_nom($nom='')
	{
		$this->nom = trim($nom);
	}
	public function set_id($id='')
	{
		$this->id = $id;
	}
	
	public function set_active($active='')
	{
		$this->active = $active;
	}
	
	public function set_date_creation($date_creation='')
	{
		$this->date_creation = $date_creation;
	}
	
	public function set_date_maj($date_maj='')
	{
		$this->date_maj = $date_maj;
	}
	
	public function set_objects_features($objects_features='')
	{
		
		$this->objects_features = $objects_features;
		

	}
	public function set_gps_data($gps_data='')
	{

		$this->gps_data = $gps_data;

	}
	
	public function get_nom()
	{
		return $this->nom;
	}
	public function get_id()
	{
		return $this->id;
	}
	
	public function get_active()
	{
		return $this->active;
	}
	
	public function get_date_creation()
	{
		$tz 	= new DateTimeZone(config::get('fuseau'));
		$date	= new DateTime($this->date_creation,$tz);
		return strftime(config::get('datesortie'), $date->getTimestamp());
	}
	
	public function get_date_creation_bdd()
	{
		return $this->date_creation;
	}
	
	public function get_date_maj()
	{
		$tz 	= new DateTimeZone(config::get('fuseau'));
		$date	= new DateTime($this->get_date_maj,$tz);
		return strftime(config::get('datesortie'), $date->getTimestamp());
	}
	
	
	public function get_date_maj_bdd()
	{
		return $this->date_maj;
	}
	
	
	/* Renvoie tableau d'objet et de propriété */
	public function get_objects_features($object_feature)
	{
		return $this->objects_features;
	}
	/* Renvoie la valeur de la propriété demandée */
	public function get_object_feature($prop='')
	{
		if ($prop !='' && isset($this->objects_features[$prop]))
		{
			return $this->objects_features[$prop]->get_valeur_prop();
		}
		
		return false;
	}
	public function get_gps_data()
	{
		return $this->gps_data;
	}

	
	
	
	/**
	* 	Charge l'objet
	*	Si load_gps_data = true, charge l'objet + données complètes
	*	Sinon objet + objects_features seulement
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param load_gps_data
	*/
	
	private function load($load_gps_data=false)
	{
		$db=db::get();
		$rqs = $db->prepare('SELECT id,nom,active,date_creation,date_maj FROM '.config::get('db_prefixe').'tracked_objects where id = ?');
		$rqs->execute(array($this->id));
		
		if($results = $rqs->fetchObject())
		{
			$this->set_nom($results->nom);
			

			$this->set_objects_features(objects_features::load_all($this->get_id()));
			
			$this->set_active($results->active);
			$this->set_date_creation($results->date_creation);
			$this->set_date_maj($results->date_maj);
			
			if($load_gps_data==true)
				$this->set_gps_data(gps_data::load_all($this->get_id()));
		}
		else
		{
			/*Erreur code 10 - Incohérence BDD*/
			throw new erreur(10);
		}
	}
	
	
	/**
	* 	Sauve l'objet, ses données et propriétés
	*	Si load = 1, charge l'objet + les données + les propriétés
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	
	private function save()
	{
		if(!$this->exist($update=true))
			$this->insert();
		
		//Si on a des propriétés à sauver :
		if (is_array($this->objects_features) && count($this->objects_features) > 0)
		{
			foreach($this->objects_features as $object_feature)
				$object_feature->save();
		}
		//Si on a des données à sauver
		if (count($this->gps_data) > 0)
		{
			foreach($this->gps_data as $data)
				$data->save();
		}
			
		trace::add("gps_data tracked_objects maj/ajoutée id=".$this->get_id().'--'.$this->get_nom());
	}
	
	/**
	* 	Vérifie si un objet existe
	*	S'il existe, possibilité d'Update, $update = true
	*
	* 	@access  private
	* 	@return  boolean
	* 	@param
	*/
	
	private function exist($update=false)
	{
		$db=db::get();
		$rqe = $db->prepare('SELECT count(id) as nb,nom,date_maj FROM '.config::get('db_prefixe').'tracked_objects where id = ?');
		$rqe->execute(array($this->get_id()));
		$results = $rqe->fetchObject();
		if ($results===false || $results->nb == 0) 
			return false;
		elseif($update===true && ($results->nom != $this->get_nom() || $results->date_maj != $this->get_date_maj_bdd()))
			$this->update();
			
		return true;
	}
	
	/**
	* 	Insert un Objet
	*
	* 	@access  private
	* 	@return  

	*/
	private function insert()
	{
		$db=db::get();
		$rqi = $db->prepare('INSERT INTO '.config::get('db_prefixe').'tracked_objects VALUES(?,?,?,?,?)');
		$rqi->execute(array($this->get_id(),$this->get_nom(),$this->get_date_creation_bdd(),$this->get_date_maj_bdd(),$this->get_active()));
		
		trace::add("Ajout tracked_objects id=".$this->get_id().'--'.$this->get_nom());
	}
	
	/**
	* 	Update un Objet
	*
	* 	@access  private
	* 	@return  
	*/
	private function update()
	{
		$db=db::get();
		$rqu = $db->prepare('UPDATE '.config::get('db_prefixe').'tracked_objects SET nom=?,date_maj=?,active=? WHERE id=?');
		$rqu->execute(array($this->get_nom(),$this->get_date_maj_bdd(),$this->get_active(),$this->get_id()));
		if ($rqu->rowCount() === 0){
			trace::add('ERREUR (<pre>'.print_r($rqu->errorInfo(),true).'</pre>) update tracked_objects id='.$this->get_id().'--'.$this->get_nom(),$this->get_date_maj_bdd(),$this->get_active());
		}
		else {		
			trace::add("update tracked_objects id=".$this->get_id().'--'.$this->get_nom(),$this->get_date_maj_bdd(),$this->get_active());
		}
	}
	/**
	* 	Delete un Objet
	*
	* 	@access  private
	* 	@return  
	*/
	private function delete($cascade=true)
	{
		$db=db::get();
		$rqd = $db->prepare('DELETE FROM '.config::get('db_prefixe').'tracked_objects WHERE id=?');
		$rqd->execute(array($this->get_id()));
		trace::add("Suppression tracked_objects id=".$this->get_id().'--'.$this->get_nom());
		if($cascade===true)
		{
			trace::add("Suppression gps_data tracked_objects id=".$this->get_id().'--'.$this->get_nom());
			foreach($gps_data as $data)
				$data->delete();
			
			trace::add("Suppression objects_features tracked_objects id=".$this->get_id().'--'.$this->get_nom());
			foreach($objects_features as $object_feature)
				$object_feature->delete();
		}
		
		
	}
	
	/**
	* 	load_all
	* 	Renvoie un tableau d'objet Objet
	*	Voir la config "date_data_valide" qui permet d'éliminer les objets non mis à jour depuis un certains temps.
	*	load_gps_data : précise les données chargées avec l'objet. Valeurs possibles : load_donnees_last  - load_donnees_date - load_donnees_all
	* 	@access  public
	* 	@return  array
	*	@param 	 order, load_gps_data
	*/
	static function load_all($order='id',$load_gps_data='load_gps_data_last')
	{	
		$db=db::get();
		$tmp_tracked_objects = array();
		
		$rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'tracked_objects WHERE active=1 ORDER BY '.$order);			
		$rqs->execute();
		
		$i = 0;
		while($result = $rqs->fetchObject())
		{
			/*Vérifie que l'objet a des données mises à jour */
			$d = new DateTime();
			$d->sub(new DateInterval('P'.config::get('date_data_valide').'D'));
			

			
			if(gps_data::load_all_by_date($result->id,$d->format('Y-m-d H:m:i'),date('Y-m-d H:m:i'),false,true)!== false)
			{
				$tmp_tracked_objects[$i] = new tracked_objects($result->id);
				$tmp_tracked_objects[$i]->$load_gps_data();
				$i++;
			}
		}
		return $tmp_tracked_objects;
	}
	
	/*Charge les dernières données de l'objet 
	* 	@access  public
	* 	@return  boolean
	* 	@param
	*/
	public function load_gps_data_last()
	{
		$this->set_gps_data(gps_data::load_all_by_date($this->get_id()));	
	}
	
	/*Charge les données de l'objet sur une période
	* 	@access  public
	* 	@return  boolean
	* 	@param	date_deb,date_fin,intervale(un intervale entre chaque capture de données - 1 donnée par jour par exemple)
	*	
	*/
	public function load_gps_data_date($date_deb=null,$date_fin=null,$intervale=null)
	{
		if($date_deb !== null)
		{
			if($date_fin === null){$date_fin = date('Y-m-d H:m:i',time());}
			$this->set_gps_data(gps_data::load_all_by_date($this->get_id(),$date_deb,$date_fin,false));
		}
	}
	
	/*Charge les dernières données de l'objet 
	* 	@access  public
	* 	@return  boolean
	* 	@param
	*/
	public function load_gps_data_all()
	{
		$this->set_gps_data(gps_data::load_all($this->get_id()));	
	}
	
	
	/**
	* 	import_csv
	* 	Importe les nouvelles données à partir d'un fichier CSV pour les stocker dans la BDD. 
	*	Pas de paramétrage d'emplacement de fichier.
	* 	Fichier placé dans le répertoire csv/tracked_objects.csv obligatoirement (traitement en CRON possible - Cf controleur).
	*
	* 	@access  public
	* 	@return  none
	*/
	static function import_csv($delimiter=',',$enclosure='"')
	{
		/*Connexion BDD*/
		$db=db::get();
		$last_date_tracked_objects = array();
		
		//Séparateur de ligne pour les affichages log
		$line = "\r\n\t";
		
		if($delimiter=='') {$delimiter==config::get('csv_separateur');}
		if($enclosure=='') {$enclosure==config::get('csv_enclosure');}
		if (($fs = fopen(config::get('csv_repertoire').config::get('system_separateur').config::get('csv_name'), "r")) !== FALSE) 
		{
			echo $line."Traitement du fichier CSV : ";
			while (($data = fgetcsv($fs,0,$delimiter,$enclosure)) !== FALSE) 
			{

				
				/*Construction condition d'import*/
				$tmp_next ='';
				$tmp_condition='';
				foreach(config::get('csv_condition') as $valeurs)
				{
					$clef= $valeurs[0];
					$valeur= $valeurs[1];
					if(config::get('csv_condition_type',$clef) == 'numeric') 
					{
						$tmp_data=str_replace(',','.',$data[$clef]);
						if (!is_numeric($tmp_data))
							$tmp_data = 0;
					}
					else{$tmp_data=$data[$clef];}
					$tmp_condition.= $tmp_next.$tmp_data.$valeur;
					$tmp_next = ' && ';
				}
				eval('$result_cond = ('.$tmp_condition.');');
				
				echo $line."\t Condition sur les données récupérées : ".$tmp_condition.' -> résultat :'.$result_cond;
				
				if($result_cond)
				{
					echo $line.'Données répondant aux conditions';
					$tmp_tracked_objects = new tracked_objects();
					$tmp_tracked_objects->set_nom($data[config::get('csv_colonne','nom')]);
					$tmp_tracked_objects->set_id($data[config::get('csv_colonne','id')]);

					
					
					
					/* Gestion des dates */
					$tmp_date	= $data[config::get('csv_colonne','date')].((config::get('csv_colonne','heure') !=-1)?' '.$data[config::get('csv_colonne','heure')]:'');
					echo $line.'Date :'.$data[config::get('csv_colonne','date')].' '.$data[config::get('csv_colonne','heure')];
					$obj_date 	= DateTime::createFromFormat(config::get('csv_date_format').' '.config::get('csv_heure_format'), $tmp_date);
					
					/* Fait une mise à jour de la date une fois les données saisies complétement. */
					if(isset($last_date_tracked_objects[$tmp_tracked_objects->get_id()]))
					{
						if($last_date_tracked_objects[$tmp_tracked_objects->get_id()] <  $obj_date->format('Y-m-d H:i:s'))
						{
							$last_date_tracked_objects[$tmp_tracked_objects->get_id()] = $obj_date->format('Y-m-d H:i:s');
							$tmp_tracked_objects->set_date_maj($obj_date->format('Y-m-d H:i:s'));
						}
					}
					else
					{
						$last_date_tracked_objects[$tmp_tracked_objects->get_id()] = $obj_date->format('Y-m-d H:i:s');
						$tmp_tracked_objects->set_date_maj($obj_date->format('Y-m-d H:i:s'));
					}
					
					/*Affectation des données*/
					$gps_data 	= new gps_data();
					$gps_data		->set_id_tracked_objects($tmp_tracked_objects->get_id());
					$gps_data		->set_dateheure($obj_date->format('Y-m-d H:i:s'));
					$gps_data		->set_latitude($data[config::get('csv_colonne','latitude')]);
					$gps_data		->set_longitude($data[config::get('csv_colonne','longitude')]);
					$gps_data		->set_temperature($data[config::get('csv_colonne','temperature')]);
					$gps_data		->set_nb_satellites($data[config::get('csv_colonne','sat_number')]);
					$gps_data		->set_altitude($data[config::get('csv_colonne','altitude')]);
					$tmp_tracked_objects	->set_gps_data(array($gps_data));
					
					
					
					/*Affectation des propriétés*/
					
					$tmp_objects_features							= 	array();
					

					
					foreach(config::get('csv_colonne_objects_features') as $clef=>$value)
					{
						$object_feature 	= new object_feature();
						$object_feature->set_id_tracked_objects($tmp_tracked_objects->get_id());
						$object_feature->set_nom_prop($clef);
						$object_feature->set_valeur_prop($value);
						$tmp_objects_features[$clef] = $object_feature;
					}
					$tmp_tracked_objects->set_objects_features($tmp_objects_features);
					
					echo $line.'tracked_objects sauvardé :'.print_r($tmp_tracked_objects);
					
					$tmp_tracked_objects->save();
				}	
				else
					echo $line.'gps_data ne répondant pas aux conditions';
			}
			fclose($fs);
			echo $line.'Dernière date de capture sauvées :'.print_r($last_date_tracked_objects);
			
		}
	
	}
	
	/**
	*	get_couleur_name
	*
	*	HACK pour récupérer les paramètres des couleurs dans le nom de l'objet contenu entre parenthèses
	*	Appel à cette fonctione désactivable dans le fichier config, ainsi que les codes couleurs
	*
	*/
	static function get_couleur_name(tracked_objects $bouquetins)
	{
		$tmp = preg_split('/[()-]+/',$bouquetins->get_nom());
		
		$tmp_objects_features = array();

		if(isset($tmp[1]) && isset($tmp[2]))
		{
			$bouquetins->set_nom(trim($tmp[0])); // Affectation du nom
			
			
			$couleurD 	= new object_feature();
			$couleurD	->set_id_tracked_objects($bouquetins->get_id());
			$couleurD	->set_nom_prop('couleurD');
			$couleurD	->set_valeur_prop(config::get('recupe_couleur_code',trim(str_replace(array('D','G'),array('',''),$tmp[1]))));
			$tmp_objects_features['couleurD'] = $couleurD;
			
			$couleurG 	= new object_feature();
			$couleurG->set_id_tracked_objects($bouquetins->get_id());
			$couleurG->set_nom_prop('couleurG');
			$couleurG->set_valeur_prop(config::get('recupe_couleur_code',trim(str_replace(array('D','G'),array('',''),$tmp[2]))));
			$tmp_objects_features['couleurG'] = $couleurG;
		}
		return $tmp_objects_features;
	}
}
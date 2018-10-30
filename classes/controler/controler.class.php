<?php
/**
*	Classe controler - Controler principal
* 	Classe qui appelle les données en fonction des actions et construit les retours vers smarty en HTML
*	Controleur basique pour le traitement de l'affichage des données. S'appuie sur la classe API pour la récupération des données
*	@author Fabien Selles
*	@copyright Parc National des écrins
*	
*/

class controler
{
	private $smarty = '';
	
	private $params = array();
	
	public function __construct($action='')
	{
		$this->smarty = api::smarty();
		
		if (isset($_GET['params']))
		{
			
			$tmp = explode('-',$_GET['params']);
			$i=0;
			while($i<count($tmp))
			{
				$this->params[$tmp[$i]] = $tmp[$i+1];
				$i+=2;
			}
		}
		elseif (isset($_POST) && count($_POST) >0)
			$this->params = $_POST;
		
		//echo 'Caching smarty :"'.($this->smarty->caching)?'Ok':'No';
		
		$this->$action();
		
		
		
	}
	
	/**
	* 	last_trace - Affiche une carte avec les données initiales 
	*
	* 	@access  protected
	* 	@return  
	* 	@param
	*/
	protected function last_trace($template="index")
	{
		/*Paramètre de la page*/
		$this->smarty->assign("titre_application",config::get('titre_application'));
		$this->smarty->assign("leaflet_gmap",config::get('leaflet_gmap'));
		
		
		/*Charge tous les objet actifs et leur dernière donnée*/
		$objets = tracked_objects::load_all('nom');
        $animals = Animal::load_all('name');
		//print_r($animals);
		
		/* Initialise le contenu carto lefleat en positionnant les dernières traces */
		$content = api::leaflet_ini($animals);
		
		/*Assigne smarty*/
		$this->smarty->assign('content',$content);
		$this->smarty->assign("animals",$animals);
		
		$this->smarty->assign('periode_min',config::get('periode_min'));
		$this->smarty->assign('periode_max',config::get('periode_max'));
		if(is_array(config::get('periode_valeurs')) && count(config::get('periode_valeurs')))
			$this->smarty->assign('periode_valeurs',config::get('periode_valeurs'));
		else
			$this->smarty->assign('periode_valeurs','');

		$lefleat_style_point_surcharge = config::get('lefleat_style_point_surcharge');
		if(count($lefleat_style_point_surcharge) > 0 && isset($lefleat_style_point_surcharge['color']))
		{	
			$this->smarty->assign("propcouleur",config::get('lefleat_style_point_surcharge','color'));
			$this->smarty->assign("propfilcolor",config::get('lefleat_style_point_surcharge','fillColor'));
		}
		else
		{
			$this->smarty->assign("propcouleur",'');
			$this->smarty->assign("propfilcolor",'');
		}
		
		$this->smarty->assign("sidebar_left",'');
		$this->smarty->assign("sidebarright",'');
		$this->smarty->assign("sidebarbottom",'');

		echo $this->smarty->fetch($template.'.tpl.html');
	}
	
	/**
	* 	Renvoi des données GeoJson (LineString) pour un parcours sur un temps donnés - Appel AJAX !
	*
	* 	@access  protected
	* 	@return  
	* 	@param
	*/
	protected function get_parcours_geojson()
	{
		
		$this->smarty->setCacheLifetime(0);
		
		if(isset($this->params['id_tracked_objects']))
		{
			header('Content-Type: application/json'); 
			
			$animal = new Animal($this->params['id_tracked_objects']);
			
			if (isset($this->params['periode']) && $this->params['periode'] != '')
				$periode = $this->params['periode'];
			else
				$periode =  config::get('periode_min');
				
			if (isset($this->params['type']) && $this->params['type'] != '')
				$type = $this->params['type'];
			else
				$type =  "Line";
			
			$d = new DateTime();
			$d->sub(new DateInterval('P'.$periode.'D'));
            $animal->load_gps_data_date($d->format('Y-m-d H:m:s'),date('Y-m-d H:m:s'));
			$this->smarty->assign("animal",$animal);
			echo $this->smarty->fetch('geojson'.$type.'.tpl.html');
		}
		else
			echo 'OUT';
	
	}
	
	/**
	* 	get_page - Renvoi le contenu d'une template correspondante
	*
	* 	@access  protected
	* 	@return  
	* 	@param
	*/
	protected function get_page()
	{
		$cacheid = $this->params['page'];
		
		$sep = config::get('system_separateur');
		$tpl = 'templates'.$sep.'pages'.$sep.traduction::get_langue().$sep.$this->params['page'].'.tpl.html';
		if(isset($this->params['page']) && file_exists($tpl))
		{
			$this->smarty->assign('template',$tpl);
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				echo $this->smarty->fetch('page_modal.tpl.html',$cacheid);
			}
			else
			{
				$this->smarty->assign("titre_application",config::get('titre_application'));
				echo $this->smarty->fetch('page.tpl.html',$cacheid);
			}
		}
	}

	
	protected function clear_cache()
	{
		$this->smarty->clearAllCache();
	}
	
	
	/**
	* 	Affiche une page non trouvée 404 !
	*
	* 	@access  protected
	* 	@return  
	* 	@param
	*/
	protected function error404()
	{	
		$this->smarty->assign('content',traduction::t('Page non trouvee'));
	}
	
	/**
	* 	import_csv - Importe les données en CSV
	*
	* 	@access  protected
	* 	@return  
	* 	@param
	*/
	protected function import_csv()
	{
		tracked_objects::import_csv();
	}
	
	
	/**
	* 	import_imap_csv - Recupère les pièces jointes d'email (.txt) pour conversion et import en CSV !
	*
	* 	@access  protected
	* 	@return  
	* 	@param
	*/
	protected function import_imap_csv()
	{
		
		$line = "\r\n";
		
		$db=db::get();
		echo $line.'###'.date('d/m/Y H:i').'##################################';
		$line = "\r\n\t".'> ';
		echo $line.'Connexion à la boîte email';
		$imap = new imap(config::get('domaine_import_imap_csv'),993);
		$imap->setAuthentication(config::get('id_authentification_import_imap_csv'),config::get('mdp_authentification_import_imap_csv'));
		$imap->setMailBox('INBOX');
		
		$tmp_rep = 'tmp'.config::get('system_separateur').'csv'.config::get('system_separateur');
		
		$nummessage = $imap->numMessages();
		echo $line.'Nombre de message(s) a traiter :'.$nummessage;
		if ($nummessage > 0)
		{
			$messages = $imap->getMessages();
			foreach($messages as $message)
			{
				if(strstr($message->getSubject(),'Tellus data from') !== false)
				{
					echo $line.'1 message trouve concernant Bouquetins'; 
					$attachements = $message->getAttachments();
					if($attachements !== false)
					{
						//echo $line.'<pre>'.print_r($attachements,true).'</pre>';
						echo $line.'Fichier de données trouvé et enregistré :'.print_r($attachements,true);
						foreach($attachements as $attachement)
							$attachement->saveToDirectory(config::get('rep_appli').$tmp_rep);

					}
					else
						echo $line.'Pas de pieces jointes trouvées';
					
					echo $line.'Message traité et marqué comme sauvegardé !';
					$message->setFlag('deleted');
				}
			}
			echo $line.'Boîte email vidangée !';
			$imap->expunge(); //on supprime les emails traités
		}	
			
			
			/*On lit les fichiers txt dans le dossier tmp/csv/ et on importe les données */
			echo $line.'Traitement des fichiers de données.';
			$rep = config::get('rep_appli').$tmp_rep;
			$send_email_info = array();
			if ($dir = opendir($rep)) 
			{
				$csv = '';
				while($file = readdir($dir)) 
				{
					if ($file!='.' && $file!='..')
					{
						if (strstr($file,'.txt'))
						{
							echo $line.'Traitement du fichier :'.$rep.$file;
							$fs = fopen($rep.$file,'r');
							$tmp_id = explode('_',$file);
							$tmp_id = explode('-',$tmp_id[0]); //on extrait uniquement les nombres pour l'identifiant !
							$id = $tmp_id[1];
							$cpt = 1;
							
							//On vérifie si on connait l'identifiant dans le fichier de configuration pour le premier import ou dans la BDD 
							$rqe = $db->prepare('SELECT count(id) as nb,nom FROM '.config::get('db_prefixe').'tracked_objects where id = ?');
							$rqe->execute(array($id));
							$results = $rqe->fetchObject();
							
							if (config::get('csv_nom_tracked_objects',$id) != '' || $results->nb == 1)
							{
								//on a l'identifiant on traite le contenu du fichier
								
								//Récupération du nom
								$name = (config::get('csv_nom_tracked_objects',$id)!='')?config::get('csv_nom_tracked_objects',$id):$results->nom;
								
								echo $line.'Données concordantes trouvées pour l\'objet traqué :'.$name;
								/*on lit toutes les lignes sauf les 3 premières*/
								while (($buffer = fgets($fs, 4096)) !== false) 
								{
									if($cpt > 3)
									{
										if (trim($buffer) != '')
										{
											$buffer = str_replace("\t",',',$buffer);
											$csv.= $id.",".$name.",".$buffer;
											echo $line."\t".'Données ligne '.($cpt-3).' : '.$id.",".$name.",".$buffer;
										}
									}
									$cpt++;
								}
								//On supprime le fichier après traitement
								echo $line.'Suppression du fichier :'.$rep.$file;
								unlink($rep.$file);
							}
							else
							{
								
								if(!isset($send_email_info[$id]) && config::get('csv_email_error'))
								{
									
									echo $line.'Envoi email pour informer de la non récupération du non, non concordance des données';
									//On envoi un email pour informer de l'ajout nécessaire de l'id/nom
									$corps = "<html><head><meta http-equiv= \"content-type\" content=\"text/html; charset=UTF-8\"></head><body><h3>Notification application Bouquetins</h3>
									<p>Un nouvel identifiant (".$id.") a été reconnu lors de l'import automatique.</p>
									<p>Il est nécessaire de renseigner son nom dans le fichier de configuration (config/config.php - 'csv_nom_tracked_objects') pour finaliser l'import de donnée.</p>
									<p>Les données sont conservées. Une fois le nom renseigné dans le tableau l'import sera effectuée lors de la prochaine automatisation.
									<strong>Un email sera transmis à chaque traitement automatique tant que le nom ne sera pas renseigné.</strong></p>
									<p><strong>Si ces données ne doivent pas être importée, il suffit de supprimer manuellement les fichiers portant l'identifiant (".$id." - ex : T5HS-".$id."_YYYY-MM-DD-NUM) dans le répertoire \"tmp/csv/\" de l'application.</strong>
									<p><small>At work !</small></p></body></html>";
									$to = config::get('csv_email_error_nom');
									if (!API::send_email($to,'Nom d\'objet traqué à rajouter',$corps))
										echo $line."\t".'Erreur envoi email';
									else
									{
										echo $line."\tEmail envoyé pour id : ".$id;
										$send_email_info[$id] = 1; //On note un email deja envoyé pour cet id !
									}
								}
							}
						}
					}
				}
				closedir($dir);
				
				if ($csv !='')
				{
					//On ecrit le fichier tracked_objects.csv dans le rep CSV
					echo $line."Ecriture du fichier CSV et envoi au traitement d'import csv";
					file_put_contents(config::get('rep_appli').'csv'.config::get('system_separateur').'tracked_objects.csv',$csv);
					
					$this->import_csv();
				}
				else
					echo $line."Rien à importer !";
			}

	}
}
<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 2:44 PM
 */
class Device
{
    protected 	$id_device;
    protected 	$ref_device;
    protected 	$id_device_type;
    protected 	$comment;

    public function __construct($id_device=null,$load_all=true)
    {
        if ($id_device !== null)
        {
            $this->setIdDevice($id_device);
        }
    }

    /**
     * @return mixed
     */
    public function getIdDevice()
    {
        return $this->id_device;
    }

    /**
     * @param mixed $id_device
     */
    public function setIdDevice($id_device)
    {
        $this->id_device = $id_device;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->ref_device;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($ref_device)
    {
        $this->ref_device = $ref_device;
    }

    /**
     * @return mixed
     */
    public function getDeviceTypeId()
    {
        return $this->id_device_type;
    }

    /**
     * @param mixed $id_device_type
     */
    public function setDeviceTypeId($id_device_type)
    {
        $this->id_device_type = $id_device_type;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
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

                echo $line."\n Condition sur les données récupérées : ".$tmp_condition.' -> résultat :'.$result_cond;
                $accurate = 0;

                /*
                 Insertion des données même si elles ne répondent pas aux conditions définies dans le fichier de configuration.
                 Si les données ne répondent pas aux conditions, le champ 'accurate' est à 0.
                 Si les données répondent aux conditions, le champ 'accurate' est à 1.
                */
                if($result_cond) {
                    $accurate = 1;
                    echo $line.'Données répondant aux conditions';
                } else {
                    $accurate = 0;
                    echo $line.'gps_data ne répondant pas aux conditions';
                }

                $device = new Device();
                $device->setIdDevice($data[config::get('csv_colonne','id')]);

                /* Gestion des dates */
                $tmp_date	= $data[config::get('csv_colonne','date')].((config::get('csv_colonne','heure') !=-1)?' '.$data[config::get('csv_colonne','heure')]:'');
                echo $line."\n Date :".$data[config::get('csv_colonne','date')].' '.$data[config::get('csv_colonne','heure')];
                $obj_date 	= DateTime::createFromFormat(config::get('csv_date_format').' '.config::get('csv_heure_format'), $tmp_date);
                /* Fait une mise à jour de la date une fois les données saisies complétement. */

                /*Affectation des données*/
                $gpsdata 	= new GPSDATA();
                $gpsdata->setDeviceId($device->getIdDevice());
                $gpsdata->setGpsDate($obj_date->format('Y-m-d H:i:s'));
                $gpsdata->setTtf($data[config::get('csv_colonne','ttf')]);
                $gpsdata->setLatitude($data[config::get('csv_colonne','latitude')]);
                $gpsdata->setLongitude($data[config::get('csv_colonne','longitude')]);
                $gpsdata->setSatNumber($data[config::get('csv_colonne','nb_satellites')]);
                $gpsdata->setDimension($data[config::get('csv_colonne','dimension')]);
                $gpsdata->setAltitude($data[config::get('csv_colonne','altitude')]);
                $gpsdata->setHdop($data[config::get('csv_colonne','hadop')]);
                $gpsdata->setTemperature($data[config::get('csv_colonne','temperature')]);
                $gpsdata->setAccurate($accurate);
                $gpsdata->insert();



                /*Affectation des propriétés*/
                echo $line.'tracked_objects sauvegardé :'.print_r($device);


            }
            fclose($fs);
            echo $line.'Dernière date de capture sauvées :'.print_r($last_date_tracked_objects);

        }

    }
}
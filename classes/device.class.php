<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 2:44 PM
 */
class Device
{
    protected 	$id;
    protected 	$reference;
    protected 	$device_type_id;
    protected 	$comment;
    protected 	$created_at;
    protected 	$updated_at;

    public function __construct($id=null,$load_all=true)
    {
        if ($id !== null)
        {
            $this->setId($id);
        }
        else
        {
            $this->setCreatedAt(date('Y-m-d H:m:i',time()));
            $this->setUpdatedAt(date('Y-m-d H:m:i',time()));
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getDeviceTypeId()
    {
        return $this->device_type_id;
    }

    /**
     * @param mixed $device_type_id
     */
    public function setDeviceTypeId($device_type_id)
    {
        $this->device_type_id = $device_type_id;
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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
                    $device = new Device();
                    $device->setId($data[config::get('csv_colonne','id')]);




                    /* Gestion des dates */
                    $tmp_date	= $data[config::get('csv_colonne','date')].((config::get('csv_colonne','heure') !=-1)?' '.$data[config::get('csv_colonne','heure')]:'');
                    echo $line.'Date :'.$data[config::get('csv_colonne','date')].' '.$data[config::get('csv_colonne','heure')];
                    $obj_date 	= DateTime::createFromFormat(config::get('csv_date_format').' '.config::get('csv_heure_format'), $tmp_date);

                    /* Fait une mise à jour de la date une fois les données saisies complétement. */

                    /*Affectation des données*/
                    $analysis 	= new Analysis();
                    $analysis->setDeviceId($device->getId());
                    $analysis->setGpsDate($obj_date->format('Y-m-d H:i:s'));
                    $analysis->setLatitude($data[config::get('csv_colonne','latitude')]);
                    $analysis->setLongitude($data[config::get('csv_colonne','longitude')]);
                    $analysis->setTemperature($data[config::get('csv_colonne','temperature')]);
                    $analysis->setSatNumber($data[config::get('csv_colonne','nb_satellites')]);
                    $analysis->setAltitude($data[config::get('csv_colonne','altitude')]);
                    $analysis->insert();



                    /*Affectation des propriétés*/
                    echo $line.'tracked_objects sauvardé :'.print_r($device);

                }
                else
                    echo $line.'gps_data ne répondant pas aux conditions';
            }
            fclose($fs);
            echo $line.'Dernière date de capture sauvées :'.print_r($last_date_tracked_objects);

        }

    }
}
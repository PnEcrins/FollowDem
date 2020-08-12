<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 12:08 PM
 */
class Animal
{


    protected 	$id_animal			= '';
    protected 	$name 			= '';
    protected 	$birth_year 	= NULL;
    protected 	$capture_date	 	= NULL;
    protected 	$death_date 		= 0;
    protected 	$comment;
    protected 	$attributes 	= array();
    protected 	$devices	= array();
    protected 	$gpsdata		= array();// gps data


    public function __construct($id_animal=null,$load_all=true)
    {
        if ($id_animal !== null)
        {
            $this->setIdAnimal($id_animal);
            $this->load($load_all);
        }
    }

    public function setName($name='')
    {
        $this->name = trim($name);
    }

    public function setIdAnimal($id_animal='')
    {
        $this->id_animal = $id_animal;
    }

    public function setAttributes($attributes='')
    {
        $this->attributes = $attributes;
    }

    public function setGpsData($gpsdata='')
    {
        $this->gpsdata = $gpsdata;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIdAnimal()
    {
        return $this->id_animal;
    }



    /* Renvoie tableau d'objet et de propriété */
    public function getAttributes()
    {
        return $this->attributes;
    }
    /* Renvoie la valeur de la propriété demandée */
    public function getAttributeElem($prop='')
    {
        if ($prop !='' && isset($this->attributes[$prop]))
        {
            return $this->attributes[$prop]->get_valeur_prop();
        }

        return false;
    }

    /**
     * @return int
     */
    public function getDeathDate()
    {
        return $this->death_date;
    }

    /**
     * @param int $death_date
     */
    public function setDeathDate($death_date)
    {
        $this->death_date = $death_date;
    }

    public function getGpsData()
    {
        return $this->gpsdata;
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
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param array $devices
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;
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
        $rqs = $db->prepare('SELECT id_animal, name, birth_year, capture_date, death_date, comment FROM '.config::get('db_prefixe').'t_animals WHERE display = TRUE AND id_animal = ?');
        $rqs->execute(array($this->id_animal));

        if($results = $rqs->fetchObject())
        {
            $this->setName($results->name);
            $this->setBirthYear($results->birth_year);
            $this->setCaptureDate($results->capture_date);
            $this->setDeathDate($results->death_date);

            $this->setAttributes(AnimalAttribute::load_all($this->getIdAnimal()));
            if($load_gps_data==true) {
                $data = GPSDATA::load_all_by_date($this->getIdAnimal());
                $this->setGpsData($data);
            }
        }
        else
        {
            /*Erreur code 10 - Incohérence BDD*/
            throw new erreur(10);
        }
    }
    static function load_all($order='name')
    {
        $db=db::get();
        $tmp_animals = array();
            $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'t_animals WHERE display = TRUE AND id_animal in ( select id_animal from '.config::get('db_prefixe').'cor_animal_devices)  ORDER BY '.$order);
            $rqs->execute();

        while($results = $rqs->fetchObject()) {
            $animal = new Animal($results->id_animal);
            $animal->setName($results->name);
            $animal->setBirthYear($results->birth_year);
            $animal->setCaptureDate($results->capture_date);
            $animal->setDeathDate($results->death_date);

            $animal->setAttributes(AnimalAttribute::load_all($animal->getIdAnimal()));
            $tmp_animals[] = $animal;
}
        return $tmp_animals;
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
            $this->setGpsData(GPSDATA::load_all_by_date($this->getIdAnimal(),$date_deb,$date_fin,false));
        }
    }
    /**
     * @return null
     */
    public function getCaptureDate()
    {
        return $this->capture_date;
    }

    /**
     * @param null $capture_date
     */
    public function setCaptureDate($capture_date)
    {
        $this->capture_date = $capture_date;
    }

    /**
     * @return null
     */
    public function getBirthYear()
    {
        return $this->birth_year;
    }

    /**
     * @param null $birth_year
     */
    public function setBirthYear($birth_year)
    {
        $this->birth_year = $birth_year;
    }
    /* Renvoie la valeur de la propriété demandée */
    public function get_object_feature($prop='')
    {
        foreach( $this->getAttributes()  as $attribute){
            if($attribute->getAttribute()->getAttribute() == $prop)
                return $attribute->getValue();
    }

        return false;
    }

}
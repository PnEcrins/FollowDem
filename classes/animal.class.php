<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 12:08 PM
 */
class Animal
{


    protected 	$id 			= '';
    protected 	$name 			= '';
    protected 	$birth_year 	= NULL;
    protected 	$capture_date	 	= NULL;
    protected 	$death_date 		= 0;
    protected 	$comment;
    protected 	$created_at;
    protected 	$updated_at;
    protected 	$attributes 	= array();
    protected 	$devices	= array();
    protected 	$analysis		= array();// gps data


    public function __construct($id=null,$load_all=true)
    {
        if ($id !== null)
        {
            $this->setId($id);
            $this->load($load_all);
        }
        else
        {
            $this->setCreated_at(date('Y-m-d H:m:i',time()));
            $this->setUpdated_at(date('Y-m-d H:m:i',time()));
        }
    }

    public function setName($name='')
    {
        $this->name = trim($name);
    }
    public function setId($id='')
    {
        $this->id = $id;
    }

    public function setCreated_at($created_at='')
    {
        $this->created_at = $created_at;
    }

    public function setUpdated_at($updated_at='')
    {
        $this->updated_at = $updated_at;
    }

    public function setAttributes($attributes='')
    {

        $this->attributes = $attributes;


    }
    public function setAnalysis($analysis='')
    {

        $this->analysis = $analysis;

    }

    public function getName()
    {
        return $this->name;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        $tz 	= new DateTimeZone(config::get('fuseau'));
        $date	= new DateTime($this->created_at,$tz);
        return strftime(config::get('datesortie'), $date->getTimestamp());
    }

    public function getCreatedAtBdd()
    {
        return $this->date_creation;
    }

    public function getUpdated_at()
    {
        $tz 	= new DateTimeZone(config::get('fuseau'));
        $date	= new DateTime($this->get_date_maj,$tz);
        return strftime(config::get('datesortie'), $date->getTimestamp());
    }


    public function getUpdatedAtBdd()
    {
        return $this->date_maj;
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
    public function getAnalysis()
    {
        return $this->analysis;
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
        $rqs = $db->prepare('SELECT id,name,birth_year,capture_date,death_date, comment, created_at, updated_at FROM '.config::get('db_prefixe').'animals where id = ?');
        $rqs->execute(array($this->id));

        if($results = $rqs->fetchObject())
        {
            $this->setName($results->name);
            $this->setBirthYear($results->birth_year);
            $this->setCaptureDate($results->capture_date);
            $this->setDeathDate($results->death_date);
            $this->setCreated_at($results->created_at);
            $this->setUpdated_at($results->updated_at);

            $this->setAttributes(AnimalAttribute::load_all($this->getId()));
            if($load_gps_data==true) {
                $data = Analysis::load_all_by_date($this->getId());
                $this->setAnalysis($data);
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
            $rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'animals ORDER BY '.$order);
            $rqs->execute();

        while($result = $rqs->fetchObject())
            $tmp_animals[] = new Animal($result->id);

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
            $this->setAnalysis(Analysis::load_all_by_date($this->getId(),$date_deb,$date_fin,false));
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
            if($attribute->getAttribute()->getName() == $prop)
                return $attribute->getValue();
    }

        return false;
    }

}
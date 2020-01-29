<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 2:46 PM
 */
class Analysis
{
    protected 	$id;
    protected 	$device_id;
    protected 	$gps_date;
    protected 	$ttf;
    protected 	$x;
    protected 	$y;
    protected 	$temperature;
    protected 	$sat_number;
    protected 	$hadop;
    protected 	$latitude;
    protected 	$longitude;
    protected 	$altitude;
    protected 	$geom_mp;
    protected 	$accurate;
    protected 	$dimension;
    protected 	$animale_device_id;
    protected 	$created_at;
    protected 	$updated_at;

    /**
     * Analysis constructor.
     */
    public function __construct($id=0)
    {
        if ($id !== 0)
        {
            $this->setId($id);
            $this->load();
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
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @param mixed $device_id
     */
    public function setDeviceId($device_id)
    {
        $this->device_id = $device_id;
    }

    /**
     * @return mixed
     */
    public function getGpsDate()
    {
        return $this->gps_date;
    }

    /**
     * @param mixed $gps_date
     */
    public function setGpsDate($gps_date)
    {
        $this->gps_date = $gps_date;
    }

    /**
     * @return mixed
     */
    public function getTtf()
    {
        return $this->ttf;
    }

    /**
     * @param mixed $ttf
     */
    public function setTtf($ttf)
    {
        $this->ttf = $ttf;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return mixed
     */
    public function getSatNumber()
    {
        return $this->sat_number;
    }

    /**
     * @param mixed $sat_number
     */
    public function setSatNumber($sat_number)
    {
        $this->sat_number = $sat_number;
    }

    /**
     * @return mixed
     */
    public function getHadop()
    {
        return $this->hadop;
    }

    /**
     * @param mixed $hadop
     */
    public function setHadop($hadop)
    {
        $this->hadop = $hadop;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param mixed $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    /**
     * @return mixed
     */
    public function getGeomMp()
    {
        return $this->geom_mp;
    }

    /**
     * @param mixed $geom_mp
     */
    public function setGeomMp($geom_mp)
    {
        $this->geom_mp = $geom_mp;
    }

    /**
     * @return mixed
     */
    public function getAccurate()
    {
        return $this->accurate;
    }

    /**
     * @param mixed $accurate
     */
    public function setAccurate($accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @return mixed
     */
    public function getAnimaleDeviceId()
    {
        return $this->animale_device_id;
    }

    /**
     * @param mixed $animale_device_id
     */
    public function setAnimaleDeviceId($animale_device_id)
    {
        $this->animale_device_id = $animale_device_id;
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
     * 	Charge une propriété
     *
     * 	@access  private
     * 	@return  boolean
     * 	@param
     */
    private function load()
    {
        $db=db::get();
        $rql = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'gps_data where id = ?');
        $rql->execute(array($this->getId()));
        if($result = $rql->fetchObject())
        {
            $this->setId($result->id);
            $this->setDeviceId($result->device_id);
            $this->setGpsDate($result->gps_date);
            $this->setLatitude($result->latitude);
            $this->setLongitude($result->longitude);
            $this->setTemperature($result->temperature);
            $this->setSatNumber($result->sat_number);
            $this->setAltitude($result->altitude);
        }
    }

    /**
     * 	Vérifie si une donnée existe
     *	Pas d'update - Une propriété saisie est ignorée - La methode update est conservée par convention
     *
     * 	@access  private
     * 	@return  boolean
     * 	@param
     */
    private function exist($update=false)
    {
        $db=db::get();
        $rqe = $db->prepare('SELECT count(id) as nb,device_id,dateheure FROM '.config::get('db_prefixe').'analysis where device_id = ? AND gps_date = ?');
        $rqe->execute(array($this->getDeviceId(), $this->getGpsDate()));

        $results = $rqe->fetchObject();
        if ($results===false || $results->nb == 0)
            return false;

        return true;
    }

    /**
     * 	Insert une donnée
     *
     * 	@access  private
     * 	@return

     */
    public function insert()
    {
        $db=db::get();
        $rq = 'INSERT INTO '.config::get('db_prefixe').'gps_data';
        $rq .= ' (device_id,
                  gps_date,
                  ttf,
                  latitude,
                  longitude,
                  sat_number,
                  dimension,
                  altitude,
                  hadop,
                  temperature,
                  x,
                  y,
                  accurate
                  )
                  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';
        try
        {
        $rqi = $db->prepare($rq);
        $rqi->execute(
            array(
                $this->getDeviceId(),
                $this->getGpsDate(),
                $this->getTtf(),
                $this->getLatitude(),
                $this->getLongitude(),
                $this->getSatNumber(),
                $this->getDimension(),
                $this->getAltitude(),
                $this->getHadop(),
                $this->getTemperature(),
                $this->getX(),
                $this->getY(),
                $this->getAccurate()
                )
        );
        }
        catch(PDOException $e)
        {
            print_r("hello");
            handle_sql_errors($rq, $e->getMessage());
        }
        if ($rqi->rowCount() === 0)
        {
            trace::add("ERREUR ajout gps_data id=".$this->getId().' - id_device :'.$this->getDeviceId());
        }
        else
        {
            trace::add("Ajout gps_data id=".$this->getId().' - id_device :'.$this->getDeviceId());
        }


    }

    /**
     * @return mixed
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @param mixed $dimension
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * 	Update une donnée
     *	Conservée par convention - Normalement pas d'Update sur les données insérées.
     * 	@access  private
     * 	@return
     */
    private function update()
    {
        $db=db::get();
        $rqu = $db->prepare('UPDATE '.config::get('db_prefixe').'analysis SET device_id=?,gps_date=?,latitude=?,longitude=?,temperature=?,number_sat=?,altitude=? WHERE id=?');
        $rqu->execute(array(
            $this->getDeviceId(),
            $this->getGpsDate(),
            $this->getLatitude(),
            $this->getLongitude(),
            $this->getTemperature(),
            $this->getSatNumber(),
            $this->getAltitude(),
            $this->getId()));

        if ($rqu->rowCount() === 0){
            trace::add("ERREUR update gps_data id=".$this->get_id().'--'.$this->get_device_id());
        }
        else {
            trace::add("update gps_data id=".$this->get_id().'--'.$this->get_device_id());
        }
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
        $rqd = $db->prepare('DELETE FROM '.config::get('db_prefixe').'analysis WHERE id=?');
        $rqd->execute(array($this->getId()));
        if ($rqd->rowCount() === 0){
            trace::add("ERREUR Suppression gps_data id=".$this->getId().'--'.$this->getDeviceId());
        }
        else {
            trace::add("Suppression gps_data id=".$this->getId().'--'.$this->getDeviceId());
        }
    }


    /**
     * 	Charge toutes les données de l'objet si $device_id retourne un tableau d'objets et de propriétés
     *	Attention si $device_id = 0 - Chargements et requêtes peuvent être longs !
     * 	@access  static
     * 	@return  array
     * 	@param	device_id, order
     */

    static function load_all($animal_id=0)
    {
        $db=db::get();
        $tmp_gps_data = array();

        if($animal_id===0)
        {
            $rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'gps_data');
            $rqs->execute();
        }
        else
        {
            $rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'gps_data where animale_device_id in (select device_id from '.config::get('db_prefixe').'animal_devices where animal_id = ?)');
            $rqs->execute(array($animal_id));
            //$rqs->debugDumpParams();
        }
        while($result = $rqs->fetchObject())
            $tmp_gps_data[] = new Analysis($result->id);

        return $tmp_gps_data;
    }

    /**
     * 	Charge toutes les données entre 2 dates ou la dernière date
     *	Attention si $device_id = 0 - Chargements et requêtes peuvent être longs !
     * 	@access  static
     * 	@return  array
     * 	@param	device_id, date_deb, date_fin, last_gps_data (dernières données seulement), order, $count_only(compte seulement si des données existent)
     */

     static function load_all_by_date($animal_id=0,$date_deb=null,$date_fin=null,$last_gps_data=true,$count_only=false, $order='gps_date')
    {
        $db=db::get();
        $tmp_gps_data = array();
        $where = '';
        $prepare = array();
        $next = '';
        if($animal_id!==0)
        {
            $where.=' animale_device_id in ( select device_id from '.config::get('db_prefixe').'animal_devices where animal_id = ?) ';
            $prepare[]=$animal_id;
            $next = ' AND ';
        }

        if($last_gps_data === false)
        {
            if($date_deb!=null)
            {
                $where.=$next.'gps_date > ?';
                $prepare[]=$date_deb;
                $next = ' AND ';
            }
            if($date_fin!=null)
            {
                $where.=$next.'gps_date < ?';
                $prepare[]=$date_fin;
            }
        }
        else
        {
            $where.= $next.'gps_date IN (SELECT max(gps_date) FROM '.config::get('db_prefixe').'gps_data WHERE'.$where.' GROUP BY gps_date )';
            $prepare = array_merge($prepare,$prepare);
        }



        if($count_only === true)
            $rqs = $db->prepare('SELECT count(id) as NB FROM '.config::get('db_prefixe').'gps_data where '.$where.' ORDER BY '.$order);
        else
            $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'gps_data where '.$where.' ORDER BY '.$order);

        $rqs->execute($prepare);

        if($count_only === true)
        {
            $result = $rqs->fetchObject();
            if($result->NB > 0)
                return true;
            return false;
        }
        else
        {
            while($result = $rqs->fetchObject()){
                $analysis = new Analysis();
                $analysis->setId($result->id);
                //$analysis->setDeviceId($result->device_id);
                $analysis->setGpsDate($result->gps_date);
                $analysis->setLatitude($result->latitude);
                $analysis->setLongitude($result->longitude);
                $analysis->setTemperature($result->temperature);
                $analysis->setSatNumber($result->sat_number);
                $analysis->setAltitude($result->altitude);
                $tmp_gps_data[] = $analysis;
            }
            /*
            if(count($tmp_gps_data)>0) {
                print_r(count($tmp_gps_data));
                return $tmp_gps_data;
            }else
                return false;
            */
        }
        return $tmp_gps_data;
    }

}
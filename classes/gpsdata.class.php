<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 2:46 PM
 */
class GPSDATA
{
    protected 	$id_gps_data;
    protected 	$id_device;
    protected 	$gps_date;
    protected 	$ttf;
    protected 	$temperature;
    protected 	$sat_number;
    protected 	$hdop;
    protected 	$latitude;
    protected 	$longitude;
    protected 	$altitude;
    protected 	$accurate;
    protected 	$dimension;

    /**
     * GPSDATA constructor.
     */
    public function __construct($id_gps_data=0)
    {
        if ($id_gps_data !== 0)
        {
            $this->setIdGpsData($id_gps_data);
            $this->load();
        }
    }

    /**
     * @return mixed
     */
    public function getIdGpsData()
    {
        return $this->id_gps_data;
    }

    /**
     * @param mixed $id_gps_data
     */
    public function setIdGpsData($id_gps_data)
    {
        $this->id_gps_data = $id_gps_data;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->id_device;
    }

    /**
     * @param mixed $id_device
     */
    public function setDeviceId($id_device)
    {
        $this->id_device = $id_device;
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
    public function getHdop()
    {
        return $this->hdop;
    }

    /**
     * @param mixed $hdop
     */
    public function setHdop($hdop)
    {
        $this->hdop = $hdop;
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
     * 	Charge une propriété
     *
     * 	@access  private
     * 	@return  boolean
     * 	@param
     */
    private function load()
    {
        $db=db::get();
        $rql = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'t_gps_data where id_gps_data = ? and accurate = true');
        $rql->execute(array($this->getIdGpsData()));
        if($result = $rql->fetchObject())
        {
            $this->setIdGpsData($result->id_gps_data);
            $this->setDeviceId($result->id_device);
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
        $rqe = $db->prepare('SELECT count(id_gps_data) as nb,id_device,gps_date FROM '.config::get('db_prefixe').'t_gps_data where id_device = ? AND gps_date = ?');
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
        $rq = 'INSERT INTO '.config::get('db_prefixe').'t_gps_data';
        $rq .= ' (
                    id_device,
                    gps_date,
                    ttf,
                    latitude,
                    longitude,
                    sat_number,
                    dimension,
                    altitude,
                    hdop,
                    temperature,
                    accurate
                    )
                    VALUES(?,?,?,?,?,?,?,?,?,?,?)';
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
                $this->getHdop(),
                $this->getTemperature(),
                $this->getAccurate(),
                )
        );
        print_r($this);
        }
        catch(PDOException $e)
        {
            print_r("hello");
            handle_sql_errors($rq, $e->getMessage());
        }
        if ($rqi->rowCount() === 0)
        {
            trace::add("ERREUR ajout gps_data id_gps_data=".$this->getIdGpsData().' - id_device :'.$this->getDeviceId());
        }
        else
        {
            trace::add("Ajout gps_data id_gps_data=".$this->getIdGpsData().' - id_device :'.$this->getDeviceId());
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
        $rqu = $db->prepare('UPDATE '.config::get('db_prefixe').'t_gps_data SET id_device=?,gps_date=?,latitude=?,longitude=?,temperature=?,number_sat=?,altitude=? WHERE id_gps_data=?');
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
            trace::add("ERREUR update t_gps_data id_gps_data=".$this->getIdGpsData().'--'.$this->get_id_device());
        }
        else {
            trace::add("update t_gps_data id_gps_data=".$this->getIdGpsData().'--'.$this->get_id_device());
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
        $rqd = $db->prepare('DELETE FROM '.config::get('db_prefixe').'t_gps_data WHERE id_gps_data=?');
        $rqd->execute(array($this->getIdGpsData()));
        if ($rqd->rowCount() === 0){
            trace::add("ERREUR Suppression t_gps_data id_gps_data=".$this->getIdGpsData().'--'.$this->getDeviceId());
        }
        else {
            trace::add("Suppression t_gps_data id_gps_data=".$this->getIdGpsData().'--'.$this->getDeviceId());
        }
    }


    /**
     * 	Charge toutes les données de l'objet si $id_device retourne un tableau d'objets et de propriétés
     *	Attention si $id_device = 0 - Chargements et requêtes peuvent être longs !
     * 	@access  static
     * 	@return  array
     * 	@param	id_device, order
     */

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
            $rqs = $db->prepare('SELECT id_gps_data FROM '.config::get('db_prefixe').'t_gps_data where accurate = true');
            $rqs->execute();
        }
        else
        {
            $rqs = $db->prepare('SELECT id_gps_data FROM '.config::get('db_prefixe').'t_gps_data where id_device in (select id_device from '.config::get('db_prefixe').'cor_animal_devices where id_animal = ? and accurate = true)');
            $rqs->execute(array($animal_id));
            //$rqs->debugDumpParams();
        }
        while($result = $rqs->fetchObject())
            $tmp_gps_data[] = new GPSDATA($result->id_gps_data);

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
            $where.=' id_device in ( select id_device from '.config::get('db_prefixe').'cor_animal_devices where id_animal = ? and accurate = true) ';
            $prepare[]=$animal_id;
            $next = ' AND ';
        }

        if($last_gps_data === false)
        {
            if($date_deb!=null)
            {
                $where.=$next.'gps_date > ? and accurate = true ';
                $prepare[]=$date_deb;
                $next = ' AND ';
            }
            if($date_fin!=null)
            {
                $where.=$next.'gps_date < ? and accurate = true';
                $prepare[]=$date_fin;
            }
        }
        else
        {
            $where.= $next.'gps_date IN (SELECT max(gps_date) FROM '.config::get('db_prefixe').'t_gps_data WHERE'.$where.' )';
            $prepare = array_merge($prepare,$prepare);
        }



        if($count_only === true)
            $rqs = $db->prepare('SELECT count(id_gps_data) as NB FROM '.config::get('db_prefixe').'t_gps_data where '.$where.' ORDER BY '.$order);
        else
            $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'t_gps_data where '.$where.' ORDER BY '.$order);

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
                $analysis = new GPSDATA();
                $analysis->setIdGpsData($result->id_gps_data);
                $analysis->setDeviceId($result->id_device);
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
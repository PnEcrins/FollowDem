<?php

/**
 * Created by PhpStorm.
 * User: Zouhir
 * Date: 10/25/18
 * Time: 2:45 PM
 */
class AnimalAttribute
{
    protected 	$id;
    protected 	$animal_id;
    protected 	$attribute_id;
    protected 	$value;
    protected 	$created_at;
    protected 	$updated_at;
    protected   $attribute;

    /**
     * AnimalAttribute constructor.
     */
    public function __construct($id)
    {
        if($id) {
            $this->setId($id);
            $this->load();
        }
    }
    private function load()
    {
        $db=db::get();
        $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'animal_attributes where id = ?');
        $rqs->execute(array($this->getId()));

        if($results = $rqs->fetchObject())
        {
            $this->setAnimalId($results->animal_id);
            $this->setAttributeId($results->attribute_id);
            $this->setValue($results->value);
            $this->setCreatedAt($results->created_at);
            $this->setUpdatedAt($results->updated_at);
            $this->setAttribute(new Attribute($results->attribute_id));
        }
        else
        {
            /*Erreur code 10 - Incohérence BDD*/
            throw new erreur(10);
        }
    }
    /**
     * 	Charge toutes les données de l'objet si $id_tracked_objects retourne un tableau d'objets et de propriétés
     *	Attention si $id_tracked_objects = 0 - Chargements et requêtes peuvent être longs !
     * 	@access  static
     * 	@return  array
     * 	@param	id_tracked_objects, order
     */

    static function load_all($animal_id=0)
    {
        $db=db::get();
        $tmp_animals_attribute_data = array();

        if($animal_id===0)
        {
            $rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'animal_attributes');
            $rqs->execute();
        }
        else
        {
            $rqs = $db->prepare('SELECT id FROM '.config::get('db_prefixe').'animal_attributes where animal_id = ?');
            $rqs->execute(array($animal_id));
        }
        while($result = $rqs->fetchObject())
            $tmp_animals_attribute_data[] = new AnimalAttribute($result->id);

        return $tmp_animals_attribute_data;
    }
    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
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
    public function getAnimalId()
    {
        return $this->animal_id;
    }

    /**
     * @param mixed $animal_id
     */
    public function setAnimalId($animal_id)
    {
        $this->animal_id = $animal_id;
    }

    /**
     * @return mixed
     */
    public function getAttributeId()
    {
        return $this->attribute_id;
    }

    /**
     * @param mixed $attribute_id
     */
    public function setAttributeId($attribute_id)
    {
        $this->attribute_id = $attribute_id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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

}
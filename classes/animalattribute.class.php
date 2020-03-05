<?php

/**
 * Created by PhpStorm.
 * User: Zouhair ET-TAOUSY
 * Date: 10/25/18
 * Time: 2:45 PM
 */
class AnimalAttribute
{
    protected 	$id_cor_an_att;
    protected 	$id_animal;
    protected 	$id_attribute;
    protected 	$value;
    protected   $attribute;

    /**
     * AnimalAttribute constructor.
     */
    public function __construct($id_cor_an_att)
    {
        if($id_cor_an_att) {
            $this->setIdCorAnAtt($id_cor_an_att);
            $this->load();
        }
    }
    private function load()
    {
        $db=db::get();
        $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'cor_animal_attributes where id_cor_an_att = ?');
        $rqs->execute(array($this->getIdCorAnAtt()));

        if($results = $rqs->fetchObject())
        {
            $this->setAnimalId($results->id_animal);
            $this->setAttributeId($results->id_attribute);
            $this->setValue($results->value);
            $this->setAttribute(new Attribute($results->id_attribute));
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
     * 	@param	id_animal, order
     */

    static function load_all($id_animal=0)
    {
        $db=db::get();
        $tmp_animals_attribute_data = array();

        if($id_animal===0)
        {
            $rqs = $db->prepare('SELECT id_cor_an_att FROM '.config::get('db_prefixe').'cor_animal_attributes');
            $rqs->execute();
        }
        else
        {
            $rqs = $db->prepare('SELECT id_cor_an_att FROM '.config::get('db_prefixe').'cor_animal_attributes where id_animal = ?');
            $rqs->execute(array($id_animal));
        }
        while($result = $rqs->fetchObject())
            $tmp_animals_attribute_data[] = new AnimalAttribute($result->id_cor_an_att);

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
    public function getIdCorAnAtt()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setIdCorAnAtt($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAnimalId()
    {
        return $this->id_animal;
    }

    /**
     * @param mixed $id_animal
     */
    public function setAnimalId($id_animal)
    {
        $this->id_animal = $id_animal;
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

}
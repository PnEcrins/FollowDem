<?php

/**
 * Created by PhpStorm.
 * User: ET-TAOUSY Zouhair
 * Date: 10/25/18
 * Time: 2:16 PM
 */
class Attribute
{
    protected 	$id_attribute;
    protected 	$attribute;
    protected 	$value_list;
    protected 	$attribute_type;
    protected 	$order;

    public function __construct($id_attribute=0)
    {

        if ($id_attribute !== 0)
            $this->setIdAttribute($id_attribute);
        if ($this->getIdAttribute()!==0)
            $this->load();
    }

    /**
     * @return mixed
     */
    public function getIdAttribute()
    {
        return $this->id_attribute;
    }

    /**
     * @param mixed $id_attribute
     */
    public function setIdAttribute($id_attribute)
    {
        $this->id_attribute = $id_attribute;
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
    public function getValueList()
    {
        return $this->value_list;
    }

    /**
     * @param mixed $value_list
     */
    public function setValueList($value_list)
    {
        $this->value_list = $value_list;
    }

    /**
     * @return mixed
     */
    public function getAttributeType()
    {
        return $this->attribute_type;
    }

    /**
     * @param mixed $attribute_type
     */
    public function setAttributeType($attribute_type)
    {
        $this->attribute_type = $attribute_type;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }


    private function load()
    {
        $db=db::get();
        $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'lib_attributes where id_attribute = ?');
        $rqs->execute(array($this->id_attribute));

        if($results = $rqs->fetchObject())
        {
            $this->setAttribute($results->attribute);

            $this->setAttributeType($results->attribute_type);

            $this->setOrder($results->order);
        }
        else
        {
            /*Erreur code 10 - Incohérence BDD*/
            throw new erreur(10);
        }
    }

}
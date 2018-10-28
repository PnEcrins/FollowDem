<?php

/**
 * Created by PhpStorm.
 * User: ET-TAOUSY Zouhair
 * Date: 10/25/18
 * Time: 2:16 PM
 */
class Attribute
{
    protected 	$id;
    protected 	$name;
    protected 	$value_list;
    protected 	$attribute_type;
    protected 	$order;
    protected 	$created_at;
    protected 	$updated_at;

    public function __construct($id=0)
    {

        if ($id !== 0)
            $this->setId($id);
        if ($this->getId()!==0)
            $this->load();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    private function load()
    {
        $db=db::get();
        $rqs = $db->prepare('SELECT * FROM '.config::get('db_prefixe').'attributes where id = ?');
        $rqs->execute(array($this->id));

        if($results = $rqs->fetchObject())
        {
            $this->setName($results->name);


            $this->setAttributeType($results->attribute_type);

            $this->setOrder($results->order);
            $this->setCreatedAt($results->created_at);
            $this->setUpdatedAt($results->updated_at);
        }
        else
        {
            /*Erreur code 10 - Incohérence BDD*/
            throw new erreur(10);
        }
    }

}
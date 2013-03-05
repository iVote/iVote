<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Position
 */
class Position
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var integer $limit
     */
    private $limit;

    /**
     * @var boolean $isGroupDependent
     */
    private $isGroupDependent;

    /**
     * @var boolean $is_active
     */
    private $is_active;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Position
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set limit
     *
     * @param integer $limit
     * @return Position
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get limit
     *
     * @return integer 
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set isGroupDependent
     *
     * @param boolean $isGroupDependent
     * @return Position
     */
    public function setIsGroupDependent($isGroupDependent)
    {
        $this->isGroupDependent = $isGroupDependent;
        return $this;
    }

    /**
     * Get isGroupDependent
     *
     * @return boolean 
     */
    public function getIsGroupDependent()
    {
        return $this->isGroupDependent;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return Position
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
}
<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Position
 */
class Position
{

    const BOOL_TRUE  = 1;
    const BOOL_FALSE = 0;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var integer $limitation
     */
    private $limitation;

    /**
     * @var boolean $isGroupDependent
     */
    private $isGroupDependent;

    /**
     * @var boolean $isActive
     */
    private $isActive;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set limitation
     *
     * @param integer $limitation
     * @return Position
     */
    public function setLimitation($limitation)
    {
        $this->limitation = $limitation;
        return $this;
    }

    /**
     * Get limitation
     *
     * @return integer 
     */
    public function getLimitation()
    {
        return $this->limitation;
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Position
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add groups
     *
     * @param Entities\Group $groups
     * @return Position
     */
    public function addGroup(\Entities\Group $groups)
    {
        $this->groups[] = $groups;
        return $this;
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
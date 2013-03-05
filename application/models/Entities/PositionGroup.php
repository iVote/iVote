<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\PositionGroup
 */
class PositionGroup
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $positions_id
     */
    private $positions_id;

    /**
     * @var integer $groups_id
     */
    private $groups_id;


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
     * Set positions_id
     *
     * @param integer $positionsId
     * @return PositionGroup
     */
    public function setPositionsId($positionsId)
    {
        $this->positions_id = $positionsId;
        return $this;
    }

    /**
     * Get positions_id
     *
     * @return integer 
     */
    public function getPositionsId()
    {
        return $this->positions_id;
    }

    /**
     * Set groups_id
     *
     * @param integer $groupsId
     * @return PositionGroup
     */
    public function setGroupsId($groupsId)
    {
        $this->groups_id = $groupsId;
        return $this;
    }

    /**
     * Get groups_id
     *
     * @return integer 
     */
    public function getGroupsId()
    {
        return $this->groups_id;
    }
}
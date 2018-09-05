<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * MilestoneMem
 *
 * @ORM\Table(name="milestone_mem")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MilestoneMemRepository")
 */
class MilestoneMem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ManyToOne(targetEntity = "AppBundle\Entity\Milestone")
     * @JoinColumn(name="milestoneId", referencedColumnName="id")
     * @ORM\Column(name="milestoneId", type="integer")
     */
    private $milestoneId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set milestoneId
     *
     * @param integer $milestoneId
     *
     * @return MilestoneMem
     */
    public function setMilestoneId($milestoneId)
    {
        $this->milestoneId = $milestoneId;

        return $this;
    }

    /**
     * Get milestoneId
     *
     * @return int
     */
    public function getMilestoneId()
    {
        return $this->milestoneId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MilestoneMem
     */
    public function setName($name)
    {
        $this->name = $name->getName();

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return MilestoneMem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}


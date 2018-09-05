<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;


/**
 * Inspector
 *
 * @ORM\Table(name="inspector")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InspectorRepository")
 */
class Inspector
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
     * @var string
     * @ManyToOne(targetEntity="AppBundle\Entity\Prospect")
     * @JoinColumn(name="prospect", referencedColumnName="name")
     * @ORM\Column(name="prospect", type="string", length=255)
     */
    private $prospect;

    /**
     * @var string
     * @ManyToOne(targetEntity="AppBundle\Entity\Staff")
     * @JoinColumn(name="staff", referencedColumnName="name")
     * @ORM\Column(name="staff", type="string", length=255)
     */
    private $staff;

    /**
     * @var string
     * @ManyToOne(targetEntity="AppBundle\Entity\Properties")
     * @JoinColumn(name="inProperty", referencedColumnName="name")
     * @ORM\Column(name="inProperty", type="string", length=255)
     */
    private $inProperty;

    /**
     * @var string
     *
     * @ORM\Column(name="prospectRemark", type="string", length=255)
     */
    private $prospectRemark;

    /**
     * @var string
     *
     * @ORM\Column(name="staffRemark", type="string", length=255)
     */
    private $staffRemark;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set prospect
     *
     * @param string $prospect
     *
     * @return Inspector
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect->getProspectName();

        return $this;
    }

    /**
     * Get prospect
     *
     * @return string
     */
    public function getProspect()
    {
        return $this->prospect;
    }

    /**
     * Set staff
     *
     * @param string $staff
     *
     * @return Inspector
     */
    public function setStaff($staff)
    {
        $this->staff = $staff->getName();

        return $this;
    }

    /**
     * Get staff
     *
     * @return string
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * Set property
     *
     * @param string $property
     *
     * @return Inspector
     */
    public function setInProperty($inProperty)
    {
        $this->inProperty = $inProperty->getName();

        return $this;
    }

    /**
     * Get property
     *
     * @return string
     */
    public function getInProperty()
    {
        return $this->inProperty;
    }

    /**
     * Set prospectRemark
     *
     * @param string $prospectRemark
     *
     * @return Inspector
     */
    public function setProspectRemark($prospectRemark)
    {
        $this->prospectRemark = $prospectRemark;

        return $this;
    }

    /**
     * Get prospectRemark
     *
     * @return string
     */
    public function getProspectRemark()
    {
        return $this->prospectRemark;
    }

    /**
     * Set staffRemark
     *
     * @param string $staffRemark
     *
     * @return Inspector
     */
    public function setStaffRemark($staffRemark)
    {
        $this->staffRemark = $staffRemark;

        return $this;
    }

    /**
     * Get staffRemark
     *
     * @return string
     */
    public function getStaffRemark()
    {
        return $this->staffRemark;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Inspector
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}


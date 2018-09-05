<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prospect
 *
 * @ORM\Table(name="prospect")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProspectRepository")
 */
class Prospect
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $prospectName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $prospectEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNo", type="text")
     */
    private $prospectPhoneNo;


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
     * Set name
     *
     * @param string $name
     *
     * @return Prospect
     */
    public function setProspectName($prospectName)
    {
        $this->prospectName = $prospectName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getProspectName()
    {
        return $this->prospectName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Prospect
     */
    public function setProspectEmail($prospectEmail)
    {
        $this->prospectEmail = $prospectEmail;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getProspectEmail()
    {
        return $this->prospectEmail;
    }

    /**
     * Set phoneNo
     *
     * @param string $phoneNo
     *
     * @return Prospect
     */
    public function setProspectPhoneNo($prospectPhoneNo)
    {
        $this->prospectPhoneNo = $prospectPhoneNo;

        return $this;
    }

    /**
     * Get phoneNo
     *
     * @return string
     */
    public function getProspectPhoneNo()
    {
        return $this->prospectPhoneNo;
    }
}


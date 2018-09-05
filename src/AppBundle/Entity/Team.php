<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Team
 * @UniqueEntity(fields="name",message="The team name is taken")
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 */
class Team
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
     * @Assert\NotBlank()
     * @Assert\Length(min="4", minMessage="Please enter at last 4 characters in the name box")
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ASSERT\Length(min= "12",minMessage="Please enter atleast 12 characters in the description box")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set description
     *
     * @param string $description
     *
     * @return Team
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set teamLeader
     *
     * @param integer $teamLeader
     *
     * @return Team
     */
    public function setTeamLeader($teamLeader)
    {
        $this->teamLeader = $teamLeader->getId();

        return $this;
    }

    /**
     * Get teamLeader
     *
     * @return int
     */
    public function getTeamLeader()
    {
        return $this->teamLeader;
    }

    /**
     * Set teamMate1
     *
     * @param integer $teamMate1
     *
     * @return Team
     */
    public function setTeamMate1($teamMate1)
    {
        $this->teamMate1 = $teamMate1->getId();

        return $this;
    }

    /**
     * Get teamMate1
     *
     * @return int
     */
    public function getTeamMate1()
    {
        return $this->teamMate1;
    }

    /**
     * Set teamMate2
     *
     * @param integer $teamMate2
     *
     * @return Team
     */
    public function setTeamMate2($teamMate2)
    {
        $this->teamMate2 = $teamMate2->getId();

        return $this;
    }

    /**
     * Get teamMate2
     *
     * @return int
     */
    public function getTeamMate2()
    {
        return $this->teamMate2;
    }

    /**
     * Set teamMate3
     *
     * @param integer $teamMate3
     *
     * @return Team
     */
    public function setTeamMate3($teamMate3)
    {
        $this->teamMate3 = $teamMate3->getId();

        return $this;
    }

    /**
     * Get teamMate3
     *
     * @return int
     */
    public function getTeamMate3()
    {
        return $this->teamMate3;
    }

    /**
     * Set teamMate4
     *
     * @param integer $teamMate4
     *
     * @return Team
     */
    public function setTeamMate4($teamMate4)
    {
        $this->teamMate4 = $teamMate4->getId();

        return $this;
    }

    /**
     * Get teamMate4
     *
     * @return int
     */
    public function getTeamMate4()
    {
        return $this->teamMate4;
    }

    /**
     * Set teamMate5
     *
     * @param integer $teamMate5
     *
     * @return Team
     */
    public function setTeamMate5($teamMate5)
    {
        $this->teamMate5 = $teamMate5->getId();

        return $this;
    }

    /**
     * Get teamMate5
     *
     * @return int
     */
    public function getTeamMate5()
    {
        return $this->teamMate5;
    }

    /**
     * Set teamMate6
     *
     * @param integer $teamMate6
     *
     * @return Team
     */
    public function setTeamMate6($teamMate6)
    {
        $this->teamMate6 = $teamMate6->getId();

        return $this;
    }

    /**
     * Get teamMate6
     *
     * @return int
     */
    public function getTeamMate6()
    {
        return $this->teamMate6;
    }

    
}


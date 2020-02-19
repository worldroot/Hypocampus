<?php

namespace TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="TeamBundle\Repository\teamRepository")
 */
class team
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
     * @ORM\Column(name="teamname", type="string", length=255)
     */
    private $teamname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateofcreation", type="date")
     */
    private $dateofcreation;


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
     * Set teamname
     *
     * @param string $teamname
     *
     * @return team
     */
    public function setTeamname($teamname)
    {
        $this->teamname = $teamname;

        return $this;
    }

    /**
     * Get teamname
     *
     * @return string
     */
    public function getTeamname()
    {
        return $this->teamname;
    }

    /**
     * Set dateofcreation
     *
     * @param \DateTime $dateofcreation
     *
     * @return team
     */
    public function setDateofcreation($dateofcreation)
    {
        $this->dateofcreation = $dateofcreation;

        return $this;
    }

    /**
     * Get dateofcreation
     *
     * @return \DateTime
     */
    public function getDateofcreation()
    {
        return $this->dateofcreation;
    }
}

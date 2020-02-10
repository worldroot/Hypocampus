<?php

namespace projetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * projets
 *
 * @ORM\Table(name="projets")
 * @ORM\Entity(repositoryClass="projetsBundle\Repository\projetsRepository")
 */
class projets
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
     * @ORM\Column(name="projet_name", type="string", length=255)
     */
    private $projetName;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255)
     */
    private $owner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
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
     * Set projetName
     *
     * @param string $projetName
     *
     * @return projets
     */
    public function setProjetName($projetName)
    {
        $this->projetName = $projetName;

        return $this;
    }

    /**
     * Get projetName
     *
     * @return string
     */
    public function getProjetName()
    {
        return $this->projetName;
    }

    /**
     * Set owner
     *
     * @param string $owner
     *
     * @return projets
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return projets
     */
    public function setStartDate($startDate)
    {
        $this->startDate = new \DateTime($startDate) ;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return projets
     */
    public function setEndDate($endDate)
    {
        $this->endDate = new \DateTime($endDate) ;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return projets
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
}


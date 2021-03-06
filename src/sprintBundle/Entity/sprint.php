<?php

namespace sprintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * sprint
 *
 * @ORM\Table(name="sprint")
 * @ORM\Entity(repositoryClass="sprintBundle\Repository\sprintRepository")
 */
class sprint
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
     * @ORM\Column(name="sprintname", type="string", length=255)
     */
    private $sprintName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDatesprint", type="date")
     */
    private $startDatesprint;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDatesprint", type="date")
     */
    private $endDatesprint;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;
    /**
     * @ORM\ManyToOne(targetEntity="\projetsBundle\Entity\projets")
     * @ORM\JoinColumn(name="projets_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $projets;

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
     * Set startDatesprint
     *
     * @param \DateTime $startDatesprint
     *
     * @return sprint
     */
    public function setStartDatesprint($startDatesprint)
    {
        $this->startDatesprint = $startDatesprint;

        return $this;
    }

    /**
     * Get startDatesprint
     *
     * @return \DateTime
     */
    public function getStartDatesprint()
    {
        return $this->startDatesprint;
    }

    /**
     * Set endDatesprint
     *
     * @param \DateTime $endDatesprint
     *
     * @return sprint
     */
    public function setEndDatesprint($endDatesprint)
    {
        $this->endDatesprint = $endDatesprint;

        return $this;
    }

    /**
     * Get endDatesprint
     *
     * @return \DateTime
     */
    public function getEndDatesprint()
    {
        return $this->endDatesprint;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return sprint
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set sprintName
     *
     * @param string $sprintName
     *
     * @return sprint
     */
    public function setSprintName($sprintName)
    {
        $this->sprintName = $sprintName;

        return $this;
    }

    /**
     * Get sprintName
     *
     * @return string
     */
    public function getSprintName()
    {
        return $this->sprintName;
    }

    /**
     * Set projets
     *
     * @param \projetsBundle\Entity\projets $projets
     *
     * @return sprint
     */
    public function setProjets(\projetsBundle\Entity\projets $projets )
    {
        $this->projets = $projets;

        return $this;
    }

    /**
     * Get projets
     *
     * @return \projetsBundle\Entity\projets
     */
    public function getProjets()
    {
        return $this->projets;
    }
}

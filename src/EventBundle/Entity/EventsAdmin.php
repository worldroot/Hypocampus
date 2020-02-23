<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EventsAdmin
 *
 * @ORM\Table(name="events_admin")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventsAdminRepository")
 */
class EventsAdmin
{
    /**
     * @var int
     *
     * @ORM\Column(name="idev", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idEv;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreEvent", type="string", length=255)
     */
    private $titreEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="NumeroEvent", type="integer")
     */
    private $numeroEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeEvent", type="string", length=255)
     */
    private $typeEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateEvent", type="date", nullable=TRUE)
     *
     */
    private $dateEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddateEvent", type="date", nullable=TRUE)
     * @Assert\GreaterThan(propertyPath="dateEvent")
     *
     */
    private $enddateEvent;


    /**
     * @return \DateTime
     */
    public function getEnddateEvent()
    {
        return $this->enddateEvent;
    }

    /**
     * @param \DateTime $enddateEvent
     */
    public function setEnddateEvent($enddateEvent)
    {
        $this->enddateEvent = $enddateEvent;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getIdev()
    {
        return $this->idEv;
    }

    /**
     * Set titreEvent
     *
     * @param string $titreEvent
     *
     * @return EventsAdmin
     */
    public function setTitreEvent($titreEvent)
    {
        $this->titreEvent = $titreEvent;

        return $this;
    }

    /**
     * Get titreEvent
     *
     * @return string
     */
    public function getTitreEvent()
    {
        return $this->titreEvent;
    }

    /**
     * Set numeroEvent
     *
     * @param integer $numeroEvent
     *
     * @return EventsAdmin
     */
    public function setNumeroEvent($numeroEvent)
    {
        $this->numeroEvent = $numeroEvent;

        return $this;
    }

    /**
     * Get numeroEvent
     *
     * @return int
     */
    public function getNumeroEvent()
    {
        return $this->numeroEvent;
    }

    /**
     * Set typeEvent
     *
     * @param string $typeEvent
     *
     * @return EventsAdmin
     */
    public function setTypeEvent($typeEvent)
    {
        $this->typeEvent = $typeEvent;

        return $this;
    }

    /**
     * Get typeEvent
     *
     * @return string
     */
    public function getTypeEvent()
    {
        return $this->typeEvent;
    }

    /**
     * @return \DateTime
     */
    public function getDateEvent()
    {
        return $this->dateEvent;
    }

    /**
     * @param \DateTime $dateEvent
     */
    public function setDateEvent($dateEvent)
    {
        $this->dateEvent = $dateEvent;
    }






}


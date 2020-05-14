<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * EventsAdmin
 *
 * @ORM\Table(name="events_admin")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventsAdminRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="commentaire_file", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=TRUE)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;


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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }






}


<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Certif
 *
 * @ORM\Table(name="certif")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\CertifRepository")
 * @Vich\Uploadable
 */
class Certif
{
    /**
     * @var int
     *
     * @ORM\Column(name="idc", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idc;

    /**
     * @var string
     *
     *
     *@ORM\ManyToOne(targetEntity="EventsAdmin")
     *@ORM\JoinColumn(name="titrec",referencedColumnName="idev", onDelete="CASCADE")
     */
    private $titrec;

    /**
     * @var int
     *
     * @ORM\Column(name="pointc", type="integer")
     */
    private $pointc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datec",  type="date", nullable=TRUE)
     */
    private $datec;

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
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getIdc()
    {
        return $this->idc;
    }

    /**
     * Set titrec
     *
     * @param \EventBundle\Entity\EventsAdmin $titrec
     *
     * @return Certif
     */
    public function setTitrec(\EventBundle\Entity\EventsAdmin $titrec)
    {
        $this->titrec = $titrec;

        return $this;
    }

    /**
     * Get titrec
     *
     * @return \EventBundle\Entity\EventsAdmin
     */
    public function getTitrec()
    {
        return $this->titrec;
    }

    /**
     * Set pointc
     *
     * @param integer $pointc
     *
     * @return Certif
     */
    public function setPointc($pointc)
    {
        $this->pointc = $pointc;

        return $this;
    }

    /**
     * Get pointc
     *
     * @return int
     */
    public function getPointc()
    {
        return $this->pointc;
    }

    /**
     * Set datec
     *
     * @param \DateTime $datec
     *
     * @return Certif
     */
    public function setDatec($datec)
    {
        $this->datec = $datec;

        return $this;
    }

    /**
     * Get datec
     *
     * @return \DateTime
     */
    public function getDatec()
    {
        return $this->datec;
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


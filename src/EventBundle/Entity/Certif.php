<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Certif
 *
 * @ORM\Table(name="certif")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\CertifRepository")
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
}


<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\ParticipantRepository")
 */
class Participant
{


    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="nomp", type="string", length=255)
     */
    private $nomp;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomp", type="string", length=255)
     */
    private $prenomp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordp", type="string", length=255)
     */
    private $passwordp;

    /**
     *@ORM\ManyToOne(targetEntity="EventsAdmin")
     *@ORM\JoinColumn(name="choix",referencedColumnName="idev", onDelete="CASCADE")
     */
    private $choix;

    /**
     * Set choix
     *
     * @param \EventBundle\Entity\EventsAdmin $choix
     *
     * @return Participant
     */
    public function setChoix(\EventBundle\Entity\EventsAdmin $choix)
    {
        $this->choix = $choix;

        return $this;
    }

    /**
     * Get choix
     *
     * @return \EventBundle\Entity\EventsAdmin
     */
    public function getChoix()
    {
        return $this->choix;
    }


    /**
     * Set nomp
     *
     * @param string $nomp
     *
     * @return Participant
     */
    public function setNomp($nomp)
    {
        $this->nomp = $nomp;

        return $this;
    }

    /**
     * Get nomp
     *
     * @return string
     */
    public function getNomp()
    {
        return $this->nomp;
    }

    /**
     * Set prenomp
     *
     * @param string $prenomp
     *
     * @return Participant
     */
    public function setPrenomp($prenomp)
    {
        $this->prenomp = $prenomp;

        return $this;
    }

    /**
     * Get prenomp
     *
     * @return string
     */
    public function getPrenomp()
    {
        return $this->prenomp;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Participant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwordp
     *
     * @param string $passwordp
     *
     * @return Participant
     */
    public function setPasswordp($passwordp)
    {
        $this->passwordp = $passwordp;

        return $this;
    }

    /**
     * Get passwordp
     *
     * @return string
     */
    public function getPasswordp()
    {
        return $this->passwordp;
    }


}


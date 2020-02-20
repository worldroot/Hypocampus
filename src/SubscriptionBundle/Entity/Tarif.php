<?php

namespace SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarif
 *
 * @ORM\Table(name="tarif")
 * @ORM\Entity(repositoryClass="SubscriptionBundle\Repository\TarifRepository")
 */
class Tarif
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
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="projectnbr", type="integer")
     */
    private $projectnbr;

    /**
     * @var int
     *
     * @ORM\Column(name="usernbr", type="integer")
     */
    private $usernbr;


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
     * @return Tarif
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
     * Set value
     *
     * @param integer $value
     *
     * @return Tarif
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set projectnbr
     *
     * @param integer $projectnbr
     *
     * @return Tarif
     */
    public function setProjectnbr($projectnbr)
    {
        $this->projectnbr = $projectnbr;

        return $this;
    }

    /**
     * Get projectnbr
     *
     * @return int
     */
    public function getProjectnbr()
    {
        return $this->projectnbr;
    }

    /**
     * Set usernbr
     *
     * @param integer $usernbr
     *
     * @return Tarif
     */
    public function setUsernbr($usernbr)
    {
        $this->usernbr = $usernbr;

        return $this;
    }

    /**
     * Get usernbr
     *
     * @return int
     */
    public function getUsernbr()
    {
        return $this->usernbr;
    }
}


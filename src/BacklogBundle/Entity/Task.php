<?php

namespace BacklogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="BacklogBundle\Repository\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description_fonctionnel", type="text")
     */
    private $descriptionFonctionnel;

    /**
     * @var string
     *
     * @ORM\Column(name="description_technique", type="text")
     */
    private $descriptionTechnique;

    /**
     * @var int
     *
     * @ORM\Column(name="story_points", type="integer")
     */
    private $storyPoints;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="date")
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished_date", type="date")
     */
    private $finishedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var int
     *
     * @ORM\Column(name="archive", type="integer")
     */
    private $archive;

    /**
     * @ORM\ManyToOne(targetEntity="Backlog")
     * @ORM\JoinColumn(name="backlog_id", referencedColumnName="id")
     */
    private $backlog;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Task
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


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
     * Set title
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set descriptionFonctionnel
     *
     * @param string $descriptionFonctionnel
     *
     * @return Task
     */
    public function setDescriptionFonctionnel($descriptionFonctionnel)
    {
        $this->descriptionFonctionnel = $descriptionFonctionnel;

        return $this;
    }

    /**
     * Get descriptionFonctionnel
     *
     * @return string
     */
    public function getDescriptionFonctionnel()
    {
        return $this->descriptionFonctionnel;
    }

    /**
     * Set descriptionTechnique
     *
     * @param string $descriptionTechnique
     *
     * @return Task
     */
    public function setDescriptionTechnique($descriptionTechnique)
    {
        $this->descriptionTechnique = $descriptionTechnique;

        return $this;
    }

    /**
     * Get descriptionTechnique
     *
     * @return string
     */
    public function getDescriptionTechnique()
    {
        return $this->descriptionTechnique;
    }

    /**
     * Set storyPoints
     *
     * @param integer $storyPoints
     *
     * @return Task
     */
    public function setStoryPoints($storyPoints)
    {
        $this->storyPoints = $storyPoints;

        return $this;
    }

    /**
     * Get storyPoints
     *
     * @return int
     */
    public function getStoryPoints()
    {
        return $this->storyPoints;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Task
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set finishedDate
     *
     * @param \DateTime $finishedDate
     *
     * @return Task
     */
    public function setFinishedDate($finishedDate)
    {
        $this->finishedDate = $finishedDate;

        return $this;
    }

    /**
     * Get finishedDate
     *
     * @return \DateTime
     */
    public function getFinishedDate()
    {
        return $this->finishedDate;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Task
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set priority
     *
     * @param int $priority
     *
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set backlog
     *
     * @param \BacklogBundle\Entity\Backlog $backlog
     *
     * @return Task
     */
    public function setBacklog(\BacklogBundle\Entity\Backlog $backlog = null)
    {
        $this->backlog = $backlog;

        return $this;
    }

    /**
     * Get backlog
     *
     * @return \BacklogBundle\Entity\Backlog
     */
    public function getBacklog()
    {
        return $this->backlog;
    }

    /**
     * @return int
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @param int $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    }

}

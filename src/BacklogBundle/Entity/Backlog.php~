<?php

namespace BacklogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Backlog
 *
 * @ORM\Table(name="backlog")
 * @ORM\Entity(repositoryClass="BacklogBundle\Repository\BacklogRepository")
 */
class Backlog
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
     * @var int
     *
     * @ORM\Column(name="points_done", type="integer")
     */
    private $pointsDone;

    /**
     * @var int
     *
     * @ORM\Column(name="points_in_progress", type="integer")
     */
    private $pointsInProgress;

    /**
     * @var int
     *
     * @ORM\Column(name="points_to_do", type="integer")
     */
    private $pointsToDo;

    /**
     * @ORM\OneToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @return \BacklogBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \BacklogBundle\Entity\Project $project
     *
     * @return Backlog
     */
    public function setProject($project)
    {
        $this->project = $project;
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
     * Set pointsDone
     *
     * @param integer $pointsDone
     *
     * @return Backlog
     */
    public function setPointsDone($pointsDone)
    {
        $this->pointsDone = $pointsDone;

        return $this;
    }

    /**
     * Get pointsDone
     *
     * @return int
     */
    public function getPointsDone()
    {
        return $this->pointsDone;
    }

    /**
     * Set pointsInProgress
     *
     * @param integer $pointsInProgress
     *
     * @return Backlog
     */
    public function setPointsInProgress($pointsInProgress)
    {
        $this->pointsInProgress = $pointsInProgress;

        return $this;
    }

    /**
     * Get pointsInProgress
     *
     * @return int
     */
    public function getPointsInProgress()
    {
        return $this->pointsInProgress;
    }

    /**
     * Set pointsToDo
     *
     * @param integer $pointsToDo
     *
     * @return Backlog
     */
    public function setPointsToDo($pointsToDo)
    {
        $this->pointsToDo = $pointsToDo;

        return $this;
    }

    /**
     * Get pointsToDo
     *
     * @return int
     */
    public function getPointsToDo()
    {
        return $this->pointsToDo;
    }
}

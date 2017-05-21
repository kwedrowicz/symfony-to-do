<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Category.
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ExclusionPolicy("none")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection|Task[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="category")
     * @Exclude()
     */
    private $tasks;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add task.
     *
     * @param Task $task
     *
     * @return Category
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task.
     *
     * @param Task $task
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks.
     *
     * @return Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}

<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Task;
use Symfony\Component\Form\FormFactory;

class TaskFormGenerator
{
    private $factory;

    /**
     * TaskFormGenerator constructor.
     *
     * @param $factory
     */
    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory;
    }

    public function generateDeleteFormViews($tasks)
    {
        $deleteForms = [];
        /* @var Task $task */
        foreach ($tasks as $task) {
            $deleteForms[$task->getId()] = $this->factory->create('AppBundle\Form\Type\TaskTypeDelete', $task)->createView();
        }

        return $deleteForms;
    }
}

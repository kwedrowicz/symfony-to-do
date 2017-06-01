<?php

declare(strict_types=1);

namespace AppBundle\Service\Task;

use AppBundle\Entity\User;
use AppBundle\SearchRepository\TaskRepository;
use FOS\ElasticaBundle\Doctrine\RepositoryManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class TaskFinder
{
    private $kernel;
    private $repositoryManager;

    /**
     * TaskFinder constructor.
     *
     * @param $kernel
     * @param $repositoryManager
     */
    public function __construct(KernelInterface $kernel, RepositoryManager $repositoryManager)
    {
        $this->kernel = $kernel;
        $this->repositoryManager = $repositoryManager;
    }

    public function findByElastic(User $user, Request $request): array
    {
        $search = $request->query->get('search');
        if ($this->kernel->getEnvironment() != 'test') {
            /** @var TaskRepository $repository */
            $repository = $this->repositoryManager->getRepository('AppBundle:Task');
            /** var array of Acme\UserBundle\Entity\User */
            $tasks = $repository->findWithUser($user, $search);
        } else {
            $tasks = $user->getTasks()->toArray();
        }

        return $tasks;
    }
}

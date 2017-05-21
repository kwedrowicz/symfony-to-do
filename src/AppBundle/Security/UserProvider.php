<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof Wędrowicz krzysztof@wedrowicz.me
 * Date: 14.01.17
 * Time: 23:33.
 */

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var ManagerRegistry
     */
    private $mr;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->mr = $managerRegistry;
    }

    public function loadUserByUsername($username)
    {
        return $this->mr->getManager()->getRepository('AppBundle:User')->loadUserByUsername($username);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->mr->getManager()->getRepository('AppBundle:User')->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class == 'AppBundle\Entity\User';
    }
}

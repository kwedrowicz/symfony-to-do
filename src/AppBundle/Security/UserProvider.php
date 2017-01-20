<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof Wędrowicz krzysztof@wedrowicz.me
 * Date: 14.01.17
 * Time: 23:33
 */

namespace AppBundle\Security;


use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface {

	/**
	 * @var EntityManager
	 */
	private $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;

	}

	public function loadUserByUsername( $username ) {
		return $this->em->getRepository('AppBundle:User')->loadUserByUsername($username);
	}

	public function refreshUser( UserInterface $user ) {
		return $user;
	}

	public function supportsClass( $class ) {
		return $class == 'AppBundle\Entity\User';
	}
}

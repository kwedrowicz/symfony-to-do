<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof Wędrowicz krzysztof@wedrowicz.me
 * Date: 14.01.17
 * Time: 23:33
 */

namespace AppBundle\Security;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface {

	public function loadUserByUsername( $username ) {
		// "load" the user - e.g. load from the db
		$user = new User($username);
		return $user;
	}

	public function refreshUser( UserInterface $user ) {
		return $user;
	}

	public function supportsClass( $class ) {
		return $class == 'AppBundle\Entity\User';
	}
}

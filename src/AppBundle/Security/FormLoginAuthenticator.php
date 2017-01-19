<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof Wędrowicz krzysztof@wedrowicz.me
 * Date: 14.01.17
 * Time: 23:22
 */

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class FormLoginAuthenticator extends AbstractGuardAuthenticator
{
	/**
	 * @var \Symfony\Component\Routing\RouterInterface
	 */
	private $router;

	public function __construct(RouterInterface $router) {
		$this->router = $router;
	}

	public function getCredentials(Request $request) {
		if ($request->getPathInfo() != '/login_check') {
			return;
		}
		return [
			'username' => $request->request->get('_username'),
			'password' => $request->request->get('_password'),
		];
	}

	public function getUser($credentials, UserProviderInterface $userProvider) {
		$username = $credentials['username'];
		return $userProvider->loadUserByUsername($username);
	}

	public function checkCredentials($credentials, UserInterface $user) {
		$password = $credentials['password'];
		if ($password == 'santa' || $password == 'elves') {
			return;
		}
		return false;
	}

	public function onAuthenticationFailure(Request $request,
		AuthenticationException $exception) {
		$url = $this->router->generate('security_login');
		return new RedirectResponse($url);
	}

	public function onAuthenticationSuccess(Request $request,
		TokenInterface $token, $providerKey) {
		$url = $this->router->generate('homepage');
		return new RedirectResponse($url);
	}

	public function start(Request $request, AuthenticationException $e = null) {
		$url = $this->router->generate('security_login');
		return new RedirectResponse($url);
	}

	public function supportsRememberMe() {
	}
}

<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof Wędrowicz krzysztof@wedrowicz.me
 * Date: 14.01.17
 * Time: 23:17
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="security_login", methods={"GET"})
	 */
	public function loginAction()
	{
		return $this->render('security/login.html.twig');
	}
	/**
	 * @Route("/login_check", name="login_check", methods={"GET","POST"})
	 */
	public function loginCheckAction()
	{
		// will never be executed
	}
}

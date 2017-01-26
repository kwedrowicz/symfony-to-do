<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
	use \Behat\Symfony2Extension\Context\KernelDictionary;

	/**
	 * @Given there is a user :username with password :password
	 */
	public function thereIsAUserWithPassword($username, $password)
	{
		$user = new \AppBundle\Entity\User();
		$user->setUsername($username);
		$user->setPlainPassword($password);
		$user->setEmail("$username.@gmail.com");
		$em = $this->getContainer()->get('doctrine')->getManager();
		$em->persist($user);
		$em->flush();
	}

	/**
	 * @BeforeScenario
	 */
	public function clearData()
	{
		$purger = new ORMPurger($this->getContainer()->get('doctrine')->getManager());
		$purger->purge();
	}

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
}

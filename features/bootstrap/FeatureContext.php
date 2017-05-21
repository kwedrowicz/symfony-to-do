<?php

namespace Features\Bootstrap;

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
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @Given I am logged in as a user
     */
    public function iAmLoggedInAsAUser()
    {
        $this->thereIsAUserWithPassword('user', 'password');
        $this->visitPath('/login');
        $this->getPage()->fillField('Username', 'user');
        $this->getPage()->fillField('Password', 'password');
        $this->getPage()->pressButton('Login');
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
     * @return \Behat\Mink\Element\DocumentElement
     */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
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

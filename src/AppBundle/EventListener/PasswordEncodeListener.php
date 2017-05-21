<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncodeListener
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $encoded = $this->encoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encoded);
    }
}

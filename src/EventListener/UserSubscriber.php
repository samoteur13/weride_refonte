<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEventListener implements EventSubscriber
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->hashUserPassword($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->hashUserPassword($args);
    }

    private function hashUserPassword(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $plainPassword = $entity->getPassword();

            if (!empty($plainPassword)) {
                $hashedPassword = $this->passwordHasher->hashPassword($entity, $plainPassword);
                $entity->setPassword($hashedPassword);
            }
        }
    }
}

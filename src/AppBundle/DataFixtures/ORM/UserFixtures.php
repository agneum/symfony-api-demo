<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class UserFixtures
 * @package AppBundle\DataFixtures\ORM
 */
class UserFixtures extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstname('John')
            ->setLastname('Doe')
            ->setEmail('john_user@symfony.com')
            ->setIsActive(true);

        $manager->persist($user);
        $this->addReference('john-user', $user);

        $manager->flush();
    }
}

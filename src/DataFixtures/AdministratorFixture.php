<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministratorFixture extends Fixture
{
    /** @var UserPasswordEncoderInterface $passwordEncoder */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $batchSize = 20;
        for ($i = 1; $i <= 40; ++$i) {
            $user = new Administrator();

            $user->setUsername("admin({$i})");

            $user->setPlainPassword("{$i}");

            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setEmail("test{$i}@gmail.com");

            $manager->persist($user);

            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
    }
}

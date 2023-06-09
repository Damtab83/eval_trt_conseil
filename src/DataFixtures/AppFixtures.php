<?php

namespace App\DataFixtures;

use App\Entity\Notice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        //Users
        $users = [];
        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user->setLastName($this->faker->lastname())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $users[] = $user;
            $manager->persist($user);
        }

        //Notice
        $notices = [];
        for ($i=1; $i <=50 ; $i++) {
            $notice = new Notice();
            $notice->settitle('Annonce ' . $i)
                ->setDescription($this->faker->text())
                ->setLocation('Cannes')
                ->setSalary(mt_rand(1500, 2300))
                ->setSchedule(mt_rand(7, 12))
                ->setRecruteur($users[mt_rand(0, count($users) - 1)]);

                $notices[] =$notice;
                $manager->persist($notice);
        }



        $manager->flush();
    }
}

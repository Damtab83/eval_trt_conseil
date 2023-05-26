<?php

namespace App\DataFixtures;

use App\Entity\Notice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

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
        for ($i=1; $i <=50 ; $i++) { 
            $notice = new Notice();
            $notice->settitle('Annonce ' . $i)
                ->setDescription($this->faker->text())
                ->setLocation('Cannes')
                ->setSalary(mt_rand(1500, 2300))
                ->setSchedule(mt_rand(7, 12));

                $manager->persist($notice);
        }


        $manager->flush();
    }
}

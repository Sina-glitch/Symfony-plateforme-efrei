<?php

namespace App\DataFixtures;

use App\Entity\Association;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $association = new Association();
        $association->setNom('Association A');
        $association->setDescription('Description de l\'Association A');

        $manager->persist($association);

        $association2 = new Association();
        $association2->setNom('Association B');
        $association2->setDescription('Description de l\'Association B');

        $manager->persist($association2);

        $manager->flush();
    }
}

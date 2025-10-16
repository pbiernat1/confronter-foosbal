<?php

namespace App\DataFixtures\TournamentCreator;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestGetNotExistingPlayerPairFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p = (new Player())
            ->setFirstName('Test1')
            ->setLastName('TestLastName1')
            ->setActive(true)
            ->setRanking(100)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test2')
            ->setLastName('TestLastName2')
            ->setActive(true)
            ->setRanking(200)
        ;
        $manager->persist($p);
        $p = (new Player())
            ->setFirstName('Test1')
            ->setLastName('TestLastName1')
            ->setActive(true)
            ->setRanking(300)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test2')
            ->setLastName('TestLastName2')
            ->setActive(true)
            ->setRanking(400)
        ;
        $manager->persist($p);

        $manager->flush();
    }
}

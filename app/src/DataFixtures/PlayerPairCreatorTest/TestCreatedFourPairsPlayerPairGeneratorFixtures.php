<?php

namespace App\DataFixtures\PlayerPairCreatorTest;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestCreatedFourPairsPlayerPairGeneratorFixtures extends Fixture
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
            ->setRanking(110)
        ;
        $manager->persist($p);
        $p = (new Player())
            ->setFirstName('Test1')
            ->setLastName('TestLastName1')
            ->setActive(true)
            ->setRanking(200)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test2')
            ->setLastName('TestLastName2')
            ->setActive(true)
            ->setRanking(220)
        ;
        $manager->persist($p);

        $manager->flush();
    }
}

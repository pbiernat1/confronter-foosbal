<?php

namespace App\DataFixtures\PlayerFilterTest;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestSuccessFilterWithActiveStrategyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p = (new Player())
            ->setFirstName('Test1')
            ->setLastName('TestLastName1')
            ->setActive(false)
            ->setRanking(100)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test2')
            ->setLastName('TestLastName2')
            ->setActive(false)
            ->setRanking(101)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test3')
            ->setLastName('TestLastName3')
            ->setActive(true)
            ->setRanking(102)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test4')
            ->setLastName('TestLastName4')
            ->setActive(true)
            ->setRanking(103)
        ;
        $manager->persist($p);

        $manager->flush();
    }
}

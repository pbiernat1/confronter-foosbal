<?php
declare(strict_types=1);

namespace App\DataFixtures\TournamentController;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestGenerateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p = (new Player())
            ->setFirstName('Test1')
            ->setLastName('TestLastName1')
            ->setActive(true)
            ->setRanking(115)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test2')
            ->setLastName('TestLastName2')
            ->setActive(true)
            ->setRanking(125)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test3')
            ->setLastName('TestLastName3')
            ->setActive(true)
            ->setRanking(245)
        ;
        $manager->persist($p);

        $p = (new Player())
            ->setFirstName('Test3')
            ->setLastName('TestLastName3')
            ->setActive(true)
            ->setRanking(235)
        ;
        $manager->persist($p);

        $manager->flush();
    }
}

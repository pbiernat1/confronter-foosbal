<?php
declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

trait Fixtures
{
    public function loadFixture(FixtureInterface $fixture): void
    {
        $fixtureLoader = new Loader();
        $fixtureLoader->addFixture($fixture);

        $executor = new ORMExecutor($this->manager, new ORMPurger($this->manager));
        $executor->execute($fixtureLoader->getFixtures());
    }
}
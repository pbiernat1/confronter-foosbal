<?php
declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTestCase extends KernelTestCase
{
    protected EntityManagerInterface $em;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->em = static::getContainer()->get('doctrine')->getManager();

        $schemaTool = new SchemaTool($this->em);
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool->createSchema($metadata);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $schemaTool = new SchemaTool($this->em);
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
    }

    protected function loadFixture(FixtureInterface $fixture): void
    {
        $fixtureLoader = new Loader();
        $fixtureLoader->addFixture($fixture);

        $executor = new ORMExecutor($this->em, new ORMPurger($this->em));
        $executor->execute($fixtureLoader->getFixtures());
    }
}

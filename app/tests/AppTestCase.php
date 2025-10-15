<?php
declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTestCase extends KernelTestCase
{
    protected EntityManagerInterface $manager;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = static::getContainer()->get('doctrine')->getManager();

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->manager);
        $metadata = $this->manager->getMetadataFactory()->getAllMetadata();

        $schemaTool->createSchema($metadata);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->manager);
        $metadata = $this->manager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
    }
}

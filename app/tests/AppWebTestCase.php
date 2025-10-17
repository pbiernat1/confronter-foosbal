<?php
declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Doctrine\ORM\EntityManagerInterface;

class AppWebTestCase extends WebTestCase
{
    use Fixtures;
    
    protected static KernelBrowser $client;

    protected EntityManagerInterface $manager;

    protected function setUp(): void
    {
        parent::setUp();
        self::$client = parent::createClient();

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

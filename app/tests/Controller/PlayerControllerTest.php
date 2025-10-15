<?php

namespace App\Tests\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PlayerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $playerRepository;
    private string $path = '/player/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->playerRepository = $this->manager->getRepository(Player::class);

        foreach ($this->playerRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testList(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Foosball match generator');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'player[first_name]' => 'Testing',
            'player[last_name]' => 'Testing',
            'player[ranking]' => 'Testing',
            'player[active]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->playerRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Player();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setRanking(1000);
        $fixture->setActive(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Foosball match generator');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Player();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setRanking(1000);
        $fixture->setActive(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'player[first_name]' => 'Something New',
            'player[last_name]' => 'Something New',
            'player[ranking]' => 'Something New',
            'player[active]' => 'Something New',
        ]);

        self::assertResponseRedirects('/player/');

        $fixture = $this->playerRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirst_name());
        self::assertSame('Something New', $fixture[0]->getLast_name());
        self::assertSame('Something New', $fixture[0]->getRanking());
        self::assertSame('Something New', $fixture[0]->getActive());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Player();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setRanking(1000);
        $fixture->setActive(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/player/');
        self::assertSame(0, $this->playerRepository->count([]));
    }
}

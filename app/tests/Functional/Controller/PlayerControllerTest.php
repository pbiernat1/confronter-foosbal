<?php

namespace App\Tests\Controller;

use App\Entity\Player;
use App\Infra\Interface\PlayerRepositoryInterface;
use App\Tests\AppWebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class PlayerControllerTest extends AppWebTestCase
{
    private PlayerRepositoryInterface $playerRepository;
    private string $path = '/';

    protected function setUp(): void
    {
        parent::setUp();

        $this->playerRepository = $this->manager->getRepository(Player::class);
    }

    public function testList(): void
    {
        $crawler = self::$client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        self::assertSame('Player List', $crawler->filter('h1')->first()->text());
    }

    public function testNew(): void
    {
        self::$client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        self::$client->submitForm('Save', [
            'player[first_name]' => 'Testing',
            'player[last_name]' => 'Testing',
            'player[ranking]' => 100,
            'player[active]' => true,
        ]);

        self::assertSame(1, count($this->playerRepository->findAllPlayers()));
    }

    public function testShow(): void
    {
        $fixture = new Player();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setRanking(1000);
        $fixture->setActive(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::$client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertPageTitleContains('Foosball match generator');
    }

    public function testEdit(): void
    {
        $fixture = new Player();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setRanking(1000);
        $fixture->setActive(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::$client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        self::$client->submitForm('Update', [
            'player[first_name]' => 'Something New',
            'player[last_name]' => 'Something New',
            'player[ranking]' => 203,
            'player[active]' => true,
        ]);

        $fixture = $this->playerRepository->findAllPlayers();

        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getLastName());
        self::assertSame(203, $fixture[0]->getRanking());
        self::assertSame(true, $fixture[0]->isActive());
    }

    public function testRemove(): void
    {
        $fixture = new Player();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setRanking(1000);
        $fixture->setActive(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::$client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        self::$client->submitForm('Delete');

        self::assertSame(0, count($this->playerRepository->findAllPlayers()));
    }
}

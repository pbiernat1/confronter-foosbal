<?php

namespace App\Tests\Controller;

use App\DataFixtures\PlayerPairCreatorTest\TestCreatedFourPairsPlayerPairGeneratorFixtures;
use App\DataFixtures\TournamentController\TestGenerateFixtures;
use App\Entity\Player;
use App\Infra\Interface\PlayerRepositoryInterface;
use App\Tests\AppWebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class TournamentControllerTest extends AppWebTestCase
{
    private PlayerRepositoryInterface $playerRepository;
    private string $path = '/generate';

    protected function setUp(): void
    {
        parent::setUp();

        /** @var $playerRepository PlayerRepositoryInterface */
        $this->playerRepository = $this->manager->getRepository(Player::class);
    }

    public function testIndex(): void
    {
        $this->loadFixture(new TestGenerateFixtures());

        $crawler = self::$client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        self::assertSame('Tournament Players', $crawler->filter('h1')->first()->text());
    }
}

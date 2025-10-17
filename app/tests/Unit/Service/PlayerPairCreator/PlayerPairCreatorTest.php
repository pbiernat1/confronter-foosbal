<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\PairCreator;

use App\DataFixtures\PlayerPairCreatorTest\TestCreatedFourPairsPlayerPairGeneratorFixtures;
use App\DataFixtures\PlayerPairCreatorTest\TestGetNotExistingPlayerPairFixtures;
use App\Service\PlayerPairCreator\PlayerPairCreator;
use App\Tests\AppTestCase;
use App\Entity\Player;

class PlayerPairCreatorTest extends AppTestCase
{
    public function testInsufficientNumberOfPlayers(): void
    {
        $players = [];

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Insufficient number of players');

        $playerPairCreator = new PlayerPairCreator();
        $playerPairCreator->generate($players);

    }
    
    public function testCreatedFourPairsPlayerPairGenerator(): void
    {
        $this->loadFixture(new TestCreatedFourPairsPlayerPairGeneratorFixtures());
        $players = $this->manager->getRepository(Player::class)->findAllPlayers();

        $playerPairCreator = new PlayerPairCreator();
        $playerPairCreator->generate($players);
        
        $this->assertSame(6, count($playerPairCreator->getAll()));
        $this->assertSame(210, $playerPairCreator->get(1)->getRanking());
        $this->assertSame(300, $playerPairCreator->get(2)->getRanking());
        $this->assertSame(320, $playerPairCreator->get(3)->getRanking());
        $this->assertSame(310, $playerPairCreator->get(4)->getRanking());
    }

    public function testGetNotExistingPlayerPair(): void
    {
        $this->loadFixture(new TestGetNotExistingPlayerPairFixtures());
        $players = $this->manager->getRepository(Player::class)->findAllPlayers();

        $playerPairCreator = new PlayerPairCreator();
        $playerPairCreator->generate($players);

        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Invalid $key number');

        $playerPairCreator->get(key: 10);
    }
}

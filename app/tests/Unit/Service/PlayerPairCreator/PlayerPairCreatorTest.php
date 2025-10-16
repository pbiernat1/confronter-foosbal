<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\PairCreator;

use App\Service\PlayerPairCreator\PlayerPairCreator;
use App\Tests\AppTestCase;
use App\Entity\Player;

class PlayerPairCreatorTest extends AppTestCase
{
    public function testInsufficientNumberOfPlayers(): void
    {
        $players = [
            (new Player())->setRanking(100),
            (new Player())->setRanking(110),
        ];

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Insufficient number of players');

        $playerPairCreator = new PlayerPairCreator();
        $playerPairCreator->generate($players);

    }
    
    public function testCreatedFourPairsPlayerPairGenerator(): void
    {
        $players = [
            (new Player())->setRanking(100),
            (new Player())->setRanking(110),
            (new Player())->setRanking(200),
            (new Player())->setRanking(220),
        ];
        
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
        $players = [
            (new Player())->setRanking(100),
            (new Player())->setRanking(200),
            (new Player())->setRanking(300),
            (new Player())->setRanking(400),
        ];

        $playerPairCreator = new PlayerPairCreator();
        $playerPairCreator->generate($players);

        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Invalid $key number');

        $playerPairCreator->get(key: 10);
    }
}

<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\PairCreator;

use App\Service\PlayerPairCreator\PlayerPairCreator;
use App\Tests\AppTestCase;
use App\Entity\Player;
use OutOfBoundsException;

class PlayerPairCreatorTest extends AppTestCase
{

    public function testCreatedOnePairPlayerPairGenerator(): void
    {
        $players = [
            (new Player())->setRanking(100),
            (new Player())->setRanking(110),
        ];

        $playerPlayerPairCreator = new PlayerPairCreator($players);
        $pairs = $playerPlayerPairCreator->getAll();

        $this->assertSame(1, count($pairs));
        $this->assertSame(210, $pairs[0]['sumRanking']);
    }

    
    public function testCreatedThreePairsPlayerPairGenerator(): void
    {
        $players = [
            (new Player())->setRanking(100),
            (new Player())->setRanking(110),
            (new Player())->setRanking(200),
        ];
        
        $playerPairCreator = new PlayerPairCreator($players);
        $pairs = $playerPairCreator->getAll();
        
        $this->assertSame(3, count($pairs));
        $this->assertSame(210, $pairs[0]['sumRanking']);
        $this->assertSame(300, $pairs[1]['sumRanking']);
        $this->assertSame(310, $pairs[2]['sumRanking']);
    }

    public function testGetNotExistingPlayerPair(): void
    {
        $players = [
            (new Player())->setRanking(100),
            (new Player())->setRanking(110),
        ];

        $playerPairCreator = new PlayerPairCreator($players);

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Invalid $key number');

        $playerPairCreator->get(2);
    }
}

<?php

namespace App\Tests\Unit\Service\TournamentCreator\Strategy;

use App\DTO\Player;
use App\Service\TournamentCreator\Strategy\MaxRankingDiffStrategy;
use App\Service\TournamentCreator\TournamentCreator;
use App\ValueObject\PlayerPair;
use App\Tests\AppTestCase;

class MaxRankingDiffStrategyTest extends AppTestCase
{
    public function testFailMaxRankingDiffStrategy(): void
    {
        $pairs = [
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(1)->setRanking(100),
                    (new Player())->setId(2)->setRanking(110),
                ],
                'sumRanking' => 210
            ]),
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(3)->setRanking(100),
                    (new Player())->setId(4)->setRanking(400),
                ],
                'sumRanking' => 500
            ])
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unable to generate data!');

        $t = new TournamentCreator(new MaxRankingDiffStrategy(20));
        $t->createTournamentMatches($pairs);
    }

    public function testSuccessMaxRankingDiffStrategy(): void
    {
        $pairs = [
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(1)->setRanking(100),
                    (new Player())->setId(2)->setRanking(200),
                ],
                'sumRanking' => 300
            ]),
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(3)->setRanking(100),
                    (new Player())->setId(4)->setRanking(210),
                ],
                'sumRanking' => 310
            ])
        ];

        $t = new TournamentCreator(new MaxRankingDiffStrategy(20));
        $t->createTournamentMatches($pairs);

        $this->assertSame(1, count($t->getAllMatches()));
    }
}

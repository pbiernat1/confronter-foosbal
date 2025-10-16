<?php

namespace App\Tests\Unit\Service\TournamentCreator\Strategy;

use App\DTO\Player;
use App\Service\TournamentCreator\Strategy\ExactRankingDiffStrategy;
use App\Service\TournamentCreator\TournamentCreator;
use App\ValueObject\PlayerPair;
use App\Tests\AppTestCase;

class ExactRankingDiffStrategyTest extends AppTestCase
{
    public function testFailExactRankingDiffStrategy(): void
    {
        $pairs = [
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(1)->setRanking(100),
                    (new Player())->setId(2)->setRanking(300),
                ],
                'sumRanking' => 400
            ]),
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(3)->setRanking(100),
                    (new Player())->setId(4)->setRanking(350),
                ],
                'sumRanking' => 350
            ])
        ];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to generate data!');

        $t = new TournamentCreator(new ExactRankingDiffStrategy(20));
        $t->createTournamentMatches($pairs);
    }

    public function testDuplicatedPlayerExactRankingDiffStrategy(): void
    {
        $pairs = [
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(1)->setRanking(100),
                    (new Player())->setId(2)->setRanking(300),
                ],
                'sumRanking' => 400
            ]),
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(1)->setRanking(100),
                    (new Player())->setId(3)->setRanking(350),
                ],
                'sumRanking' => 350
            ])
        ];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to generate data!');

        $t = new TournamentCreator(new ExactRankingDiffStrategy(20));
        $t->createTournamentMatches($pairs);
    }

    public function testSuccessExactRankingDiffStrategy(): void
    {
        $pairs = [
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(1)->setRanking(80),
                    (new Player())->setId(2)->setRanking(120),
                ],
                'sumRanking' => 200
            ]),
            PlayerPair::fromArray([
                'players' => [
                    (new Player())->setId(3)->setRanking(110),
                    (new Player())->setId(4)->setRanking(130),
                ],
                'sumRanking' => 240
            ])
        ];

        $t = new TournamentCreator(new ExactRankingDiffStrategy(20));
        $t->createTournamentMatches($pairs);

        $this->assertSame(1, count($t->getAllMatches()));
    }
}

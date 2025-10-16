<?php
declare(strict_types=1);

namespace App\ValueObject;

class TournamentPair
{
    public function __construct(
        private array $teamA, private array $teamB, 
        private int $rankingA, private int $rankingB
    )
    {
    }

    public static function fromArray(array $arr): TournamentPair
    {
        return new TournamentPair(
            $arr['teamA'], $arr['teamB'],
            $arr['rankingSumA'], $arr['rankingSumB']
        );
    }

    public function getTeamA(): array
    {
        return $this->teamA;
    }

    public function getTeamB(): array
    {
        return $this->teamB;
    }

    public function getRankingA(): int
    {
        return $this->rankingA;
    }

    public function getRankingB(): int
    {
        return $this->rankingB;
    }

    public function getDifference(): int
    {
        return $this->getRankingA() - $this->getRankingB();
    }
}

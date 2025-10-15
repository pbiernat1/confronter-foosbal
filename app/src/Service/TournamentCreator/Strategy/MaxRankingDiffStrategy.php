<?php
declare(strict_types=1);

namespace App\Service\TournamentCreator\Strategy;

class MaxRankingDiffStrategy implements StrategyInterface
{
    /**
     * @param int $maxPercentageDiff Number between 0 and 100
     */
    public function __construct(private int $maxPercentageDiff)
    {
        if ($maxPercentageDiff < 0) {
            throw new \OutOfBoundsException('Value cant be lower than 0');
        }

        if ($maxPercentageDiff > 100) {
            throw new \OutOfBoundsException('Value cant be greater than 100');
        }
    }

    public function createTournamentPairs(array $pairs): array
    {
        $matches = [];
        $pairCount = count($pairs);
        for ($i = 0; $i < $pairCount - 1; $i++) {
            for ($j = $i + 1; $j < $pairCount; $j++) {
                $teamA = $pairs[$i];
                $teamB = $pairs[$j];

                $diff = max($teamA->getRanking(), $teamB->getRanking()) / min($teamA->getRanking(), $teamB->getRanking());

                $maxDiff = ($this->maxPercentageDiff+100) / 100;
                if ($diff <= $maxDiff) {
                    $matches[] = [
                        'teamA' => $teamA->getPlayers(),
                        'teamB' => $teamB->getPlayers(),
                        'ratingSumA' => $teamA->getRanking(),
                        'ratingSumB' => $teamB->getRanking()
                    ];
                }
            }
        }

        return $matches;
    }
}

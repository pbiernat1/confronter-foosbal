<?php
declare(strict_types=1);

namespace App\Service\TournamentCreator\Strategy;

use App\ValueObject\TournamentPair;

class ExactRankingDiffStrategy implements StrategyInterface
{
    /**
     * @param int $exactPercentageDiff Number between 0 and 100
     */
    public function __construct(private int $exactPercentageDiff)
    {
        if ($exactPercentageDiff < 0) {
            throw new \OutOfBoundsException('Value cant be lower than 0');
        }

        if ($exactPercentageDiff > 100) {
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

                $idsA = array_map(fn($p) => $p->getId(), $teamA->getPlayers());
                $idsB = array_map(fn($p) => $p->getId(), $teamB->getPlayers());

                if (count(array_intersect($idsA, $idsB)) != 0) {
                    continue;
                }

                $diff = max($teamA->getRanking(), $teamB->getRanking()) / min($teamA->getRanking(), $teamB->getRanking());

                $exactDiff = ($this->exactPercentageDiff+100) / 100;
                if ($diff == $exactDiff) {
                    $matches[] = TournamentPair::fromArray([
                        'teamA' => $teamA->getPlayers(),
                        'teamB' => $teamB->getPlayers(),
                        'rankingSumA' => $teamA->getRanking(),
                        'rankingSumB' => $teamB->getRanking(),
                    ]);
                }
            }
        }

        return $matches;
    }
}

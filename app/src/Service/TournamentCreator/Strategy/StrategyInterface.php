<?php
declare(strict_types=1);

namespace App\Service\TournamentCreator\Strategy;

interface StrategyInterface
{
    public function createTournamentPairs(array $pairs): array;
}

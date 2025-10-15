<?php
declare(strict_types=1);

namespace App\Service\TournamentCreator;

use App\Service\TournamentCreator\Strategy\StrategyInterface;

class TournamentCreator
{
    private array $matches = [];

    public function __construct(private StrategyInterface $strategy)
    {
    }

    public function createTournamentMatches(array $pairs): void
    {
        $this->matches = $this->strategy->createTournamentPairs($pairs);

        if (count($this->matches) == 0) {
            throw new \Exception('Unable to generate data!');
        }
    }

    public function getAllMatches(): array
    {
        return $this->matches;
    }

    public function getRandomMatch(): ?array
    {
        $index = array_rand($this->matches);

        return $this->matches[$index];
    }
}

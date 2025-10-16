<?php
declare(strict_types=1);

namespace App\Service\TournamentCreator;

use App\Service\TournamentCreator\Strategy\StrategyInterface;
use App\ValueObject\TournamentPair;

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
            throw new \RuntimeException('Unable to generate data!');
        }
    }

    /**
     * @return array[TournamentPair]
     */
    public function getAllMatches(): array
    {
        return $this->matches;
    }

    public function getRandomMatch(): TournamentPair
    {
        $index = array_rand($this->matches);

        return $this->matches[$index];
    }
}

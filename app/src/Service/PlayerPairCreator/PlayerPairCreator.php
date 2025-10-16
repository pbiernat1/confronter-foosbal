<?php
declare(strict_types=1);

namespace App\Service\PlayerPairCreator;

use App\Entity\Player;
use App\ValueObject\PlayerPair;

class PlayerPairCreator
{
    private array $pairs = [];

    public function generate(array $players): void
    {
        $this->pairs = $this->createPairs($players);
    }

    public function getAll(): array
    {
        return $this->pairs;
    }

    public function get(int $key): PlayerPair
    {
        $key -= 1; # more human readable: $key:1 == index:0
        if (!isset($this->pairs[$key])) {
            throw new \OutOfBoundsException('Invalid $key number');
        }

        return $this->pairs[$key];
    }

    /**
     * @param array[Player] $players
     * @return array
     */
    private function createPairs(array $players): array
    {
        $pairs = [];
        $count = count($players);

        if ($count < 4) {
            throw new \DomainException('Insufficient number of players');
        }

        for ($i = 0; $i < $count - 1; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $pair = [
                    $players[$i],
                    $players[$j]
                ];

                $sumRanking = $pair[0]->getRanking() + $pair[1]->getRanking();
                $pairs[] = PlayerPair::fromArray([
                    'players' => $pair,
                    'sumRanking' => $sumRanking
                ]);
            }
        }

        return $pairs;
    }
}

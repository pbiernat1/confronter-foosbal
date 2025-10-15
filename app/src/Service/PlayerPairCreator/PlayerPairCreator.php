<?php
declare(strict_types=1);

namespace App\Service\PlayerPairCreator;

use App\Entity\Player;

class PlayerPairCreator
{
    private array $pairs = [];

    /**
     * @param array[Player] $players
     */
    public function __construct(array $players)
    {
        $this->pairs = $this->createPairs($players);
    }

    public function getAll(): array
    {
        return $this->pairs;
    }

    public function get(int $key): array
    {
        $key -= 1; # for more human readabnle $key:1 == index:0
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
        for ($i = 0; $i < $count - 1; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $pair = [
                    $players[$i],
                    $players[$j]
                ];
                $sumRanking = $pair[0]->getRanking() + $pair[1]->getRanking();
                $pairs[] = [
                    'players' => $pair,
                    'sumRanking' => $sumRanking
                ];
            }
        }

        return $pairs;
    }
}

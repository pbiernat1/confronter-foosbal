<?php
declare(strict_types=1);

namespace App\ValueObject;

class PlayerPair
{
    public function __construct(private array $players, private int $ranking)
    {
    }

    public static function fromArray(array $arr): PlayerPair
    {
        return new PlayerPair($arr['players'], $arr['sumRanking']);
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getRanking(): int
    {
        return $this->ranking;
    }
}
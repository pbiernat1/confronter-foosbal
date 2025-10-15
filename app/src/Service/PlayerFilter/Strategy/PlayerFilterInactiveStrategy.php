<?php
declare(strict_types=1);

namespace App\Service\PlayerFilter\Strategy;

use App\Entity\Player;

class PlayerFilterInactiveStrategy implements StrategyInterface
{
    /**
     * @param array[Player] $players 
     * @return Player[Player]
     */
    public function filter(array $players): array
    {
        return array_filter(
            $players, 
            callback: fn(Player $playerEntity) => !$playerEntity->isActive()
        );
    }
}

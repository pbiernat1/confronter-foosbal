<?php
declare(strict_types=1);

namespace App\Service\PlayerFilter\Strategy;

use App\Entity\Player;

interface StrategyInterface
{
    /**
     * 
     * @param array[Player] $players
     * @return array[Player]
     */
    public function filter(array $players): array;
}

<?php
declare(strict_types=1);

namespace App\Service\PlayerFilter;

use App\Service\PlayerFilter\Strategy\StrategyInterface;
use App\Entity\Player;

class PlayerFilter
{
    public function __construct(private StrategyInterface $strategy)
    {
    }

    /**
     * @param array[Player]
     * @return array[Player]
     */
    public function filter(array $players): array
    {
        return $this->strategy->filter($players);
    }
}

<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\PlayerFilter;

use App\Service\PlayerFilter\PlayerFilter;
use App\Service\PlayerFilter\Strategy\PlayerFilterActiveStrategy;
use App\Service\PlayerFilter\Strategy\PlayerFilterInactiveStrategy;
use App\Tests\AppTestCase;
use App\Entity\Player;

class PlayerFilterTest extends AppTestCase
{
    public function testSuccessFilterWithActiveStrategy()
    {
        $players = [
            (new Player())->setActive(false),
            (new Player())->setActive(false),
            (new Player())->setActive(true),
            (new Player())->setActive(true),
        ];
        $filter = new PlayerFilter(new PlayerFilterActiveStrategy());
        $filteredPlayers = $filter->filter($players);

        $this->assertEquals(2, count($filteredPlayers));
    }

    public function testSuccessFilterWithInactiveStrategy()
    {
        $players = [
            (new Player())->setActive(false),
            (new Player())->setActive(false),
            (new Player())->setActive(false),
            (new Player())->setActive(true),
        ];
        $filter = new PlayerFilter(new PlayerFilterInactiveStrategy());
        $filteredPlayers = $filter->filter($players);

        $this->assertEquals(3, count($filteredPlayers));
    }
}

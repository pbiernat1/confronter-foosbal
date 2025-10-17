<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\PlayerFilter;

use App\DataFixtures\PlayerFilterTest\TestSuccessFilterWithActiveStrategyFixtures;
use App\DataFixtures\PlayerFilterTest\TestSuccessFilterWithInactiveStrategyFixtures;
use App\Service\PlayerFilter\PlayerFilter;
use App\Service\PlayerFilter\Strategy\PlayerFilterActiveStrategy;
use App\Service\PlayerFilter\Strategy\PlayerFilterInactiveStrategy;
use App\Tests\AppTestCase;
use App\Entity\Player;

class PlayerFilterTest extends AppTestCase
{
    public function testSuccessFilterWithActiveStrategy()
    {
        $this->loadFixture(new TestSuccessFilterWithActiveStrategyFixtures());
        $players = $this->manager->getRepository(Player::class)->findAllPlayers();

        $filter = new PlayerFilter(new PlayerFilterActiveStrategy());
        $filteredPlayers = $filter->filter($players);

        $this->assertSame(2, count($filteredPlayers));
    }

    public function testSuccessFilterWithInactiveStrategy()
    {
        $this->loadFixture(new TestSuccessFilterWithInactiveStrategyFixtures());
        $players = $this->manager->getRepository(Player::class)->findAllPlayers();

        $filter = new PlayerFilter(new PlayerFilterInactiveStrategy());
        $filteredPlayers = $filter->filter($players);

        $this->assertSame(3, count($filteredPlayers));
    }
}

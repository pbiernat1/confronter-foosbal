<?php
declare(strict_types=1);

namespace App\Infra\Interface;

use App\Entity\Player;

interface PlayerRepositoryInterface
{
    public function findAllPlayers(): array;

    public function findActivePlayers(): array;

    public function findInactivePlayers(): array;

    public function findPlayer(int $id): Player;

    public function save(Player $player, bool $flush = true): void;

    public function delete(Player $player, bool $flush = true): void;
}

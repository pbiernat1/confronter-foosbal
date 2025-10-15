<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Player;
use App\Infra\Interface\PlayerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 * @implements PlayerRepositoryInterface
 */
class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * Find all players
     * @return Player[]
     */
    public function findAllPlayers(): array
    {

        return $this->findAll();
    }

    /**
     * Find all active players
     * @return Player[]
     */
    public function findActivePlayers(): array
    {

        return $this->findBy(['active' => true]);
    }

    /**
     * Find all inactive players
     * @return Player[]
     */
    public function findInactivePlayers(): array
    {

        return $this->findBy(['active' => false]);
    }

    /**
     * Find player by id
     * @param int $id
     * @return Player
     */
    public function findPlayer(int $id): Player
    {
        return $this->find($id);
    }
}

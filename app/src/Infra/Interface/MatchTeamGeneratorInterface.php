<?php
declare(strict_types=1);

namespace App\Infra\Interface;

interface MatchTeamGeneratorInterface
{
    public function generate(): array;
}

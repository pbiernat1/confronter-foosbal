<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infra\Interface\PlayerRepositoryInterface;
use App\Service\PlayerFilter\PlayerFilter;
use App\Service\PlayerPairCreator\PlayerPairCreator;
use App\Service\TournamentCreator\TournamentCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TournamentController extends AbstractController
{
    #[Route('/generate', name: 'tournament_generate', methods: ['GET'])]
    public function generate(
        Request $request, 
        PlayerRepositoryInterface $repo,
        PlayerFilter $filter,
        PlayerPairCreator $pairCreator,
        TournamentCreator $tournament
    ): Response
    {
        try {
            $players = $repo->findAllPlayers();
            $players = $filter->filter($players);
            $pairCreator->generate($players);
            $pairs = $pairCreator->getAll();
            $tournament->createTournamentMatches($pairs);
            $tournamentPairs = $tournament->getRandomMatch();
        }
        catch(\Exception $e) {
            return $this->render(
                'messages/error.html.twig',
                ['message' => 'No players found who can participate in the tournament.']
            );
        }

        return $this->render('tournament/index.html.twig', [
            'tournamentPairs' => $tournamentPairs,
        ]);
    }
}

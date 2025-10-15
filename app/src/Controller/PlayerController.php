<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Infra\Interface\PlayerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class PlayerController extends AbstractController
{
    const FILTER_ALL = 'all';
    const FILTER_ACTIVE = 'active';
    const FILTER_INACTIVE = 'inactive';

    #[Route(name: 'player_list', methods: ['GET'])]
    public function list(Request $request, PlayerRepositoryInterface $repo): Response
    {
        $filter = $request->query->get('filter');
        $players = match ($filter) {
            'all' => $repo->findAllPlayers(),
            'active' => $repo->findActivePlayers(),
            'inactive' => $repo->findInactivePlayers(),
        };

        return $this->render('player/list.html.twig', [
            'players' => $players,
            'filter' => $filter,
        ]);
    }

    // FIXME: EntityManagerInterface is tightly coupled
    #[Route('/new', name: 'player_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('player_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('player/new.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'player_show', methods: ['GET'])]
    public function show(PlayerRepositoryInterface $repo, int $id): Response
    {
        $player = $repo->findPlayer($id);
        if ($player == null) {
            return $this->render('messages/error.html.twig', ['message' => 'Player not found']);
        }

        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }

    // FIXME: EntityManagerInterface is tightly coupled
    #[Route('/{id}/edit', name: 'player_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        PlayerRepositoryInterface $repo,
        int $id
    ): Response
    {
        $player = $repo->findPlayer($id);
        if ($player == null) {
            return $this->render('messages/error.html.twig', ['message' => 'Player not found']);
        }

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('player_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('player/edit.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    // FIXME: EntityManagerInterface is tightly coplued
    #[Route('/{id}', name: 'player_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        EntityManagerInterface $em,
        PlayerRepositoryInterface $repo,
        int $id
    ): Response
    {
        // $repo = $em->getRepository(Player::class);
        $player = $repo->findPlayer($id);
        if ($player == null) {
            return $this->render('messages/error.html.twig', ['message' => 'Player not found']);
        }
        
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($player);
            $em->flush();
        }

        return $this->redirectToRoute('player_list', [], Response::HTTP_SEE_OTHER);
    }
}

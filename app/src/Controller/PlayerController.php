<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class PlayerController extends AbstractController
{
    #[Route(name: 'player_list', methods: ['GET'])]
    public function list(PlayerRepository $repo): Response
    {
        return $this->render('player/list.html.twig', [
            'players' => $repo->findAll(),
        ]);
    }

    // FIXME: EntityManagerInterface is tightly coplued
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
    public function show(PlayerRepository $repo, int $id): Response
    {
        $player = $repo->find($id);
        if ($player == null) {
            return $this->render('messages/error.html.twig', ['message' => 'Player not found']);
        }

        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }

    // FIXME: EntityManagerInterface is tightly coplued
    #[Route('/{id}/edit', name: 'player_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $repo = $em->getRepository(Player::class);
        $player = $repo->find($id);
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
    public function delete(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $repo = $em->getRepository(Player::class);
        $player = $repo->find($id);
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

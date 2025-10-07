<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlayerRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlayerRepository $playerRepo, ReviewRepository $reviewRepo, CategorieRepository $catRepo): Response
    {
        $players = $playerRepo->findAll();
        $reviews = $reviewRepo->findAll();
        $categories = $catRepo->findAll();

        // Calculer la note moyenne pour chaque joueur
        $averages = [];
        foreach ($players as $player) {
            $notes = [];
            foreach ($player->getReviews() as $review) {
                $notes[] = $review->getRating();
            }
            $averages[$player->getId()] = count($notes) > 0 ? array_sum($notes) / count($notes) : null;
        }


        return $this->render('home/index.html.twig', [
            'players' => $players,
            'averages' => $averages,
            'reviews' => $reviews,
            'categories' => $categories,
        ]);
    }
}
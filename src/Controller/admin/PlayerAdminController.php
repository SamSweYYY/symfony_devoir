<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlayerAdminController extends AbstractController
{
    #[Route('/player/admin', name: 'app_player_admin')]
    public function index(): Response
    {
        return $this->render('player_admin/index.html.twig', [
            'controller_name' => 'PlayerAdminController',
        ]);
    }
}

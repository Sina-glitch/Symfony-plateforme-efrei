<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    
}

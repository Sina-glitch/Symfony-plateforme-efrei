<?php

namespace App\Controller;

use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'projet_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $projets = $em->getRepository(Projet::class)->findAll();

        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/ajouter', name: 'projet_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $projet = new Projet();
            $projet->setTitre($request->request->get('titre'));
            $projet->setDescription($request->request->get('description'));

            $em->persist($projet);
            $em->flush();

            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/ajouter.html.twig');
    }
}

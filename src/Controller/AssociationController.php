<?php

namespace App\Controller;

use App\Entity\Association;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends AbstractController
{
    #[Route('/associations', name: 'association_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $associations = $em->getRepository(Association::class)->findAll();

        return $this->render('association/index.html.twig', [
            'associations' => $associations,
        ]);
    }

    #[Route('/association/{id<\\d+>}', name: 'association_show')]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $association = $em->getRepository(Association::class)->find($id);

        if (!$association) {
            throw $this->createNotFoundException('Association introuvable.');
        }

        return $this->render('association/show.html.twig', [
            'association' => $association,
        ]);
    }

    #[Route('/association/ajouter', name: 'association_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $association = new Association();
            $association->setNom($request->request->get('nom'));
            $association->setDescription($request->request->get('description'));

            $em->persist($association);
            $em->flush();

            return $this->redirectToRoute('association_index');
        }

        return $this->render('association/ajouter.html.twig');
    }

    #[Route('/association/{id}/modifier', name: 'association_modifier')]
    public function modifier(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user || !in_array('ROLE_ASSOCIATION', $user->getRoles())) {
            throw $this->createAccessDeniedException('Vous n\'avez pas les autorisations nécessaires pour modifier cette association.');
        }

        $association = $em->getRepository(Association::class)->find($id);

        if (!$association) {
            throw $this->createNotFoundException('Association introuvable.');
        }

        if ($request->isMethod('POST')) {
            $association->setNom($request->request->get('nom'));
            $association->setDescription($request->request->get('description'));

            $em->flush();

            $this->addFlash('success', 'L\'association a été modifiée avec succès.');

            return $this->redirectToRoute('association_index');
        }

        return $this->render('association/modifier.html.twig', [
            'association' => $association,
        ]);
    }
}

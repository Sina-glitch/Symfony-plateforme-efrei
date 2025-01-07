<?php

namespace App\Controller;

use App\Entity\Benevole;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/benevole')]
class BenevoleController extends AbstractController
{
    #[Route('/', name: 'benevole_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $benevoles = $em->getRepository(Benevole::class)->findAll();

        return $this->render('benevole/index.html.twig', [
            'benevoles' => $benevoles,
        ]);
    }

    #[Route('/ajouter', name: 'benevole_ajouter')]
public function ajouter(Request $request, EntityManagerInterface $em): Response
{
    if ($request->isMethod('POST')) {
        $benevole = new Benevole();
        $benevole->setNom($request->request->get('nom'));
        $benevole->setPrenom($request->request->get('prenom'));
        $benevole->setEmail($request->request->get('email'));

        $em->persist($benevole);
        $em->flush();

        return $this->redirectToRoute('benevole_index');
    }

    return $this->render('benevole/ajouter.html.twig');
}

}

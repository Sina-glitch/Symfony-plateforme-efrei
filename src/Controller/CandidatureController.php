<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    #[Route('/candidatures', name: 'candidature_index')]
    public function index(EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $candidatures = $em->getRepository(Candidature::class)->findBy(['benevole' => $user]);

        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }

    #[Route('/candidature/{offreId}/nouveau', name: 'candidature_new')]
    public function new(EntityManagerInterface $em, $offreId, Request $request)
    {
        $offre = $em->getRepository(Offre::class)->find($offreId);

        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée.');
        }

        $candidature = new Candidature();
        $candidature->setOffre($offre);
        $candidature->setBenevole($this->getUser());

        $em->persist($candidature);
        $em->flush();

        return $this->redirectToRoute('candidature_index');
    }
}

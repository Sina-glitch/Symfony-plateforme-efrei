<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Association;
use App\Entity\Offre;
use App\Entity\User;
use App\Entity\Candidature;



class OffreController extends AbstractController
{
    #[Route('/offre', name: 'offre_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $offres = $em->getRepository(Offre::class)->findAll();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/offre/{id}', name: 'offre_show', requirements: ['id' => '\d+'])]
public function show(int $id, EntityManagerInterface $em): Response
{
    $offre = $em->getRepository(Offre::class)->find($id);

    if (!$offre) {
        throw $this->createNotFoundException('L\'offre demandée n\'existe pas.');
    }

    return $this->render('offre/show.html.twig', [
        'offre' => $offre,
    ]);
}


#[Route('/offre/ajouter', name: 'offre_ajouter')]
public function ajouter(Request $request, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    if (!$user || !in_array('ROLE_ASSOCIATION', $user->getRoles())) {
        throw $this->createAccessDeniedException('Seules les associations peuvent ajouter des offres.');
    }

    if ($request->isMethod('POST')) {
        $offre = new Offre();
        $offre->setTitre($request->request->get('titre'));
        $offre->setDescription($request->request->get('description'));
        $offre->setLieu($request->request->get('lieu'));
        $offre->setDateDebut(new \DateTime($request->request->get('date_debut')));
        $offre->setAssociation($user);

        $em->persist($offre);
        $em->flush();

        $this->addFlash('success', 'Offre ajoutée avec succès !');

        return $this->redirectToRoute('offre_index');
    }

    return $this->render('offre/ajouter.html.twig');
}



#[Route('/offre/{id}/postuler', name: 'offre_postuler')]
public function postuler(int $id, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    if (!$user || !in_array('ROLE_BENEVOLE', $user->getRoles())) {
        throw $this->createAccessDeniedException('Seuls les bénévoles peuvent postuler à une offre.');
    }

    $offre = $em->getRepository(Offre::class)->find($id);

    if (!$offre) {
        throw $this->createNotFoundException('L\'offre demandée n\'existe pas.');
    }

    $candidature = new Candidature();
    $candidature->setBenevole($user);
    $candidature->setOffre($offre);
    $candidature->setStatut('En attente');

    $em->persist($candidature);
    $em->flush();

    $this->addFlash('success', 'Votre candidature a été envoyée avec succès !');

    return $this->redirectToRoute('offre_index');
}


#[Route('/offre/{id}/supprimer', name: 'offre_supprimer', requirements: ['id' => '\\d+'])]
public function supprimer(int $id, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    if (!$user || !in_array('ROLE_ASSOCIATION', $user->getRoles())) {
        throw $this->createAccessDeniedException('Seules les associations peuvent supprimer des offres.');
    }

    $offre = $em->getRepository(Offre::class)->find($id);

    if (!$offre) {
        throw $this->createNotFoundException('L\'offre demandée n\'existe pas.');
    }

    if ($offre->getAssociation() !== $user) {
        throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres offres.');
    }

    $candidatures = $em->getRepository(Candidature::class)->findBy(['offre' => $offre]);
    foreach ($candidatures as $candidature) {
        $em->remove($candidature);
    }

    $em->remove($offre);
    $em->flush();

    $this->addFlash('success', 'L\'offre a été supprimée avec succès.');

    return $this->redirectToRoute('offre_index');
}



}

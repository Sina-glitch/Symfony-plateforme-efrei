<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/update', name: 'profil_update', methods: ['POST'])]
    public function updateEmail(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // Vérifie que l'utilisateur est bien une instance de User
        if (!$user instanceof \App\Entity\User) {
            return $this->redirectToRoute('app_login');
        }

        $newEmail = $request->request->get('email');

        if ($newEmail) {
            $user->setEmail($newEmail);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre adresse e-mail a été mise à jour avec succès.');
        }

        return $this->redirectToRoute('profil');
    }
}

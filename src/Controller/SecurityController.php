<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route('/register', name: 'app_register')]
public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
{
    if ($request->isMethod('POST')) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $role = $request->request->get('role');

        if ($email && $password && $role) {
            $user = new User();
            $user->setEmail($email);

            
            $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($existingUser) {
                $this->addFlash('error', 'Un compte avec cet email existe déjà.');
                return $this->redirectToRoute('app_register');
            }

            if ($role === 'association') {
                $user->setRoles(['ROLE_ASSOCIATION']);
            } elseif ($role === 'benevole') {
                $user->setRoles(['ROLE_BENEVOLE']);
            }

            $user->setPassword($passwordHasher->hashPassword($user, $password));

            $em->persist($user);

            try {
                $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de la création de votre compte.');
                return $this->redirectToRoute('app_register');
            }

            $this->addFlash('success', 'Votre compte a été créé avec succès.');
            return $this->redirectToRoute('home');
        }
    }

    return $this->render('security/register.html.twig');
}



}

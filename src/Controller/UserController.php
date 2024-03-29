<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * This method enables to update one's profile
     * 
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    #[Route('/utilisateur/modification/{id}', name: 'app_user_update', methods: ['GET', 'POST'])]
    public function update(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_security_logIn');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_recipes_index');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Vos informations ont été modifiées avec succès!"
                );

                return $this->redirectToRoute('app_recipes_index');
            } else {
                $this->addFlash(
                    'danger',
                    "Le mot de passe renseigné est incorrect"
                );
            }
        }

        return $this->render('pages/user/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * This method enables to update one's password
     * 
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    #[Route('/utilisateur/modification-du-mot-de-passe/{id}', name: 'app_user_passwordUpdate', methods: ['GET', 'POST'])]
    public function updatePassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_security_logIn');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_recipes_index');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setUpdatedAt(new DateTimeImmutable());
                $user->setPlainPassword($form->getData()['newPassword']);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a été modifié avec succès!"
                );

                return $this->redirectToRoute('app_recipes_index');
            } else {
                $this->addFlash(
                    'danger',
                    "Le mot de passe renseigné est incorrect"
                );
            }
        }

        return $this->render('pages/user/updatePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

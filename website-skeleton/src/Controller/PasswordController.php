<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\PwdType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/password")
 */
class PasswordController extends AbstractController
{
    /**
     * @Route("/{id}/edit", name="password_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user) : Response
    {

        $form = $this->createForm(PwdType::class, $user);
        $form->handleRequest($request);

        $hash = $user -> getPassword();

        var_dump($hash, $_POST);
        

        if (($form->isSubmitted()) && ($form->isValid()) && ($_POST["pwd"]["newPassword"] == $_POST["pwd"]["newPasswordConfirm"])  && ($_POST["pwd"]["password"] == $hash)) {
            $user -> setPassword(password_hash($_POST["pwd"]["newPassword"],PASSWORD_DEFAULT));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        } 

        return $this->render('password/edit.html.twig', [
            'page_title' => 'Edit Password',
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }
}
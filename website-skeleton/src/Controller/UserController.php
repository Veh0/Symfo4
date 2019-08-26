<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\PasswordType;
use App\Repository\UserRepository;
use App\Repository\ActuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET", "POST"})
     */
    public function index(UserRepository $userRepository): Response
    {

        // var_dump ($_POST["toRole"]);
        // die;

        

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'page_title' => 'User'
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET", "POST"})
     */
    public function show(User $user, Request $r): Response
    {

        

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'page_title' => 'User'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/edit.html.twig', [
            'page_title' => 'Edit Profile',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }


    /**
     * @Route("/{id}/user/role", name="user_role", methods={"GET","POST"})
     */
    public function toRole(Request $request, User $user): Response
    {
        if ($_POST["toRole"] == "toUser") {
            // echo "yo";
            // die;
            $user ->setRoles("ROLE_USER");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        } else if ($_POST["toRole"] == "toAdmin") {
            // echo "yoyo";
            // die;
            $user ->setRoles("ROLE_ADMIN");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        } 

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/edit/password", name="user_edit_password", methods={"GET","POST"})
     */
    public function editPassword(Request $request, User $user)
    {
        $form = $this->createForm(PasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/edit.html.twig', [
            'page_title' => 'Edit Profile',
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/sub", name="user_sub", methods={"GET","POST"})
     */
    public function userActu(Request $request, User $user,ActuRepository $actu) {
        $user_id = $user -> getId();


        return $this->render('user/sub.html.twig', [
            'page_title' => 'Sub Actualities',
            'actus' => $user -> getActus(),
        ]);
    }
}

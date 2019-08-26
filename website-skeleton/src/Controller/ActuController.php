<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\ActuType;
use App\Repository\ActuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/actu")
 */
class ActuController extends AbstractController
{
    /**
     * @Route("/", name="actu_index", methods={"GET"})
     */
    public function index(ActuRepository $actuRepository): Response
    {
        return $this->render('actu/index.html.twig', [
            'page_title' => 'Actuality',
            'actus' => $actuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="actu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actu = new Actu();
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actu);
            $entityManager->flush();

            return $this->redirectToRoute('actu_index');
        }

        return $this->render('actu/new.html.twig', [
            'page_title' => 'New Actuality',
            'actu' => $actu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actu_show", methods={"GET", "POST"})
     */
    public function show(Actu $actu, UserRepository $user): Response
    {

        $id = null;
        
        for ($i=0; $i < count($this -> getUser() -> getActus()); $i++) { 
            $cool =  $this -> getUser() -> getActus()[$i] -> getId();
            if ($actu -> getId() == $cool) {
                $id = $cool;
            }
        } 

        return $this->render('actu/show.html.twig', [
            'page_title' => 'Actuality',
            'actu' => $actu,
            'user' => $this -> getUser(),
            'actu_id' => $id
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actu $actu): Response
    {
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actu_index');
        }

        return $this->render('actu/edit.html.twig', [
            'page_title' => 'Edit Actuality',
            'actu' => $actu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actu_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Actu $actu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actu_index');
    }

    /**
     * @Route("/{id}/ajax", name="ajax_actu", methods={"GET","POST"})
     */
    public function toSub(Request $request, Actu $actu)
    {

        $req = $request -> request -> get('value');


        if ($req == "follow") {
            // echo "yo";
            // die;
            $actu ->addUserId($this -> getUser());
            
        } else if ($req == "unfollow") {
            // echo "yoyo";
            // die;
            $actu ->removeUserId($this -> getUser());
        } 
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($actu);
        $entityManager->flush();
        return new JsonResponse($req);
    }

    
}

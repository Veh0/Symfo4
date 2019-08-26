<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Product;
use App\Form\ArtistType;
use App\Hello\WikiArtist;
use App\Repository\ArtistRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/artist")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="artist_index", methods={"GET"})
     */
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('artist/index.html.twig', [
            'artists' => $artistRepository->findAll(), 'page_title' => 'Artist'
        ]);
    }

    /**
     * @Route("/new", name="artist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
            'page_title' => 'New Artist'
        ]);
    }

    /**
     * @Route("/{id}", name="artist_show", methods={"GET"})
     */
    public function show(WikiArtist $wiki, Artist $artist, ArtistRepository $a): Response
    {

        $prod = $artist -> getProducts();

        $sameStyleArtist = $a -> findByStyle($artist -> getStyle());
        

        foreach ($sameStyleArtist as $key => $value) { 
            if ($value["id"] == $artist -> getId()) {
                unset($sameStyleArtist[$key]);
            }
        }

        $w = ($wiki -> getWiki($artist)) ? $wiki -> getWiki($artist) : null ;

        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
            'wiki' => $w,
            'page_title' => 'Artist',
            'sameStyleArtists' => $sameStyleArtist,
            'prod' => $prod
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artist $artist): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
            'page_title' => 'Edit Artist'
        ]);
    }

    /**
     * @Route("/{id}", name="artist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artist $artist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artist_index');
    }

    /**
     * @Route("/{id}/ajax", name="ajax_artist", methods={"GET","POST"})
     */
    public function artistProduct(Request $request, Artist $artist, ProductRepository $prod) {
        
        $arrayProd = [];
        $p = $prod -> findByArtist($artist->getId());

        foreach ($p as $key => $value) { 

                $arrayProd[] = array("title" => $value -> getTitle(), "prodDate" => $value -> getProductionDate(), "desc" => $value -> getDescription(), "prodId" => $this -> generateURL('product_show',['id' => $value -> getId()]));  
        } 

        return new JsonResponse($arrayProd);
    }

}

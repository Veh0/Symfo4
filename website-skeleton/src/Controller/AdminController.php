<?php

namespace App\Controller;


use App\Repository\AdminRepository;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use App\Repository\EventRepository;
use App\Repository\ProductRepository;
use App\Repository\ActuRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController {

    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(Request $request, AdminRepository $admin, UserRepository $user, ArtistRepository $artist, EventRepository $event, ProductRepository $product, ActuRepository $actu) : Response {


        $entityManager= $this -> getDoctrine() -> getManager();
        /* $query = $entityManager -> createQuery('SELECT a, e.place, e.type, e.description, e.city, e.price, COUNT(e.id) as nbe FROM App\Entity\Artist a JOIN a.events e GROUP BY a.id');
        $artistsMoreEvent = $query->getResult(); */ 

        $argsArtistEvent= array('b.place','COUNT(b.id)');

        $clauseArtistEvent = 'WHERE b.place = ?0 AND a.name = ?1';

        $parametersAtistEvent = array("Here", "Jerod Mayo");

        $artistsMoreEvent = $admin -> toJoinDQL($entityManager, 'App\Entity\Artist', 'events', $argsArtistEvent, NULL,$clauseArtistEvent, $parametersAtistEvent);

        $argsArtistProduct= array('b.title', 'b.productionDate');

        $clauseArtistProduct = 'WHERE b.productionDate >= ?0';

        $parametersAtistProduct = array("1971");

        $artistsProduct = $admin -> toJoinDQL($entityManager, 'App\Entity\Artist', 'products', $argsArtistProduct, NULL,$clauseArtistProduct, $parametersAtistProduct);

        // echo "<pre>", var_dump($artistsMoreEvent);die; 

        return $this->render('admin/index.html.twig', [
            'page_title' => 'Admin Page',
            'user' => $user -> findAll(),
            'event' => $event -> findAll(),
            'artist' => $artist -> findAll(),
            'product' => $product -> findAll(),
            'actu' => $actu -> findAll(),
            'event_artist' =>$artistsMoreEvent,
            'prod_artist' => $artistsProduct,
        ]);
    }

    /**
     * @Route("/ajax", name="admin_ajax", methods={"GET", "POST"})
     */
    public function ajaxTable(Request $request) {
        
        $enti = $request -> request -> get('value');

        $entity = new $enti;

        $arrayValues = $enti -> Collection ->getValues();

        var_dump($arrayValues);die;

        $entityManager= $this -> getDoctrine() -> getManager();
        $entity = $entityManager->getClassMetadata($enti)->getColumnNames();
        
        

    return new JsonResponse($entity);
    }
}

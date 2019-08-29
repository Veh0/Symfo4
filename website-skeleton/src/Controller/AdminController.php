<?php

namespace App\Controller;


use App\Repository\AdminRepository;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use App\Repository\EventRepository;
use App\Repository\ProductRepository;
use App\Repository\ActuRepository;
use Doctrine\Common\Collections\Collection as Collec;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController {


    /**
     * @Route("/", name="admin_index", methods={"GET", "POST"})
     */
    public function index(Request $request) : Response {

        /* $query = $entityManager -> createQuery('SELECT a, e.place, e.type, e.description, e.city, e.price, COUNT(e.id) as nbe FROM App\Entity\Artist a JOIN a.events e GROUP BY a.id');
        $artistsMoreEvent = $query->getResult(); */ 

        

        // echo "<pre>", var_dump($artistsMoreEvent);die; 

        return $this->render('admin/index.html.twig', [
            'page_title' => 'Admin Page',
        ]);
    }

    /**
     * @Route("/ajax", name="admin_ajax", methods={"GET", "POST"})
     */
    public function ajaxTable(Request $request) {
        
        $enti = $request -> request -> get('value');
        $this -> table = $enti;
        $entity = new $this -> table;

        

        $arrayCollec = [];

        

        $entityManager= $this -> getDoctrine() -> getManager();
        $entity = $entityManager->getClassMetadata($enti)-> getColumnNames();
        $entityRefClass = $entityManager->getClassMetadata($enti)->getReflectionClass();
        $arrayProperties = $entityRefClass -> getProperties();

        if (!empty($arrayProperties)) {
            # code...
            foreach ($arrayProperties as $key ) {
            # code...
                if (strpos($key -> getDocComment(), 'mappedBy')) {
                $arrayCollec[] = $key; 
                }    
            }
        }

        

        /* var_dump($entity);
        var_dump($arrayCollec); */

    return new JsonResponse(array($entity, $arrayCollec));
    }

    /**
     * @Route("/ajax/join", name="admin_ajax_join", methods={"GET", "POST"})
     */
    public function ajaxJoinTable(Request $request) {
        
        $enti = $request -> request -> get('value');


        


            $enti = "App\Entity\\".ucfirst(substr($enti, 0, -1));
        
        $this -> joinTable = $enti;

        $entity = new $enti;

        $arrayCollec = [];

        

        $entityManager= $this -> getDoctrine() -> getManager();
        $entity = $entityManager->getClassMetadata($enti)-> getColumnNames();
        $entityRefClass = $entityManager->getClassMetadata($enti)->getReflectionClass();
        $arrayProperties = $entityRefClass -> getProperties();

        if (!empty($arrayProperties)) {
            # code...
            foreach ($arrayProperties as $key ) {
            # code...
                if (strpos($key -> getDocComment(), 'mappedBy')) {
                $arrayCollec[] = $key;
                }    
            }
        }

        

        

        /* var_dump($entity);
        var_dump($arrayCollec); */

    return new JsonResponse(array($entity, $arrayCollec));
    }

    /**
     * @Route("/ajax/data", name="admin_ajax_data", methods={"GET", "POST"})
     */
    public function ajaxCheckData(Request $request, AdminRepository $admin) {
        
        $variable = $request -> request -> get('value');

        $table = $variable[0];
        unset($variable[0]);
        $joinTable = $variable[1];
        unset($variable[1]);
        $groupby = $variable[2];
        unset($variable[2]);

        foreach ($variable as $key => $value) {
            # code...
            if (strpos($value, "_")) {
               $value = str_replace('_', '', ucwords($value, '_'));
               $value = lcfirst($value);
            }
            $args[] = $value;
        }

        $entityManager= $this -> getDoctrine() -> getManager();

        if ($joinTable == "") {
            $search = $admin -> toDQL($entityManager, $table, $args, $groupby);
        } else {
            $search = $admin -> toJoinDQL($entityManager, $table, $joinTable, $args, $groupby);
        }


        return new JsonResponse($search);
    }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActuRepository;
use App\Hello\HelloWorld;
use App\Hello\Geo;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ActuRepository $a, HelloWorld $h, Geo $g)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'page_title' => 'Home',
            'hello' => $h->yoUpper(),
            'actus' => $a -> findAll()
        ]);
    }
}

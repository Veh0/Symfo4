<?php

namespace App\Controller;

use App\Entity\Event;
use App\Hello\Geo;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findByStartDate(),
            'page_title' => 'Event'
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $event -> setStartDate($event -> getStartDate()." ".$event -> getStartH());
            $event -> setEndDate($event -> getEndDate()." ".$event -> getEndH());
            $entityManager->persist($event);
            $entityManager->flush();

            
            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'page_title' => 'New Event'
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event, Geo $g): Response
    {

        var_dump($g -> geolocalisation($event)["features"][0]["geometry"]["coordinates"][1]);
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'city' => $event -> getCity(),
            'type' => $event -> getType(),
            'lon' => $g -> geolocalisation($event)["features"][0]["geometry"]["coordinates"][1],
            'lat' => $g -> geolocalisation($event)["features"][0]["geometry"]["coordinates"][0],
            'page_title' => 'Event'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'page_title' => 'Edit Event'
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\PartyType;
use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/party")
 */
class PartyController extends AbstractController
{
    /**
     * @Route("/", name="party_index", methods={"GET"})
     */
    public function index(PartyRepository $partyRepository): Response
    {
        return $this->render('party/index.html.twig', [
            'parties' => $partyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="party_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $party = new Party();
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($party);
            $entityManager->flush();

            return $this->redirectToRoute('party_index');
        }

        return $this->render('party/new.html.twig', [
            'party' => $party,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="party_show", methods={"GET"})
     */
    public function show(Party $party): Response
    {
        return $this->render('party/show.html.twig', [
            'party' => $party,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="party_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Party $party): Response
    {
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('party_index', [
                'id' => $party->getId(),
            ]);
        }

        return $this->render('party/edit.html.twig', [
            'party' => $party,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="party_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Party $party): Response
    {
        if ($this->isCsrfTokenValid('delete'.$party->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($party);
            $entityManager->flush();
        }

        return $this->redirectToRoute('party_index');
    }
}

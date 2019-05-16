<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Party;
use App\Entity\Travel;
use App\Form\PartyType;
use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PartyController extends AbstractController
{
    /**
     * @Route("/party", name="party_index", methods={"GET"})
     */
    public function index(PartyRepository $partyRepository): Response
    {

        return $this->render('party/index.html.twig', [

            'parties' => $partyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/party/new", name="party_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $party = new Party();
        $party->setUser($this->getUser());
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($party);
            $entityManager->flush();

            return $this->redirectToRoute('homepage/');
        }

        return $this->render('party/new.html.twig', [
            'party' => $party,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/party/{id}", name="party_show", methods={"GET"})
     */
    public function show(Party $party): Response
    {
        $travel = $this->getDoctrine()->getRepository(Travel::class)->findBy([], ['party'=>'desc']);
        $aller= $this->getDoctrine()->getRepository(Category::class)->findOneBy(['label'=>Category::ALLER]);
        $retour= $this->getDoctrine()->getRepository(Category::class)->findOneBy(['label'=>Category::RETOUR]);
        $allertravels = $this->getDoctrine()->getRepository(Travel::class)->findByCategory($party, $aller,6);
        $retourtravels = $this->getDoctrine()->getRepository(Travel::class)->findByCategory($party, $retour,6);

        dump($allertravels);

        return $this->render('party/show.html.twig', [

            'party' => $party,
            'travels' =>$travel,
            "allers"=>$allertravels,
            "retours"=>$retourtravels,

        ]);
    }

    /**
     * @Route("/party/{id}/edit", name="party_edit", methods={"GET","POST"})
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
     * @Route("/party/{id}", name="party_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Party $party): Response
    {
        if ($this->isCsrfTokenValid('delete' . $party->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($party);
            $entityManager->flush();
        }

        return $this->redirectToRoute('party_index');
    }

    /**
     * @Route("/search-results", name="search", methods="GET")
     */
    public function searchQuery(Request $request)
    {
        $uq = $request->get('search-query');
        if ($uq === "") {
            $parties = $this->getDoctrine()->getRepository(Party::class)->findAll();
            return $this->render('search/index.html.twig', ['parties' => $parties]);
        } else {
            $parties = $this->getDoctrine()->getRepository(Party::class)->searchBy($uq);
            return $this->render('search/index.html.twig', ['parties' => $parties]);
        }
    }
}

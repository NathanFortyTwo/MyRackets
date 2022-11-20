<?php

namespace App\Controller;

use App\Entity\DisplayRack;
use App\Entity\Racket;
use App\Form\DisplayRackType;
use App\Repository\DisplayRackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/display/rack")
 */
class DisplayRackController extends AbstractController
{
    /**
     * @Route("/", name="app_display_rack_index", methods={"GET"})
     */
    public function index(DisplayRackRepository $displayRackRepository): Response
    {
        return $this->render('display_rack/index.html.twig', [
            'display_racks' => $displayRackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_display_rack_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DisplayRackRepository $displayRackRepository): Response
    {
        $displayRack = new DisplayRack();
        $form = $this->createForm(DisplayRackType::class, $displayRack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $displayRackRepository->add($displayRack, true);

            return $this->redirectToRoute('app_display_rack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('display_rack/new.html.twig', [
            'display_rack' => $displayRack,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_display_rack_show", methods={"GET"})
     */
    public function show(DisplayRack $displayRack): Response
    {
        return $this->render('display_rack/show.html.twig', [
            'display_rack' => $displayRack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_display_rack_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DisplayRack $displayRack, DisplayRackRepository $displayRackRepository): Response
    {
        $form = $this->createForm(DisplayRackType::class, $displayRack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $displayRackRepository->add($displayRack, true);

            return $this->redirectToRoute('app_display_rack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('display_rack/edit.html.twig', [
            'display_rack' => $displayRack,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_display_rack_delete", methods={"POST"})
     */
    public function delete(Request $request, DisplayRack $displayRack, DisplayRackRepository $displayRackRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $displayRack->getId(), $request->request->get('_token'))) {
            $displayRackRepository->remove($displayRack, true);
        }

        return $this->redirectToRoute('app_display_rack_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{display_rack_id}/racket/{racket_id}", name="app_display_rack_racket_show")
     * @ParamConverter("display_rack", options={"id" = "display_rack_id"})
     * @ParamConverter("racket", options={"id" = "racket_id"})
     */
    public function racketShow(DisplayRack $display_rack, Racket $racket): Response
    {
        dump($racket);
        if (!$display_rack->getRackets()->contains($racket)) {
            throw $this->createNotFoundException("Couldn't find such a racket in this display_rack!");
        }

        if (!$display_rack->isPublished()) {
            throw $this->createAccessDeniedException("You cannot access the requested ressource!");
        }
        return $this->render('display_rack/racket_show.html.twig', [
            'racket' => $racket,
            'display_rack' => $display_rack
        ]);
    }
}

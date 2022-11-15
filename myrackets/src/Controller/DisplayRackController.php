<?php

namespace App\Controller;

use App\Entity\DisplayRack;
use App\Form\DisplayRackType;
use App\Repository\DisplayRackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        if ($this->isCsrfTokenValid('delete'.$displayRack->getId(), $request->request->get('_token'))) {
            $displayRackRepository->remove($displayRack, true);
        }

        return $this->redirectToRoute('app_display_rack_index', [], Response::HTTP_SEE_OTHER);
    }
}

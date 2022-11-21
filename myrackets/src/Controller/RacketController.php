<?php

namespace App\Controller;

use App\Entity\Racket;
use App\Form\RacketType;
use App\Repository\RacketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/racket")
 */
class RacketController extends AbstractController
{
    /**
     * @Route("/", name="app_racket_index", methods={"GET"})
     */
    public function index(RacketRepository $racketRepository): Response
    {
        return $this->render('racket/index.html.twig', [
            'rackets' => $racketRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_racket_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RacketRepository $racketRepository): Response
    {
        $racket = new Racket();
        $form = $this->createForm(RacketType::class, $racket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $racketRepository->add($racket, true);

            return $this->redirectToRoute('app_racket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('racket/new.html.twig', [
            'racket' => $racket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_racket_show", methods={"GET"})
     */
    public function show(Racket $racket): Response
    {
        return $this->render('racket/show.html.twig', [
            'racket' => $racket,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_racket_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Racket $racket, RacketRepository $racketRepository): Response
    {
        $form = $this->createForm(RacketType::class, $racket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $racketRepository->add($racket, true);

            return $this->redirectToRoute('app_racket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('racket/edit.html.twig', [
            'racket' => $racket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_racket_delete", methods={"POST"})
     */
    public function delete(Request $request, Racket $racket, RacketRepository $racketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$racket->getId(), $request->request->get('_token'))) {
            $racketRepository->remove($racket, true);
        }

        return $this->redirectToRoute('app_racket_index', [], Response::HTTP_SEE_OTHER);
    }
}

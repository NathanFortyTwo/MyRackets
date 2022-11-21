<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InventoryRepository;
use App\Entity\Inventory;
use App\Entity\Racket;
use App\Entity\TennisMan;
use Symfony\Component\HttpFoundation\Request;
use App\Form\InventoryType;

class InventoryController extends AbstractController
{
    /**
     * @Route("/", name="app_inventory")
     */
    public function indexAction()
    {
        return $this->render('homepage.html.twig', []);
    }
    /**
     * Show a Inventory
     * 
     * @Route("/inventory/{id}", name="inventory_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     * @param Integer $id
     */
    public function showAction(ManagerRegistry $doctrine, $id)
    {
        $InventoryRepo = $doctrine->getRepository(Inventory::class);
        $Inventory = $InventoryRepo->find($id);

        if (!$Inventory) {
            throw $this->createNotFoundException('The Inventory does not exist');
        }
        $rackets = $doctrine->getRepository(Racket::class)->findBy(["inventory" => $Inventory]);
        $back_path = $this->generateUrl("list_inventories");
        return $this->render(
            'inventory/show.html.twig',
            [
                'rackets' => $rackets,
                'inventory' => $Inventory,
                'back_path' => $back_path,
            ]
        );
    }
    /**
     * Liste les inventares
     *
     * @Route("/inventory", name = "list_inventories", methods="GET")
     */
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $inventories = $entityManager->getRepository(Inventory::class)->findAll();
        dump($inventories);

        return $this->render(
            'inventory/list.html.twig',
            [
                'inventories' => $inventories,
            ]

        );
    }
    /**
     * @Route("/new/{id}", name="app_inventory_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InventoryRepository $inventoryRepository, TennisMan $tennisMan): Response
    {
        $inventory = new Inventory();
        $inventory->setTennisMan($tennisMan);
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventoryRepository->add($inventory, true);

            return $this->redirectToRoute('app_inventory', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventory/new.html.twig', [
            'inventory' => $inventory,
            'form' => $form,
        ]);
    }
}

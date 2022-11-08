<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Inventory;
use App\Entity\Racket;

class InventoryController extends AbstractController
{
    /**
     * @Route("/", name="app_inventory")
     */
    public function indexAction()
    {
        $htmlpage = '<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Welcome!</title>
        </head>
        <body>
            <h1>Bienvenue</h1>
            </body>
    </html>';

        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
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
}

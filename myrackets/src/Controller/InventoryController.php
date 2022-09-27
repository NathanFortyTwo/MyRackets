<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class InventoryController extends AbstractController
{
    /**
     * @Route("/inventory", name="app_inventory")
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
                
        <p>Bienvenue, voici votre Inventory  !</p>
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
     * @Route("/Inventory/{id}", name="Inventory_show", requirements={"id"="\d+"})
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

        $res = '...';
        //...

        $res .= '<p/><a href="' . $this->generateUrl('Inventory_index') . '">Back</a>';

        return new Response('<html><body>' . $res . '</body></html>');
    }
}

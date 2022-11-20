<?php

namespace App\DataFixtures;

use App\Entity\DisplayRack;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Racket;
use App\Entity\Inventory;
use App\Entity\RacketCategory;
use App\Entity\RacketWeightCategory;
use App\Entity\TennisMan;
use phpDocumentor\Reflection\PseudoTypes\True_;

class AppFixtures extends Fixture
{
    private static function RacketGenerator()
    {
        yield ["Une super raquette", 200];
        yield ["Une turbo raquette", 210];
    }


    public function load(ObjectManager $manager): void
    {
        $racketRepo = $manager->getRepository(Racket::class); #creation des raquettes
        foreach (self::RacketGenerator() as [$desc, $weight]) {
            $racket = new Racket();
            $racket->setDescription($desc);
            $racket->setWeight($weight);
            $manager->persist($racket);
        }
        $manager->flush();


        $rackets = $racketRepo->findBy([]); #all rackets into inventory

        $tennisman = new TennisMan();
        $tennisman->setName("Jean");
        $tennisman->setDescription("Le meilleur tennisman");

        $paul = new TennisMan();
        $paul->setName("Paul");
        $paul->setDescription("Un mauvais tennisman");


        $inventory = new Inventory();
        $inventory->setDescription("Un inventaire du tonerre");
        $inventory->setTennisMan($tennisman);

        $inventory2 = new Inventory();
        $inventory2->setDescription("Un inventaire plutot bof");
        $inventory2->setTennisMan($paul);

        $category = new RacketWeightCategory();
        $category->setLabel("Les raquettes lourdes");
        $category->setDescription("Ceci est une description");

        $category2 = new RacketWeightCategory();
        $category2->setLabel("Les raquettes TRES lourdes");
        $category2->setDescription("Ceci est une bonne description");
        $category2->setParent($category);

        $raquette2paul = new Racket();
        $raquette2paul->setDescription("La raquette de Paul");
        $raquette2paul->setInventory($inventory2);





        $display_rack = new DisplayRack();
        $display_rack->setDescription("La turbo étagère");
        $display_rack->setPublished(True);
        $display_rack->setTennisMan($tennisman);

        foreach ($rackets as $racket) {
            $inventory->addRacket($racket);
            $racket->addWeightCategory($category2);
            $display_rack->addRacket($racket);
        }


        $manager->persist($category);
        $manager->persist($category2);
        $manager->persist($display_rack);
        $manager->persist($inventory);
        $manager->persist($inventory2);
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\DisplayRack;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Racket;
use App\Entity\Inventory;
use App\Entity\RacketCategory;
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


        $inventory = new Inventory();
        $inventory->setDescription("Un inventaire du tonerre");
        $inventory->setTennisMan($tennisman);

        $category = new RacketCategory();
        $category->setLabel("Les raquettes lourdes");
        $category->setDescription("Ceci est une description");


        $display_rack = new DisplayRack();
        $display_rack->setDescription("La turbo étagère");
        $display_rack->setPublished(True);
        $display_rack->setTennisMan($tennisman);

        foreach ($rackets as $racket) {
            $inventory->addRacket($racket);
            $racket->addCategory($category);
            $display_rack->addRacket($racket);
        }

        $manager->persist($category);
        $manager->persist($display_rack);
        $manager->persist($inventory);
        $manager->flush();
    }
}

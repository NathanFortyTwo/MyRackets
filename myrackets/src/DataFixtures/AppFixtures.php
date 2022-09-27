<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Racket;
use App\Entity\Inventory;

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
        $inventory = new Inventory();
        $inventory->setDescription("Un inventaire du tonerre");
        foreach ($rackets as $racket) {
            $inventory->addRacket($racket);
        }

        $manager->persist($inventory);
        $manager->flush();
    }
}

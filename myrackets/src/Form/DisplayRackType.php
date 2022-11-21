<?php

namespace App\Form;

use App\Entity\DisplayRack;
use App\Entity\Racket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\RacketRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class DisplayRackType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $display_rack = $options['data'] ?? null;
        $member = $display_rack->gettennisMan();

        $builder
            ->add('description')
            ->add('published')
            ->add('tennisMan', null, [
                'disabled'   => true,
            ])
            ->add('rackets'); //, EntityType::class, [
        ////     'class' => Racket::class,
        //   'query_builder' => function (RacketRepository $er) use ($member) {
        //     return $er->createQueryBuilder('g')
        //       ->leftJoin('g.inventory', 'i')
        //     ->andWhere('i.tennisMan = :tennisMan')
        //   ->setParameter('tennisMan', $member);
        //}
        //   ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DisplayRack::class,
        ]);
    }
}

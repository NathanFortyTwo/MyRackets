<?php

namespace App\Form;

use App\Entity\DisplayRack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\RacketRepository;

class DisplayRackType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $display_rack = $options['data'] ?? null;
        $member = $display_rack->getCreator();

        $builder
            ->add('description')
            ->add('published')
            ->add('tennisMan', null, [
                'disabled'   => true,
            ])
            ->add('[objets]', null, [
                'query_builder' => function (RacketRepository $er) use ($member) {
                    return $er->createQueryBuilder('g')
                        ->leftJoin('g.[inventaire]', 'i')
                        ->andWhere('i.tennisMan = :member')
                        ->setParameter('member', $member);
                }
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DisplayRack::class,
        ]);
    }
}

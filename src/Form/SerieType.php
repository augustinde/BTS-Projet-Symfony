<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Personne;
use App\Entity\Serie;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En cours de parution' => 'en_cours',
                    'Terminé' => 'termine'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom'

            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'nom'
            ])
            ->add('scenariste', EntityType::class, [
                'class' => Personne::class,
                'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('p')
                    ->where('p.type LIKE :type')
                    ->setParameter('type', '%Scénariste%');
                },
            ])
            ->add('dessinateur', EntityType::class, [
                'class' => Personne::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('p')
                        ->where('p.type LIKE :type')
                        ->setParameter('type', '%Dessinateur%');
                },
            ])
            ->add('save', SubmitType::class, ['label'=>'Ajouter la série']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}

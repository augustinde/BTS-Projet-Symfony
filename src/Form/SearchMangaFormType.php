<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Manga;
use App\Entity\Personne;
use App\Entity\Serie;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchMangaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', EntityType::class, [
                'required' => false,
                'class' => Serie::class,
                'choice_label' => 'nom'
            ])
            ->add('dessinateur', EntityType::class, [
                'required' => false,
                'class' => Personne::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('p')
                        ->where('p.type LIKE :type')
                        ->setParameter('type', '%Dessinateur%');
                },
            ])
            ->add('scenariste', EntityType::class, [
                'required' => false,
                'class' => Personne::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('p')
                        ->where('p.type LIKE :type')
                        ->setParameter('type', '%Scénariste%');
                },
            ])
            ->add('editeur', EntityType::class, [
                'required' => false,
                'class' => Editeur::class,
                'choice_label' => 'nom'

            ])
            ->add('categorie', EntityType::class, [
                'required' => false,
                'class' => Categorie::class,
                'choice_label' => 'nom'

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Rechercher'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

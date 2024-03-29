<?php

namespace App\Form;

use App\Entity\Manga;
use App\Entity\Serie;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serie', EntityType::class,[
                'class' => Serie::class,
                'choice_label' => 'nom'
            ])
            ->add('nbPage', TextType::class,array('label'=>'Nombre de page'))
            ->add('numTome',IntegerType ::class,array('label'=>'Numéros du Tome'))
            ->add('prixManga',MoneyType::class,array('label'=>'Prix du manga'))
            ->add('descManga', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['minlength' => 90]
            ])
            ->add('image', FileType::class, [
                'label' => 'Insérez une image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => 'image/*',
                        'mimeTypesMessage' => 'Le fichier nest pas une image',
                    ])
                ],
            ])

            ->add('dateParution', DateType::class, [
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd'
            ])

            ->add('save', SubmitType::class,['label'=>'Ajouter '])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}

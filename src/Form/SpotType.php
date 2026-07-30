<?php

namespace App\Form;

use App\Entity\Spot;
use App\Enum\WindQuality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeSpot', TextType::class)
            ->add('nom', TextType::class)
            ->add('region', TextType::class)
            ->add('codeRegion', TextType::class, ['required' => false])
            ->add('note', NumberType::class, ['required' => false])
            ->add('shortDescription', TextareaType::class, ['required' => false])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('localisation', TextareaType::class, ['required' => false])
            ->add('distFromParis', TextType::class, ['required' => false])
            ->add('distFromParisAutoroute', TextType::class, ['required' => false])
            ->add('timeFromParis', TextType::class, ['required' => false])
            ->add('peageFromParis', TextType::class, ['required' => false])
            ->add('mareeDesc', TextareaType::class, ['required' => false])
            ->add('orientationDesc', TextareaType::class, ['required' => false])
            ->add('isFoil', CheckboxType::class, ['required' => false])
            ->add('foilDesc', TextareaType::class, ['required' => false])
            ->add('waveDesc', TextareaType::class, ['required' => false])
            ->add('isContraintEte', CheckboxType::class, ['required' => false])
            ->add('contraintEteDesc', TextareaType::class, ['required' => false])
            ->add('long', NumberType::class, ['required' => false, 'scale' => 6])
            ->add('lat', NumberType::class, ['required' => false, 'scale' => 6])
            ->add('windfinder', UrlType::class, ['required' => false])
            ->add('windguru', UrlType::class, ['required' => false])
            ->add('meteoFrance', UrlType::class, ['required' => false])
            ->add('meteoConsult', UrlType::class, ['required' => false])
            ->add('alloSurf', UrlType::class, ['required' => false])
            ->add('merteo', UrlType::class, ['required' => false])
            ->add('tempEau', UrlType::class, ['required' => false])
            ->add('webcam', UrlType::class, ['required' => false])
            ->add('balise', UrlType::class, ['required' => false])
            ->add('maree', UrlType::class, ['required' => false])
            ->add('links', CollectionType::class, [
                'entry_type' => SpotLinkType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;

        foreach (Spot::DIRECTIONS as $dir) {
            $builder->add("wind_$dir", ChoiceType::class, [
                'choices' => [
                    '' => null,
                    'KO' => '-1',
                    'WARN' => '0',
                    'OK' => '1',
                    'TOP' => '2',
                ],
                'required' => false,
                'label' => strtoupper($dir),
                'mapped' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Spot::class]);
    }
}

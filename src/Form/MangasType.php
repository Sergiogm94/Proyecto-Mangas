<?php

namespace App\Form;

use App\Entity\Characters;
use App\Entity\Mangas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MangasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nombre", "attr" => ["placeholder" => "Nombre"]])
            ->add('imageFile', FileType::class, ["label" => "Imagen", "mapped" => false])       
            ->add('year', NumberType::class, ["label" => "Inicio de publicación"])
            /*->add('characters', EntityType::class, [
                'class' => Characters::class,
                'choice_label' => 'name',
                'multiple' => true
                //'expanded' => true
            ])*/
            ->add("enviar", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mangas::class,
        ]);
    }
}

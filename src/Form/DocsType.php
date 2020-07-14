<?php

namespace App\Form;

use App\Entity\Docs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DocsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('docFile', FileType::class, ['required' => false])
            // ->add('document')
            // ->add('taille')
            // ->add('created_at')
            ->add('date_edition')
            // ->add('date_echeance')
            // ->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Docs::class,
        ]);
    }
}

<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EventBundle\Entity\EventsAdmin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CertifType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titrec',EntityType::class, array(
                'class'=>EventsAdmin::class,
                'choice_label'=>'TitreEvent',
                'multiple'=>false))
            ->add('pointc')
            ->add('datec')
            ->add('valider',SubmitType::class);

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Certif'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_certif';
    }


}

<?php

namespace EventBundle\Form;

use EventBundle\Entity\EventsAdmin;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomp')
                ->add('prenomp')
                ->add('email')
                ->add('passwordp')
                ->add('review')
                ->add('choix',EntityType::class, array(
                'class'=>EventsAdmin::class,
                'choice_label'=>'TitreEvent',
                'multiple'=>false))
                ->add('captcha', CaptchaType::class, array(
                    'width' => 200,
                    'height' => 60,
                    'length' => 5,
                    'quality' => 50,

                    ))
                ->add('valider',SubmitType::class)

        ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Participant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_participant';
    }


}

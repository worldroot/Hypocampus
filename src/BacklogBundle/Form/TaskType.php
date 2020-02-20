<?php

namespace BacklogBundle\Form;

use AppBundle\Entity\User;
use BacklogBundle\Entity\Backlog;
use BacklogBundle\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')->add('descriptionFonctionnel')->add('descriptionTechnique')->add('storyPoints')
            ->add('finishedDate')
            ->add('state', ChoiceType::class, array(
                'choices'  => array(
                    'To Do' => "To Do",
                    'In Progress' => "In Progress",
                    'Done' => "Done",
                ),
            ))
            ->add('user',EntityType::class,array(
                'class'=>User::class,
                'choice_label'=>'username',
                'multiple'=>false
            ))
            ->add('priority')
            ->add('valider',SubmitType::class);
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BacklogBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backlogbundle_task';
    }


}

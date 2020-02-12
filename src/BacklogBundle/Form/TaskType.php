<?php

namespace BacklogBundle\Form;

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
        $builder->add('title')->add('descriptionFonctionnel')->add('descriptionTechnique')->add('storyPoints')->add('createdDate')->add('finishedDate')
            ->add('state', ChoiceType::class, array(
                'choices'  => array(
                    'To Do' => "To Do",
                    'In Progress' => "In Progress",
                    'Done' => "Done",
                ),
            ))
            ->add('priority')
            ->add('backlog',EntityType::class,array(
                'class'=>Backlog::class,
                'choice_label'=>'id',
                'multiple'=>false
            ))
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

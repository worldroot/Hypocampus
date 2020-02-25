<?php

namespace BacklogBundle\Form;

use BacklogBundle\Entity\Project;
use projetsBundle\Entity\projets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BacklogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pointsDone')->add('pointsInProgress')->add('pointsToDo')
            ->add('project',EntityType::class,array(
                'class'=>projets::class,
                'choice_label'=>'projetName',
                'multiple'=>false
            ))
            ->add('valider',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BacklogBundle\Entity\Backlog'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backlogbundle_backlog';
    }


}

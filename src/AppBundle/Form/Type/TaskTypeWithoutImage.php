<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Task;
use AppBundle\Form\TagsTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskTypeWithoutImage extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject')
            ->add('category', EntityType::class, [
                'class' => 'AppBundle\Entity\Category'
            ])
            ->add('tags', TextType::class)
            ->add('priority', ChoiceType::class, array(
                'choices' => Task::getAvailablePriorities()
            ))
        ;

        $builder->get('tags')->addModelTransformer(new TagsTransformer($this->manager));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task',
            'csrf_protection' => false,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }
}

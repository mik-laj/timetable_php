<?php

namespace TimetableBundle\Form;


use TimetableBundle\Entity\StudentGroup;

use AppBundle\Form\Embeddable\SuggestionTutorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TimetableBundle\Form\Embeddable\DayOfWeekType;
use TimetableBundle\Form\Embeddable\SimpleTimeType;
use TimetableBundle\Form\Embeddable\SuggestionSubjectType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('startTime', SimpleTimeType::class)
            ->add('endTime', SimpleTimeType::class)
            ->add('day', DayOfWeekType::class)
            ->add('subject', SuggestionSubjectType::class)
            ->add('tutor', SuggestionTutorType::class)
            ->add('student_groups', EntityType::class, [
                'by_reference' => false,
                'multiple' => true,
                'class' => StudentGroup::class
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TimetableBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }


}

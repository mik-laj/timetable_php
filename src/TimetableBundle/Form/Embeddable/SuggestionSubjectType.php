<?php

namespace TimetableBundle\Form\Embeddable;

use AppBundle\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class SuggestionSubjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'remote_route' => 'subject_suggestion',
            'class' => Subject::class,
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'pl',
            'placeholder' => 'Select a subject',
        ));
    }

    public function getParent()
    {
        return Select2EntityType::class;
    }
}

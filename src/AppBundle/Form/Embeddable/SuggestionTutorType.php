<?php

namespace AppBundle\Form\Embeddable;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class SuggestionTutorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'remote_route' => 'tutor_suggestion',
            'class' => 'AppBundle\Entity\Tutor',
            'primary_key' => 'id',
            'page_limit' => 10,
            'allow_clear' => true,
            'delay' => 250,
            'language' => 'pl',
            'placeholder' => 'Select a tutor',
        ));
    }

    public function getParent()
    {
        return Select2EntityType::class;
    }
}

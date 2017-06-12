<?php
/**
 * Created by PhpStorm.
 * User: andrzej
 * Date: 03.06.17
 * Time: 21:15
 */

namespace TimetableBundle\Form\Embeddable;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayOfWeekType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => [
                'Monday' => 1,
                'Tuesday' => 2,
                'Wednesday' => 3,
                'Thursday' => 4,
                'Friday' => 5,
                'Saturday' => 6,
                'Sunday' => 7
            ]
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}

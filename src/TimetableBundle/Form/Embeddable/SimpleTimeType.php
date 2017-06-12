<?php

namespace TimetableBundle\Form\Embeddable;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TimetableBundle\Entity\SimpleTime;

class SimpleTimeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CallbackTransformer(
                function (SimpleTime $data = null) {
                    if(!$data)
                    {
                        return null;
                    }
                    return [
                        'hour' => $data->getHour(),
                        'minute' => $data->getMinute()
                    ];
                },
                function ($data) {
                    return new SimpleTime($data['hour'], $data['minute']);
                }
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'input' => 'array',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TimeType::class;
    }
}
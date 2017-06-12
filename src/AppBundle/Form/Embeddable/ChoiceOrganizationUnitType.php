<?php

namespace AppBundle\Form\Embeddable;

use AppBundle\Entity\OrganizationUnit;
use AppBundle\Repository\OrganizationUnitRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceOrganizationUnitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => OrganizationUnit::class,
            'query_builder' => function (OrganizationUnitRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.lft', 'ASC');
            },
            'choice_label' => function (OrganizationUnit $unit) {
                return str_repeat(' - ', $unit->getLvl()) . $unit;
            }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }


}

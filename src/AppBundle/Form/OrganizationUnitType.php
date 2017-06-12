<?php

namespace AppBundle\Form;

use AppBundle\Entity\OrganizationUnit;
use AppBundle\Form\Embeddable\ChoiceOrganizationUnitType;
use AppBundle\Repository\OrganizationUnitRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationUnitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var OrganizationUnit */
        $organizationUnit = $builder->getData();
        $builder->add('name')
            ->add('parent', ChoiceOrganizationUnitType::class, [
                'class' => OrganizationUnit::class,
                'query_builder' => function (OrganizationUnitRepository $er) use ($organizationUnit) {
                    if ($organizationUnit) {
                        $qb = $er->createQueryBuilder('u2')
                            ->where('u2.lft >= :lft')
                            ->andWhere('u2.rgt <= :rgt')
                        ;
                        return $er->createQueryBuilder('u1')
                            ->orderBy('u1.lft', 'ASC')
                            ->where($qb->expr()->NotIn('u1.id', $qb->getDQL()))
                            ->setParameter('lft', $organizationUnit->getLft())
                            ->setParameter('rgt', $organizationUnit->getRgt());
                    }
                }
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\OrganizationUnit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_organizationunit';
    }


}

<?php

namespace UserBundle\Form;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\RouterInterface;


class LoginForm extends AbstractType
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $url = $this->router->generate('security_login');

        $builder->setAction($url)
            ->setMethod('POST')
            ->add('username', TextType::class)
            ->add('password', PasswordType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->resolve();
    }

}
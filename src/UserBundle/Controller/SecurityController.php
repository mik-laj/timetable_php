<?php
/**
 * Created by PhpStorm.
 * User: andrzej
 * Date: 04.06.17
 * Time: 14:49
 */

namespace UserBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use UserBundle\Form\LoginForm;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     * @Method({"GET", "POST"});
     */
    public function loginAction(Request $request)
    {
        /** @var AuthenticationUtils $authUtils */
        $authUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $login_form = $this->createForm(LoginForm::class, array('username' => $lastUsername));

        if ($error) {
           $this->addFlash('danger', $error->getMessageKey());
        }

        return $this->render('security/login.html', array(
//            'error' => $error,
            'login_form' => $login_form->createView()
        ));
    }

    /**
     * @Route("/login", name="security_check")
     * @Method({"POST"});
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="security_logout")
     * @Method({"GET", "POST"});
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: andrzej
 * Date: 03.06.17
 * Time: 17:56
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route(name="default_index", path="/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function index() {
        return $this->render('default/index.html.twig');
    }
}
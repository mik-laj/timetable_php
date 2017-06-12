<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrganizationUnit;
use AppBundle\Form\OrganizationUnitType;
use AppBundle\Repository\OrganizationUnitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Organizationunit controller.
 *
 * @Route("organizationunit")
 */
class OrganizationUnitController extends Controller
{
    /**
     * Lists all organizationUnit entities.
     *
     * @Route("/", name="organizationunit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organizationUnits = $em->getRepository('AppBundle:OrganizationUnit')->findAll();

        return $this->render('organizationunit/index.html.twig', array(
            'organizationUnits' => $organizationUnits,
        ));
    }

    /**
     * Creates a new organizationUnit entity.
     *
     * @Route("/new", name="organizationunit_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_ORGANIZATION_UNIT')")
     */
    public function newAction(Request $request)
    {
        $organizationUnit = new OrganizationUnit();
        $form = $this->createForm(OrganizationUnitType::class, $organizationUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organizationUnit);
            $em->flush();

            $this->addFlash('success', 'OrganizationUnit created');
            return $this->redirectToRoute('organizationunit_show', array('id' => $organizationUnit->getId()));
        }

        return $this->render('organizationunit/new.html.twig', array(
            'organizationUnit' => $organizationUnit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a organizationUnit entity.
     *
     * @Route("/{id}", name="organizationunit_show")
     * @Method("GET")
     * @ParamConverter("organizationUnit", class="AppBundle:OrganizationUnit", options={"repository_method" = "findWithJoins"})
     */
    public function showAction(OrganizationUnit $organizationUnit)
    {
        $deleteForm = $this->createDeleteForm($organizationUnit);

        $em = $this->getDoctrine()->getManager();

        /** @var OrganizationUnitRepository $repo */
        $repo = $em->getRepository(OrganizationUnit::class);

        $children = $repo->childrenHierarchy($organizationUnit);

        return $this->render('organizationunit/show.html.twig', array(
            'organizationUnit' => $organizationUnit,
            'children' => $children,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing organizationUnit entity.
     *
     * @Route("/{id}/edit", name="organizationunit_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_ORGANIZATION_UNIT')")
     */
    public function editAction(Request $request, OrganizationUnit $organizationUnit)
    {
        $deleteForm = $this->createDeleteForm($organizationUnit);
        $editForm = $this->createForm(OrganizationUnitType::class, $organizationUnit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'OrganizationUnit updated');
            return $this->redirectToRoute('organizationunit_index');
        }

        return $this->render('organizationunit/edit.html.twig', array(
            'organizationUnit' => $organizationUnit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a organizationUnit entity.
     *
     * @Route("/{id}", name="organizationunit_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_MANAGE_ORGANIZATION_UNIT')")
     */
    public function deleteAction(Request $request, OrganizationUnit $organizationUnit)
    {
        $form = $this->createDeleteForm($organizationUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organizationUnit);
            $em->flush();

            $this->addFlash('success', 'OrganizationUnit deleted');
        }

        return $this->redirectToRoute('organizationunit_index');
    }

    /**
     * Creates a form to delete a organizationUnit entity.
     *
     * @param OrganizationUnit $organizationUnit The organizationUnit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrganizationUnit $organizationUnit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organizationunit_delete', array('id' => $organizationUnit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

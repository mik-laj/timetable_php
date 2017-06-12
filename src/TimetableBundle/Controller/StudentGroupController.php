<?php

namespace TimetableBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use TimetableBundle\Entity\StudentGroup;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TimetableBundle\Form\StudentGroupType;

/**
 * Studentgroup controller.
 *
 * @Route("student-group")
 */
class StudentGroupController extends Controller
{
    /**
     * Lists all studentGroup entities.
     *
     * @Route("/", name="student_group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $studentGroups = $em->getRepository(StudentGroup::class)->findListQueryBuilder()->getQuery()->getResult();

        return $this->render('studentgroup/index.html.twig', array(
            'studentGroups' => $studentGroups,
        ));
    }

    /**
     * Creates a new studentGroup entity.
     *
     * @Route("/new", name="student_group_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_STUDENT_GROUP')")
     */
    public function newAction(Request $request)
    {
        $studentGroup = new Studentgroup();
        $form = $this->createForm(StudentGroupType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($studentGroup);
            $em->flush();

            $this->addFlash('success', 'StudentGroup created');
            return $this->redirectToRoute('student_group_show', array('id' => $studentGroup->getId()));
        }

        return $this->render('studentgroup/new.html.twig', array(
            'studentGroup' => $studentGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a studentGroup entity.
     *
     * @Route("/{id}", name="student_group_show")
     * @Method("GET")
     * @ParamConverter("studentGroup", class="TimetableBundle:StudentGroup", options={"repository_method" = "findWithJoins"})
     */
    public function showAction(StudentGroup $studentGroup)
    {
        $deleteForm = $this->createDeleteForm($studentGroup);

        return $this->render('studentgroup/show.html.twig', array(
            'studentGroup' => $studentGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing studentGroup entity.
     *
     * @Route("/{id}/edit", name="student_group_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_STUDENT_GROUP')")
     */
    public function editAction(Request $request, StudentGroup $studentGroup)
    {
        $deleteForm = $this->createDeleteForm($studentGroup);
        $editForm = $this->createForm(StudentGroupType::class, $studentGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'StudentGroup updated');
            return $this->redirectToRoute('student_group_index');
        }

        return $this->render('studentgroup/edit.html.twig', array(
            'studentGroup' => $studentGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a studentGroup entity.
     *
     * @Route("/{id}", name="student_group_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_MANAGE_STUDENT_GROUP')")
     */
    public function deleteAction(Request $request, StudentGroup $studentGroup)
    {
        $form = $this->createDeleteForm($studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($studentGroup);
            $em->flush();

            $this->addFlash('success', 'StudentGroup deleted');
        }

        return $this->redirectToRoute('student_group_index');
    }

    /**
     * Creates a form to delete a studentGroup entity.
     *
     * @param StudentGroup $studentGroup The studentGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StudentGroup $studentGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('student_group_delete', array('id' => $studentGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

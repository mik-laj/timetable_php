<?php

namespace TimetableBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use TimetableBundle\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TimetableBundle\Form\SubjectType;

/**
 * Subject controller.
 *
 * @Route("subject")
 */
class SubjectController extends Controller
{
    /**
     * Lists all subject entities.
     *
     * @Route("/", name="subject_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subjects = $em->getRepository(Subject::class)->findAll();

        return $this->render('subject/index.html.twig', array(
            'subjects' => $subjects,
        ));
    }

    /**
     * Creates a new subject entity.
     *
     * @Route("/new", name="subject_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_SUBJECT')")
     */
    public function newAction(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            $this->addFlash('success', 'Subject created');
            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        }

        return $this->render('subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/{id}", name="subject_show")
     * @Method("GET")
     * @ParamConverter("subject", class="TimetableBundle:Subject", options={"repository_method" = "findWithJoins"})
     */
    public function showAction(Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);

        return $this->render('subject/show.html.twig', array(
            'subject' => $subject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subject entity.
     *
     * @Route("/{id}/edit", name="subject_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_SUBJECT')")
     */
    public function editAction(Request $request, Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);
        $editForm = $this->createForm(SubjectType::class, $subject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Subject updated');
            return $this->redirectToRoute('subject_index');
        }

        return $this->render('subject/edit.html.twig', array(
            'subject' => $subject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subject entity.
     *
     * @Route("/{id}", name="subject_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_MANAGE_SUBJECT')")
     */
    public function deleteAction(Request $request, Subject $subject)
    {
        $form = $this->createDeleteForm($subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();

            $this->addFlash('success', 'Subject deleted');
        }

        return $this->redirectToRoute('subject_index');
    }

    /**
     * Creates a form to delete a subject entity.
     *
     * @param Subject $subject The subject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subject $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_delete', array('id' => $subject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Return suggestion for subject.
     *
     * @Route("/suggestion/", name="subject_suggestion")
     * @Method("GET")
     */
    public function suggestionTutorAction(Request $request)
    {
        $q = $request->query->get('q');
        $limit = $request->query->get('page_limit');

        $repo = $this->getDoctrine()->getRepository(Subject::class);

        $elements = $repo->search($q, $limit);
        $elements = array_map(function(Subject $subject) {
            return [
                'id' => $subject->getId(),
                'text' => (string) $subject
            ];
        }, $elements);

        return $this->json($elements);
    }
}

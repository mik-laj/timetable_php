<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tutor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tutor controller.
 *
 * @Route("tutor")
 */
class TutorController extends Controller
{
    /**
     * Lists all tutor entities.
     *
     * @Route("/", name="tutor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tutors = $em->getRepository('AppBundle:Tutor')->findAll();

        return $this->render('tutor/index.html.twig', array(
            'tutors' => $tutors,
        ));
    }

    /**
     * Creates a new tutor entity.
     *
     * @Route("/new", name="tutor_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_TUTOR')")
     */
    public function newAction(Request $request)
    {
        $tutor = new Tutor();
        $form = $this->createForm('AppBundle\Form\TutorType', $tutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tutor);
            $em->flush();

            $this->addFlash('success', 'Tutor created');
            return $this->redirectToRoute('tutor_show', array('id' => $tutor->getId()));
        }

        return $this->render('tutor/new.html.twig', array(
            'tutor' => $tutor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tutor entity.
     *
     * @Route("/{id}", name="tutor_show")
     * @Method("GET")
     */
    public function showAction(Tutor $tutor)
    {
        $deleteForm = $this->createDeleteForm($tutor);

        return $this->render('tutor/show.html.twig', array(
            'tutor' => $tutor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tutor entity.
     *
     * @Route("/{id}/edit", name="tutor_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_TUTOR')")
     */
    public function editAction(Request $request, Tutor $tutor)
    {
        $deleteForm = $this->createDeleteForm($tutor);
        $editForm = $this->createForm('AppBundle\Form\TutorType', $tutor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Tutor updated');
            return $this->redirectToRoute('tutor_index');
        }

        return $this->render('tutor/edit.html.twig', array(
            'tutor' => $tutor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tutor entity.
     *
     * @Route("/{id}", name="tutor_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_MANAGE_TUTOR')")
     */
    public function deleteAction(Request $request, Tutor $tutor)
    {
        $form = $this->createDeleteForm($tutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tutor);
            $em->flush();

            $this->addFlash('success', 'Tutor deleted');
        }

        return $this->redirectToRoute('tutor_index');
    }

    /**
     * Creates a form to delete a tutor entity.
     *
     * @param Tutor $tutor The tutor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tutor $tutor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tutor_delete', array('id' => $tutor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Return suggestion for field.
     *
     * @Route("/tutor/", name="tutor_suggestion")
     * @Method("GET")
     */
    public function suggestionTutorAction(Request $request)
    {
        $q = $request->query->get('q');
        $limit = $request->query->get('page_limit');

        $repo = $this->getDoctrine()->getRepository(Tutor::class);

        $elements = $repo->search($q, $limit);
        $elements = array_map(function(Tutor $tutor) {
            return [
                'id' => $tutor->getId(),
                'text' => (string) $tutor
            ];
        }, $elements);

        return $this->json($elements);
    }
}

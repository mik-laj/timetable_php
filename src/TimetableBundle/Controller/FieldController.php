<?php

namespace TimetableBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use TimetableBundle\Entity\Field;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TimetableBundle\Form\FieldType;

/**
 * Field controller.
 *
 * @Route("field")
 */
class FieldController extends Controller
{
    /**
     * Lists all field entities.
     *
     * @Route("/", name="field_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fields = $em->getRepository(Field::class)->findListQueryBuilder()->getQuery()->getResult();

        return $this->render('field/index.html.twig', array(
            'fields' => $fields,
        ));
    }

    /**
     * Creates a new field entity.
     *
     * @Route("/new", name="field_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_FIELD')")
     */
    public function newAction(Request $request)
    {
        $field = new Field();
        $form = $this->createForm(FieldType::class, $field);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($field);
            $em->flush();

            $this->addFlash('success', 'Field created');
            return $this->redirectToRoute('field_show', array('id' => $field->getId()));
        }

        return $this->render('field/new.html.twig', array(
            'field' => $field,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a field entity.
     *
     * @Route("/{id}", name="field_show")
     * @Method("GET")
     * @ParamConverter("field", class="TimetableBundle:Field", options={"repository_method" = "findWithJoins"})
     */
    public function showAction(Field $field)
    {
        $deleteForm = $this->createDeleteForm($field);

        return $this->render('field/show.html.twig', array(
            'field' => $field,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing field entity.
     *
     * @Route("/{id}/edit", name="field_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_MANAGE_FIELD')")
     */
    public function editAction(Request $request, Field $field)
    {
        $deleteForm = $this->createDeleteForm($field);
        $editForm = $this->createForm(FieldType::class, $field);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Field updated');
            return $this->redirectToRoute('field_index');
        }

        return $this->render('field/edit.html.twig', array(
            'field' => $field,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a field entity.
     *
     * @Route("/{id}", name="field_delete")
     * @Method("DELETE")
     * @Security("is_granted('ROLE_MANAGE_FIELD')")
     */
    public function deleteAction(Request $request, Field $field)
    {
        $form = $this->createDeleteForm($field);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($field);
            $em->flush();

            $this->addFlash('success', 'Field deleted');
        }

        return $this->redirectToRoute('field_index');
    }

    /**
     * Creates a form to delete a field entity.
     *
     * @param Field $field The field entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Field $field)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('field_delete', array('id' => $field->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Return suggestion for field.
     *
     * @Route("/tutor/", name="field_suggestion")
     * @Method("GET")
     */
    public function suggestionTutorAction(Request $request)
    {
        $q = $request->query->get('q');
        $limit = $request->query->get('page_limit');

        $repo = $this->getDoctrine()->getRepository(Field::class);

        $elements = $repo->search($q, $limit);
        $elements = array_map(function(Field $field) {
            return [
                'id' => $field->getId(),
                'text' => (string) $field
            ];
        }, $elements);

        return $this->json($elements);
    }

}

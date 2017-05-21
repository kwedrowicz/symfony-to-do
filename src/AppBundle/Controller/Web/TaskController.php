<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Task;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Task controller.
 *
 * @Route("task")
 */
class TaskController extends Controller
{
    /**
     * Lists all task entities.
     *
     * @Route("/", name="task_index")
     * @Method("GET")
     * @Cache(expires="+2 days")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $search = $request->query->get('search');
        $finder = $this->get('fos_elastica.finder.app.task');
        $boolQuery = new BoolQuery();
        if($search){
            $fieldQuery = new Query\MultiMatch();
            $fieldQuery->setQuery($search);
            $fieldQuery->setFields(['subject', 'category', 'tags']);
            $boolQuery->addMust($fieldQuery);
        }
        $userFilter = new Query\Term();
        $userFilter->setTerm('user', $this->getUser()->getUsername());
        $boolQuery->addFilter($userFilter);

        $tasks = $finder->find($boolQuery, 1000);
	    $deleteForms = [];
        /* @var Task $task */
	    foreach ($tasks as $task) {
		    $deleteForms[$task->getId()] = $this->createDeleteForm($task)->createView();
	    }


        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
	        'delete_forms' => $deleteForms
        ));
    }

	/**
	 * Creates a new task entity.
	 *
	 * @Route("/new", name="task_new")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function newAction(Request $request)
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm('AppBundle\Form\Type\TaskType', $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'Task created!');
            return $this->redirectToRoute('task_show', array('id' => $task->getId()));
        }

        return $this->render('task/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }

	/**
	 * Finds and displays a task entity.
	 *
	 * @Route("/{id}", name="task_show")
	 * @Method("GET")
	 * @param Task $task
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function showAction(Task $task)
    {
        $deleteForm = $this->createDeleteForm($task);

        return $this->render('task/show.html.twig', array(
            'task' => $task,
            'delete_form' => $deleteForm->createView()
        ));
    }

	/**
	 * Displays a form to edit an existing task entity.
	 *
	 * @Route("/{id}/edit", name="task_edit")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @param Task $task
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function editAction(Request $request, Task $task)
    {
        $deleteForm = $this->createDeleteForm($task);
        $editForm = $this->createForm('AppBundle\Form\Type\TaskType', $task);
        $editForm->add('done');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_edit', array('id' => $task->getId()));
        }

        return $this->render('task/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

	/**
	 * Deletes a task entity.
	 *
	 * @Route("/{id}", name="task_delete")
	 * @Method("DELETE")
	 * @param Request $request
	 * @param Task $task
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
    public function deleteAction(Request $request, Task $task)
    {
        $form = $this->createDeleteForm($task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('task_index');
    }

    /**
     * Creates a form to delete a task entity.
     *
     * @param Task $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Task $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

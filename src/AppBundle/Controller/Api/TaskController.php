<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Task;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class TaskController
 * @package AppBundle\Controller\Api
 */
class TaskController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *     description="Returns a collection of Tasks",
     *     resource=true
     * )
     */
    public function cgetAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();
        if ($tasks === null) {
            throw new ResourceNotFoundException("No task in collection");
        }
        return $tasks;
    }

    /**
     * @ApiDoc(
     *     description="Creates Task",
     *     resource=true,
     *     input="AppBundle\Form\Type\TaskTypeWithoutImage"
     * )
     */
    public function postAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm('AppBundle\Form\Type\TaskType', $task);
        $data = $request->request->all();
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'api_get_task',
                    array('id' => $task->getId())
                ),
                Response::HTTP_CREATED
            );
        }

        return $form;
    }

    /**
     * @ApiDoc(
     *     description="Updates the Task",
     *     resource=true,
     *     input="AppBundle\Form\Type\TaskTypeWithoutImage"
     * )
     */
    public function putAction($id, Request $request){
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);
        if ($task === null) {
            throw new ResourceNotFoundException("Task not found");
        }

        $form = $this->createForm('AppBundle\Form\Type\TaskType', $task);
        $data = $request->request->all();
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'api_get_task',
                    array('id' => $task->getId())
                ),
                Response::HTTP_OK
            );
        }

        return $form;
    }

    /**
     * @ApiDoc(
     *     description="Returns single Task",
     *     resource=true
     * )
     */
    public function getAction($id)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);
        if ($task === null) {
            throw new ResourceNotFoundException("Task not found");
        }
        return $task;
    }

    /**
     * @ApiDoc(
     *     description="Deletes Task",
     *     resource=true
     * )
     */
    public function deleteAction($id)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);
        if($task === null){
            throw new ResourceNotFoundException("Task not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
    }
}

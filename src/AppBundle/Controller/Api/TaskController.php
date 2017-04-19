<?php
/**
 * Created by PhpStorm.
 * User: kwedrowicz
 * Date: 18.04.2017
 * Time: 09:51
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Task;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class TaskController
 * @package AppBundle\Controller\Api
 */
class TaskController extends FOSRestController implements ClassResourceInterface
{

    public function cgetAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();
        if ($tasks === null) {
            throw new ResourceNotFoundException("No task in collection");
        }
        return $tasks;
    }

    public function postAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm('AppBundle\Form\Type\TaskType', $task);
        $data = json_decode($request->getContent(), true);
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

    public function getAction($id)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);
        if ($task === null) {
            throw new ResourceNotFoundException("Task not found");
        }
        return $task;
    }

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
<?php

namespace AppBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CategoryController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *     description="Returns a collection of Categories",
     *     resource=true
     * )
     */
    public function cgetAction()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
    }

    /**
     * @ApiDoc(
     *     description="Returns single Category",
     *     resource=true
     * )
     */
    public function getAction($id)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if ($task === null) {
            throw new ResourceNotFoundException("Category not found");
        }
        return $task;
    }
}

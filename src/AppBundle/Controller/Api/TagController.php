<?php


namespace AppBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class TagController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *     description="Returns a collection of Tags",
     *     resource=true
     * )
     */
    public function cgetAction()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Tag')->findAll();
    }

    /**
     * @ApiDoc(
     *     description="Returns single Tag",
     *     resource=true
     * )
     */
    public function getAction($id)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Tag')->find($id);
        if ($task === null) {
            throw new ResourceNotFoundException("Tag not found");
        }
        return $task;
    }
}
<?php


namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->findAll();
        $response =  $this->render('news/index.html.twig', [
            'news' => $news
        ]);
        $response->setSharedMaxAge(5);
        return $response;
    }
}

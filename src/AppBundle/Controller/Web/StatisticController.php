<?php

namespace AppBundle\Controller\Web;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("statistic")
 */
class StatisticController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        $tasksCountByDays = $this->getDoctrine()->getRepository('AppBundle:Task')->getCountByDays($this->getUser(), 100);
        $tasksDoneUndoneCount = $this->getDoctrine()->getRepository('AppBundle:Task')->getDoneUndoneCount($this->getUser());
        $series = array(
            array("name" => "Data Serie Name", "data" => array())
        );

        foreach($tasksCountByDays as $day){
            $series[0]['data'][] = [strtotime($day['date'])*1000, intval($day['counter'])];
        }

        $ob = new Highchart();
        $ob->chart->type('column');
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Tasks group by created date');
        $ob->xAxis->title(array('text'  => "data"));
        $ob->xAxis->type('datetime');
        $ob->xAxis->dateTimeLabelFormats([
            'day' => '%e. %b'
        ]);
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);


        $ob2 = new Highchart();
        $ob2->chart->type('pie');
        $ob2->chart->renderTo('linechart2');  // The #id of the div where to render the chart
        $ob2->yAxis->title(array('text'  => "Vertical axis title"));

        $series2 = array(
            array("name" => "Data Serie Name", "data" => array())
        );

        foreach($tasksDoneUndoneCount as $el){
            $series2[0]['data'][] = [$el['done'] ? 'done' : 'not done', intval($el['counter'])];
        }

        $ob2->series($series2);

        return $this->render('statistic/index.html.twig', array(
            'chart' => $ob,
            'chart2' => $ob2
        ));
    }

}

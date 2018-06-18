<?php

namespace DataminingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Datamining/Default/index.html.twig');
    }

    public function setDataminingListAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $idUser = 1;

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($idUser);

            $dataminingList = new \HomeBundle\Entity\Datamininglist;
            $dataminingList->setUser($user);

            $em->persist($dataminingList);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );

            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function getDataminingListAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

//        $sessionId = $_POST['sessionId'];
//        $fieldName = $_POST['fieldName'];

        $sessionId = 1;

        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);

            $dataminingList = $em->createQuery(
                    "SELECT dl.datamininglistId, u.userId 
                FROM HomeBundle:Datamininglist dl 
                JOIN HomeBundle:User u 
                WITH dl.user = u.userId 
                WHERE dl.datamininglistId = '1'"
            );

            $dataminingList_v = $dataminingList->getResult();

            if ($dataminingList_v) {
                $datamininglistId_Value = $dataminingList_v[0]['datamininglistId'];
                $userId_Value = $dataminingList_v[0]['userId'];
            } else {
                $datamininglistId_Value = "_";
                $userId_Value = "_";
            }

            $sendData[0] = array(
                'datamininglistId' => $datamininglistId_Value,
                'userId' => $userId_Value
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function setDataminingListVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $idVideo = 1;
            $idDataminingList = 1;

            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($idVideo);
            $dataminingList = $em->getRepository('HomeBundle:Datamininglist')->findOneByDatamininglistId($idDataminingList);

            $dataminingListVideo = new \HomeBundle\Entity\Datamininglistvideo;
            $dataminingListVideo->setDatamininglist($dataminingList);
            $dataminingListVideo->setVideo($video);

            $em->persist($dataminingListVideo);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );

            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function getDataminingListVideoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

//        $sessionId = $_POST['sessionId'];
//        $fieldName = $_POST['fieldName'];

        $sessionId = 1;

        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);

            $dataminingListVideo = $em->createQuery(
                    "SELECT dlv.datamininglistvideoId, v.videoId, dl.datamininglistId 
                FROM HomeBundle:Datamininglistvideo dlv 
                JOIN HomeBundle:Video v 
                WITH dlv.video = v.videoId 
                JOIN HomeBundle:Datamininglist dl 
                WITH dlv.datamininglist = dl.datamininglistId
                WHERE dlv.datamininglistvideoId = '1'"
            );

            $dataminingListVideo_v = $dataminingListVideo->getResult();

            if ($dataminingListVideo_v) {
                $datamininglistvideoId_Value = $dataminingListVideo_v[0]['datamininglistvideoId'];
                $videoId_Value = $dataminingListVideo_v[0]['videoId'];
                $datamininglistId_Value = $dataminingListVideo_v[0]['datamininglistId'];
            } else {
                $datamininglistvideoId_Value = "_";
                $videoId_Value = "_";
                $datamininglistId_Value = "_";
            }

            $sendData[0] = array(
                'datamininglistvideoId' => $datamininglistvideoId_Value,
                'videoId' => $videoId_Value,
                'datamininglistId' => $datamininglistId_Value
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
    
}

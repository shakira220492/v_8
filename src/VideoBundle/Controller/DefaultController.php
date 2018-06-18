<?php

namespace VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('@Video/Default/index.html.twig');
    }

    public function getInfoAboutVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $video = $em->createQuery(
                    "SELECT v.videoId, v.videoName, v.videoDescription, v.videoImage, v.videoContent, v.videoUpdatedate, v.videoAmountViews, v.videoLikes, v.videoDislikes, 
                        u.userId, u.userName, u.userEmail, u.userPassword 
                    FROM HomeBundle:Video v 
                    JOIN HomeBundle:User u 
                    WITH u.userId = v.user 
                    WHERE v.videoId = '1'");

            $videos = $video->getResult();


            
            if ($videos) {
                
                $videoUpdatedate = $videos[0]['videoUpdatedate'];
                
                $videoUpdatedateString = $videoUpdatedate->format('d-M-Y');
                
                $videoId_Value = $videos[0]['videoId'];
                $videoName_Value = $videos[0]['videoName'];
                $videoDescription_Value = $videos[0]['videoDescription'];
                $videoImage_Value = $videos[0]['videoImage'];
                $videoContent_Value = $videos[0]['videoContent'];
                $videoUpdatedate_Value = $videoUpdatedateString;
                $videoAmountViews_Value = $videos[0]['videoAmountViews'];
                $videoLikes_Value = $videos[0]['videoLikes'];
                $videoDislikes_Value = $videos[0]['videoDislikes'];
                $userId_Value = $videos[0]['userId'];
                $userName_Value = $videos[0]['userName'];
                $userEmail_Value = $videos[0]['userEmail'];
                $userPassword_Value = $videos[0]['userPassword'];
            } else {
                $videoId_Value = "_";
                $videoName_Value = "_";
                $videoDescription_Value = "_";
                $videoImage_Value = "_";
                $videoContent_Value = "_";
                $videoUpdatedate_Value = "_";
                $videoAmountViews_Value = "_";
                $videoLikes_Value = "_";
                $videoDislikes_Value = "_";
                $userId_Value = "_";
                $userName_Value = "_";
                $userEmail_Value = "_";
                $userPassword_Value = "_";
            }

            $users2 = array();
            $users2[0] = array(
                'videoId' => $videoId_Value,
                'videoName' => $videoName_Value,
                'videoDescription' => $videoDescription_Value,
                'videoImage' => $videoImage_Value,
                'videoContent' => $videoContent_Value,
                'videoUpdatedate' => $videoUpdatedate_Value,
                'videoAmountViews' => $videoAmountViews_Value,
                'videoLikes' => $videoLikes_Value,
                'videoDislikes' => $videoDislikes_Value,
                'userId' => $userId_Value,
                'userName' => $userName_Value,
                'userEmail' => $userEmail_Value,
                'userPassword' => $userPassword_Value
            );

            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function getCommentAboutVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

//            $numAle = rand(1, 9);
            $videoId = 1;
//            $videoId = $_POST['idVideo'];

//            $comment = $em->createQuery(
//                "SELECT c.commentId, c.commentContent, c.commentLikes, c.commentDislikes, c.commentCreationdate, 
//                u.userId, u.userName, 
//                v.videoId 
//                FROM HomeBundle:Comment c 
//                JOIN HomeBundle:User u 
//                WITH u.userId = c.user 
//                JOIN HomeBundle:Video v 
//                WITH v.videoId = c.video 
//                WHERE c.commentId = '$numAle'");


            $query = $em->createQuery(
                "SELECT c.commentId, c.commentContent, c.commentLikes, c.commentDislikes, c.commentCreationdate, 
                u.userId, u.userName, 
                v.videoId, v.videoAmountComments 
                FROM HomeBundle:Comment c 
                JOIN HomeBundle:User u 
                WITH u.userId = c.user 
                JOIN HomeBundle:Video v 
                WITH v.videoId = c.video 
                WHERE v.videoId = '$videoId'");
            
            $comment = $query->getResult();

            $amountComments = $comment[0]['videoAmountComments'];
            
//            $amountComments = 0;
//            while (isset($comment[$amountComments]['commentId'])) {
//                $amountComments++;
//            }
            
            $maxValue = $amountComments - 2;
            
            $numAle = rand(0, $maxValue);
            
            if ($comment) {
                $commentId_Value = $comment[$numAle]['commentId'];
                $commentContent_Value = $comment[$numAle]['commentContent'];
                $commentLikes_Value = $comment[$numAle]['commentLikes'];
                $commentDislikes_Value = $comment[$numAle]['commentDislikes'];
                $commentCreationdate_Value = $comment[$numAle]['commentCreationdate'];
                $userId_Value = $comment[$numAle]['userId'];
                $userName_Value = $comment[$numAle]['userName'];
                $videoId_Value = $comment[$numAle]['videoId'];
                
                $users2[0] = array(
                    'commentId' => $commentId_Value,
                    'commentContent' => $commentContent_Value,
                    'commentLikes' => $commentLikes_Value,
                    'commentDislikes' => $commentDislikes_Value,
                    'commentCreationdate' => $commentCreationdate_Value,
                    'userId' => $userId_Value,
                    'userName' => $userName_Value,
                    'videoId' => $videoId_Value,
                    'amountComments' => $amountComments
                );                
                
            } else {
                $users2[0] = array(
                    'commentId' => "_",
                    'commentContent' => "_",
                    'commentLikes' => "_",
                    'commentDislikes' => "_",
                    'commentCreationdate' => "_",
                    'userId' => "_",
                    'userName' => "_",
                    'videoId' => "_",
                    'amountComments' => 0
                );
            }
            
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function addLikeVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

//            $.post(url, {idUser: idUser, idVideo:idVideo, amountLikes:amountLikes}, function (data)

            $idUser = $_POST['idUser'];
            $idVideo = $_POST['idVideo'];
            $amountLikes = $_POST['amountLikes'];

            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($idVideo);

            $video->setVideoLikes($amountLikes);

            $em->persist($video);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function addDislikeVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

//                    $.post(url, {idUser: idUser, idVideo:idVideo, amountDislikes:amountDislikes}, function (data)

            $idUser = $_POST['idUser'];
            $idVideo = $_POST['idVideo'];
            $amountDislikes = $_POST['amountDislikes'];

            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($idVideo);

            $video->setVideoDislikes($amountDislikes);

            $em->persist($video);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function addCommentVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $idUser = $_SESSION['loginSession'];
            $idVideo = $_POST['idVideo'];
            $commentContent = $_POST['commentContent'];

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($idUser);
            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($idVideo);


            $comment = new \HomeBundle\Entity\Comment();
            $comment->setCommentContent($commentContent);
            $comment->setUser($user);
            $comment->setVideo($video);
            $comment->setCommentLikes(22);
            $comment->setCommentDislikes(22);
            $comment->setCommentCreationdate("22-04-1992");

            $em->persist($comment);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    public function increaseCommentsAmountVideoAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            $em = $this->getDoctrine()->getManager();

            $idVideo = $_POST['idVideo'];

            $video = $em->getRepository('HomeBundle:Video')->findOneByVideoId($idVideo);

            $amountComments = $video->getVideoAmountComments();
            
            $newAmountComments = $amountComments + 1;
            
            $video->setVideoAmountComments($newAmountComments);
            $em->persist($video);
            $em->flush();

            $users2 = array();
            $users2[0] = array(
                'variable' => "funciona"
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
    function readLyricsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $idVideo = $_POST['idVideo'];

        if ($request->isXMLHttpRequest()) {

            $lyricsLine = $em->createQuery(
                "SELECT ll.lyricslineId, lw.lyricswordId, lw.lyricswordContent, lw.lyricswordStarttime, lw.lyricswordEndtime, v.videoId 
                FROM HomeBundle:Lyricsline ll 
                JOIN HomeBundle:Video v 
                WITH ll.video = v.videoId 
                JOIN HomeBundle:Lyricsword lw 
                WITH lw.lyricsline = ll.lyricslineId 
                WHERE ll.video = '$idVideo'"
            );
            
//            $lyricsLine = $em->createQuery(
//                "SELECT ll.lyricslineId, ll.lyricslineContent, ll.lyricslineStarttime, ll.lyricslineEndtime, v.videoId 
//                FROM HomeBundle:Lyricsline ll
//                JOIN HomeBundle:Video v
//                WITH ll.video = v.videoId 
//                WHERE ll.video = '$idVideo'"
//            );
            
            $lyrics = $lyricsLine->getResult();
            
            $amountLines = 0;
            while (isset($lyrics[$amountLines]['lyricslineId'])) {
                $amountLines++;
            }
            
            $i = 0;
            while (isset($lyrics[$i]['lyricslineId'])) {

                if ($lyrics) {
                    $lyricslineId_Value = $lyrics[$i]['lyricslineId'];
                    $lyricswordId_Value = $lyrics[$i]['lyricswordId'];
                    $lyricswordContent_Value = $lyrics[$i]['lyricswordContent'];
                    $lyricswordStarttime_Value = $lyrics[$i]['lyricswordStarttime'];
                    $lyricswordEndtime_Value = $lyrics[$i]['lyricswordEndtime'];
                    $videoId_Value = $lyrics[$i]['videoId'];
                    $amountLines_Value = $amountLines;
                } else {
                    $lyricslineId_Value = "_";
                    $lyricswordId_Value = "_";
                    $lyricswordContent_Value = "_";
                    $lyricswordStarttime_Value = "_";
                    $lyricswordEndtime_Value = "_";
                    $videoId_Value = "_";
                    $amountLines_Value = $amountLines;
                }

                $sendData[$i] = array(
                    'lyricslineId' => $lyricslineId_Value,
                    'lyricswordId' => $lyricswordId_Value,
                    'lyricswordContent' => $lyricswordContent_Value,
                    'lyricswordStarttime' => $lyricswordStarttime_Value,
                    'lyricswordEndtime' => $lyricswordEndtime_Value,
                    'videoId' => $videoId_Value,
                    'amountLines' => $amountLines_Value
                );
                $i++;
            }
            
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }        
    }
}

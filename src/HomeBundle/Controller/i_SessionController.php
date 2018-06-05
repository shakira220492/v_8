<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use HomeBundle\Entity\Login;

class i_SessionController extends Controller {

    public function indexAction() {
        return $this->render('@Home/home/form/Session.html.twig');
    }

    public function checkSessionAction(Request $request) {
        if ($request->isXMLHttpRequest()) {

            if (isset($_SESSION['loginSession'])) {
                // en caso de que exista una sesión
                $users2 = array();
                $users2[] = array(
                    'sessionStatus' => "1",
                    'sessionId' => $_SESSION['loginSession']
                );
            } else {
                // en caso de que no exista una sesión
                $users2 = array();
                $users2[] = array(
                    'sessionStatus' => "0",
                    'sessionId' => "logOut"
                );
            }

            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function logInUserAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $user_name = $_POST['user_name'];
        $user_password = $_POST["user_password"];

        $geolocalization33 = $_SERVER["REMOTE_ADDR"];

        if ($request->isXMLHttpRequest()) {

            $user = $em->createQuery(
                "SELECT u.userId, u.userName 
                FROM HomeBundle:User u 
                WHERE u.userName = '$user_name' and u.userPassword = '$user_password'"
            );

            $users = $user->getResult();

            if (!$users) {
//                vacio
                $users2 = array();
                $users2[] = array(
                    'id' => "0",
                    'userName' => "0"
                );
                return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
            } else {
//                lleno    
//                insertar login de sesion 
                $_SESSION['loginSession'] = $users[0]['userId'];

                $userId = $_SESSION['loginSession'];

                $user = $em->getRepository('HomeBundle:User')->findOneByUserId($userId);

                $login = new Login();
                
                $login->setLoginGeolocalization($geolocalization33);
                $login->setLoginHour("123");
                $login->setUser($user);
                
                $em->persist($login);
                $em->flush();

                return new Response(json_encode($users), 200, array('Content-Type' => 'application/json'));
            }
        }
    }

    public function logOutUserAction(Request $request) {
        session_destroy();
//        session_start();
        $geolocalization33 = $_SERVER["REMOTE_ADDR"];
        if ($request->isXMLHttpRequest()) {

            $users2 = array();
            $users2[] = array(
                'id' => $geolocalization33,
                'userName' => $geolocalization33
            );
            return new Response(json_encode($users2), 200, array('Content-Type' => 'application/json'));
        }
    }
    
}

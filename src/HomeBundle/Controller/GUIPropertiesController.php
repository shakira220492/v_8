<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GUIPropertiesController extends Controller {

    public function GUIPropertiesAction() {
        return $this->render('@Home/home/form/GUIProperties.html.twig');
    }

    public function getStoredFieldAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

//        fieldName

        
        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);

        if ($sessionId == "logOut")
        {
            $selectedField = $em->createQuery(
                "SELECT f.fieldId, f.fieldName, f.fieldUsualmode, f.fieldCurrentmode 
                FROM HomeBundle:Field f"
            );
        } else
        {
            $selectedField = $em->createQuery(
                "SELECT f.fieldId, f.fieldName, f.fieldUsualmode, f.fieldCurrentmode, u.userId, l.layoutId 
                FROM HomeBundle:Field f 
                JOIN HomeBundle:User u 
                WITH u.userId = f.user 
                JOIN HomeBundle:Layout l 
                WITH l.layoutId = f.layout 
                WHERE u.userId = '$sessionId' and f.fieldName = '$fieldName'"
            );
        }
            

            $selectedFieldInstance = $selectedField->getResult();

            if ($selectedFieldInstance) {
                $selectedFieldId_Value = $selectedFieldInstance[0]['fieldId'];
                $selectedFieldName_Value = $selectedFieldInstance[0]['fieldName'];
                $selectedFieldUsualmode_Value = $selectedFieldInstance[0]['fieldUsualmode'];
                $selectedFieldCurrentmode_Value = $selectedFieldInstance[0]['fieldCurrentmode'];
            } else {
                $selectedFieldId_Value = "_";
                $selectedFieldName_Value = "_";
                $selectedFieldUsualmode_Value = "_";
                $selectedFieldCurrentmode_Value = "_";
            }

            
        if ($sessionId == "logOut")
        {
            $permanentField = $em->createQuery(
                "SELECT f.fieldId, f.fieldName, f.fieldUsualmode, f.fieldCurrentmode 
                FROM HomeBundle:Field f 
                WHERE f.fieldUsualmode = 'permanent'"
            );
        } else
        {
            $permanentField = $em->createQuery(
                "SELECT f.fieldId, f.fieldName, f.fieldUsualmode, f.fieldCurrentmode, u.userId, l.layoutId 
                FROM HomeBundle:Field f 
                JOIN HomeBundle:User u 
                WITH u.userId = f.user 
                JOIN HomeBundle:Layout l 
                WITH l.layoutId = f.layout 
                WHERE u.userId = '$sessionId' and f.fieldUsualmode = 'permanent'"
            );
        }
        
            $permanentFieldInstance = $permanentField->getResult();

            if ($permanentFieldInstance) {
                $permanentFieldId_Value = $permanentFieldInstance[0]['fieldId'];
                $permanentFieldName_Value = $permanentFieldInstance[0]['fieldName'];
                $permanentFieldUsualmode_Value = $permanentFieldInstance[0]['fieldUsualmode'];
                $permanentFieldCurrentmode_Value = $permanentFieldInstance[0]['fieldCurrentmode'];
            } else {
                $permanentFieldId_Value = "_";
                $permanentFieldName_Value = "_";
                $permanentFieldUsualmode_Value = "_";
                $permanentFieldCurrentmode_Value = "_";
            }
            
            $selectedLayoutId_Value = "";
            $permanentLayoutId_Value = "";

            $sendData[0] = array(
                'selectedFieldId' => $selectedFieldId_Value,
                'selectedFieldName' => $selectedFieldName_Value,
                'selectedFieldUsualmode' => $selectedFieldUsualmode_Value,
                'selectedFieldCurrentmode' => $selectedFieldCurrentmode_Value,
                'selectedLayoutId_Value' => $selectedLayoutId_Value,
                'permanentFieldId' => $permanentFieldId_Value,
                'permanentFieldName' => $permanentFieldName_Value,
                'permanentFieldUsualmode' => $permanentFieldUsualmode_Value,
                'permanentFieldCurrentmode' => $permanentFieldCurrentmode_Value,
                'permanentLayoutId' => $permanentLayoutId_Value
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function getStoredLayoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

//        fieldName

        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);

            $layout = $em->createQuery(
                    "SELECT l.layoutId, l.layoutBackgroundcolor, l.layoutOpacity, l.layoutWidth, l.layoutHeight, u.userId 
                FROM HomeBundle:Layout l 
                JOIN HomeBundle:User u 
                WITH u.userId = l.user 
                JOIN HomeBundle:Field f 
                WITH l.layoutId = f.layout 
                WHERE u.userId = '$sessionId' and f.fieldName = '$fieldName'"
            );


            $layouts = $layout->getResult();

            if ($layouts) {
                $layoutId_Value = $layouts[0]['layoutId'];
                $layoutBackgroundcolor_Value = $layouts[0]['layoutBackgroundcolor'];
                $layoutOpacity_Value = $layouts[0]['layoutOpacity'];
                $layoutWidth_Value = $layouts[0]['layoutWidth'];
                $layoutHeight_Value = $layouts[0]['layoutHeight'];
            } else {
                $layoutId_Value = "_";
                $layoutBackgroundcolor_Value = "_";
                $layoutOpacity_Value = "_";
                $layoutWidth_Value = "_";
                $layoutHeight_Value = "_";
            }

            $sendData[0] = array(
                'layoutId' => $layoutId_Value,
                'layoutBackgroundcolor' => $layoutBackgroundcolor_Value,
                'layoutOpacity' => $layoutOpacity_Value,
                'layoutWidth' => $layoutWidth_Value,
                'layoutHeight' => $layoutHeight_Value,
                'fieldName' => $fieldName,
                'userId' => $sessionId
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function setThisFieldAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);
            
            $layout = $em->getRepository('HomeBundle:Layout')->findOneByLayoutId(22);
            if (!$layout) {
//                SET LAYOUT
                $layout = new \HomeBundle\Entity\Layout();
                $layout->setLayoutBackgroundcolor("123");
                $layout->setLayoutHeight("123");
                $layout->setLayoutOpacity("123");
                $layout->setLayoutWidth("123");
                $layout->setUser($user);

                $em->persist($layout);
                $em->flush();
            }

            $fieldFound = $em->getRepository('HomeBundle:Field')->findOneByFieldName($fieldName);
            if ($fieldFound) {
//                $fieldFound->setFieldUsualmode("permanent");
//                $fieldFound->setFieldCurrentmode("selected");
//                $em->flush();
            } else {
                $field = new \HomeBundle\Entity\Field();
                $field->setFieldIcon($fieldName);
                $field->setFieldName($fieldName);
                $field->setFieldUsualmode("permanent");
                $field->setFieldCurrentmode("selected");
                $field->setFieldEmergentwindow("12345");
                $field->setFieldContentwindow("22222");
                $field->setLayout($layout);
                $field->setUser($user);

                $em->persist($field);
                $em->flush();
            }

            $sendData[0] = array(
                'fieldId' => "22",
                'fieldName' => "22",
                'fieldUsualmode' => "22",
                'fieldCurrentmode' => "22",
                'userId' => "22"
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function setThisLayoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

//        fieldName

        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);

//                SET LAYOUT
            $layout = new \HomeBundle\Entity\Layout();
            $layout->setLayoutBackgroundcolor("246");
            $layout->setLayoutHeight("246");
            $layout->setLayoutOpacity("246");
            $layout->setLayoutWidth("246");
            $layout->setUser($user);

            $em->persist($layout);
            $em->flush();


            $sendData[0] = array(
//                'fieldId' => $fieldId_Value,
//                'fieldName' => $fieldName_Value
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function deleteStoredFieldAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

//        fieldName

        if ($request->isXMLHttpRequest()) {

            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($sessionId);

            $layout = $em->getRepository('HomeBundle:Layout')->findOneByLayoutId(22);
            if (!$layout) {
//                SET LAYOUT
                $layout = new \HomeBundle\Entity\Layout();
                $layout->setLayoutBackgroundcolor("123");
                $layout->setLayoutHeight("123");
                $layout->setLayoutOpacity("123");
                $layout->setLayoutWidth("123");
                $layout->setUser($user);

                $em->persist($layout);
                $em->flush();
            }

            $fieldFound = $em->getRepository('HomeBundle:Field')->findOneByFieldName($fieldName);
            if ($fieldFound) {
                $fieldFound->setFieldUsualmode("permanent");
                $fieldFound->setFieldCurrentmode("selected");
                $em->flush();
            } else {
                $field = new \HomeBundle\Entity\Field();
                $field->setFieldIcon($fieldName);
                $field->setFieldName($fieldName);
                $field->setFieldUsualmode("permanent");
                $field->setFieldCurrentmode("selected");
                $field->setLayout($layout);
                $field->setUser($user);

                $em->persist($field);
                $em->flush();
            }

            $sendData[0] = array(
//                'fieldId' => $fieldId_Value,
//                'fieldName' => $fieldName_Value
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function deleteStoredLayoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];


//        fieldName

        if ($request->isXMLHttpRequest()) {


            $sendData[0] = array(
//                'fieldId' => $fieldId_Value,
//                'fieldName' => $fieldName_Value,
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $subFieldName = $_POST['subFieldName'];
        $subFieldValue = $_POST['subFieldValue'];

        if ($request->isXMLHttpRequest()) {

            $subFieldsAmount = 0;
            while (isset($subFieldName[$subFieldsAmount]) and isset($subFieldValue[$subFieldsAmount])) {
                $subFieldsAmount++;
            }

            $subFields = 0;
            while (isset($subFieldName[$subFields]) and isset($subFieldValue[$subFields])) {

                $valor1 = $subFieldName[$subFields];
                $valor2 = $subFieldValue[$subFields];

                $sendData[$subFields] = array(
                    'valor_1' => $valor1,
                    'valor_2' => $valor2,
                    'subFieldsAmount' => $subFieldsAmount
                );

                $subFields++;
            }



            $idUser = $subFieldValue[1];
            $idLayout = $subFieldValue[2];
            $user = $em->getRepository('HomeBundle:User')->findOneByUserId($idUser);
            $layout = $em->getRepository('HomeBundle:Layout')->findOneByLayoutId($idLayout);

            $field = new \HomeBundle\Entity\Field();
            $field->setUser($user);
            $field->setLayout($layout);
            $field->setFieldName($subFieldValue[3]);
            $field->setFieldIcon($subFieldValue[5]);
            $field->setFieldUsualmode("temporal");
            $field->setFieldCurrentmode("unselected");

            $em->persist($field);
            $em->flush();

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function setUsualModeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

        if ($request->isXMLHttpRequest()) {

            $field = $em->createQuery(
                    "SELECT f.fieldId, f.fieldName, f.fieldUsualmode, f.fieldCurrentmode, u.userId 
                FROM HomeBundle:Field f 
                JOIN HomeBundle:User u 
                WITH u.userId = f.user  
                WHERE u.userId = '$sessionId'"
            );

            $fields = $field->getResult();

            $amountFields = 0;

            $fieldFound211 = $em->getRepository('HomeBundle:Field')->findOneByFieldName("artistIconContent");
            $fieldFound211->setFieldUsualmode("zzz");
            $em->flush();

            while (isset($fields[$amountFields]['fieldName'])) {

                $respectlyFieldName = $fields[$amountFields]['fieldName'];

                if ($respectlyFieldName === $fieldName) {

                    $respectlyFieldUsualmode = $fields[$amountFields]['fieldUsualmode'];

                    if ($respectlyFieldUsualmode === 'permanent') {
                        $fieldFound1 = $em->getRepository('HomeBundle:Field')->findOneByFieldName($respectlyFieldName);
                        $fieldFound1->setFieldUsualmode("temporal");
                        $em->flush();
                    }
                    if ($respectlyFieldUsualmode === 'temporal') {
                        $fieldFound3 = $em->getRepository('HomeBundle:Field')->findOneByFieldName($respectlyFieldName);
                        $fieldFound3->setFieldUsualmode("permanent");
                        $em->flush();
                    }
                } else {
                    $fieldFound2 = $em->getRepository('HomeBundle:Field')->findOneByFieldName($respectlyFieldName);
                    $fieldFound2->setFieldUsualmode("temporal");
                    $em->flush();
                }
                $amountFields++;
            }

            if ($fields) {
                $fieldId_Value = $fields[0]['fieldId'];
                $fieldName_Value = $fields[0]['fieldName'];
                $fieldUsualmode_Value = $fields[0]['fieldUsualmode'];
                $fieldCurrentmode_Value = $fields[0]['fieldCurrentmode'];
                $userId_Value = $fields[0]['userId'];
            } else {
                $fieldId_Value = "_";
                $fieldName_Value = "_";
                $fieldUsualmode_Value = "_";
                $fieldCurrentmode_Value = "_";
                $userId_Value = "_";
            }

            $sendData[0] = array(
                'fieldId' => $fieldId_Value,
                'fieldName' => $fieldName_Value,
                'fieldUsualmode' => $fieldUsualmode_Value,
                'fieldCurrentmode' => $fieldCurrentmode_Value,
                'userId' => $userId_Value
            );
            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }

    public function setCurrentModeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
//
        $sessionId = $_POST['sessionId'];
        $fieldName = $_POST['fieldName'];

        if ($request->isXMLHttpRequest()) {

            $field = $em->createQuery(
                    "SELECT f.fieldId, f.fieldName, f.fieldUsualmode, f.fieldCurrentmode, u.userId 
                FROM HomeBundle:Field f 
                JOIN HomeBundle:User u 
                WITH u.userId = f.user  
                WHERE u.userId = '$sessionId'"
            );

            $fields = $field->getResult();

            $amountFields = 0;
            while (isset($fields[$amountFields]['fieldName'])) {

                $respectlyFieldName = $fields[$amountFields]['fieldName'];

                if ($respectlyFieldName === $fieldName) {
                    $fieldFound1 = $em->getRepository('HomeBundle:Field')->findOneByFieldName($respectlyFieldName);
                    $fieldFound1->setFieldCurrentmode("selected");
                    $em->flush();
                } else {
                    $fieldFound2 = $em->getRepository('HomeBundle:Field')->findOneByFieldName($respectlyFieldName);
                    $fieldFound2->setFieldCurrentmode("unselected");
                    $em->flush();
                }

                $amountFields++;
            }

            $sendData[0] = array(
                'fieldId' => "22",
                'fieldName' => "22",
                'fieldUsualmode' => "22",
                'fieldCurrentmode' => "22",
                'userId' => "22"
            );

            return new Response(json_encode($sendData), 200, array('Content-Type' => 'application/json'));
        }
    }
}
<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HomeBundle\Entity\Task;

class HomeController extends Controller
{
    public function homeAction()
    {
        $taskEntity = new Task;
        
        
        $get_task_properties_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_task_properties_form');
        
        
//        i_SessionController.php
        
        $check_session_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'check_session_form');
        
        $log_in_user_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'log_in_user_form');
        
        $log_out_user_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'log_out_user_form');
        
        
//        GUIPropertiesController.php
        
        $get_stored_field_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_stored_field_form');
        $get_stored_layout_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_stored_layout_form');
        
        
        $set_this_field_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_this_field_form');
        $set_this_layout_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_this_layout_form');
        
        
        $delete_stored_field_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_stored_field_form');
        $delete_stored_layout_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_stored_layout_form');
        
        
        $update_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'update_form');
        $set_usualMode_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_usualMode_form');
        $set_currentMode_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_currentMode_form');
        
        

        $get_info_about_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_info_about_video_form');
        $get_comment_about_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_comment_about_video_form');
        $add_like_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'add_like_video_form');
        $add_dislike_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'add_dislike_video_form');
        $add_comment_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'add_comment_video_form');
        
        
        $show_previous_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'show_previous_video_form');
        $show_next_video_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'show_next_video_form');
        
        
        $set_cacheList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_cacheList_form');
        $get_cacheList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_cacheList_form');
        $set_cacheListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_cacheListVideo_form');
        $get_cacheListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_cacheListVideo_form');
        
        $set_dataminingList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_dataminingList_form');
        $get_dataminingList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_dataminingList_form');
        $set_dataminingListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_dataminingListVideo_form');
        $get_dataminingListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_dataminingListVideo_form');
                
        $set_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_specificList_form');
        $get_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_specificList_form');
        $set_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'set_specificListVideo_form');
        $get_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'get_specificListVideo_form');
        
        $delete_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_specificList_form');
        $delete_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'delete_specificListVideo_form');
        $edit_specificListVideo_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'edit_specificListVideo_form');
        $edit_specificList_form_ajax = $this->createCustomForm(
        'HomeBundle\Form\TaskType', $taskEntity, 'POST', 'edit_specificList_form');
        
        return $this->render('@Home/home/home.html.twig', array(
            'get_task_properties_form_ajax' => $get_task_properties_form_ajax->createView(),
            'check_session_form_ajax' => $check_session_form_ajax->createView(),
            
            'log_in_user_form_ajax' => $log_in_user_form_ajax->createView(),
            'log_out_user_form_ajax' => $log_out_user_form_ajax->createView(),
            
            'get_stored_field_form_ajax' => $get_stored_field_form_ajax->createView(),
            'get_stored_layout_form_ajax' => $get_stored_layout_form_ajax->createView(),
            
            'set_this_field_form_ajax' => $set_this_field_form_ajax->createView(),
            'set_this_layout_form_ajax' => $set_this_layout_form_ajax->createView(),
            
            'delete_stored_field_form_ajax' => $delete_stored_field_form_ajax->createView(),
            'delete_stored_layout_form_ajax' => $delete_stored_layout_form_ajax->createView(),
            'update_form_ajax' => $update_form_ajax->createView(),
            'set_usualMode_form_ajax' => $set_usualMode_form_ajax->createView(),
            'set_currentMode_form_ajax' => $set_currentMode_form_ajax->createView(),
            
            'get_info_about_video_form_ajax' => $get_info_about_video_form_ajax->createView(),
            'get_comment_about_video_form_ajax' => $get_comment_about_video_form_ajax->createView(),
            'add_like_video_form_ajax' => $add_like_video_form_ajax->createView(),
            'add_dislike_video_form_ajax' => $add_dislike_video_form_ajax->createView(),
            'add_comment_video_form_ajax' => $add_comment_video_form_ajax->createView(),
            
            'show_previous_video_form_ajax' => $show_previous_video_form_ajax->createView(),
            'show_next_video_form_ajax' => $show_next_video_form_ajax->createView(),
            
            'set_cacheList_form_ajax' => $set_cacheList_form_ajax->createView(),
            'get_cacheList_form_ajax' => $get_cacheList_form_ajax->createView(),
            'set_cacheListVideo_form_ajax' => $set_cacheListVideo_form_ajax->createView(),
            'get_cacheListVideo_form_ajax' => $get_cacheListVideo_form_ajax->createView(),
            'set_dataminingList_form_ajax' => $set_dataminingList_form_ajax->createView(),
            'get_dataminingList_form_ajax' => $get_dataminingList_form_ajax->createView(),
            'set_dataminingListVideo_form_ajax' => $set_dataminingListVideo_form_ajax->createView(),
            'get_dataminingListVideo_form_ajax' => $get_dataminingListVideo_form_ajax->createView(),
            'set_specificList_form_ajax' => $set_specificList_form_ajax->createView(),
            'get_specificList_form_ajax' => $get_specificList_form_ajax->createView(),
            'set_specificListVideo_form_ajax' => $set_specificListVideo_form_ajax->createView(),
            'get_specificListVideo_form_ajax' => $get_specificListVideo_form_ajax->createView(),
            'delete_specificList_form_ajax' => $delete_specificList_form_ajax->createView(),
            'delete_specificListVideo_form_ajax' => $delete_specificListVideo_form_ajax->createView(),
            'edit_specificListVideo_form_ajax' => $edit_specificListVideo_form_ajax->createView(),
            'edit_specificList_form_ajax' => $edit_specificList_form_ajax->createView()
        ));
         
    }
    
    private function createCustomForm($objForm, $objEntity, $method, $route) {
        $form = $this->createForm($objForm, $objEntity, array(
            'action' => $this->generateUrl($route),
            'method' => $method
        ));
        return $form;
    }
    
}
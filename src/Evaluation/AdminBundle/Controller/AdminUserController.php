<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminUserController extends Controller
{
	
	
    public function readAction(){
		 
		 
    	//第二部分:查询数据形成列表
    	$defaultEntityManager = $this->getDoctrine()->getManager ('default');
    	$adminUserRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:AdminUser');
    	$adminUser = $adminUserRepository->findAll();
    	
		 
		 
		return $this->render('EvaluationAdminBundle:AdminUser:Read.html.twig',array('adminUser'=>$adminUser));
	}
	
	
	public function createAction(){
	
		
		
		
		
	
	
		return $this->render('EvaluationAdminBundle:AdminUser:Create.html.twig');
	}
	
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
	
	
		return new JsonResponse();
	}
	
	
    
    
   
    
    
    
    
    
    
    
    
}

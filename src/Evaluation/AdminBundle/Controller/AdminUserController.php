<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    
    
   
    
    
    
    
    
    
    
    
}

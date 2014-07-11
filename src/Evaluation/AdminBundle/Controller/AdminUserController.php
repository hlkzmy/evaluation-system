<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUserController extends Controller
{
	
    public function __construct(){
    	
    	//得到uri的相关信息是为了知道用户访问了哪些资源
    	$request = $this->getRequest();
    	$requestUri = $request->getRequestUri();
    	
    	//得到session目的是为了得到用户
    	$session = $request->getSession();
    	
    	//得到数据库是为了根据用户 和 资源，去到数据库中查询相关权限
    	$doctrine = $this->getDoctrine();
    	
    	
    	//但是很遗憾，这种思路在symfony完全实现不了，这些对象在构造函数中都取不到
    	
    }
	
	
	
	
	
	
	
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
